<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionExpiry;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionExpiryEmails extends Command
{
    protected $signature = 'subscription:send-expiry-emails';

    protected $description = 'Send reminder emails to users whose subscription expires in 7 or 3 days';


    public function handle()
    {
        $renewalUrl = url('/subscriptions');

        foreach ([7, 3] as $daysLeft) {
            $targetDate = now()->addDays($daysLeft)->toDateString();

            $this->info("Looking for subscriptions expiring on: {$targetDate}");

            User::query()
                ->where('subscription_status', 'active')
                ->whereNotNull('subscription_expiry_date')
                ->whereDate('subscription_expiry_date', $targetDate)
                ->whereNotNull('email')
                ->chunkById(100, function ($users) use ($renewalUrl, $daysLeft) {
                    foreach ($users as $user) {
                        try {
                            Mail::to($user->email)->send(
                                new SubscriptionExpiry($user, (string) $user->subscription_expiry_date, $renewalUrl, $daysLeft)
                            );

                            $this->info("Subscription expiry email sent to {$user->email}");
                            Log::info('Subscription expiry email sent', [
                                'user_id' => $user->u_id,
                                'email' => $user->email,
                                'expiry_date' => $user->subscription_expiry_date,
                                'days_left' => $daysLeft,
                            ]);
                        } catch (\Throwable $exception) {
                            $this->error("Subscription expiry email failed for {$user->email}: {$exception->getMessage()}");
                            Log::error('Subscription expiry email failed', [
                                'user_id' => $user->u_id,
                                'email' => $user->email,
                                'error' => $exception->getMessage(),
                                'days_left' => $daysLeft,
                            ]);
                        }
                    }
                }, 'u_id');
        }

        $this->info('Subscription expiry email scan completed.');

        return self::SUCCESS;
    }
}
