<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration OTP</title>
</head>
<body style="margin:0; padding:0; background:#eef6f1; font-family:Arial, Helvetica, sans-serif; color:#173043;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef6f1; margin:0; padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:620px; background:#ffffff; border-radius:22px; overflow:hidden; border:1px solid #d7eadf; box-shadow:0 18px 48px rgba(13, 64, 43, 0.12);">
                    <tr>
                        <td style="background:#0d2d45; padding:30px; color:#ffffff;">
                            <div style="font-size:32px; line-height:1; font-weight:800; letter-spacing:-1px;">myplexus</div>
                            <div style="margin-top:8px; width:72px; height:4px; background:#36b875; border-radius:20px;"></div>
                            <p style="margin:18px 0 0; font-size:15px; line-height:1.7; color:#d8f4e4;">
                                Secure email verification for your registration.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:34px 30px 30px;">
                            <div style="display:inline-block; padding:7px 12px; background:#eaf7ef; color:#12773e; border-radius:999px; font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase;">
                                Email OTP
                            </div>

                            <h1 style="margin:18px 0 12px; font-size:28px; line-height:1.25; color:#102b3f;">
                                Verify your email
                            </h1>

                            <p style="margin:0 0 18px; font-size:15px; line-height:1.8; color:#415466;">
                                We received a request to verify <strong><?php echo e($email); ?></strong> for a new myplexus account. Enter the code below to continue registration.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0; background:#f7fbf8; border:1px solid #dcefe3; border-radius:18px;">
                                <tr>
                                    <td align="center" style="padding:26px 18px;">
                                        <div style="font-size:12px; color:#6a7b86; text-transform:uppercase; letter-spacing:.16em; font-weight:700; margin-bottom:12px;">One-time password</div>
                                        <div style="font-size:40px; line-height:1; font-weight:800; letter-spacing:.20em; color:#12773e;"><?php echo e($otp); ?></div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 12px; font-size:15px; line-height:1.8; color:#415466;">
                                This OTP is valid for <strong><?php echo e($expiresInMinutes); ?> minutes</strong>.
                            </p>
                            <p style="margin:0; font-size:13px; line-height:1.7; color:#7a8b96;">
                                If you did not request this, you can safely ignore this email. Your account will not be created without the OTP.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 30px; background:#f6faf7; border-top:1px solid #e4efe8;">
                            <p style="margin:0; font-size:12px; line-height:1.6; color:#71808a;">
                                myplexus keeps this check in place to protect advisor accounts and client data.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/email/registration_otp.blade.php ENDPATH**/ ?>