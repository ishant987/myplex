@extends('web.layout.app')
@section('vue-js') @stop
@if (isset($dataArr['meta_title']))
    @section('page-title'){{ $dataArr['meta_title'] }}@stop
    @else
    @section('page-title'){{ $dataArr['title'] }}@stop
    @endif
    @if (isset($dataArr['meta_key']))
        @section('meta-keywords'){{ $dataArr['meta_key'] }}@stop
        @endif
        @if (isset($dataArr['meta_descp']))
            @section('meta-description'){{ $dataArr['meta_descp'] }}@stop
            @endif
            @if (isset($dataArr['image_path']))
                @section('meta-image'){{ $dataArr['image_path'] }}@stop
                @endif
                @if ($dataArr['full_url'])
                    @section('cur-url'){{ $dataArr['full_url'] }}@stop
                    @endif
                    @section('content')
                        <section class="inner_banner_section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="inner_section_banner">
                                            <h4>About Myplexus</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <section class="abt_page_section pb-0">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="page_abt_inner" data-aos="fade-down" data-aos-duration="1000">
                                            <h4>The Meaning of myplexus</h4>
                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels
                                                may be blood vessels (veins, apillaries) or lymphatic vessels. The nerves are typically axons
                                                outside the central nervous system.</p>
                                            <p>The financial systems today are a close copy of the network of nerves. Equally complex and
                                                confounding. But myplexus.com is the ordering of this complex into a largely simplified and
                                                understandable one, in the context of the saving and investment instruments.</p>
                                            <p>Source: Wikipedia https://en.wikipedia.org/wiki/Plexus</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="abt_right_img_wrapper" data-aos="fade-up" data-aos-duration="1500">
                                            <img src="{{ asset('themes/frontend/assets/v1/img/abt-right-img.jpg') }}" class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="page_abt_second_sec"
                            style="background: url({{ asset('themes/frontend/assets/v1/img/second_abt_arrow.png') }}) #010800; background-repeat: no-repeat; background-position: left; background-size: cover">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="second_abt_cont" data-aos="fade-down" data-aos-duration="1000">
                                            <h4>The Various Metrics of Performance is Synthesised into Numbers</h4>
                                            <p>Product life cycles will compress. Variations in performances will manifest itself more
                                                frequently. Risk evaluation will take centre-stage for marking the success or failure of every
                                                financial product or solution.</p>
                                            <p>Unbiased, user defined statistical tools will be the bedrock for understanding performance and
                                                evaluating efficacy of funds and fund managers in delivering returns quantum, providing it
                                                consistently and most specifically managing its various risk factors within manageable levels.
                                            </p>
                                            <p>But where will the technically able as well as the lay person converge to find out all this??
                                                myplexus.com aims to be this platform. Over time, myplexus should be the most preferred option
                                                for the individual, the corporate investor, the fund professional for checking out the fund’s
                                                overview as well as technical details. In a manner that is easy, simple, structured. And
                                                UNBIASED. And USER DEFINED.</p>
                                            <p>And myplexus.com will continue to evolve. With more evaluation tools. Continuously contemporize.
                                                And remain the most relevant.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <section class="our_vision_sec">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="vision_title mb-4 text-center">
                                            <h4 data-aos="fade-down" data-aos-duration="1000">Our Vision</h4>
                                            <p data-aos="fade-down" data-aos-duration="1500">
                                                To be the one-stop platform for the technically able as well as the lay person to have a
                                                comprehensive view of all their financial options, in an easily understandable manner, so that
                                                they can take informed decisions about your finances.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" data-aos="fade-down" data-aos-duration="500">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/vision1.png') }}" />
                                            </div>
                                            <h4>Return</h4>
                                            <p>
                                                We help our clients to get the best returns by providing detailed analysis of all investment
                                                opportunities and risk factors involved.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" data-aos="fade-down" data-aos-duration="1000">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/vision2.png') }}" />
                                            </div>
                                            <h4>Portfolio Allocation</h4>
                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels
                                                may be blood vessels (veins, capillaries) or lymphatic vessels.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" data-aos="fade-down" data-aos-duration="1500">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/vision3.png') }}" />
                                            </div>
                                            <h4>Peer Comparison</h4>
                                            <p>
                                                Over time, as your investment goals change, so should your asset allocation. We can provide you
                                                with a personalized asset allocation that is in line with your risk tolerance and investment
                                                objectives.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-3" data-aos="fade-down" data-aos-duration="2000">
                                        <div class="single_vison">
                                            <div class="single_vison_img">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/vision4.png') }}" />
                                            </div>
                                            <h4>Risk Ratios</h4>
                                            <p>
                                                We provide customized risk ratios for different types of investments, so that you can make
                                                informed decisions about the level of risk you are comfortable with.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="mission_section"
                            style="background-image: url({{ asset('themes/frontend/assets/v1/img/mission-bg.jpg') }}); background-position: center; background-size: cover; background-repeat: no-repeat">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mission_content" data-aos="fade-down" data-aos-duration="1500">
                                            <h4>Our Mission</h4>
                                            <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most
                                                of us. However, selections and preferences are still locked in the antiquated time period
                                                returns only.</p>
                                            <p>At myplexus.com we provide multiple statistical parameters, portfolio components and
                                                construction, and time frames to choose to evaluate fund performance. A better understanding
                                                leads to better product choice twhich increases our prosperity and improves our well-being.</p>
                                            <p>In essence, therefore, it is our goal to provide current tools for fund performance evaluation
                                                that will help us in choosing the right savings and investment product in the mutual fund space
                                                to increase our happiness and live a more profound life.</p>
                                            <p>Live better, through research!!!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="abt_meet_our_section section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="vision_title mb-5">
                                            <h4 data-aos="fade-down" data-aos-duration="1000" class="aos-init aos-animate">Meet Our Team</h4>
                                            <p data-aos="fade-down" data-aos-duration="1500" class="aos-init aos-animate">We, at myplexus.com
                                                believe the financial intermediation and personal finance industry in India is going through the
                                                fastest evolutionary stage.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="meet_team_slider slick-initialized slick-slider">
                                            <div class="slick-list draggable">
                                                <div class="slick-track"
                                                    style="opacity: 1; width: 5278px; transform: translate3d(-2262px, 0px, 0px);">
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="-4" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="-3" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="-2" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="-1" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide" data-slick-index="0" aria-hidden="true"
                                                        tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide" data-slick-index="1" aria-hidden="true"
                                                        tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-current slick-active" data-slick-index="2"
                                                        aria-hidden="false" tabindex="0" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="0"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="0"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="0"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-active" data-slick-index="3"
                                                        aria-hidden="false" tabindex="0" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="0"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="0"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="0"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-active" data-slick-index="4"
                                                        aria-hidden="false" tabindex="0" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="0"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="0"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="0"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned slick-active" data-slick-index="5"
                                                        id="" aria-hidden="false" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="0"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="0"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="0"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="6" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="img/founder.jpg">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="7" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="8" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                    <div class="single_team slick-slide slick-cloned" data-slick-index="9" id=""
                                                        aria-hidden="true" tabindex="-1" style="width: 337px;">
                                                        <div class="single_team_wrapper">
                                                            <div class="single_team_img">
                                                                <img src="{{ asset('themes/frontend/assets/v1/img/founder.jpg') }}">
                                                            </div>
                                                            <ul>
                                                                <li><a href="#" tabindex="-1"><i class="ph-facebook-logo"></i></a>
                                                                </li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-twitter-logo"></i></a></li>
                                                                <li><a href="#" tabindex="-1"><i class="ph-instagram-logo"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single_team_content">
                                                            <h4>Prasunjit</h4>
                                                            <p>A plexus (from the Latin for "braid") is a branching network of vessels or
                                                                nerves.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @stop
