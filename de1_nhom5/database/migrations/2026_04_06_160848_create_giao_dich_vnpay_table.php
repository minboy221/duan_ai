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
        Schema::create('giao_dich_vnpay', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung');
            $table->string('ma_don_hang')->unique();
            $table->decimal('so_tien', 15, 2);
            $table->text('noi_dung');
            $table->string('ma_giao_dich_vnpay')->nullable();
            $table->enum('loai_giao_dich', ['thu_nhap', 'chi_tieu']);
            $table->tinyInteger('trang_thai')->default(0)->comment('0: Đang chờ, 1: Thành công, 2: Thất bại');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giao_dich_vnpay');
    }
};
