<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MucTieuTietKiem extends Model
{
    use HasFactory;

    protected $table = 'muc_tieu_tiet_kiem';

    protected $fillable = [
        'nguoi_dung_id',
        'ten_muc_tieu',
        'so_tien_muc_tieu',
        'so_tien_hien_tai',
        'han_chot',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
