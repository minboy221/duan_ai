<!DOCTYPE html>

<html class="light" lang="vi"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>The Fiscal Curator - Ngân sách &amp; Tiết kiệm</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Manrope:wght@500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary": "#ffffff",
                        "on-error": "#ffffff",
                        "on-tertiary-container": "#ffc3c6",
                        "tertiary-fixed": "#ffdadb",
                        "outline-variant": "#c5c5d4",
                        "surface": "#faf8ff",
                        "secondary-container": "#6cf8bb",
                        "tertiary-container": "#b60237",
                        "surface-container": "#eaedff",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#f2f3ff",
                        "inverse-on-surface": "#eef0ff",
                        "on-primary": "#ffffff",
                        "secondary-fixed": "#6ffbbe",
                        "surface-tint": "#4355b9",
                        "on-primary-fixed": "#00105c",
                        "on-primary-fixed-variant": "#293ca0",
                        "inverse-surface": "#283044",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed": "#002113",
                        "on-surface-variant": "#454652",
                        "primary-fixed": "#dee0ff",
                        "secondary": "#006c49",
                        "surface-variant": "#dae2fd",
                        "on-surface": "#131b2e",
                        "surface-container-highest": "#dae2fd",
                        "on-secondary": "#ffffff",
                        "tertiary": "#8a0027",
                        "primary": "#24389c",
                        "on-secondary-fixed-variant": "#005236",
                        "error-container": "#ffdad6",
                        "primary-container": "#3f51b5",
                        "tertiary-fixed-dim": "#ffb2b7",
                        "on-tertiary-fixed": "#40000d",
                        "background": "#faf8ff",
                        "on-secondary-container": "#00714d",
                        "outline": "#757684",
                        "secondary-fixed-dim": "#4edea3",
                        "inverse-primary": "#bac3ff",
                        "primary-fixed-dim": "#bac3ff",
                        "on-primary-container": "#cacfff",
                        "on-tertiary-fixed-variant": "#92002a",
                        "error": "#ba1a1a",
                        "on-background": "#131b2e",
                        "surface-container-high": "#e2e7ff",
                        "surface-dim": "#d2d9f4",
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
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .headline { font-family: 'Manrope', sans-serif; }
        .tabular-nums { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-surface text-on-surface">
<!-- SideNavBar -->
<aside class="bg-slate-50 dark:bg-slate-900 h-screen w-64 fixed left-0 top-0 flex flex-col h-full py-6 px-4 z-50">
<div class="mb-10 px-4">
<h1 class="text-lg font-bold tracking-tight text-indigo-900 dark:text-indigo-100">The Fiscal Curator</h1>
<p class="text-xs text-slate-500 font-medium">Quản lý Tài sản</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-full style_universal_hover text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-sm font-medium">Bảng điều khiển</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-full style_universal_hover text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
<span class="text-sm font-medium">Giao dịch</span>
</a>
<!-- Active Tab: Ngân sách -->
<a class="flex items-center gap-3 px-4 py-3 rounded-full relative text-indigo-700 dark:text-indigo-400 font-semibold before:content-[''] before:absolute before:left-0 before:w-1 before:h-6 before:bg-indigo-700 before:rounded-r-full" href="#">
<span class="material-symbols-outlined" data-icon="account_balance_wallet" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
<span class="text-sm font-medium">Ngân sách</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-full style_universal_hover text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="psychology">psychology</span>
<span class="text-sm font-medium">Cố vấn AI</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-full style_universal_hover text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-sm font-medium">Cài đặt</span>
</a>
</nav>
<div class="mt-auto space-y-4 pt-6 border-t border-slate-200/50">
<button class="w-full py-3 px-4 bg-gradient-to-tr from-primary to-primary-container text-white rounded-full font-semibold text-sm flex items-center justify-center gap-2 shadow-md active:scale-95 transition-transform">
<span class="material-symbols-outlined text-sm" data-icon="add">add</span>
            Thêm nhanh
        </button>
<a class="flex items-center gap-3 px-4 py-3 rounded-full style_universal_hover text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="download">download</span>
<span class="text-sm font-medium">Xuất dữ liệu</span>
</a>
<div class="flex items-center gap-3 px-4 py-2">
<img alt="User Profile Avatar" class="w-8 h-8 rounded-full object-cover" data-alt="Professional headshot of a refined man in a minimalist studio setting with soft directional lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB5FJFi8h3wm3NFNgLsGnu3iU4gCSSPU-4QdLRQqBywNDyohtozZP5icfm4tSRCxsQwPE2I3wimHgkBiK-nI-8sUOcHadaWVcQV_TapaP8Jj3E1wBy7_BeXTTJMF5vaaLkeDGf_PEXpDxSyy5F71iE4E1AuSt6_IAOY1j5HlobAzaurGO1q_HdTVxJosKYN0ghVrDwZ9fuSfVWv9uTGgmJ042Lfnm4bZSkuWrGpPJKVFMjRn5zNQtQ8nXagLJAFBDMa3eoe0lz2Nug"/>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">Julian Thorne</p>
<p class="text-[10px] text-slate-500 truncate">Thành viên Curator</p>
</div>
</div>
</div>
</aside>
<!-- TopNavBar -->
<header class="fixed top-0 right-0 left-64 h-16 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md flex items-center justify-between px-8 w-auto">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm" data-icon="search">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface" placeholder="Tìm kiếm thông tin tài chính..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4">
<button class="relative text-slate-600 hover:text-indigo-600 transition-all">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="absolute top-0 right-0 w-2 h-2 bg-tertiary rounded-full border-2 border-white"></span>
</button>
<button class="text-slate-600 hover:text-indigo-600 transition-all">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
</div>
<div class="h-8 w-[1px] bg-slate-200"></div>
<img alt="User Profile Image" class="w-9 h-9 rounded-full object-cover border-2 border-primary-container/20" data-alt="Close-up of a stylish user profile image used for interface personalization" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBGzddKxiTw8SguAfufD8fiuwyYIL63V5dA0k-wkbOppQUFOT-XI-Iw_YGrPciAu_9NqDgS5nxCyFyMvj1xB_W7_3nYHEwYKNmoRpV6TLRKB85NGbRjtKdDKMSaOFo2IppjZr6fo79dtg-INgU5kWSYXAlGDgSCb_qzaldU4pAb3417SPua9keIpyPtOyeavPj992m5_NF3w1ckMdYLv7hPa1JvaUoZzGrwzgukyI6VCFJlpN2lL4HwvDOqktU5wcIOrTqJwhoOlYQ"/>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 px-10 pb-12 min-h-screen">
<!-- Editorial Header Section -->
<section class="mb-12 flex flex-col md:flex-row justify-between items-end gap-8">
<div class="max-w-2xl">
<h2 class="text-sm font-bold uppercase tracking-widest text-primary mb-2">Tổng quan danh mục</h2>
<h3 class="text-5xl font-extrabold headline leading-tight text-on-surface">
                Gìn giữ <span class="text-secondary italic">di sản tài chính</span> của bạn một cách tinh tế.
            </h3>
</div>
<div class="bg-surface-container-low p-6 rounded-full flex items-center gap-8">
<div>
<p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Tổng ngân sách tháng</p>
<p class="text-2xl font-extrabold tabular-nums">312.000.000 VNĐ</p>
</div>
<div class="h-10 w-[1px] bg-slate-300"></div>
<div>
<p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Mức độ sử dụng</p>
<p class="text-2xl font-extrabold tabular-nums text-secondary">64%</p>
</div>
</div>
</section>
<!-- Bento Grid: Monthly Budgets -->
<section class="mb-16">
<div class="flex items-center justify-between mb-8">
<h4 class="text-xl font-bold headline">Phân loại chi tiêu hàng tháng</h4>
<button class="text-sm font-semibold text-primary flex items-center gap-1 hover:gap-2 transition-all">
                Xem chi tiết <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Food Budget Card -->
<div class="bg-surface-container-lowest p-8 rounded-full flex flex-col justify-between min-h-[220px] shadow-sm relative overflow-hidden group">
<div class="relative z-10">
<div class="flex justify-between items-start mb-6">
<div class="p-3 bg-secondary-container rounded-xl">
<span class="material-symbols-outlined text-on-secondary-container" data-icon="restaurant">restaurant</span>
</div>
<span class="text-xs font-bold text-secondary uppercase tracking-wider">Bền vững</span>
</div>
<h5 class="text-lg font-bold mb-1">Ẩm thực &amp; Thực phẩm</h5>
<p class="text-3xl font-extrabold tabular-nums mb-4">21.050.000<span class="text-base font-medium text-slate-400"> / 30.000.000 VNĐ</span></p>
</div>
<div class="relative z-10">
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-secondary transition-all duration-1000" style="width: 70%;"></div>
</div>
<p class="text-[11px] font-medium text-slate-500 mt-2">Đã dùng 70%. Đang đi đúng lộ trình.</p>
</div>
</div>
<!-- Entertainment Budget Card (Nearing Limit) -->
<div class="bg-surface-container-lowest p-8 rounded-full flex flex-col justify-between min-h-[220px] shadow-sm relative overflow-hidden ring-2 ring-tertiary/10">
<div class="relative z-10">
<div class="flex justify-between items-start mb-6">
<div class="p-3 bg-tertiary-container rounded-xl">
<span class="material-symbols-outlined text-white" data-icon="theater_comedy">theater_comedy</span>
</div>
<span class="text-xs font-bold text-tertiary uppercase tracking-wider italic">Cần lưu ý</span>
</div>
<h5 class="text-lg font-bold mb-1">Giải trí &amp; Lối sống</h5>
<p class="text-3xl font-extrabold tabular-nums mb-4">47.250.000<span class="text-base font-medium text-slate-400"> / 50.000.000 VNĐ</span></p>
</div>
<div class="relative z-10">
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-tertiary transition-all duration-1000" style="width: 94.5%;"></div>
</div>
<p class="text-[11px] font-bold text-tertiary mt-2">Đã dùng 94.5%. Còn lại 2.750.000 VNĐ.</p>
</div>
</div>
<!-- Utilities Budget Card -->
<div class="bg-surface-container-lowest p-8 rounded-full flex flex-col justify-between min-h-[220px] shadow-sm relative overflow-hidden">
<div class="relative z-10">
<div class="flex justify-between items-start mb-6">
<div class="p-3 bg-primary-container rounded-xl">
<span class="material-symbols-outlined text-white" data-icon="bolt">bolt</span>
</div>
<span class="text-xs font-bold text-primary uppercase tracking-wider">Chi phí cố định</span>
</div>
<h5 class="text-lg font-bold mb-1">Nhà ở &amp; Tiện ích</h5>
<p class="text-3xl font-extrabold tabular-nums mb-4">10.500.000<span class="text-base font-medium text-slate-400"> / 21.000.000 VNĐ</span></p>
</div>
<div class="relative z-10">
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-primary transition-all duration-1000" style="width: 50%;"></div>
</div>
<p class="text-[11px] font-medium text-slate-500 mt-2">Đã dùng 50%. Dưới mức chi tiêu trung bình.</p>
</div>
</div>
</div>
</section>
<!-- Savings Goals: Asymmetric Layout -->
<section>
<div class="flex items-baseline gap-4 mb-8">
<h4 class="text-3xl font-extrabold headline">Mục tiêu Tiết kiệm</h4>
<p class="text-slate-500 font-medium text-sm">Tích lũy tài sản dài hạn</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Large Featured Goal -->
<div class="lg:col-span-7 bg-surface-container-low rounded-full overflow-hidden p-1">
<div class="bg-surface-container-lowest rounded-[2.5rem] p-10 flex flex-col md:flex-row gap-10 items-center">
<div class="w-full md:w-1/2">
<div class="flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-widest mb-4">
<span class="material-symbols-outlined text-sm" data-icon="auto_awesome">auto_awesome</span>
                            Mục tiêu chính
                        </div>
<h5 class="text-4xl font-extrabold headline mb-6">Biệt thự tại Tuscany</h5>
<div class="space-y-6 mb-8">
<div>
<div class="flex justify-between text-xs font-bold uppercase mb-2">
<span class="text-slate-500">Đã tích lũy</span>
<span class="text-on-surface">3.625M / 11.250M VNĐ</span>
</div>
<div class="h-3 w-full bg-surface-container-low rounded-full">
<div class="h-full bg-gradient-to-r from-primary to-primary-container rounded-full" style="width: 32.2%;"></div>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="bg-surface-container-low p-4 rounded-full">
<p class="text-[10px] font-bold text-slate-500 uppercase">Ngày hoàn thành</p>
<p class="text-base font-bold tabular-nums">Th10 2026</p>
</div>
<div class="bg-surface-container-low p-4 rounded-full">
<p class="text-[10px] font-bold text-slate-500 uppercase">Tốc độ hàng ngày</p>
<p class="text-base font-bold tabular-nums text-secondary">7.100.000 VNĐ</p>
</div>
</div>
</div>
<button class="px-8 py-3 bg-on-surface text-white rounded-full font-bold text-sm hover:bg-slate-800 transition-colors">Điều chỉnh đóng góp</button>
</div>
<div class="w-full md:w-1/2 h-full min-h-[300px]">
<div class="relative h-full w-full rounded-[2rem] overflow-hidden group">
<img alt="Tuscany Villa" class="w-full h-full object-cover grayscale-[20%] group-hover:scale-105 transition-transform duration-700" data-alt="Dreamy landscape of a classic Tuscan stone villa surrounded by rolling hills and cypress trees at dawn" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0672jcdNxiGuSd9-BtrhLxPaQrVze6UeNO3CCSNI75cksMrv-BsLwjzzxXFg7DaoqJZJb1HfJr7TIvRa75BqSNE6xzeIrshTQ6HoUfO6pFiu7-7Qzq7gmPfdrxVbXqOvWNMCcjWaeMo1aV8sghckPjqXsWPzfzSk1vZRgEbnuV431_PEnXQeQLkwCsrro9HsNXrcwn7d2uyYu6Ww_p2E75kvlRJf_onyOzMijTtQSnSlGd0bUtXgWk0_xKOWnnYMe9mQ8qQMUaAQ"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
</div>
</div>
</div>
</div>
<!-- Secondary Goals Stack -->
<div class="lg:col-span-5 flex flex-col gap-6">
<!-- Goal: Emergency Fund -->
<div class="bg-surface-container-low p-8 rounded-full border border-transparent hover:border-primary/20 transition-all">
<div class="flex justify-between items-start mb-6">
<div>
<h6 class="text-xl font-extrabold headline mb-1">Quỹ dự phòng khẩn cấp</h6>
<p class="text-sm text-slate-500 font-medium">Đảm bảo 9 tháng chi tiêu</p>
</div>
<div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
<span class="material-symbols-outlined text-primary" data-icon="security" style="font-variation-settings: 'FILL' 1;">security</span>
</div>
</div>
<div class="flex justify-between items-end mb-4">
<div>
<p class="text-2xl font-extrabold tabular-nums">1.560.000.000 VNĐ</p>
<p class="text-[10px] font-bold text-slate-400 uppercase">Mục tiêu: 1.875.000.000 VNĐ</p>
</div>
<div class="text-right">
<p class="text-sm font-bold text-secondary">+10.500.000 / tuần</p>
<p class="text-[10px] text-slate-400 font-medium italic">Còn 31 tuần</p>
</div>
</div>
<div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
<div class="h-full bg-primary" style="width: 83%;"></div>
</div>
</div>
<!-- Goal: New High-End SUV -->
<div class="bg-surface-container-low p-8 rounded-full border border-transparent hover:border-primary/20 transition-all">
<div class="flex justify-between items-start mb-6">
<div>
<h6 class="text-xl font-extrabold headline mb-1">Xe sang đẳng cấp</h6>
<p class="text-sm text-slate-500 font-medium">Model S Plaid Fund</p>
</div>
<div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
<span class="material-symbols-outlined text-primary" data-icon="electric_car">electric_car</span>
</div>
</div>
<div class="flex justify-between items-end mb-4">
<div>
<p class="text-2xl font-extrabold tabular-nums">1.030.000.000 VNĐ</p>
<p class="text-[10px] font-bold text-slate-400 uppercase">Mục tiêu: 3.000.000.000 VNĐ</p>
</div>
<div class="text-right">
<p class="text-sm font-bold text-secondary">+30.000.000 / tuần</p>
<p class="text-[10px] text-slate-400 font-medium italic">Dự kiến Th1 2025</p>
</div>
</div>
<div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
<div class="h-full bg-primary" style="width: 34%;"></div>
</div>
</div>
</div>
</div>
</section>
<!-- Insights Footer Action -->
<section class="mt-16 bg-primary text-white p-12 rounded-[3rem] relative overflow-hidden">
<div class="absolute top-0 right-0 w-1/2 h-full opacity-10">
<div class="w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
</div>
<div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
<div class="max-w-xl text-center md:text-left">
<h4 class="text-3xl font-bold headline mb-4">Tối ưu hóa hành trình thịnh vượng.</h4>
<p class="text-primary-fixed-dim font-medium leading-relaxed">Dựa trên tỷ lệ chi tiêu và quỹ đạo thu nhập hiện tại, AI của chúng tôi gợi ý tăng 12% tốc độ tích lũy "Biệt thự Tuscany" để đạt mục tiêu vào tháng 10/2026 với điểm tin cậy 95%.</p>
</div>
<button class="whitespace-nowrap px-10 py-5 bg-white text-primary rounded-full font-extrabold shadow-2xl hover:scale-105 active:scale-95 transition-all">
                Thực hiện chiến lược tối ưu
            </button>
</div>
</section>
</main>
</body></html>