<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>myplexus | Register</title>
	<link rel="shortcut icon" href="<?php echo e(asset('themes/frontend/assets/infosolz/images/favicon.png')); ?>" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/all.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/owl.carousel.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/login.css')); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .inline-action-group {
            display: flex;
            gap: 12px;
            align-items: stretch;
        }
        .inline-action-group input {
            flex: 1 1 auto;
        }
        .inline-action-btn {
            flex: 0 0 auto;
            min-width: 132px;
            border: 1px solid #379962;
            background: #379962;
            color: #fff;
            border-radius: 12px;
            padding: 0 18px;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }
        .inline-action-btn[disabled] {
            opacity: 0.65;
            cursor: not-allowed;
        }
        .field-help-text {
            font-size: 13px;
            margin-top: 8px;
            color: #688277;
        }
        .otp-row {
            margin-top: 14px;
        }
        .otp-status {
            margin-top: 8px;
            font-size: 13px;
            color: #2f8158;
        }
        @media (max-width: 575px) {
            .inline-action-group {
                flex-direction: column;
            }
            .inline-action-btn {
                width: 100%;
                min-height: 52px;
            }
        }
    </style>
   
    <?php
        $recaptchaSiteKey = env('RECAPTCHA_SITE_KEY');
        $recaptchaEnabled = !empty($recaptchaSiteKey);
    ?>
    <?php if($recaptchaEnabled): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
	
</head>
<body>

	<div class="main">
        <div class="login_main register_main">
            <div class="container">
            <?php if(session('error')): ?>
                    <div class="alert alert-danger danger-login new-dngr">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-success">
                        <p><?php echo e($message); ?></p>
                    </div>
                <?php endif; ?>
                <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/logo.png')); ?>" alt="" class="login_logo">
                <h1>Create Account</h1>
                
                <form method="post" action="<?php echo e(route('user.registration-store')); ?>" enctype="multipart/form-data" id="registrationForm">
                  <?php echo csrf_field(); ?>
                    <div class="upload_file">
                        <label class="label" for="input"><span>Logo</span></label>

                        <div class="input">
                            <input name="image" id="file" type="file">
                        </div>

                        <p>Upload logo</p>
                       
                    </div>
                    <?php if($errors->has('image')): ?>
                            <div class="text-danger"><?php echo e($errors->first('image')); ?></div>
                        <?php endif; ?>
                   

                    <div class="free_trial">
                        <span>Free Trial (14 Days)</span>
                         <p class="dont_acc up">Already Have An Account?   <a href="<?php echo e(route('user.user_login')); ?>"> Sign In Now!</a></p>
                    </div>

              
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Company Name</label>
                                <input type="text" name="company_name" id="company_name" value="<?php echo e(old('company_name')); ?>">
                                    <div class="text-danger"></div>
                                <?php if($errors->has('company_name')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('company_name')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Contact Person</label>
                                <input type="text" name="contact_person"  id="contact_person" value="<?php echo e(old('contact_person')); ?>">
                                <div class="text-danger"></div>
                                <?php if($errors->has('contact_person')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('contact_person')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Email</label>
                                <div class="inline-action-group">
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>">
                                    <button type="button" id="sendEmailOtpButton" class="inline-action-btn">Check Email</button>
                                </div>
                                <div class="field-help-text">Click Check Email to receive a 6-digit OTP on this address before registration.</div>
                                <div id="otp_status" class="otp-status"></div>
                                <div class="text-danger"></div>
                                <?php if($errors->has('email')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('email')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Email OTP</label>
                                <input type="text" name="email_otp" id="email_otp" maxlength="6" inputmode="numeric" value="<?php echo e(old('email_otp')); ?>">
                                <div class="field-help-text">Enter the OTP sent to your email. OTP is valid for 10 minutes.</div>
                                <div class="text-danger"></div>
                                <?php if($errors->has('email_otp')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('email_otp')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>City</label>
                                <input type="text" name="city" id="city" value="<?php echo e(old('city')); ?>">
                                <div class="text-danger"></div>
                                <?php if($errors->has('city')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('city')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>State</label>
                                <input type="text" name="state" id="state" value="<?php echo e(old('state')); ?>" >
                                <div class="text-danger"></div>
                                <?php if($errors->has('state')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('state')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>ARN</label>
                                <input type="text" name="arn" id="arn" value="<?php echo e(old('arn')); ?>">
                                <div class="text-danger"></div>
                                <?php if($errors->has('arn')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('arn')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>PAN</label>
                                <input type="text" name="pan"  id="pan" value="<?php echo e(old('pan')); ?>">
                                <div class="text-danger"></div>
                                <?php if($errors->has('pan')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('pan')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>GST</label>
                                <input type="text" name="gst" id="gst" value="<?php echo e(old('gst')); ?>">
                                <div class="text-danger"></div>
                                <?php if($errors->has('gst')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('gst')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" value="">
                                <div class="text-danger"></div>
                                <?php if($errors->has('password')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('password')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" value="">
                                <div class="text-danger"></div>
                                <?php if($errors->has('confirm_password')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('confirm_password')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- <div class="form_group radio_btns">
                                <input type="radio" id="test1" name="radio-group" checked>
                                <label for="test1">Paid</label>
                                <input type="radio" id="test2" name="radio-group">
                                <label for="test2">Free Trial (7 Days)</label>
                            </div> -->
                            <div class="form_group check_btns">
                                <input type="checkbox" id="html" name="privacy_policy"  value="1" <?php if(old('privacy_policy') == '1'): ?> checked <?php endif; ?>>
                                <label for="html"><a href="<?php echo e(route('web.page', ['slug' => 'privacy-policy'])); ?>" target="_blank">privacy policy</a>, <a href="<?php echo e(route('web.page', ['slug' => 'terms-of-service'])); ?>" target="_blank">terms & condition</a>.</label>
                                <div class="text-danger" id="privacy_policy_error"></div>
                                <?php if($errors->has('privacy_policy')): ?>
                                    <div class="text-danger"><?php echo e($errors->first('privacy_policy')); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="captcha">
                                    <!-- <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/capcha_box.png')); ?>" alt=""> -->
                                    <?php if($recaptchaEnabled): ?>
                                        <div
                                            class="g-recaptcha"
                                            data-sitekey="<?php echo e($recaptchaSiteKey); ?>"
                                            data-callback="onRegistrationRecaptchaSuccess"
                                            data-expired-callback="onRegistrationRecaptchaExpired"
                                        ></div>
                                        <div id="recaptcha_error" class="text-danger"></div>
                                        <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php else: ?>
                                        <div class="text-muted" style="font-size: 14px;">reCAPTCHA is disabled in this local environment because the site key is not configured.</div>
                                        <div id="recaptcha_error" class="text-danger"></div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="sign_in">
                                <input type="submit" value="Sign Up">
                                <p class="dont_acc">Already Have An Account?   <a href="<?php echo e(route('user.user_login')); ?>"> Sign In Now!</a></p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        
		<img class="left_bg" src="<?php echo e(asset('themes/frontend/assets/infosolz/images/left_img.png')); ?>" alt="">
		<img class="right_bg" src="<?php echo e(asset('themes/frontend/assets/infosolz/images/rignt_img.png')); ?>" alt="">
	</div>

	<script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery.min.js')); ?>"></script>
	<script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/icon.js')); ?>"></script>

    <script>
        function onRegistrationRecaptchaSuccess() {
            $('#recaptcha_error').html('');
        }

        function onRegistrationRecaptchaExpired() {
            $('#recaptcha_error').html('Please complete the reCAPTCHA verification.');
        }

        $(document).ready(function() 
        {
            var otpSentForEmail = '';

            function setFieldError(fieldId, message) {
                $('#' + fieldId).closest('.form_group').find('.text-danger').first().html(message || '');
            }

            function normalizeEmail(email) {
                return $.trim(email).toLowerCase();
            }

            function isValidEmail(email) 
            {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function showRegistrationMessage(message) {
                alert(message);
            }

            $('#email').on('input', function() {
                otpSentForEmail = '';
                $('#email_otp').val('');
                $('#otp_status').html('Please click Check Email again after changing the email address.');
                setFieldError('email_otp', '');
            });

            $('#sendEmailOtpButton').on('click', function() {
                var email = $('#email').val().trim();
                var $button = $(this);

                if (email === '') {
                    setFieldError('email', 'Email is required.');
                    $('#otp_status').html('');
                    return;
                }

                if (!isValidEmail(email)) {
                    setFieldError('email', 'Please enter a valid email address.');
                    $('#otp_status').html('');
                    return;
                }

                setFieldError('email', '');
                setFieldError('email_otp', '');
                $('#otp_status').html('');

                $.ajax({
                    url: "<?php echo e(route('user.registration-send-otp')); ?>",
                    type: "post",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        email: email
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $button.prop('disabled', true).text('Sending...');
                    },
                    success: function(response) {
                        otpSentForEmail = normalizeEmail(email);
                        $('#otp_status').html(response.message);
                        showRegistrationMessage('OTP sent successfully. Please enter the OTP from your email, then complete the form and click Sign Up.');
                        $('#email_otp').focus();
                    },
                    error: function(xhr) {
                        otpSentForEmail = '';
                        var response = xhr.responseJSON || {};
                        var validationErrors = response.errors || {};
                        var emailError = validationErrors.email ? validationErrors.email[0] : (response.message || 'Unable to send OTP right now.');
                        setFieldError('email', emailError);
                        $('#otp_status').html('');
                    },
                    complete: function() {
                        $button.prop('disabled', false).text('Check Email');
                    }
                });
            });

            $('#registrationForm').submit(function(event) 
            {
                // Prevent form submission
                event.preventDefault();

                // Perform client-side validation
                var isValid = true;

                // Validate company name
                var companyName = $('#company_name').val().trim();
                if (companyName === '') {
                    setFieldError('company_name', 'Company Name is required.');
                    isValid = false;
                } else {
                    setFieldError('company_name', '');
                }

                var contactPerson = $('#contact_person').val().trim();
                if (contactPerson === '') {
                    setFieldError('contact_person', 'Contact Person is required.');
                    isValid = false;
                } else {
                    setFieldError('contact_person', '');
                }

                // Validate email
                var email = $('#email').val().trim();
                if (email === '') 
                {
                  
                    setFieldError('email', 'Email is required.');
                    isValid = false;
                } else if (!isValidEmail(email)) 
                {
                    
                    setFieldError('email', 'Please enter a valid email address.');
                    isValid = false;
                } 
                else 
                {
                    setFieldError('email', '');
                }

                var emailOtp = $('#email_otp').val().trim();
                if (emailOtp === '') {
                    setFieldError('email_otp', 'Please enter the OTP sent to your email.');
                    showRegistrationMessage('Please enter the OTP sent to your email before signing up.');
                    isValid = false;
                } else if (!/^\d{6}$/.test(emailOtp)) {
                    setFieldError('email_otp', 'Email OTP must be 6 digits.');
                    showRegistrationMessage('Email OTP must be 6 digits.');
                    isValid = false;
                } else if (otpSentForEmail !== normalizeEmail(email)) {
                    setFieldError('email_otp', 'Please click Check Email and use the OTP sent to this email address.');
                    showRegistrationMessage('Please click Check Email first and enter the OTP sent to this email address.');
                    isValid = false;
                } else {
                    setFieldError('email_otp', '');
                }

                // Validate other fields similarly...

                var city = $('#city').val().trim();
                if (city === '') {
                    setFieldError('city', 'City is required.');
                    isValid = false;
                } else {
                    setFieldError('city', '');
                }
                var state = $('#state').val().trim();
                if (state === '') {
                    setFieldError('state', 'State is required.');
                    isValid = false;
                } else {
                    setFieldError('state', '');
                }

                var arn = $('#arn').val().trim();
                if (arn === '') {
                    setFieldError('arn', 'ARN is required.');
                    isValid = false;
                } 
                else if (!/^\d+$/.test(arn)) 
                {
                    setFieldError('arn', 'ARN must contain only numeric values.');
                    isValid = false;
                }
                else 
                {
                    setFieldError('arn', '');
                }

                var pan = $('#pan').val().trim();
                if (pan === '') {
                    setFieldError('pan', 'PAN is required.');
                    isValid = false;
                } 
                
                else if (!/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan)) 
                {
                    setFieldError('pan', 'Invalid PAN format. PAN should be in the format ABCDE1234F.');
                    isValid = false;
                }
                else
                {
                    setFieldError('pan', '');
                }

                var gst = $('#gst').val().trim();
                if (gst === '') {
                    setFieldError('gst', 'GST is required.');
                    isValid = false;
                } else if (!/^[a-zA-Z0-9]{15}$/.test(gst)) {
                    setFieldError('gst', 'GST must be alphanumeric and 15 characters long.');
                    isValid = false;
                } else {
                    setFieldError('gst', '');
                }

                // Validate password
                var password = $('#password').val().trim();
                if (password === '') 
                {
                    setFieldError('password', 'Password is required.');
                    isValid = false;
                } 
                else if (!/^(?=.*[a-zA-Z])(?=.*\d).+$/.test(password)) 
                {
                    setFieldError('password', 'Password must contain at least one alphabetic character and one numeric character.');
                    isValid = false;
                } 
                else if (password.length < 8) 
                {
                    setFieldError('password', 'Password must be at least 8 characters long.');
                    isValid = false;
                } 
                else 
                {
                    setFieldError('password', '');
                }

                // Validate confirm password
                var confirmPassword = $('#confirm_password').val().trim();
                if (confirmPassword === '') {
                    setFieldError('confirm_password', 'Confirm Password is required.');
                    isValid = false;
                } else if (confirmPassword !== password) {
                    setFieldError('confirm_password', 'Passwords do not match.');
                    isValid = false;
                } else {
                    setFieldError('confirm_password', '');
                }


                // Validate privacy policy checkbox
                if (!$('#html').is(':checked')) 
                {
                    $('#privacy_policy_error').html('You must agree to the Privacy Policy.');
                    isValid = false;
                    
                } 
                else 
                {
                    $('#privacy_policy_error').html('');
                }

                // Validate reCAPTCHA
                var recaptchaResponse = 'local-bypass';
                if (<?php echo e($recaptchaEnabled ? 'true' : 'false'); ?>) {
                    recaptchaResponse = '';
                }

                if (<?php echo e($recaptchaEnabled ? 'true' : 'false'); ?> && typeof grecaptcha !== 'undefined' && typeof grecaptcha.getResponse === 'function') {
                    recaptchaResponse = grecaptcha.getResponse();
                }

                if (<?php echo e($recaptchaEnabled ? 'true' : 'false'); ?> && !recaptchaResponse) 
                {
                    $('#recaptcha_error').html('Please complete the reCAPTCHA verification.');
                    isValid = false;
                } 
                else 
                {
                    $('#recaptcha_error').html('');
                }



                // If form is valid, submit the form
                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>

</body>
</html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/registration.blade.php ENDPATH**/ ?>