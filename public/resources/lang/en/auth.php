<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'sign_in_txt' => 'Login',
    'sign_in2_txt' => 'Sign In Now!',
    'sign_up_txt' => 'Register',
    'sign_up2_txt' => 'Create An Account',
    'remember_me_txt' => 'Remember me',
    'or_txt' => 'OR',
    'sign_in_f_password_txt' => 'Forgot Password?',
    'signup_prfx_txt' => "Don't Have An Account Yet?",
    'sign_in_prfx_txt' => "Already Have An Account?",
    'lgn_with_google_txt' => 'Login with Google',
    'lgn_with_facebook_txt' => 'Login with Facebook',
    'lgn_with_microsoft_txt' => 'Login with Microsoft',
    'lgn_with_apple_txt' => 'Login with Apple ID',
    'sgnup_with_google_txt' => 'Register with Google',
    'sgnup_with_facebook_txt' => 'Register with Facebook',
    'sgnup_with_microsoft_txt' => 'Register with Microsoft',
    'sgnup_with_apple_txt' => 'Register with Apple ID',

    'dshbrd_txt' => 'Dashboard',
    'reset_password_txt' => 'Reset Password',
    'edit_profile_txt' => 'Edit Profile',
    'logout_txt' => 'Logout',

    'thank_you_txt' => 'Thank you.',
    'bk_to_website_txt' => 'Back to website',

    'f_password_hdng_txt' => 'Recover your password',
    'f_password_txt' => 'Forgot Password',
    'f_password_sign_in_txt' => 'Back to Login',
    'f_password_btn_txt' => 'Reset My Password',
    'f_password_email_lbl_txt' => 'Enter your registered email id',
    'f_password_email_plchldr_txt' => 'example@email.com',

    'verification_code_txt' => 'Verification Code',

    'f_password_mail_p_sfx' => " is your login Password.",
    'f_password_mail_h_txt' => 'Congrats! Your password has been reset.',
    'f_password_mail_f_name' => "Forgot Password",
    'f_password_mail_sbjct' => "Forgot Password" . __('common.mail_sbjct_sfx'),

    'su_reg_mail_sbjct' => "Welcome to your new " . env('APP_NAME') . " account",
    'su_reg_front_mail_p' => "Thank you for registering with " . env('APP_NAME') . ". Below your account login details :",
    'su_reg_admin_mail_p' => "Your account has been created by " . env('APP_NAME') . " Team. Below your account login details :",
    'su_reg_user_mail_p' => "Thank you for registering with us. Please find below your account login details -",
    'su_reg_mail_f_name' => "Sign Up",
    'su_reg_mail_username' => "Email Id",

    'su_f_pswd_mail_sbjct' => "Reset Password" . __('common.mail_sbjct_sfx'),
    'su_f_pswd_mail_p_pfx' => 'Please use this 6 digit code ',
    'su_f_pswd_mail_p_sfx' => ' to reset your ' . env('APP_NAME') . ' account password.',
    'su_f_pswd_mail_f_name' => 'Reset Password',


    'validation' => [
        'required' => [],
    ],

    'error' => [
        'login_username' => 'Incorrect username/password.',
        'no_acc_username' => 'Account not found for given username.',

        'no_acc_email' => 'This email id does not exist in our system.',
        'password' => 'Password given is incorrect.',
        'verify_code' => 'Invalid Verification code.',
        'otp' => 'Invalid OTP.',

        'secret' => 'Incorrect secret.',
        'secret_not_given' => 'Administrator not given secret to your account for publishing the uploaded values.',
    ],

    'success' => [
        'login' => "Login successfully.",
        'logout' => 'Logged out successfully!',
        'f_password' => 'Your new password has been sent to given email id.',
        'su_signup' => "Thank You for Signing Up.",
        'su_profile' => "Successfully updated your profile.",
        'verify_code' => "Your account verified successfully please login to your account.",
        'verify_email_code' => "Your email verified successfully.",
        'verify_mobile_code' => "Your mobile number verified successfully.",
    ],

    'info' => [],

    'warning' => [
        'acc_disabled' => 'Account disabled by administrator.',
        'acc_approved' => 'Please verify your account.',
        'email_not_provided' => 'Your social media account does not have an email ID configured, please try with other platforms or use your email ID to sign up.',
        'account_not_found' => 'Account with this credential does not exist.'
    ],

];
