<!DOCTYPE html>

<html class="light" lang="vi"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Phân tích AI - The Fiscal Curator</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap" rel="stylesheet"/>
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
        h1, h2, h3, .headline { font-family: 'Manrope', sans-serif; }
        .tabular-nums { font-variant-numeric: tabular-nums; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 dark:bg-slate-900 flex flex-col py-6 px-4 z-50">
<div class="mb-10 px-2">
<h1 class="text-lg font-bold tracking-tight text-indigo-900 dark:text-indigo-100">The Fiscal Curator</h1>
<p class="text-xs text-slate-500 font-medium">Quản lý Tài sản</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full transition-colors text-slate-500 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-sm font-medium">Bảng điều khiển</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full transition-colors text-slate-500 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50" href="#">
<span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
<span class="text-sm font-medium">Giao dịch</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full transition-colors text-slate-500 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50" href="#">
<span class="material-symbols-outlined" data-icon="account_balance_wallet">account_balance_wallet</span>
<span class="text-sm font-medium">Ngân sách</span>
</a>
<!-- Active Navigation: Phân tích AI -->
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full relative text-indigo-700 dark:text-indigo-400 font-semibold before:content-[''] before:absolute before:left-0 before:w-1 before:h-6 before:bg-indigo-700 before:rounded-r-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="psychology" style="font-variation-settings: 'FILL' 1;">psychology</span>
<span class="text-sm font-medium">Phân tích AI</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-full transition-colors text-slate-500 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-sm font-medium">Cài đặt</span>
</a>
</nav>
<div class="mt-auto space-y-4">
<button class="w-full py-3 px-4 rounded-full bg-primary text-on-primary font-semibold text-sm flex items-center justify-center gap-2 shadow-lg hover:opacity-90 transition-all">
<span class="material-symbols-outlined text-sm" data-icon="add">add</span>
                Thêm nhanh
            </button>
<div class="pt-4 border-t border-slate-200 dark:border-slate-800">
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="download">download</span>
<span class="text-xs font-medium">Xuất dữ liệu</span>
</a>
</div>
</div>
</aside>
<!-- TopNavBar -->
<header class="fixed top-0 right-0 left-64 h-16 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md shadow-sm dark:shadow-none flex items-center justify-between px-8">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" data-icon="search">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Tìm kiếm phân tích..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4">
<button class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-all">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-all">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
</div>
<div class="flex items-center gap-3 border-l border-slate-200 dark:border-slate-800 pl-6">
<div class="text-right">
<p class="text-sm font-semibold leading-none">Julian Vane</p>
<p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold mt-1">Thành viên Premium</p>
</div>
<img alt="Ảnh đại diện người dùng" class="w-10 h-10 rounded-full object-cover border-2 border-surface-container-high" data-alt="Portrait of a sophisticated man in a dark turtleneck in a minimalist studio setting with soft lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCHC7TQepy8Ilgzx8GsqE012mjgWS4bYgW4RyrgUMa5zetdkMJl_ISjxUVW8VMgLhIPjA2sLhhf21na5fkFnG-wxSxyw65w3qi1wIdo7dBVHpr7q01MTvVaOyJFErtlnDEBDkXxSpERKR4pAToNhfs4m7spQuy_scOZNp-GdWHwQoTlVqME4VVJC2QxBDPtfXzxT2ekDdrg5xs0VH49h4Gkw695556OjicrS2IW2g6-ing8aVuc1f3HeAQAwU0CcKZtceM6c5eF13Y"/>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<!-- Hero Section: Editorial Spending Habits -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
<div class="lg:col-span-7 bg-surface-container-lowest rounded-full p-10 flex flex-col justify-center relative overflow-hidden group">
<div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-primary/10 transition-colors"></div>
<h2 class="text-sm font-bold text-primary uppercase tracking-[0.2em] mb-4">Phân tích chuyên sâu</h2>
<h3 class="text-5xl font-extrabold headline leading-[1.1] mb-8 max-w-md">Thói quen chi tiêu của bạn</h3>
<div class="space-y-6 max-w-lg">
<div class="space-y-2">
<div class="flex justify-between items-end">
<span class="text-lg font-semibold">Phong cách sống &amp; Giải trí</span>
<span class="text-2xl font-bold tabular-nums text-primary">45%</span>
</div>
<div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-gradient-to-r from-primary to-primary-container rounded-full w-[45%]"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between items-end">
<span class="text-lg font-semibold">Chi phí cố định &amp; Tiện ích</span>
<span class="text-2xl font-bold tabular-nums text-secondary">30%</span>
</div>
<div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-gradient-to-r from-secondary to-secondary-container rounded-full w-[30%]"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between items-end">
<span class="text-lg font-semibold">Tiết kiệm &amp; Đầu tư</span>
<span class="text-2xl font-bold tabular-nums text-tertiary">25%</span>
</div>
<div class="h-3 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-gradient-to-r from-tertiary to-tertiary-container rounded-full w-[25%]"></div>
</div>
</div>
</div>
</div>
<div class="lg:col-span-5 bg-primary rounded-full p-10 text-on-primary flex flex-col justify-between shadow-2xl relative overflow-hidden">
<img alt="Biểu diễn dữ liệu trừu tượng" class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-overlay" data-alt="Abstract 3D crystalline structures with ethereal light refracting through dark indigo and glowing teal surfaces" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAXs7uQ-1ZTc_ZfojBI4HyWUnFXFa0XH542rLCJhJzckkxFq-xg9iGVH1Iw7bMtVukwNSGiQlFA8Gm7OWf8QG2IiBZ-RV3fzJ0Vqm3w8a5MD9a7HehM9Kbj37amqh_Oc0QaEPipvMVXq4QzAfoij7DYWybe2qFQLdGOM5wSDXZWAlT8bL5hUc4zI2haYzc04ePNO0lbOzaSVnG_UbtSKwEjPP1avx2H0M_pmg0AzHHjIh-n71tuiL2Z4Jg1ZzLCbvjwMnCH82RJTI"/>
<div class="relative z-10">
<div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
</div>
<h4 class="text-2xl font-bold mb-4 headline">Dự báo thông minh</h4>
<p class="text-indigo-100/80 leading-relaxed mb-6">Dựa trên quỹ đạo hiện tại, bạn dự kiến sẽ vượt mục tiêu tiết kiệm hàng tháng khoảng <span class="text-white font-bold">31.000.000 VNĐ</span>.</p>
<div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/10">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-secondary-fixed" data-icon="trending_up">trending_up</span>
<span class="text-sm font-medium">+12.4% hiệu quả so với tháng trước</span>
</div>
</div>
</div>
<button class="relative z-10 mt-8 w-full py-4 bg-white text-primary font-bold rounded-full hover:bg-indigo-50 transition-colors shadow-lg">
                    Tạo báo cáo đầy đủ
                </button>
</div>
</section>
<!-- AI Advice Bento Grid -->
<div class="mb-8 flex items-center justify-between">
<h3 class="text-2xl font-bold headline">Đề xuất từ AI</h3>
<button class="text-sm font-bold text-primary flex items-center gap-1 group">
                Cập nhật phân tích 
                <span class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform" data-icon="refresh">refresh</span>
</button>
</div>
<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<!-- Advice Card 1 -->
<div class="bg-surface-container-lowest p-8 rounded-full border-none shadow-sm group hover:bg-surface-container-low transition-all">
<div class="w-10 h-10 rounded-full bg-tertiary-fixed text-tertiary flex items-center justify-center mb-6">
<span class="material-symbols-outlined" data-icon="restaurant" style="font-variation-settings: 'FILL' 1;">restaurant</span>
</div>
<h4 class="font-bold text-lg mb-3">Thói quen ăn uống</h4>
<p class="text-slate-600 text-sm leading-relaxed mb-6">Bạn đã chi <span class="font-bold text-tertiary">nhiều hơn 20%</span> cho việc ăn ngoài so với tháng trước. Hãy cân nhắc nấu ăn tại nhà cuối tuần này để cân bằng ngân sách.</p>
<div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
<span>Tiết kiệm tiềm năng</span>
<span class="text-tertiary">3.600.000 VNĐ</span>
</div>
</div>
<!-- Advice Card 2 -->
<div class="bg-surface-container-lowest p-8 rounded-full border-none shadow-sm group hover:bg-surface-container-low transition-all">
<div class="w-10 h-10 rounded-full bg-secondary-fixed text-secondary flex items-center justify-center mb-6">
<span class="material-symbols-outlined" data-icon="electric_bolt" style="font-variation-settings: 'FILL' 1;">electric_bolt</span>
</div>
<h4 class="font-bold text-lg mb-3">Tối ưu hóa tiện ích</h4>
<p class="text-slate-600 text-sm leading-relaxed mb-6">Hóa đơn năng lượng của bạn đã tăng liên tục trong 3 tháng. Chuyển sang 'Gói Thông minh' với nhà cung cấp hiện tại có thể giúp bạn tiết kiệm chi phí đáng kể.</p>
<div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
<span>ROI dự kiến</span>
<span class="text-secondary">8.2% năm</span>
</div>
</div>
<!-- Advice Card 3 -->
<div class="bg-surface-container-lowest p-8 rounded-full border-none shadow-sm group hover:bg-surface-container-low transition-all">
<div class="w-10 h-10 rounded-full bg-primary-fixed text-primary flex items-center justify-center mb-6">
<span class="material-symbols-outlined" data-icon="subscriptions" style="font-variation-settings: 'FILL' 1;">subscriptions</span>
</div>
<h4 class="font-bold text-lg mb-3">Kiểm tra đăng ký</h4>
<p class="text-slate-600 text-sm leading-relaxed mb-6">Chúng tôi phát hiện 3 dịch vụ phát trực tuyến không được sử dụng trong 30 ngày qua. Hãy hủy chúng để giải phóng vốn cho 'Quỹ Khẩn cấp'.</p>
<div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
<span>Số tiền tăng thêm mỗi tháng</span>
<span class="text-primary">1.100.000 VNĐ</span>
</div>
</div>
</section>
<!-- Anomaly Detection Section -->
<section class="bg-surface-container-low rounded-[2rem] p-10">
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
<div>
<div class="flex items-center gap-3 mb-2">
<span class="material-symbols-outlined text-tertiary" data-icon="warning">warning</span>
<h3 class="text-2xl font-bold headline">Phát hiện bất thường</h3>
</div>
<p class="text-slate-500 text-sm">Theo dõi thời gian thực các mẫu chi tiêu bất thường hoặc các khoản phí trùng lặp.</p>
</div>
<div class="flex gap-2">
<span class="px-4 py-2 bg-tertiary-container text-white text-xs font-bold rounded-full">2 Ưu tiên cao</span>
<span class="px-4 py-2 bg-surface-container-high text-on-surface-variant text-xs font-bold rounded-full">1 Trùng lặp tiềm ẩn</span>
</div>
</div>
<div class="space-y-4">
<!-- Anomaly Item 1 -->
<div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all">
<div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
<img alt="Logo nhà bán hàng" class="w-8 h-8 rounded-lg object-contain" data-alt="Minimalist technology company logo with clean geometric shapes on a white background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAf4Qz1rpbxN8SaEBsylB_nwt3MBjvFNzQ4_guhXoM8ozUHWAbvyIJytPH6tmGzehzt9bhYny4-1k7McsK_GOuuU66kbvXBCo5ekB9-kKESWfUWz6WvYinNPlyEUwG0EmpK3glEADJEF3tNMGbkys50pnsLq073GjC8le6ug6ItQkDbj0-aOBqWffkEnw8oII6yjpbshTCokrXsdYwwm0HzgMjiblbRa3wFjfl4ISnDyDbykNH05cZHms1iBPW7Jw88gHPZSy060x0"/>
</div>
<div class="flex-1">
<div class="flex items-center gap-2 mb-1">
<h5 class="font-bold">CloudStorage Pro</h5>
<span class="text-[10px] bg-tertiary/10 text-tertiary px-2 py-0.5 rounded-full font-bold">SỐ TIỀN BẤT THƯỜNG</span>
</div>
<p class="text-sm text-slate-500">Giao dịch này cao hơn 300% so với hóa đơn hàng tháng trung bình của bạn (250.000 VNĐ).</p>
</div>
<div class="text-right">
<p class="text-xl font-extrabold headline tabular-nums">1.000.000 VNĐ</p>
<p class="text-xs text-slate-400">24 Tháng 10, 2023</p>
</div>
<div class="flex gap-2 ml-4">
<button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
</button>
<button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-tertiary transition-colors">
<span class="material-symbols-outlined" data-icon="flag">flag</span>
</button>
</div>
</div>
<!-- Anomaly Item 2 -->
<div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all">
<div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center shrink-0 text-slate-400">
<span class="material-symbols-outlined text-3xl" data-icon="shopping_bag">shopping_bag</span>
</div>
<div class="flex-1">
<div class="flex items-center gap-2 mb-1">
<h5 class="font-bold">Apple Store London</h5>
<span class="text-[10px] bg-tertiary/10 text-tertiary px-2 py-0.5 rounded-full font-bold">BẤT THƯỜNG VỊ TRÍ</span>
</div>
<p class="text-sm text-slate-500">Mua hàng lần đầu tại địa điểm này. Có phải là bạn không?</p>
</div>
<div class="text-right">
<p class="text-xl font-extrabold headline tabular-nums">32.500.000 VNĐ</p>
<p class="text-xs text-slate-400">23 Tháng 10, 2023</p>
</div>
<div class="flex gap-2 ml-4">
<button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
</button>
<button class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-tertiary transition-colors">
<span class="material-symbols-outlined" data-icon="report">report</span>
</button>
</div>
</div>
<!-- Anomaly Item 3 -->
<div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row items-center gap-6 group hover:shadow-md transition-all border border-dashed border-primary/20">
<div class="w-14 h-14 bg-primary/5 rounded-xl flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary" data-icon="content_copy">content_copy</span>
</div>
<div class="flex-1">
<div class="flex items-center gap-2 mb-1">
<h5 class="font-bold">Gói đăng ký Netflix</h5>
<span class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">TRÙNG LẶP TIỀM ẨN</span>
</div>
<p class="text-sm text-slate-500">Phát hiện hai khoản phí giống hệt nhau trong vòng 24 giờ. Hãy kiểm tra lỗi thanh toán.</p>
</div>
<div class="text-right">
<p class="text-xl font-extrabold headline tabular-nums">400.000 VNĐ</p>
<p class="text-xs text-slate-400">22 Tháng 10, 2023</p>
</div>
<div class="flex gap-2 ml-4">
<button class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-full hover:opacity-90 transition-opacity">
                            Giải quyết
                        </button>
</div>
</div>
</div>
</section>
</main>
</body></html>