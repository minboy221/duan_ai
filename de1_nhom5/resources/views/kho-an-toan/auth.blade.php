@extends('layouts.app')

@section('title', 'Xác thực Kho an toàn - The Fiscal Curator')

@section('content')
<div class="max-w-md mx-auto mt-20">
    <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-2xl border border-outline-variant/10 text-center">
        <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-8 mx-auto">
            <span class="material-symbols-outlined text-4xl">lock</span>
        </div>
        
        <h2 class="text-3xl font-extrabold text-on-surface mb-2">Kho an toàn</h2>
        <p class="text-on-surface-variant mb-10 leading-relaxed px-4">Để tiếp tục, chúng tôi cần xác minh danh tính của bạn qua mã OTP gửi đến Email.</p>

        @if(session('success'))
            <div class="mb-6 p-4 bg-secondary/10 text-secondary rounded-xl text-sm font-bold flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-error/10 text-error rounded-xl text-sm font-bold flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                {{ session('error') }}
            </div>
        @endif

        @if(!session('success'))
            <form action="{{ route('kho-an-toan.send-otp') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-4 bg-primary text-on-primary rounded-2xl font-extrabold shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-95 transition-all">
                    Gửi mã OTP qua Email
                </button>
            </form>
        @else
            <form action="{{ route('kho-an-toan.verify') }}" method="POST" class="space-y-6">
                @csrf
                <div class="relative">
                    <input type="text" name="otp" maxlength="6" placeholder="Nhập 6 chữ số" 
                        class="w-full px-6 py-4 bg-surface-container rounded-2xl border-2 border-transparent focus:border-primary focus:bg-surface-container-lowest outline-none text-center text-3xl font-bold tracking-[0.5em] tabular-nums transition-all"
                        required autofocus>
                </div>
                
                <button type="submit" class="w-full py-4 bg-primary text-on-primary rounded-2xl font-extrabold shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-95 transition-all">
                    Xác nhận mã OTP
                </button>
                
                <p class="text-xs text-outline">Mã OTP sẽ hết hạn sau 5 phút.</p>
            </form>
            
            <form action="{{ route('kho-an-toan.send-otp') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="text-sm font-bold text-primary hover:underline">
                    Gửi lại mã OTP
                </button>
            </form>
        @endif
        
        <div class="mt-10 pt-8 border-t border-outline-variant/5">
            <a href="{{ route('dashboard') }}" class="text-sm text-outline hover:text-on-surface transition-colors flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Quay lại Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
