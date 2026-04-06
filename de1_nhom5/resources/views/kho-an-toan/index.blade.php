@extends('layouts.app')

@section('title', 'Kho an toàn - The Fiscal Curator')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-12">
        <div class="text-left">
            <h2 class="text-4xl font-extrabold text-on-surface mb-2">Kho an toàn</h2>
            <p class="text-on-surface-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-sm text-secondary">verified_user</span>
                Bảo vệ tài sản của bạn với lớp bảo mật tăng cường.
            </p>
        </div>
        <form action="{{ route('kho-an-toan.lock') }}" method="POST">
            @csrf
            <button type="submit" class="p-4 bg-error/10 text-error rounded-full hover:bg-error/20 transition-all active:scale-95 flex items-center gap-2">
                <span class="material-symbols-outlined">lock_open</span>
                <span class="text-sm font-bold">Khóa kho</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Balance Cards -->
        <div class="lg:col-span-12 grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <!-- Safe Balance Card -->
            <div class="bg-gradient-to-br from-primary to-primary-container p-10 rounded-3xl shadow-xl shadow-primary/20 flex flex-col justify-between overflow-hidden relative group">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                <div class="relative z-10 text-left">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white" data-icon="shield">shield</span>
                        </div>
                        <span class="text-white/60 font-bold uppercase tracking-widest text-xs">Số dư trong kho</span>
                    </div>
                    <h3 class="text-5xl font-extrabold text-white tabular-nums mb-2">
                        {{ number_format($user->so_du_kho_an_toan, 0, ',', '.') }}<span class="text-white/30 text-2xl ml-2">VNĐ</span>
                    </h3>
                </div>
            </div>

            <!-- Main Balance Card -->
            <div class="bg-surface-container-lowest p-10 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col justify-between relative group">
                <div class="relative z-10 text-left">
                    <div class="flex items-center gap-3 mb-6 text-left">
                        <div class="w-10 h-10 bg-secondary/10 text-secondary rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                        <span class="text-outline font-bold uppercase tracking-widest text-xs text-left">Tài khoản chính</span>
                    </div>
                    <h3 class="text-5xl font-extrabold text-on-surface tabular-nums mb-2 text-left">
                        {{ number_format($availableBalance, 0, ',', '.') }}<span class="text-outline/30 text-2xl ml-2">VNĐ</span>
                    </h3>
                </div>
            </div>
        </div>

        <!-- Transfer Form -->
        <div class="lg:col-span-7 bg-surface-container-lowest rounded-3xl p-10 shadow-sm border border-outline-variant/5">
            <h3 class="text-2xl font-bold mb-8">Điều chuyển quỹ</h3>
            
            <form action="{{ route('kho-an-toan.transfer') }}" method="POST" class="space-y-8">
                @csrf
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-outline uppercase tracking-wider">Hình thức chuyển</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="to_safe" checked class="peer hidden">
                            <div class="p-6 rounded-2xl border-2 border-outline-variant/10 bg-surface-container-high transition-all peer-checked:border-primary peer-checked:bg-primary/5 group-hover:bg-surface-container-highest text-center flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-3xl text-primary transition-transform peer-checked:scale-110">arrow_circle_right</span>
                                <span class="text-sm font-bold">Chuyển vào Kho</span>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="from_safe" class="peer hidden">
                            <div class="p-6 rounded-2xl border-2 border-outline-variant/10 bg-surface-container-high transition-all peer-checked:border-secondary peer-checked:bg-secondary/5 group-hover:bg-surface-container-highest text-center flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-3xl text-secondary transition-transform peer-checked:scale-110">arrow_circle_left</span>
                                <span class="text-sm font-bold">Rút khỏi Kho</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-outline uppercase tracking-wider">Số tiền cần chuyển</label>
                    <div class="relative">
                        <input type="number" name="amount" placeholder="Ví dụ: 500000" min="1000" step="1000" 
                            class="w-full px-8 py-5 bg-surface-container rounded-3xl border-2 border-transparent focus:border-primary focus:bg-surface-container-lowest outline-none text-2xl font-bold tabular-nums text-primary transition-all"
                            required>
                        <span class="absolute right-8 top-1/2 -translate-y-1/2 font-extrabold text-outline/30 text-xl">VNĐ</span>
                    </div>
                </div>

                <button type="submit" class="w-full py-5 bg-primary text-on-primary rounded-2xl font-extrabold shadow-xl shadow-primary/20 hover:shadow-primary/40 active:scale-95 transition-all text-xl mt-6">
                    Xác nhận GD ngay
                </button>
            </form>
        </div>

        <!-- Info Card -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-primary/5 p-10 rounded-3xl border border-primary/10 flex flex-col justify-between h-full text-left">
                <div>
                    <h4 class="text-xl font-bold text-primary mb-6 text-left">Tại sao nên dùng Kho?</h4>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-primary bg-white p-2 rounded-lg text-sm">enhanced_encryption</span>
                            <p class="text-sm text-on-surface-variant leading-relaxed text-left">
                                <strong class="text-on-surface">Bảo mật kép:</strong> Chỉ truy cập được qua lớp xác thực OTP.
                            </p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-primary bg-white p-2 rounded-lg text-sm">savings</span>
                            <p class="text-sm text-on-surface-variant leading-relaxed text-left">
                                <strong class="text-on-surface">Tiết kiệm kỷ luật:</strong> Số tiền trong kho được ẩn khỏi thống kê thu chi thông thường, giúp bạn tránh chi tiêu lạm quỹ.
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="mt-8 pt-8 border-t border-primary/10">
                    <p class="text-[10px] uppercase font-extrabold tracking-widest text-primary/50 text-left italic">The Fiscal Curator Security Center</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 p-4 bg-secondary text-white rounded-2xl shadow-2xl flex items-center gap-3 z-50 animate-bounce">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    <script>setTimeout(() => document.getElementById('toast').remove(), 3000)</script>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed bottom-10 left-1/2 -translate-x-1/2 p-4 bg-error text-white rounded-2xl shadow-2xl flex items-center gap-3 z-50 animate-shake">
        <span class="material-symbols-outlined">error</span>
        <span class="font-bold">{{ session('error') }}</span>
    </div>
    <script>setTimeout(() => document.getElementById('toast-error').remove(), 3000)</script>
@endif
@endsection
