@extends('web.layout.app')
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
@if (isset($dataArr['image_path']))
                @section('meta-image'){{ $dataArr['image_path'] }}@stop
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
            <form action="{{ route('web.investor-signup.save') }}" name="investorsignupFrm" id="investorsignupFrm" method="post">
              {{ csrf_field() }}             

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('First Name') }}</label>
                  <x-form.field.text2 id="f_name" name="f_name" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.f_name_txt') }}" value="{{ old('f_name') }}" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('Last Name') }}</label>
                  <x-form.field.text2 id="l_name" name="l_name" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.l_name_txt') }}" value="{{ old('l_name') }}" />
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('common.email_txt') }}</label>
                  <x-form.field.text2 type="email" id="email" name="email" class="box-shadow" placeholder="{{ __('subscribeduser.placeholder.email_txt') }}" value="{{ old('email') }}" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label>{{ __('I am an') }}</label>
                 <select id="user_type" name="user_type" class="box-shadow">
					 <option value="">Select an option</option>
					 <option value="Advisor">Advisor</option>
					 <option value="Fund House Representative">Fund House Representative</option>
					 <option value="Investor">Investor</option>
					</select>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
			<input type="checkbox" name="is_contacted_with_team" id="is_contacted_with_team" value="No" class="form-controll box-shadow w-auto" />
                  {{ __('I want to be contacted by MyPlexus Team') }}                  
                </div>               
              </div>

              <div class="row register-analysis-bottom">
                <div class="col-lg-12 col-md-12 col-sm-12 text-right register-action">
					<button type="button" id="sendInvestorSignupFrm" class="btn form-submit btn-bg-2 text-white text-uppercase" >Submit</button>
					                
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
	
$('#is_contacted_with_team').on('click', (e) => {
	
	if( $('#is_contacted_with_team').is(':checked') )
	{
		$('#is_contacted_with_team').val('Yes');
	} else {	
		$('#is_contacted_with_team').val('No');		
	}
});
	
	
  $(function() {
    $("#investorsignupFrm").validate({
        rules: {
          f_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          user_type: {
            required: true
          }
        },
        messages: {
          f_name: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt')) }}",
          email: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
            email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
          },
          user_type: {
            required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('select an option')) }}"
          }
        }
      }),
      $("#sendInvestorSignupFrm").click(function(e) {
        e.preventDefault();
		
		var formData = {
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                  f_name: $("#f_name").val(),
                  l_name: $("#l_name").val(),
                  email: $("#email").val(),
                  user_type: $("#user_type").val(),
                  is_contacted_with_team: $("#is_contacted_with_team").val()
                };
		
		 $.ajax({
                  url: "{{ route('web.investor-signup.save') }}",
                  type: "post",
                  data: formData,
                  dataType: 'json',
                  beforeSend: function() {
                    $('#investorsendSignupFrm').prop('disabled', true);
                    $("#investorsendSignupFrm").text("{{ $defDataArr['web_lang']['processing_txt'] }}");
                  },
                  success: function(data) {
                    // console.log(data);
                    // alert(data['msg']);
                    $('#investorsendSignupFrm').prop('disabled', false);
                    $("#investorsendSignupFrm").text("{{ $defDataArr['web_lang']['register_txt'] }}");
                    $("#msg_id").html(data['msg']);
                    if (data['url'] != '') {
						
						//console.log(data['url'];);
						
                      window.location.href = data['url'];
                    }
                  },
                  error: function(e) {
                    // console.log(e);
                    $("#msg_id").html('There is error while submit');
                  }
                });		
        
      	});
  });
</script>
@endpush