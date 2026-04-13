<html>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2>Hello {{ trim($user->f_name . ' ' . $user->l_name) ?: $user->email }},</h2>
    <p>Your MyPlexus trial expires in {{ $daysLeft }} day(s).</p>
    <p>Expiry date: <strong>{{ optional($user->trial_ends_at)->format('d M Y') }}</strong></p>
    <p>Upgrade to keep access to premium fund analysis, advisor workflows, and research tools.</p>
    <p>
        <a href="{{ url('/subscription') }}" style="display:inline-block;padding:12px 18px;background:#1a73e8;color:#fff;text-decoration:none;border-radius:4px;">View Subscription Plans</a>
    </p>
    <p>If the button does not work, open this link: {{ url('/subscription') }}</p>
</body>
</html>
