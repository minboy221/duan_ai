<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TongKetTaiChinh extends Model
{
    use HasFactory;

    protected $table = 'tong_ket_tai_chinh';

    protected $fillable = [
        'nguoi_dung_id',
        'thang',
        'nam',
        'tong_thu',
        'tong_chi',
        'tong_tiet_kiem',
        'so_tien_con_lai',
        'han_muc_chi_tieu_thang',
        'ngay_cap_nhat',
    ];

    const UPDATED_AT = 'ngay_cap_nhat';

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
