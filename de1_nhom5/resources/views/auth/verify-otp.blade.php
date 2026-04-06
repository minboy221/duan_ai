@extends('layouts.auth')

@section('title', 'Kích hoạt tài khoản | The Fiscal Curator')

@section('content')
<div class="w-full max-w-5xl grid md:grid-cols-2 gap-0 z-10 bg-surface-container-lowest rounded-xl overflow-hidden shadow-2xl shadow-on-surface/5">
    <div class="hidden md:flex flex-col justify-between p-12 bg-primary relative overflow-hidden">
        <div class="z-10">
            <div class="text-white text-3xl font-headline font-extrabold tracking-tighter mb-2">
                The Fiscal Curator
            </div>
        </div>
        <div class="z-10 mt-auto">
            <div class="bg-surface-container-lowest/10 backdrop-blur-md rounded-xl p-6 border border-white/10">
                <blockquote class="text-white text-lg font-headline font-semibold leading-tight">
                    "Gần xong rồi! Vui lòng kiểm tra email của bạn để lấy mã kích hoạt OTP."
                </blockquote>
            </div>
        </div>
    </div>
    <div class="p-8 md:p-16 flex flex-col justify-center bg-surface-bright">
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-headline font-bold text-on-surface tracking-tight mb-2">Xác thực OTP</h1>
            <p class="text-on-surface-variant">Nhập mã gồm 6 chữ số chúng tôi vừa gửi đến <strong>{{ $email }}</strong>.</p>
        </div>
        <form class="space-y-6" method="POST" action="{{ route('verify-otp.post') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            @if ($errors->any())
                <div class="p-3 bg-red-100/50 text-red-600 rounded-xl text-sm mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100/50 text-red-600 rounded-xl text-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="p-3 bg-green-100/50 text-green-700 rounded-xl text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-label font-semibold text-on-surface mb-2" for="otp">Mã OTP (6 số)</label>
                <input class="w-full text-center tracking-[1rem] text-2xl px-4 py-3 rounded-xl border-none bg-surface-container-low text-on-surface focus:ring-2 focus:ring-primary-container transition-all" id="otp" name="otp" placeholder="------" type="text" maxlength="6"/>
            </div>
            
            <button class="w-full py-4 rounded-xl bg-gradient-to-r from-primary to-primary-container text-white font-semibold text-lg shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all duration-200" type="submit">
                Xác thực & Kích hoạt
            </button>
        </form>
        <div class="mt-8 text-center text-sm text-on-surface-variant">
            Chưa nhận được mã? 
            <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Đăng nhập lại</a>
        </div>
    </div>
</div>
@endsection
