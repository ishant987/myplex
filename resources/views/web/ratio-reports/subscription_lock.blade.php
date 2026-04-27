@extends('web.layout.infosolz_user_app')
@section('vue-js') @stop
@section('content')

@php($lock_access_screen = true)

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="subs_end">
                <h1 class="page_heading mb-3">Access Blocked</h1>
                <p>
                    {{ !empty($expiry_date_display) ? 'Your access expired on ' . $expiry_date_display . '.' : 'Your subscription or trial period has ended.' }}
                </p>
                <p>Choose a plan to continue. Until then, the reports stay locked.</p>
                <a href="{{ $subscription_cta_url ?? '#' }}">Subscribe</a>
            </div>
        </div>
    </div>
</div>

@endsection
