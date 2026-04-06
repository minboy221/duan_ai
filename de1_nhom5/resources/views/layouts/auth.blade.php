<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'The Fiscal Curator')</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
    @yield('head')
</head>
<body class="bg-background font-body text-on-surface min-h-screen flex flex-col">
    <main class="flex-grow flex items-center justify-center relative overflow-hidden px-6 py-12">
        <!-- Abstract Background Decorative Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary-container/10 rounded-full blur-[120px]"></div>
            <div class="absolute top-[20%] right-[10%] w-[20%] h-[20%] bg-tertiary-fixed/5 rounded-full blur-[80px]"></div>
        </div>

        @yield('content')
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
                © 2024 The Fiscal Curator. Bảo mật & Riêng tư.
            </div>
        </div>
    </footer>
    @yield('scripts')
</body>
</html>
