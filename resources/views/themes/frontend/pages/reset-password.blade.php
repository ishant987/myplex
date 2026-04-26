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
    .reset-shell {
        padding: 28px 0 48px;
    }

    .reset-card {
        border: 0;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .reset-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(260px, 0.85fr);
        gap: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at top left, rgba(15, 157, 88, 0.18), transparent 34%),
            linear-gradient(145deg, #ffffff, #f4f8fc);
        border-bottom: 1px solid #e8edf3;
    }

    .reset-title p {
        margin: 0 0 8px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #0f9d58;
        font-weight: 700;
    }

    .reset-title h1 {
        margin: 0 0 10px;
        color: #10243c;
        font-size: 34px;
        line-height: 1.05;
    }

    .reset-title .lead {
        margin: 0;
        color: #64748b;
        font-size: 16px;
    }

    .reset-info-card {
        background: #10243c;
        color: #fff;
        border-radius: 22px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .reset-info-card h5 {
        margin: 0;
        font-size: 18px;
        color: #fff;
    }

    .reset-info-card p {
        margin: 0;
        color: #fff;
        line-height: 1.6;
        font-size: 14px;
    }

    .reset-form-wrap {
        padding: 28px;
    }

    .reset-form-card {
        border: 1px solid #e8edf3;
        border-radius: 24px;
        padding: 24px;
        background: #fff;
    }

    .reset-form-head {
        margin-bottom: 20px;
    }

    .reset-form-head h5 {
        margin: 0 0 6px;
        color: #10243c;
        font-size: 22px;
    }

    .reset-form-head p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .reset-form-wrap .form-control {
        border-radius: 14px;
        border: 1px solid #d9e3ee;
        min-height: 48px;
        padding: 11px 14px;
        box-shadow: none;
    }

    .reset-form-wrap .field-icon {
        right: 16px;
        top: 16px;
    }

    .reset-actions {
        padding-top: 10px;
    }

    .reset-actions .btn {
        min-width: 190px;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 700;
        border: 0;
    }

    .reset-actions .btn-primary {
        background: linear-gradient(145deg, #0f9d58, #69b53f);
    }

    @media (max-width: 991px) {
        .reset-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .reset-shell {
            padding: 20px 0 36px;
        }

        .reset-hero,
        .reset-form-wrap,
        .reset-form-card {
            padding: 20px;
        }

        .reset-title h1 {
            font-size: 28px;
        }

        .reset-actions .btn {
            min-width: 100%;
        }
    }
</style>
<div class="container">
    <div class="row reset-shell">
        <div class="col-md-4 col-lg-3 col-12">
            @include('themes.frontend.includes.user-left-nav')
        </div>
        <div class="col-md-8 col-lg-9 col-12">
            <div class="content-form bg-lightblue reset-card">
                <div class="reset-hero">
                    <div class="reset-title">
                        <p>Account Security</p>
                        <h1>Reset Password</h1>
                        <div class="lead">Choose a strong new password to keep your account protected and your sessions secure.</div>
                    </div>
                    <div class="reset-info-card">
                        <h5>Password tips</h5>
                        <p>Use at least 6 characters and avoid reusing your current password. After a successful reset, you’ll be signed out and asked to log in again.</p>
                    </div>
                </div>

                <form action="{{ route('web.reset.password.save') }}" method="post" id="resetPasswordForm">
                    {{ csrf_field() }}
                    <div class="reset-form-wrap">
                        <div class="reset-form-card">
                            <div class="reset-form-head">
                                <h5>Change Your Password</h5>
                                <p>Enter your current password first, then confirm the new one below.</p>
                            </div>

                            <x-form.group_lyt4 label="{{ __('subscribeduser.cr_password_txt') }}" for="current_password" error="{{ $errors->first('current_password') }}" required="true">
                                <x-form.field.text type="password" id="current_password" name="current_password" value="" />
                            </x-form.group_lyt4>

                            <x-form.group_lyt4 label="{{ __('subscribeduser.n_password_txt') }}" for="new_password" error="{{ $errors->first('new_password') }}" info="{{ __('subscribeduser.info.pwd_len_txt') }}" required="true">
                                <x-form.field.text type="password" id="new_password" name="new_password" value="" />
                            </x-form.group_lyt4>

                            <x-form.group_lyt4 label="{{ __('common.c_password_txt') }}" for="new_password_confirmation" error="{{ $errors->first('new_password_confirmation') }}" required="true">
                                <x-form.field.text type="password" id="new_password_confirmation" name="new_password_confirmation" value="" />
                            </x-form.group_lyt4>

                            <div class="form-group row justify-content-center space-p-top reset-actions">
                                <div class="col-md-auto col-12 text-center">
                                    <x-form.field.button3 id="send" name="send" type="submit" class="btn btn-primary" text="{{ $defDataArr['web_lang']['reset_now_txt'] }}"/>
                                </div>
                            </div>

                            @if(session()->has('alert'))
                            <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                            @endif
                        </div>
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
