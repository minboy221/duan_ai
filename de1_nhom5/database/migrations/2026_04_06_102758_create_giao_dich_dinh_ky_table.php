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
        Schema::create('giao_dich_dinh_ky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->onDelete('cascade');
            $table->foreignId('danh_muc_id')->constrained('danh_muc')->onDelete('cascade');
            $table->decimal('so_tien', 15, 2);
            $table->string('chu_ky');
            $table->date('ngay_bat_dau');
            $table->date('ngay_chay_tiep_theo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giao_dich_dinh_ky');
    }
};
