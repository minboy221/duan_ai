@extends('layouts.app')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Quản lý Danh mục</h2>
            <p class="text-outline text-sm mt-1">Phân loại các khoản chi và nguồn thu nhập của bạn</p>
        </div>
        <button onclick="document.getElementById('danhmuc-modal').classList.remove('hidden')" class="bg-primary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-primary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined" data-icon="add_box">add_box</span> Thêm Danh mục mới
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Income Categories -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold flex items-center gap-2 text-secondary">
                <span class="material-symbols-outlined">payments</span> Khoản Thu
            </h3>
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($danhMucs->where('loai', 'thu') as $cat)
                            <tr class="group hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <span class="material-symbols-outlined text-secondary">{{ $cat->biu_tuong }}</span>
                                    <span class="font-semibold">{{ $cat->ten_danh_muc }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('danhmuc.destroy', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-outline hover:text-error opacity-0 group-hover:opacity-100 transition-opacity" onclick="return confirm('Bạn có chắc muốn xoá danh mục này?')">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="px-6 py-8 text-center text-outline italic">Chưa có danh mục thu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Expense Categories -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold flex items-center gap-2 text-tertiary">
                <span class="material-symbols-outlined">shopping_cart</span> Khoản Chi
            </h3>
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/20 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($danhMucs->where('loai', 'chi') as $cat)
                            <tr class="group hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <span class="material-symbols-outlined text-tertiary">{{ $cat->biu_tuong }}</span>
                                    <span class="font-semibold">{{ $cat->ten_danh_muc }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('danhmuc.destroy', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-outline hover:text-error opacity-0 group-hover:opacity-100 transition-opacity" onclick="return confirm('Bạn có chắc muốn xoá danh mục này?')">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="px-6 py-8 text-center text-outline italic">Chưa có danh mục chi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="danhmuc-modal" class="fixed inset-0 bg-black/60 {{ $errors->hasAny(['ten_danh_muc', 'loai', 'biu_tuong']) ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-md border border-outline-variant/10 relative">
        <button onclick="document.getElementById('danhmuc-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="text-xl font-bold mb-6">Thêm Danh mục mới</h3>
        <form method="POST" action="{{ route('danhmuc.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Tên danh mục</label>
                <input type="text" name="ten_danh_muc" value="{{ old('ten_danh_muc') }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('ten_danh_muc') border border-error bg-error-container/10 @enderror">
                @error('ten_danh_muc')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Loại</label>
                <select name="loai" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('loai') border border-error bg-error-container/10 @enderror">
                    <option value="chi" {{ old('loai') == 'chi' ? 'selected' : '' }}>Khoản Chi (Expense)</option>
                    <option value="thu" {{ old('loai') == 'thu' ? 'selected' : '' }}>Khoản Thu (Income)</option>
                </select>
                @error('loai')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Biểu tượng (Material Symbol Name)</label>
                <input type="text" name="biu_tuong" value="{{ old('biu_tuong', 'category') }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('biu_tuong') border border-error bg-error-container/10 @enderror">
                @error('biu_tuong')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
                <p class="text-[10px] text-outline mt-1 italic">Vd: restaurant, commute, home, school, health_and_safety...</p>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition-all">Lưu Danh mục</button>
            </div>
        </form>
    </div>
</div>
@endsection
