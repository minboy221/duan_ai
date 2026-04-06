<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoDich extends Model
{
    use HasFactory;

    protected $table = 'giao_dich';

    protected $fillable = [
        'nguoi_dung_id',
        'danh_muc_id',
        'so_tien',
        'ghi_chu',
        'ngay_giao_dich',
        'ai_tu_phan_loai',
        'ngay_tao',
    ];

    const CREATED_AT = 'ngay_tao';

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }
}
