<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoanThu extends Model
{
    use HasFactory;

    protected $table = 'khoan_thu';

    protected $fillable = [
        'nguoi_dung_id',
        'danh_muc_id',
        'so_tien',
        'nguon_thu',
        'ngay_nhan',
        'la_thu_nhap_co_dinh',
        'ghi_chu',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }
}
