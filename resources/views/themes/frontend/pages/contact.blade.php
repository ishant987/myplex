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
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@if( isset($dataArr['custom_fields']['image_16']))
@push('styles')
<style>
  .custom-banner {
    background-image: url('{{ $defDataArr['media_folder'].$dataArr['custom_fields']['image_16']['value'] }}');
  }
</style>
@endpush
@endif
@section('content')
<div class="custom-banner no-bg">
  <div class="container">
    @if(isset($dataArr['custom_fields']['textarea_17']))
    <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_17']['value']) !!}</h1>
    @endif
  </div>
</div>

<div class="connect-us-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-12 c-lft">
        @if(isset($dataArr['custom_fields']['textarea_18']))
        <h3 class="m-b-30">{!! nl2br($dataArr['custom_fields']['textarea_18']['value']) !!}</h3>
        @endif
        @if(isset($dataArr['image_path']))
        <x-img src="{{ $dataArr['image_path'] }}" class="img-fluid" />
        @endif
        <div class="contact-address m-t-30">
          <div class="c-block c-block-1">
            @if(isset($dataArr['custom_fields']['text_19']))
            <h6 class="text-green">{{ $dataArr['custom_fields']['text_19']['value'] }}</h6>
            @endif
            <div class="c-address">
              @if(isset($dataArr['custom_fields']['textarea_20']))
              {!! nl2br($dataArr['custom_fields']['textarea_20']['value']) !!}
              @endif
            </div>
            <div class="c-details">
              @if(isset($dataArr['custom_fields']['text_21']) || isset($dataArr['custom_fields']['text_22']))
              <ul>
                @if(isset($dataArr['custom_fields']['text_21']))
                <li>
                  <p>
                    <x-img src="{{asset('themes/frontend/assets/images/call-icon-2.png')}}" alt="call icon" /> {{ $dataArr['custom_fields']['text_21']['value'] }}
                  </p>
                </li>
                @endif
                @if(isset($dataArr['custom_fields']['text_22']))
                <li>
                  <p>
                    <x-link url="mailto:{{ $dataArr['custom_fields']['text_22']['value'] }}">
                      <x-img src="{{asset('themes/frontend/assets/images/web-icon-2.png')}}" alt="web icon" /> {{ $dataArr['custom_fields']['text_22']['value'] }}
                    </x-link>
                  </p>
                </li>
                @endif
              </ul>
              @endif
            </div>
          </div>
          <div class="c-block c-block-2">
            @if(isset($dataArr['custom_fields']['text_23']))
            <h6 class="text-green">{{ $dataArr['custom_fields']['text_23']['value'] }}</h6>
            @endif
            <div class="c-address">
              @if(isset($dataArr['custom_fields']['textarea_24']))
              {!! nl2br($dataArr['custom_fields']['textarea_24']['value']) !!}
              @endif
            </div>
            <div class="c-details">
              @if(isset($dataArr['custom_fields']['text_25']) || isset($dataArr['custom_fields']['text_26']))
              <ul>
                @if(isset($dataArr['custom_fields']['text_25']))
                <li>
                  <p>
                    <x-img src="{{asset('themes/frontend/assets/images/call-icon-2.png')}}" alt="call icon" /> {{ $dataArr['custom_fields']['text_25']['value'] }}
                  </p>
                </li>
                @endif
                @if(isset($dataArr['custom_fields']['text_26']))
                <li>
                  <p>
                    <x-link url="mailto:{{ $dataArr['custom_fields']['text_26']['value'] }}">
                      <x-img src="{{asset('themes/frontend/assets/images/web-icon-2.png')}}" alt="web icon" /> {{ $dataArr['custom_fields']['text_26']['value'] }}
                    </x-link>
                  </p>
                </li>
                @endif
              </ul>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-12 c-rgt">
        @if(isset($dataArr['custom_fields']['textarea_27']))
        <h3 class="text-green m-b-30">{!! nl2br($dataArr['custom_fields']['textarea_27']['value']) !!}</h3>
        @endif
        <div class="contact-form m-t-30">
          {!! $dataArr['descp'] !!}
          <form action="{{ route('web.contact.save') }}" name="cntctFrm" id="cntctFrm" method="post">
            {{ csrf_field() }}
            <x-form.field.hidden name="recaptcha_v3" id="recaptcha_v3" />

            <x-form.group_lyt3 label="{{ __('contact.name_txt') }}" for="name" error="{{ $errors->first('name') }}">
              <x-form.field.text id="name" name="name" placeholder="{{ __('contact.placeholder.name_txt') }}" value="{{ \Auth::check() ? \Auth::user()->f_name.' '.\Auth::user()->l_name : old('name') }}" />
            </x-form.group_lyt3>

            <x-form.group_lyt3 label="{{ __('contact.email_txt') }}" for="email" error="{{ $errors->first('email') }}">
              <x-form.field.text type="email" id="email" name="email" placeholder="{{ __('contact.placeholder.email_txt') }}" value="{{ \Auth::check() ? \Auth::user()->email : old('email') }}" />
            </x-form.group_lyt3>

            <x-form.group_lyt3 label="{{ __('contact.mobile_txt') }}" for="mobile" error="{{ $errors->first('mobile') }}">
              <x-form.field.text type="tel" id="mobile" name="mobile" placeholder="{{ __('contact.placeholder.mobile_txt') }}" value="{{ \Auth::check() ? \Auth::user()->mobile : old('mobile') }}" />
            </x-form.group_lyt3>

            <x-form.group_lyt3 label="{{ __('contact.message_txt') }}" for="message" error="{{ $errors->first('message') }}" required="true">
              <x-form.field.textarea id="message" name="message" rows="2" placeholder="{{ __('contact.placeholder.message_txt') }}" value="{!! old('message') !!}" />
            </x-form.group_lyt3>

            <div class="form-field-row">
              <div class="form-field text-right">
                <x-form.field.button3 type="button" id="sendCntctFrm" name="sendCntctFrm" text="{{ $defDataArr['web_lang']['submit_query_txt'] }}" />
              </div>
            </div>
          </form>
          <div id="msg_id"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="connect-gmap">
  <div class="container">
    @if(isset($dataArr['custom_fields']['textarea_28']))
    <div class="gmap-wrap box-shadow">
      {!! nl2br($dataArr['custom_fields']['textarea_28']['value']) !!}
    </div>
    @endif
  </div>
</div>
@stop
@push('scripts')
<script>
  $(function() {
    $("#cntctFrm").validate({
        rules: {
          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          mobile: {
            required: false,
            number: true
          },
          message: {
            required: true
          }
        },
        messages: {
          name: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('contact.name_txt')) }}",
          email: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('contact.email_txt')) }}",
            email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('contact.email_txt')) }}"
          },
          mobile: {
            number: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.mobile_txt')) }}"
          },
          message: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('contact.message_txt')) }}"
        }
      }),
      $("#sendCntctFrm").click(function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute("{{ Config('commonconstants.recaptcha.site_key') }}", {
            action: 'contact_form'
          }).then(function(token) {
            var a = $("#cntctFrm");
            if (1 == a.valid()) {
              if (token) {
                $("#recaptcha_v3").val(token);
                // alert($("#recaptcha_v3").val());
                var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  name: $("#name").val(),
                  email: $("#email").val(),
                  mobile: $("#mobile").val(),
                  message: $("#message").val(),
                  recaptcha_v3: $("#recaptcha_v3").val()
                };
                $.ajax({
                  url: "{{ route('web.contact.save') }}",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#sendCntctFrm').prop('disabled', true);
                    $("#sendCntctFrm").text("{{ $defDataArr['web_lang']['processing_txt'] }}");
                  },
                  success: function(data) {
                    console.log(data);
                    // alert(data['msg']);
                    $('#sendCntctFrm').prop('disabled', false);
                    $("#sendCntctFrm").text("{{ $defDataArr['web_lang']['submit_query_txt'] }}");
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    console.log(e);
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