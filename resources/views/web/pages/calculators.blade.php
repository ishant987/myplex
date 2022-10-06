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
<div id="vue-app">
    <calculators image_path="{{asset('themes/frontend/assets/v1/img/')}}" sip_faqs="" sip_pdf_url="{{ isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:'' }}" username="{{ session()->get('username') }}" useremail="{{ session()->get('useremail') }}"></calculators>
</div>
{{-- @if(session()->has('username') && session()->has('useremail') )
<div id="vue-app">
    <calculators image_path="{{asset('themes/frontend/assets/v1/img/')}}" sip_faqs="" sip_pdf_url="{{ isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:'' }}" username="{{ session()->get('username') }}" useremail="{{ session()->get('useremail') }}"></calculators>
</div>
@else
<div class="myplexus-login-page sip-calc-login">
    <div class="login-page">
        <div class="container">
            <div class="login-block bg-gry br-5 box-shadow">
                <div class="login-wrap">
                    <div class="col-lg-5 col-md-6 col-sm-12 m-auto sip-calc-wrapper">
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
@endif --}}
@stop