@extends('layouts.app')

@section('title', 'VNPay Sandbox Demo')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/10 rounded-3xl mb-4">
            <span class="material-symbols-outlined text-4xl text-primary" data-icon="payments">payments</span>
        </div>
        <h2 class="text-4xl font-black tracking-tight text-on-surface">Cổng thanh toán VNPay</h2>
        <p class="text-outline text-lg mt-2">Trải nghiệm thanh toán an toàn và nhanh chóng qua môi trường Sandbox</p>
    </div>

    <!-- Alert for Sandbox -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-2xl mb-10 shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <span class="material-symbols-outlined text-blue-500" data-icon="info">info</span>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-bold text-blue-800">Thông tin thử nghiệm</h4>
                <p class="text-blue-700 mt-1">Dùng thẻ nội địa bên dưới để test thành công:</p>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm font-mono text-blue-900 bg-white/50 p-4 rounded-xl">
                    <div>Số thẻ: <span class="font-bold">970419852137142015</span></div>
                    <div>Tên: <span class="font-bold">NGUYEN VAN A</span></div>
                    <div>Ngày: <span class="font-bold">07/15</span></div>
                    <div>OTP: <span class="font-bold">123456</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Form -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/10 shadow-xl overflow-hidden">
        <form action="{{ route('vnpay.pay') }}" method="POST" id="vnpay-form">
            @csrf
            
            <div class="p-8 space-y-8">
                <!-- Select Type -->
                <div>
                    <label class="block text-sm font-bold text-outline uppercase tracking-widest mb-4">Loại giao dịch</label>
                    <div class="grid grid-cols-2 gap-6">
                        <label class="relative group cursor-pointer">
                            <input type="radio" name="loai_giao_dich" value="thu_nhap" checked class="peer sr-only">
                            <div class="p-6 rounded-2xl border-2 border-outline-variant/20 bg-surface-container-low transition-all peer-checked:border-secondary peer-checked:bg-secondary/5 group-hover:bg-surface-container">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                                        <span class="material-symbols-outlined" data-icon="account_balance_wallet">account_balance_wallet</span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-lg">Nạp tiền</div>
                                        <div class="text-xs text-outline italic">Tăng số dư tài khoản</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="relative group cursor-pointer">
                            <input type="radio" name="loai_giao_dich" value="chi_tieu" class="peer sr-only">
                            <div class="p-6 rounded-2xl border-2 border-outline-variant/20 bg-surface-container-low transition-all peer-checked:border-tertiary peer-checked:bg-tertiary/5 group-hover:bg-surface-container">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center">
                                        <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-lg">Thanh toán</div>
                                        <div class="text-xs text-outline italic">Chi trả hóa đơn</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Input Amount and Description -->
                <!-- Input Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-outline uppercase tracking-widest mb-2">Số tiền thanh toán (VNĐ)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-outline font-bold">₫</span>
                                <input type="text" name="so_tien" value="50,000" class="money-input w-full bg-surface-container-low border-none rounded-2xl pl-10 pr-4 py-4 text-2xl font-black focus:ring-2 focus:ring-primary text-on-surface" placeholder="0">
                            </div>
                            <p class="text-xs text-outline">Tối thiểu 1,000 VNĐ</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-outline uppercase tracking-widest mb-2">Chọn Ngân hàng / Phương thức</label>
                            <select name="bank_code" class="w-full bg-surface-container-low border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-primary text-on-surface font-semibold">
                                <option value="">--- Trực tiếp tại VNPay ---</option>
                                <option value="NCB">Ngân hàng NCB (Thẻ nội địa)</option>
                                <option value="VNPAYQR">Thanh toán quét mã VNPAYQR</option>
                                <option value="INTCARD">Thẻ thanh toán quốc tế</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-outline uppercase tracking-widest mb-2">Nội dung đơn hàng</label>
                        <textarea name="noi_dung" rows="5" class="w-full h-full bg-surface-container-low border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-primary resize-none" placeholder="Ghi chú thanh toán...">Nạp tiền vào tài khoản Fiscal Curator</textarea>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="bg-surface-container-low p-8 border-t border-outline-variant/10">
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl text-xl font-black shadow-2xl hover:shadow-primary/50 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                    Xác nhận thanh toán qua VNPay
                    <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                </button>
                <div class="mt-4 flex items-center justify-center gap-6 grayscale opacity-50">
                    <img src="https://sandbox.vnpayment.vn/paymentv2/images/img/logos/vnpay-logo.png" alt="VNPay" class="h-8">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('vnpay-form');
    form.addEventListener('submit', function(e) {
        // We already have a global stripCommas in app.blade.php
        // but let's ensure it works for this web form redirect too.
        const moneyInput = form.querySelector('.money-input');
        if (moneyInput) {
            moneyInput.value = moneyInput.value.replace(/,/g, '');
        }
    });

    // Auto resize textarea
    const textarea = document.querySelector('textarea');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endsection
