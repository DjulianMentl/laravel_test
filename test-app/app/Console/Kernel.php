<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /**
         * при такой реализации в crontab нужно запускать php /var/www/html/test-app/artisan schedule:run
         */
        $schedule->command('user:check_expiration')->everyTenMinutes();

        /**
         * также можно настроить выполнение раз в 10 минут команды user:check_expiration по crontab
         * /10 * * * * cd /var/www/html/test-app && php artisan user:check_expiration >> storage/logs/checkExpiration.log 2>&1
         */
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
