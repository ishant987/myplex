@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                    <div class="head_brdcm">
                        <ul class="brdcmb">
                            <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                            <li>Ratio Reports</li>
                        </ul>
                    </div>
                        <div class="all_dash">
                            <h1 class="page_heading">Ratio Reports</h1>
                            <ul>
                                <li>
                                    <a href="{{route('user.quick_ratio')}}">
                                        <figure><img src="{{asset('new-images/dh1.png')}}" alt=""></figure>
                                        <h4>Quick Ratios</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.weekly_snapshot_new')}}">
                                        <figure><img src="{{asset('new-images/dh2.png')}}" alt=""></figure>
                                        <h4>Snapshot</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.fund_factsheet')}}">
                                        <figure><img src="{{asset('new-images/dh3.png')}}" alt=""></figure>
                                        <h4>Fund Factsheet</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.stats')}}">
                                        <figure><img src="{{asset('new-images/dh4.png')}}" alt=""></figure>
                                        <h4>Performance Ratios</h4>
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
                                        <h4>r-Square Compare</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- <div class="dash_boxes">
                            <ul>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 1</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 2</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 3</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 4</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 5</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 6</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                   
                </div>
        </div>

@endsection
