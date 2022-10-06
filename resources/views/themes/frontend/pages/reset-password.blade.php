@extends('themes.frontend.layouts.app')
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
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4 col-lg-3 col-12">
			@include('themes.frontend.includes.user-left-nav')
		</div>
		<!-- -->
		<div class="col-md-8 col-lg-9 col-12"> 
			<div class="content-form bg-lightblue">
				<div class="">
					<p class="lead">{!! $dataArr['title'] !!}</p>
				</div>
				<form action="{{ route('web.reset.password.save') }}" method="post" id="resetPasswordForm">
					{{ csrf_field() }}

					<x-form.group_lyt4 label="{{ __('subscribeduser.cr_password_txt') }}" for="current_password" error="{{ $errors->first('current_password') }}" required="true">
						<x-form.field.text type="password" id="current_password" name="current_password" value="" />
					</x-form.group_lyt4>

					<x-form.group_lyt4 label="{{ __('subscribeduser.n_password_txt') }}" for="new_password" error="{{ $errors->first('new_password') }}" info="{{ __('subscribeduser.info.pwd_len_txt') }}" required="true">
						<x-form.field.text type="password" id="new_password" name="new_password" value="" />
					</x-form.group_lyt4>

					<x-form.group_lyt4 label="{{ __('common.c_password_txt') }}" for="new_password_confirmation" error="{{ $errors->first('new_password_confirmation') }}" required="true">
						<x-form.field.text type="password" id="new_password_confirmation" name="new_password_confirmation" value="" />
					</x-form.group_lyt4>

					<div class="form-group row justify-content-center space-p-top">
						<div class="col-md-auto col-6 text-center">
							<x-form.field.button3 id="send" name="send" type="submit" class="btn btn-primary" text="{{ $defDataArr['web_lang']['reset_now_txt'] }}"/>
						</div>
						<!-- /.col-auto -->
					</div>
					<!-- /.form-group -->

			        {{-- Alert message start --}}
			        @if(session()->has('alert'))
			        <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
			        @endif
			        {{-- Alert message end --}}
				</form>
			</div>
			<!-- /.content-form --> 
		</div>
		<!-- --> 
	</div>
	<!-- /.row --> 
</div>
<!-- /.container -->
@stop
@push('scripts')
<script>
	$(function() {
		$("#resetPasswordForm").validate({
			rules: {
				current_password: {
					required: true,
				},
				new_password: {
					required: true,
					minlength: 6
				},
				new_password_confirmation : {
					required: true,
					equalTo : "#new_password"
				}
			},
			messages: {
				current_password: {
					required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.cr_password_txt')) }}",
				},
				new_password: {
					required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.n_password_txt')) }}",
					minlength: "{{ strtolower(__('subscribeduser.info.pwd_len_txt')) }}",
				},
				new_password_confirmation: {
					required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.c_password_txt')) }}",
					equalTo: "{{ __('front.validation.confirm_password_txt') }}"
				}
			}
		})
	});
</script>
@endpush