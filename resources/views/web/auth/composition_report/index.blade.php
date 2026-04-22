@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        <div class="all_dash">
                            <h1 class="page_heading">Composition Report</h1>
                            <ul>
                                <li>
                                    <a href="{{route('user.allocation_snapshot')}}">
                                        <figure><img src="{{asset('new-images/Composition.png')}}" alt=""></figure>
                                        <h4>Composition<br> Allocation<br> Snapshot</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.scheme_portfolio')}}">
                                        <figure><img src="{{asset('new-images/Scheme-Portfolio.png')}}" alt=""></figure>
                                        <h4>Scheme Portfolio</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.occurrence_report')}}">
                                        <figure><img src="{{asset('new-images/Occurrence-Report.png')}}" alt=""></figure>
                                        <h4>Occurrence<br> Report</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.top_script_rop_industry')}}">
                                        <figure><img src="{{asset('new-images/Top-Scrips.png')}}" alt=""></figure>
                                        <h4>Top Scrips <br>Top Industries</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.new_script_new_industry')}}">
                                        <figure><img src="{{asset('new-images/New-Scrips.png')}}" alt=""></figure>
                                        <h4>New Scrips<br> New Industries</h4>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="{{route('user.boomers')}}">
                                        <figure><img src="{{asset('new-images/Boomers.png')}}" alt=""></figure>
                                        <h4>Boomers</h4>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('user.busters')}}">
                                        <figure><img src="{{asset('new-images/Busters.png')}}" alt=""></figure>
                                        <h4>Busters</h4>
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
