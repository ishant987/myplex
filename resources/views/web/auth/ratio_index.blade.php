@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        

                        <div class="all_dash">
                            <h1 class="page_heading">Ratio Reports</h1>
                            <ul>
                                <li>
                                    <a href="{{route('user.quick_ratio')}}">
                                        <figure><img src="{{asset('new-images/dh1.png')}}" alt=""></figure>
                                        <h4>Quick <span>Ratios</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.weekly_snapshot_new')}}">
                                        <figure><img src="{{asset('new-images/dh2.png')}}" alt=""></figure>
                                        <h4>Weekly <span>Snapshot</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.monthly_snapshot_new')}}">
                                        <figure><img src="{{asset('new-images/dh2.png')}}" alt=""></figure>
                                        <h4>Monthly <span>Snapshot</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.fund_factsheet')}}">
                                        <figure><img src="{{asset('new-images/dh3.png')}}" alt=""></figure>
                                        <h4>Fund <span>Factsheet</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.performance_ratios')}}">
                                        <figure><img src="{{asset('new-images/dh4.png')}}" alt=""></figure>
                                        <h4>Performance <span>Ratios</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.quartile_decile')}}">
                                        <figure><img src="{{asset('new-images/dh5.png')}}" alt=""></figure>
                                        <h4>Quartile &amp;<br> Decile</h4>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="{{route('user.comparative')}}">
                                        <figure><img src="{{asset('new-images/dh6.png')}}" alt=""></figure>
                                        <h4>Comparative</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.r_square_comparison')}}">
                                        <figure><img src="{{asset('new-images/dh6.png')}}" alt=""></figure>
                                        <h4>R-Square <span>Comparison</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.notifications')}}">
                                        <figure><img src="{{asset('new-images/dh4.png')}}" alt=""></figure>
                                        <h4>Notifications</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>

@endsection
