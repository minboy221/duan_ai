<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguCanhAi extends Model
{
    use HasFactory;

    protected $table = 'ngu_canh_ai';

    protected $fillable = [
        'nguoi_dung_id',
        'tu_khoa_quan_tam',
        'gia_tri_ngu_canh',
        'do_tin_cay',
        'cap_nhat_lan_cuoi',
    ];

    const UPDATED_AT = 'cap_nhat_lan_cuoi';

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }
}
