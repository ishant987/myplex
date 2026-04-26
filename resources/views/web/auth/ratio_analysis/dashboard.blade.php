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
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.quick_ratio', 'icon' => 'new-images/dh1.png', 'title' => 'Quick Ratios', 'subtitle' => 'Fast ratio overview'])
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.weekly_snapshot_new', 'icon' => 'new-images/dh2.png', 'title' => 'Snapshot', 'subtitle' => 'Open weekly snapshot'])
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.fund_factsheet', 'icon' => 'new-images/dh3.png', 'title' => 'Fund Factsheet', 'subtitle' => 'View fund essentials'])
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.stats', 'icon' => 'new-images/dh4.png', 'title' => 'Performance Ratios', 'subtitle' => 'Track ratio performance'])
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.quartile_decile', 'icon' => 'new-images/dh5.png', 'title' => 'Quartile & Decile', 'subtitle' => 'Rank peer group standing'])
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.comparative', 'icon' => 'new-images/dh6.png', 'title' => 'Comparative', 'subtitle' => 'Compare multiple funds'])
                                @include('web.auth.partials.dashboard-card', ['route' => 'user.r_square_comparison', 'icon' => 'new-images/dh6.png', 'title' => 'R-Square Compare', 'subtitle' => 'Check correlation strength'])
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
