@extends('layouts.app')

@section('title', 'The Fiscal Curator - Ngân sách & Tiết kiệm')

@section('content')
<!-- Main Content -->
<div class="pb-12 min-h-screen">
    <!-- Editorial Header Section -->
    <section class="mb-12 flex flex-col md:flex-row justify-between items-end gap-8">
        <div class="max-w-2xl">
            <h2 class="text-sm font-bold uppercase tracking-widest text-primary mb-2">Tổng quan danh mục</h2>
            <h3 class="text-5xl font-extrabold headline leading-tight text-on-surface">
                Gìn giữ <span class="text-secondary italic">di sản tài chính</span> của bạn một cách tinh tế.
            </h3>
        </div>
        <div class="bg-surface-container-low p-6 rounded-full flex items-center gap-8">
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Tổng ngân sách tháng</p>
                <p class="text-2xl font-extrabold tabular-nums">312.000.000 VNĐ</p>
            </div>
            <div class="h-10 w-[1px] bg-slate-300"></div>
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Mức độ sử dụng</p>
                <p class="text-2xl font-extrabold tabular-nums text-secondary">64%</p>
            </div>
        </div>
    </section>

    <!-- Bento Grid: Monthly Budgets -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h4 class="text-xl font-bold headline">Phân loại chi tiêu hàng tháng</h4>
            <button class="text-sm font-semibold text-primary flex items-center gap-1 hover:gap-2 transition-all">
                Xem chi tiết <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Food Budget Card -->
            <div class="bg-surface-container-lowest p-8 rounded-full flex flex-col justify-between min-h-[220px] shadow-sm relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-secondary-container rounded-xl">
                            <span class="material-symbols-outlined text-on-secondary-container" data-icon="restaurant">restaurant</span>
                        </div>
                        <span class="text-xs font-bold text-secondary uppercase tracking-wider">Bền vững</span>
                    </div>
                    <h5 class="text-lg font-bold mb-1">Ẩm thực & Thực phẩm</h5>
                    <p class="text-3xl font-extrabold tabular-nums mb-4">21.050.000<span class="text-base font-medium text-slate-400"> / 30.000.000 VNĐ</span></p>
                </div>
                <div class="relative z-10">
                    <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                        <div class="h-full bg-secondary transition-all duration-1000" style="width: 70%;"></div>
                    </div>
                    <p class="text-[11px] font-medium text-slate-500 mt-2">Đã dùng 70%. Đang đi đúng lộ trình.</p>
                </div>
            </div>
            <!-- Entertainment Budget Card -->
            <div class="bg-surface-container-lowest p-8 rounded-full flex flex-col justify-between min-h-[220px] shadow-sm relative overflow-hidden ring-2 ring-tertiary/10">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-tertiary-container rounded-xl">
                            <span class="material-symbols-outlined text-white" data-icon="theater_comedy">theater_comedy</span>
                        </div>
                        <span class="text-xs font-bold text-tertiary uppercase tracking-wider italic">Cần lưu ý</span>
                    </div>
                    <h5 class="text-lg font-bold mb-1">Giải trí & Lối sống</h5>
                    <p class="text-3xl font-extrabold tabular-nums mb-4">47.250.000<span class="text-base font-medium text-slate-400"> / 50.000.000 VNĐ</span></p>
                </div>
                <div class="relative z-10">
                    <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                        <div class="h-full bg-tertiary transition-all duration-1000" style="width: 94.5%;"></div>
                    </div>
                    <p class="text-[11px] font-bold text-tertiary mt-2">Đã dùng 94.5%. Còn lại 2.750.000 VNĐ.</p>
                </div>
            </div>
            <!-- Utilities Budget Card -->
            <div class="bg-surface-container-lowest p-8 rounded-full flex flex-col justify-between min-h-[220px] shadow-sm relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-primary-container rounded-xl">
                            <span class="material-symbols-outlined text-white" data-icon="bolt">bolt</span>
                        </div>
                        <span class="text-xs font-bold text-primary uppercase tracking-wider">Chi phí cố định</span>
                    </div>
                    <h5 class="text-lg font-bold mb-1">Nhà ở & Tiện ích</h5>
                    <p class="text-3xl font-extrabold tabular-nums mb-4">10.500.000<span class="text-base font-medium text-slate-400"> / 21.000.000 VNĐ</span></p>
                </div>
                <div class="relative z-10">
                    <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                        <div class="h-full bg-primary transition-all duration-1000" style="width: 50%;"></div>
                    </div>
                    <p class="text-[11px] font-medium text-slate-500 mt-2">Đã dùng 50%. Dưới mức chi tiêu trung bình.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Savings Goals -->
    <section>
        <div class="flex items-baseline gap-4 mb-8">
            <h4 class="text-3xl font-extrabold headline">Mục tiêu Tiết kiệm</h4>
            <p class="text-slate-500 font-medium text-sm">Tích lũy tài sản dài hạn</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7 bg-surface-container-low rounded-full overflow-hidden p-1">
                <div class="bg-surface-container-lowest rounded-[2.5rem] p-10 flex flex-col md:flex-row gap-10 items-center">
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-widest mb-4">
                            <span class="material-symbols-outlined text-sm" data-icon="auto_awesome">auto_awesome</span>
                            Mục tiêu chính
                        </div>
                        <h5 class="text-4xl font-extrabold headline mb-6">Biệt thự tại Tuscany</h5>
                        <div class="space-y-6 mb-8">
                            <div>
                                <div class="flex justify-between text-xs font-bold uppercase mb-2">
                                    <span class="text-slate-500">Đã tích lũy</span>
                                    <span class="text-on-surface">3.625M / 11.250M VNĐ</span>
                                </div>
                                <div class="h-3 w-full bg-surface-container-low rounded-full">
                                    <div class="h-full bg-gradient-to-r from-primary to-primary-container rounded-full" style="width: 32.2%;"></div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-surface-container-low p-4 rounded-full">
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">Ngày hoàn thành</p>
                                    <p class="text-base font-bold tabular-nums">Th10 2026</p>
                                </div>
                                <div class="bg-surface-container-low p-4 rounded-full">
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">Tốc độ hàng ngày</p>
                                    <p class="text-base font-bold tabular-nums text-secondary">7.100.000 VNĐ</p>
                                </div>
                            </div>
                        </div>
                        <button class="px-8 py-3 bg-on-surface text-white rounded-full font-bold text-sm hover:bg-slate-800 transition-colors">Điều chỉnh đóng góp</button>
                    </div>
                    <div class="w-full md:w-1/2 h-full min-h-[300px]">
                        <div class="relative h-full w-full rounded-[2rem] overflow-hidden group">
                            <img alt="Tuscany Villa" class="w-full h-full object-cover grayscale-[20%] group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0672jcdNxiGuSd9-BtrhLxPaQrVze6UeNO3CCSNI75cksMrv-BsLwjzzxXFg7DaoqJZJb1HfJr7TIvRa75BqSNE6xzeIrshTQ6HoUfO6pFiu7-7Qzq7gmPfdrxVbXqOvWNMCcjWaeMo1aV8sghckPjqXsWPzfzSk1vZRgEbnuV431_PEnXQeQLkwCsrro9HsNXrcwn7d2uyYu6Ww_p2E75kvlRJf_onyOzMijTtQSnSlGd0bUtXgWk0_xKOWnnYMe9mQ8qQMUaAQ"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-5 flex flex-col gap-6">
                <!-- Goal: Emergency Fund -->
                <div class="bg-surface-container-low p-8 rounded-full border border-transparent hover:border-primary/20 transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h6 class="text-xl font-extrabold headline mb-1">Quỹ dự phòng khẩn cấp</h6>
                            <p class="text-sm text-slate-500 font-medium">Đảm bảo 9 tháng chi tiêu</p>
                        </div>
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-primary" data-icon="security" style="font-variation-settings: 'FILL' 1;">security</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <p class="text-2xl font-extrabold tabular-nums">1.560.000.000 VNĐ</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Mục tiêu: 1.875.000.000 VNĐ</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-secondary">+10.500.000 / tuần</p>
                            <p class="text-[10px] text-slate-400 font-medium italic">Còn 31 tuần</p>
                        </div>
                    </div>
                    <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-primary" style="width: 83%;"></div>
                    </div>
                </div>
                <!-- Goal: New High-End SUV -->
                <div class="bg-surface-container-low p-8 rounded-full border border-transparent hover:border-primary/20 transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h6 class="text-xl font-extrabold headline mb-1">Xe sang đẳng cấp</h6>
                            <p class="text-sm text-slate-500 font-medium">Model S Plaid Fund</p>
                        </div>
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-primary" data-icon="electric_car">electric_car</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <p class="text-2xl font-extrabold tabular-nums">1.030.000.000 VNĐ</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Mục tiêu: 3.000.000.000 VNĐ</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-secondary">+30.000.000 / tuần</p>
                            <p class="text-[10px] text-slate-400 font-medium italic">Dự kiến Th1 2025</p>
                        </div>
                    </div>
                    <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-primary" style="width: 34%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Insights Footer Action -->
    <section class="mt-16 bg-primary text-white p-12 rounded-[3rem] relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-10">
            <div class="w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="max-w-xl text-center md:text-left">
                <h4 class="text-3xl font-bold headline mb-4">Tối ưu hóa hành trình thịnh vượng.</h4>
                <p class="text-primary-fixed-dim font-medium leading-relaxed">Dựa trên tỷ lệ chi tiêu và quỹ đạo thu nhập hiện tại, AI của chúng tôi gợi ý tăng 12% tốc độ tích lũy "Biệt thự Tuscany" để đạt mục tiêu vào tháng 10/2026 với điểm tin cậy 95%.</p>
            </div>
            <button class="whitespace-nowrap px-10 py-5 bg-white text-primary rounded-full font-extrabold shadow-2xl hover:scale-105 active:scale-95 transition-all">
                Thực hiện chiến lược tối ưu
            </button>
        </div>
    </section>
</div>
@endsection