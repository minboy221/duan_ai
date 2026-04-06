<!DOCTYPE html>

<html class="light" lang="vi"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Quản lý Giao dịch - The Fiscal Curator</title>
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
                        "surface-bright": "#faf8ff",
                        "on-surface": "#131b2e",
                        "surface-variant": "#dae2fd"
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
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; }
        .tabular-nums { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-surface text-on-surface">
<!-- SideNavBar -->
<aside class="bg-slate-50 dark:bg-slate-900 h-screen w-64 fixed left-0 top-0 flex flex-col py-6 px-4 z-50">
<div class="mb-10 px-2">
<h1 class="text-lg font-bold tracking-tight text-indigo-900 dark:text-indigo-100">The Fiscal Curator</h1>
<p class="text-xs text-slate-500 font-medium tracking-wide">Quản lý Tài chính</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="font-medium">Bảng điều khiển</span>
</a>
<!-- Active State: Transactions -->
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full relative text-indigo-700 dark:text-indigo-400 font-semibold before:content-[''] before:absolute before:left-0 before:w-1 before:h-6 before:bg-indigo-700 before:rounded-r-full bg-slate-200/50 dark:bg-slate-800/50" href="#">
<span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
<span class="font-medium">Giao dịch</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="account_balance_wallet">account_balance_wallet</span>
<span class="font-medium">Ngân sách</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="psychology">psychology</span>
<span class="font-medium">Thông tin AI</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="font-medium">Cài đặt</span>
</a>
</nav>
<div class="mt-auto space-y-4 pt-6">
<button class="w-full py-3 bg-gradient-to-br from-primary to-primary-container text-white rounded-full font-semibold shadow-md flex items-center justify-center gap-2 hover:opacity-90 transition-all">
<span class="material-symbols-outlined text-sm" data-icon="add">add</span>
            Thêm nhanh
        </button>
<div class="pt-4 border-t border-slate-200 dark:border-slate-800">
<a class="flex items-center gap-3 px-3 py-2 rounded-full text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="download">download</span>
<span class="text-sm font-medium">Xuất dữ liệu</span>
</a>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="ml-64 min-h-screen relative pb-12">
<!-- TopNavBar -->
<header class="fixed top-0 right-0 left-64 h-16 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md flex items-center justify-between px-8 w-full shadow-sm dark:shadow-none">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full group">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl" data-icon="search">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-400" placeholder="Tìm kiếm giao dịch, danh mục, hoặc mô tả..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-all">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-all">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
<div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>
<div class="flex items-center gap-3">
<img alt="Ảnh hồ sơ người dùng" class="w-8 h-8 rounded-full border border-slate-200" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQndZ9Y7dpdU5JezZyUpW0AZGcvHBgeUac5e9LX2bdfUZqp0fzeNJi159rb8V9wbyriExVyzEdgTo6jCRVvo2RoIR62Smfv-CL-9aoukKV7eyYBv1FtTZ8ubyPV9PoXS7glQqPKv8Mz5u9sn0WiPiRu3c6SiRsgVxKO2KtOsLSmqfqG0RET9LDrWwndlHDXdaUtujZNuj-ObafEuc5nr8Dan6h14JVVDZRXCZM359ubBqFyj3AXon7okrbtL4nwS_EMrFQ6e6RM8Y"/>
</div>
</div>
</header>
<!-- Page Content -->
<div class="pt-24 px-8 max-w-7xl mx-auto">
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-6">
<div>
<h2 class="text-4xl font-extrabold tracking-tight text-indigo-950 mb-1">Lịch sử Giao dịch</h2>
<p class="text-on-surface-variant font-medium">Quản lý và biên tập dấu ấn tài chính của bạn với độ chính xác cao.</p>
</div>
<div class="flex items-center gap-3">
<button class="flex items-center gap-2 bg-secondary-container text-on-secondary-container px-6 py-3 rounded-full font-bold shadow-sm hover:opacity-90 transition-all">
<span class="material-symbols-outlined" data-icon="auto_awesome" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    Thêm nhanh bằng AI
                </button>
</div>
</div>
<!-- Bento Filter Bar -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
<div class="md:col-span-1 p-4 bg-surface-container-lowest rounded-xl shadow-sm flex flex-col justify-center">
<label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Khoảng thời gian</label>
<div class="flex items-center justify-between text-on-surface">
<span class="font-semibold text-sm">30 ngày qua</span>
<span class="material-symbols-outlined text-sm" data-icon="calendar_month">calendar_month</span>
</div>
</div>
<div class="md:col-span-1 p-4 bg-surface-container-lowest rounded-xl shadow-sm flex flex-col justify-center">
<label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Danh mục</label>
<div class="flex items-center justify-between text-on-surface">
<span class="font-semibold text-sm">Tất cả danh mục</span>
<span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
</div>
</div>
<div class="md:col-span-1 p-4 bg-surface-container-lowest rounded-xl shadow-sm flex flex-col justify-center">
<label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Trạng thái</label>
<div class="flex items-center justify-between text-on-surface">
<span class="font-semibold text-sm">Hoàn tất</span>
<span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
</div>
</div>
<div class="md:col-span-1 p-4 bg-primary text-white rounded-xl shadow-lg flex flex-col justify-center">
<label class="text-[10px] font-bold uppercase tracking-widest text-primary-fixed opacity-70 mb-1">Số dư hiện tại</label>
<div class="flex items-baseline gap-1">
<span class="text-2xl font-bold tabular-nums">42.850.000đ</span>
<span class="text-xs text-secondary-fixed">+12%</span>
</div>
</div>
</div>
<!-- Transaction List -->
<div class="bg-surface-container-low rounded-xl p-1 overflow-hidden">
<div class="grid grid-cols-12 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 bg-surface-container-low">
<div class="col-span-2">Ngày</div>
<div class="col-span-3">Danh mục</div>
<div class="col-span-5">Mô tả</div>
<div class="col-span-2 text-right">Số tiền</div>
</div>
<div class="flex flex-col gap-1">
<!-- Row 1 -->
<div class="grid grid-cols-12 items-center px-6 py-4 bg-surface-container-lowest hover:bg-surface-container-high transition-colors group cursor-pointer">
<div class="col-span-2 text-sm font-medium tabular-nums text-slate-600">24 Th10, 2023</div>
<div class="col-span-3">
<span class="px-3 py-1 bg-surface-variant text-primary text-xs font-semibold rounded-full">Quản lý Tài sản</span>
</div>
<div class="col-span-5 text-sm font-semibold text-on-surface">Tái đầu tư cổ tức - Vanguard</div>
<div class="col-span-2 text-right text-sm font-bold tabular-nums text-secondary">+1.240.000đ</div>
</div>
<!-- Row 2 -->
<div class="grid grid-cols-12 items-center px-6 py-4 bg-surface-container-low hover:bg-surface-container-high transition-colors group cursor-pointer">
<div class="col-span-2 text-sm font-medium tabular-nums text-slate-600">23 Th10, 2023</div>
<div class="col-span-3">
<span class="px-3 py-1 bg-tertiary-fixed text-tertiary text-xs font-semibold rounded-full">Ẩm thực cao cấp</span>
</div>
<div class="col-span-5 text-sm font-semibold text-on-surface">The Gilded Fork - Ăn trưa khách hàng</div>
<div class="col-span-2 text-right text-sm font-bold tabular-nums text-tertiary">-450.250đ</div>
</div>
<!-- Row 3 -->
<div class="grid grid-cols-12 items-center px-6 py-4 bg-surface-container-lowest hover:bg-surface-container-high transition-colors group cursor-pointer">
<div class="col-span-2 text-sm font-medium tabular-nums text-slate-600">22 Th10, 2023</div>
<div class="col-span-3">
<span class="px-3 py-1 bg-slate-200 text-slate-600 text-xs font-semibold rounded-full">Tiện ích</span>
</div>
<div class="col-span-5 text-sm font-semibold text-on-surface">Dịch vụ đám mây - AWS Enterprise</div>
<div class="col-span-2 text-right text-sm font-bold tabular-nums text-tertiary">-89.990đ</div>
</div>
<!-- Row 4 -->
<div class="grid grid-cols-12 items-center px-6 py-4 bg-surface-container-low hover:bg-surface-container-high transition-colors group cursor-pointer">
<div class="col-span-2 text-sm font-medium tabular-nums text-slate-600">21 Th10, 2023</div>
<div class="col-span-3">
<span class="px-3 py-1 bg-secondary-fixed text-on-secondary-container text-xs font-semibold rounded-full">Thu nhập</span>
</div>
<div class="col-span-5 text-sm font-semibold text-on-surface">Phí tư vấn - Nexus Group</div>
<div class="col-span-2 text-right text-sm font-bold tabular-nums text-secondary">+8.500.000đ</div>
</div>
<!-- Row 5 -->
<div class="grid grid-cols-12 items-center px-6 py-4 bg-surface-container-lowest hover:bg-surface-container-high transition-colors group cursor-pointer">
<div class="col-span-2 text-sm font-medium tabular-nums text-slate-600">20 Th10, 2023</div>
<div class="col-span-3">
<span class="px-3 py-1 bg-tertiary-fixed text-tertiary text-xs font-semibold rounded-full">Mua sắm</span>
</div>
<div class="col-span-5 text-sm font-semibold text-on-surface">Apple Store - MacBook Pro M3</div>
<div class="col-span-2 text-right text-sm font-bold tabular-nums text-tertiary">-62.499.000đ</div>
</div>
<!-- Row 6 -->
<div class="grid grid-cols-12 items-center px-6 py-4 bg-surface-container-low hover:bg-surface-container-high transition-colors group cursor-pointer">
<div class="col-span-2 text-sm font-medium tabular-nums text-slate-600">19 Th10, 2023</div>
<div class="col-span-3">
<span class="px-3 py-1 bg-surface-variant text-primary text-xs font-semibold rounded-full">Du lịch</span>
</div>
<div class="col-span-5 text-sm font-semibold text-on-surface">British Airways - LHR đến JFK</div>
<div class="col-span-2 text-right text-sm font-bold tabular-nums text-tertiary">-11.120.500đ</div>
</div>
</div>
</div>
<!-- Pagination/Footer -->
<div class="mt-8 flex items-center justify-between">
<p class="text-sm text-slate-500 font-medium">Đang hiển thị <span class="text-on-surface font-bold">1-6</span> trên <span class="text-on-surface font-bold">240</span> giao dịch</p>
<div class="flex items-center gap-2">
<button class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-400 hover:bg-white transition-colors disabled:opacity-50" disabled="">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white font-bold shadow-sm">1</button>
<button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white text-slate-600 font-bold transition-colors">2</button>
<button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white text-slate-600 font-bold transition-colors">3</button>
<button class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-600 hover:bg-white transition-colors">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
</div>
</main>
<!-- Modal Backdrop -->
<div class="fixed inset-0 z-[100] bg-on-surface/40 backdrop-blur-md flex items-center justify-center p-4">
<!-- AI Quick Add Modal -->
<div class="bg-surface-container-lowest w-full max-w-lg rounded-full overflow-hidden shadow-[0_40px_60px_-15px_rgba(19,27,46,0.2)] p-8">
<div class="flex items-center gap-4 mb-6">
<div class="w-12 h-12 bg-secondary-container rounded-full flex items-center justify-center text-on-secondary-container">
<span class="material-symbols-outlined text-2xl" data-icon="auto_awesome" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
</div>
<div>
<h3 class="text-xl font-bold text-indigo-950">Trợ lý Giao dịch AI</h3>
<p class="text-sm text-on-surface-variant">Mô tả việc chi tiêu của bạn bằng ngôn ngữ tự nhiên.</p>
</div>
</div>
<div class="relative mb-6">
<textarea class="w-full bg-surface-container-low border-none rounded-xl p-4 text-on-surface placeholder:text-slate-400 focus:ring-2 focus:ring-secondary/30 transition-all resize-none font-medium" placeholder="VD: 'Đã chi 50.000đ ăn trưa tại Starbucks hôm nay'" rows="4"></textarea>
<div class="absolute bottom-3 right-3 flex gap-2">
<span class="material-symbols-outlined text-slate-300" data-icon="mic">mic</span>
<span class="material-symbols-outlined text-slate-300" data-icon="attach_file">attach_file</span>
</div>
</div>
<div class="flex items-center gap-3">
<button class="flex-1 py-3 bg-gradient-to-r from-secondary to-on-secondary-container text-white rounded-full font-bold shadow-lg hover:shadow-secondary/20 transition-all flex items-center justify-center gap-2">
                Phân tích &amp; Ghi lại
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
</button>
<button class="px-6 py-3 text-slate-500 font-semibold hover:text-tertiary transition-colors">Hủy</button>
</div>
<div class="mt-6 pt-6 border-t border-slate-100">
<p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Hãy thử nói...</p>
<div class="flex flex-wrap gap-2">
<span class="px-3 py-1 bg-surface-container-low text-xs text-indigo-700 font-medium rounded-full cursor-pointer hover:bg-primary/5 transition-colors">"Chuyến Grab hết 24.500đ"</span>
<span class="px-3 py-1 bg-surface-container-low text-xs text-indigo-700 font-medium rounded-full cursor-pointer hover:bg-primary/5 transition-colors">"Đã nhận 12.000.000đ tiền thuê nhà"</span>
</div>
</div>
</div>
</div>
</body></html>