@extends('layouts.app')

@section('title', 'Ngân sách Tháng')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Quản lý Ngân sách</h2>
            <p class="text-outline text-sm mt-1">Kiểm soát chi tiêu theo các hạn mức đã thiết lập</p>
        </div>
        <button onclick="document.getElementById('budget-modal').classList.remove('hidden')" class="bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span> Thêm Ngân sách
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/20 shadow-sm flex items-center justify-between mb-6">
        <form method="GET" action="{{ route('ngansach') }}" class="flex items-center gap-4 w-full">
            <div class="flex items-center gap-2">
                <label for="month" class="text-xs font-bold text-outline">Thời gian:</label>
                <select name="month" class="bg-surface-container-low border-none rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary text-sm" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                    @endfor
                </select>
                <select name="year" class="bg-surface-container-low border-none rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary text-sm" onchange="this.form.submit()">
                    @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Năm {{ $y }}</option>
                    @endfor
                </select>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Budgets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($budgets as $budget)
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/20 shadow-sm relative overflow-hidden group">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">{{ $budget->danhMuc->bieu_tuong ?? 'category' }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg leading-tight">{{ $budget->danhMuc->ten_danh_muc }}</h3>
                            <p class="text-[10px] text-outline font-medium tracking-wider uppercase">Ngân sách tháng {{ $budget->thang }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-tertiary font-bold text-2xl tabular-nums">{{ number_format($budget->da_chi_tieu, 0, ',', '.') }}₫</span>
                        <span class="text-outline text-sm font-medium tabular-nums">/ {{ number_format($budget->so_tien_han_muc, 0, ',', '.') }}₫</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-surface-container-high rounded-full h-2.5 mb-1 overflow-hidden relative">
                        <div class="{{ $budget->phan_tram >= 100 ? 'bg-error' : ($budget->phan_tram >= 80 ? 'bg-tertiary' : 'bg-primary') }} h-2.5 rounded-full transition-all duration-1000 ease-out" 
                             style="width: {{ $budget->phan_tram }}%"></div>
                    </div>
                    
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="{{ $budget->phan_tram >= 100 ? 'text-error' : 'text-outline' }}">{{ $budget->phan_tram }}% Đã dùng</span>
                        @if($budget->phan_tram >= 100)
                            <span class="text-error">Vượt quá ngân sách!</span>
                        @else
                            <span class="text-secondary">Còn lại: {{ number_format($budget->so_tien_han_muc - $budget->da_chi_tieu, 0, ',', '.') }}₫</span>
                        @endif
                    </div>
                </div>
                
                <form action="{{ route('budget.destroy', $budget->id) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-error/70 hover:text-error hover:bg-error/10 w-8 h-8 rounded-full flex items-center justify-center transition-colors" onclick="return confirm('Bạn có chắc muốn xoá ngân sách này?')">
                        <span class="material-symbols-outlined" style="font-size: 18px;" data-icon="delete">delete</span>
                    </button>
                </form>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 text-center bg-surface-container-lowest py-16 rounded-2xl border border-outline-variant/20 border-dashed">
                <span class="material-symbols-outlined text-4xl text-outline mb-3" data-icon="account_balance_wallet">account_balance_wallet</span>
                <p class="text-outline font-medium">Chưa có ngân sách nào được thiết lập cho tháng này.</p>
                <button onclick="document.getElementById('budget-modal').classList.remove('hidden')" class="mt-4 text-primary font-bold hover:underline">Tạo ngay</button>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal: Add Budget -->
<div id="budget-modal" class="fixed inset-0 bg-black/60 {{ $errors->hasAny(['so_tien_han_muc', 'danh_muc_id']) ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-md border border-outline-variant/10 relative">
        <button onclick="document.getElementById('budget-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
        <h3 class="text-xl font-bold mb-6 text-on-surface">Thiết lập Ngân sách</h3>
        <form method="POST" action="{{ route('budget.store') }}" class="space-y-4">
            @csrf
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold mb-2">Tháng</label>
                    <input type="number" name="thang" min="1" max="12" value="{{ old('thang', $month) }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('thang') border border-error bg-error-container/10 @enderror">
                    @error('thang')
                        <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold mb-2">Năm</label>
                    <input type="number" name="nam" min="2000" max="2100" value="{{ old('nam', $year) }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('nam') border border-error bg-error-container/10 @enderror">
                    @error('nam')
                        <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-2">Danh mục chi tiêu</label>
                <select name="danh_muc_id" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary">
                    <option value="" disabled selected>Chọn danh mục</option>
                    @foreach($danhMucs as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->ten_danh_muc }}</option>
                    @endforeach
                </select>
                @if($danhMucs->isEmpty())
                    <p class="text-xs text-tertiary mt-2">Tất cả danh mục chi tiêu đã được cài ngân sách trong tháng này.</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Hạn mức (VNĐ)</label>
                <input type="text" name="so_tien_han_muc" value="{{ old('so_tien_han_muc') }}" class="money-input w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('so_tien_han_muc') border border-error bg-error-container/10 @enderror" placeholder="0">
                @error('so_tien_han_muc')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition-all">Lưu Ngân sách</button>
            </div>
        </form>
    </div>
</div>
@endsection
