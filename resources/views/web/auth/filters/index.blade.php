@extends('web.layout.infosolz_user_app')

@section('content')
<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="all_dash">
                <h1 class="page_heading">Filters</h1>
                <ul>
                    <li>
                        <a href="{{ route('user.filters.ratios') }}">
                            <figure><img src="{{ asset('new-images/By-Ratios.png') }}" alt=""></figure>
                            <h4>By Ratios</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.filters.composition') }}">
                            <figure><img src="{{ asset('new-images/By-Composition.png') }}" alt=""></figure>
                            <h4>By Composition</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.filters.jensens') }}">
                            <figure><img src="{{ asset('new-images/dh4.png') }}" alt=""></figure>
                            <h4>By Jensen's</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.filters.beta') }}">
                            <figure><img src="{{ asset('new-images/by-Beta.png') }}" alt=""></figure>
                            <h4>By Beta</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.filters.volatility') }}">
                            <figure><img src="{{ asset('new-images/Volatility.png') }}" alt=""></figure>
                            <h4>By Volatility</h4>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
