<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>myplexus | Register</title>
	<link rel="shortcut icon" href="{{asset('themes/frontend/assets/infosolz/images/favicon.png')}}" type="image/x-icon">
	<link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/login.css')}}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
</head>
<body>

	<div class="main">
        <div class="login_main register_main">
            <div class="container">
            @if (session('error'))
                    <div class="alert alert-danger danger-login new-dngr">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <img src="{{asset('themes/frontend/assets/infosolz/images/logo.png')}}" alt="" class="login_logo">
                <h1>Create Account</h1>
                
                <form method="post" action="{{route('user.registration-store')}}" enctype="multipart/form-data" id="registrationForm">
                  @csrf
                    <div class="upload_file">
                        <label class="label" for="input"><span>Logo</span></label>

                        <div class="input">
                            <input name="image" id="file" type="file">
                        </div>

                        <p>Upload logo</p>
                       
                    </div>
                    @if ($errors->has('image'))
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                        @endif
                   

                    <div class="free_trial">
                        <span>Free Trial (14 Days)</span>
                         <p class="dont_acc up">Already Have An Account?   <a href="{{route('user.user_login')}}"> Sign In Now!</a></p>
                    </div>

              
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Company Name</label>
                                <input type="text" name="company_name" id="company_name" value="{{old('company_name')}}">
                                    <div class="text-danger"></div>
                                @if ($errors->has('company_name'))
                                    <div class="text-danger">{{ $errors->first('company_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Contact Person</label>
                                <input type="text" name="contact_person"  id="contact_person" value="{{old('contact_person')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('contact_person'))
                                    <div class="text-danger">{{ $errors->first('contact_person') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Email</label>
                                <input type="email"  name="email" id="email" value="{{old('email')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>City</label>
                                <input type="text" name="city" id="city" value="{{old('city')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('city'))
                                    <div class="text-danger">{{ $errors->first('city') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>State</label>
                                <input type="text" name="state" id="state" value="{{old('state')}}" >
                                <div class="text-danger"></div>
                                @if ($errors->has('state'))
                                    <div class="text-danger">{{ $errors->first('state') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>ARN</label>
                                <input type="text" name="arn" id="arn" value="{{old('arn')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('arn'))
                                    <div class="text-danger">{{ $errors->first('arn') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>PAN</label>
                                <input type="text" name="pan"  id="pan" value="{{old('pan')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('pan'))
                                    <div class="text-danger">{{ $errors->first('pan') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>GST</label>
                                <input type="text" name="gst" id="gst" value="{{old('gst')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('gst'))
                                    <div class="text-danger">{{ $errors->first('gst') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" value="{{old('password')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" value="{{old('confirm_password')}}">
                                <div class="text-danger"></div>
                                @if ($errors->has('confirm_password'))
                                    <div class="text-danger">{{ $errors->first('confirm_password') }}</div>
                                @endif
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
                                <input type="checkbox" id="html" name="privacy_policy"  value="1" @if(old('privacy_policy') == '1') checked @endif>
                                <label for="html"><a href="{{ route('web.page', ['slug' => 'privacy-policy']) }}" target="_blank">privacy policy</a>, <a href="{{ route('web.page', ['slug' => 'terms-of-service']) }}" target="_blank">terms & condition</a>.</label>
                                <div class="text-danger" id="privacy_policy_error"></div>
                                @if ($errors->has('privacy_policy'))
                                    <div class="text-danger">{{ $errors->first('privacy_policy') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="captcha">
                                    <!-- <img src="{{asset('themes/frontend/assets/infosolz/images/capcha_box.png')}}" alt=""> -->
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                    <div id="recaptcha_error" class="text-danger"></div>
                                    @error('g-recaptcha-response')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="sign_in">
                                <input type="submit" value="Sign Up">
                                <p class="dont_acc">Already Have An Account?   <a href="{{route('user.user_login')}}"> Sign In Now!</a></p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        
		<img class="left_bg" src="{{asset('themes/frontend/assets/infosolz/images/left_img.png')}}" alt="">
		<img class="right_bg" src="{{asset('themes/frontend/assets/infosolz/images/rignt_img.png')}}" alt="">
	</div>

	<script src="{{asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('themes/frontend/assets/infosolz/js/jquery.min.js')}}"></script>
	<script src="{{asset('themes/frontend/assets/infosolz/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('themes/frontend/assets/infosolz/js/icon.js')}}"></script>
	<script src="{{asset('themes/frontend/assets/infosolz/js/main.js')}}"></script>

    <script>
       

        $(document).ready(function() 
        {
            $('#registrationForm').submit(function(event) 
            {
                // Prevent form submission
                event.preventDefault();

                // Perform client-side validation
                var isValid = true;

                // Validate company name
                var companyName = $('#company_name').val().trim();
                if (companyName === '') {
                    $('#company_name').next('.text-danger').html('Company Name is required.');
                    isValid = false;
                } else {
                    $('#company_name').next('.text-danger').html('');
                }

                var contactPerson = $('#contact_person').val().trim();
                if (companyName === '') {
                    $('#contact_person').next('.text-danger').html('Contact Person is required.');
                    isValid = false;
                } else {
                    $('#contact_person').next('.text-danger').html('');
                }

                // Validate email
                var email = $('#email').val().trim();
                if (email === '') 
                {
                  
                    $('#email').next('.text-danger').html('Email is required.');
                    isValid = false;
                } else if (!isValidEmail(email)) 
                {
                    
                    $('#email').next('.text-danger').html('Please enter a valid email address.');
                    isValid = false;
                } 
                else 
                {
                    // Clear previous error message
                    
                    $('#email').next('.text-danger').html('');

                    // Check email uniqueness
                    
                    checkEmailUnique(email);
                
                }

                // Validate other fields similarly...

                var city = $('#city').val().trim();
                if (city === '') {
                    $('#city').next('.text-danger').html('City is required.');
                    isValid = false;
                } else {
                    $('#city').next('.text-danger').html('');
                }
                var state = $('#state').val().trim();
                if (state === '') {
                    $('#state').next('.text-danger').html('State is required.');
                    isValid = false;
                } else {
                    $('#state').next('.text-danger').html('');
                }

                var arn = $('#arn').val().trim();
                if (arn === '') {
                    $('#arn').next('.text-danger').html('ARN is required.');
                    isValid = false;
                } 
                else if (!/^\d+$/.test(arn)) 
                {
                    $('#arn').next('.text-danger').html('ARN must contain only numeric values.');
                    isValid = false;
                }
                else 
                {
                    $('#arn').next('.text-danger').html('');
                }

                var pan = $('#pan').val().trim();
                if (pan === '') {
                    $('#pan').next('.text-danger').html('PAN is required.');
                    isValid = false;
                } 
                
                else if (!/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan)) 
                {
                    $('#pan').next('.text-danger').html('Invalid PAN format. PAN should be in the format ABCDE1234F.');
                    isValid = false;
                }
                else
                {
                    $('#pan').next('.text-danger').html('');
                }

                var gst = $('#gst').val().trim();
                if (gst === '') {
                    $('#gst').next('.text-danger').html('GST is required.');
                    isValid = false;
                } else if (!/^[a-zA-Z0-9]{15}$/.test(gst)) {
                    $('#gst').next('.text-danger').html('GST must be alphanumeric and 15 characters long.');
                    isValid = false;
                } else {
                    $('#gst').next('.text-danger').html('');
                }

                // Validate password
                var password = $('#password').val().trim();
                if (password === '') 
                {
                    $('#password').next('.text-danger').html('Password is required.');
                    isValid = false;
                } 
                else if (!/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]+$/.test(password)) 
                {
                    $('#password').next('.text-danger').html('Password must contain both alphabetic and numeric characters.');
                    isValid = false;
                } 
                else if (password.length < 8) 
                {
                    $('#password').next('.text-danger').html('Password must be at least 8 characters long.');
                    isValid = false;
                } 
                else 
                {
                    $('#password').next('.text-danger').html('');
                }

                // Validate confirm password
                var confirmPassword = $('#confirm_password').val().trim();
                if (confirmPassword === '') {
                    $('#confirm_password').next('.text-danger').html('Confirm Password is required.');
                    isValid = false;
                } else if (confirmPassword !== password) {
                    $('#confirm_password').next('.text-danger').html('Passwords do not match.');
                    isValid = false;
                } else {
                    $('#confirm_password').next('.text-danger').html('');
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
                if (!$('.g-recaptcha-response').val()) 
                {
                    //console.log('ok');
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

            function isValidEmail(email) 
            {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function checkEmailUnique(email) {
                $.ajax({
                    url: '/check-email-unique',
                    type: 'POST', // Use POST method
                    data: {email: email, _token: '{{ csrf_token() }}'},
                    success: function(response) {
                        if (!response.unique) {
                            $('#email').next('.text-danger').html('This email is already in use.');
                            isValid = false;
                        }
                    },
                    error: function() {
                        $('#email').next('.text-danger').html('Error checking email uniqueness.');
                        isValid = false;
                    }
                });
            }
        });
    </script>

</body>
</html>
