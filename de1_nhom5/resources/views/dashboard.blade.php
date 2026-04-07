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

        <!-- Chart: Expense Comparison -->
        <div class="md:col-span-2 lg:col-span-3 bg-surface-container-lowest rounded-2xl p-8 border border-outline-variant/10 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold">Biến động Chi tiêu</h3>
                    <p class="text-xs text-outline mt-1">So sánh mức chi tiêu mỗi ngày giữa tháng này và tháng trước</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-tertiary"></span>
                        <span class="text-xs text-outline font-medium">Tháng này</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-outline-variant/60"></span>
                        <span class="text-xs text-outline font-medium">Tháng trước</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 w-full relative" style="min-height: 250px;">
                <canvas id="comparisonChart"></canvas>
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
                                <span class="material-symbols-outlined">{{ $activity->danhMuc->bieu_tuong ?? ($activity->type == 'thu' ? 'payments' : 'shopping_cart') }}</span>
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

        <!-- AI Curator Chat Panel -->
        <div class="md:col-span-2 lg:col-span-3 bg-gradient-to-br from-primary via-primary-container to-primary rounded-2xl p-1 shadow-2xl shadow-primary/20" id="aiChatPanel">
            <div class="bg-surface-container-lowest/95 backdrop-blur-xl rounded-[14px] overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary to-primary-container p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl animate-pulse">auto_awesome</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Curator AI — Trợ lý Tài chính</h4>
                                <p class="text-sm text-white/70">Hỏi bất kỳ điều gì về tài chính của bạn</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button id="btnAnalyzeAi" class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">analytics</span>
                                Phân tích tự động
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Content Area -->
                <div id="aiChatContent" class="p-6 max-h-[400px] overflow-y-auto space-y-4" style="scroll-behavior: smooth;">
                    <!-- Default Welcome -->
                    <div class="flex gap-3" id="aiWelcomeMsg">
                        <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0 mt-1">
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        </div>
                        <div class="flex-1">
                            @if($savingsRate < 20 && $monthlyIncome > 0)
                                <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed">
                                    <p class="mb-2">Xin chào! Tỷ lệ tiết kiệm tháng này của bạn đang ở mức <strong class="text-primary">{{ $savingsRate }}%</strong>.</p>
                                    <p>Hãy thử hỏi tôi: <em>"Làm sao để tiết kiệm nhiều hơn?"</em> hoặc nhấn <strong>Phân tích tự động</strong> để tôi đánh giá chi tiết.</p>
                                </div>
                            @elseif($savingsRate >= 20)
                                <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed">
                                    <p class="mb-2">Tuyệt vời! 🎉 Bạn đã tiết kiệm được <strong class="text-secondary">{{ $savingsRate }}%</strong> thu nhập tháng này.</p>
                                    <p>Hãy hỏi tôi bất kỳ câu hỏi nào về tài chính, ví dụ: <em>"Tôi nên đầu tư vào đâu?"</em></p>
                                </div>
                            @else
                                <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed">
                                    <p class="mb-2">Chào bạn! Tôi là <strong class="text-primary">Curator AI</strong> — trợ lý tài chính cá nhân của bạn. 👋</p>
                                    <p>Hãy bắt đầu ghi lại giao dịch và đặt câu hỏi cho tôi để nhận được những gợi ý thông minh nhất!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Suggested Questions -->
                <div class="px-6 pb-3">
                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2" id="suggestedQuestions">
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">💰 Tôi chi tiêu nhiều nhất vào đâu?</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">📊 Phân tích thói quen chi tiêu</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">💡 Gợi ý tiết kiệm cho tôi</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">📈 Dự báo tài chính cuối tháng</button>
                    </div>
                </div>

                <!-- Input Bar -->
                <div class="p-4 border-t border-outline-variant/10 bg-surface-container-lowest">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 relative">
                            <input type="text" id="aiPromptInput" 
                                placeholder="Hỏi Curator AI bất kỳ điều gì về tài chính..." 
                                class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 pr-12 focus:ring-2 focus:ring-primary text-sm font-medium transition-all">
                            <button id="btnSendPrompt" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center hover:bg-primary/90 transition-all hover:scale-105 active:scale-95">
                                <span class="material-symbols-outlined text-sm">send</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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

        // --- AI Chat Logic ---
        const chatContent = document.getElementById('aiChatContent');
        const promptInput = document.getElementById('aiPromptInput');
        const btnSendPrompt = document.getElementById('btnSendPrompt');
        const btnAnalyzeAi = document.getElementById('btnAnalyzeAi');

        // Simple markdown to HTML renderer
        function renderMarkdown(text) {
            if (typeof marked !== 'undefined') {
                return marked.parse(text);
            }
            // Fallback basic markdown
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/\n/g, '<br>');
        }

        function addUserBubble(text) {
            const bubble = document.createElement('div');
            bubble.className = 'flex gap-3 justify-end animate-fade-in';
            bubble.innerHTML = `
                <div class="max-w-[80%]">
                    <div class="bg-primary text-white rounded-2xl rounded-tr-md p-4 text-sm leading-relaxed">
                        ${text}
                    </div>
                </div>
                <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-sm">person</span>
                </div>
            `;
            chatContent.appendChild(bubble);
            chatContent.scrollTop = chatContent.scrollHeight;
        }

        function addAiBubble(htmlContent) {
            const bubble = document.createElement('div');
            bubble.className = 'flex gap-3 animate-fade-in';
            bubble.innerHTML = `
                <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                </div>
                <div class="flex-1 max-w-[85%]">
                    <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed prose prose-sm max-w-none prose-headings:text-on-surface prose-strong:text-primary">
                        ${htmlContent}
                    </div>
                </div>
            `;
            chatContent.appendChild(bubble);
            chatContent.scrollTop = chatContent.scrollHeight;
        }

        function addTypingIndicator() {
            const indicator = document.createElement('div');
            indicator.id = 'typingIndicator';
            indicator.className = 'flex gap-3 animate-fade-in';
            indicator.innerHTML = `
                <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-sm animate-pulse">auto_awesome</span>
                </div>
                <div class="flex-1">
                    <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 bg-primary/40 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                                <span class="w-2 h-2 bg-primary/40 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                                <span class="w-2 h-2 bg-primary/40 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                            </div>
                            <span class="text-xs text-outline font-medium">Curator AI đang suy nghĩ...</span>
                        </div>
                    </div>
                </div>
            `;
            chatContent.appendChild(indicator);
            chatContent.scrollTop = chatContent.scrollHeight;
        }

        function removeTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) indicator.remove();
        }

        function addErrorBubble(message) {
            const bubble = document.createElement('div');
            bubble.className = 'flex gap-3 animate-fade-in';
            bubble.innerHTML = `
                <div class="w-8 h-8 bg-error/10 text-error rounded-lg flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-sm">warning</span>
                </div>
                <div class="flex-1">
                    <div class="bg-error-container/50 rounded-2xl rounded-tl-md p-4 text-sm text-on-error-container leading-relaxed">
                        ${message}
                    </div>
                </div>
            `;
            chatContent.appendChild(bubble);
            chatContent.scrollTop = chatContent.scrollHeight;
        }

        // Send custom prompt
        async function sendPrompt(text) {
            if (!text.trim()) return;
            
            addUserBubble(text);
            promptInput.value = '';
            addTypingIndicator();

            try {
                const response = await fetch('{{ route("ai.hoi_dap") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ prompt: text })
                });

                const result = await response.json();
                removeTypingIndicator();

                if (result.success) {
                    const html = renderMarkdown(result.data.answer);
                    addAiBubble(html);
                } else {
                    addErrorBubble(result.message || 'Có lỗi xảy ra, vui lòng thử lại.');
                }
            } catch (error) {
                removeTypingIndicator();
                addErrorBubble('Có lỗi kết nối. Vui lòng thử lại sau.');
            }
        }

        if (btnSendPrompt) {
            btnSendPrompt.addEventListener('click', () => sendPrompt(promptInput.value));
        }
        if (promptInput) {
            promptInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendPrompt(promptInput.value);
            });
        }

        // Suggested questions
        window.askSuggestion = function(btn) {
            const text = btn.innerText.replace(/^[^\s]+\s/, ''); // Remove emoji prefix
            sendPrompt(text);
        };

        // Auto analyze button
        if (btnAnalyzeAi) {
            btnAnalyzeAi.addEventListener('click', async function() {
                const originalBtnText = btnAnalyzeAi.innerHTML;
                btnAnalyzeAi.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Đang phân tích...';
                btnAnalyzeAi.disabled = true;
                
                addTypingIndicator();

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
                    removeTypingIndicator();
                    
                    if (result.success) {
                        const html = renderMarkdown(result.data.analysis);
                        addAiBubble(html);
                        
                        btnAnalyzeAi.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> Hoàn tất';
                        setTimeout(() => {
                            btnAnalyzeAi.innerHTML = originalBtnText;
                            btnAnalyzeAi.disabled = false;
                        }, 3000);
                    } else {
                        addErrorBubble(result.message || 'Có lỗi xảy ra');
                        btnAnalyzeAi.innerHTML = originalBtnText;
                        btnAnalyzeAi.disabled = false;
                    }
                } catch (error) {
                    removeTypingIndicator();
                    addErrorBubble('Lỗi: ' + error.message);
                    btnAnalyzeAi.innerHTML = originalBtnText;
                    btnAnalyzeAi.disabled = false;
                }
            });
        }

        // --- AI Quick Input Logic ---
        const aiQuickInput = document.getElementById('aiQuickInput');
        const btnAiSubmit = document.getElementById('btnAiSubmit');
        const aiInputStatus = document.getElementById('aiInputStatus');

        async function handleAiInput() {
            const val = aiQuickInput.value.trim();
            if (!val) return;

            // Loading state
            btnAiSubmit.disabled = true;
            btnAiSubmit.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span>';
            aiInputStatus.classList.remove('hidden', 'text-error', 'text-secondary');
            aiInputStatus.classList.add('text-primary');
            aiInputStatus.innerText = 'AI đang xử lý...';

            try {
                const response = await fetch('{{ route("ai.nhap_lieu") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ input: val })
                });

                const result = await response.json();

                if (result.success) {
                    aiInputStatus.classList.replace('text-primary', 'text-secondary');
                    aiInputStatus.innerText = '✓ ' + result.message;
                    aiQuickInput.value = '';
                    
                    // Optional: Refresh some dashboard stats or just reload after a delay
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                aiInputStatus.classList.replace('text-primary', 'text-error');
                aiInputStatus.innerText = '✕ ' + error.message;
            } finally {
                btnAiSubmit.disabled = false;
                btnAiSubmit.innerHTML = '<span class="material-symbols-outlined text-sm">send</span>';
            }
        }

        if (btnAiSubmit) btnAiSubmit.addEventListener('click', handleAiInput);
        if (aiQuickInput) {
            aiQuickInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') handleAiInput();
            });
        }

        // --- Comparison Chart ---
        const compCtx = document.getElementById('comparisonChart')?.getContext('2d');
        if (compCtx) {
            new Chart(compCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthDaysLabels) !!},
                    datasets: [
                        {
                            label: 'Tháng này',
                            data: {!! json_encode($thisMonthValues) !!},
                            borderColor: '#8a0027',
                            backgroundColor: 'rgba(138, 0, 39, 0.05)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#8a0027',
                            pointRadius: 3
                        },
                        {
                            label: 'Tháng trước',
                            data: {!! json_encode($lastMonthValues) !!},
                            borderColor: '#cbd5e1',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.4,
                            fill: false,
                            pointBackgroundColor: '#cbd5e1',
                            pointRadius: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { 
                            backgroundColor: '#131b2e', 
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
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
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
    .prose h1, .prose h2, .prose h3 { margin-top: 0.5em; margin-bottom: 0.25em; }
    .prose p { margin-top: 0.25em; margin-bottom: 0.25em; }
    .prose ul, .prose ol { margin-top: 0.25em; margin-bottom: 0.25em; padding-left: 1.5em; }
    .prose li { margin-top: 0.1em; margin-bottom: 0.1em; }
</style>
@endsection