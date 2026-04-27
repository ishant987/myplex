<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeAccount extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public ?string $plainPassword;
    public ?string $verifyUrl;
    public ?string $loginUrl;

    public function __construct(User $user, ?string $plainPassword = null, ?string $verifyUrl = null, ?string $loginUrl = null)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
        $this->verifyUrl = $verifyUrl;
        $this->loginUrl = $loginUrl;
    }

    public function build()
    {
        return $this->subject('Welcome to myplexus')
            ->view('emails.welcome_account');
    }
}
