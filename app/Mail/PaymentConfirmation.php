<?php

namespace App\Mail;

use App\Models\PaymentTransaction;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public Subscription $subscription;
    public PaymentTransaction $transaction;

    public function __construct(User $user, Subscription $subscription, PaymentTransaction $transaction)
    {
        $this->user = $user;
        $this->subscription = $subscription;
        $this->transaction = $transaction;
    }

    public function build()
    {
        $planName = optional($this->subscription->plan)->name ?: 'Subscription';

        return $this->subject("Payment Confirmed — MyPlexus {$planName} Plan")
            ->view('emails.payment-confirmation');
    }
}
