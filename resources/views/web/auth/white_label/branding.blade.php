@extends('web.layout.infosolz_user_app')

@section('content')
<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                    <li>White Label Branding</li>
                </ul>
            </div>

            <div class="perform_head">
                <h2>White Label Branding</h2>
            </div>

            <div class="light_green_bg" style="padding: 30px; border-radius: 18px;">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="row" style="align-items: stretch;">
                    <div class="col-lg-7">
                        <form method="POST" action="{{ route('user.white_label.branding.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form_group" style="margin-bottom: 20px;">
                                <label for="wl_company_name" style="display: block; font-weight: 600; margin-bottom: 8px;">Brand name</label>
                                <input
                                    id="wl_company_name"
                                    type="text"
                                    name="wl_company_name"
                                    value="{{ old('wl_company_name', $branding['company_name']) }}"
                                    placeholder="Enter your company name"
                                    style="width: 100%; border: 1px solid #d8e6d0; border-radius: 12px; padding: 14px 16px;"
                                    required
                                >
                            </div>

                            <div class="form_group" style="margin-bottom: 24px;">
                                <label for="wl_logo" style="display: block; font-weight: 600; margin-bottom: 8px;">Brand logo</label>
                                <input
                                    id="wl_logo"
                                    type="file"
                                    name="wl_logo"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    style="width: 100%; border: 1px solid #d8e6d0; border-radius: 12px; padding: 12px 16px; background: #fff;"
                                >
                                <small style="display: block; margin-top: 8px; color: #5d6d57;">Recommended format: PNG with transparent background.</small>
                                <small style="display: block; margin-top: 6px; color: #5d6d57;">Recommended size: 220px width x 90px height. Maximum file size: 2MB.</small>
                            </div>

                            <button type="submit" class="btn btn-success" style="border-radius: 999px; padding: 12px 26px;">Save Branding</button>
                        </form>
                    </div>

                    <div class="col-lg-5" style="margin-top: 20px;">
                        <div style="background: #fff; border-radius: 18px; padding: 24px; height: 100%; box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);">
                            <p style="font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; color: #6ab130; margin-bottom: 12px;">Preview</p>
                            <div style="border: 1px dashed #d8e6d0; border-radius: 16px; padding: 24px; text-align: center; min-height: 230px; display: flex; flex-direction: column; justify-content: center;">
                                @if (!empty($branding['has_custom_logo']) && !empty($branding['logo_url']))
                                    <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['company_name'] ?: 'White label logo' }}" style="max-width: 220px; max-height: 90px; object-fit: contain; margin: 0 auto 18px;">
                                @else
                                    <img src="{{ asset('themes/frontend/assets/infosolz/images/small_logo.png') }}" alt="Default myplexus logo" style="max-width: 220px; max-height: 90px; object-fit: contain; margin: 0 auto 18px;">
                                @endif

                                <h4 style="margin-bottom: 8px;">{{ $branding['company_name'] ?: 'Your brand name will appear in PDFs' }}</h4>
                                <p style="margin: 0; color: #5d6d57;">This branding will replace the default logo in the member header and PDF exports.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
