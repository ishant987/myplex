<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You</title>
</head>
<body style="margin: 0; padding: 0; font-family: Verdana, Geneva, sans-serif;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;max-width: 840px;margin: 15px auto;padding: 20px;border: 1px solid #efefef;">
    <tr>
        <td style="padding:15px;">
            <img src="https://myplexus.com/themes/frontend/assets/infosolz/images/logo.png" alt="Logo" style="width:100%; max-width: 150px; display: block; margin: 0 auto;">
        </td>
    </tr>
    <tr>
        <td style="padding:20px 0; text-align:center;">
          
            <h2 style="font-size: 30px; font-weight: 400; color:#313131; margin-top: 15px; margin-bottom: 0;">Thank You</h2>
            <h3 style="font-size: 20px; color:#6a6a6a; font-weight:400; margin:0;">Your registration has been completed successfully.</h3>
        </td>
    </tr>
    <tr>
        <td style="padding:5px 15px;"><p style="text-align:left; color:#4a4a4a; font-size:12px; margin:0; padding:0px 0;">
            We are pleased to welcome you to Myplexus and confirm that your registration was successful. Below, you will find your login credentials:</p></td>
    </tr>
    <tr>
        <td style="padding:5px 15px;"><p style="text-align:left; color:#4a4a4a; font-size:12px; margin:0; padding:0px 0;">
            User Name : <span style="color:#156db9;">{{ $email }}</span></p></td>
    </tr>
    <tr>
        <td style="padding:5px 15px;"><p style="text-align:left; color:#4a4a4a; font-size:12px; margin:0; padding:0px 0;">
            Password : {{ $password }}</p></td>
    </tr>
    <tr>
        <td style="padding:5px 15px;">
            <p style="text-align:left; color:#4a4a4a; font-size:12px; margin:0; padding:0px 0;">
                To confirm the email address and activate the account, please click on the button below.
                <a href="https://myplexus.com/verify-email/{{$id}}"> Verify</a>
                <br>
                or copy/paste the URL below into your browser:<br>
            
                <span>https://myplexus.com/verify-email/{{$id}}</span>


            </p>
        </td>
    </tr>
    <tr>
        <td style="padding:20px 0; text-align: left;">
            <p style="color:#4a4a4a;  font-size:12px; margin:0; padding:0px 0;">Warm Regards</p>
            <p style="color:#4a4a4a;  font-size:12px; margin:0; padding:0px 0;">Myplexus<br>{{ date("d-m-Y",strtotime($date)) }}</p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #022a5b; padding:6px 0;">
            <p style="color:#fff; font-family:Verdana, Geneva, sans-serif; text-align:center; font-size:11px;">© {{ date("Y",strtotime($date)) }} by Myplexus. All Rights Reserved</p>
        </td>
    </tr>
</table>

</body>
</html>
