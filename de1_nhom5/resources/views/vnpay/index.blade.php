@extends('layouts.app')

@section('title', 'Nạp tiền qua VNPay')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black text-on-surface mb-4">Thanh toán VNPay</h1>
        <p class="text-outline text-lg">Chọn số tiền và phương thức thanh toán của bạn</p>
    </div>

    <form action="{{ route('vnpay.pay') }}" method="POST" id="vnpay-form" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        
        <!-- Left: Form Inputs -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-container-lowest rounded-[32px] p-8 border border-outline-variant/10 shadow-xl">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">payments</span> Thông tin giao dịch
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-outline mb-2 uppercase tracking-widest">Số tiền (VNĐ)</label>
                        <div class="relative group">
                            <input type="number" name="so_tien" id="so_tien" value="50000" min="1000" required
                                class="w-full bg-surface-container text-2xl font-black p-6 rounded-2xl border-2 border-transparent focus:border-primary focus:bg-surface transition-all outline-none">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-outline font-bold">VND</div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-outline mb-2 uppercase tracking-widest">Nội dung thanh toán</label>
                        <input type="text" name="noi_dung" value="Nap tien vao tai khoan" required
                            class="w-full bg-surface-container p-4 rounded-2xl border-2 border-transparent focus:border-primary focus:bg-surface transition-all outline-none font-medium">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-outline mb-2 uppercase tracking-widest">Loại giao dịch</label>
                            <select name="loai_giao_dich" class="w-full bg-surface-container p-4 rounded-2xl border-2 border-transparent focus:border-primary focus:bg-surface transition-all outline-none font-medium appearance-none">
                                <option value="thu_nhap">Thu nhập / Nạp tiền</option>
                                <option value="chi_tieu">Chi tiêu / Thanh toán</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-outline mb-2 uppercase tracking-widest">Ngôn ngữ</label>
                            <select name="language" class="w-full bg-surface-container p-4 rounded-2xl border-2 border-transparent focus:border-primary focus:bg-surface transition-all outline-none font-medium appearance-none">
                                <option value="vn">Tiếng Việt</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods Grid -->
            <div class="bg-surface-container-lowest rounded-[32px] p-8 border border-outline-variant/10 shadow-xl">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">account_balance</span> Chọn phương thức thanh toán
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Method: VNPAYQR -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="bank_code" value="" class="peer hidden" checked>
                        <div class="h-full p-6 rounded-2xl border-2 border-outline-variant/20 bg-surface group-hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <img src="https://sandbox.vnpayment.vn/paymentv2/Images/brands/logo-vnpayqr.svg" alt="VNPAY-QR" class="w-8">
                            </div>
                            <div class="font-bold text-sm">VNPAY-QR</div>
                            <div class="text-[10px] text-outline mt-1 uppercase tracking-tighter">Ứng dụng Ngân hàng</div>
                        </div>
                    </label>

                    <!-- Method: ATM (NCB) -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="bank_code" value="NCB" class="peer hidden">
                        <div class="h-full p-6 rounded-2xl border-2 border-outline-variant/20 bg-surface group-hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary text-3xl">credit_card</span>
                            </div>
                            <div class="font-bold text-sm">Thẻ ATM / Tài khoản</div>
                            <div class="text-[10px] text-outline mt-1 uppercase tracking-tighter">Ngân hàng nội địa</div>
                        </div>
                    </label>

                    <!-- Method: INTCARD -->
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="bank_code" value="VISA" class="peer hidden">
                        <div class="h-full p-6 rounded-2xl border-2 border-outline-variant/20 bg-surface group-hover:border-primary/50 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary text-3xl">public</span>
                            </div>
                            <div class="font-bold text-sm">Thẻ quốc tế</div>
                            <div class="text-[10px] text-outline mt-1 uppercase tracking-tighter">Visa, Mastercard, JCB</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right: Summary & Pay -->
        <div class="space-y-6">
            <div class="bg-primary text-white rounded-[40px] p-8 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <h3 class="text-lg font-bold mb-8 opacity-80 uppercase tracking-widest">Tổng thanh toán</h3>
                <div class="mb-8">
                    <div class="text-5xl font-black mb-2" id="display-amount">50.000</div>
                    <div class="text-sm font-bold opacity-60">VND</div>
                </div>

                <ul class="space-y-4 mb-10 opacity-80 text-sm">
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">check_circle</span> Phí giao dịch: 0đ</li>
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">check_circle</span> Xử lý tức thì</li>
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">check_circle</span> Bảo mật 256-bit</li>
                </ul>

                <button type="submit" class="w-full bg-white text-primary py-5 rounded-2xl font-black text-lg hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-3 active:scale-95 transition-all">
                    THANH TOÁN NGAY <span class="material-symbols-outlined">trending_flat</span>
                </button>
            </div>

            <div class="bg-surface-container-high/30 rounded-3xl p-6 text-center border border-dashed border-outline-variant/30">
                <img src="https://sandbox.vnpayment.vn/paymentv2/Images/brands/logo-vnpay.svg" alt="VNPay Logo" class="h-8 mx-auto opacity-50 mb-4 grayscale">
                <p class="text-[10px] text-outline leading-relaxed uppercase tracking-tighter font-bold">
                    Dịch vụ được cung cấp bởi VNPAY. <br> Thông tin giao dịch của bạn được bảo mật tuyệt đối.
                </p>
            </div>
        </div>
    </form>
</div>

<script>
    const inputAmount = document.getElementById('so_tien');
    const displayAmount = document.getElementById('display-amount');

    inputAmount.addEventListener('input', (e) => {
        let val = e.target.value;
        if (val) {
            displayAmount.innerText = new Intl.NumberFormat('vi-VN').format(val);
        } else {
            displayAmount.innerText = '0';
        }
    });
</script>

<style>
    .bg-surface-container-lowest { background-color: #ffffff; }
    .bg-surface-container { background-color: #f3f4f6; }
    .text-outline { color: #6b7280; }
</style>
@endsection
