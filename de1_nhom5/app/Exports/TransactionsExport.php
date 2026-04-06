<?php

namespace App\Exports;

use App\Models\GiaoDich;
use App\Models\KhoanThu;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $userId = Auth::id();

        // Lấy danh sách chi tiêu
        $expenses = GiaoDich::where('nguoi_dung_id', $userId)
            ->with('danhMuc')
            ->get()
            ->map(function ($item) {
                $item->type = 'Chi tiêu';
                $item->date = $item->ngay_giao_dich;
                $item->title = $item->ghi_chu ?: 'Không có nội dung';
                return $item;
            });

        // Lấy danh sách thu nhập
        $incomes = KhoanThu::where('nguoi_dung_id', $userId)
            ->with('danhMuc')
            ->get()
            ->map(function ($item) {
                $item->type = 'Thu nhập';
                $item->date = $item->ngay_nhan;
                $item->title = $item->nguon_thu ?: ($item->ghi_chu ?: 'Không có nội dung');
                return $item;
            });

        // Hợp nhất và sắp xếp theo ngày
        return $expenses->concat($incomes)->sortByDesc('date');
    }

    /**
     * Map data to Excel columns
     */
    public function map($transaction): array
    {
        return [
            $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') : '',
            $transaction->type,
            $transaction->danhMuc ? $transaction->danhMuc->ten_danh_muc : 'Khác',
            $transaction->title,
            $transaction->so_tien,
        ];
    }

    /**
     * Define Excel headers
     */
    public function headings(): array
    {
        return [
            'Ngày Giao Dịch',
            'Loại Phân Loại',
            'Danh Mục',
            'Nội Dung / Nguồn Thu',
            'Số Tiền (VNĐ)',
        ];
    }
}
