@extends('web.layout.infosolz_user_app')
@section('vue-js') @stop
@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="perform">
                <div class="head_brdcm">
                    <h1 class="page_heading">{{ $page_title }}</h1>
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.ratio_dashboard') }}">Ratio Reports</a></li>
                        <li>{{ $page_title }}</li>
                    </ul>
                </div>
                <div class="subs_end">
                    <p>{{ $page_message }}</p>
                    <a href="{{ route('user.ratio_dashboard') }}">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
