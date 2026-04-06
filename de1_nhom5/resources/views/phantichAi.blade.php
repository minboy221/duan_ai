@extends('layouts.app')

@section('title', 'Phân tích AI - The Fiscal Curator')

@section('content')
<!-- Main Content -->
<div class="pb-12 min-h-screen">
    <!-- Hero Section: Editorial Spending Habits -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
        <div class="lg:col-span-7 bg-surface-container-lowest rounded-full p-10 flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-primary/10 transition-colors"></div>
            <h2 class="text-sm font-bold text-primary uppercase tracking-[0.2em] mb-4">Phân tích chuyên sâu</h2>
            <h3 class="text-5xl font-extrabold headline leading-[1.1] mb-8 max-w-md">Thói quen chi tiêu của bạn</h3>
            <div class="space-y-6 max-w-lg">
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Phong cách sống & Giải trí</span>
                        <span class="text-2xl font-bold tabular-nums text-primary">{{ Auth::check() ? '45%' : '0%' }}</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-primary-container rounded-full w-[{{ Auth::check() ? '45' : '0' }}%]"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Chi phí cố định & Tiện ích</span>
                        <span class="text-2xl font-bold tabular-nums text-secondary">{{ Auth::check() ? '30%' : '0%' }}</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-secondary to-secondary-container rounded-full w-[{{ Auth::check() ? '30' : '0' }}%]"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Tiết kiệm & Đầu tư</span>
                        <span class="text-2xl font-bold tabular-nums text-tertiary">{{ Auth::check() ? '25%' : '0%' }}</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-tertiary to-tertiary-container rounded-full w-[{{ Auth::check() ? '25' : '0' }}%]"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 bg-primary rounded-full p-10 text-on-primary flex flex-col justify-between shadow-2xl relative overflow-hidden">
            <img alt="Biểu diễn dữ liệu trừu tượng" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-overlay" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAXs7uQ-1ZTc_ZfojBI4HyWUnFXFa0XH542rLCJhJzckkxFq-xg9iGVH1Iw7bMtVukwNSGiQlFA8Gm7OWf8QG2IiBZ-RV3fzJ0Vqm3w8a5MD9a7HehM9Kbj37amqh_Oc0QaEPipvMVXq4QzAfoij7DYWybe2qFQLdGOM5wSDXZWAlT8bL5hUc4zI2haYzc04ePNO0lbOzaSVnG_UbtSKwEjPP1avx2H0M_pmg0AzHHjIh-n71tuiL2Z4Jg1ZzLCbvjwMnCH82RJTI"/>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                </div>
                <h4 class="text-2xl font-bold mb-4 headline">Dự báo thông minh</h4>
                <p class="text-indigo-100/80 leading-relaxed mb-6">Dựa trên quỹ đạo hiện tại, bạn dự kiến sẽ vượt mục tiêu tiết kiệm hàng tháng khoảng <span class="text-white font-bold">{{ Auth::check() ? '31.000.000' : '0' }} VNĐ</span>.</p>
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/10">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed" data-icon="trending_up">trending_up</span>
                        <span class="text-sm font-medium">{{ Auth::check() ? '+12.4%' : '0%' }} hiệu quả so với tháng trước</span>
                    </div>
                </div>
            </div>
            <button class="relative z-10 mt-8 w-full py-4 bg-white text-primary font-bold rounded-full hover:bg-indigo-50 transition-colors shadow-lg">
                Tạo báo cáo đầy đủ
            </button>
        </div>
    </section>

    <!-- AI Advice Bento Grid -->
    <div class="mb-8 flex items-center justify-between">
        <h3 class="text-2xl font-bold headline">Đề xuất từ AI</h3>
        <button class="text-sm font-bold text-primary flex items-center gap-1 group">
            Cập nhật phân tích 
            <span class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform" data-icon="refresh">refresh</span>
        </button>
    </div>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Advice Card 1 -->
        <div class="bg-surface-container-lowest p-8 rounded-full border-none shadow-sm group hover:bg-surface-container-low transition-all">
            <div class="w-10 h-10 rounded-full bg-tertiary-fixed text-tertiary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined" data-icon="restaurant" style="font-variation-settings: 'FILL' 1;">restaurant</span>
            </div>
            <h4 class="font-bold text-lg mb-3">Thói quen ăn uống</h4>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">Bạn đã chi <span class="font-bold text-tertiary">{{ Auth::check() ? 'nhiều hơn 20%' : '0%' }}</span> cho việc ăn ngoài so với tháng trước. Hãy cân nhắc nấu ăn tại nhà cuối tuần này để cân bằng ngân sách.</p>
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                <span>Tiết kiệm tiềm năng</span>
                <span class="text-tertiary">{{ Auth::check() ? '3.600.000' : '0' }} VNĐ</span>
            </div>
        </div>
        <!-- Advice Card 2 -->
        <div class="bg-surface-container-lowest p-8 rounded-full border-none shadow-sm group hover:bg-surface-container-low transition-all">
            <div class="w-10 h-10 rounded-full bg-secondary-fixed text-secondary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined" data-icon="electric_bolt" style="font-variation-settings: 'FILL' 1;">electric_bolt</span>
            </div>
            <h4 class="font-bold text-lg mb-3">Tối ưu hóa tiện ích</h4>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">Hóa đơn năng lượng của bạn đã tăng liên tục trong 3 tháng. Chuyển sang 'Gói Thông minh' với nhà cung cấp hiện tại có thể giúp bạn tiết kiệm chi phí đáng kể.</p>
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                <span>ROI dự kiến</span>
                <span class="text-secondary">{{ Auth::check() ? '8.2% năm' : '0%' }}</span>
            </div>
        </div>
        <!-- Advice Card 3 -->
        <div class="bg-surface-container-lowest p-8 rounded-full border-none shadow-sm group hover:bg-surface-container-low transition-all">
            <div class="w-10 h-10 rounded-full bg-primary-fixed text-primary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined" data-icon="subscriptions" style="font-variation-settings: 'FILL' 1;">subscriptions</span>
            </div>
            <h4 class="font-bold text-lg mb-3">Kiểm tra đăng ký</h4>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">Chúng tôi phát hiện 3 dịch vụ phát trực tuyến không được sử dụng trong 30 ngày qua. Hãy hủy chúng để giải phóng vốn cho 'Quỹ Khẩn cấp'.</p>
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                <span>Số tiền tăng thêm mỗi tháng</span>
                <span class="text-primary">{{ Auth::check() ? '1.100.000' : '0' }} VNĐ</span>
            </div>
        </div>
    </section>

    <!-- Anomaly Detection Section -->
    <section class="bg-surface-container-low rounded-[2rem] p-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-tertiary" data-icon="warning">warning</span>
                    <h3 class="text-2xl font-bold headline">Phát hiện bất thường</h3>
                </div>
                <p class="text-slate-500 text-sm">Theo dõi thời gian thực các mẫu chi tiêu bất thường hoặc các khoản phí trùng lặp.</p>
            </div>
            <div class="flex gap-2">
                <span class="px-4 py-2 bg-tertiary-container text-white text-xs font-bold rounded-full">2 Ưu tiên cao</span>
                <span class="px-4 py-2 bg-surface-container-high text-on-surface-variant text-xs font-bold rounded-full">1 Trùng lặp tiềm ẩn</span>
            </div>
        </div>
        <div class="space-y-4">
            <!-- Anomaly Item 1 -->
            <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all">
                <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                    <img alt="Logo nhà bán hàng" class="w-8 h-8 rounded-lg object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAf4Qz1rpbxN8SaEBsylB_nwt3MBjvFNzQ4_guhXoM8ozUHWAbvyIJytPH6tmGzehzt9bhYny4-1k7McsK_GOuuU66kbvXBCo5ekB9-kKESWfUWz6WvYinNPlyEUwG0EmpK3glEADJEF3tNMGbkys50pnsLq073GjC8le6ug6ItQkDbj0-aOBqWffkEnw8oII6yjpbshTCokrXsdYwwm0HzgMjiblbRa3wFjfl4ISnDyDbykNH05cZHms1iBPW7Jw88gHPZSy060x0"/>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-bold">CloudStorage Pro</h5>
                        <span class="text-[10px] bg-tertiary/10 text-tertiary px-2 py-0.5 rounded-full font-bold">SỐ TIỀN BẤT THƯỜNG</span>
                    </div>
                    <p class="text-sm text-slate-500">Giao dịch này cao hơn 300% so với hóa đơn hàng tháng trung bình của bạn (250.000 VNĐ).</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold headline tabular-nums">{{ Auth::check() ? '1.000.000' : '0' }} VNĐ</p>
                    <p class="text-xs text-slate-400">24 Tháng 10, 2023</p>
                </div>
                <div class="flex gap-2 ml-4">
                    <button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
                    </button>
                    <button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-tertiary transition-colors">
                        <span class="material-symbols-outlined" data-icon="flag">flag</span>
                    </button>
                </div>
            </div>
            <!-- Anomaly Item 2 -->
            <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all">
                <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center shrink-0 text-slate-400">
                    <span class="material-symbols-outlined text-3xl" data-icon="shopping_bag">shopping_bag</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-bold">Apple Store London</h5>
                        <span class="text-[10px] bg-tertiary/10 text-tertiary px-2 py-0.5 rounded-full font-bold">BẤT THƯỜNG VỊ TRÍ</span>
                    </div>
                    <p class="text-sm text-slate-500">Mua hàng lần đầu tại địa điểm này. Có phải là bạn không?</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold headline tabular-nums">{{ Auth::check() ? '32.500.000' : '0' }} VNĐ</p>
                    <p class="text-xs text-slate-400">23 Tháng 10, 2023</p>
                </div>
                <div class="flex gap-2 ml-4">
                    <button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
                    </button>
                    <button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-tertiary transition-colors">
                        <span class="material-symbols-outlined" data-icon="report">report</span>
                    </button>
                </div>
            </div>
            <!-- Anomaly Item 3 -->
            <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all border border-dashed border-primary/20">
                <div class="w-14 h-14 bg-primary/5 rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary" data-icon="content_copy">content_copy</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-bold">Gói đăng ký Netflix</h5>
                        <span class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">TRÙNG LẶP TIỀM ẨN</span>
                    </div>
                    <p class="text-sm text-slate-500">Phát hiện hai khoản phí giống hệt nhau trong vòng 24 giờ. Hãy kiểm tra lỗi thanh toán.</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-extrabold headline tabular-nums">{{ Auth::check() ? '400.000' : '0' }} VNĐ</p>
                    <p class="text-xs text-slate-400">22 Tháng 10, 2023</p>
                </div>
                <div class="flex gap-2 ml-4">
                    <button class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-full hover:opacity-90 transition-opacity">
                        Giải quyết
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection