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
        Schema::create('khoan_thu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->onDelete('cascade');
            $table->foreignId('danh_muc_id')->constrained('danh_muc')->onDelete('cascade');
            $table->decimal('so_tien', 15, 2);
            $table->string('nguon_thu');
            $table->date('ngay_nhan');
            $table->boolean('la_thu_nhap_co_dinh')->default(false);
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khoan_thu');
    }
};
