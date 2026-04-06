<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NganSach extends Model
{
    use HasFactory;

    protected $table = 'ngan_sach';

    protected $fillable = [
        'nguoi_dung_id',
        'danh_muc_id',
        'so_tien_han_muc',
        'thang',
        'nam',
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
