<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('giao_dich_dinh_ky', function (Blueprint $table) {
            $table->enum('loai_giao_dich', ['thu', 'chi'])->after('danh_muc_id');
            $table->string('trang_thai')->default('hoat_dong')->after('chu_ky');
            $table->date('ngay_ket_thuc')->nullable()->after('ngay_bat_dau');
            $table->date('lan_thuc_hien_cuoi')->nullable()->after('ngay_ket_thuc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('giao_dich_dinh_ky', function (Blueprint $table) {
            $table->dropColumn(['loai_giao_dich', 'trang_thai', 'ngay_ket_thuc', 'lan_thuc_hien_cuoi']);
        });
    }
};
