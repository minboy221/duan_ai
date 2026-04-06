@extends('layouts.app')

@section('title', 'Giao dịch Định kỳ')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Lập lịch Giao dịch</h2>
            <p class="text-outline text-sm mt-1">Tự động hoá các khoản thu chi lặp lại hàng ngày, tuần, tháng</p>
        </div>
        <button onclick="document.getElementById('recurring-modal').classList.remove('hidden')" class="bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined" data-icon="update">update</span> Thêm Lịch mới
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Recurring List -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low text-outline text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Loại & Danh mục</th>
                    <th class="px-6 py-4 font-semibold">Số tiền</th>
                    <th class="px-6 py-4 font-semibold">Chu kỳ</th>
                    <th class="px-6 py-4 font-semibold">Trạng thái</th>
                    <th class="px-6 py-4 font-semibold text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($recurrings as $item)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $item->loai_giao_dich == 'thu' ? 'bg-secondary/10 text-secondary' : 'bg-tertiary/10 text-tertiary' }} flex items-center justify-center">
                                    <span class="material-symbols-outlined">{{ $item->loai_giao_dich == 'thu' ? 'trending_up' : 'trending_down' }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">{{ $item->danhMuc->ten_danh_muc ?? 'Chưa rõ' }}</p>
                                    <p class="text-[10px] text-outline uppercase font-bold tracking-tight">Bắt đầu: {{ date('d/m/Y', strtotime($item->ngay_bat_dau)) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold tabular-nums {{ $item->loai_giao_dich == 'thu' ? 'text-secondary' : 'text-tertiary' }}">
                                {{ number_format($item->so_tien, 0, ',', '.') }}₫
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-surface-container rounded-full text-xs font-medium border border-outline-variant/20">
                                @switch($item->chu_ky)
                                    @case('hang_ngay') Hàng ngày @break
                                    @case('hang_tuan') Hàng tuần @break
                                    @case('hang_thang') Hàng tháng @break
                                    @case('hang_nam') Hàng năm @break
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('recurring.toggle', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="flex items-center gap-2 group">
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $item->trang_thai == 'hoat_dong' ? 'bg-secondary' : 'bg-outline' }} opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 {{ $item->trang_thai == 'hoat_dong' ? 'bg-secondary' : 'bg-outline' }}"></span>
                                    </span>
                                    <span class="text-xs font-bold uppercase transition-colors {{ $item->trang_thai == 'hoat_dong' ? 'text-secondary' : 'text-outline' }}">
                                        {{ $item->trang_thai == 'hoat_dong' ? 'Đang chạy' : 'Tạm dừng' }}
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('recurring.destroy', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-outline hover:text-error transition-colors" onclick="return confirm('Xoá lịch giao dịch này?')">
                                    <span class="material-symbols-outlined" data-icon="delete">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-outline">
                            <span class="material-symbols-outlined text-4xl mb-3 block" data-icon="event_repeat">event_repeat</span>
                            <p>Chưa có giao dịch định kỳ nào được thiết lập.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Recurring -->
<div id="recurring-modal" class="fixed inset-0 bg-black/60 {{ $errors->hasAny(['so_tien', 'chu_ky', 'ngay_bat_dau', 'danh_muc_id']) ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-md border border-outline-variant/10 relative">
        <button onclick="document.getElementById('recurring-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
        <h3 class="text-xl font-bold mb-6 text-on-surface">Thiết lập Giao dịch Định kỳ</h3>
        <form method="POST" action="{{ route('recurring.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Loại giao dịch</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all has-[:checked]:border-secondary has-[:checked]:bg-secondary/5 font-bold text-sm">
                        <input type="radio" name="loai_giao_dich" value="thu" {{ old('loai_giao_dich', 'thu') == 'thu' ? 'checked' : '' }} class="sr-only">
                        Thu nhập (+)
                    </label>
                    <label class="relative flex items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all has-[:checked]:border-tertiary has-[:checked]:bg-tertiary/5 font-bold text-sm">
                        <input type="radio" name="loai_giao_dich" value="chi" {{ old('loai_giao_dich') == 'chi' ? 'checked' : '' }} class="sr-only">
                        Chi tiêu (-)
                    </label>
                </div>
                @error('loai_giao_dich')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Danh mục</label>
                <select name="danh_muc_id" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('danh_muc_id') border border-error bg-error-container/10 @enderror">
                    @foreach($danhMucs as $cat)
                        <option value="{{ $cat->id }}" {{ old('danh_muc_id') == $cat->id ? 'selected' : '' }}>{{ $cat->ten_danh_muc }} ({{ $cat->loai == 'thu' ? 'Thu' : 'Chi' }})</option>
                    @endforeach
                </select>
                @error('danh_muc_id')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Số tiền (VNĐ)</label>
                <input type="text" name="so_tien" value="{{ old('so_tien') }}" class="money-input w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('so_tien') border border-error bg-error-container/10 @enderror" placeholder="0">
                @error('so_tien')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Chu kỳ lặp lại</label>
                <select name="chu_ky" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('chu_ky') border border-error bg-error-container/10 @enderror">
                    <option value="hang_ngay" {{ old('chu_ky') == 'hang_ngay' ? 'selected' : '' }}>Hàng ngày</option>
                    <option value="hang_tuan" {{ old('chu_ky') == 'hang_tuan' ? 'selected' : '' }}>Hàng tuần</option>
                    <option value="hang_thang" {{ old('chu_ky', 'hang_thang') == 'hang_thang' ? 'selected' : '' }}>Hàng tháng</option>
                    <option value="hang_nam" {{ old('chu_ky') == 'hang_nam' ? 'selected' : '' }}>Hàng năm</option>
                </select>
                @error('chu_ky')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Ngày bắt đầu</label>
                <input type="date" name="ngay_bat_dau" value="{{ old('ngay_bat_dau', date('Y-m-d')) }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('ngay_bat_dau') border border-error bg-error-container/10 @enderror">
                @error('ngay_bat_dau')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition-all">Kích hoạt Tự động</button>
            </div>
        </form>
    </div>
</div>
@endsection
