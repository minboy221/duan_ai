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
                        <span class="text-2xl font-bold tabular-nums text-primary">{{ $percentages['lifestyle'] }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-primary-container rounded-full w-[{{ $percentages['lifestyle'] }}%]"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Chi phí cố định & Tiện ích</span>
                        <span class="text-2xl font-bold tabular-nums text-secondary">{{ $percentages['fixed'] }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-secondary to-secondary-container rounded-full w-[{{ $percentages['fixed'] }}%]"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Tiết kiệm & Đầu tư</span>
                        <span class="text-2xl font-bold tabular-nums text-tertiary">{{ $percentages['savings'] }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-tertiary to-tertiary-container rounded-full w-[{{ $percentages['savings'] }}%]"></div>
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
                <p class="text-indigo-100/80 leading-relaxed mb-6">Dựa trên quỹ đạo hiện tại, bạn dự kiến sẽ có số dư ròng cuối tháng khoảng <span class="text-white font-bold">{{ number_format($projectedSavings, 0, ',', '.') }} VNĐ</span>.</p>
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
        <button id="btnRefreshAnalysis" class="text-sm font-bold text-primary flex items-center gap-1 group">
            Cập nhật phân tích 
            <span class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform" data-icon="refresh">refresh</span>
        </button>
    </div>
    <section class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-12">
        <!-- AI Advice Content -->
        <div class="bg-surface-container-lowest p-8 rounded-3xl border-none shadow-sm group hover:bg-surface-container-low transition-all">
            <div class="w-10 h-10 rounded-full bg-primary-fixed text-primary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined" data-icon="auto_awesome" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
            </div>
            <h4 class="font-bold text-xl mb-4">Lời khuyên chuyên sâu từ Curator AI</h4>
            <div class="text-slate-600 text-sm leading-loose prose max-w-none prose-sm">
                @if($latestAi)
                    {!! nl2br(e($latestAi->noi_dung)) !!}
                @else
                    <p class="italic text-outline">Chưa có bản phân tích nào gần đây. Hãy nhấn nút "Cập nhật phân tích" hoặc sử dụng chức năng phân tích tại Dashboard để AI có thể đánh giá chi tiết cho bạn.</p>
                @endif
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
            @forelse($anomalies as $anomaly)
                <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all">
                    <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-outline text-3xl">{{ $anomaly['icon'] }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h5 class="font-bold">{{ $anomaly['title'] }}</h5>
                            <span class="text-[10px] bg-tertiary/10 text-tertiary px-2 py-0.5 rounded-full font-bold uppercase">{{ $anomaly['reason'] }}</span>
                        </div>
                        <p class="text-sm text-slate-500">{{ $anomaly['detail'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-extrabold headline tabular-nums text-tertiary">{{ number_format($anomaly['amount'], 0, ',', '.') }} VNĐ</p>
                        <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($anomaly['date'])->format('d/m/Y') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-surface-container-lowest rounded-xl">
                    <p class="text-sm text-outline italic">Curator AI chưa phát hiện bất thường nào trong chi tiêu của bạn. Tuyệt vời!</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('btnRefreshAnalysis')?.addEventListener('click', async function() {
        const btn = this;
        const icon = btn.querySelector('.material-symbols-outlined');
        
        // Loading state
        btn.disabled = true;
        icon.classList.add('animate-spin');
        btn.querySelector('span:not(.material-symbols-outlined)').innerText = 'Đang phân tích...';

        try {
            const response = await fetch('{{ route("ai.phan_tich") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ days: 30 })
            });

            const result = await response.json();
            if (result.success) {
                // Refresh page to show new results
                location.reload();
            } else {
                alert('Lỗi: ' + result.message);
            }
        } catch (error) {
            alert('Có lỗi xảy ra: ' + error.message);
        } finally {
            btn.disabled = false;
            icon.classList.remove('animate-spin');
        }
    });
</script>
@endsection