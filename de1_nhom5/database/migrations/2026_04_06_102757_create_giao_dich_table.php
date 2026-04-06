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
        Schema::create('giao_dich', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->onDelete('cascade');
            $table->foreignId('danh_muc_id')->constrained('danh_muc')->onDelete('cascade');
            $table->decimal('so_tien', 15, 2);
            $table->text('ghi_chu')->nullable();
            $table->date('ngay_giao_dich');
            $table->boolean('ai_tu_phan_loai')->default(false);
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giao_dich');
    }
};
