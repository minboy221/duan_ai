@extends('layouts.app')

@section('title', 'Thông báo - The Fiscal Curator')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Trung tâm thông báo</h2>
            <p class="text-sm text-outline mt-1 text-left">Quản lý các cảnh báo và cập nhật từ hệ thống.</p>
        </div>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-bold text-primary hover:underline flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">done_all</span>
                    Đánh dấu tất cả là đã đọc
                </button>
            </form>
        @endif
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="bg-surface-container-lowest rounded-2xl p-6 border {{ $notification->read_at ? 'border-outline-variant/10 opacity-75' : 'border-primary/20 shadow-sm border-l-4 border-l-primary' }} flex items-start gap-4 transition-all hover:shadow-md">
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 {{ $notification->read_at ? 'bg-surface-container text-outline' : 'bg-primary/10 text-primary' }}">
                    <span class="material-symbols-outlined text-2xl" {{ !$notification->read_at ? 'style=font-variation-settings:\'FILL\'1' : '' }}>
                        {{ $notification->data['icon'] ?? 'notifications' }}
                    </span>
                </div>
                
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1 text-left">
                        <h3 class="text-base font-bold text-on-surface truncate pr-4 text-left">
                            {{ $notification->data['title'] ?? 'Thông báo hệ thống' }}
                        </h3>
                        <span class="text-[10px] font-medium text-outline whitespace-nowrap pt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-outline/80 leading-relaxed mb-4 text-left">
                        {{ $notification->data['message'] ?? '' }}
                    </p>
                    
                    <div class="flex items-center gap-4">
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-primary hover:underline">
                                    Đánh dấu đã đọc
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa thông báo này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-tertiary hover:underline">
                                Xóa
                            </button>
                        </form>

                        @if(isset($notification->data['action_url']))
                            <a href="{{ $notification->data['action_url'] }}" class="text-xs font-bold text-secondary hover:underline ml-auto flex items-center gap-1">
                                Chi tiết
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-surface-container-lowest rounded-3xl p-16 text-center border border-dashed border-outline-variant/30">
                <div class="w-20 h-20 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-outline/40">notifications_off</span>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2">Hộp thư trống</h3>
                <p class="text-sm text-outline max-w-xs mx-auto">Bạn không có thông báo nào vào lúc này. Chúng tôi sẽ cập nhật cho bạn ngay khi có thông tin mới!</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
