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
				<form action="{{ route('web.edit.profile.save') }}" method="post" id="profileForm" name="profileForm" enctype="multipart/form-data">
					{{ csrf_field() }}

					<div class="form-group row align-items-center{{ $errors->first('file')?' has-danger':'' }}">
						<label class="col-sm-auto col-md-4 col-lg-auto col-xl-2 mb-sm-0">
							@if($user->p_picture)
							<x-img src="{{ url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 110, 110, 100]) }}" alt="{{ $user->f_name }} {{ $user->l_name }}" title="{{ $user->f_name }} {{ $user->l_name }}" id="preview_img" width="110" height="110" class="img-fluid" />
							<x-form.field.hidden name="hid_file_src" id="hid_file_src" value="{{ url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 110, 110, 100]) }}"></x-form.field.hidden>
							@else
							<x-img src="{{asset('themes/frontend/assets/images/profile-photo.png')}}" id="preview_img" width="110" height="110" class="img-fluid" />
							@endif
						</label>
						<div class="col-sm-4 col-md-8 col-lg-5 col-xl-10">
							<div class="custom-file">
								<input type="file" class="custom-file-input remove-file" id="file" name="file">
								<label class="custom-file-label" id="label_file" for="file">{{ __('subscribeduser.upload_photo_txt') }}</label>
								<small class="form-text text-muted">{!! __('subscribeduser.info.image') !!}</small>
								<a class="red-text hide remove" id="removeFile" href="JavaScript:void(0);">{{ $defDataArr['web_lang']['remove_attachment_txt'] }}</a>
							</div>
							<!-- /.custom-file -->
						</div>
						<!--  -->
					</div>
					<!-- /.form-group -->

					<div class="form-group row align-items-center">
						<x-form.group_lyt6 label="{{ __('common.f_name_txt') }}" for="f_name" error="{{ $errors->first('f_name') }}" required="true">
							<x-form.field.text id="f_name" name="f_name" value="{{ (old('f_name'))?old('f_name'):$user->f_name }}" />
						</x-form.group_lyt6>

						<x-form.group_lyt6 label="{{ __('common.l_name_txt') }}" for="l_name" error="{{ $errors->first('l_name') }}" required="false">
							<x-form.field.text id="l_name" name="l_name" value="{{ (old('l_name'))?old('l_name'):$user->l_name }}" />
						</x-form.group_lyt6>

						<x-form.group_lyt6 label="{{ __('common.email_txt') }}" for="email" error="{{ $errors->first('email') }}" required="true">
							<x-form.field.text id="email" name="email" value="{{ (old('email'))?old('email'):$user->email }}" />
						</x-form.group_lyt6>

						<x-form.group_lyt6 label="{{ __('subscribeduser.mobile_txt') }}" for="mobile" error="{{ $errors->first('mobile') }}" required="true">
							<x-form.field.text id="mobile" name="mobile" value="{{ (old('mobile'))?old('mobile'):$user->mobile }}" />
						</x-form.group_lyt6>

						<x-form.group_lyt6 label="{{ __('subscribeduser.brthdy_txt') }}">
							<div class="input-group">
								<select name="birthday_year" id="birthday_year" class="custom-select placeholder">
									<option value="">{{ __('subscribeduser.brthdy_year_def_opt_txt') }}</option>
									@if(!empty($yearArr))
									@foreach ($yearArr as $yValue)
									<option value="{{ $yValue }}" @if( $yValue==old('birthday_year') ) {{ 'selected' }} @elseif( $yValue==$birthdayArr[0] ) {{ 'selected' }} @endif>{{ $yValue }}</option>
									@endforeach
									@endif
								</select>
								<select name="birthday_month" id="birthday_month" class="custom-select placeholder">
									<option value="">{{ __('subscribeduser.brthdy_month_def_opt_txt') }}</option>
									@if(!empty($monthsArr))
									@foreach ($monthsArr as $key => $mValue)
									<option value="{{ $key }}" @if( $key==old('birthday_month') ) {{ 'selected' }} @elseif( $key==$birthdayArr[1] ) {{ 'selected' }} @endif>{{ $mValue }}</option>
									@endforeach
									@endif
								</select>
								<select name="birthday_day" id="birthday_day" class="custom-select placeholder">
									<option value="">{{ __('subscribeduser.brthdy_day_def_opt_txt') }}</option>
									@if(!empty($daysArr))
									@foreach ($daysArr as $value)
									<option value="{{ $value }}" @if( $value==old('birthday_day') ) {{ 'selected' }} @elseif( $value==$birthdayArr[2] ) {{ 'selected' }} @endif>{{ $value }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</x-form.group_lyt6>

						<x-form.group_lyt6 label="{{ __('subscribeduser.neet_aprng_yr_txt') }}" for="neet_appearing_year" error="{{ $errors->first('neet_appearing_year') }}" required="true">
							<select name="neet_appearing_year" id="neet_appearing_year" class="custom-select placeholder">
								<option value="">{{ $defDataArr['web_lang']['def_drop_optn_txt'] }}</option>
								@if(!empty($nayArr))
								@foreach ($nayArr as $nyValue)
								<option value="{{ $nyValue }}" @if( $nyValue==old('neet_appearing_year') ) {{ 'selected' }} @elseif( $nyValue==$user->neet_apear_year ) {{ 'selected' }} @endif>{{ $nyValue }}</option>
								@endforeach
								@endif
							</select>
						</x-form.group_lyt6>

						<x-form.group_lyt6 label="{{ __('subscribeduser.class_txt') }}" for="class" error="{{ $errors->first('class') }}" required="true">
							<select name="class" id="class" class="custom-select placeholder">
								<option value="">{{ $defDataArr['web_lang']['def_drop_optn_txt'] }}</option>
								@if(!empty($defDataArr['user_class_type']))
								@foreach ($defDataArr['user_class_type']['value'] as $key => $class_type)
								<option value="{{ $class_type }}" @if( $class_type==old('class') ) {{ 'selected' }} @elseif( $class_type==$user->class ) {{ 'selected' }} @endif>{{ $defDataArr['user_class_type']['text'][$class_type] }}</option>
								@endforeach
								@endif
							</select>
						</x-form.group_lyt6>
					</div>
					<!-- -->

					<div class="form-group row justify-content-center space-p-top">
						<div class="col-md-auto col-6 text-center">
							<x-form.field.button3 id="send" name="send" type="submit" class="btn btn-primary" text="{{ $defDataArr['web_lang']['save_txt'] }}" />
						</div>
						<!-- /.col-auto -->
						<div class="col-md-auto col-6 text-center">
							<x-form.field.button3 type="reset" class="btn btn-primary" text="{{ $defDataArr['web_lang']['cancel_txt'] }}" />
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
		$("#profileForm").validate({
			rules: {
				file: {
					required: false,
					extension: "jpg|jpeg|png"
				},
				f_name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				mobile: {
					required: true,
					number: true,
					minlength: 10,
					maxlength: 10
				},
				neet_appearing_year: {
					required: true
				},
				class: {
					required: true
				}
			},
			messages: {
				file: {
					required: "{{ $defDataArr['web_lang']['please_txt'] }} {{ strtolower(__('subscribeduser.upload_photo_txt')) }}",
					extension: "{{ $defDataArr['web_lang']['jq_validate']['upload_extension_txt'] }}"
				},
				f_name: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt')) }}",
				email: {
					required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
					email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
				},
				mobile: {
					required: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('subscribeduser.mobile_txt')) }}",
					number: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt')) }}",
					minlength: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt')) }}",
					maxlength: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt')) }}"
				},
				neet_appearing_year: "{{ $defDataArr['web_lang']['jq_validate']['select_a_txt'].strtolower(__('subscribeduser.neet_aprng_yr_txt')) }}",
				class: "{{ $defDataArr['web_lang']['jq_validate']['select_a_txt'].strtolower(__('subscribeduser.class_txt')) }}"
			}
		});
		/*Remove file*/
		$("#file").change(function() {
			if ($('#file').hasClass('remove-file')) {
				var val = $(this).val().toLowerCase(),
					regex = new RegExp("(.*?)\.(jpg|jpeg|png)$");
				if ((regex.test(val))) {
					var oFReader = new FileReader();
					oFReader.readAsDataURL(document.getElementById("file").files[0]);
					oFReader.onload = function(oFREvent) {
						document.getElementById("preview_img").src = oFREvent.target.result;
					};
					$("#removeFile").show();
				}
			}
		});
		$("#removeFile").click(function() {
			if (confirm('Are you sure ?')) {
				$("#file").val('');
				$("#label_file").text('Upload Photo');
				$("#removeFile").hide();
				var file_src = "{{asset('themes/frontend/assets/images/profile-photo.png')}}";
				var old_file = $("#hid_file_src").val();
				if (old_file != '' && old_file !== undefined) {
					file_src = old_file;
				}
				document.getElementById("preview_img").src = file_src;
			}
		});
		/**/
	});
</script>
@endpush