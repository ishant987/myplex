<html>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2>Payment confirmed</h2>
    <p>Hello <?php echo e(trim($user->f_name . ' ' . $user->l_name) ?: $user->email); ?>,</p>
    <p>Your payment for the <strong><?php echo e(optional($subscription->plan)->name ?: 'MyPlexus'); ?></strong> plan was successful.</p>
    <p>Amount paid: <strong><?php echo e($transaction->currency); ?> <?php echo e(number_format((float) $transaction->amount, 2)); ?></strong></p>
    <p>Plan valid until: <strong><?php echo e(optional($subscription->ends_at)->format('d M Y')); ?></strong></p>
    <p>Payment ID: <?php echo e($transaction->razorpay_payment_id); ?></p>
    <p>
        <a href="<?php echo e(url('/dashboard')); ?>" style="display:inline-block;padding:12px 18px;background:#1a73e8;color:#fff;text-decoration:none;border-radius:4px;">Go to Dashboard</a>
    </p>
</body>
</html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/payment-confirmation.blade.php ENDPATH**/ ?>