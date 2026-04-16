@extends('web.layout.infosolz_user_app')
@section('vue-js') @stop
@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="subs_end">
                <p>
                    {{ !empty($expiry_date_display) ? 'Subscription will expire on ' . $expiry_date_display : 'Your subscription or trial period has ended.' }}
                </p>
                <a href="{{ $subscription_cta_url ?? '#' }}">Subscribe</a>
            </div>
        </div>
    </div>
</div>

@endsection
