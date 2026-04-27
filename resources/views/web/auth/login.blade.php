
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>myplexus | Login</title>
        <link rel="shortcut icon" href="{{asset('themes/frontend/assets/infosolz/images/favicon.png')}}" type="image/x-icon">
        <!-- <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"> -->
        <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/all.min.css' )}}">
        <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/owl.carousel.min.css' )}}">
        <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/login.css' )}}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        
    </head>
    <body>
    <div class="main log_main">
        <div class="login_main">
            <figure>
                <img src="{{ asset('themes/frontend/assets/infosolz/images/logo.png') }}" alt="" class="login_logo">
                <!-- <img src="images/logo.png" alt="" class="login_logo"> -->
                <h1>Login</h1>
            </figure>
            <!-- <div class="new_form new_form2"> 
                <h4>Login</h4>  -->

                <div class="login_with">
                <h5>Sign In with</h5>
                <ul>
                    <li><a href="{{ route('user.login.google') }}"><i class="fa-brands fa-google"></i></a></li>
                    <li><a href="{{ route('user.login.facebook') }}"><i class="fa fa-facebook"></i></a></li>
                </ul>
                <h5>Or</h5>
            </div>

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
            
                <form method="POST" action="{{ route('user.loginpost', [], false) }}" class="contact-wrapper">
                    @csrf
                    <div class="form_group" data-floating-group>
                        <label>User Name</label>
                        <input type="email" name="email" autocomplete="email" class="user_img" data-floating-input>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
				    </div>
                    

                    <div class="form_group" data-floating-group>
                        <label>Password</label>
                        <div class="show_hide_pass">
                            <input ondrop="return false;" name="password" autocomplete="new-password" type="password" data-floating-input>
                            <i class="toggle_password fa fa-fw fa-eye-slash" aria-hidden="true"></i>
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <input type="hidden" name="pageurl"  value="{{isset($cal)?$cal:''}}" >

                    {{-- @if (Route::has('password.request'))
                                    <div class="contact-form">
                                        <p><a href="{{ route('password.request') }}">Forgot Password?</a></p>
                                    </div>
                                @endif --}}
                                
                    <div class="form_group">
					    <a href="#" class="forgot_pass">Forgot Password?</a>
				    </div>
                   
                    <input type="submit" value="Sign in">
                    <p class="dont_acc">Don't Have An Account Yet?   <a href="{{ route('user.registration') }}"> Create An Account</a></p>

                   <!-- <button type="submit">Log in <img src="{{asset('assets/images/arw.png')}}" alt=""></button>  -->
                      <!-- <a href="{{ route('user.registration') }}" class="reg">Registration</a>  -->
                </form>
            <!-- </div> -->

           
        </div>
            <img class="left_bg" src="{{asset('themes/frontend/assets/infosolz/images/left_img.png')}}" alt="">
		    <img class="right_bg" src="{{asset('themes/frontend/assets/infosolz/images/rignt_img.png')}}" alt="">
    </div>
        <script src="{{asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')}}"></script>
	    <script src="{{asset('themes/frontend/assets/infosolz/js/jquery.min.js')}}"></script>
	    <script src="{{asset('themes/frontend/assets/infosolz/js/owl.carousel.min.js')}}"></script>
	    <script src="{{asset('themes/frontend/assets/infosolz/js/icon.js')}}"></script>
        <!-- <style media="all" id="fa-v4-font-face"> -->
        <script src="{{ asset('themes/frontend/assets/infosolz/js/main.js') }}"></script>
        
    </body>
</html>
