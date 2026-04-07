<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class AutoProcessRecurring
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Phủ logic này đối với các route web có đăng nhập người dùng
        if (Auth::check()) {
            $userId = Auth::id();
            $cacheKey = 'processed_recurring_' . $userId;

            // Nếu user chưa chạy tiến trình kiểm tra (ví dụ trong 12 tiếng qua)
            if (!Cache::has($cacheKey)) {
                // Chạy lệnh xử lý định kỳ
                Artisan::call('app:process-recurring');
                
                // Cache lại để ngăn trang không bị chậm vì lúc nào cũng call cron liên tục
                Cache::put($cacheKey, true, now()->addHours(12));
            }
        }

        return $next($request);
    }
}
