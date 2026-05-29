<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiry extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public string $expiry_date;
    public string $renewal_url;
    public int $daysLeft;

    public function __construct(User $user, string $expiry_date, string $renewal_url, int $daysLeft = 3)
    {
        $this->user = $user;
        $this->expiry_date = $expiry_date;
        $this->renewal_url = $renewal_url;
        $this->daysLeft = $daysLeft;
    }

    public function build()
    {
        return $this->subject("Your myplexus Subscription Expires in {$this->daysLeft} Days")
            ->view('emails.web.subscription_expiry');
    }
}
