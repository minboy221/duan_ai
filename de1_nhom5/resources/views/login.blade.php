@extends('layouts.auth')

@section('title', 'Đăng nhập | The Fiscal Curator')

@section('content')
<div class="w-full max-w-5xl grid md:grid-cols-2 gap-0 z-10 bg-surface-container-lowest rounded-xl overflow-hidden shadow-2xl shadow-on-surface/5">
    <!-- Left Side: Visual/Branding Section -->
    <div class="hidden md:flex flex-col justify-between p-12 bg-primary relative overflow-hidden">
        <div class="z-10">
            <div class="text-white text-3xl font-headline font-extrabold tracking-tighter mb-2">
                The Fiscal Curator
            </div>
            <p class="text-on-primary-container text-lg font-medium opacity-90 max-w-xs">
                Nâng tầm quản lý tài chính cá nhân với sự tinh tế và chính xác.
            </p>
        </div>
        <div class="z-10 mt-auto">
            <div class="bg-surface-container-lowest/10 backdrop-blur-md rounded-xl p-6 border border-white/10">
                <span class="material-symbols-outlined text-secondary-fixed text-4xl mb-4" data-icon="account_balance_wallet">account_balance_wallet</span>
                <blockquote class="text-white text-xl font-headline font-semibold leading-tight">
                    "Sự giàu có không nằm ở việc sở hữu nhiều, mà ở việc quản lý thông minh."
                </blockquote>
            </div>
        </div>
        <!-- Abstract Shape in Indigo Side -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full opacity-20 pointer-events-none">
            <img alt="" class="w-full h-full object-cover scale-150" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDs2YnJwShfz0sTZmkz8O3Y-hoCeJf6PKzqRyIEBqF_HeOP4_tdJCpXWwWIxGeUYgEtORW49Llfqdal5t3XnBjaY8ULxnqDF2lkgutCwAPQuHosDuGmCwp1F_U5TfuZnc2vW8VRtcHHrj29SfIWpXUOGQ4SloFpKQ0_TXTM0zFGNpcLQ7x4ejnSy8Y0fZ1LdJOYp9X2wIl4e1PQiQ7mu_7YDtptIKfyr-nbSsJ0jEPBrDBe_BtECP1cbtocbuAwlVCApTrk70UxaBk"/>
        </div>
    </div>
    <!-- Right Side: Login Form Section -->
    <div class="p-8 md:p-16 flex flex-col justify-center bg-surface-bright">
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-headline font-bold text-on-surface tracking-tight mb-2">Chào mừng trở lại</h1>
            <p class="text-on-surface-variant">Vui lòng nhập thông tin để truy cập tài khoản của bạn.</p>
        </div>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-label font-semibold text-on-surface mb-2" for="email">Email</label>
                <input class="w-full px-4 py-3 rounded-xl border-none bg-surface-container-low text-on-surface focus:ring-2 focus:ring-primary-container transition-all placeholder:text-outline-variant" id="email" name="email" placeholder="curator@finance.vn" type="email"/>
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-label font-semibold text-on-surface" for="password">Mật khẩu</label>
                    <a class="text-xs font-semibold text-primary hover:text-primary-container transition-colors" href="#">Quên mật khẩu?</a>
                </div>
                <div class="relative">
                    <input class="w-full px-4 py-3 rounded-xl border-none bg-surface-container-low text-on-surface focus:ring-2 focus:ring-primary-container transition-all placeholder:text-outline-variant" id="password" name="password" placeholder="••••••••" type="password"/>
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button">
                        <span class="material-symbols-outlined text-sm" data-icon="visibility">visibility</span>
                    </button>
                </div>
            </div>
            <button class="w-full py-4 rounded-xl bg-gradient-to-r from-primary to-primary-container text-white font-semibold text-lg shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all duration-200" type="submit">
                Đăng nhập
            </button>
        </form>
        <div class="mt-8 relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-outline-variant/30"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-surface-bright text-outline font-medium">Hoặc tiếp tục với</span>
            </div>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-4">
            <button class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-surface-container-lowest border border-outline-variant/20 hover:bg-surface-container-low transition-colors active:scale-95 duration-200">
                <img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuR3-_CdI5zzfZdT39sJuluNhIxID9OaxgPzVA00px2UQNSl0LiLlQOEGcGtyxLgayUPkPxy4ghn_-mSa6nGt3mtUmMNyQpRVoy9gWtLAXVooJO1gvs_Ef2_QNG80TgtBaXbEHFw2JGVIlVVilLzy1st89sr2JFF-KiMJfcQN43nnnGH9X-di3MREPCMGmyvuwqf4p9ClMvLCFhL_3xdnlz1BDwnULrQq9ovCnK3K8ZTJYJxwEQWGyGWGX9pXIplyRZ0cM8X4WzrI"/>
                <span class="font-semibold text-sm">Google</span>
            </button>
            <button class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-on-surface text-white hover:opacity-90 transition-colors active:scale-95 duration-200">
                <span class="material-symbols-outlined text-xl" data-icon="apple">ios</span>
                <span class="font-semibold text-sm">Apple</span>
            </button>
        </div>
        <div class="mt-10 text-center text-sm text-on-surface-variant">
            Chưa có tài khoản? 
            <a class="text-primary font-bold hover:underline" href="{{ route('dangky') }}">Đăng ký ngay</a>
        </div>
    </div>
</div>
@endsection