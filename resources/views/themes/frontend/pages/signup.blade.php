@extends('themes.frontend.layouts.app')
@section('captcha') @stop
@section('jquery-validate') @stop
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
@push('styles')
<style>
  .custom-banner {
    background-image: url('{{ $dataArr['image_path'] }}');
  }
</style>
@endpush
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<div class="custom-banner no-bg analysis-login-banner">
  <div class="container">
    @if(isset($dataArr['custom_fields']['textarea_29']))
    <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
    @endif
  </div>
</div>

<div class="myplexus-login-page">
  <div class="login-page">
    <div class="container">
      <div class="login-block bg-gry br-5 box-shadow">
        <div class="login-wrap">
          <div class="col-lg-9 col-md-9 col-sm-12 m-auto analysis-login-main-box">
            {!! $dataArr['descp'] !!}
            <form action="{{ route('web.signup.save') }}" name="signupFrm" id="signupFrm" method="post">
              {{ csrf_field() }}
              <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('common.f_name_txt') }}</label>
                  <x-form.field.text2 id="f_name" name="f_name" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.f_name_txt') }}" value="{{ old('f_name') }}" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('common.l_name_txt') }}</label>
                  <x-form.field.text2 id="l_name" name="l_name" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.l_name_txt') }}" value="{{ old('l_name') }}" />
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('common.email_txt') }}</label>
                  <x-form.field.text2 type="email" id="email" name="email" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.email_txt') }}" value="{{ old('email') }}" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('common.mobile_txt') }}</label>
                  <x-form.field.text2 type="tel" id="mobile" name="mobile" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.mobile_txt') }}" value="{{ old('mobile') }}" />
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('subscribeduser.company_txt') }}</label>
                  <x-form.field.text2 id="company" name="company" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.company_txt') }}" value="{{ old('company') }}" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('subscribeduser.pincode_txt') }}</label>
                  <x-form.field.text2 id="pincode" name="pincode" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.pincode_txt') }}" value="{{ old('pincode') }}" />
                </div>
              </div>

              <div class="row register-analysis-bottom">
                <div class="col-lg-12 col-md-12 col-sm-12 text-right register-action">
                  <label>&nbsp;</label>
                  <x-form.field.button3 class="form-submit btn-bg-2 text-white text-uppercase" type="button" id="sendSignupFrm" name="sendSignupFrm" text="{{ $defDataArr['web_lang']['register_txt'] }}" />
                </div>
              </div>
            </form>
            <div id="msg_id"></div>
            <div class="no-account-wrap">
              <div class="no-account-container">
                <div class="no-acount-message">
                  <span class="text-green">{{ __('auth.sign_in_prfx_txt') }}</span>
                </div>
                <div class="creat-account-message">
                  <x-link url="{{ route('web.login') }}">{{ __('auth.sign_in2_txt') }}</x-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@push('scripts')
<script>
  $(function() {
    $("#signupFrm").validate({
        rules: {
          f_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          mobile: {
            required: true,
            number: true
          },
          pincode: {
            required: true,
            number: true
          }
        },
        messages: {
          f_name: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt')) }}",
          email: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
            email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
          },
          mobile: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.mobile_txt')) }}",
            number: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.mobile_txt')) }}"
          },
          pincode: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.pincode_txt')) }}",
            number: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.pincode_txt')) }}"
          }
        }
      }),
      $("#sendSignupFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'signup_form'
          }).then(function(token) {
            var a = $("#signupFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  f_name: $("#f_name").val(),
                  l_name: $("#l_name").val(),
                  email: $("#email").val(),
                  mobile: $("#mobile").val(),
                  company: $("#company").val(),
                  pincode: $("#pincode").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "{{ route('web.signup.save') }}",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendSignupFrm').prop('disabled', true);
                    $("#sendSignupFrm").text("{{ $defDataArr['web_lang']['processing_txt'] }}");
                  },
                  success: function(data) {
                    // console.log(data);
                    // alert(data['msg']);
                    $('#sendSignupFrm').prop('disabled', false);
                    $("#sendSignupFrm").text("{{ $defDataArr['web_lang']['register_txt'] }}");
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    // console.log(e);
                    $("#msg_id").html('There is error while submit');
                  }
                });
              }
            }
          });
        });
      });
  });
</script>
@endpush