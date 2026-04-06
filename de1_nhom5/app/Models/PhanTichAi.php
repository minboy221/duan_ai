<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanTichAi extends Model
{
    use HasFactory;

    protected $table = 'phan_tich_ai';

    protected $fillable = [
        'nguoi_dung_id',
        'loai_phan_tich',
        'noi_dung',
        'ngay_tao',
    ];

    const CREATED_AT = 'ngay_tao';

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
