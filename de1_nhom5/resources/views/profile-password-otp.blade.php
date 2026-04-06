<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Xác nhận OTP - Fiscal Curator</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                "colors": {
                    "primary": "#4f378a",
                    "surface": "#fcf7ff",
                    "surface-container": "#f1efff",
                    "on-surface": "#1d1a25",
                    "on-surface-variant": "#49454f",
                    "outline": "#79747e",
                    "outline-variant": "#cac4d0",
                    "error": "#b3261e",
                    "error-container": "#f9dedc",
                    "on-error-container": "#410e0b"
                },
                "fontFamily": {
                    "sans": ["Inter", "sans-serif"],
                    "headline": ["Manrope", "sans-serif"]
                }
            }
        }
    };
    </script>
</head>
<body class="bg-surface text-on-surface font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-outline-variant/20">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-surface-container rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">lock_reset</span>
            </div>
            <h1 class="text-2xl font-extrabold font-headline text-on-surface">Đặt lại mật khẩu</h1>
            <p class="text-sm text-on-surface-variant mt-2">Vui lòng kiểm tra email của bạn để lấy mã OTP bảo mật. OTP sẽ hết hạn trong 5 phút.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-start gap-3">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-error-container border border-error/20 flex items-start gap-3">
                <span class="material-symbols-outlined text-error">error</span>
                <p class="text-sm font-medium text-on-error-container">{{ session('error') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.password.verify.post') }}" class="space-y-6">
            @csrf
            
            <!-- OTP Input -->
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Mã OTP (6 số)</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">password</span>
                    <input type="text" name="otp" maxlength="6" class="w-full pl-12 pr-4 py-3 bg-surface-container border-none rounded-xl focus:ring-2 focus:ring-primary transition-all font-medium placeholder-outline @error('otp') border border-error bg-error-container/10 @enderror" placeholder="123456" />
                    @error('otp')
                        <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- New Password -->
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Mật khẩu mới</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
                    <input type="password" name="password" minlength="8" class="w-full pl-12 pr-4 py-3 bg-surface-container border-none rounded-xl focus:ring-2 focus:ring-primary transition-all font-medium placeholder-outline @error('password') border border-error bg-error-container/10 @enderror" placeholder="Tối thiểu 8 ký tự" />
                    @error('password')
                        <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Confirm New Password -->
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Xác nhận mật khẩu</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock_check</span>
                    <input type="password" name="confirm-password" minlength="8" class="w-full pl-12 pr-4 py-3 bg-surface-container border-none rounded-xl focus:ring-2 focus:ring-primary transition-all font-medium placeholder-outline @error('confirm-password') border border-error bg-error-container/10 @enderror" placeholder="Nhập lại mật khẩu" />
                    @error('confirm-password')
                        <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-primary text-white rounded-xl font-bold hover:opacity-90 transition-opacity focus:ring-4 focus:ring-primary/20 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Lưu mật khẩu mới
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-primary hover:underline flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Hủy và quay lại Profile
            </a>
        </div>
    </div>

</body>
</html>
