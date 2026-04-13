@extends('themes.backend.layouts.app-no-header')
@section('commonPages') @stop
@section('menu') @stop
@section('themebg-pattern')themebg-pattern="theme1" @stop
@section('section-class')class="login-block" @stop
@section('content')
<form class="md-float-material form-material" method="POST" action="{{ route('admin.forgotpassword.post') }}">
    {{ csrf_field() }}
    <div class="company-name text-center">
        <!-- <h1>{{ config('app.name') }}</h1> -->
        <x-img src="{{asset('img/LOGO.png')}}" width="245" />
    </div>
    <div class="auth-box card">
        <div class="card-block">
            <div class="row m-b-20">
                <div class="col-md-12">
                    <h3 class="text-center">{{ __('auth.f_password_hdng_txt') }}</h3>
                </div>
            </div>

            <x-form.group_lyt2 label="{{ __('common.email_txt') }}" 
                  error="{{ $errors->first('email') }}" for="email">
                <x-form.field.text type="email" name="email" id="email" value="{{ old('email') }}" required="true" />
            </x-form.group_lyt2>

            <div class="row m-t-25 text-left">
                <div class="col-12">
                    <div class="text-right f-right">
                        <x-link url="{{ route('admin.login') }}" class="text-right f-w-600">
                            {{ __('auth.f_password_sign_in_txt') }}
                        </x-link>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <x-form.field.button2 id="f_pass" name="f_pass" class="m-b-20" text="{{ __('auth.f_password_txt') }}" />

                    {{-- Alert message start --}}
                    @if(session()->has('alert'))
                        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                    @endif 
                    {{-- Alert message end --}}
                    
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-10">
                    <p class="text-inverse text-left m-b-0">{{ __('auth.thank_you_txt') }}</p>
                    <p class="text-inverse text-left">
                        <x-link url="/" class="f-w-600">
                            {{ __('auth.bk_to_website_txt') }}
                        </x-link>
                    </p>
                </div>
                <div class="col-md-2">
                    <x-img src="{{asset('img/Favicon-small.png')}}" width="32" />
                </div>
            </div>
        </div>
    </div>
</form>
@stop