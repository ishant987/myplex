@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        <div class="all_dash dashboard">
                            <h1 class="page_heading">Dashboard</h1>
                            <ul>
                                <li>
                                    <a href="{{route('user.ratio_dashboard')}}">
                                        <figure><img src="{{asset('new-images/ratio-reports.png')}}" alt=""></figure>
                                        <h4>Ratio Reports</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.ratio_analysis')}}">
                                        <figure><img src="{{asset('new-images/ratio-analysis.png')}}" alt=""></figure>
                                        <h4>Ratio Analysis</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.composition_report')}}">
                                        <figure><img src="{{asset('new-images/composition-report.png')}}" alt=""></figure>
                                        <h4>Composition <br>Report</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.indices_report')}}">
                                        <figure><img src="{{asset('new-images/indies-report.png')}}" alt=""></figure>
                                        <h4>Indices Report</h4>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="#">
                                        <figure><img src="{{asset('new-images/model-portfolio.png')}}" alt=""></figure>
                                        <h4>Model Portfolio</h4>
                                    </a>
                                </li> --}}
                               
                                <li>
                                    <a href="{{route('user.filters')}}">
                                        <figure><img src="{{asset('new-images/filters.png')}}" alt=""></figure>
                                        <h4>Filters</h4>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('predictive')}}">
                                        <figure><img src="{{asset('new-images/predictive.png')}}" alt=""></figure>
                                        <h4>Predictive</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                   
                </div>
        </div>

@endsection
