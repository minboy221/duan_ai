<!DOCTYPE html>

<html class="light" lang="vi"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Đăng nhập | The Fiscal Curator</title>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "on-primary": "#ffffff",
                      "on-error-container": "#93000a",
                      "primary-container": "#3f51b5",
                      "on-surface": "#131b2e",
                      "surface-container-high": "#e2e7ff",
                      "outline-variant": "#c5c5d4",
                      "tertiary-fixed-dim": "#ffb2b7",
                      "secondary-fixed": "#6ffbbe",
                      "error": "#ba1a1a",
                      "surface-container-low": "#f2f3ff",
                      "primary-fixed": "#dee0ff",
                      "inverse-primary": "#bac3ff",
                      "surface-container-lowest": "#ffffff",
                      "background": "#faf8ff",
                      "secondary-container": "#6cf8bb",
                      "inverse-on-surface": "#eef0ff",
                      "on-secondary-container": "#00714d",
                      "surface-tint": "#4355b9",
                      "on-tertiary-fixed-variant": "#92002a",
                      "on-tertiary-fixed": "#40000d",
                      "tertiary": "#8a0027",
                      "outline": "#757684",
                      "tertiary-container": "#b60237",
                      "primary-fixed-dim": "#bac3ff",
                      "tertiary-fixed": "#ffdadb",
                      "on-secondary-fixed": "#002113",
                      "on-secondary": "#ffffff",
                      "surface": "#faf8ff",
                      "on-primary-fixed-variant": "#293ca0",
                      "error-container": "#ffdad6",
                      "on-tertiary-container": "#ffc3c6",
                      "inverse-surface": "#283044",
                      "on-surface-variant": "#454652",
                      "surface-dim": "#d2d9f4",
                      "surface-container-highest": "#dae2fd",
                      "on-tertiary": "#ffffff",
                      "on-secondary-fixed-variant": "#005236",
                      "on-error": "#ffffff",
                      "surface-variant": "#dae2fd",
                      "secondary-fixed-dim": "#4edea3",
                      "primary": "#24389c",
                      "on-primary-fixed": "#00105c",
                      "secondary": "#006c49",
                      "on-background": "#131b2e",
                      "on-primary-container": "#cacfff",
                      "surface-container": "#eaedff",
                      "surface-bright": "#faf8ff"
              },
              "borderRadius": {
                      "DEFAULT": "0.125rem",
                      "lg": "0.25rem",
                      "xl": "0.5rem",
                      "full": "0.75rem"
              },
              "fontFamily": {
                      "headline": ["Manrope"],
                      "body": ["Inter"],
                      "label": ["Inter"]
              }
            },
          },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-background font-body text-on-surface min-h-screen flex flex-col">
<main class="flex-grow flex items-center justify-center relative overflow-hidden px-6 py-12">
<!-- Abstract Background Decorative Elements -->
<div class="absolute inset-0 z-0">
<div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/10 rounded-full blur-[120px]"></div>
<div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary-container/10 rounded-full blur-[120px]"></div>
<div class="absolute top-[20%] right-[10%] w-[20%] h-[20%] bg-tertiary-fixed/5 rounded-full blur-[80px]"></div>
</div>
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
<img alt="" class="w-full h-full object-cover scale-150" data-alt="abstract flowing 3D geometric waves in shades of indigo and deep blue with soft studio lighting and premium finish" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDs2YnJwShfz0sTZmkz8O3Y-hoCeJf6PKzqRyIEBqF_HeOP4_tdJCpXWwWIxGeUYgEtORW49Llfqdal5t3XnBjaY8ULxnqDF2lkgutCwAPQuHosDuGmCwp1F_U5TfuZnc2vW8VRtcHHrj29SfIWpXUOGQ4SloFpKQ0_TXTM0zFGNpcLQ7x4ejnSy8Y0fZ1LdJOYp9X2wIl4e1PQiQ7mu_7YDtptIKfyr-nbSsJ0jEPBrDBe_BtECP1cbtocbuAwlVCApTrk70UxaBk"/>
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
<span class="material-symbols-outlined text-xl" data-icon="apple" data-weight="fill">ios</span>
<span class="font-semibold text-sm">Apple</span>
</button>
</div>
<div class="mt-10 text-center text-sm text-on-surface-variant">
                    Chưa có tài khoản? 
                    <a class="text-primary font-bold hover:underline" href="#">Đăng ký ngay</a>
</div>
</div>
</div>
</main>
<!-- Footer Component Integration -->
<footer class="bg-[#faf8ff] dark:bg-[#131b2e] w-full py-8 border-t border-[#131b2e]/5 dark:border-[#faf8ff]/5">
<div class="flex flex-col md:flex-row justify-between items-center px-6 max-w-7xl mx-auto gap-4">
<div class="text-lg font-bold text-[#24389c] font-headline">The Fiscal Curator</div>
<div class="flex gap-6">
<a class="text-[#131b2e]/40 dark:text-[#faf8ff]/40 font-['Inter'] text-sm tracking-normal hover:text-[#24389c] transition-colors duration-200" href="#">Điều khoản</a>
<a class="text-[#131b2e]/40 dark:text-[#faf8ff]/40 font-['Inter'] text-sm tracking-normal hover:text-[#24389c] transition-colors duration-200" href="#">Hỗ trợ</a>
<a class="text-[#131b2e]/40 dark:text-[#faf8ff]/40 font-['Inter'] text-sm tracking-normal hover:text-[#24389c] transition-colors duration-200" href="#">Liên hệ</a>
</div>
<div class="text-[#131b2e]/40 dark:text-[#faf8ff]/40 font-['Inter'] text-sm tracking-normal">
                © 2024 The Fiscal Curator. Bảo mật &amp; Riêng tư.
            </div>
</div>
</footer>
</body></html>