@extends('web.layout.infosolz_user_app')
@section('vue-js') @stop
@section('content')
<style>
    .wl-wrap {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(280px, 0.7fr);
        gap: 24px;
    }

    .wl-card {
        background: #fff;
        border: 1px solid #dde7e3;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .wl-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .wl-subtitle {
        color: #60756d;
        margin-bottom: 20px;
    }

    .wl-preview-box {
        border: 1px dashed #b8cbc3;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        background: #f7fbf9;
    }

    .wl-preview-logo {
        max-width: 220px;
        width: 100%;
        height: auto;
        display: block;
        margin: 0 auto 16px;
    }

    .wl-form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (max-width: 991px) {
        .wl-wrap {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="perform">
                <div class="head_brdcm">
                    
                    <p class="mb-0">This branding changes PDF output only for active White Label subscribers.</p>
                </div>

                <div class="wl-wrap">
                    <div class="wl-card">
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin:0; padding-left: 18px;">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="wl-title">PDF Branding</div>
                    <p class="wl-subtitle">Upload your logo and set the company name that should replace MyPlexus branding in PDFs.</p>

                    <form method="POST" action="{{ route('user.whitelabel_settings.save') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $brandingSettings['company_name'] ?? $user->company) }}" maxlength="255" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="logo">Company Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept=".png,.jpg,.jpeg">
                            <small class="text-muted d-block mt-2">PNG or JPG, up to 2MB. This logo will appear in generated PDFs only.</small>
                        </div>

                        <div class="wl-form-actions">
                            <button type="submit" class="btn btn-success">Save PDF Branding</button>
                            <a href="{{ route('web.subscription.index') }}" class="btn btn-outline-secondary">Back to Plans</a>
                        </div>
                    </form>
                    </div>

                    <div class="wl-card">
                        <div class="wl-title">Preview</div>
                        <p class="wl-subtitle">This is the branding that will replace the default MyPlexus logo in your PDFs while the White Label plan is active.</p>
                        <div class="wl-preview-box">
                            @if(!empty($brandingSettings['logo']))
                            <img src="{{ asset($brandingSettings['logo']) }}" alt="White Label Logo" class="wl-preview-logo">
                            @else
                            <img src="{{ asset('images/myplexus-footer-logo.png') }}" alt="Default Logo" class="wl-preview-logo">
                            @endif
                            <h3 class="mb-2">{{ $brandingSettings['company_name'] ?? $user->company ?? 'MyPlexus' }}</h3>
                            <p class="text-muted mb-0">PDF-only branding preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
