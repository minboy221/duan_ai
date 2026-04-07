<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VNPay extends Model
{
    use HasFactory;

    protected $table = 'giao_dich_vnpay';

    protected $fillable = [
        'nguoi_dung_id',
        'ma_don_hang',
        'so_tien',
        'noi_dung',
        'ma_giao_dich_vnpay',
        'loai_giao_dich',
        'trang_thai',
        'vnp_create_date',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
