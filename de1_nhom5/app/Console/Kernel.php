<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * Chạy giao dịch định kỳ mỗi phút (kiểm tra ngay_chay_tiep_theo)
     * Dùng withoutOverlapping() để tránh chạy trùng nếu lần trước chưa xong
     * Sử dụng: php artisan schedule:work
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:process-recurring')
                 ->everyMinute()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/recurring.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
