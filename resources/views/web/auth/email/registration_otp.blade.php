<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration OTP</title>
</head>
<body style="margin:0; padding:24px; background:#f3f7f4; font-family:Arial, Helvetica, sans-serif; color:#183328;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #d9e8df;">
        <div style="padding:24px 28px; background:linear-gradient(135deg, #183c2f 0%, #2f8158 100%); color:#ffffff;">
            <h1 style="margin:0; font-size:26px; line-height:1.2;">Your registration OTP</h1>
            <p style="margin:10px 0 0; font-size:14px; line-height:1.7; color:rgba(255,255,255,0.84);">
                Use this one-time password to complete your myplexus registration.
            </p>
        </div>

        <div style="padding:28px;">
            <p style="margin:0 0 16px; font-size:15px; line-height:1.8;">
                Hello,
            </p>
            <p style="margin:0 0 18px; font-size:15px; line-height:1.8;">
                We received a request to verify this email address for registration: <strong>{{ $email }}</strong>
            </p>

            <div style="margin:0 0 18px; padding:18px; border-radius:14px; background:#eef8f1; text-align:center;">
                <div style="font-size:13px; letter-spacing:0.14em; text-transform:uppercase; color:#4f6f5f; margin-bottom:10px;">One-Time Password</div>
                <div style="font-size:34px; font-weight:700; letter-spacing:0.22em; color:#1e6b45;">{{ $otp }}</div>
            </div>

            <p style="margin:0 0 12px; font-size:14px; line-height:1.8;">
                This OTP is valid for {{ $expiresInMinutes }} minutes.
            </p>
            <p style="margin:0; font-size:14px; line-height:1.8; color:#607467;">
                If you did not request this, you can safely ignore this email.
            </p>
        </div>
    </div>
</body>
</html>
