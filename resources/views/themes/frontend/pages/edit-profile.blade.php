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
        <div class="col-md-8 col-lg-9 col-12">
            <div class="content-form bg-lightblue">
                <div class="">
                    <p class="lead">{!! $dataArr['title'] !!}</p>
                </div>
                <form action="{{ route('web.edit.profile.save') }}" method="post" id="profileForm" name="profileForm" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group row align-items-center{{ $errors->first('p_picture') ? ' has-danger' : '' }}">
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
                                <input type="file" class="custom-file-input remove-file" id="p_picture" name="p_picture">
                                <label class="custom-file-label" id="label_p_picture" for="p_picture">{{ __('subscribeduser.upload_photo_txt') }}</label>
                                <small class="form-text text-muted">{!! __('subscribeduser.info.image') !!}</small>
                                <a class="red-text hide remove" id="removeFile" href="JavaScript:void(0);">{{ $defDataArr['web_lang']['remove_attachment_txt'] }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <x-form.group_lyt6 label="{{ __('common.f_name_txt') }}" for="f_name" error="{{ $errors->first('f_name') }}" required="true">
                            <x-form.field.text id="f_name" name="f_name" value="{{ old('f_name', $user->f_name) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="{{ __('common.l_name_txt') }}" for="l_name" error="{{ $errors->first('l_name') }}" required="false">
                            <x-form.field.text id="l_name" name="l_name" value="{{ old('l_name', $user->l_name) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="{{ __('common.email_txt') }}" for="email" error="{{ $errors->first('email') }}" required="true">
                            <x-form.field.text id="email" name="email" value="{{ old('email', $user->email) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="{{ __('subscribeduser.mobile_txt') }}" for="mobile" error="{{ $errors->first('mobile') }}" required="false">
                            <x-form.field.text id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="Company" for="company" error="{{ $errors->first('company') }}" required="false">
                            <x-form.field.text id="company" name="company" value="{{ old('company', $user->company) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="Pincode" for="pincode" error="{{ $errors->first('pincode') }}" required="false">
                            <x-form.field.text id="pincode" name="pincode" value="{{ old('pincode', $user->pincode) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="City" for="city" error="{{ $errors->first('city') }}" required="false">
                            <x-form.field.text id="city" name="city" value="{{ old('city', $user->city) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="State" for="state" error="{{ $errors->first('state') }}" required="false">
                            <x-form.field.text id="state" name="state" value="{{ old('state', $user->state) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="Birthday" required="false">
                            <div class="input-group">
                                <select name="birthday_year" id="birthday_year" class="custom-select placeholder">
                                    <option value="">{{ __('subscribeduser.brthdy_year_def_opt_txt') }}</option>
                                    @foreach ($yearArr as $yValue)
                                    <option value="{{ $yValue }}" @if((string) old('birthday_year', $birthdayArr[0] ?? '') === (string) $yValue) selected @endif>{{ $yValue }}</option>
                                    @endforeach
                                </select>
                                <select name="birthday_month" id="birthday_month" class="custom-select placeholder">
                                    <option value="">{{ __('subscribeduser.brthdy_month_def_opt_txt') }}</option>
                                    @foreach ($monthsArr as $key => $mValue)
                                    <option value="{{ $key }}" @if((string) old('birthday_month', $birthdayArr[1] ?? '') === (string) $key) selected @endif>{{ $mValue }}</option>
                                    @endforeach
                                </select>
                                <select name="birthday_day" id="birthday_day" class="custom-select placeholder">
                                    <option value="">{{ __('subscribeduser.brthdy_day_def_opt_txt') }}</option>
                                    @foreach ($daysArr as $value)
                                    <option value="{{ $value }}" @if((string) old('birthday_day', $birthdayArr[2] ?? '') === (string) $value) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="Address" for="address" error="{{ $errors->first('address') }}" required="false">
                            <textarea id="address" name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                        </x-form.group_lyt6>
                    </div>

                    <div class="form-group row justify-content-center space-p-top">
                        <div class="col-md-auto col-6 text-center">
                            <x-form.field.button3 id="send" name="send" type="submit" class="btn btn-primary" text="{{ $defDataArr['web_lang']['save_txt'] }}" />
                        </div>
                        <div class="col-md-auto col-6 text-center">
                            <x-form.field.button3 type="reset" class="btn btn-primary" text="{{ $defDataArr['web_lang']['cancel_txt'] }}" />
                        </div>
                    </div>

                    @if(session()->has('alert'))
                    <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script>
    $(function() {
        $("#profileForm").validate({
            rules: {
                p_picture: {
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
                    required: false,
                    number: true
                }
            },
            messages: {
                p_picture: {
                    extension: "{{ $defDataArr['web_lang']['jq_validate']['upload_extension_txt'] }}"
                },
                f_name: "{{ $defDataArr['web_lang']['jq_validate']['enter_a_txt'].strtolower(__('common.f_name_txt')) }}",
                email: {
                    required: "{{ $defDataArr['web_lang']['jq_validate']['enter_an_txt'].strtolower(__('common.email_txt')) }}",
                    email: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('common.email_txt')) }}"
                },
                mobile: {
                    number: "{{ $defDataArr['web_lang']['jq_validate']['enter_valid_txt'].strtolower(__('subscribeduser.mobile_txt')) }}"
                }
            }
        });

        $("#p_picture").change(function() {
            if ($('#p_picture').hasClass('remove-file')) {
                var val = $(this).val().toLowerCase(),
                    regex = new RegExp("(.*?)\\.(jpg|jpeg|png)$");
                if ((regex.test(val))) {
                    var oFReader = new FileReader();
                    oFReader.readAsDataURL(document.getElementById("p_picture").files[0]);
                    oFReader.onload = function(oFREvent) {
                        document.getElementById("preview_img").src = oFREvent.target.result;
                    };
                    $("#label_p_picture").text(document.getElementById("p_picture").files[0].name);
                    $("#removeFile").show();
                }
            }
        });

        $("#removeFile").click(function() {
            if (confirm('Are you sure ?')) {
                $("#p_picture").val('');
                $("#label_p_picture").text('Upload Photo');
                $("#removeFile").hide();
                var file_src = "{{asset('themes/frontend/assets/images/profile-photo.png')}}";
                var old_file = $("#hid_file_src").val();
                if (old_file != '' && old_file !== undefined) {
                    file_src = old_file;
                }
                document.getElementById("preview_img").src = file_src;
            }
        });
    });
</script>
@endpush
