@extends('layouts.app')

@section('title', 'Quản lý Tài khoản - Fiscal Curator')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <header class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight font-headline">Quản lý Tài khoản</h1>
        <p class="text-on-surface-variant mt-2">Cập nhật thông tin cá nhân và thiết lập của bạn.</p>
    </header>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Profile & Security -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Profile Section -->
            <section class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/15 shadow-sm">
                <div class="flex flex-col md:flex-row items-center gap-8 mb-10">
                    <div class="relative group cursor-pointer inline-block" onclick="document.getElementById('avatar-input').click()">
                        <img id="avatarPreview" alt="Avatar"
                            class="w-32 h-32 rounded-full object-cover border-4 border-surface-container-high"
                            src="{{ $user->anh_dai_dien ? asset('storage/' . $user->anh_dai_dien) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuA626iML8Eg0T0FDI2y9Tg9PHrbfMc12buaZYXBAYhPh6vpJzY3op19-kt6OW8wLRTi7V1qepL0biFk51eW_fVjg4ZUg7qs3QPXCbRyCbLaHPTWFH1AI2KJvd5wfwl6qRfBhHmqH4CkcRjWf6GWg4RYj9j_I4QUxg1J0TkWb1K-TkipH1OuAlWBljHRu3mI9BZTa4oGGRIIivvi_W7k0vZ9Q49vtgJFNkLd9vbx_6Nsae2ILriiw8XTbWa7imtVUbrwhjIl8017jN0' }}" />
                        <div class="absolute bottom-1 right-1 bg-primary p-2 rounded-full text-white shadow-lg hover:scale-105 transition-transform flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm" data-icon="photo_camera">photo_camera</span>
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl font-bold text-on-surface font-headline">{{ $user->ho_ten ?? 'Khách' }}</h2>
                        <p class="text-on-surface-variant">Thành viên từ {{ $user->ngay_tao ? \Carbon\Carbon::parse($user->ngay_tao)->format('m, Y') : 'N/A' }}</p>
                        <div class="mt-4 flex flex-wrap gap-2 justify-center md:justify-start">
                            <span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-xs font-bold rounded-full">Đã xác minh</span>
                            <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-xs font-bold rounded-full">Hà Nội, VN</span>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-6 bg-secondary-container text-on-secondary-container p-4 rounded-xl text-sm font-bold border border-secondary/20 flex items-center gap-2">
                        <span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-6 bg-error-container text-on-error-container p-4 rounded-xl text-sm border border-error/20 font-medium">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    
                    <input type="file" id="avatar-input" class="hidden" accept="image/*" onchange="openCropModal(event)" />
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant">Họ và tên</label>
                        <input name="ho_ten" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 transition-all font-medium" type="text" value="{{ old('ho_ten', $user->ho_ten ?? '') }}" />
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant">Email</label>
                        <input disabled class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 opacity-60 cursor-not-allowed font-medium text-outline" type="email" value="{{ $user->email ?? '' }}" />
                        <p class="text-[10px] text-outline-variant mt-1">Email được dùng để đăng nhập, không thể thay đổi lúc này.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant">Đơn vị tiền tệ</label>
                        <select name="tien_te" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 transition-all font-medium pointer-events-none opacity-80" readonly>
                            <option value="VND" selected>VND (Việt Nam Đồng)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant">Ngôn ngữ</label>
                        <select name="ngon_ngu" class="w-full bg-surface-container-low border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 transition-all font-medium pointer-events-none opacity-80" readonly>
                            <option value="Tiếng Việt" selected>Tiếng Việt</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 pt-4 flex justify-end">
                        <button class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:opacity-90 transition-opacity" type="submit">Lưu thay đổi</button>
                    </div>
                </form>
            </section>
            
            <!-- Security Section -->
            <section class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/15 shadow-sm">
                <h2 class="text-xl font-bold mb-6 font-headline flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary" data-icon="security">security</span>
                    Bảo mật & Thiết bị
                </h2>
                <div class="space-y-6">
                    <!-- Password -->
                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-6 rounded-xl bg-surface-container-low border border-outline-variant/10 flex justify-between items-center">
                            <div>
                                <p class="font-bold">Mật khẩu</p>
                                <p class="text-xs text-on-surface-variant">Cập nhật lần cuối: {{ $user->password_changed_at ? $user->password_changed_at->diffForHumans() : 'Chưa thay đổi' }}</p>
                            </div>
                            <form method="POST" action="{{ route('profile.password.send-otp') }}">
                                @csrf
                                <button type="submit" class="text-primary font-bold text-sm hover:underline flex items-center gap-1">
                                    Đổi mật khẩu
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Active Devices -->
                    <div>
                        <h3 class="text-sm font-bold text-on-surface-variant mb-4 uppercase tracking-wider">Thiết bị đang đăng nhập</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined" data-icon="devices">devices</span>
                                    </div>
                                    <div>
                                        @php
                                            $agent = request()->userAgent();
                                            $os = 'Windows PC'; $browser = 'Chrome';
                                            if (preg_match('/macintosh|mac os x/i', $agent)) $os = 'MacBook';
                                            elseif (preg_match('/linux/i', $agent)) $os = 'Linux';
                                            elseif (preg_match('/android/i', $agent)) $os = 'Android';
                                            elseif (preg_match('/iphone|ipad/i', $agent)) $os = 'iPhone';
                                            
                                            if (preg_match('/safari/i', $agent) && !preg_match('/chrome/i', $agent)) $browser = 'Safari';
                                            elseif (preg_match('/firefox|fxios/i', $agent)) $browser = 'Firefox';
                                            elseif (preg_match('/edg/i', $agent)) $browser = 'Edge';
                                        @endphp
                                        <p class="font-bold text-sm">{{ $os }} • {{ $browser }}</p>
                                        <p class="text-xs text-on-surface-variant">Hà Nội, Việt Nam • Đang hoạt động trên trình duyệt này</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-secondary flex-shrink-0">Hiện tại</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Column: Subscription & Analytics -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Subscription Card -->
            <section class="bg-primary rounded-xl p-8 text-white relative overflow-hidden shadow-2xl shadow-primary/20">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-10">
                        <div>
                            <span class="px-3 py-1 bg-white/20 text-xs font-bold rounded-full backdrop-blur-sm">Gói Premium</span>
                            <h2 class="text-4xl font-black mt-4 font-headline tracking-tighter">1.250.000 <span class="text-lg font-medium">VNĐ/năm</span></h2>
                        </div>
                        <span class="material-symbols-outlined text-4xl opacity-50" data-icon="diamond" style="font-variation-settings: 'FILL' 1;">diamond</span>
                    </div>
                    <div class="space-y-4 mb-10">
                        <div class="flex items-center gap-2 text-sm font-medium opacity-90">
                            <span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
                            <span>Truy cập không giới hạn Insights</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm font-medium opacity-90">
                            <span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
                            <span>Hỗ trợ ưu tiên 24/7</span>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-white/10">
                        <button class="w-full bg-white text-primary py-3 rounded-xl font-bold hover:bg-opacity-90 transition-all shadow-lg">Quản lý thanh toán</button>
                    </div>
                </div>
            </section>

            <!-- Help Banner -->
            <div class="bg-secondary-container/30 rounded-xl p-6 flex items-center gap-4 border border-secondary-container/50">
                <span class="material-symbols-outlined text-secondary text-3xl" data-icon="contact_support">contact_support</span>
                <div>
                    <p class="text-sm font-bold text-on-secondary-container">Cần hỗ trợ?</p>
                    <p class="text-xs text-secondary">Đội ngũ của chúng tôi luôn sẵn sàng 24/7.</p>
                </div>
            </div>
        </div>
    <!-- Crop Modal -->
    <div id="cropModal" class="hidden fixed inset-0 z-[100] bg-black/80 flex items-center justify-center p-4">
        <div class="bg-surface rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <h3 class="text-xl font-bold font-headline mb-4">Cắt ảnh đại diện</h3>
            <div class="w-full max-h-[400px] overflow-hidden rounded-xl bg-surface-container mb-6 flex items-center justify-center">
                <img id="imageToCrop" class="max-w-full max-h-full block" />
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCropModal()" class="px-5 py-2.5 rounded-xl font-bold text-on-surface-variant hover:bg-surface-container transition-colors">Hủy</button>
                <button type="button" onclick="applyCrop()" class="px-5 py-2.5 bg-primary text-white rounded-xl font-bold hover:opacity-90 transition-opacity">OK</button>
            </div>
        </div>
    </div>

    <!-- Hidden form to process cropped image -->
    <form id="avatarForm" action="{{ route('profile.update.avatar') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="anh_dai_dien_base64" id="anh_dai_dien_base64">
    </form>
    
</div>
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
let cropper;

function openCropModal(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imageToCrop').src = e.target.result;
            document.getElementById('cropModal').classList.remove('hidden');
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(document.getElementById('imageToCrop'), {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
            });
        }
        reader.readAsDataURL(input.files[0]);
    }
    // Clear input so selecting same file works again
    input.value = '';
}

function closeCropModal() {
    document.getElementById('cropModal').classList.add('hidden');
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
}

function applyCrop() {
    if (!cropper) return;
    
    // Get cropped canvas
    const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
    });
    
    // Convert canvas to base64
    const base64Data = canvas.toDataURL('image/jpeg');
    
    // Set to hidden form and submit
    document.getElementById('anh_dai_dien_base64').value = base64Data;
    document.getElementById('avatarForm').submit();
    
    closeCropModal();
}
</script>