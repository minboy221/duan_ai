@extends('layouts.app')

@section('title', 'Kết quả Thanh toán')

@section('content')
<div class="max-w-xl mx-auto py-20 px-4">
    <div class="bg-surface-container-lowest rounded-[48px] border border-outline-variant/10 shadow-2xl overflow-hidden relative group">
        <!-- Status Header -->
        <div class="p-12 text-center relative z-10">
            @if($status == 'success')
                <div class="w-32 h-32 bg-green-500/10 text-green-600 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                    <span class="material-symbols-outlined text-7xl font-black">check_circle</span>
                </div>
                <h2 class="text-4xl font-black text-on-surface mb-3 tracking-tight">Thanh toán thành công!</h2>
                <p class="text-outline text-lg font-medium opacity-80">Cảm ơn bạn đã tin tưởng dịch vụ của chúng tôi.</p>
            @else
                <div class="w-32 h-32 bg-red-500/10 text-red-600 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse">
                    <span class="material-symbols-outlined text-7xl font-black">error</span>
                </div>
                <h2 class="text-4xl font-black text-on-surface mb-3 tracking-tight">Giao dịch thất bại</h2>
                <p class="text-outline text-lg font-medium opacity-80">Đã có lỗi xảy ra hoặc giao dịch đã bị hủy.</p>
            @endif
        </div>

        <!-- Order Summary Card -->
        <div class="mx-8 mb-8 bg-surface-container-low/40 rounded-[32px] p-8 border border-outline-variant/5">
            <h4 class="text-[10px] font-black text-outline uppercase tracking-widest mb-6 opacity-60">Chi tiết hóa đơn</h4>
            
            <div class="space-y-5">
                <div class="flex justify-between items-center group/item cursor-default">
                    <span class="text-sm font-bold text-outline opacity-70">Mã đơn hàng</span>
                    <span class="font-mono font-black text-on-surface bg-surface p-2 rounded-lg border border-outline-variant/10">{{ $order_id }}</span>
                </div>
                
                <div class="flex justify-between items-center border-t border-outline-variant/10 pt-5">
                    <span class="text-sm font-bold text-outline opacity-70">Số tiền thanh toán</span>
                    <span class="text-2xl font-black text-on-surface text-primary">{{ number_format($amount, 0, ',', '.') }} <span class="text-xs font-bold">VND</span></span>
                </div>

                @if($vnp_id)
                <div class="flex justify-between items-center border-t border-outline-variant/10 pt-5">
                    <span class="text-sm font-bold text-outline opacity-70">Mã giao dịch VNPay</span>
                    <span class="font-mono text-xs font-bold text-outline">{{ $vnp_id }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-10 pt-0 space-y-4">
            <button id="btn-check-status" class="w-full bg-secondary text-white py-5 rounded-2xl font-black uppercase text-sm tracking-widest flex items-center justify-center gap-3 hover:shadow-xl hover:bg-secondary/90 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined">sync</span> Kiểm tra trạng thái thực tế
            </button>
            
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('dashboard') }}" class="bg-surface-container-high text-on-surface py-5 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-outline-variant/10 transition-all">
                    <span class="material-symbols-outlined text-sm">dashboard</span> Dashboard
                </a>
                <a href="{{ route('vnpay.index') }}" class="bg-surface-container-high text-on-surface py-5 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-outline-variant/10 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span> Tiếp tục nạp
                </a>
            </div>
        </div>

        <!-- Subtle Footer -->
        <div class="bg-surface-container-lowest/50 p-6 text-center border-t border-outline-variant/5">
            <p class="text-[10px] text-outline opacity-40 font-bold uppercase tracking-widest">Powered by VNPAY Secure Payment Gateway</p>
        </div>
    </div>

    <!-- API Response Modal -->
    <div id="statusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-md hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-[40px] p-10 max-w-md w-full mx-4 shadow-3xl transform scale-95 transition-transform duration-300" id="modalContainer">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined">api</span>
                </div>
                <h3 class="text-2xl font-black text-on-surface">Kết quả API</h3>
            </div>
            
            <div id="modalContent" class="bg-surface-container p-6 rounded-3xl font-mono text-xs overflow-auto max-h-64 mb-8 leading-relaxed border border-outline-variant/5">
                <div class="flex items-center gap-2">
                    <span class="animate-spin material-symbols-outlined text-primary">sync</span> Đang lấy dữ liệu từ VNPay...
                </div>
            </div>
            
            <button onclick="closeModal()" class="w-full py-4 bg-outline-variant/10 hover:bg-outline-variant/20 rounded-2xl font-black text-sm uppercase tracking-widest transition-all">Đóng cửa sổ</button>
        </div>
    </div>
</div>

<script>
    const statusModal = document.getElementById('statusModal');
    const modalContainer = document.getElementById('modalContainer');
    const modalContent = document.getElementById('modalContent');

    function closeModal() {
        modalContainer.classList.add('scale-95');
        statusModal.classList.add('opacity-0');
        setTimeout(() => statusModal.classList.add('hidden'), 300);
    }

    document.getElementById('btn-check-status').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<span class="animate-spin material-symbols-outlined">sync</span> Đang gọi VNPay...';
        
        statusModal.classList.remove('hidden');
        setTimeout(() => {
            statusModal.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95');
        }, 10);

        const orderId = "{{ $order_id }}";
        const transDate = "{{ $vnpay->vnp_create_date ?? '' }}";

        if (!transDate) {
            modalContent.innerHTML = '<div class="text-red-500 font-bold mb-2">Lỗi: Thiếu thời gian giao dịch!</div>Bạn cần thực hiện lại giao dịch mới để hệ thống ghi nhận thời gian truy vấn.';
            btn.disabled = false;
            btn.innerHTML = originalHTML;
            return;
        }

        fetch(`{{ route('vnpay.query') }}?order_id=${orderId}&trans_date=${transDate}`)
            .then(response => response.json())
            .then(data => {
                let html = '<div class="space-y-2">';
                for (const [key, value] of Object.entries(data)) {
                    html += `<div class="flex justify-between border-b border-outline-variant/5 pb-2">
                                <span class="text-outline font-bold">${key}:</span>
                                <span class="text-on-surface font-black">${value}</span>
                             </div>`;
                }
                html += '</div>';
                modalContent.innerHTML = html;
            })
            .catch(error => {
                modalContent.innerHTML = '<div class="text-red-500">Lỗi kết nối API: ' + error.message + '</div>';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            });
    });
</script>

<style>
    .animate-bounce { animation: bounce 2s infinite; }
    @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .shadow-3xl { shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3); }
</style>
@endsection
