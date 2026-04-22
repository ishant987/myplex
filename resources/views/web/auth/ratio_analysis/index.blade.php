@extends('web.layout.infosolz_user_app')

{{-- @section('myplexus', $browser_title) --}}

@section('content')


<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        <div class="all_dash">
                            <h1 class="page_heading">Ratio Analysis</h1>
                            <ul>
                                <li>
                                    <a href="{{route('user.risk_ratio')}}">
                                        <figure><img src="{{asset('new-images/Risk-Ratio.png')}}" alt=""></figure>
                                        <h4>Risk Ratio</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.return_ratio')}}">
                                        <figure><img src="{{asset('new-images/Return-Ratio.png')}}" alt=""></figure>
                                        <h4>Return Ratio</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.sortino_ratio')}}">
                                        <figure><img src="{{asset('new-images/Sortino-Ratio.png')}}" alt=""></figure>
                                        <h4>Sortino Ratio</h4>
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
