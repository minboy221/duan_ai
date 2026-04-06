@extends('layouts.app')

@section('title', 'The Fiscal Curator - Tổng quan')

@section('content')
<!-- Dashboard Canvas -->
<div class="max-w-7xl mx-auto">
    <!-- Hero Balance & Editorial Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 items-end">
        <div class="lg:col-span-7">
            <span class="text-sm font-semibold text-primary/60 uppercase tracking-widest mb-2 block">Vốn khả dụng</span>
            <h2 class="text-6xl font-extrabold tracking-tighter text-on-surface tabular-nums">300.000.000<span class="text-primary/30 text-4xl ml-2">VNĐ</span></h2>
            <div class="flex gap-8 mt-6">
                <div>
                    <p class="text-xs text-outline mb-1">Thu nhập tháng</p>
                    <p class="text-xl font-bold text-secondary tabular-nums">+125.000.000 VNĐ</p>
                </div>
                <div class="h-10 w-[1px] bg-outline-variant/20 self-center"></div>
                <div>
                    <p class="text-xs text-outline mb-1">Chi tiêu vận hành</p>
                    <p class="text-xl font-bold text-tertiary tabular-nums">-68.500.000 VNĐ</p>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 flex justify-end">
            <div class="bg-surface-container-lowest p-6 rounded-full border border-outline-variant/10 shadow-sm flex items-center gap-6">
                <div class="text-right">
                    <p class="text-[10px] text-outline font-bold uppercase tracking-wider">Tỷ lệ tiết kiệm</p>
                    <p class="text-2xl font-bold text-primary">45,2%</p>
                </div>
                <div class="relative w-16 h-16">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle class="text-surface-container-high" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-width="4"></circle>
                        <circle class="text-secondary" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-dasharray="175.9" stroke-dashoffset="96.4" stroke-width="4"></circle>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary text-sm" data-icon="trending_up">trending_up</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bento Grid Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Chart: Monthly Trends -->
        <div class="md:col-span-2 bg-surface-container-low rounded-xl p-8 flex flex-col">
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-lg font-bold">Ma trận Hiệu suất</h3>
                <div class="flex gap-2">
                    <span class="flex items-center gap-1.5 text-xs font-medium text-outline"><span class="w-2 h-2 rounded-full bg-secondary"></span> Thu nhập</span>
                    <span class="flex items-center gap-1.5 text-xs font-medium text-outline"><span class="w-2 h-2 rounded-full bg-tertiary"></span> Chi phí</span>
                </div>
            </div>
            <div class="flex-1 flex items-end justify-between gap-4 h-48 pb-2 border-b border-outline-variant/10">
                <!-- Bar chart simulation -->
                <div class="group relative flex-1 flex flex-col items-center gap-2">
                    <div class="w-full flex flex-col gap-1 items-center justify-end h-full">
                        <div class="w-4 bg-secondary/20 h-[60%] rounded-t-sm"></div>
                        <div class="w-4 bg-tertiary/20 h-[40%] rounded-t-sm"></div>
                    </div>
                    <span class="text-[10px] text-outline">Tháng 1</span>
                </div>
                <div class="group relative flex-1 flex flex-col items-center gap-2">
                    <div class="w-full flex flex-col gap-1 items-center justify-end h-full">
                        <div class="w-4 bg-secondary/40 h-[75%] rounded-t-sm"></div>
                        <div class="w-4 bg-tertiary/40 h-[30%] rounded-t-sm"></div>
                    </div>
                    <span class="text-[10px] text-outline">Tháng 2</span>
                </div>
                <div class="group relative flex-1 flex flex-col items-center gap-2">
                    <div class="w-full flex flex-col gap-1 items-center justify-end h-full">
                        <div class="w-4 bg-secondary/60 h-[55%] rounded-t-sm"></div>
                        <div class="w-4 bg-tertiary/60 h-[50%] rounded-t-sm"></div>
                    </div>
                    <span class="text-[10px] text-outline">Tháng 3</span>
                </div>
                <div class="group relative flex-1 flex flex-col items-center gap-2">
                    <div class="w-full flex flex-col gap-1 items-center justify-end h-full">
                        <div class="w-4 bg-secondary/80 h-[85%] rounded-t-sm"></div>
                        <div class="w-4 bg-tertiary/80 h-[45%] rounded-t-sm"></div>
                    </div>
                    <span class="text-[10px] text-outline">Tháng 4</span>
                </div>
                <div class="group relative flex-1 flex flex-col items-center gap-2">
                    <div class="w-full flex flex-col gap-1 items-center justify-end h-full">
                        <div class="w-4 bg-secondary h-[95%] rounded-t-sm shadow-lg shadow-secondary/20"></div>
                        <div class="w-4 bg-tertiary h-[35%] rounded-t-sm shadow-lg shadow-tertiary/20"></div>
                    </div>
                    <span class="text-[10px] font-bold text-primary">Tháng 5</span>
                </div>
            </div>
        </div>
        <!-- Categories Pie Chart -->
        <div class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10">
            <h3 class="text-lg font-bold mb-8">Phân bổ</h3>
            <div class="relative w-40 h-40 mx-auto mb-8">
                <div class="w-full h-full rounded-full" style="background: conic-gradient(#24389c 0% 45%, #006c49 45% 70%, #8a0027 70% 85%, #eaedff 85% 100%)"></div>
                <div class="absolute inset-4 bg-surface-container-lowest rounded-full flex items-center justify-center">
                    <div class="text-center">
                        <p class="text-[10px] text-outline uppercase font-bold">Lớn nhất</p>
                        <p class="text-sm font-bold">Thuê nhà</p>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-primary"></span> Thuê nhà</span>
                    <span class="font-semibold tabular-nums">30.800.000 VNĐ</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-secondary"></span> Du lịch</span>
                    <span class="font-semibold tabular-nums">17.100.000 VNĐ</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-tertiary"></span> Ăn uống</span>
                    <span class="font-semibold tabular-nums">10.200.000 VNĐ</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-surface-container"></span> Khác</span>
                    <span class="font-semibold tabular-nums">10.400.000 VNĐ</span>
                </div>
            </div>
        </div>
        <!-- Recent Activity List -->
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-bold">Nhật ký Kiểm toán</h3>
                <button class="text-xs font-bold text-primary hover:underline">Xem nhật ký</button>
            </div>
            <div class="space-y-6">
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined" data-icon="restaurant">restaurant</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold group-hover:text-primary transition-colors">Artisan Bistro & Bar</p>
                            <p class="text-[10px] text-outline">Ăn uống & Xã hội · 2 giờ trước</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-tertiary tabular-nums">-3.425.000 VNĐ</p>
                        <p class="text-[10px] text-outline">TK Cá nhân</p>
                    </div>
                </div>
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined" data-icon="payments">payments</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold group-hover:text-primary transition-colors">Tech Solutions Inc.</p>
                            <p class="text-[10px] text-outline">Thu nhập chính · Hôm qua</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-secondary tabular-nums">+62.600.000 VNĐ</p>
                        <p class="text-[10px] text-outline">TK Doanh nghiệp</p>
                    </div>
                </div>
                <div class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined" data-icon="flight_takeoff">flight_takeoff</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold group-hover:text-primary transition-colors">Skyline Airways</p>
                            <p class="text-[10px] text-outline">Du lịch · 14 tháng 5</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-tertiary tabular-nums">-20.840.000 VNĐ</p>
                        <p class="text-[10px] text-outline">Quỹ Du lịch</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Insights / AI Card -->
        <div class="bg-primary text-on-primary rounded-xl p-8 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-lg flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                </div>
                <h4 class="text-xl font-bold mb-2">Gợi ý từ Curator</h4>
                <p class="text-sm text-on-primary/80 leading-relaxed mb-6">Chi tiêu không thiết yếu của bạn thấp hơn 12% so với tháng trước. Hãy cân nhắc chuyển <span class="font-bold text-white">10.000.000 VNĐ</span> vào danh mục đầu tư lãi suất cao.</p>
            </div>
            <button class="relative z-10 w-full py-3 bg-white text-primary font-bold rounded-full text-sm shadow-xl active:scale-95 transition-all">
                Thực hiện kiến nghị
            </button>
        </div>
    </div>
</section>
@endsection