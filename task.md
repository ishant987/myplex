# Subscription Expiry Email — Implementation Guide

## Overview
Send automated reminder emails to users 3 days before their subscription expires.

## Mail Config (already in .env)
```
MAIL_MAILER=smtp
MAIL_HOST=myplexus.com
MAIL_PORT=465
MAIL_USERNAME=noreply@myplexus.com
MAIL_PASSWORD=qN4c92%3nMy
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@myplexus.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Step 1 — Create the Email Template

**Create file:** `resources/views/emails/subscription_expiry.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Subscription Expiring Soon</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(180deg, #56BF84 0%, #12773E 112%); padding: 32px 24px; text-align: center; }
        .header img { max-width: 160px; height: auto; }
        .body { padding: 32px 24px; }
        .body h2 { color: #1f2937; font-size: 22px; margin-bottom: 12px; }
        .body p { color: #344054; font-size: 15px; line-height: 1.6; margin-bottom: 16px; }
        .highlight { background: #f3f8f5; border: 1px solid #dcece1; border-radius: 10px; padding: 16px 20px; margin: 20px 0; }
        .highlight p { margin: 0; font-size: 15px; color: #12773E; font-weight: 600; }
        .btn { display: inline-block; background: linear-gradient(180deg, #56BF84 0%, #12773E 112%); color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 10px; font-size: 15px; font-weight: 600; margin-top: 8px; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 24px; text-align: center; }
        .footer p { margin: 0; font-size: 13px; color: #667085; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('themes/frontend/assets/v1/img/logo_dash.png') }}" alt="myplexus">
        </div>
        <div class="body">
            <h2>Hi {{ $user->f_name }},</h2>
            <p>Your <strong>myplexus</strong> subscription is expiring in <strong>3 days</strong>.</p>

            <div class="highlight">
                <p>⏰ Expiry Date: {{ \Carbon\Carbon::parse($expiry_date)->format('d M Y') }}</p>
            </div>

            <p>
                To continue enjoying uninterrupted access to Ratio Reports, Composition Reports,
                Indices Reports, Filters, Predictive tools and more — please renew your subscription
                before it expires.
            </p>

            <p>
                <a href="{{ $renewal_url }}" class="btn">Renew Subscription</a>
            </p>

            <p style="margin-top: 24px; font-size: 13px; color: #667085;">
                If you have already renewed, please ignore this email.
                For support, contact us at support@myplexus.com.
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} myplexus.com. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
```

---

## Step 2 — Create the Mailable Class

**Create file:** `app/Mail/SubscriptionExpiry.php`

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SubscriptionExpiry extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $expiry_date;
    public $renewal_url;

    public function __construct(User $user, string $expiry_date, string $renewal_url)
    {
        $this->user = $user;
        $this->expiry_date = $expiry_date;
        $this->renewal_url = $renewal_url;
    }

    public function build()
    {
        return $this->subject('Your myplexus Subscription Expires in 3 Days')
                    ->view('emails.subscription_expiry')
                    ->with([
                        'user'        => $this->user,
                        'expiry_date' => $this->expiry_date,
                        'renewal_url' => $this->renewal_url,
                    ]);
    }
}
```

---

## Step 3 — Create the Artisan Command

**Create file:** `app/Console/Commands/SendSubscriptionExpiryEmails.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Mail\SubscriptionExpiry;
use Carbon\Carbon;

class SendSubscriptionExpiryEmails extends Command
{
    protected $signature   = 'subscription:send-expiry-emails';
    protected $description = 'Send reminder emails to users whose subscription expires in 3 days';

    public function handle()
    {
        $targetDate = Carbon::now()->addDays(3)->toDateString();

        $this->info("Looking for subscriptions expiring on: {$targetDate}");

        // Query users whose subscription_expiry_date matches 3 days from now
        $users = User::whereNotNull('subscription_expiry_date')
            ->whereDate('subscription_expiry_date', $targetDate)
            ->where('status', 'y')
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users with subscriptions expiring in 3 days.');
            return 0;
        }

        $this->info("Found {$users->count()} user(s). Sending emails...");

        $sent    = 0;
        $failed  = 0;

        foreach ($users as $user) {
            try {
                $renewalUrl = url('/subscription');

                Mail::to($user->email)->send(
                    new SubscriptionExpiry($user, $user->subscription_expiry_date, $renewalUrl)
                );

                $sent++;
                $this->info("✓ Sent to: {$user->email}");
                Log::info("Subscription expiry email sent", ['user_id' => $user->u_id, 'email' => $user->email]);

            } catch (\Exception $e) {
                $failed++;
                $this->error("✗ Failed for: {$user->email} — {$e->getMessage()}");
                Log::error("Subscription expiry email failed", [
                    'user_id' => $user->u_id,
                    'email'   => $user->email,
                    'error'   => $e->getMessage(),
                ]);
            }
        }

        $this->info("Done. Sent: {$sent}, Failed: {$failed}");
        return 0;
    }
}
```

---

## Step 4 — Register in Kernel

**Edit file:** `app/Console/Kernel.php`

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // Register command
    protected $commands = [
        \App\Console\Commands\SendSubscriptionExpiryEmails::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Run every day at 9:00 AM
        $schedule->command('subscription:send-expiry-emails')
                 ->dailyAt('09:00')
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/subscription-expiry.log'));
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
```

---

## Step 5 — Add Cron Job on Server

**Run on production server:**
```bash
crontab -e
```

**Add this line:**
```
* * * * * cd /var/www/vhosts/myplexus.com/httpdocs && /opt/plesk/php/8.0/bin/php artisan schedule:run >> /dev/null 2>&1
```

This runs Laravel scheduler every minute. Laravel then decides which commands to run based on their schedule.

---

## Step 6 — Test Locally

**Test the command manually:**
```bash
# Run the command directly
php artisan subscription:send-expiry-emails

# Test with a specific date by temporarily changing addDays(3) to addDays(0)
# in the command, then run it and change back
```

**Test email template in browser:**
```bash
# Add a temporary test route in routes/web.php
Route::get('/test-expiry-email', function () {
    $user = App\Models\User::first();
    return new App\Mail\SubscriptionExpiry(
        $user,
        now()->addDays(3)->toDateString(),
        url('/subscription')
    );
});
```

Visit `http://localhost/test-expiry-email` to preview the email in browser.

**Send a test email:**
```bash
# Add temporary test route
Route::get('/send-test-expiry-email', function () {
    $user = App\Models\User::first();
    Mail::to($user->email)->send(
        new App\Mail\SubscriptionExpiry(
            $user,
            now()->addDays(3)->toDateString(),
            url('/subscription')
        )
    );
    return 'Email sent to ' . $user->email;
});
```

---

## Step 7 — Verify Column Name

Before running, confirm which column stores expiry date:

```bash
# Check users table
php artisan tinker --execute="echo implode(', ', array_column(DB::select('DESCRIBE users'), 'Field'));"

# Or check model
grep -n "subscription_expiry_date\|expiry" app/Models/User.php | head -10
```

If the column name is different (e.g. `subscription_end_date`), update line in command:
```php
->whereDate('subscription_expiry_date', $targetDate)
// change to whatever the actual column is
```

---

## File Summary

| File | Action |
|------|--------|
| `resources/views/emails/subscription_expiry.blade.php` | CREATE — email HTML template |
| `app/Mail/SubscriptionExpiry.php` | CREATE — Mailable class |
| `app/Console/Commands/SendSubscriptionExpiryEmails.php` | CREATE — Artisan command |
| `app/Console/Kernel.php` | EDIT — register command + schedule |
| Server crontab | EDIT — add Laravel scheduler cron |

---

## Testing Checklist

- [ ] `php artisan subscription:send-expiry-emails` runs without error
- [ ] Email preview works at `/test-expiry-email`
- [ ] Test email received at inbox
- [ ] Email shows correct user name and expiry date
- [ ] Renewal link works
- [ ] Check `storage/logs/laravel.log` for any mail errors
- [ ] Verify cron is running on server: `crontab -l`
- [ ] Check `storage/logs/subscription-expiry.log` after server deployment

---

## Notes

- The command is **idempotent** — safe to run multiple times on same day, it only sends to users expiring exactly 3 days from now
- All sends are logged to `storage/logs/laravel.log`
- Command output is also logged to `storage/logs/subscription-expiry.log` on server
- If `subscription_expiry_date` is stored in `mpx_subscriptions` table instead of `mpx_users`, the query needs to be updated to join that table