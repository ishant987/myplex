<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Subscription Expiring Soon</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(180deg, #56BF84 0%, #12773E 112%); padding: 32px 24px; text-align: center; }
        .header img { max-width: 160px; height: auto; }
        .body { padding: 32px 24px; }
        .body h2 { color: #1f2937; font-size: 22px; margin-bottom: 12px; }
        .body p { color: #344054; font-size: 15px; line-height: 1.6; margin-bottom: 16px; }
        .highlight { background: #f3f8f5; border: 1px solid #dcece1; border-radius: 10px; padding: 16px 20px; margin: 20px 0; }
        .highlight p { margin: 0; font-size: 15px; color: #12773E; font-weight: 600; }
        .btn { display: inline-block; background: linear-gradient(180deg, #56BF84 0%, #12773E 112%); color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 10px; font-size: 15px; font-weight: 600; margin-top: 8px; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 24px; text-align: center; }
        .footer p { margin: 0; font-size: 13px; color: #667085; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('themes/frontend/assets/v1/img/logo_dash.png') }}" alt="myplexus">
        </div>
        <div class="body">
            <h2>Hi {{ $user->f_name ?: 'User' }},</h2>
            <p>Your <strong>myplexus</strong> subscription is expiring in <strong>3 days</strong>.</p>

            <div class="highlight">
                <p>Expiry Date: {{ \Carbon\Carbon::parse($expiry_date)->format('d M Y') }}</p>
            </div>

            <p>
                To continue enjoying uninterrupted access to Ratio Reports, Composition Reports,
                Indies Reports, Filters, Predictive tools and more, please renew your subscription
                before it expires.
            </p>

            <p>
                <a href="{{ $renewal_url }}" class="btn">Renew Subscription</a>
            </p>

            <p style="margin-top: 24px; font-size: 13px; color: #667085;">
                If you have already renewed, please ignore this email.
                For support, contact us at support@myplexus.com.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} myplexus.com. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
