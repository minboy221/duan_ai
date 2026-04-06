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
        Schema::create('tong_ket_tai_chinh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->onDelete('cascade');
            $table->integer('thang');
            $table->integer('nam');
            $table->decimal('tong_thu', 15, 2)->default(0);
            $table->decimal('tong_chi', 15, 2)->default(0);
            $table->decimal('tong_tiet_kiem', 15, 2)->default(0);
            $table->decimal('so_tien_con_lai', 15, 2)->default(0);
            $table->decimal('han_muc_chi_tieu_thang', 15, 2)->default(0);
            $table->timestamp('ngay_cap_nhat')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tong_ket_tai_chinh');
    }
};
