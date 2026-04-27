<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to myplexus</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 24px 12px; color: #1f2937; }
        .card { max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; }
        .header { background: #022a5b; padding: 28px 24px; text-align: center; color: #ffffff; }
        .body { padding: 28px 24px; }
        .body h1 { font-size: 24px; margin: 0 0 12px; }
        .body p { font-size: 15px; line-height: 1.6; margin: 0 0 16px; color: #4b5563; }
        .credentials { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; margin: 18px 0; }
        .credentials p { margin: 0 0 8px; }
        .credentials p:last-child { margin-bottom: 0; }
        .button { display: inline-block; background: #156db9; color: #ffffff !important; text-decoration: none; padding: 12px 22px; border-radius: 8px; font-weight: 600; }
        .footer { padding: 18px 24px 24px; color: #6b7280; font-size: 13px; }
    </style>
</head>
<body>
    @php
        $displayName = trim((string) ($user->f_name ?? '') . ' ' . (string) ($user->l_name ?? ''));
        $displayName = $displayName !== '' ? $displayName : ($user->contact_person ?: ($user->company ?: 'there'));
    @endphp

    <div class="card">
        <div class="header">
            <h2 style="margin:0;">Welcome to myplexus</h2>
        </div>

        <div class="body">
            <h1>Hi {{ $displayName }},</h1>
            <p>Your myplexus account has been created successfully.</p>

            <div class="credentials">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                @if (!empty($plainPassword))
                    <p><strong>Password:</strong> {{ $plainPassword }}</p>
                @endif
            </div>

            @if (!empty($verifyUrl))
                <p>Please verify your email address to activate your account.</p>
                <p><a href="{{ $verifyUrl }}" class="button">Verify Email</a></p>
                <p style="font-size:13px;">If the button does not work, open this link in your browser:<br>{{ $verifyUrl }}</p>
            @elseif (!empty($loginUrl))
                <p>You can sign in any time using the link below.</p>
                <p><a href="{{ $loginUrl }}" class="button">Go To Login</a></p>
            @endif

            <p>Thank you for joining myplexus.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} myplexus. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
