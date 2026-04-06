<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GiaoDichDinhKy;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xử lý các giao dịch định kỳ đã đến hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Đang bắt đầu xử lý giao dịch định kỳ...');
        
        $now = Carbon::now();
        $recurrings = GiaoDichDinhKy::where('trang_thai', 'hoat_dong')
            ->where('ngay_bat_dau', '<=', $now->toDateString())
            ->where(function ($query) use ($now) {
                $query->whereNull('ngay_ket_thuc')
                      ->orWhere('ngay_ket_thuc', '>=', $now->toDateString());
            })
            ->get();

        $processedCount = 0;

        foreach ($recurrings as $item) {
            if ($this->isDue($item, $now)) {
                $this->createTransaction($item, $now);
                $item->update(['lan_thuc_hien_cuoi' => $now->toDateString()]);
                $processedCount++;
            }
        }

        $this->info("Đã xử lý xong $processedCount giao dịch.");
    }

    private function isDue($item, $now)
    {
        if (!$item->lan_thuc_hien_cuoi) {
            // Check if start date is today or in the past
            return Carbon::parse($item->ngay_bat_dau)->isPast() || Carbon::parse($item->ngay_bat_dau)->isToday();
        }

        $lastDate = Carbon::parse($item->lan_thuc_hien_cuoi);

        switch ($item->chu_ky) {
            case 'hang_ngay':
                return $now->diffInDays($lastDate) >= 1;
            case 'hang_tuan':
                return $now->diffInWeeks($lastDate) >= 1;
            case 'hang_thang':
                return $now->diffInMonths($lastDate) >= 1;
            case 'hang_nam':
                return $now->diffInYears($lastDate) >= 1;
            default:
                return false;
        }
    }

    private function createTransaction($item, $now)
    {
        if ($item->loai_giao_dich === 'chi') {
            GiaoDich::create([
                'nguoi_dung_id' => $item->nguoi_dung_id,
                'danh_muc_id' => $item->danh_muc_id,
                'so_tien' => $item->so_tien,
                'ghi_chu' => 'Giao dịch định kỳ tự động: ' . $item->danhMuc->ten_danh_muc,
                'ngay_giao_dich' => $now->toDateString(),
                'ai_tu_phan_loai' => false,
            ]);
        } else {
            KhoanThu::create([
                'nguoi_dung_id' => $item->nguoi_dung_id,
                'danh_muc_id' => $item->danh_muc_id,
                'so_tien' => $item->so_tien,
                'nguon_thu' => 'Định kỳ: ' . $item->danhMuc->ten_danh_muc,
                'ngay_nhan' => $now->toDateString(),
                'la_thu_nhap_co_dinh' => true,
                'ghi_chu' => 'Giao dịch định kỳ tự động',
            ]);
        }
    }
}

