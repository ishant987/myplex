<?php

namespace App\Support;

use App\Mail\WelcomeAccount;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailSender
{
    public static function send(User $user, ?string $plainPassword = null, ?string $verifyUrl = null, ?string $loginUrl = null): void
    {
        if (empty($user->email)) {
            return;
        }

        try {
            Mail::to($user->email)->send(
                new WelcomeAccount($user, $plainPassword, $verifyUrl, $loginUrl)
            );
        } catch (\Throwable $exception) {
            Log::warning('Welcome email failed to send.', [
                'user_id' => $user->u_id,
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
