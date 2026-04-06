<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    use HasFactory;

    protected $table = 'nguoi_dung';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'tien_te',
        'ngay_tao',
    ];

    const CREATED_AT = 'ngay_tao';

    protected $hidden = [
        'mat_khau',
    ];

    public function danhMucs()
    {
        return $this->hasMany(DanhMuc::class, 'nguoi_dung_id');
    }

    public function giaoDichs()
    {
        return $this->hasMany(GiaoDich::class, 'nguoi_dung_id');
    }

    public function khoanThus()
    {
        return $this->hasMany(KhoanThu::class, 'nguoi_dung_id');
    }

    public function nganSachs()
    {
        return $this->hasMany(NganSach::class, 'nguoi_dung_id');
    }

    public function mucTieuTietKiems()
    {
        return $this->hasMany(MucTieuTietKiem::class, 'nguoi_dung_id');
    }

    public function giaoDichDinhKys()
    {
        return $this->hasMany(GiaoDichDinhKy::class, 'nguoi_dung_id');
    }

    public function lichSuChatAis()
    {
        return $this->hasMany(LichSuChatAi::class, 'nguoi_dung_id');
    }

    public function nguCanhAis()
    {
        return $this->hasMany(NguCanhAi::class, 'nguoi_dung_id');
    }

    public function phanTichAis()
    {
        return $this->hasMany(PhanTichAi::class, 'nguoi_dung_id');
    }

    public function tongKetTaiChinhs()
    {
        return $this->hasMany(TongKetTaiChinh::class, 'nguoi_dung_id');
    }
}
