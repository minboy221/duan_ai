@extends('layouts.app')

@section('title', 'Tổng quan - The Fiscal Curator')

@section('content')

<!-- Welcome Modal -->
<div id="welcomeModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-surface-container-lowest rounded-3xl p-8 md:p-10 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300" id="modalContent">
        <div class="absolute top-0 right-0 p-4">
            <button id="closeModalIconBtn" class="text-outline hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6 mx-auto">
            <span class="material-symbols-outlined text-4xl" data-icon="auto_awesome">auto_awesome</span>
        </div>
        <h3 class="text-2xl font-headline font-extrabold text-center mb-3">Trung tâm Trợ giúp AI</h3>
        <p class="text-on-surface-variant text-center mb-8 leading-relaxed">Để tận dụng tối đa sức mạnh của <strong>The Fiscal Curator</strong>, hãy dành 1 phút xem qua sổ tay sử dụng các tính năng xịn sò của chúng tôi nhé!</p>
        
        <div class="flex flex-col gap-3">
            <a href="{{ route('huongdan') }}" class="w-full py-4 bg-gradient-to-r from-primary to-primary-container text-white rounded-xl font-bold text-center shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:scale-[1.02] active:scale-[0.98] transition-all">
                Đọc Hướng Dẫn Ngay
            </a>
            <button id="closeModalBtn" class="w-full py-4 bg-transparent border border-outline-variant text-on-surface-variant font-bold rounded-xl text-center hover:bg-surface-container hover:text-on-surface transition-all">
                Bỏ qua
            </button>
        </div>
    </div>
</div>

<!-- Dashboard Canvas -->
<div class="max-w-7xl mx-auto">
    <!-- Hero Balance & Editorial Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 items-end">
        <div class="lg:col-span-7">
            <span class="text-sm font-semibold text-primary/60 uppercase tracking-widest mb-2 block">Vốn khả dụng</span>
            <h2 class="text-6xl font-extrabold tracking-tighter text-on-surface tabular-nums text-left">
                {{ number_format($availableBalance, 0, ',', '.') }}<span class="text-primary/30 text-4xl ml-2 text-primary">VNĐ</span>
            </h2>
            <div class="flex gap-8 mt-6">
                <div>
                    <p class="text-xs text-outline mb-1 text-left">Thu nhập tháng</p>
                    <p class="text-xl font-bold text-secondary tabular-nums">+{{ number_format($monthlyIncome, 0, ',', '.') }} VNĐ</p>
                </div>
                <div class="h-10 w-[1px] bg-outline-variant/20 self-center"></div>
                <div>
                    <p class="text-xs text-outline mb-1 text-left">Chi tiêu vận hành</p>
                    <p class="text-xl font-bold text-tertiary tabular-nums">-{{ number_format($monthlyExpense, 0, ',', '.') }} VNĐ</p>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 flex justify-end">
            <div class="bg-surface-container-lowest p-6 rounded-full border border-outline-variant/10 shadow-sm flex items-center gap-6">
                <div class="text-right">
                    <p class="text-[10px] text-outline font-bold uppercase tracking-wider">Tỷ lệ tiết kiệm</p>
                    <p class="text-2xl font-bold text-primary">{{ $savingsRate }}%</p>
                </div>
                <div class="relative w-16 h-16">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle class="text-surface-container-high" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-width="4"></circle>
                        <circle class="text-secondary" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-dasharray="175.9" stroke-dashoffset="{{ 175.9 - (175.9 * $savingsRate / 100) }}" stroke-width="4" style="transition: stroke-dashoffset 1s ease-in-out;"></circle>
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
        <!-- Chart: Performance Matrix -->
        <div class="md:col-span-2 bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold">Ma trận Hiệu suất</h3>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-secondary"></span>
                        <span class="text-xs text-outline font-medium">Thu nhập</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-tertiary"></span>
                        <span class="text-xs text-outline font-medium">Chi phí</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 w-full relative" style="min-height: 250px;">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Allocation Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm">
            <h3 class="text-lg font-bold mb-8">Phân bổ</h3>
            <div class="relative w-48 h-48 mx-auto mb-8">
                <canvas id="allocationChart"></canvas>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="text-center">
                        <p class="text-[10px] text-outline uppercase font-bold tracking-wider">HẠN MỨC</p>
                        <p class="text-xs font-bold">{{ $categoryData->first()->danhMuc->ten_danh_muc ?? 'Chưa có' }}</p>
                    </div>
                </div>
            </div>
            <div class="space-y-3 mt-6">
                @php $colors = ['#24389c', '#006c49', '#8a0027', '#4355b9', '#00714d', '#ffdad6', '#dee0ff']; @endphp
                @forelse($categoryData->take(4) as $index => $item)
                    <div class="flex justify-between items-center text-sm">
                        <span class="flex items-center gap-2 text-outline">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $colors[$index % count($colors)] }}"></span>
                            {{ $item->danhMuc->ten_danh_muc }}
                        </span>
                        <span class="font-semibold tabular-nums">{{ number_format($item->total, 0, ',', '.') }} VNĐ</span>
                    </div>
                @empty
                    <p class="text-xs text-outline italic text-center py-4">Chưa có dữ liệu phân bổ trong tháng.</p>
                @endforelse
            </div>
        </div>

        <!-- Audit Log (Recent Activity) -->
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-bold">Nhật ký Kiểm toán</h3>
                <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-primary hover:underline">Xem tất cả</a>
            </div>
            <div class="space-y-6">
                @forelse($recentActivity as $activity)
                    <div class="flex items-center justify-between group cursor-pointer text-left">
                        <div class="flex items-center gap-4 text-left">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $activity->type == 'thu' ? 'bg-secondary/10 text-secondary' : 'bg-tertiary/10 text-tertiary' }}">
                                <span class="material-symbols-outlined">{{ $activity->danhMuc->biu_tuong ?? ($activity->type == 'thu' ? 'payments' : 'shopping_cart') }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold group-hover:text-primary transition-colors text-left">
                                    {{ $activity->type == 'thu' ? $activity->nguon_thu : ($activity->ghi_chu ?: 'Chi tiêu') }}
                                </p>
                                <p class="text-[10px] text-outline font-medium text-left">
                                    {{ $activity->danhMuc->ten_danh_muc ?? 'Chưa phân loại' }} · {{ Carbon\Carbon::parse($activity->date)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold {{ $activity->type == 'thu' ? 'text-secondary' : 'text-tertiary' }} tabular-nums">
                                {{ $activity->type == 'thu' ? '+' : '-' }}{{ number_format($activity->so_tien, 0, ',', '.') }} VNĐ
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-outline italic">Chưa có hoạt động nào gần đây.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Safe Vault Card -->
        <div class="bg-surface-container-highest rounded-2xl p-8 border border-outline-variant/10 shadow-sm flex flex-col justify-between group">
            <div class="text-left">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined" data-icon="shield">shield</span>
                </div>
                <h4 class="text-xl font-bold mb-2">Kho an toàn</h4>
                <p class="text-xs text-outline leading-relaxed mb-6">Lớp bảo vệ OTP siêu cấp cho tài sản tích luỹ của bạn.</p>
            </div>
            <a href="{{ route('kho-an-toan.auth') }}" class="w-full py-3 bg-primary text-on-primary font-extrabold rounded-xl text-sm shadow-xl active:scale-95 transition-all hover:shadow-primary/40 text-center">
                Truy cập ngay
            </a>
        </div>

        <!-- AI Insights Card -->
        <div class="bg-primary text-on-primary rounded-2xl p-8 relative overflow-hidden flex flex-col justify-between shadow-xl">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 text-left">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-lg flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                </div>
                <h4 class="text-xl font-bold mb-4">Gợi ý từ Curator AI</h4>
                @if($savingsRate < 20 && $monthlyIncome > 0)
                    <p class="text-sm text-on-primary/80 leading-relaxed mb-6">
                        Tỷ lệ tiết kiệm tháng này của bạn đang ở mức <span class="font-bold text-white">{{ $savingsRate }}%</span>. 
                        Hãy thử cắt giảm 10% chi tiêu cho <span class="font-bold text-white">{{ $categoryData->first()->danhMuc->ten_danh_muc ?? 'các danh mục' }}</span> để tối ưu hoá ngân sách.
                    </p>
                @elseif($savingsRate >= 20)
                    <p class="text-sm text-on-primary/80 leading-relaxed mb-6">
                        Tuyệt vời! Bạn đã tiết kiệm được <span class="font-bold text-white">{{ $savingsRate }}%</span> thu nhập. 
                        Bạn có muốn thiết lập một biểu đồ mục tiêu tích luỹ mới cho kỳ nghỉ tiếp theo không?
                    </p>
                @else
                    <p class="text-sm text-on-primary/80 leading-relaxed mb-6">
                        Bắt đầu ghi lại các giao dịch của bạn để Curator AI có thể phân tích và đưa ra những gợi ý tài chính thông minh nhất cho bạn.
                    </p>
                @endif
            </div>
            <button class="relative z-10 w-full py-3 bg-white text-primary font-extrabold rounded-xl text-sm shadow-xl active:scale-95 transition-all hover:bg-surface-container-low">
                Xem Phân tích Chi tiết
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Modal Logic ---
        const modal = document.getElementById('welcomeModal');
        const modalContent = document.getElementById('modalContent');
        const closeBtn = document.getElementById('closeModalBtn');
        const closeIconBtn = document.getElementById('closeModalIconBtn');
        
        if (modal && !localStorage.getItem('hasSeenGuidePopup')) {
            setTimeout(() => {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                if(modalContent) {
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }
            }, 600);
        }

        const closeModal = function() {
            if(modal) modal.classList.add('opacity-0', 'pointer-events-none');
            if(modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
            localStorage.setItem('hasSeenGuidePopup', 'true');
        };

        if(closeBtn) closeBtn.addEventListener('click', closeModal);
        if(closeIconBtn) closeIconBtn.addEventListener('click', closeModal);

        // --- Charts ---
        const perfCtx = document.getElementById('performanceChart')?.getContext('2d');
        if (perfCtx) {
            new Chart(perfCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($days) !!},
                    datasets: [
                        {
                            label: 'Thu nhập',
                            data: {!! json_encode($incomeTrends) !!},
                            borderColor: '#006c49',
                            backgroundColor: 'rgba(0, 108, 73, 0.05)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#006c49',
                            pointRadius: 4
                        },
                        {
                            label: 'Chi phí',
                            data: {!! json_encode($expenseTrends) !!},
                            borderColor: '#8a0027',
                            backgroundColor: 'rgba(138, 0, 39, 0.05)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#8a0027',
                            pointRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#131b2e', padding: 12 }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#757684' } },
                        y: { 
                            grid: { color: 'rgba(117, 118, 132, 0.1)', borderDash: [4, 4] },
                            ticks: { font: { size: 10 }, color: '#757684', callback: (value) => (value / 1000000) + 'M' }
                        }
                    }
                }
            });
        }

        const allocCtx = document.getElementById('allocationChart')?.getContext('2d');
        if (allocCtx) {
            new Chart(allocCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoryData->pluck('danhMuc.ten_danh_muc')->toArray()) !!},
                    datasets: [{
                        data: {!! json_encode($categoryData->pluck('total')->toArray()) !!},
                        backgroundColor: ['#24389c', '#006c49', '#8a0027', '#4355b9', '#00714d', '#ffdad6', '#dee0ff'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#131b2e', padding: 12 }
                    }
                }
            });
        }
    });
</script>
@endsection