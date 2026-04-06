<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';

    protected $fillable = [
        'nguoi_dung_id',
        'ten_danh_muc',
        'loai',
        'biu_tuong',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function giaoDichs()
    {
        return $this->hasMany(GiaoDich::class, 'danh_muc_id');
    }

    public function khoanThus()
    {
        return $this->hasMany(KhoanThu::class, 'danh_muc_id');
    }

    public function nganSachs()
    {
        return $this->hasMany(NganSach::class, 'danh_muc_id');
    }

    public function giaoDichDinhKys()
    {
        return $this->hasMany(GiaoDichDinhKy::class, 'danh_muc_id');
    }
}
