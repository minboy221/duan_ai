@extends('layouts.auth')

@section('title', 'Đăng ký - The Fiscal Curator')

@section('content')
<div class="w-full max-w-6xl flex flex-col md:flex-row bg-surface-container-lowest rounded-2xl overflow-hidden shadow-2xl relative z-10">
    <!-- Left Section: Brand Ambience -->
    <section class="hidden md:flex md:w-1/2 bg-primary relative overflow-hidden flex-col justify-between p-12 lg:p-16">
        <div class="z-10">
            <h1 class="font-headline text-4xl lg:text-5xl font-extrabold text-on-primary tracking-tighter mb-4">
                The Fiscal Curator
            </h1>
            <p class="text-on-primary/80 text-xl font-light max-w-md">
                Nâng tầm quản lý tài chính cá nhân với sự tinh tế của một chuyên gia giám tuyển.
            </p>
        </div>
        <!-- Decorative Visual: Abstract Data Curves -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-[-10%] right-[-10%] w-[80%] h-[80%] rounded-full bg-primary-container/20 blur-[120px]"></div>
            <div class="absolute bottom-[-20%] left-[-10%] w-[100%] h-[70%] rounded-full bg-secondary/10 blur-[100px]"></div>
            <img alt="Abstract decorative background" class="absolute bottom-0 right-0 w-full h-full object-cover mix-blend-overlay opacity-30" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZB897HiGAZ7B0PcDNriTuRdpL1FIqVo6fbmJoESJNcuEkv2eOLrGE1AlFV3ACMUBEmhCl8tvZIAr9aj1oUZhM2hskZ0ASuSzwJppmlDcpxkuwW0cp2BBGpeyLIeHZZWlXMsZcdIbgyVKlu6iGRXUWS-MDRJkS7POdiLpp2kLlDJQBYvhnaYOdcPuughjUTkUzrrFpJGPsseTxRDEfhmLboxU3pTgAPVII6jY5BwYON9KGz8TGFRBGH0yI4sTlQ18SEPatzr7ChzI"/>
        </div>
        <div class="z-10 mt-auto">
            <div class="flex items-center gap-4 text-on-primary/60 text-sm">
                <span class="w-12 h-[1px] bg-on-primary/30"></span>
                <span>THẨM MỸ • CHÍNH XÁC • TIN CẬY</span>
            </div>
        </div>
    </section>
    <!-- Right Section: Registration Form -->
    <section class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 bg-surface">
        <div class="w-full max-w-md space-y-8">
            <div class="space-y-2">
                <h2 class="font-headline text-3xl font-bold text-on-surface tracking-tight">Tạo tài khoản mới</h2>
                <p class="text-on-surface-variant font-medium">Bắt đầu hành trình giám tuyển tài chính của bạn ngay hôm nay.</p>
            </div>
            <!-- Social Sign-up Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <button class="flex items-center justify-center gap-3 py-3 px-4 rounded-xl bg-surface-container-lowest border border-outline-variant/20 hover:bg-surface-container-low transition-all duration-200 active:scale-95 group">
                    <img alt="Google Logo" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjpIumPrz3Zx2TUZ60dRrgkyI8jAm73NkwFUiPGyui-u2W5P3OnZ13mJSZL9cHH5zLXaqLaIbi12lfyYC2cLXHgnz3KCZsOzW-qzy4u3W9JFCwOiHIxcpRd3IVhm2kOeXUhTAi8KCBAXmtg5mYiW1Uu2tDltxqL0-uKFugevuGtw8vn4Q1FonGE8edLWuFbvR-aGcfPG7mSD1seqOyoHbCHlM44ZjGdQ6CMyPopwPcajeCsMDUuAFlGTPALOtmEHTOaplrPglixnE"/>
                    <span class="text-sm font-semibold text-on-surface">Google</span>
                </button>
                <button class="flex items-center justify-center gap-3 py-3 px-4 rounded-xl bg-surface-container-lowest border border-outline-variant/20 hover:bg-surface-container-low transition-all duration-200 active:scale-95">
                    <span class="material-symbols-outlined text-xl">ios</span>
                    <span class="text-sm font-semibold text-on-surface">Apple</span>
                </button>
            </div>
            <div class="relative flex items-center py-2">
                <div class="flex-grow border-t border-outline-variant/10"></div>
                <span class="flex-shrink mx-4 text-xs font-semibold text-outline tracking-widest">HOẶC ĐĂNG KÝ BẰNG EMAIL</span>
                <div class="flex-grow border-t border-outline-variant/10"></div>
            </div>
            <!-- Registration Form -->
            <form class="space-y-5">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-outline-variant uppercase tracking-wider ml-1" for="fullname">Họ và tên</label>
                    <input class="w-full px-4 py-3.5 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-outline/40" id="fullname" name="fullname" placeholder="Nguyễn Văn A" type="text"/>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-outline-variant uppercase tracking-wider ml-1" for="email">Địa chỉ Email</label>
                    <input class="w-full px-4 py-3.5 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-outline/40" id="email" name="email" placeholder="ten@vidu.com" type="email"/>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-outline-variant uppercase tracking-wider ml-1" for="password">Mật khẩu</label>
                        <input class="w-full px-4 py-3.5 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-outline/40" id="password" name="password" placeholder="••••••••" type="password"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-outline-variant uppercase tracking-wider ml-1" for="confirm-password">Xác nhận</label>
                        <input class="w-full px-4 py-3.5 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface placeholder:text-outline/40" id="confirm-password" name="confirm-password" placeholder="••••••••" type="password"/>
                    </div>
                </div>
                <div class="flex items-start gap-3 py-2">
                    <div class="flex items-center h-5">
                        <input class="h-5 w-5 rounded-lg border-outline-variant/30 text-primary focus:ring-primary/30 bg-surface-container-low cursor-pointer" id="terms" name="terms" type="checkbox"/>
                    </div>
                    <div class="text-sm">
                        <label class="text-on-surface-variant leading-relaxed" for="terms">
                            Tôi đồng ý với <a class="text-primary font-semibold hover:underline decoration-primary/30" href="#">Điều khoản sử dụng</a> và <a class="text-primary font-semibold hover:underline decoration-primary/30" href="#">Chính sách bảo mật</a>.
                        </label>
                    </div>
                </div>
                <button class="w-full py-4 bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold rounded-xl shadow-lg shadow-primary/10 hover:shadow-primary/20 hover:opacity-95 transition-all duration-300 active:scale-[0.98] mt-2" type="submit">
                    Tạo tài khoản
                </button>
            </form>
            <div class="pt-6 text-center">
                <p class="text-on-surface-variant font-medium">
                    Đã có tài khoản? 
                    <a class="text-primary font-bold hover:underline ml-1 underline-offset-4 decoration-primary/30 transition-all" href="{{ route('login') }}">Đăng nhập ngay</a>
                </p>
            </div>
        </div>
    </section>
</div>
@endsection