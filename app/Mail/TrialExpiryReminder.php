<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrialExpiryReminder extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public int $daysLeft;

    public function __construct(User $user, int $daysLeft)
    {
        $this->user = $user;
        $this->daysLeft = $daysLeft;
    }

    public function build()
    {
        return $this->subject("Your MyPlexus trial expires in {$this->daysLeft} day(s)")
            ->view('emails.trial-expiry-reminder');
    }
}
