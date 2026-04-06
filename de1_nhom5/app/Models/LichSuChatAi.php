<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuChatAi extends Model
{
    use HasFactory;

    protected $table = 'lich_su_chat_ai';

    protected $fillable = [
        'nguoi_dung_id',
        'cau_hoi_nguoi_dung',
        'cau_tra_loi_ai',
        'hanh_dong_he_thong',
        'ngay_tao',
    ];

    const CREATED_AT = 'ngay_tao';

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
