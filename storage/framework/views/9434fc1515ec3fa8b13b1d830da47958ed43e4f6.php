<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6; background:#f7faf8; padding:24px;">
    <div style="max-width:640px; margin:0 auto; background:#fff; border:1px solid #e2ebe5; border-radius:12px; padding:28px;">
        <h2 style="margin-top:0; color:#17362a;">Payment failed</h2>
        <p>Hello <?php echo e(trim($user->f_name . ' ' . $user->l_name) ?: $user->email); ?>,</p>
        <p>Your payment for the <strong><?php echo e(optional($subscription->plan)->name ?: 'MyPlexus'); ?></strong> plan could not be completed.</p>
        <p>Amount attempted: <strong><?php echo e($transaction->currency); ?> <?php echo e(number_format((float) $transaction->amount, 2)); ?></strong></p>
        <?php if(!empty($transaction->failure_reason)): ?>
            <p>Reason: <?php echo e($transaction->failure_reason); ?></p>
        <?php endif; ?>
        <p>You can try again from the subscription page.</p>
        <p>
            <a href="<?php echo e(route('web.subscriptions.index')); ?>" style="display:inline-block;padding:12px 18px;background:#2f8c5b;color:#fff;text-decoration:none;border-radius:6px;">Retry Payment</a>
        </p>
    </div>
</body>
</html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/web/payment-failed.blade.php ENDPATH**/ ?>