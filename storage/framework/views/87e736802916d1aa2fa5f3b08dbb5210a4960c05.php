<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to myplexus</title>
</head>
<body style="margin:0; padding:0; background:#eef6f1; font-family:Arial, Helvetica, sans-serif; color:#173043;">
    <?php
        $displayName = trim((string) ($user->f_name ?? '') . ' ' . (string) ($user->l_name ?? ''));
        $displayName = $displayName !== '' ? $displayName : ($user->contact_person ?: ($user->company ?: 'there'));
    ?>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef6f1; margin:0; padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; background:#ffffff; border-radius:22px; overflow:hidden; border:1px solid #d7eadf; box-shadow:0 18px 48px rgba(13, 64, 43, 0.12);">
                    <tr>
                        <td style="background:#0d2d45; padding:30px 30px 26px; color:#ffffff;">
                            <div style="font-size:34px; line-height:1; font-weight:800; letter-spacing:-1px; color:#ffffff;">myplexus</div>
                            <div style="margin-top:8px; width:72px; height:4px; background:#36b875; border-radius:20px;"></div>
                            <p style="margin:18px 0 0; font-size:15px; line-height:1.7; color:#d8f4e4;">
                                Your mutual fund fog light is ready.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:34px 30px 30px;">
                            <div style="display:inline-block; padding:7px 12px; background:#eaf7ef; color:#12773e; border-radius:999px; font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase;">
                                Welcome aboard
                            </div>

                            <h1 style="margin:18px 0 12px; font-size:28px; line-height:1.25; color:#102b3f;">
                                Hi <?php echo e($displayName); ?>,
                            </h1>

                            <p style="margin:0 0 18px; font-size:15px; line-height:1.8; color:#415466;">
                                Your myplexus account has been created successfully. We are excited to help you track, compare, and understand mutual fund data with more clarity.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:22px 0; background:#f7fbf8; border:1px solid #dcefe3; border-radius:16px;">
                                <tr>
                                    <td style="padding:18px 20px;">
                                        <p style="margin:0 0 8px; font-size:13px; color:#6a7b86; text-transform:uppercase; letter-spacing:.08em; font-weight:700;">Account email</p>
                                        <p style="margin:0; font-size:17px; color:#102b3f; font-weight:700;"><?php echo e($user->email); ?></p>
                                        <?php if(!empty($plainPassword)): ?>
                                            <p style="margin:16px 0 8px; font-size:13px; color:#6a7b86; text-transform:uppercase; letter-spacing:.08em; font-weight:700;">Password</p>
                                            <p style="margin:0; font-size:17px; color:#102b3f; font-weight:700;"><?php echo e($plainPassword); ?></p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>

                            <?php if(!empty($verifyUrl)): ?>
                                <p style="margin:0 0 18px; font-size:15px; line-height:1.8; color:#415466;">
                                    Please verify your email address to activate your account.
                                </p>
                                <p style="margin:0 0 18px;">
                                    <a href="<?php echo e($verifyUrl); ?>" style="display:inline-block; background:#12773e; color:#ffffff; text-decoration:none; padding:14px 24px; border-radius:12px; font-size:15px; font-weight:700;">Verify Email</a>
                                </p>
                                <p style="margin:0; font-size:12px; line-height:1.6; color:#7a8b96;">If the button does not work, open this link:<br><?php echo e($verifyUrl); ?></p>
                            <?php elseif(!empty($loginUrl)): ?>
                                <p style="margin:0 0 18px; font-size:15px; line-height:1.8; color:#415466;">
                                    You can sign in any time using the link below.
                                </p>
                                <p style="margin:0;">
                                    <a href="<?php echo e($loginUrl); ?>" style="display:inline-block; background:#12773e; color:#ffffff; text-decoration:none; padding:14px 24px; border-radius:12px; font-size:15px; font-weight:700;">Go To Login</a>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 30px; background:#f6faf7; border-top:1px solid #e4efe8;">
                            <p style="margin:0; font-size:12px; line-height:1.6; color:#71808a;">
                                Thank you for joining myplexus. For support, contact support@myplexus.com.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/emails/web/welcome_account.blade.php ENDPATH**/ ?>