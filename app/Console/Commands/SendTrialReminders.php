<?php

namespace App\Console\Commands;

use App\Mail\TrialExpiryReminder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTrialReminders extends Command
{
    protected $signature = 'app:send-trial-reminders';

    protected $description = 'Send reminder emails to users whose trial expires in 1, 2, or 3 days';

    public function handle()
    {
        foreach ([3, 2, 1] as $daysLeft) {
            $targetDate = now()->addDays($daysLeft)->toDateString();

            User::query()
                ->where('subscription_status', 'trial')
                ->whereDate('trial_ends_at', $targetDate)
                ->chunkById(100, function ($users) use ($daysLeft) {
                    foreach ($users as $user) {
                        Mail::to($user->email)->send(new TrialExpiryReminder($user, $daysLeft));
                        $this->info("Trial reminder sent to {$user->email} ({$daysLeft} day(s) left)");
                    }
                }, 'u_id');
        }

        return self::SUCCESS;
    }
}
