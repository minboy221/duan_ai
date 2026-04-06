@extends('layouts.app')

@section('title', 'Kết quả Thanh toán VNPay')

@section('content')
<div class="max-w-xl mx-auto py-12">
    <div class="bg-surface-container-lowest rounded-[40px] border border-outline-variant/10 shadow-2xl overflow-hidden">
        <div class="p-10 text-center">
            @if($status == 'success')
                <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-6xl" data-icon="check_circle">check_circle</span>
                </div>
                <h2 class="text-3xl font-black text-on-surface mb-2">Thanh toán hoàn tất!</h2>
                <p class="text-outline">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
            @else
                <div class="w-24 h-24 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-6xl" data-icon="error">error</span>
                </div>
                <h2 class="text-3xl font-black text-on-surface mb-2">Giao dịch thất bại</h2>
                <p class="text-outline">Đã có lỗi xảy ra hoặc bạn đã hủy thanh toán.</p>
            @endif
        </div>

        <div class="bg-surface-container-low/50 p-8 space-y-4">
            <div class="flex justify-between items-center text-sm">
                <span class="text-outline font-bold uppercase tracking-wider">Mã đơn hàng</span>
                <span class="font-mono font-bold text-on-surface">{{ $order_id }}</span>
            </div>
            <div class="flex justify-between items-center text-sm border-t border-outline-variant/10 pt-4">
                <span class="text-outline font-bold uppercase tracking-wider">Số tiền</span>
                <span class="text-xl font-black text-on-surface">{{ number_format($amount, 0, ',', '.') }} VNĐ</span>
            </div>
            @if($vnp_id)
            <div class="flex justify-between items-center text-sm border-t border-outline-variant/10 pt-4">
                <span class="text-outline font-bold uppercase tracking-wider">Mã VNPay</span>
                <span class="font-mono text-outline">{{ $vnp_id }}</span>
            </div>
            @endif
        </div>

        <div class="p-10 space-y-4">
            <a href="{{ route('dashboard') }}" class="w-full bg-primary text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-primary/90 transition-all shadow-lg hover:shadow-primary/40">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span> Quay về Dashboard
            </a>
            <a href="{{ route('vnpay.index') }}" class="w-full bg-surface-container-high text-on-surface-variant py-4 rounded-2xl font-bold flex items-center justify-center gap-2 hover:bg-outline-variant/10 transition-all">
                Thực hiện giao dịch khác
            </a>
        </div>
    </div>
</div>
@endsection
