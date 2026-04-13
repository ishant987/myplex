<html>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2>Payment confirmed</h2>
    <p>Hello {{ trim($user->f_name . ' ' . $user->l_name) ?: $user->email }},</p>
    <p>Your payment for the <strong>{{ optional($subscription->plan)->name ?: 'MyPlexus' }}</strong> plan was successful.</p>
    <p>Amount paid: <strong>{{ $transaction->currency }} {{ number_format((float) $transaction->amount, 2) }}</strong></p>
    <p>Plan valid until: <strong>{{ optional($subscription->ends_at)->format('d M Y') }}</strong></p>
    <p>Payment ID: {{ $transaction->razorpay_payment_id }}</p>
    <p>
        <a href="{{ url('/dashboard') }}" style="display:inline-block;padding:12px 18px;background:#1a73e8;color:#fff;text-decoration:none;border-radius:4px;">Go to Dashboard</a>
    </p>
</body>
</html>
