@extends('layouts.app')

@section('title', 'Phân tích AI - The Fiscal Curator')

@section('content')
<!-- Main Content -->
<div class="pb-12 min-h-screen">
    <!-- Hero Section: Editorial Spending Habits -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
        <div class="lg:col-span-7 bg-surface-container-lowest rounded-3xl p-10 flex flex-col justify-center relative overflow-hidden group">
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
                        <div class="h-full bg-gradient-to-r from-primary to-primary-container rounded-full transition-all duration-1000" style="width: {{ $percentages['lifestyle'] }}%"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Chi phí cố định & Tiện ích</span>
                        <span class="text-2xl font-bold tabular-nums text-secondary">{{ $percentages['fixed'] }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-secondary to-secondary-container rounded-full transition-all duration-1000" style="width: {{ $percentages['fixed'] }}%"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Tiết kiệm & Đầu tư</span>
                        <span class="text-2xl font-bold tabular-nums text-tertiary">{{ $percentages['savings'] }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-tertiary to-tertiary-container rounded-full transition-all duration-1000" style="width: {{ $percentages['savings'] }}%"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-lg font-semibold">Phát sinh & Khác</span>
                        <span class="text-2xl font-bold tabular-nums text-outline">{{ $percentages['other'] }}%</span>
                    </div>
                    <div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-outline to-outline-variant rounded-full transition-all duration-1000" style="width: {{ $percentages['other'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 bg-primary rounded-3xl p-10 text-on-primary flex flex-col justify-between shadow-2xl relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
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
            <button id="btnGenerateReport" class="relative z-10 mt-8 w-full py-4 bg-white text-primary font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-lg active:scale-[0.98]">
                Tạo báo cáo đầy đủ
            </button>
        </div>
    </section>

    <!-- AI Chat Section -->
    <section class="mb-12">
        <div class="bg-gradient-to-br from-primary via-primary-container to-primary rounded-2xl p-1 shadow-2xl shadow-primary/20">
            <div class="bg-surface-container-lowest/95 backdrop-blur-xl rounded-[14px] overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary to-primary-container p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl animate-pulse">auto_awesome</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Curator AI — Phân tích Chuyên sâu</h4>
                                <p class="text-sm text-white/70">Hỏi AI về thói quen chi tiêu và nhận gợi ý tối ưu hóa tài chính</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button id="btnRefreshAnalysis" class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">analytics</span>
                                Phân tích tự động
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Chat Content Area -->
                <div id="aiChatContent" class="p-6 max-h-[500px] overflow-y-auto space-y-4" style="scroll-behavior: smooth;">
                    <!-- Show latest AI analysis if exists -->
                    @if($latestAi)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0 mt-1">
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        </div>
                        <div class="flex-1">
                            <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed">
                                <div class="flex items-center gap-2 mb-3 text-xs text-outline">
                                    <span class="material-symbols-outlined text-xs">schedule</span>
                                    {{ \Carbon\Carbon::parse($latestAi->ngay_tao)->diffForHumans() }}
                                </div>
                                <div class="prose prose-sm max-w-none" id="latestAiContent">
                                    {!! nl2br(e($latestAi->noi_dung)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="flex gap-3" id="aiWelcomeMsg">
                        <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0 mt-1">
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        </div>
                        <div class="flex-1">
                            <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed">
                                <p class="mb-2">Chào bạn! Tôi là <strong class="text-primary">Curator AI</strong> 👋</p>
                                <p>Chưa có bản phân tích nào gần đây. Hãy nhấn nút <strong>"Phân tích tự động"</strong> hoặc nhập câu hỏi bên dưới để tôi đánh giá chi tiết thói quen chi tiêu của bạn.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Suggested Questions -->
                <div class="px-6 pb-3">
                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2">
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">📊 Phân tích chi tiết 30 ngày qua</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">💡 Gợi ý cắt giảm chi tiêu</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">🏦 Lập kế hoạch tiết kiệm</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">📈 So sánh chi tiêu tháng này vs tháng trước</button>
                        <button onclick="askSuggestion(this)" class="shrink-0 px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-xs font-semibold rounded-full transition-all border border-primary/10">🎯 Đặt mục tiêu tài chính</button>
                    </div>
                </div>

                <!-- Input Bar -->
                <div class="p-4 border-t border-outline-variant/10 bg-surface-container-lowest">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 relative">
                            <input type="text" id="aiPromptInput" 
                                placeholder="Hỏi Curator AI bất kỳ điều gì về tài chính của bạn..." 
                                class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 pr-12 focus:ring-2 focus:ring-primary text-sm font-medium transition-all">
                            <button id="btnSendPrompt" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center hover:bg-primary/90 transition-all hover:scale-105 active:scale-95">
                                <span class="material-symbols-outlined text-sm">send</span>
                            </button>
                        </div>
                    </div>
                </div>
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
            @if(count($anomalies) > 0)
            <div class="flex gap-2">
                <span class="px-4 py-2 bg-tertiary-container text-white text-xs font-bold rounded-full">{{ count($anomalies) }} Phát hiện</span>
            </div>
            @endif
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
                    <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">verified</span>
                    </div>
                    <p class="text-sm text-outline font-medium">Curator AI chưa phát hiện bất thường nào trong chi tiêu của bạn. Tuyệt vời!</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatContent = document.getElementById('aiChatContent');
        const promptInput = document.getElementById('aiPromptInput');
        const btnSendPrompt = document.getElementById('btnSendPrompt');
        const btnRefreshAnalysis = document.getElementById('btnRefreshAnalysis');
        const btnGenerateReport = document.getElementById('btnGenerateReport');

        // Markdown renderer
        function renderMarkdown(text) {
            if (typeof marked !== 'undefined') {
                return marked.parse(text);
            }
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
                    <div class="bg-surface-container-low rounded-2xl rounded-tl-md p-4 text-sm text-on-surface leading-relaxed prose prose-sm max-w-none">
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
                            <span class="text-xs text-outline font-medium">Curator AI đang phân tích...</span>
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
            const text = btn.innerText.replace(/^[^\s]+\s/, '');
            sendPrompt(text);
        };

        // Auto analyze
        if (btnRefreshAnalysis) {
            btnRefreshAnalysis.addEventListener('click', async function() {
                const originalBtnText = btnRefreshAnalysis.innerHTML;
                btnRefreshAnalysis.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Đang phân tích...';
                btnRefreshAnalysis.disabled = true;
                
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
                        
                        btnRefreshAnalysis.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> Hoàn tất';
                        setTimeout(() => {
                            btnRefreshAnalysis.innerHTML = originalBtnText;
                            btnRefreshAnalysis.disabled = false;
                        }, 3000);
                    } else {
                        addErrorBubble(result.message || 'Có lỗi xảy ra');
                        btnRefreshAnalysis.innerHTML = originalBtnText;
                        btnRefreshAnalysis.disabled = false;
                    }
                } catch (error) {
                    removeTypingIndicator();
                    addErrorBubble('Lỗi: ' + error.message);
                    btnRefreshAnalysis.innerHTML = originalBtnText;
                    btnRefreshAnalysis.disabled = false;
                }
            });
        }

        // Generate report button
        if (btnGenerateReport) {
            btnGenerateReport.addEventListener('click', function() {
                sendPrompt('Hãy tạo một báo cáo tài chính đầy đủ cho tháng này, bao gồm: tổng quan thu chi, phân tích theo danh mục, phát hiện bất thường, dự báo cuối tháng và lời khuyên cải thiện.');
                // Scroll to chat
                document.getElementById('aiChatContent')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
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