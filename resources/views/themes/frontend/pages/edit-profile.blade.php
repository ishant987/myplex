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
<style>
    .edit-profile-shell {
        padding: 28px 0 48px;
    }

    .account-nav-card,
    .profile-edit-card,
    .profile-section-card {
        border: 0;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .account-nav-card {
        padding: 0;
    }

    .account-nav-head {
        padding: 24px 24px 18px;
        background: linear-gradient(145deg, #133b64, #0f9d58);
        color: #fff;
    }

    .account-nav-head p {
        margin: 0 0 6px;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        opacity: 0.82;
    }

    .account-nav-head h4 {
        margin: 0;
        font-size: 26px;
        line-height: 1.1;
    }

    .account-nav-list {
        padding: 14px;
        gap: 8px;
    }

    .account-nav-list .list-group-item {
        border: 0;
        border-radius: 16px;
        padding: 14px 16px;
        font-weight: 600;
        color: #1f2937;
        background: #f5f8fb;
        transition: all 0.2s ease;
    }

    .account-nav-list .list-group-item:hover,
    .account-nav-list .list-group-item.active {
        background: linear-gradient(145deg, #0f9d58, #69b53f);
        color: #fff;
    }

    .profile-edit-card {
        padding: 0;
    }

    .profile-edit-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.9fr);
        gap: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at top left, rgba(105, 181, 63, 0.22), transparent 34%),
            linear-gradient(145deg, #ffffff, #f4f8fc);
        border-bottom: 1px solid #e8edf3;
    }

    .profile-edit-title p {
        margin: 0 0 8px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #0f9d58;
        font-weight: 700;
    }

    .profile-edit-title h1 {
        margin: 0 0 10px;
        color: #10243c;
        font-size: 34px;
        line-height: 1.05;
    }

    .profile-edit-title .lead {
        margin: 0;
        color: #64748b;
        font-size: 16px;
    }

    .profile-photo-card {
        background: #fff;
        border: 1px solid #e7edf5;
        border-radius: 22px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 14px;
    }

    .profile-photo-frame {
        width: 124px;
        height: 124px;
        border-radius: 28px;
        overflow: hidden;
        background: #edf3f8;
        box-shadow: inset 0 0 0 1px #dbe4ee;
    }

    .profile-photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-photo-copy h5 {
        margin: 0 0 6px;
        color: #10243c;
        font-size: 18px;
    }

    .profile-photo-copy p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }

    .profile-edit-form {
        padding: 28px;
    }

    .profile-section-card {
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: none;
        border: 1px solid #e8edf3;
    }

    .profile-section-card:last-of-type {
        margin-bottom: 0;
    }

    .profile-section-head {
        margin-bottom: 20px;
    }

    .profile-section-head h5 {
        margin: 0 0 6px;
        color: #10243c;
        font-size: 22px;
    }

    .profile-section-head p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .profile-edit-form .form-group.row.align-items-center {
        margin-left: -10px;
        margin-right: -10px;
    }

    .profile-edit-form .form-group.row.align-items-center > [class*="col-"] {
        padding-left: 10px;
        padding-right: 10px;
    }

    .profile-edit-form .form-control,
    .profile-edit-form .custom-select,
    .profile-edit-form .custom-file-label {
        border-radius: 14px;
        border: 1px solid #d9e3ee;
        min-height: 48px;
        padding: 11px 14px;
        box-shadow: none;
    }

    .profile-edit-form textarea.form-control {
        min-height: 118px;
        resize: vertical;
    }

    .profile-edit-form .custom-file {
        width: 100%;
    }

    .profile-edit-form .custom-file-label::after {
        height: 46px;
        border-radius: 0 14px 14px 0;
        background: #10243c;
        color: #fff;
    }

    .profile-edit-form .input-group {
        gap: 10px;
    }

    .profile-edit-form .input-group .custom-select {
        border-radius: 14px;
    }

    .profile-edit-actions {
        padding-top: 8px;
    }

    .profile-edit-actions .btn {
        min-width: 160px;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 700;
        border: 0;
    }

    .profile-edit-actions .btn-primary {
        background: linear-gradient(145deg, #0f9d58, #69b53f);
    }

    .profile-edit-actions .btn-secondary {
        background: #e8eef5;
        color: #10243c;
    }

    @media (max-width: 991px) {
        .profile-edit-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .edit-profile-shell {
            padding: 20px 0 36px;
        }

        .profile-edit-hero,
        .profile-edit-form,
        .profile-section-card {
            padding: 20px;
        }

        .profile-edit-title h1 {
            font-size: 28px;
        }

        .profile-edit-form .input-group {
            flex-direction: column;
        }

        .profile-edit-actions .btn {
            min-width: 100%;
        }
    }
</style>
<div class="container">
    <div class="row edit-profile-shell">
        <div class="col-md-4 col-lg-3 col-12">
            @include('themes.frontend.includes.user-left-nav')
        </div>
        <div class="col-md-8 col-lg-9 col-12">
            <div class="content-form bg-lightblue profile-edit-card">
                <div class="profile-edit-hero">
                    <div class="profile-edit-title">
                        <p>Account Settings</p>
                        <h1>Edit Profile</h1>
                        <div class="lead">Update your personal, contact, and banking details from one clean dashboard.</div>
                    </div>
                    <div class="profile-photo-card">
                        <div class="profile-photo-frame">
                            @if($user->p_picture)
                            <x-img src="{{ url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 124, 124, 100]) }}" alt="{{ $user->f_name }} {{ $user->l_name }}" title="{{ $user->f_name }} {{ $user->l_name }}" id="preview_img" width="124" height="124" class="img-fluid" />
                            <x-form.field.hidden name="hid_file_src" id="hid_file_src" value="{{ url('storage', [$user->p_picture, $defDataArr['user_media_folder'], 124, 124, 100]) }}"></x-form.field.hidden>
                            @else
                            <x-img src="{{asset('themes/frontend/assets/images/profile-photo.png')}}" id="preview_img" width="124" height="124" class="img-fluid" />
                            @endif
                        </div>
                        <div class="profile-photo-copy">
                            <h5>{{ trim($user->f_name . ' ' . $user->l_name) ?: 'User Profile' }}</h5>
                            <p>Add a clear profile image so your account feels complete and easier to recognize.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('web.edit.profile.save') }}" method="post" id="profileForm" name="profileForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="profile-edit-form">
                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Profile Image</h5>
                        <p>Upload a JPG or PNG photo to personalize your account.</p>
                    </div>

                    <div class="form-group row align-items-center{{ $errors->first('p_picture') ? ' has-danger' : '' }}">
                        <div class="col-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input remove-file" id="p_picture" name="p_picture">
                                <label class="custom-file-label" id="label_p_picture" for="p_picture">{{ __('subscribeduser.upload_photo_txt') }}</label>
                                <small class="form-text text-muted">{!! __('subscribeduser.info.image') !!}</small>
                                <a class="red-text hide remove" id="removeFile" href="JavaScript:void(0);">{{ $defDataArr['web_lang']['remove_attachment_txt'] }}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Personal Details</h5>
                        <p>Keep your identity and primary contact basics up to date.</p>
                    </div>
                    <div class="form-group row align-items-center">
                        <div class="col-12 mb-1">
                        </div>
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

                        <x-form.group_lyt6 label="Pincode" for="pincode" error="{{ $errors->first('pincode') }}" required="false">
                            <x-form.field.text id="pincode" name="pincode" value="{{ old('pincode', $user->pincode) }}" />
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
                    </div>

                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Contact Details</h5>
                        <p>These details help keep your communication and location info current.</p>
                    </div>
                    <div class="form-group row align-items-center">
                        <x-form.group_lyt6 label="City" for="city" error="{{ $errors->first('city') }}" required="false">
                            <x-form.field.text id="city" name="city" value="{{ old('city', optional($user->sensitiveDetails)->city ?: $user->city) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="State" for="state" error="{{ $errors->first('state') }}" required="false">
                            <x-form.field.text id="state" name="state" value="{{ old('state', optional($user->sensitiveDetails)->state ?: $user->state) }}" />
                        </x-form.group_lyt6>
                    </div>
                    </div>

                    <div class="profile-section-card">
                    <div class="profile-section-head">
                        <h5>Banking Details</h5>
                        <p>Store payout and verification information in one place.</p>
                    </div>
                    <div class="form-group row align-items-center">
                        <x-form.group_lyt6 label="Bank Name" for="bank_name" error="{{ $errors->first('bank_name') }}" required="false">
                            <x-form.field.text id="bank_name" name="bank_name" value="{{ old('bank_name', optional($user->sensitiveDetails)->bank_name) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="Account Holder Name" for="account_holder_name" error="{{ $errors->first('account_holder_name') }}" required="false">
                            <x-form.field.text id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name', optional($user->sensitiveDetails)->account_holder_name) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="Account Number" for="account_number" error="{{ $errors->first('account_number') }}" required="false">
                            <x-form.field.text id="account_number" name="account_number" value="{{ old('account_number', optional($user->sensitiveDetails)->account_number) }}" />
                        </x-form.group_lyt6>

                        <x-form.group_lyt6 label="IFSC Code" for="ifsc_code" error="{{ $errors->first('ifsc_code') }}" required="false">
                            <x-form.field.text id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code', optional($user->sensitiveDetails)->ifsc_code) }}" />
                        </x-form.group_lyt6>
                    </div>
                    </div>

                    <div class="form-group row justify-content-center space-p-top profile-edit-actions">
                        <div class="col-md-auto col-6 text-center">
                            <x-form.field.button3 id="send" name="send" type="submit" class="btn btn-primary" text="{{ $defDataArr['web_lang']['save_txt'] }}" />
                        </div>
                        <div class="col-md-auto col-6 text-center">
                            <x-form.field.button3 type="reset" class="btn btn-secondary" text="{{ $defDataArr['web_lang']['cancel_txt'] }}" />
                        </div>
                    </div>

                    @if(session()->has('alert'))
                    <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                    @endif
                    </div>
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
