<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoDichDinhKy extends Model
{
    use HasFactory;

    protected $table = 'giao_dich_dinh_ky';

    protected $fillable = [
        'nguoi_dung_id',
        'danh_muc_id',
        'loai_giao_dich',
        'so_tien',
        'chu_ky',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'lan_thuc_hien_cuoi',
        'ngay_chay_tiep_theo',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'lan_thuc_hien_cuoi' => 'date',
        'ngay_chay_tiep_theo' => 'date',
        'so_tien' => 'decimal:2',
    ];

    // === Scopes ===

    /**
     * Chỉ lấy các giao dịch đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('trang_thai', 'hoat_dong');
    }

    /**
     * Chỉ lấy các giao dịch đã đến hạn chạy (ngay_chay_tiep_theo <= hôm nay)
     */
    public function scopeDue($query)
    {
        return $query->whereNotNull('ngay_chay_tiep_theo')
                     ->where('ngay_chay_tiep_theo', '<=', now()->toDateString());
    }

    /**
     * Chỉ lấy các giao dịch chưa hết hạn
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('ngay_ket_thuc')
              ->orWhere('ngay_ket_thuc', '>=', now()->toDateString());
        });
    }

    // === Relationships ===

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    // === Helpers ===

    /**
     * Tính ngày chạy tiếp theo dựa vào chu kỳ
     */
    public function tinhNgayTiepTheo(): string
    {
        $base = $this->ngay_chay_tiep_theo ?? $this->ngay_bat_dau;
        $date = \Carbon\Carbon::parse($base);

        return match ($this->chu_ky) {
            'hang_ngay'  => $date->addDay()->toDateString(),
            'hang_tuan'  => $date->addWeek()->toDateString(),
            'hang_thang' => $date->addMonth()->toDateString(),
            'hang_nam'   => $date->addYear()->toDateString(),
            default      => $date->addMonth()->toDateString(),
        };
    }

    /**
     * Tên chu kỳ hiển thị cho View
     */
    public function tenChuKy(): string
    {
        return match ($this->chu_ky) {
            'hang_ngay'  => 'Hàng ngày',
            'hang_tuan'  => 'Hàng tuần',
            'hang_thang' => 'Hàng tháng',
            'hang_nam'   => 'Hàng năm',
            default      => $this->chu_ky,
        };
    }
}
