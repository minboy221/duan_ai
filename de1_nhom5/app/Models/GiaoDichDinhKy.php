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
        'so_tien',
        'chu_ky',
        'ngay_bat_dau',
        'ngay_chay_tiep_theo',
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
