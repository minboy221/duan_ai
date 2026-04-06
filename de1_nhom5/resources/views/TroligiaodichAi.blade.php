@extends('layouts.app')

@section('title', 'Quản lý Giao dịch - Fiscal Curator')

@section('content')
<!-- Breadcrumbs & Title Section -->
<div class="flex justify-between items-end mb-8">
    <div>
        <h1 class="text-3xl font-extrabold font-headline tracking-tight text-on-surface mb-2">Quản lý Giao dịch</h1>
        <p class="text-on-surface-variant text-sm">Xem và quản lý tất cả các hoạt động tài chính của bạn trong một giao diện duy nhất.</p>
    </div>
    <div class="flex gap-3">
        <button class="px-5 py-2.5 rounded-full bg-secondary-container text-on-secondary-container font-headline font-bold text-sm flex items-center gap-2 hover:brightness-95 transition-all">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Thêm giao dịch
        </button>
        <button class="px-5 py-2.5 rounded-full bg-surface-container-high text-on-surface font-headline font-bold text-sm flex items-center gap-2 hover:bg-surface-container-highest transition-all">
            <span class="material-symbols-outlined text-lg">file_download</span>
            Xuất báo cáo
        </button>
    </div>
</div>

<!-- Dashboard Summary Widgets (Asymmetric Layout) -->
<div class="grid grid-cols-12 gap-6 mb-8">
    <div class="col-span-12 lg:col-span-4 p-6 bg-surface-container-lowest rounded-full shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-full bg-secondary-container/20">
                <span class="material-symbols-outlined text-secondary">trending_up</span>
            </div>
            <span class="text-[10px] font-bold text-secondary uppercase tracking-widest">+12.5% vs tháng trước</span>
        </div>
        <p class="text-on-surface-variant text-xs font-semibold mb-1">Tổng Thu nhập (Tháng này)</p>
        <h3 class="text-2xl font-black font-headline text-secondary tracking-tight">85.000.000 <span class="text-sm font-bold">VNĐ</span></h3>
    </div>
    <div class="col-span-12 lg:col-span-4 p-6 bg-surface-container-lowest rounded-full shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-full bg-tertiary-container/10">
                <span class="material-symbols-outlined text-tertiary">trending_down</span>
            </div>
            <span class="text-[10px] font-bold text-tertiary uppercase tracking-widest">-2.4% vs tháng trước</span>
        </div>
        <p class="text-on-surface-variant text-xs font-semibold mb-1">Tổng Chi tiêu (Tháng này)</p>
        <h3 class="text-2xl font-black font-headline text-tertiary tracking-tight">42.350.000 <span class="text-sm font-bold">VNĐ</span></h3>
    </div>
    <div class="col-span-12 lg:col-span-4 p-6 bg-primary-container text-on-primary-container rounded-full shadow-lg shadow-primary/10">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-full bg-white/10">
                <span class="material-symbols-outlined text-white">savings</span>
            </div>
            <span class="text-[10px] font-bold text-white/70 uppercase tracking-widest">Mục tiêu: 50M</span>
        </div>
        <p class="text-white/70 text-xs font-semibold mb-1">Số dư ròng</p>
        <h3 class="text-2xl font-black font-headline text-white tracking-tight">42.650.000 <span class="text-sm font-bold">VNĐ</span></h3>
    </div>
</div>

<!-- Filters Bar -->
<div class="bg-surface-container-low rounded-full p-2 mb-6 flex flex-wrap items-center gap-2">
    <div class="flex items-center gap-2 bg-surface-container-lowest rounded-full px-4 py-2 text-sm text-on-surface-variant font-medium border border-outline-variant/20 cursor-pointer hover:bg-white transition-colors">
        <span class="material-symbols-outlined text-lg">calendar_today</span>
        30 ngày qua
        <span class="material-symbols-outlined text-lg">expand_more</span>
    </div>
    <div class="flex items-center gap-2 bg-surface-container-lowest rounded-full px-4 py-2 text-sm text-on-surface-variant font-medium border border-outline-variant/20 cursor-pointer hover:bg-white transition-colors">
        <span class="material-symbols-outlined text-lg">category</span>
        Hạng mục
        <span class="material-symbols-outlined text-lg">expand_more</span>
    </div>
    <div class="flex items-center gap-2 bg-surface-container-lowest rounded-full px-4 py-2 text-sm text-on-surface-variant font-medium border border-outline-variant/20 cursor-pointer hover:bg-white transition-colors">
        <span class="material-symbols-outlined text-lg">payments</span>
        Trạng thái
        <span class="material-symbols-outlined text-lg">expand_more</span>
    </div>
    <div class="h-6 w-[1px] bg-outline-variant/50 mx-2"></div>
    <button class="text-primary text-xs font-bold uppercase tracking-wider px-4 hover:underline">Xóa bộ lọc</button>
    <div class="ml-auto pr-4">
        <p class="text-[10px] font-bold text-outline uppercase tracking-tighter">Hiển thị 24 giao dịch</p>
    </div>
</div>

<!-- Transaction Table Section -->
<div class="bg-surface-container-lowest rounded-full overflow-hidden shadow-sm border border-outline-variant/10">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container/50">
                    <th class="px-8 py-5 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Ngày</th>
                    <th class="px-8 py-5 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Mô tả</th>
                    <th class="px-8 py-5 text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Hạng mục</th>
                    <th class="px-8 py-5 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-right">Số tiền</th>
                    <th class="px-8 py-5 text-[10px] font-black text-on-surface-variant uppercase tracking-widest text-center">Trạng thái</th>
                    <th class="px-8 py-5 w-10"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container">
                <!-- Transaction Row 1 (Income) -->
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-on-surface">24 Th10, 2023</p>
                        <p class="text-[10px] text-on-surface-variant">14:30</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-secondary-container/20 flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined">work</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface leading-tight">Lương tháng 10</p>
                                <p class="text-[10px] text-on-surface-variant">Công ty TechGlobal Solutions</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-surface-container-high rounded-full text-[10px] font-bold text-on-surface-variant uppercase tracking-tight">Lương</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <p class="text-sm font-black text-secondary">+ 45.000.000 VNĐ</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-secondary-container/10 text-secondary border border-secondary/20">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold uppercase">Hoàn tất</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <button class="p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-outline">more_vert</span>
                        </button>
                    </td>
                </tr>
                <!-- Transaction Row 2 (Expense) -->
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-on-surface">22 Th10, 2023</p>
                        <p class="text-[10px] text-on-surface-variant">19:15</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-tertiary-container/10 flex items-center justify-center text-tertiary">
                                <span class="material-symbols-outlined">restaurant</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface leading-tight">Ăn tối tại Pizza 4P's</p>
                                <p class="text-[10px] text-on-surface-variant">Thanh toán qua thẻ Visa</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-surface-container-high rounded-full text-[10px] font-bold text-on-surface-variant uppercase tracking-tight">Ăn uống</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <p class="text-sm font-black text-tertiary">- 1.250.000 VNĐ</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-secondary-container/10 text-secondary border border-secondary/20">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold uppercase">Hoàn tất</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <button class="p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-outline">more_vert</span>
                        </button>
                    </td>
                </tr>
                <!-- Transaction Row 3 (Expense) -->
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-on-surface">20 Th10, 2023</p>
                        <p class="text-[10px] text-on-surface-variant">08:00</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">home</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface leading-tight">Tiền thuê căn hộ Vinhomes</p>
                                <p class="text-[10px] text-on-surface-variant">Chuyển khoản định kỳ</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-surface-container-high rounded-full text-[10px] font-bold text-on-surface-variant uppercase tracking-tight">Thuê nhà</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <p class="text-sm font-black text-tertiary">- 15.000.000 VNĐ</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-secondary-container/10 text-secondary border border-secondary/20">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold uppercase">Hoàn tất</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <button class="p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-outline">more_vert</span>
                        </button>
                    </td>
                </tr>
                <!-- Transaction Row 4 (Expense) -->
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-on-surface">18 Th10, 2023</p>
                        <p class="text-[10px] text-on-surface-variant">10:45</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600">
                                <span class="material-symbols-outlined">directions_car</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface leading-tight">Grab Car - Sân bay</p>
                                <p class="text-[10px] text-on-surface-variant">Chuyến đi công tác</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-surface-container-high rounded-full text-[10px] font-bold text-on-surface-variant uppercase tracking-tight">Di chuyển</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <p class="text-sm font-black text-tertiary">- 320.000 VNĐ</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                            <span class="text-[10px] font-bold uppercase">Chờ duyệt</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <button class="p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-outline">more_vert</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Pagination Footer -->
    <div class="px-8 py-6 flex items-center justify-between bg-surface-container/30">
        <p class="text-xs text-on-surface-variant">Hiển thị <span class="font-bold">1 - 4</span> trong tổng số <span class="font-bold">24</span> giao dịch</p>
        <div class="flex items-center gap-2">
            <button class="p-2 rounded-full hover:bg-surface-container-high text-on-surface-variant disabled:opacity-30" disabled="">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="w-8 h-8 rounded-full bg-primary text-on-primary text-xs font-bold">1</button>
            <button class="w-8 h-8 rounded-full hover:bg-surface-container-high text-on-surface-variant text-xs font-bold">2</button>
            <button class="w-8 h-8 rounded-full hover:bg-surface-container-high text-on-surface-variant text-xs font-bold">3</button>
            <button class="p-2 rounded-full hover:bg-surface-container-high text-on-surface-variant">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </div>
</div>

<!-- Sticky Bottom Visual -->
<div class="mt-8">
    <div class="relative bg-gradient-to-r from-primary to-primary-container rounded-full p-8 overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <h4 class="text-xl font-headline font-black text-white mb-2">Phân tích Chi tiêu Thông minh</h4>
                <p class="text-white/80 text-sm max-w-md">Chúng tôi nhận thấy chi tiêu cho 'Ăn uống' của bạn đã giảm 15% so với tháng trước. Tuyệt vời!</p>
            </div>
            <button class="bg-white text-primary px-6 py-3 rounded-full font-headline font-black text-sm hover:bg-opacity-90 transition-all">
                Xem chi tiết
            </button>
        </div>
    </div>
</div>
@endsection