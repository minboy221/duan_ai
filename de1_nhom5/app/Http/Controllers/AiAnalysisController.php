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

            // Fetch transactions for the user within the period, joined with categories to filter just expenses 'chi_tieu'
            $transactions = GiaoDich::where('giao_dich.nguoi_dung_id', $user->id)
                ->whereBetween('giao_dich.ngay_giao_dich', [$startDate, $endDate])
                ->join('danh_muc', 'giao_dich.danh_muc_id', '=', 'danh_muc.id')
                ->where('danh_muc.loai', 'chi_tieu')
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
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
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
}
