<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'The Fiscal Curator')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "on-secondary-container": "#00714d",
                "inverse-primary": "#bac3ff",
                "on-secondary-fixed": "#002113",
                "background": "#faf8ff",
                "primary": "#24389c",
                "surface-container-low": "#f2f3ff",
                "secondary-fixed": "#6ffbbe",
                "surface": "#faf8ff",
                "secondary-container": "#6cf8bb",
                "surface-variant": "#dae2fd",
                "on-tertiary-fixed": "#40000d",
                "tertiary": "#8a0027",
                "surface-container-high": "#e2e7ff",
                "on-surface": "#131b2e",
                "on-primary-fixed": "#00105c",
                "tertiary-fixed-dim": "#ffb2b7",
                "primary-fixed": "#dee0ff",
                "surface-dim": "#d2d9f4",
                "on-tertiary": "#ffffff",
                "on-secondary-fixed-variant": "#005236",
                "error-container": "#ffdad6",
                "outline": "#757684",
                "on-primary-fixed-variant": "#293ca0",
                "error": "#ba1a1a",
                "on-tertiary-fixed-variant": "#92002a",
                "on-secondary": "#ffffff",
                "on-tertiary-container": "#ffc3c6",
                "on-primary-container": "#cacfff",
                "surface-container-highest": "#dae2fd",
                "on-error": "#ffffff",
                "secondary-fixed-dim": "#4edea3",
                "inverse-on-surface": "#eef0ff",
                "tertiary-container": "#b60237",
                "surface-tint": "#4355b9",
                "outline-variant": "#c5c5d4",
                "on-primary": "#ffffff",
                "surface-container": "#eaedff",
                "surface-bright": "#faf8ff",
                "primary-container": "#3f51b5",
                "tertiary-fixed": "#ffdadb",
                "surface-container-lowest": "#ffffff",
                "on-surface-variant": "#454652",
                "on-background": "#131b2e",
                "inverse-surface": "#283044",
                "secondary": "#006c49",
                "primary-fixed-dim": "#bac3ff",
                "on-error-container": "#93000a"
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
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @yield('head')
</head>
<body class="bg-background text-on-background min-h-screen">
    <!-- SideNavBar Anchor -->
    <aside class="h-screen fixed left-0 top-0 w-64 z-50 bg-[#f1efff] dark:bg-[#1e273d] flex flex-col py-8 backdrop-blur-xl bg-opacity-80 shadow-[40px_0_40px_-20px_rgba(19,27,46,0.04)]">
        <div class="px-6 mb-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-on-primary">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                </div>
                <div>
                    <h2 class="text-xl font-black text-[#24389c] dark:text-[#3f51b5] leading-tight">Fiscal Curator</h2>
                    <p class="font-['Manrope'] text-[10px] font-semibold uppercase tracking-widest text-[#24389c]/60">Elite Wealth Mgmt</p>
                </div>
            </div>
            <button class="w-full py-3 px-4 bg-gradient-to-br from-primary to-primary-container text-on-primary rounded-full font-headline font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                <span class="material-symbols-outlined text-sm">add</span>
                Add Transaction
            </button>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="group flex items-center gap-3 px-6 py-3 transition-all font-['Manrope'] text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-[#24389c] dark:text-[#3f51b5] relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#24389c] before:rounded-full bg-white/40' : 'text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-[#24389c] hover:bg-white/50' }}" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" {{ request()->routeIs('dashboard') ? 'style=font-variation-settings:\'FILL\'1;' : '' }}>dashboard</span>
                Tổng quan
            </a>
            <a class="group flex items-center gap-3 px-6 py-3 transition-all font-['Manrope'] text-sm font-semibold {{ request()->routeIs('tro-ly-giao-dich-ai') ? 'text-[#24389c] dark:text-[#3f51b5] relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#24389c] before:rounded-full bg-white/40' : 'text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-[#24389c] hover:bg-white/50' }}" href="{{ route('tro-ly-giao-dich-ai') }}">
                <span class="material-symbols-outlined" {{ request()->routeIs('tro-ly-giao-dich-ai') ? 'style=font-variation-settings:\'FILL\'1;' : '' }}>receipt_long</span>
                Giao dịch
            </a>
            <a class="group flex items-center gap-3 px-6 py-3 transition-all font-['Manrope'] text-sm font-semibold {{ request()->routeIs('phantich-ai') ? 'text-[#24389c] dark:text-[#3f51b5] relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#24389c] before:rounded-full bg-white/40' : 'text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-[#24389c] hover:bg-white/50' }}" href="{{ route('phantich-ai') }}">
                <span class="material-symbols-outlined" {{ request()->routeIs('phantich-ai') ? 'style=font-variation-settings:\'FILL\'1;' : '' }}>analytics</span>
                Phân tích AI
            </a>
            <a class="group flex items-center gap-3 px-6 py-3 transition-all font-['Manrope'] text-sm font-semibold {{ request()->routeIs('ngansach') ? 'text-[#24389c] dark:text-[#3f51b5] relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#24389c] before:rounded-full bg-white/40' : 'text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-[#24389c] hover:bg-white/50' }}" href="{{ route('ngansach') }}">
                <span class="material-symbols-outlined" {{ request()->routeIs('ngansach') ? 'style=font-variation-settings:\'FILL\'1;' : '' }}>pie_chart</span>
                Ngân sách
            </a>
            <a class="group flex items-center gap-3 px-6 py-3 text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-[#24389c] hover:bg-white/50 transition-all font-['Manrope'] text-sm font-semibold" href="#">
                <span class="material-symbols-outlined">lock</span>
                Kho an toàn
            </a>
        </nav>
        <div class="mt-auto pt-6 border-t border-primary/5">
            <a class="group flex items-center gap-3 px-6 py-3 {{ request()->routeIs('huongdan') ? 'text-primary font-bold bg-primary/10' : 'text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-[#24389c] hover:bg-white/5' }} transition-all font-['Manrope'] text-sm font-semibold" href="{{ route('huongdan') }}">
                <span class="material-symbols-outlined" {{ request()->routeIs('huongdan') ? 'style=font-variation-settings:\'FILL\'1;' : '' }}>help_outline</span>
                Hướng dẫn SD
            </a>
            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left group flex items-center gap-3 px-6 py-3 text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-tertiary transition-all font-['Manrope'] text-sm font-semibold">
                    <span class="material-symbols-outlined">logout</span>
                    Đăng xuất
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="group flex items-center gap-3 px-6 py-3 text-[#131b2e]/70 dark:text-[#faf8ff]/70 hover:text-primary transition-all font-['Manrope'] text-sm font-semibold">
                <span class="material-symbols-outlined">login</span>
                Đăng nhập
            </a>
            @endauth
        </div>
    </aside>

    <main class="ml-64 min-h-screen flex flex-col">
        <!-- TopNavBar Anchor -->
        <header class="w-full sticky top-0 z-40 bg-[#faf8ff] dark:bg-[#131b2e] flex justify-between items-center px-6 py-4">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative max-w-md w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">search</span>
                    <input class="w-full bg-surface-container-low border-none rounded-full py-2.5 pl-11 pr-4 text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-outline/60" placeholder="Tìm kiếm tài chính..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-full hover:bg-[#f1efff] dark:hover:bg-[#1e273d] transition-colors cursor-pointer active:opacity-80">
                        <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                    </button>
                    <a href="{{ route('profile.edit') }}" class="p-2 rounded-full hover:bg-[#f1efff] dark:hover:bg-[#1e273d] transition-colors cursor-pointer active:opacity-80 flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-surface-variant">settings</span>
                    </a>
                </div>
                <div class="h-8 w-[1px] bg-outline-variant/30 mx-2"></div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition-opacity group">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-on-surface group-hover:text-primary transition-colors">{{ Auth::check() ? Auth::user()->ho_ten : 'Khách' }}</p>
                        <p class="text-[10px] text-on-surface-variant">Thành viên</p>
                    </div>
                    <img alt="User profile" class="w-10 h-10 rounded-full object-cover border-2 border-primary-fixed shadow-sm" src="{{ Auth::check() && Auth::user()->anh_dai_dien ? asset('storage/' . Auth::user()->anh_dai_dien) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuA626iML8Eg0T0FDI2y9Tg9PHrbfMc12buaZYXBAYhPh6vpJzY3op19-kt6OW8wLRTi7V1qepL0biFk51eW_fVjg4ZUg7qs3QPXCbRyCbLaHPTWFH1AI2KJvd5wfwl6qRfBhHmqH4CkcRjWf6GWg4RYj9j_I4QUxg1J0TkWb1K-TkipH1OuAlWBljHRu3mI9BZTa4oGGRIIivvi_W7k0vZ9Q49vtgJFNkLd9vbx_6Nsae2ILriiw8XTbWa7imtVUbrwhjIl8017jN0' }}"/>
                </a>
            </div>
        </header>

        <!-- Main Content Content -->
        <div class="p-8 flex-1">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>
</html>
