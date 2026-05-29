<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myplexus | Verification Pending</title>
    <link rel="shortcut icon" href="{{asset('themes/frontend/assets/infosolz/images/favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/login.css')}}">
    <style>
        body {
            min-height: 100vh;
            background: #f4faf6;
            font-family: Poppins, Arial, sans-serif;
        }
        .pending-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 18px;
        }
        .pending-card {
            width: min(680px, 100%);
            background: #fff;
            border: 1px solid #dcebe2;
            border-radius: 22px;
            padding: 42px;
            box-shadow: 0 24px 70px rgba(22, 69, 44, 0.12);
            text-align: center;
        }
        .pending-card img {
            width: 220px;
            max-width: 70%;
            margin-bottom: 24px;
        }
        .pending-card h1 {
            margin: 0 0 14px;
            color: #17362a;
            font-size: 34px;
            line-height: 1.2;
            font-weight: 700;
        }
        .pending-card p {
            margin: 0 auto 24px;
            max-width: 520px;
            color: #597064;
            font-size: 16px;
            line-height: 1.8;
        }
        .pending-card .btn {
            border-radius: 999px;
            padding: 13px 28px;
            background: #2f8c5b;
            border: 0;
            color: #fff;
            font-weight: 700;
        }
        .pending-status {
            display: inline-block;
            margin-bottom: 18px;
            padding: 8px 14px;
            border-radius: 999px;
            background: #eef8f1;
            color: #226c45;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }
        @media (max-width: 575px) {
            .pending-card {
                padding: 30px 20px;
            }
            .pending-card h1 {
                font-size: 27px;
            }
        }
    </style>
</head>
<body>
    <div class="pending-wrap">
        <div class="pending-card">
            <img src="{{asset('themes/frontend/assets/infosolz/images/logo.png')}}" alt="myplexus">
            <span class="pending-status">Verification Pending</span>
            <h1>We are verifying your ARN details.</h1>
            <p>Your registration has been received. Our team will check your ARN number and account details. Please stay tuned, you will be able to log in once the admin verifies your account.</p>
            <a class="btn" href="{{ route('user.user_login') }}">Back to Sign In</a>
        </div>
    </div>
</body>
</html>
