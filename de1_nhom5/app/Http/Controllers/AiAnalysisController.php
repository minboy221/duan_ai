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
        // - Large transactions (> 500k)
        // - Duplicates (same amt, same day)
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
        
        // Total Income this month
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

            // Define the period: default last 30 days
            $days = $request->input('days', 30);
            $startDate = Carbon::now()->subDays($days)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            // Fetch transactions for the user within the period, joined with categories to filter just expenses 'chi'
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

            // Calculate total spent
            $totalSpent = $transactions->sum('tong_tien');

            // Format data into percentages for the prompt
            $expenseDetails = [];
            foreach ($transactions as $tx) {
                $percentage = round(($tx->tong_tien / $totalSpent) * 100, 2);
                $expenseDetails[] = "- {$tx->ten_danh_muc}: " . number_format($tx->tong_tien, 0, ',', '.') . " VNĐ ({$percentage}%)";
            }
            $expenseSummaryText = implode("\n", $expenseDetails);

            $apiKey = config('services.gemini.api_key');
            if (empty($apiKey)) {
                return response()->json(['success' => false, 'message' => 'Thiếu cấu hình API Key Gemini.'], 500);
            }

            // Build the Prompt
            $systemInstruction = "Bạn là một chuyên gia tài chính cá nhân nhạy bén và thân thiện. Dựa vào số liệu chi phí, hãy phân tích thói quen tiêu dùng trong {$days} ngày qua và đưa ra nhận xét. Đừng quên đưa ra 1-2 lời khuyên cụ thể để cắt giảm hoặc tối ưu hóa nếu cần. Bạn hãy dùng ngôn từ ngắn gọn, rõ ràng, dễ hiểu và trình bày theo định dạng markdown.";

            $prompt = "Tổng chi tiêu của tôi trong {$days} ngày qua là: " . number_format($totalSpent, 0, ',', '.') . " VNĐ.\n"
                    . "Chi tiết từng khoản (với tỷ lệ % tương ứng) như sau:\n" 
                    . $expenseSummaryText . "\n\n"
                    . "Hãy phân tích thói quen tiêu dùng, đưa ra kết luận và lời khuyên cho tôi.";

            // Request logic to Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'system_instruction' => [
                    'parts' => [
                        ['text' => $systemInstruction]
                    ]
                ],
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ],
                    ]
                ],
                'generationConfig' => [
                    // Adjust if needed
                    'temperature' => 0.7,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Extract response text
                $aiText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                if (!empty($aiText)) {
                    // Save the analysis
                    $analysis = PhanTichAi::create([
                        'nguoi_dung_id' => $user->id,
                        'loai_phan_tich' => 'thoi_quen_tieu_dung',
                        'noi_dung' => $aiText,
                        // ngay_tao is automatically handled if defined correctly, but just in case:
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
            }

            Log::error('Gemini API Error: ' . $response->body());
            return response()->json(['success' => false, 'message' => 'Không thể gọi Gemini API.'], 500);

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
            $apiKey = config('services.gemini.api_key');

            if (empty($input)) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập nội dung.'], 400);
            }

            if (empty($apiKey)) {
                Log::error('Gemini API Key is missing in quickInput');
                return response()->json(['success' => false, 'message' => 'Lỗi: Chưa cấu hình API Key.'], 500);
            }

            // Get user's categories for better mapping
            $categories = \App\Models\DanhMuc::where('nguoi_dung_id', $user->id)->get(['id', 'ten_danh_muc', 'loai']);
            $catList = $categories->map(fn($c) => "{$c->ten_danh_muc} ({$c->loai})")->implode(', ');

            $systemPrompt = "Bạn là trợ lý tài chính. Phân tích câu nói của người dùng và trả về JSON chuẩn: {\"so_tien\": number, \"ten_danh_muc\": string, \"ghi_chu\": string, \"loai\": \"chi\"|\"thu\"}. 
            Danh sách danh mục hiện có: [{$catList}].
            Ví dụ: 'Ăn sáng 30k' -> {\"so_tien\": 30000, \"ten_danh_muc\": \"Ăn uống\", \"ghi_chu\": \"Ăn sáng\", \"loai\": \"chi\"}.";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(15)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => "Instructions: {$systemPrompt}\nUser Input: {$input} "]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.1
                ]
            ]);

            if ($response->successful()) {
                $resData = $response->json();
                $rawJson = $resData['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                Log::info('Gemini QuickInput Raw Response: ' . $rawJson);

                // Clean markdown if AI returns it (gemini-pro often adds ```json)
                $cleanJson = preg_replace('/^```json\s*|\s*```$/m', '', trim($rawJson));
                $parsed = json_decode($cleanJson, true);

                if ($parsed && isset($parsed['so_tien'])) {
                    // Normalize category name for matching
                    $targetCategoryName = trim($parsed['ten_danh_muc']);
                    $loai = isset($parsed['loai']) ? ($parsed['loai'] === 'thu' ? 'thu' : 'chi') : 'chi';

                    // Find actual category ID (case insensitive search)
                    $cat = \App\Models\DanhMuc::where('nguoi_dung_id', $user->id)
                        ->where('ten_danh_muc', 'like', $targetCategoryName)
                        ->first();

                    if (!$cat) {
                        // Create default if not found
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
                    Log::error('Gemini QuickInput Failed to parse JSON: ' . $rawJson);
                }
            } else {
                Log::error('Gemini QuickInput API Error: ' . $response->body());
            }

            return response()->json(['success' => false, 'message' => 'AI đang bận hoặc không hiểu yêu cầu, hãy thử lại bằng câu khác.'], 500);
        } catch (\Exception $e) {
            Log::error('QuickInput Exception: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }
}
