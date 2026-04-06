<!DOCTYPE html>

<html class="light" lang="vi"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>The Fiscal Curator - Tổng quan</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
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
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .display-num { font-family: 'Manrope', sans-serif; }
        .tabular-nums { font-variant-numeric: tabular-nums; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface text-on-surface overflow-x-hidden">
<!-- SideNavBar -->
<aside class="bg-slate-50 dark:bg-slate-900 h-screen w-64 fixed left-0 top-0 flex flex-col h-full py-6 px-4 z-50">
<div class="mb-10 px-2">
<h1 class="text-lg font-bold tracking-tight text-indigo-900 dark:text-indigo-100">The Fiscal Curator</h1>
<p class="text-[10px] uppercase tracking-widest text-slate-400 font-semibold mt-1">Quản lý Tài sản</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full transition-colors relative text-indigo-700 dark:text-indigo-400 font-semibold before:content-[''] before:absolute before:left-0 before:w-1 before:h-6 before:bg-indigo-700 before:rounded-r-full" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-sm">Tổng quan</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
<span class="text-sm">Giao dịch</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="account_balance_wallet">account_balance_wallet</span>
<span class="text-sm">Ngân sách</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="psychology">psychology</span>
<span class="text-sm">Phân tích AI</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-sm">Cài đặt</span>
</a>
</nav>
<div class="mt-auto pt-6 space-y-4">
<button class="w-full flex items-center justify-center gap-2 bg-gradient-to-br from-primary to-primary-container text-white py-3 rounded-full font-semibold shadow-md hover:opacity-90 transition-all active:scale-95">
<span class="material-symbols-outlined text-sm" data-icon="add">add</span>
<span>Thêm nhanh</span>
</button>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="download">download</span>
<span class="text-sm">Xuất dữ liệu</span>
</a>
<div class="flex items-center gap-3 px-2 pt-4 border-t border-slate-200 dark:border-slate-800">
<img alt="User Profile Avatar" class="w-8 h-8 rounded-full" data-alt="professional male portrait with minimalist lighting and corporate attire on a soft blue background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuClpqZnoy9MLP6N93jySzRtoYA1Ig3aBrKLckAtwINe0PHu7tbvNwrNyZSfEe6J-nmXUvOL4lgipXFryNCAbTQUn9mpfWVHwmhl9ES8k1AQnKAiOUfWhPdXk67QGHHrfF5kuy0Rw_2PgDeh3aieoiGrn_pO59uAfcBeNnLshEYnvHfLDogfafcQU3N5be8CMJz_wAfpxDEBQhZISS1zORSuDps7pdW2a2NA4XcEYb_8y7jW7JDGGNcTr3rf6LVyi9sRfIkG-tkBJgA"/>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">Julian Thorne</p>
<p class="text-[10px] text-slate-500 truncate">Thành viên Premium</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="pl-64 min-h-screen">
<!-- TopNavBar -->
<header class="fixed top-0 right-0 left-64 h-16 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md shadow-sm dark:shadow-none flex items-center justify-between px-8 w-full">
<div class="flex items-center bg-surface-container-low px-4 py-1.5 rounded-full w-96">
<span class="material-symbols-outlined text-outline text-lg" data-icon="search">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-outline" placeholder="Tìm kiếm hồ sơ..." type="text"/>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4 text-slate-600 dark:text-slate-400">
<button class="hover:text-indigo-600 transition-all"><span class="material-symbols-outlined" data-icon="notifications">notifications</span></button>
<button class="hover:text-indigo-600 transition-all"><span class="material-symbols-outlined" data-icon="help_outline">help_outline</span></button>
</div>
<div class="h-8 w-[1px] bg-outline-variant/30"></div>
<img alt="User Profile Image" class="w-9 h-9 rounded-full ring-2 ring-primary/10" data-alt="Close up of a professional male with short dark hair in a corporate headshot with clean lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCLn8-bk9pbabpBEZWvP0730ebhO38l0HXpB3GdovFBdlOuAVlJrfTI26AAA6zndZ9mgayuvJEOKlYA5CdU7HEebPcA_fBKovbq3x6O9LIdYGDIWOUVihh9lV3MPGB_o5xwxCN-SpKEDa7BZc2n8ofPd9JsmKcDN8bZbcjBlC7W812y0gYRDMbcS2cVjbNg7lFQSRqhqFjQkx5FM20510nNN_zAR6MtoPIjN7roA_MO1NBDDDjyHbQLysGgA8dJcDDcwFR55MiJv2E"/>
</div>
</header>
<!-- Dashboard Canvas -->
<section class="pt-24 pb-12 px-8 max-w-7xl mx-auto">
<!-- Hero Balance & Editorial Stats -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 items-end">
<div class="lg:col-span-7">
<span class="text-sm font-semibold text-primary/60 uppercase tracking-widest mb-2 block">Vốn khả dụng</span>
<h2 class="text-6xl font-extrabold tracking-tighter text-on-surface tabular-nums">300.000.000<span class="text-primary/30 text-4xl ml-2">VNĐ</span></h2>
<div class="flex gap-8 mt-6">
<div>
<p class="text-xs text-outline mb-1">Thu nhập tháng</p>
<p class="text-xl font-bold text-secondary tabular-nums">+125.000.000 VNĐ</p>
</div>
<div class="h-10 w-[1px] bg-outline-variant/20 self-center"></div>
<div>
<p class="text-xs text-outline mb-1">Chi tiêu vận hành</p>
<p class="text-xl font-bold text-tertiary tabular-nums">-68.500.000 VNĐ</p>
</div>
</div>
</div>
<div class="lg:col-span-5 flex justify-end">
<div class="bg-surface-container-lowest p-6 rounded-full border border-outline-variant/10 shadow-sm flex items-center gap-6">
<div class="text-right">
<p class="text-[10px] text-outline font-bold uppercase tracking-wider">Tỷ lệ tiết kiệm</p>
<p class="text-2xl font-bold text-primary">45,2%</p>
</div>
<div class="relative w-16 h-16">
<svg class="w-full h-full transform -rotate-90">
<circle class="text-surface-container-high" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-width="4"></circle>
<circle class="text-secondary" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-dasharray="175.9" stroke-dashoffset="96.4" stroke-width="4"></circle>
</svg>
<div class="absolute inset-0 flex items-center justify-center">
<span class="material-symbols-outlined text-secondary text-sm" data-icon="trending_up">trending_up</span>
</div>
</div>
</div>
</div>
</div>
<!-- Bento Grid Dashboard -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<!-- Chart: Monthly Trends -->
<div class="md:col-span-2 bg-surface-container-low rounded-xl p-8 flex flex-col">
<div class="flex justify-between items-center mb-10">
<h3 class="text-lg font-bold">Ma trận Hiệu suất</h3>
<div class="flex gap-2">
<span class="flex items-center gap-1.5 text-xs font-medium text-outline"><span class="w-2 h-2 rounded-full bg-secondary"></span> Thu nhập</span>
<span class="flex items-center gap-1.5 text-xs font-medium text-outline"><span class="w-2 h-2 rounded-full bg-tertiary"></span> Chi phí</span>
</div>
</div>
<div class="flex-1 flex items-end justify-between gap-4 h-48 pb-2 border-b border-outline-variant/10">
<!-- Bar chart simulation -->
<div class="group relative flex-1 flex flex-col items-center gap-2">
<div class="w-full flex flex-col gap-1 items-center justify-end h-full">
<div class="w-4 bg-secondary/20 h-[60%] rounded-t-sm"></div>
<div class="w-4 bg-tertiary/20 h-[40%] rounded-t-sm"></div>
</div>
<span class="text-[10px] text-outline">Tháng 1</span>
</div>
<div class="group relative flex-1 flex flex-col items-center gap-2">
<div class="w-full flex flex-col gap-1 items-center justify-end h-full">
<div class="w-4 bg-secondary/40 h-[75%] rounded-t-sm"></div>
<div class="w-4 bg-tertiary/40 h-[30%] rounded-t-sm"></div>
</div>
<span class="text-[10px] text-outline">Tháng 2</span>
</div>
<div class="group relative flex-1 flex flex-col items-center gap-2">
<div class="w-full flex flex-col gap-1 items-center justify-end h-full">
<div class="w-4 bg-secondary/60 h-[55%] rounded-t-sm"></div>
<div class="w-4 bg-tertiary/60 h-[50%] rounded-t-sm"></div>
</div>
<span class="text-[10px] text-outline">Tháng 3</span>
</div>
<div class="group relative flex-1 flex flex-col items-center gap-2">
<div class="w-full flex flex-col gap-1 items-center justify-end h-full">
<div class="w-4 bg-secondary/80 h-[85%] rounded-t-sm"></div>
<div class="w-4 bg-tertiary/80 h-[45%] rounded-t-sm"></div>
</div>
<span class="text-[10px] text-outline">Tháng 4</span>
</div>
<div class="group relative flex-1 flex flex-col items-center gap-2">
<div class="w-full flex flex-col gap-1 items-center justify-end h-full">
<div class="w-4 bg-secondary h-[95%] rounded-t-sm shadow-lg shadow-secondary/20"></div>
<div class="w-4 bg-tertiary h-[35%] rounded-t-sm shadow-lg shadow-tertiary/20"></div>
</div>
<span class="text-[10px] font-bold text-primary">Tháng 5</span>
</div>
</div>
</div>
<!-- Categories Pie Chart -->
<div class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10">
<h3 class="text-lg font-bold mb-8">Phân bổ</h3>
<div class="relative w-40 h-40 mx-auto mb-8">
<!-- Simulated Pie Chart with conic gradient -->
<div class="w-full h-full rounded-full" style="background: conic-gradient(#24389c 0% 45%, #006c49 45% 70%, #8a0027 70% 85%, #eaedff 85% 100%)"></div>
<div class="absolute inset-4 bg-surface-container-lowest rounded-full flex items-center justify-center">
<div class="text-center">
<p class="text-[10px] text-outline uppercase font-bold">Lớn nhất</p>
<p class="text-sm font-bold">Thuê nhà</p>
</div>
</div>
</div>
<div class="space-y-3">
<div class="flex justify-between items-center text-sm">
<span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-primary"></span> Thuê nhà</span>
<span class="font-semibold tabular-nums">30.800.000 VNĐ</span>
</div>
<div class="flex justify-between items-center text-sm">
<span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-secondary"></span> Du lịch</span>
<span class="font-semibold tabular-nums">17.100.000 VNĐ</span>
</div>
<div class="flex justify-between items-center text-sm">
<span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-tertiary"></span> Ăn uống</span>
<span class="font-semibold tabular-nums">10.200.000 VNĐ</span>
</div>
<div class="flex justify-between items-center text-sm">
<span class="flex items-center gap-2 text-outline"><span class="w-2 h-2 rounded-full bg-surface-container"></span> Khác</span>
<span class="font-semibold tabular-nums">10.400.000 VNĐ</span>
</div>
</div>
</div>
<!-- Recent Activity List (High-end List pattern) -->
<div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10">
<div class="flex justify-between items-center mb-8">
<h3 class="text-lg font-bold">Nhật ký Kiểm toán</h3>
<button class="text-xs font-bold text-primary hover:underline">Xem nhật ký</button>
</div>
<div class="space-y-6">
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
<span class="material-symbols-outlined" data-icon="restaurant">restaurant</span>
</div>
<div>
<p class="text-sm font-bold group-hover:text-primary transition-colors">Artisan Bistro &amp; Bar</p>
<p class="text-[10px] text-outline">Ăn uống &amp; Xã hội · 2 giờ trước</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-tertiary tabular-nums">-3.425.000 VNĐ</p>
<p class="text-[10px] text-outline">TK Cá nhân</p>
</div>
</div>
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
<span class="material-symbols-outlined" data-icon="payments">payments</span>
</div>
<div>
<p class="text-sm font-bold group-hover:text-primary transition-colors">Tech Solutions Inc.</p>
<p class="text-[10px] text-outline">Thu nhập chính · Hôm qua</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-secondary tabular-nums">+62.600.000 VNĐ</p>
<p class="text-[10px] text-outline">TK Doanh nghiệp</p>
</div>
</div>
<div class="flex items-center justify-between group cursor-pointer">
<div class="flex items-center gap-4">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
<span class="material-symbols-outlined" data-icon="flight_takeoff">flight_takeoff</span>
</div>
<div>
<p class="text-sm font-bold group-hover:text-primary transition-colors">Skyline Airways</p>
<p class="text-[10px] text-outline">Du lịch · 14 tháng 5</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-bold text-tertiary tabular-nums">-20.840.000 VNĐ</p>
<p class="text-[10px] text-outline">Quỹ Du lịch</p>
</div>
</div>
</div>
</div>
<!-- Quick Insights / AI Card -->
<div class="bg-primary text-on-primary rounded-xl p-8 relative overflow-hidden flex flex-col justify-between">
<!-- Glassy Background Decoration -->
<div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
<div class="relative z-10">
<div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-lg flex items-center justify-center mb-6">
<span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
</div>
<h4 class="text-xl font-bold mb-2">Gợi ý từ Curator</h4>
<p class="text-sm text-on-primary/80 leading-relaxed mb-6">Chi tiêu không thiết yếu của bạn thấp hơn 12% so với tháng trước. Hãy cân nhắc chuyển <span class="font-bold text-white">10.000.000 VNĐ</span> vào danh mục đầu tư lãi suất cao.</p>
</div>
<button class="relative z-10 w-full py-3 bg-white text-primary font-bold rounded-full text-sm shadow-xl active:scale-95 transition-all">
                    Thực hiện kiến nghị
                </button>
</div>
</div>
</section>
</main>
</body></html>