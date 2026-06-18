<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trial Ending Soon</title>
</head>
<body style="margin:0; padding:0; background:#eef6f1; font-family:Arial, Helvetica, sans-serif; color:#173043;">
    <?php
        $displayName = trim((string) ($user->f_name ?? '') . ' ' . (string) ($user->l_name ?? ''));
        $displayName = $displayName !== '' ? $displayName : ($user->email ?? 'there');
        $daysLabel = $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's');
        $trialDate = $user->trial_ends_at ? \Carbon\Carbon::parse($user->trial_ends_at)->format('d M Y') : 'soon';
        $subscriptionUrl = route('web.subscriptions.index');
    ?>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef6f1; margin:0; padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; background:#ffffff; border-radius:22px; overflow:hidden; border:1px solid #d7eadf; box-shadow:0 18px 48px rgba(13, 64, 43, 0.12);">
                    <tr>
                        <td style="background:#0d2d45; padding:30px; color:#ffffff;">
                            <div style="font-size:32px; line-height:1; font-weight:800; letter-spacing:-1px;">myplexus</div>
                            <div style="margin-top:8px; width:72px; height:4px; background:#36b875; border-radius:20px;"></div>
                            <p style="margin:18px 0 0; font-size:15px; line-height:1.7; color:#d8f4e4;">
                                Your trial access is almost complete.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:34px 30px 30px;">
                            <div style="display:inline-block; padding:7px 12px; background:#eaf7ef; color:#12773e; border-radius:999px; font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase;">
                                Trial ending
                            </div>

                            <h1 style="margin:18px 0 12px; font-size:28px; line-height:1.25; color:#102b3f;">
                                Hi <?php echo e($displayName); ?>,
                            </h1>

                            <p style="margin:0 0 18px; font-size:15px; line-height:1.8; color:#415466;">
                                Your myplexus trial expires in <strong><?php echo e($daysLabel); ?></strong>. Choose a plan to keep your fund analysis, advisor workflows, and research tools available without interruption.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:22px 0; background:#f7fbf8; border:1px solid #dcefe3; border-radius:16px;">
                                <tr>
                                    <td style="padding:18px 20px;">
                                        <p style="margin:0 0 8px; font-size:13px; color:#6a7b86; text-transform:uppercase; letter-spacing:.08em; font-weight:700;">Trial ends on</p>
                                        <p style="margin:0; font-size:24px; color:#12773e; font-weight:800;"><?php echo e($trialDate); ?></p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 20px; font-size:15px; line-height:1.8; color:#415466;">
                                Plans are built so you can continue from trial to live usage without losing access to your saved workflow.
                            </p>

                            <p style="margin:0 0 18px;">
                                <a href="<?php echo e($subscriptionUrl); ?>" style="display:inline-block; background:#12773e; color:#ffffff; text-decoration:none; padding:14px 24px; border-radius:12px; font-size:15px; font-weight:700;">View Subscription Plans</a>
                            </p>

                            <p style="margin:0; font-size:12px; line-height:1.6; color:#7a8b96;">If the button does not work, open this link:<br><?php echo e($subscriptionUrl); ?></p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 30px; background:#f6faf7; border-top:1px solid #e4efe8;">
                            <p style="margin:0; font-size:12px; line-height:1.6; color:#71808a;">
                                Need help choosing a plan? Contact support@myplexus.com.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/web/trial-expiry-reminder.blade.php ENDPATH**/ ?>