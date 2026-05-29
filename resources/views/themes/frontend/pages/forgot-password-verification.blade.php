@extends('web.layout.app')
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
@push('style')
<style>
  .custom-banner {
    background-image: url('{{ $dataArr['image_path'] }}');
  }
</style>
@endpush
@endif
@push('style')
<style>
  .forgot-flow {
    position: relative;
    overflow: hidden;
    padding: 82px 0 96px;
    background:
      radial-gradient(circle at left top, rgba(74, 171, 111, 0.18), transparent 28%),
      radial-gradient(circle at right bottom, rgba(26, 66, 48, 0.14), transparent 26%),
      linear-gradient(180deg, #f8fcfa 0%, #edf6f0 100%);
  }
  .forgot-flow::before,
  .forgot-flow::after {
    content: "";
    position: absolute;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(74, 171, 111, 0.08);
    filter: blur(10px);
    z-index: 0;
  }
  .forgot-flow::before {
    top: -120px;
    right: -70px;
  }
  .forgot-flow::after {
    left: -100px;
    bottom: -140px;
  }
  .forgot-shell {
    position: relative;
    z-index: 1;
    max-width: 920px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(35, 98, 68, 0.10);
    border-radius: 34px;
    overflow: hidden;
    box-shadow: 0 32px 90px rgba(21, 57, 39, 0.12);
    backdrop-filter: blur(10px);
  }
  .forgot-panel {
    padding: 44px 44px 40px;
  }
  .forgot-panel__intro {
    max-width: 520px;
    margin-bottom: 26px;
  }
  .forgot-panel__intro h2 {
    margin: 0 0 10px;
    color: #16362a;
    font-size: 28px;
    line-height: 1.2;
    font-weight: 700;
  }
  .forgot-panel__intro p,
  .forgot-rich-text {
    margin: 0;
    color: #5a6d63;
    font-size: 15px;
    line-height: 1.85;
  }
  .forgot-rich-text {
    margin-bottom: 24px;
  }
  .forgot-form-box {
    max-width: 100%;
    padding: 28px;
    border-radius: 24px;
    background: linear-gradient(180deg, #ffffff 0%, #f7fbf8 100%);
    border: 1px solid #dfebe3;
  }
  .forgot-help-box {
    margin-bottom: 22px;
    padding: 22px 22px 18px;
    border-radius: 22px;
    background: linear-gradient(135deg, #183c2f 0%, #2f8158 100%);
    color: #fff;
    box-shadow: 0 18px 40px rgba(24, 60, 47, 0.18);
  }
  .forgot-help-box__tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.14);
    color: #d7f5e1;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
  }
  .forgot-help-box__tag::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #9cf0bb;
  }
  .forgot-help-box h3 {
    margin: 16px 0 10px;
    color: #fff;
    font-size: 25px;
    line-height: 1.2;
    font-weight: 700;
  }
  .forgot-help-box p {
    margin: 0;
    color: rgba(255, 255, 255, 0.84);
    font-size: 14px;
    line-height: 1.8;
  }
  .forgot-help-steps {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin-top: 18px;
  }
  .forgot-help-step {
    min-height: 100%;
    padding: 14px 14px 12px;
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.10);
    border: 1px solid rgba(255, 255, 255, 0.08);
  }
  .forgot-help-step.is-active {
    background: rgba(255, 255, 255, 0.18);
    border-color: rgba(255, 255, 255, 0.22);
  }
  .forgot-help-step span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    margin-bottom: 10px;
    border-radius: 50%;
    background: #fff;
    color: #246d48;
    font-size: 12px;
    font-weight: 700;
  }
  .forgot-help-step strong {
    display: block;
    margin-bottom: 4px;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
  }
  .forgot-help-step p {
    font-size: 12px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.76);
  }
  .forgot-label {
    display: block;
    margin-bottom: 10px;
    color: #2d5140;
    font-size: 13px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-weight: 700;
  }
  .forgot-input {
    margin-bottom: 18px;
  }
  .forgot-input input {
    width: 100%;
    height: 62px;
    border-radius: 18px;
    border: 1px solid #d1e3d8;
    background: #fff;
    padding: 0 18px;
    font-size: 16px;
    color: #17362a;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8) !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .forgot-input input:focus {
    outline: none;
    border-color: #359762;
    box-shadow: 0 0 0 4px rgba(53, 151, 98, 0.10) !important;
  }
  .forgot-note {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 18px;
    padding: 16px 18px;
    border-radius: 18px;
    background: #eef8f1;
    color: #436555;
    font-size: 14px;
    line-height: 1.7;
  }
  .forgot-note::before {
    content: "i";
    flex: 0 0 24px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #2f8c5b;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
  }
  .forgot-action button,
  .forgot-action .btn {
    width: 100%;
    min-height: 60px;
    border: 0;
    border-radius: 999px;
    padding: 16px 22px;
    background: linear-gradient(135deg, #173f31 0%, #379962 100%);
    color: #fff !important;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    box-shadow: 0 18px 36px rgba(55, 153, 98, 0.24);
  }
  .forgot-message {
    margin-top: 18px;
  }
  .forgot-footer {
    margin-top: 24px;
    color: #677a70;
    font-size: 15px;
  }
  .forgot-footer a {
    color: #20754a;
    font-weight: 700;
    text-decoration: none;
  }
  @media only screen and (max-width: 991px) {
    .forgot-panel {
      padding: 34px 26px;
    }
  }
  @media only screen and (max-width: 575px) {
    .forgot-flow {
      padding: 38px 0 54px;
    }
    .forgot-panel {
      padding: 28px 18px;
    }
    .forgot-form-box {
      padding: 20px 16px;
      border-radius: 20px;
    }
    .forgot-help-box {
      padding: 18px 16px 16px;
    }
    .forgot-help-box h3 {
      font-size: 22px;
    }
    .forgot-help-steps {
      grid-template-columns: 1fr;
    }
    .forgot-panel__intro h2 {
      font-size: 24px;
    }
  }
</style>
@endpush
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<div class="forgot-flow">
  <div class="container">
    <div class="forgot-shell">
      <div class="forgot-panel">
        <div class="forgot-panel__intro">
          <h2>Verify Your Code</h2>
          <p>Enter the six-digit verification code from your email to continue to the password reset screen.</p>
        </div>

        @if(!empty(trim(strip_tags($dataArr['descp'] ?? ''))))
          <div class="forgot-rich-text">{!! $dataArr['descp'] !!}</div>
        @endif

        <div class="forgot-form-box">
          <div class="forgot-help-box">
            <span class="forgot-help-box__tag">Password Help</span>
            <h3>Recover your account in three quick steps.</h3>
            <p>We will guide you from email verification to setting a fresh password without losing access to your account.</p>
            <div class="forgot-help-steps">
              <div class="forgot-help-step">
                <span>1</span>
                <strong>Share email</strong>
                <p>Tell us which account needs the reset code.</p>
              </div>
              <div class="forgot-help-step is-active">
                <span>2</span>
                <strong>Verify code</strong>
                <p>Confirm the code we send to your inbox.</p>
              </div>
              <div class="forgot-help-step">
                <span>3</span>
                <strong>Set password</strong>
                <p>Choose a secure new password and sign in.</p>
              </div>
            </div>
          </div>

          <div class="forgot-note">
            If the code has not arrived yet, go back and request a fresh one for the same email address.
          </div>

          <form action="{{ route('web.forgot.password.verification.codecheck') }}" name="fgtPassVrfyFrm" id="fgtPassVrfyFrm" method="post">
            {{ csrf_field() }}
            <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />

            <div class="forgot-input">
              <label class="forgot-label">{{ __('auth.verification_code_txt') }}</label>
              <x-form.field.text2 id="forget_code" name="forget_code" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.verification_code_txt') }}" value="{{ old('forget_code') }}" />
            </div>

            <div class="forgot-action">
              <x-form.field.button3 class="text-uppercase btn-bg-2 f-b text-white" type="button" id="sendFgtPassVrfyFrm" name="sendFgtPassVrfyFrm" text="{{ $defDataArr['web_lang']['verify_code_txt'] }}" />
            </div>
          </form>

          <div id="msg_id" class="forgot-message"></div>
        </div>

        <div class="forgot-footer">
          <span>Need a new code?</span>
          <x-link url="{{ route('web.forgot.password') }}">Go back</x-link>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@push('scripts')
<script>
  function runForgotRecaptcha(actionName, callback) {
    if (typeof grecaptcha === 'undefined' || typeof grecaptcha.ready !== 'function') {
      callback('local-bypass');
      return;
    }

    grecaptcha.ready(function() {
      grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
        action: actionName
      }).then(function(token) {
        callback(token || 'local-bypass');
      });
    });
  }

  $(function() {
    $("#fgtPassVrfyFrm").validate({
        rules: {
          forget_code: {
            required: true,
            number: true,
            minlength: 6,
            maxlength: 6
          }
        },
        messages: {
          forget_code: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('auth.verification_code_txt')) }}",
            number: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('auth.verification_code_txt')) }}"
          }
        }
      }),
      $("#sendFgtPassVrfyFrm").click(function(e) {
        e.preventDefault();
        runForgotRecaptcha('forgot_password_verification_form', function(token) {
          var a = $("#fgtPassVrfyFrm");
          if (1 == a.valid()) {
            $("#recaptcha_v3").val(token);
            var formData = {
              "_token": $('meta[name="csrf-token"]').attr('content'),
              forget_code: $("#forget_code").val(),
              recaptcha_v3: $("#recaptcha_v3").val()
            };
            $.ajax({
              url: "{{ route('web.forgot.password.verification.codecheck') }}",
              type: "post",
              data: formData,
              dataType: 'json',
              beforeSend: function() {
                $('#sendFgtPassVrfyFrm').prop('disabled', true);
                $("#sendFgtPassVrfyFrm").text("{{ $defDataArr['web_lang']['processing_txt'] }}");
              },
              success: function(data) {
                $('#sendFgtPassVrfyFrm').prop('disabled', false);
                $("#sendFgtPassVrfyFrm").text("{{ $defDataArr['web_lang']['verify_code_txt'] }}");
                $("#msg_id").html(data['msg']);
                if (data['url'] != '') {
                  window.location.href = data['url'];
                }
              },
              error: function() {
                $('#sendFgtPassVrfyFrm').prop('disabled', false);
                $("#sendFgtPassVrfyFrm").text("{{ $defDataArr['web_lang']['verify_code_txt'] }}");
                $("#msg_id").html('There is error while submit');
              }
            });
          }
        });
      });
  });
</script>
@endpush
