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
          <div class="col-lg-5 col-md-6 col-sm-12 m-auto login-main-box">
            {!! $dataArr['descp'] !!}
            <form action="{{ route('web.forgot.password.sendcode') }}" name="fgtPassFrm" id="fgtPassFrm" method="post">
              {{ csrf_field() }}
              <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />

              <div class="login-field">
                <label>{{ __('common.email_txt') }}</label>
                <x-form.field.text2 type="email" id="email" name="email" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.email_txt') }}" value="{{ old('email') }}" />
              </div>

              <div class="log-other-opt">
                <div class="login-action-btn float-right">
                  <x-form.field.button3 class="text-uppercase btn-bg-2 f-b text-white" type="button" id="sendFgtPassFrm" name="sendFgtPassFrm" text="{{ $defDataArr['web_lang']['send_code_txt'] }}" />
                </div>
                <div class="clear"></div>
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
    $("#fgtPassFrm").validate({
        rules: {
          email: {
            required: true,
            email: true
          }
        },
        messages: {
          email: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
            email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
          }
        }
      }),
      $("#sendFgtPassFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'forgot_password_form'
          }).then(function(token) {
            var a = $("#fgtPassFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  email: $("#email").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "{{ route('web.forgot.password.sendcode') }}",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendFgtPassFrm').prop('disabled', true);
                    $("#sendFgtPassFrm").text("{{ $defDataArr['web_lang']['processing_txt'] }}");
                  },
                  success: function(data) {
                    // console.log(data);
                    // alert(data['msg']);
                    $('#sendFgtPassFrm').prop('disabled', false);
                    $("#sendFgtPassFrm").text("{{ $defDataArr['web_lang']['send_code_txt'] }}");
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