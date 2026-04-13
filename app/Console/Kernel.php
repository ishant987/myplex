<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\MembersBirthday::class,
        Commands\InsertCagrQuartileDecile::class,
        Commands\SendTrialReminders::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('notify:membersbirthday')
        //     ->withoutOverlapping()
        //     ->dailyAt('12:05');

        // $schedule->command('inspire')->hourly();
        $schedule->command('set:daily-cagr')->dailyAt('16:28');
        $schedule->command('app:send-trial-reminders')->dailyAt('09:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
