@extends('layouts.app')

@section('title', 'Quản lý Giao dịch')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Lịch sử Giao dịch</h2>
            <p class="text-outline text-sm mt-1">Quản lý thu nhập và chi tiêu của bạn</p>
        </div>
        <div class="flex gap-4">
            <button onclick="document.getElementById('income-modal').classList.remove('hidden')" class="bg-secondary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-secondary/90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span> Thêm khoản Thu
            </button>
            <button onclick="document.getElementById('expense-modal').classList.remove('hidden')" class="bg-tertiary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-tertiary/90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined" data-icon="remove_circle">remove_circle</span> Thêm khoản Chi
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/20 shadow-sm flex items-center justify-between">
        <form method="GET" action="{{ route('transactions.index') }}" class="flex items-center gap-4 w-full">
            <div class="flex-1 max-w-md relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
                <input type="text" name="search" value="{{ $query ?? '' }}" placeholder="Tìm kiếm theo tên giao dịch, ghi chú..." class="w-full bg-surface-container-low border-none rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-primary text-sm">
            </div>
            <div class="flex items-center gap-2">
                <label for="month" class="text-xs font-bold text-outline">Tháng:</label>
                <input type="month" name="month" value="{{ $month }}" class="bg-surface-container-low border-none rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary text-sm" onchange="this.form.submit()">
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Transactions List -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low text-outline text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Tên giao dịch</th>
                    <th class="px-6 py-4 font-semibold">Ngày</th>
                    <th class="px-6 py-4 font-semibold">Danh mục</th>
                    <th class="px-6 py-4 font-semibold text-right">Số tiền</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $transaction->type == 'thu' ? 'bg-secondary/10 text-secondary' : 'bg-tertiary/10 text-tertiary' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined">{{ $transaction->type == 'thu' ? 'system_update_alt' : 'shopping_cart' }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">{{ $transaction->title }}</p>
                                    @if($transaction->ghi_chu && $transaction->title != $transaction->ghi_chu)
                                        <p class="text-xs text-outline">{{ $transaction->ghi_chu }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-outline tabular-nums">
                            {{ date('d-m-Y', strtotime($transaction->date)) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-outline">
                            <span class="px-3 py-1 bg-surface-container rounded-full text-xs font-medium border border-outline-variant/20">
                                {{ $transaction->danhMuc->ten_danh_muc ?? 'Chưa phân loại' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-base {{ $transaction->type == 'thu' ? 'text-secondary' : 'text-tertiary' }} tabular-nums">
                                {{ $transaction->type == 'thu' ? '+' : '-' }}{{ number_format($transaction->so_tien, 0, ',', '.') }} VNĐ
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-outline">
                            <span class="material-symbols-outlined text-4xl mb-3 block" data-icon="inbox">inbox</span>
                            <p>Chưa có giao dịch nào trong tháng này.</p>
                        </td>
                    </tr>
                @endforelse
            </ul>
        </table>
    </div>
</div>

<!-- Modal: Add Income -->
<div id="income-modal" class="fixed inset-0 bg-black/60 {{ $errors->hasAny(['nguon_thu', 'ngay_nhan']) ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-md border border-outline-variant/10 relative">
        <button onclick="document.getElementById('income-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
        <h3 class="text-xl font-bold mb-6 text-on-surface">Thêm khoản Thu mới</h3>
        <form method="POST" action="{{ route('transactions.income.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Tên nguồn thu</label>
                <input type="text" name="nguon_thu" value="{{ old('nguon_thu') }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('nguon_thu') border border-error bg-error-container/10 @enderror">
                @error('nguon_thu')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Số tiền (VNĐ)</label>
                <input type="number" name="so_tien" value="{{ old('so_tien') }}" min="0" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('so_tien') border border-error bg-error-container/10 @enderror">
                @error('so_tien')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Danh mục</label>
                <select name="danh_muc_id" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('danh_muc_id') border border-error bg-error-container/10 @enderror">
                    @foreach($danhMucs->where('loai', 'thu') as $cat)
                        <option value="{{ $cat->id }}" {{ old('danh_muc_id') == $cat->id ? 'selected' : '' }}>{{ $cat->ten_danh_muc }}</option>
                    @endforeach
                </select>
                @error('danh_muc_id')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Ngày nhận</label>
                <input type="date" name="ngay_nhan" value="{{ old('ngay_nhan', date('Y-m-d')) }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('ngay_nhan') border border-error bg-error-container/10 @enderror">
                @error('ngay_nhan')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Ghi chú (Tuỳ chọn)</label>
                <input type="text" name="ghi_chu" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary">
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-secondary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-secondary/90 transition-all">Lưu Khoản Thu</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Expense -->
<div id="expense-modal" class="fixed inset-0 bg-black/60 {{ $errors->hasAny(['ngay_giao_dich', 'ghi_chu']) && !$errors->has('nguon_thu') ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-md border border-outline-variant/10 relative">
        <button onclick="document.getElementById('expense-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
        <h3 class="text-xl font-bold mb-6 text-on-surface">Thêm khoản Chi mới</h3>
        <form method="POST" action="{{ route('transactions.expense.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Mô tả/Tên giao dịch</label>
                <input type="text" name="ghi_chu" value="{{ old('ghi_chu') }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('ghi_chu') border border-error bg-error-container/10 @enderror">
                @error('ghi_chu')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Số tiền (VNĐ)</label>
                <input type="number" name="so_tien" value="{{ old('so_tien') }}" min="0" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('so_tien') border border-error bg-error-container/10 @enderror">
                @error('so_tien')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Danh mục</label>
                <select name="danh_muc_id" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('danh_muc_id') border border-error bg-error-container/10 @enderror">
                    @foreach($danhMucs->where('loai', 'chi') as $cat)
                        <option value="{{ $cat->id }}" {{ old('danh_muc_id') == $cat->id ? 'selected' : '' }}>{{ $cat->ten_danh_muc }}</option>
                    @endforeach
                </select>
                @error('danh_muc_id')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Ngày giao dịch</label>
                <input type="date" name="ngay_giao_dich" value="{{ old('ngay_giao_dich', date('Y-m-d')) }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('ngay_giao_dich') border border-error bg-error-container/10 @enderror">
                @error('ngay_giao_dich')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-tertiary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-tertiary/90 transition-all">Lưu Khoản Chi</button>
            </div>
        </form>
    </div>
</div>
@endsection
