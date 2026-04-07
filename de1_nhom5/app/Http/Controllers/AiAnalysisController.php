<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\GiaoDich;
use App\Models\PhanTichAi;
use Carbon\Carbon;

class AiAnalysisController extends Controller
{
    /**
     * Helper: Call OpenRouter API (OpenAI-compatible)
     */
    private function callOpenRouter(string $systemPrompt, string $userMessage, float $temperature = 0.7, int $maxTokens = 1024): ?string
    {
        $apiKey = config('services.openrouter.api_key');
        $model = config('services.openrouter.model', 'google/gemini-2.0-flash-001');

        if (empty($apiKey)) {
            throw new \Exception('Chưa cấu hình API Key. Vui lòng thêm OPENROUTER_API_KEY vào file .env');
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
            'HTTP-Referer' => config('app.url', 'http://localhost'),
            'X-Title' => 'The Fiscal Curator',
        ])->timeout(30)->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['choices'][0]['message']['content'] ?? null;
        }

        Log::error('OpenRouter API Error: ' . $response->body());
        return null;
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // 1. Calculate Group Percentages (Lifestyle, Fixed, Savings)
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $expenses = GiaoDich::where('nguoi_dung_id', $user->id)
            ->whereBetween('ngay_giao_dich', [$monthStart, $monthEnd])
            ->with('danhMuc')
            ->get();

        $lifestyleKeys = ['Ăn uống', 'Giải trí', 'Mua sắm', 'Du lịch', 'Làm đẹp', 'Thể thao'];
        $fixedKeys = ['Tiền nhà', 'Điện nước', 'Internet', 'Xăng xe', 'Điện thoại', 'Bảo hiểm'];
        $savingsKeys = ['Tiết kiệm', 'Đầu tư', 'Kho an toàn', 'Vàng', 'Chứng khoán'];

        $lifestyleTotal = 0;
        $fixedTotal = 0;
        $savingsTotal = 0;

        foreach ($expenses as $ex) {
            $catName = $ex->danhMuc->ten_danh_muc ?? '';
            if (in_array($catName, $lifestyleKeys)) $lifestyleTotal += $ex->so_tien;
            elseif (in_array($catName, $fixedKeys)) $fixedTotal += $ex->so_tien;
            elseif (in_array($catName, $savingsKeys)) $savingsTotal += $ex->so_tien;
        }

        $totalSpent = $lifestyleTotal + $fixedTotal + $savingsTotal ?: 1; // avoid /0
        $percentages = [
            'lifestyle' => round(($lifestyleTotal / $totalSpent) * 100),
            'fixed' => round(($fixedTotal / $totalSpent) * 100),
            'savings' => round(($savingsTotal / $totalSpent) * 100),
        ];

        // 2. Anomaly Detection (Simplified)
        $anomalies = [];
        foreach ($expenses as $ex) {
            if ($ex->so_tien > 500000) {
                $anomalies[] = [
                    'title' => $ex->danhMuc->ten_danh_muc ?? 'Chi tiêu',
                    'reason' => 'SỐ TIỀN LỚN',
                    'detail' => 'Giao dịch này cao hơn mức trung bình ngày.',
                    'amount' => $ex->so_tien,
                    'date' => $ex->ngay_giao_dich,
                    'icon' => $ex->danhMuc->bieu_tuong ?? 'shopping_bag'
                ];
            }
        }

        // 3. Smart Forecast (Simplified)
        $daysInMonth = Carbon::now()->daysInMonth;
        $elapsedDays = Carbon::now()->day;
        $remainingDays = $daysInMonth - $elapsedDays;
        
        $avgDailyExpense = ($lifestyleTotal + $fixedTotal) / ($elapsedDays ?: 1);
        $forecastRemainingExpense = $avgDailyExpense * $remainingDays;
        
        $totalIncome = \App\Models\KhoanThu::where('nguoi_dung_id', $user->id)
            ->whereBetween('ngay_nhan', [$monthStart, $monthEnd])
            ->sum('so_tien');
            
        $projectedSavings = $totalIncome - ($lifestyleTotal + $fixedTotal + $forecastRemainingExpense);

        // 4. Find latest AI analysis content
        $latestAi = PhanTichAi::where('nguoi_dung_id', $user->id)
            ->orderBy('ngay_tao', 'desc')
            ->first();

        return view('phantichAi', compact('percentages', 'anomalies', 'latestAi', 'projectedSavings'));
    }

    public function analyzeHabits(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập'], 401);
            }

            $days = $request->input('days', 30);
            $startDate = Carbon::now()->subDays($days)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            $transactions = GiaoDich::where('giao_dich.nguoi_dung_id', $user->id)
                ->whereBetween('giao_dich.ngay_giao_dich', [$startDate, $endDate])
                ->join('danh_muc', 'giao_dich.danh_muc_id', '=', 'danh_muc.id')
                ->where('danh_muc.loai', 'chi')
                ->selectRaw('danh_muc.ten_danh_muc, SUM(giao_dich.so_tien) as tong_tien')
                ->groupBy('danh_muc.id', 'danh_muc.ten_danh_muc')
                ->get();

            if ($transactions->isEmpty()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Không có dữ liệu chi tiêu nào trong thời gian này để phân tích.'
                ]);
            }

            $totalSpent = $transactions->sum('tong_tien');

            $expenseDetails = [];
            foreach ($transactions as $tx) {
                $percentage = round(($tx->tong_tien / $totalSpent) * 100, 2);
                $expenseDetails[] = "- {$tx->ten_danh_muc}: " . number_format($tx->tong_tien, 0, ',', '.') . " VNĐ ({$percentage}%)";
            }
            $expenseSummaryText = implode("\n", $expenseDetails);

            $systemInstruction = "Bạn là một chuyên gia tài chính cá nhân nhạy bén và thân thiện. Dựa vào số liệu chi phí, hãy phân tích thói quen tiêu dùng trong {$days} ngày qua và đưa ra nhận xét. Đừng quên đưa ra 1-2 lời khuyên cụ thể để cắt giảm hoặc tối ưu hóa nếu cần. Bạn hãy dùng ngôn từ ngắn gọn, rõ ràng, dễ hiểu và trình bày theo định dạng markdown.";

            $prompt = "Tổng chi tiêu của tôi trong {$days} ngày qua là: " . number_format($totalSpent, 0, ',', '.') . " VNĐ.\n"
                    . "Chi tiết từng khoản (với tỷ lệ % tương ứng) như sau:\n" 
                    . $expenseSummaryText . "\n\n"
                    . "Hãy phân tích thói quen tiêu dùng, đưa ra kết luận và lời khuyên cho tôi.";

            $aiText = $this->callOpenRouter($systemInstruction, $prompt);

            if (!empty($aiText)) {
                PhanTichAi::create([
                    'nguoi_dung_id' => $user->id,
                    'loai_phan_tich' => 'thoi_quen_tieu_dung',
                    'noi_dung' => $aiText,
                    'ngay_tao' => Carbon::now(),
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'analysis' => $aiText,
                        'total_spent' => $totalSpent,
                    ]
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Không thể nhận phản hồi từ AI.'], 500);

        } catch (\Exception $e) {
            Log::error("AiAnalysisController error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }

    public function quickInput(Request $request)
    {
        try {
            $user = Auth::user();
            $input = $request->input('input');

            if (empty($input)) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập nội dung.'], 400);
            }

            // Get user's categories for better mapping
            $categories = \App\Models\DanhMuc::where('nguoi_dung_id', $user->id)->get(['id', 'ten_danh_muc', 'loai']);
            $catList = $categories->map(fn($c) => "{$c->ten_danh_muc} ({$c->loai})")->implode(', ');

            $systemPrompt = "Bạn là trợ lý tài chính. Phân tích câu nói của người dùng và trả về JSON chuẩn: {\"so_tien\": number, \"ten_danh_muc\": string, \"ghi_chu\": string, \"loai\": \"chi\"|\"thu\"}. 
            Danh sách danh mục hiện có: [{$catList}].
            Ví dụ: 'Ăn sáng 30k' -> {\"so_tien\": 30000, \"ten_danh_muc\": \"Ăn uống\", \"ghi_chu\": \"Ăn sáng\", \"loai\": \"chi\"}.
            CHỈ trả về JSON, không có markdown hay text khác.";

            $rawJson = $this->callOpenRouter($systemPrompt, $input, 0.1, 256);
            
            if ($rawJson) {
                Log::info('OpenRouter QuickInput Raw Response: ' . $rawJson);

                // Clean markdown if AI returns it
                $cleanJson = preg_replace('/^```json\s*|\s*```$/m', '', trim($rawJson));
                $parsed = json_decode($cleanJson, true);

                if ($parsed && isset($parsed['so_tien'])) {
                    $targetCategoryName = trim($parsed['ten_danh_muc']);
                    $loai = isset($parsed['loai']) ? ($parsed['loai'] === 'thu' ? 'thu' : 'chi') : 'chi';

                    $cat = \App\Models\DanhMuc::where('nguoi_dung_id', $user->id)
                        ->where('ten_danh_muc', 'like', $targetCategoryName)
                        ->first();

                    if (!$cat) {
                        $cat = \App\Models\DanhMuc::create([
                            'nguoi_dung_id' => $user->id, 
                            'ten_danh_muc' => $targetCategoryName, 
                            'loai' => $loai,
                            'bieu_tuong' => 'category'
                        ]);
                    }

                    if ($loai === 'thu') {
                        \App\Models\KhoanThu::create([
                            'nguoi_dung_id' => $user->id,
                            'danh_muc_id' => $cat->id,
                            'so_tien' => $parsed['so_tien'],
                            'ngay_nhan' => now(),
                            'nguon_thu' => $parsed['ghi_chu'] ?? 'Nhập liệu AI: ' . $input,
                        ]);
                    } else {
                        \App\Models\GiaoDich::create([
                            'nguoi_dung_id' => $user->id,
                            'danh_muc_id' => $cat->id,
                            'so_tien' => $parsed['so_tien'],
                            'ngay_giao_dich' => now(),
                            'ghi_chu' => $parsed['ghi_chu'] ?? 'Nhập liệu AI: ' . $input,
                        ]);
                    }

                    return response()->json([
                        'success' => true,
                        'message' => "Đã ghi nhận: " . number_format($parsed['so_tien']) . "đ vào mục " . $cat->ten_danh_muc,
                        'data' => $parsed
                    ]);
                } else {
                    Log::error('OpenRouter QuickInput Failed to parse JSON: ' . $rawJson);
                }
            }

            return response()->json(['success' => false, 'message' => 'AI đang bận hoặc không hiểu yêu cầu, hãy thử lại bằng câu khác.'], 500);
        } catch (\Exception $e) {
            Log::error('QuickInput Exception: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Custom AI Prompt - users can ask any finance-related question
     */
    public function customPrompt(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập'], 401);
            }

            $prompt = $request->input('prompt');
            if (empty($prompt)) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập câu hỏi.'], 400);
            }

            // Gather user's financial context
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();

            $monthlyExpenses = GiaoDich::where('giao_dich.nguoi_dung_id', $user->id)
                ->whereBetween('giao_dich.ngay_giao_dich', [$monthStart, $monthEnd])
                ->join('danh_muc', 'giao_dich.danh_muc_id', '=', 'danh_muc.id')
                ->selectRaw('danh_muc.ten_danh_muc, SUM(giao_dich.so_tien) as tong_tien')
                ->groupBy('danh_muc.id', 'danh_muc.ten_danh_muc')
                ->get();

            $totalExpense = $monthlyExpenses->sum('tong_tien');

            $monthlyIncome = \App\Models\KhoanThu::where('nguoi_dung_id', $user->id)
                ->whereBetween('ngay_nhan', [$monthStart, $monthEnd])
                ->sum('so_tien');

            // Build context
            $expenseBreakdown = $monthlyExpenses->map(function ($e) use ($totalExpense) {
                $pct = $totalExpense > 0 ? round(($e->tong_tien / $totalExpense) * 100, 1) : 0;
                return "- {$e->ten_danh_muc}: " . number_format($e->tong_tien, 0, ',', '.') . " VNĐ ({$pct}%)";
            })->implode("\n");

            $contextInfo = "Dữ liệu tài chính tháng " . Carbon::now()->format('m/Y') . " của người dùng:\n"
                . "- Tổng thu nhập: " . number_format($monthlyIncome, 0, ',', '.') . " VNĐ\n"
                . "- Tổng chi tiêu: " . number_format($totalExpense, 0, ',', '.') . " VNĐ\n"
                . "- Số dư ròng: " . number_format($monthlyIncome - $totalExpense, 0, ',', '.') . " VNĐ\n";
            
            if ($expenseBreakdown) {
                $contextInfo .= "\nChi tiết chi tiêu theo danh mục:\n" . $expenseBreakdown;
            }

            $systemInstruction = "Bạn là Curator AI — một chuyên gia tài chính cá nhân thông minh, thân thiện và chuyên nghiệp. "
                . "Bạn có trách nhiệm giúp người dùng quản lý tài chính cá nhân hiệu quả. "
                . "Dưới đây là dữ liệu tài chính hiện tại của người dùng:\n\n"
                . $contextInfo . "\n\n"
                . "Hãy trả lời câu hỏi của người dùng dựa trên dữ liệu này. "
                . "Sử dụng ngôn ngữ tiếng Việt, ngắn gọn, rõ ràng. "
                . "Trình bày bằng markdown khi cần. "
                . "Nếu câu hỏi không liên quan đến tài chính, hãy lịch sự từ chối và gợi ý câu hỏi phù hợp.";

            $aiText = $this->callOpenRouter($systemInstruction, $prompt, 0.7, 1024);

            if (!empty($aiText)) {
                PhanTichAi::create([
                    'nguoi_dung_id' => $user->id,
                    'loai_phan_tich' => 'hoi_dap_ai',
                    'noi_dung' => "**Câu hỏi:** {$prompt}\n\n**Trả lời:**\n{$aiText}",
                    'ngay_tao' => Carbon::now(),
                ]);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'answer' => $aiText,
                    ]
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Không thể nhận phản hồi từ AI. Vui lòng thử lại.'], 500);

        } catch (\Exception $e) {
            Log::error("CustomPrompt error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }
}
