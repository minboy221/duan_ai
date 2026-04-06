@extends('layouts.app')

@section('title', 'Hướng dẫn sử dụng | The Fiscal Curator')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <h1 class="text-4xl font-headline font-extrabold text-primary mb-3">Sổ tay Quản lý</h1>
        <p class="text-on-surface-variant text-lg">Khám phá cách hoạt động của hệ thống và giải phóng sức mạnh của Trợ lý AI.</p>
    </div>

    <div class="space-y-6">
        <!-- Chức năng 1 -->
        <div class="bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 relative z-10">
                <div class="w-16 h-16 bg-primary-container text-on-primary-container rounded-2xl flex items-center justify-center shrink-0 shadow-inner">
                    <span class="material-symbols-outlined text-3xl" data-icon="dashboard">dashboard</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-on-surface mb-2 font-headline">1. Tổng quan (Dashboard)</h2>
                    <p class="text-on-surface-variant leading-relaxed mb-3">Nơi hiển thị toàn cảnh bức tranh tài chính của bạn. Tự động tính toán số dư Vốn khả dụng, tỷ lệ tiết kiệm thông minh và theo dõi dòng tiền thu/chi chi tiết.</p>
                    <ul class="list-disc pl-5 text-sm text-outline space-y-1">
                        <li>Dữ liệu <strong class="text-primary">thời gian thực</strong> giúp theo dõi tiến độ mỗi ngày.</li>
                        <li>Hiển thị cảnh báo và các lời khuyên nhanh từ hệ thống.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Chức năng 2 -->
        <div class="bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-secondary/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 relative z-10">
                <div class="w-16 h-16 bg-secondary-container text-on-secondary-container rounded-2xl flex items-center justify-center shrink-0 shadow-inner">
                    <span class="material-symbols-outlined text-3xl" data-icon="auto_fix_high">auto_fix_high</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-on-surface mb-2 font-headline">2. Nhập liệu AI (Smart Entry)</h2>
                    <p class="text-on-surface-variant leading-relaxed mb-3">Quên đi việc phải tự gõ từng con số và chọn chuyên mục mệt mỏi! Bạn chỉ cần gõ vào khung văn bản tự nhiên, ví dụ: <code class="bg-surface-variant text-primary px-2 py-0.5 rounded font-semibold space-x-1">"Hôm nay mua ly cà phê 50k"</code>.</p>
                    <ul class="list-disc pl-5 text-sm text-outline space-y-1">
                        <li>AI sẽ tự động <strong>bóc tách số tiền 50.000đ</strong> và phân loại nó vào <strong>"Ăn uống"</strong>.</li>
                        <li>Tránh nhập sai, nhập nhầm và tiết kiệm đến 80% thủ tục nhập liệu.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Chức năng 3 -->
        <div class="bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-32 h-32 bg-tertiary/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 relative z-10">
                <div class="w-16 h-16 bg-tertiary-container text-on-tertiary-container rounded-2xl flex items-center justify-center shrink-0 shadow-inner">
                    <span class="material-symbols-outlined text-3xl" data-icon="forum">forum</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-on-surface mb-2 font-headline">3. Trợ lý Phân tích AI</h2>
                    <p class="text-on-surface-variant leading-relaxed mb-4">Để AI đọc báo cáo tài chính thay bạn. Trợ lý này quét lịch sử dòng tiền trong 30 ngày và cảnh báo sự "bất thường" hoặc tóm tắt thói quen mua sắm.</p>
                    <div class="bg-surface-variant/50 p-4 rounded-xl text-sm italic text-on-surface-variant border-l-4 border-tertiary">
                        "🔍 Phát hiện bất thường: Tuần này bạn đã chi tới 1.500.000 VNĐ cho mua sắm trực tuyến, cao gấp 3 lần tuần trước. Hãy hãm phanh lại nếu muốn mua chiếc Laptop vào cuối năm!"
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center pt-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-bold rounded-full hover:bg-primary-container transition-all shadow-xl shadow-primary/20 hover:scale-105">
                <span class="material-symbols-outlined">rocket_launch</span>
                Quay lại Bảng điều khiển
            </a>
        </div>
    </div>
</div>
@endsection
