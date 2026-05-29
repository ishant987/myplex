@extends('web.layout.app')
@if(isset($dataArr['meta_title']))
@section('page-title'){{$dataArr['meta_title']}}@stop
@else
@section('page-title'){{$dataArr['title']}}@stop
@endif
@if(isset($dataArr['meta_key']))
@section('meta-keywords'){{$dataArr['meta_key']}}@stop
@endif
@if(isset($dataArr['meta_descp']))
@section('meta-description'){{$dataArr['meta_descp']}}@stop
@endif
@if(isset($dataArr['image_path']))
@section('meta-image'){{$dataArr['image_path']}}@stop
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif

@section('vue-js') @stop
@section('content')
<style>
.login-page .login-block, .sip-calc-login .login-block {
    margin: 55px 0;
    border: 1px solid #e7e4e4;
}
.login-page .login-block .login-wrap, .sip-calc-login .login-block .login-wrap {
    padding: 75px 0 75px 0;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper {
    max-width: 55%;
    flex: 55%;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper h3 {
    text-align: center;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap {
    margin: 0 auto;
    width: 75%;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login {
    text-align: center;
    margin: 35px 0 0 0;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .login-field {
    margin-top: 5px;
}
	.sip-calc-login .login-block .login-wrap .password-field {
    margin-top: 20px;
}
	.login-page .login-block .login-wrap .log-other-opt, .sip-calc-login .login-block .login-wrap .log-other-opt {
    margin-top: 20px;
}
	.box-shadow {
    box-shadow: 2px 8px 15px -6px #0000001f;
}
input {
    border: 1px solid #e7e4e4;
    border-radius: 5px;
    padding: 12px 16px;
    box-shadow: 2px 8px 15px -6px #0000001f;
}
input, select, textarea {
    width: 100%;
    line-height: normal;
    font-family: 'Volte-Medium';
    color: #000;
    font-size: 16px;
}
	form label {
    color: #6ab130;
    margin: 0 0 10px 0;
    display: block;
    line-height: normal;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login ul li img {
    width: 100%;
    border-radius: 5px;
}
	ul {
    padding: 0;
    margin: 0;
    list-style-type: none;
}
	.sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login ul li:first-child {
    margin-top: 10px;
}

.sip-calc-login .login-block .login-wrap .sip-calc-wrapper .sip-calc-loginin-wrap .sip-calc-social-login ul li {
    margin-top: 15px;
}
	.float-right {
    float: right!important;
}
	.btn-bg-2 {
    background: #6ab130;
}
</style>
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>{{ $dataArr['title'] }}</h4>
                    <p>
                        {{-- {!! nl2br($dataArr['descp'])!!} --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@if(session()->has('username') && session()->has('useremail') )
<div id="vue-app">
    <calculators image_path="{{asset('themes/frontend/assets/v1/img/')}}" sip_faqs="" sip_pdf_url="{{ isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:'' }}" username="{{ session()->get('username') }}" useremail="{{ session()->get('useremail') }}"></calculators>
</div>

<div id="vue-app">
    <calculators image_path="{{asset('themes/frontend/assets/v1/img/')}}" sip_faqs="" sip_pdf_url="{{ isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:'' }}" username="{{ session()->get('username') }}" useremail="{{ session()->get('useremail') }}"></calculators>
</div>
@else
<div class="myplexus-login-page sip-calc-login">
    <div class="login-page">
        <div class="container">
            <div class="login-block bg-gry br-5 box-shadow">
                <div class="login-wrap">
                    <div class="col-lg-6 col-md-6 col-sm-12 m-auto sip-calc-wrapper">
                        <h3>Please Login First To Get Your Result</h3>
                        <div class="sip-calc-loginin-wrap">

                            <div class="sip-calc-social-login">
                                <h6>Log in with</h6>
                                <ul>
                                    <li><a href="{{ route('web.calculators.social.login','google') }}"><x-img src="{{asset('themes/frontend/assets/images/gmail-login-img.jpg')}}" /></a></li>
                                    <li><a href="{{ route('web.calculators.social.login','facebook') }}"><x-img src="{{asset('themes/frontend/assets/images/facebook-login-img.jpg')}}" /></a></li>
                                </ul>
                                <h6>OR</h6>
                            </div>

                            <form action="{{ route('web.calculators') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="login-field">
                                    <label>Enter your name</label>
                                    <input type="text" id="login_user" name="username" class="box-shadow" placeholder="John Doe" required />
                                </div>
                                <div class="password-field">
                                    <label>Enter your mail</label>
                                    <input type="email" id="login_pass" name="useremail" class="box-shadow" placeholder="Johndoe@mail.com" required />
                                </div>
                                <div class="log-other-opt">
                                    <div class="login-action-btn float-right">
                                        <input type="submit" value="Next" class="text-uppercase btn-bg-2 f-b text-white" />
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                            @if(session()->has('alert'))
                            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                            @endif
                            <div class="calculator-select-calc" style="display: none;">
                                <img src="../images/select-calc-bg-img.jpg" class="img-fluid">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@stop

<script>

document.addEventListener('DOMContentLoaded', function() {
  var monthlyTab1 = document.getElementById('pills-monthly-tab1');
	 var weeklyTab1 = document.getElementById('pills-weekly-tab1');
	var pillmonthlythree=document.getElementById('pills-monthly-tab3');
	var pillmonthlytwo=document.getElementById('pills-monthly-tab2');
	var pillmonthlyg=document.getElementById('pills-monthly-tab6');
	//var pillmonthlyg1=document.getElementById('pills-weekly7');
	
	
		

  if (monthlyTab1) {
    monthlyTab1.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = 'https://myplexus.com/calctest?cal=sip';
    });
  }
	
	  if (weeklyTab1) {
    weeklyTab1.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = 'https://myplexus.com/calctest?cal=lump';
    });
  }
	
	 //if (pillmonthlythree) {
    //pillmonthlythree.addEventListener('click', function(e) {
     // e.preventDefault();
     // window.location.href = 'https://new.myplexus.com/calctest?cal=retire';
    //});
  //}
	
	 if (pillmonthlytwo) {
    pillmonthlytwo.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = 'https://myplexus.com/calctest?cal=inflation';
    });
  }
	if (pillmonthlyg) {
    pillmonthlyg.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = 'https://myplexus.com/calctest?cal=pills-goal1';
    });
  }
	
	
	  var urlParams = new URLSearchParams(window.location.search);

            // Get a specific parameter by name
            var cal = urlParams.get('cal');

            if (cal === "risk") {
                var tabButtons = document.querySelectorAll('.tab_snap_shot button');
                tabButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                var riskTab = document.getElementById('pills-monthly-tab4');
                riskTab.classList.add('active');

                var tabPanes = document.querySelectorAll('.tab-pane');
                tabPanes.forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });

                var riskPane = document.getElementById('risk-tol-eval');
                riskPane.classList.add('active', 'show');
            }
	
	
});</script>