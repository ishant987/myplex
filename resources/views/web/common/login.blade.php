<!-- login modal -->

{{-- 
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body"> --}}
                <!--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                @php
                    $url = $source=='calucator' ? route('web.calculators')   :'';   
                @endphp
                <form action="{{$url}}" method="POST" class="login_form">
                    {!! csrf_field() !!}
                <div class="login_form_wrapper">
                    <div class="login_form_header d-flex align-items-center justify-content-between">
                        <h4>Sign In</h4>
                        <p>or <b><a href="#" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">create account</a></b></p>
                    </div>
                    <div class="socila_login">
                        <a href="{{ route('web.calculators.social.login','google') }}" class="btn btn-block w-100"><span><i class="ph-google-logo-bold"></i></span> Sign in With Google</a>
                    </div>
                    <div class="separate_or text-center mb-4 mt-3"><span>or</span></div>
                    <div class="login_fomr">
                        @if( $source=='calucator')
                        <input type="text" class="login_input" placeholder="Name" name="username"  required/>
                        <input type="text" class="login_input" placeholder="Email" name="useremail" required />
                        <div class="login_form_footer d-flex align-items-center justify-content-between mt-3 mb-3">
                            <div>
                                {{-- <a  href="javascript://" class="sign_in_btn money_title_btn cal_sign_in"></a> --}}
                                <input type="submit" value="Sign In" class="sign_in_btn money_title_btn"  style="border:0px !important"/>
                            </div>

                        </div>
                        @else
                        <input type="text" class="login_input" placeholder="Email" name="useremail" />
                        <input type="password" class="login_input" placeholder="Password" name="password" />
                        <div class="login_form_footer d-flex align-items-center justify-content-between mt-3 mb-3">
                            <div class="remember_det d-flex">
                                <input type="checkbox" /> Remember me
                            </div>
                            <div>
                                <a href="#" class="sign_in_btn money_title_btn ">Sign In</a>
                            </div>
                        </div>
                        <div class="forget_pass">
                            <a href="#">Forgot your passwords?</a>
                        </div>
                        @endif
                        
                    </div>
                </div>
                </form>
            {{-- </div>
        </div>
    </div>
</div> --}}


<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="login_form_wrapper">
                    <div class="login_form_header d-flex align-items-center justify-content-between">
                        <h4>Sign Up</h4>
                        <p>Already Have Acount <b><a href="#" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal"> Login Now</a></b></p>
                    </div>
                    <div class="socila_login">
                        <a href="#" class="btn btn-block w-100"><span><i class="ph-google-logo-bold"></i></span> Sign Up With Google</a>
                    </div>
                    <div class="separate_or text-center mb-4 mt-3"><span>or</span></div>
                    <div class="login_fomr">
                        <form action="{{ route('web.signup.save') }}" name="signupFrm" id="signupFrm" method="post">
                            {{ csrf_field() }}
                            <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />
                        <input type="text" class="login_input" placeholder="Your Name" name="f_name" id="f_name"/>
                        <input type="text" class="login_input" placeholder="Phone Number" name="mobile" id="mobile"/>
                        <input type="email" class="login_input" placeholder="Email Address" name="email" id="email"/>
                        </form>
                        <div class="login_form_footer d-flex align-items-center justify-content-between mt-2 mb-3">

                            <div>
                                <a href="javascript://" id="sendSignupFrm" class="sign_in_btn money_title_btn">Sign Up</a>
                            </div>
                        </div>
                        <div id="msg_id"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

