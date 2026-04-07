<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\GiaoDich;
use App\Models\PhanTichAi;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $lifestyleKeywords = ['ăn', 'uống', 'giải trí', 'mua sắm', 'du lịch', 'làm đẹp', 'phim', 'quà', 'chơi', 'tiêu vặt', 'nhậu', 'cafe', 'thời trang'];
        $fixedKeywords = ['nhà', 'điện', 'nước', 'internet', 'xăng', 'học phí', 'bảo hiểm', 'nợ', 'thoại', 'cáp', 'rác', 'phí'];
        $savingsKeywords = ['tiết kiệm', 'đầu tư', 'vàng', 'chứng khoán', 'heo', 'gửi', 'tích lũy'];

        $lifestyleTotal = 0;
        $fixedTotal = 0;
        $savingsTotal = 0;
        $otherTotal = 0;

        foreach ($expenses as $ex) {
            $catName = mb_strtolower($ex->danhMuc->ten_danh_muc ?? '');
            
            $matched = false;
            foreach ($lifestyleKeywords as $key) {
                if (Str::contains($catName, $key)) {
                    $lifestyleTotal += $ex->so_tien;
                    $matched = true;
                    break;
                }
            }
            if ($matched) continue;

            foreach ($fixedKeywords as $key) {
                if (Str::contains($catName, $key)) {
                    $fixedTotal += $ex->so_tien;
                    $matched = true;
                    break;
                }
            }
            if ($matched) continue;

            foreach ($savingsKeywords as $key) {
                if (Str::contains($catName, $key)) {
                    $savingsTotal += $ex->so_tien;
                    $matched = true;
                    break;
                }
            }
            if ($matched) continue;

            $otherTotal += $ex->so_tien;
        }

        $totalSpent = $lifestyleTotal + $fixedTotal + $savingsTotal + $otherTotal ?: 1;
        $percentages = [
            'lifestyle' => round(($lifestyleTotal / $totalSpent) * 100),
            'fixed' => round(($fixedTotal / $totalSpent) * 100),
            'savings' => round(($savingsTotal / $totalSpent) * 100),
            'other' => round(($otherTotal / $totalSpent) * 100),
        ];

        // 2. Anomaly Detection (Simplified)
        // 2. Anomaly Detection (Enhanced)
        $anomalies = [];
        $totalIncome = \App\Models\KhoanThu::where('nguoi_dung_id', $user->id)
            ->whereBetween('ngay_nhan', [$monthStart, $monthEnd])
            ->sum('so_tien');
            
        $avgIncome = $totalIncome ?: 5000000; // default 5M if no income recorded

        foreach ($expenses as $ex) {
            // Case 1: Large transaction (> 20% of monthly income)
            if ($ex->so_tien > ($avgIncome * 0.2)) {
                $anomalies[] = [
                    'title' => $ex->danhMuc->ten_danh_muc ?? 'Chi tiêu đột xuất',
                    'reason' => 'SỐ TIỀN RẤT LỚN',
                    'detail' => 'Giao dịch này chiếm hơn 20% ngân sách tháng của bạn.',
                    'amount' => $ex->so_tien,
                    'date' => $ex->ngay_giao_dich,
                    'icon' => 'warning'
                ];
            }
            // Case 2: Potential duplicates (same amount, same category, same day)
            $duplicates = $expenses->where('danh_muc_id', $ex->danh_muc_id)
                ->where('so_tien', $ex->so_tien)
                ->where('ngay_giao_dich', $ex->ngay_giao_dich)
                ->count();
            if ($duplicates > 1) {
                // Check if already in anomalies to avoid double warning
                $exists = collect($anomalies)->where('amount', $ex->so_tien)->where('date', $ex->ngay_giao_dich)->where('reason', 'TRÙNG LẶP')->first();
                if (!$exists) {
                    $anomalies[] = [
                        'title' => $ex->danhMuc->ten_danh_muc,
                        'reason' => 'TRÙNG LẶP',
                        'detail' => 'Phát hiện nhiều giao dịch giống hệt nhau trong cùng một ngày.',
                        'amount' => $ex->so_tien,
                        'date' => $ex->ngay_giao_dich,
                        'icon' => 'content_copy'
                    ];
                }
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

            $systemPrompt = "Bạn là trợ lý tài chính. Phân tích câu nói của người dùng và trả về JSON chuẩn: {\"so_tien\": number, \"ten_danh_muc\": string, \"ghi_chu\": string, \"loai\": \"chi\"}. 
            Lưu ý: CHỈ được phép xử lý các khoản chi tiêu (loai: chi). Nếu nội dung là khoản thu, vẫn phải trả về loai: chi nhưng ghi chú là nội dung gốc.
            Danh sách danh mục hiện có: [{$catList}].
            Ví dụ: 'Ăn sáng 30k' -> {\"so_tien\": 30000, \"ten_danh_muc\": \"Ăn uống\", \"ghi_chu\": \"Ăn sáng\", \"loai\": \"chi\"}.
            CHỈ trả về JSON, không có markdown hay text khác.";

            $rawJson = $this->callOpenRouter($systemPrompt, $input, 0.1, 256);
            
            if ($rawJson) {
                Log::info('OpenRouter QuickInput Raw Response: ' . $rawJson);

                $cleanJson = preg_replace('/^```json\s*|\s*```$/m', '', trim($rawJson));
                $parsed = json_decode($cleanJson, true);

                if ($parsed && isset($parsed['so_tien'])) {
                    $targetCategoryName = trim($parsed['ten_danh_muc']);
                    $loai = 'chi'; // Cưỡng ép chỉ là khoản chi theo yêu cầu user

                    $cat = \App\Models\DanhMuc::where('nguoi_dung_id', $user->id)
                        ->where('loai', 'chi')
                        ->where('ten_danh_muc', 'like', $targetCategoryName)
                        ->first();

                    if (!$cat) {
                        $cat = \App\Models\DanhMuc::create([
                            'nguoi_dung_id' => $user->id, 
                            'ten_danh_muc' => $targetCategoryName, 
                            'loai' => 'chi',
                            'bieu_tuong' => 'payments'
                        ]);
                    }

                    \App\Models\GiaoDich::create([
                        'nguoi_dung_id' => $user->id,
                        'danh_muc_id' => $cat->id,
                        'so_tien' => $parsed['so_tien'],
                        'ngay_giao_dich' => now(),
                        'ghi_chu' => $parsed['ghi_chu'] ?? 'Nhập liệu AI: ' . $input,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => "Đã ghi nhận chi phí: " . number_format($parsed['so_tien']) . "đ vào mục " . $cat->ten_danh_muc,
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
            $monthlySavingsGoals = \App\Models\MucTieuTietKiem::where('nguoi_dung_id', $user->id)->get();
            $savingsContext = $monthlySavingsGoals->map(fn($g) => "- {$g->ten_muc_tieu}: Đã có " . number_format($g->so_tien_hien_tai, 0, ',', '.') . " / " . number_format($g->so_tien_muc_tieu, 0, ',', '.') . " VNĐ")->implode("\n");

            $contextInfo = "Dữ liệu tài chính tháng " . Carbon::now()->format('m/Y') . " của người dùng:\n"
                . "- Tổng thu nhập: " . number_format($monthlyIncome, 0, ',', '.') . " VNĐ\n"
                . "- Tổng chi tiêu: " . number_format($totalExpense, 0, ',', '.') . " VNĐ\n"
                . "- Số dư ròng (Thu nhập - Chi tiêu): " . number_format($monthlyIncome - $totalExpense, 0, ',', '.') . " VNĐ\n";
            
            if ($expenseBreakdown) {
                $contextInfo .= "\nChi tiết chi tiêu theo danh mục:\n" . $expenseBreakdown;
            }

            if ($savingsContext) {
                $contextInfo .= "\n\nCác mục tiêu tiết kiệm đang thực hiện:\n" . $savingsContext;
            }

            $systemInstruction = "Bạn là Curator AI — một chuyên gia tài chính cá nhân thông minh, thân thiện và chuyên nghiệp. "
                . "Bạn có trách nhiệm giúp người dùng quản lý tài chính cá nhân hiệu quả. "
                . "Dưới đây là dữ liệu tài chính hiện tại của người dùng:\n\n"
                . $contextInfo . "\n\n"
                . "Hãy trả lời câu hỏi của người dùng dựa trên dữ liệu này. "
                . "Sử dụng ngôn ngữ tiếng Việt, ngắn gọn, rõ ràng. "
                . "Trình bày bằng markdown khi cần. "
                . "Hãy là một 'Financial Coach' thực thụ: Đưa ra nhận xét khách quan, khen ngợi nếu họ tiết kiệm tốt, và nhắc nhở nếu chi tiêu vượt quá thu nhập. "
                . "Sử dụng ngôn ngữ tiếng Việt, ngắn gọn, rõ ràng. "
                . "Trình bày bằng markdown (bullet points, bold text) để dễ đọc. "
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
    public function analyzeReceipt(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập'], 401);
            }

            $request->validate([
                'receipt_image' => 'required|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            ]);

            $file = $request->file('receipt_image');
            $imageData = base64_encode(file_get_contents($file->path()));
            $mimeType = $file->getMimeType();

            $apiKey = env('GEMINI_API_KEY');
            if (empty($apiKey)) {
                return response()->json(['success' => false, 'message' => 'Chưa cấu hình GEMINI_API_KEY'], 500);
            }

            // Get user's categories
            $categories = \App\Models\DanhMuc::where('nguoi_dung_id', $user->id)->get(['id', 'ten_danh_muc', 'loai']);
            $catList = $categories->map(fn($c) => "{$c->ten_danh_muc} ({$c->loai})")->implode(', ');

            $systemPrompt = "Bạn là trợ lý tài chính. Phân tích ảnh hóa đơn/biên lai và trả về JSON chuẩn: {\"so_tien\": number, \"ten_danh_muc\": string, \"ghi_chu\": string, \"loai\": \"chi\"|\"thu\"}.
            Danh sách danh mục hiện có: [{$catList}].
            Nếu hóa đơn là thanh toán mua hàng, thì loại thường là 'chi'. Ghi chú nên ngắn gọn mô tả giao dịch.
            CHỈ trả về JSON, không có markdown hay text khác.";

            $payload = [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $systemPrompt],
                            [
                                "inline_data" => [
                                    "mime_type" => $mimeType,
                                    "data" => $imageData
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", $payload);

            if ($response->successful()) {
                $data = $response->json();
                $rawJson = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($rawJson) {
                    Log::info('Gemini Receipt Input Response: ' . $rawJson);

                    // Clean markdown
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
                                'bieu_tuong' => 'receipt'
                            ]);
                        }

                        if ($loai === 'thu') {
                            \App\Models\KhoanThu::create([
                                'nguoi_dung_id' => $user->id,
                                'danh_muc_id' => $cat->id,
                                'so_tien' => $parsed['so_tien'],
                                'ngay_nhan' => Carbon::now(),
                                'nguon_thu' => $parsed['ghi_chu'] ?? 'Nhập qua hình ảnh',
                            ]);
                        } else {
                            \App\Models\GiaoDich::create([
                                'nguoi_dung_id' => $user->id,
                                'danh_muc_id' => $cat->id,
                                'so_tien' => $parsed['so_tien'],
                                'ngay_giao_dich' => Carbon::now(),
                                'ghi_chu' => $parsed['ghi_chu'] ?? 'Nhập qua hình ảnh',
                            ]);
                        }

                        return response()->json([
                            'success' => true,
                            'message' => "Đã ghi nhận: " . number_format($parsed['so_tien']) . "đ vào mục " . $cat->ten_danh_muc,
                            'data' => $parsed
                        ]);
                    }
                }
            }

            Log::error('Gemini Receipt API Error: ' . $response->body());
            return response()->json(['success' => false, 'message' => 'Lỗi xử lý hình ảnh hoặc AI không hiểu. Vui lòng thử lại.'], 500);
            
        } catch (\Exception $e) {
            Log::error('analyzeReceipt Exception: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }
}
