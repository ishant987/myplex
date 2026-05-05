@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <div class="all_dash">
                <h1 class="page_heading">Dashboard</h1>
                <ul>
                    <li>
                        <a href="{{ route('user.ratio_dashboard') }}">
                            <figure><img src="{{ asset('new-images/dh1.png') }}" alt=""></figure>
                            <h4>Ratio <span>Reports</span></h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.ratio_analysis') }}">
                            <figure><img src="{{ asset('new-images/Risk-Ratio.png') }}" alt=""></figure>
                            <h4>Ratio <span>Analysis</span></h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.composition_report') }}">
                            <figure><img src="{{ asset('new-images/Composition.png') }}" alt=""></figure>
                            <h4>Composition <span>Report</span></h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.indies_report') }}">
                            <figure><img src="{{ asset('new-images/Indices-History.png') }}" alt=""></figure>
                            <h4>Indices <span>Report</span></h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.model_portfolio') }}">
                            <figure><img src="{{ asset('new-images/dh3.png') }}" alt=""></figure>
                            <h4>Model <span>Portfolio</span></h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.filters') }}">
                            <figure><img src="{{ asset('new-images/By-Ratios.png') }}" alt=""></figure>
                            <h4>Filters</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.predictive') }}">
                            <figure><img src="{{ asset('new-images/Occurrence-Report.png') }}" alt=""></figure>
                            <h4>Predictive</h4>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
