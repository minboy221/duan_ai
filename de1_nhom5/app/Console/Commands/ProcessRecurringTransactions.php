<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GiaoDichDinhKy;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Notifications\RecurringTransactionNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProcessRecurringTransactions extends Command
{
    /**
     * Tên lệnh: php artisan app:process-recurring
     */
    protected $signature = 'app:process-recurring';

    /**
     * Mô tả: Xử lý các giao dịch định kỳ đã đến hạn
     */
    protected $description = 'Tự động tạo giao dịch khi đến hạn, cập nhật ngày tiếp theo, gửi thông báo';

    /**
     * Xử lý chính
     */
    public function handle()
    {
        $this->info('🔄 Đang bắt đầu xử lý giao dịch định kỳ...');
        Log::info('[RecurringTransactions] Bắt đầu xử lý lúc ' . now()->format('Y-m-d H:i:s'));

        $now = Carbon::now();

        // Lấy danh sách: đang hoạt động + đã đến hạn + chưa hết hạn
        $recurrings = GiaoDichDinhKy::active()
            ->due()
            ->notExpired()
            ->with(['nguoiDung', 'danhMuc'])
            ->get();

        if ($recurrings->isEmpty()) {
            $this->info('✅ Không có giao dịch định kỳ nào đến hạn.');
            Log::info('[RecurringTransactions] Không có giao dịch nào đến hạn.');
            return;
        }

        $processedCount = 0;
        $skippedCount = 0;

        foreach ($recurrings as $item) {
            try {
                // === CHỐNG TRÙNG: kiểm tra đã tạo trong ngày chưa ===
                if ($this->isAlreadyProcessedToday($item, $now)) {
                    $skippedCount++;
                    $this->line("  ⏭️ Bỏ qua #{$item->id} (đã xử lý hôm nay)");
                    continue;
                }

                // === TẠO GIAO DỊCH ===
                DB::beginTransaction();

                $transaction = $this->createTransaction($item, $now);

                // === CẬP NHẬT: ngày thực hiện cuối + ngày chạy tiếp theo ===
                $item->update([
                    'lan_thuc_hien_cuoi'  => $now->toDateString(),
                    'ngay_chay_tiep_theo' => $item->tinhNgayTiepTheo(),
                ]);

                DB::commit();

                // === GỬI THÔNG BÁO (database + email) ===
                $user = $item->nguoiDung;
                if ($user) {
                    $user->notify(new RecurringTransactionNotification(
                        $item->so_tien,
                        $item->loai_giao_dich,
                        $item->danhMuc->ten_danh_muc ?? 'Không rõ',
                        $now->format('d/m/Y')
                    ));
                }

                $processedCount++;

                // === LOG ===
                $loaiText = $item->loai_giao_dich === 'thu' ? 'Thu nhập' : 'Chi tiêu';
                $soTienFormatted = number_format($item->so_tien, 0, ',', '.');
                $this->info("  ✅ #{$item->id} | {$loaiText} {$soTienFormatted}₫ | {$item->danhMuc->ten_danh_muc} | Next: {$item->ngay_chay_tiep_theo->format('d/m/Y')}");

                Log::info("[RecurringTransactions] Đã tạo giao dịch #{$item->id}", [
                    'user_id'      => $item->nguoi_dung_id,
                    'loai'         => $item->loai_giao_dich,
                    'so_tien'      => $item->so_tien,
                    'danh_muc'     => $item->danhMuc->ten_danh_muc ?? 'N/A',
                    'ngay_tiep_theo' => $item->ngay_chay_tiep_theo,
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("  ❌ Lỗi xử lý #{$item->id}: {$e->getMessage()}");
                Log::error("[RecurringTransactions] Lỗi #{$item->id}: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("🏁 Hoàn tất: {$processedCount} giao dịch đã tạo, {$skippedCount} bỏ qua.");
        Log::info("[RecurringTransactions] Hoàn tất: {$processedCount} tạo, {$skippedCount} bỏ qua.");
    }

    /**
     * Kiểm tra xem giao dịch đã được xử lý trong ngày hôm nay chưa
     * (Chống tạo trùng nếu command chạy nhiều lần/ngày)
     */
    private function isAlreadyProcessedToday($item, Carbon $now): bool
    {
        if (!$item->lan_thuc_hien_cuoi) {
            return false;
        }

        return Carbon::parse($item->lan_thuc_hien_cuoi)->isSameDay($now);
    }

    /**
     * Tạo giao dịch mới vào bảng tương ứng (giao_dich hoặc khoan_thu)
     */
    private function createTransaction($item, Carbon $now)
    {
        $danhMucTen = $item->danhMuc->ten_danh_muc ?? 'Giao dịch định kỳ';

        if ($item->loai_giao_dich === 'chi') {
            // === CHI TIÊU → bảng giao_dich ===
            return GiaoDich::create([
                'nguoi_dung_id'  => $item->nguoi_dung_id,
                'danh_muc_id'    => $item->danh_muc_id,
                'so_tien'        => $item->so_tien,
                'ghi_chu'        => '🔄 Tự động: ' . $danhMucTen,
                'ngay_giao_dich' => $now->toDateString(),
                'ai_tu_phan_loai' => false,
            ]);
        } else {
            // === THU NHẬP → bảng khoan_thu ===
            return KhoanThu::create([
                'nguoi_dung_id'      => $item->nguoi_dung_id,
                'danh_muc_id'        => $item->danh_muc_id,
                'so_tien'            => $item->so_tien,
                'nguon_thu'          => '🔄 Định kỳ: ' . $danhMucTen,
                'ngay_nhan'          => $now->toDateString(),
                'la_thu_nhap_co_dinh' => true,
                'ghi_chu'            => 'Giao dịch định kỳ tự động',
            ]);
        }
    }
}
