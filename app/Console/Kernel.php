<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\InsertCagrQuartileDecile::class,
        Commands\SendSubscriptionExpiryEmails::class,
        Commands\SendTrialReminders::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('set:daily-cagr')->dailyAt('16:28');
        $schedule->command('subscription:send-expiry-emails')->dailyAt('09:00');
        $schedule->command('app:send-trial-reminders')->dailyAt('09:00');
    }
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
