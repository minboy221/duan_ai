@extends('layouts.app')

@section('title', 'Mục tiêu Tiết kiệm')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Mục tiêu Tiết kiệm</h2>
            <p class="text-outline text-sm mt-1">Lập kế hoạch và theo dõi tiến độ các mục tiêu tài chính của bạn</p>
        </div>
        <button onclick="document.getElementById('savings-modal').classList.remove('hidden')" class="bg-secondary text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-secondary/90 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined" data-icon="flag">flag</span> Thêm Mục tiêu
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Savings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($goals as $goal)
            <div class="bg-surface-container-lowest p-6 rounded-3xl border {{ $goal->trang_thai == 'hoan_thanh' ? 'border-secondary' : 'border-outline-variant/20' }} shadow-sm relative group overflow-hidden">
                <!-- Status badge -->
                @if($goal->trang_thai == 'hoan_thanh')
                    <div class="absolute -right-12 top-6 bg-secondary text-white text-[10px] font-bold uppercase tracking-wider px-12 py-1 rotate-45 shadow-sm z-10">Đã đạt</div>
                @endif

                <div class="flex flex-col h-full relative z-10">
                    <div class="mb-6 flex-1">
                        <h3 class="font-bold text-xl mb-1 pr-6">{{ $goal->ten_muc_tieu }}</h3>
                        <p class="text-xs text-outline flex items-center gap-1.5 font-medium">
                            <span class="material-symbols-outlined text-[14px]">event</span> 
                            Hạn: {{ date('d/m/Y', strtotime($goal->han_chot)) }}
                            @php
                                $daysLeft = \Carbon\Carbon::parse($goal->han_chot)->diffInDays(\Carbon\Carbon::now());
                                $isDue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($goal->han_chot));
                            @endphp
                            @if($goal->trang_thai != 'hoan_thanh')
                                <span class="ml-1 {{ $isDue ? 'text-error' : 'text-primary' }} font-bold">
                                    ({{ $isDue ? 'Đã quá hạn' : "Còn $daysLeft ngày" }})
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex w-full justify-between items-end">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-outline font-bold uppercase">Hiện có</span>
                                <span class="text-2xl font-bold tabular-nums {{ $goal->trang_thai == 'hoan_thanh' ? 'text-secondary' : 'text-on-surface' }}">{{ number_format($goal->so_tien_hien_tai, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="text-right flex flex-col">
                                <span class="text-[10px] text-outline font-bold uppercase">Mục tiêu</span>
                                <span class="text-sm font-semibold tabular-nums text-outline">{{ number_format($goal->so_tien_muc_tieu, 0, ',', '.') }}₫</span>
                            </div>
                        </div>

                        <!-- Progress Bar Container -->
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $goal->trang_thai == 'hoan_thanh' ? 'text-secondary bg-secondary/10' : 'text-primary bg-primary/10' }}">
                                        Tiến độ
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold inline-block {{ $goal->trang_thai == 'hoan_thanh' ? 'text-secondary' : 'text-primary' }}">
                                        {{ $goal->phan_tram }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2.5 mb-4 text-xs flex rounded-full bg-surface-container-high">
                                <div style="width: {{ $goal->phan_tram }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $goal->trang_thai == 'hoan_thanh' ? 'bg-secondary' : 'bg-primary' }} transition-all duration-1000 ease-out"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-outline-variant/10">
                        @if($goal->trang_thai != 'hoan_thanh')
                            <button onclick="openAddMoneyModal({{ $goal->id }}, '{{ $goal->ten_muc_tieu }}')" class="text-sm font-semibold text-primary flex items-center gap-1 hover:underline">
                                <span class="material-symbols-outlined text-[18px]">add_circle</span> Thêm tiền
                            </button>
                        @else
                            <span class="text-sm font-bold text-secondary flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">workspace_premium</span> Hoàn thành</span>
                        @endif
                        
                        <form action="{{ route('savings.destroy', $goal->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-outline hover:text-error transition-colors" onclick="return confirm('Bạn có chắc muốn xoá mục tiêu này?')">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3 text-center bg-surface-container-lowest py-16 rounded-3xl border border-outline-variant/20 border-dashed">
                <span class="material-symbols-outlined text-4xl text-outline mb-3" data-icon="savings">savings</span>
                <p class="text-outline font-medium">Chưa có mục tiêu tiết kiệm nào được lập.</p>
                <button onclick="document.getElementById('savings-modal').classList.remove('hidden')" class="mt-4 text-secondary font-bold hover:underline">Tạo mục tiêu ngay</button>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Money Modal -->
<div id="add-money-modal" class="fixed inset-0 bg-black/60 {{ $errors->has('so_tien_them') ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-sm border border-outline-variant/10 relative">
        <button onclick="document.getElementById('add-money-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
        <h3 class="text-xl font-bold mb-2 text-on-surface">Cập nhật tiến độ</h3>
        <p class="text-sm text-outline mb-6" id="add-money-goal-name"></p>
        <form id="add-money-form" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-semibold mb-2">Số tiền gửi thêm (VNĐ)</label>
                <input type="number" name="so_tien_them" value="{{ old('so_tien_them') }}" min="1" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary @error('so_tien_them') border border-error bg-error-container/10 @enderror" placeholder="Nhập số tiền...">
                @error('so_tien_them')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition-all">Xác nhận nộp</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Goal -->
<div id="savings-modal" class="fixed inset-0 bg-black/60 {{ $errors->hasAny(['ten_muc_tieu', 'so_tien_muc_tieu', 'han_chot']) ? '' : 'hidden' }} backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-md border border-outline-variant/10 relative">
        <button onclick="document.getElementById('savings-modal').classList.add('hidden')" class="absolute top-4 right-4 text-outline hover:text-on-surface">
            <span class="material-symbols-outlined" data-icon="close">close</span>
        </button>
        <h3 class="text-xl font-bold mb-6 text-on-surface">Tạo Mục tiêu mới</h3>
        <form method="POST" action="{{ route('savings.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Tên mục tiêu</label>
                <input type="text" name="ten_muc_tieu" value="{{ old('ten_muc_tieu') }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary @error('ten_muc_tieu') border border-error bg-error-container/10 @enderror" placeholder="Vd: Mua xe, Đám cưới...">
                @error('ten_muc_tieu')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-2">Số tiền mục tiêu (VNĐ)</label>
                <input type="number" name="so_tien_muc_tieu" value="{{ old('so_tien_muc_tieu') }}" min="100000" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary @error('so_tien_muc_tieu') border border-error bg-error-container/10 @enderror">
                @error('so_tien_muc_tieu')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Mục tiêu đạt vào (Hạn chót)</label>
                <input type="date" name="han_chot" value="{{ old('han_chot') }}" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary @error('han_chot') border border-error bg-error-container/10 @enderror">
                @error('han_chot')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Đã có khuyến mãi/tích luỹ sẵn (Tuỳ chọn)</label>
                <input type="number" name="so_tien_hien_tai" value="{{ old('so_tien_hien_tai', 0) }}" min="0" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary @error('so_tien_hien_tai') border border-error bg-error-container/10 @enderror">
                @error('so_tien_hien_tai')
                    <p class="text-[10px] text-error font-bold mt-1 ml-1 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-secondary text-white py-3 rounded-xl font-bold shadow-lg hover:bg-secondary/90 transition-all">Lưu Mục Tiêu</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddMoneyModal(id, name) {
        document.getElementById('add-money-goal-name').innerText = 'Mục tiêu: ' + name;
        document.getElementById('add-money-form').action = '/savings/' + id + '/add';
        document.getElementById('add-money-modal').classList.remove('hidden');
    }
</script>
@endsection
