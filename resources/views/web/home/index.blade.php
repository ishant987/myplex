@extends('web.layout.app')
@section('moneycontrol') @stop
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
<section class="new_hero_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 px-0">
                <div class="left_slider_sec">
                    <h4>Market Update</h4>
                    <div class="her_banner_left_slide">
                        <div class="single_slider_nav">
                            <p>Bandhan Bank Q2 update: Loans, advances rise 22% to Rs 99,374 crore Why was Electronics Mart India IPO a hit with investors?</p>
                            <p>Pune#39;s newest fine-dining Chinese restaurant wants you to try something new</p>
                        </div>
                        <div class="single_slider_nav">
                            <p>Bandhan Bank Q2 update: Loans, advances rise 22% to Rs 99,374 crore Why was Electronics Mart India IPO a hit with investors?</p>
                            <p>Pune#39;s newest fine-dining Chinese restaurant wants you to try something new</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 px-0">
                <div class="hero_banner_right_slider">
                    <div class="single_slider_for">
                        <img src="{{asset('themes/frontend/assets/v1/img/banner1.jpg')}}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInUp">Wealth is not just about money. It's about what all you can do with it. It is having your own story of progress. And living it every single day. So go ahead, imagine a future you want to shape.</p>
                            <a href="#" class="banner_btn btn animate__animated animate__fadeInLeft">Discover</a>
                        </div>
                    </div>
                    <div class="single_slider_for">
                        <img src="{{asset('themes/frontend/assets/v1/img/banner2.jpg')}}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInUp">Wealth is not just about money. It's about what all you can do with it. It is having your own story of progress. And living it every single day. So go ahead, imagine a future you want to shape.</p>
                            <a href="#" class="banner_btn btn animate__animated animate__fadeInLeft">Discover</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="latest_from_myplexus_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest_inner_sec">
                    <div class="latest_inner_sec_title">Latest from myplexus</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single_rserach">
                                <div class="latest_header">Best fund for SIP</div>
                                <h2>Aditya Birla Sun Life Flexi Cap Fund</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_rserach">
                                <div class="latest_header">Best fund for SIP</div>
                                <h2>Future value calculator?</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_rserach">
                                <div class="latest_header">Best fund for SIP</div>
                                <h2>With Compare scheme</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<section class="abt_section section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-12">
                <div class="abt_img text-center">
                    <h2>Powerful Tools For <br>Mutual Fund Research</h2>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="row">

                    <div class="col-md-4">
                        <div class="single_abt_item  mb-5" data-aos="fade-up" data-aos-duration="1500">
                            <div class="abt_icon d-flex align-items-center">
                                <img src="{{asset('themes/frontend/assets/v1/img/fund-icon.png')}}" />
                                <h4>Category Performance Snapshot</h4>
                            </div>
                            <div class="single_abt_content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <a href="/fund-performance">Go to Fund Performance <i class="ph-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single_abt_item mb-5" data-aos="fade-up" data-aos-duration="1500">
                            <div class="abt_icon d-flex align-items-center">
                                <img src="{{asset('themes/frontend/assets/v1/img/performance-icon.png')}}" />
                                <h4>Scheme Performance, Ratios & highlights</h4>
                            </div>
                            <div class="single_abt_content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <a href="/performance-snapshot">Go to Performance Snapshot <i class="ph-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single_abt_item" data-aos="fade-up" data-aos-duration="1500">
                            <div class="abt_icon d-flex align-items-center">
                                <img src="{{asset('themes/frontend/assets/v1/img/ranking-icon.png')}}" />
                                <h4>Category wise return & risk ratios</h4>
                            </div>
                            <div class="single_abt_content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <a href="/monthly-ranking">Go to Monthly Ranking <i class="ph-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="compare_section section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="compare_titile text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Compare: Scheme, Index, Currency, Commodity..</h2>
                    <p>Professional service uses specialised, project management techniques to oversee the...</p>
                </div>
            </div>
        </div>
        <div class="row align-items-end">
            <div class="col-lg-6 offset-lg-0 col-md-10 offset-md-1" data-aos="fade-up" data-aos-duration="1500">
                <div class="compare_left_sction">
                    <img src="{{asset('themes/frontend/assets/v1/img/compare-sheme-img.png')}}" class="img-fluid" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="right_compare">
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{asset('themes/frontend/assets/v1/img/daily-price-icon.png')}}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Daily Price</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.</p>
                            <a href="/compare-scheme?compare_price_type=scheme_scheme">Compare Now!</a>
                        </div>
                    </div>
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{asset('themes/frontend/assets/v1/img/ratio-icon.png')}}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Ratio</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.</p>
                            <a href="/compare-scheme?compare_ratio_type=information_ratio">Compare Now!</a>
                        </div>
                    </div>
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{asset('themes/frontend/assets/v1/img/composition-icon.png')}}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Composition</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.</p>
                            <a href="/compare-scheme?compare_composition_type=top_industry">Compare Now!</a>
                        </div>
                    </div>
                    <button data-aos="fade-up" data-aos-duration="1000" class="compare_scheme_btn btn-block">Compare</button>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="money_seriously_section section">
    <div class="container">
        <div class="row">
            <div class="money_seriously_title mb-4">
                <div class="col-md-12" data-aos="fade-up" data-aos-duration="1000">
                    <div class="money_seriously_title d-block d-sm-flex align-items-center">
                        <h4>Money, Seriously!!</h4>
                        <p>orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-4 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="1000">
                    <img src="{{asset('themes/frontend/assets/v1/img/money-seriusly-img.jpg')}}" class="img-fluid" />
                </div>
                <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">Read More</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="1000">
                    <img src="{{asset('themes/frontend/assets/v1/img/money-seriusly-img.jpg')}}" class="img-fluid" />
                </div>
                <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">Read More</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="1000">
                    <img src="{{asset('themes/frontend/assets/v1/img/money-seriusly-img.jpg')}}" class="img-fluid" />
                </div>
                <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Growth v/s Value Investing: Which One to Choose?</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">Read More</a>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <a href="#" class="money_title_btn">View All Articles</a>
            </div>
        </div>
    </div>
</section>
<section class="calulator_section section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 mb-4">
                <div class="calculator_title text-center">
                    <h4 data-aos="fade-up" data-aos-duration="500">Calculator</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Pro membership brings exclusive and timely data at your fingertips. Discover your next great investment idea quicker and easier.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills justify-content-center calculator_nav_pills mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="Planner-tab" data-bs-toggle="tab" data-bs-target="#Planner" type="button" role="tab" aria-controls="Planner" aria-selected="true">Planner</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Performance-tab" data-bs-toggle="tab" data-bs-target="#Performance" type="button" role="tab" aria-controls="Performance" aria-selected="false">Performance</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="Planner" role="tabpanel" aria-labelledby="Planner-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="calculator_inner d-md-flex d-block align-items-center-between w-100">
                                    <div class="single_calculator">
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="500">
                                            <a href="{{ route('web.calculators') }}?tab=inf-calc">
                                                <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon1.png')}}" />
                                                <h4>Inflation calculator</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="{{ route('web.calculators') }}?tab=retire-calc">
                                                <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon2.png')}}" />
                                                <h4>Retirement calculator</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1500">
                                            <a href="objective-calculator.html">
                                                <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon3.png')}}" />
                                                <h4>other objectives*</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="2000">
                                            <a href="{{ route('web.calculators') }}?tab=risk-tol-eval">
                                                <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon4.png')}}" />
                                                <h4>Risk appetite evaluator</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="2000">
                                            <a href="future-value-calculator.html">
                                                <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon6.png')}}" />
                                                <h4>Future Value</h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Performance" role="tabpanel" aria-labelledby="Performance-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="calculator_inner d-md-flex d-block align-items-center-between justify-content-center w-100">
                                    <div class="single_calculator">
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="500">
                                            <a href="lumpsum-calculator.html">
                                                <img src="{{asset('themes/frontend/assets/v1/img/lumpsum.png')}}" />
                                                <h4>Lumpsum calculator</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="{{ route('web.calculators') }}?tab=sip-planner">
                                                <img src="{{asset('themes/frontend/assets/v1/img/sip.png')}}" />
                                                <h4>SIP calculator</h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="money_seriously_section fund_watch_setion_home section">
    <div class="container">
        <div class="row">
            <div class="money_seriously_title mb-4">
                <div class="col-md-12" data-aos="fade-down" data-aos-duration="1000">
                    <div class="money_seriously_title d-block d-sm-flex align-items-center">
                        <h4>Fund Watch</h4>
                        <p>orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-duration="500">
                <div class="money_left_sec">
                    <div class="fund_watch_home_sec_single_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/nippon.jpg')}}" />
                    </div>
                </div>
                <div class="money_right_section" >
                    <h4>NIPPON INDIA SMALLCAP INDEX 250 FUND</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">View More Details</a>
                </div>
            </div>
            <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
                <div class="money_left_sec">
                    <div class="fund_watch_home_sec_single_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/nippon.jpg')}}" />
                    </div>
                </div>
                <div class="money_right_section" >
                    <h4>NIPPON INDIA SMALLCAP INDEX 150 FUND</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">View More Details</a>
                </div>
            </div>
        </div>
        <div class="row mt-5" data-aos="fade-up" data-aos-duration="500">
            <div class="col-md-12 text-center">
                <a href="#" class="money_title_btn">View All Funds</a>
            </div>
        </div>
    </div>
</section>
<section class="money_seriously_section fund_watch_setion_home nfo_monitor_home_section section">
    <div class="container">
        <div class="row">
            <div class="money_seriously_title mb-4">
                <div class="col-md-12" data-aos="fade-up" data-aos-duration="1000">
                    <div class="money_seriously_title d-block d-sm-flex align-items-center">
                        <h4>NFO Monitor</h4>
                        <p>orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="500">
                    <div class="fund_watch_home_sec_single_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/nippon.jpg')}}" />
                    </div>
                </div>
                <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Mahindra Manulife Flexi Cap Yojana</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">View More Details</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="500">
                    <div class="fund_watch_home_sec_single_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/nippon.jpg')}}" />
                    </div>
                </div>
                <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Tata Business Cycle Fund</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#">View More Details</a>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <a href="#" class="money_title_btn">View All Monitor</a>
            </div>
        </div>
    </div>
</section>

<section class="fund_expert_section section">
    <img class="fund_expert_man" src="{{asset('themes/frontend/assets/v1/img/fund_expert.png')}}" data-aos="fade-up" data-aos-duration="500" />
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="fund_man_expert_home" data-aos="fade-up" data-aos-duration="500">
                    <h2>Meet The Fund Expert</h2>
                    <h4>Vihang Naik</h4>
                    <p>Fund Manager - Equity Investments<br>L&T Investment Management Limited</p>
                    <p>Vihang is the consummate fund professional in youthful garb. In every conversation and discussion, he brings in a perspective that really gets the participants to think and participate. Armed with CFA and BMS qualifications, and with the support ...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonial_section_home section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="calculator_title text-center">
                    <h4 data-aos="fade-up" data-aos-duration="500">See What Industry leaders Are Saying</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Don’t just take our word for it...</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="testimonial_inner">
                    <div class="testimonial_slider">
                        <div class="single_testimonila_slide">
                            <div class="single_slider_message">
                                <img src="{{asset('themes/frontend/assets/v1/img/quote.png')}}" />
                                <p>myplexus.com provides data and analysis like no other platform. It is a very evolved and contemporary platform to evaluate fund performance. The comparisons between funds that it provides by using exhaustive statistical tools lend to it the credibility that investors and advisors will certainly benefit from. Certain features and tools myplexus.com utilises provide insights unmatched anywhere else. </p>
                            </div>
                            <div class="testimonila_user_group_sec d-flex align-items-center justify-content-center">
                                <div class="user_img_group">
                                    <img src="{{asset('themes/frontend/assets/v1/img/founder.jpg')}}" />
                                </div>
                                <div class="user_details_group">
                                    <h4>Waqar Naqvi</h4>
                                    <p>Chief Executive, </p>
                                    <p>Taurus Mutual Fund</p>
                                </div>
                            </div>
                        </div>
                        <div class="single_testimonila_slide">
                            <div class="single_slider_message">
                                <img src="{{asset('themes/frontend/assets/v1/img/quote.png')}}" />
                                <p>myplexus.com provides data and analysis like no other platform. It is a very evolved and contemporary platform to evaluate fund performance. The comparisons between funds that it provides by using exhaustive statistical tools lend to it the credibility that investors and advisors will certainly benefit from. Certain features and tools myplexus.com utilises provide insights unmatched anywhere else. </p>
                            </div>
                            <div class="testimonila_user_group_sec d-flex align-items-center justify-content-center">
                                <div class="user_img_group">
                                    <img src="{{asset('themes/frontend/assets/v1/img/founder.jpg')}}" />
                                </div>
                                <div class="user_details_group">
                                    <h4>Waqar Naqvi</h4>
                                    <p>Chief Executive, </p>
                                    <p>Taurus Mutual Fund</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="research_section section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="research_titile">
                    <h4 data-aos="fade-up" data-aos-duration="500">Are you a financial Advisor
                    </h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Pro membership brings exclusive and timely data at your fingertips. Discover your next great investment idea quicker and easier</p>
                    <a data-aos="fade-up" data-aos-duration="1500" href="#" class="reserch_discover_btn">Discover</a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <div class="research_right_sec">
                    <div class="research_row d-md-block d-lg-flex d-block align-items-center mb-40">
                        <div class="single_reserch d-flex align-items-center text-end mr-40 gb-right" data-aos="fade-up" data-aos-duration="1000">
                            <h4>Premium screens on various themes</h4>
                            <div class="research_icon">
                                <img src="{{asset('themes/frontend/assets/v1/img/research1.png')}}" />
                            </div>
                        </div>
                        <div class="single_reserch d-flex align-items-center" data-aos="fade-down" data-aos-duration="1000">
                            <div class="research_icon">
                                <img src="{{asset('themes/frontend/assets/v1/img/research2.png')}}" />
                            </div>
                            <h4>Forecasts for price, revenue and EPS</h4>
                        </div>
                    </div>
                    <span class="verticle_line d-none d-lg-block"></span>
                    <span class="horizotal_line d-none d-lg-block"></span>
                    <div class="research_row d-md-block d-lg-flex d-block  align-items-center">
                        <div class="single_reserch d-flex align-items-center text-end mr-40 gb-right" data-aos="fade-up" data-aos-duration="1000">
                            <h4>Download data for offline analysis</h4>
                            <div class="research_icon">
                                <img src="{{asset('themes/frontend/assets/v1/img/research3.png')}}" />
                            </div>
                        </div>
                        <div class="single_reserch d-flex align-items-center" data-aos="fade-down" data-aos-duration="1000">
                            <div class="research_icon">
                                <img src="{{asset('themes/frontend/assets/v1/img/research4.png')}}" />
                            </div>
                            <h4>Premium and customizable filters</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="ask_the_expert_sec section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="calculator_title text-center">
                    <h4 data-aos="fade-up" data-aos-duration="500">Ask The Experts</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Don’t just take our word for it...</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="500">
                <div class="single_ask_expert">
                    <img src="{{asset('themes/frontend/assets/v1/img/quote-green.png')}}" />
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly ...</p>
                    <div class="single_ask_footer d-flex align-items-center">
                        <span></span>
                        <h4>Vikash Kumar</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="500">
                <div class="single_ask_expert">
                    <img src="{{asset('themes/frontend/assets/v1/img/quote-green.png')}}" />
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly ...</p>
                    <div class="single_ask_footer d-flex align-items-center">
                        <span></span>
                        <h4>Vikash Kumar</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="500">
                <div class="single_ask_expert">
                    <img src="{{asset('themes/frontend/assets/v1/img/quote-green.png')}}" />
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly ...</p>
                    <div class="single_ask_footer d-flex align-items-center">
                        <span></span>
                        <h4>Vikash Kumar</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <a href="#" class="money_title_btn">Ask An Expert</a>
            </div>
        </div>
    </div>
</section>
<section class="cta_section section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="fund_man_expert_home" data-aos="fade-up" data-aos-duration="500">
                    <h2>Performance Synopsis</h2>
                    <p>Pro membership brings exclusive and timely data at your fingertips. Discover your next great investment idea quicker and easier</p>
                    <a href="#" class="money_title_btn me-3">Login</a>
                    <a href="#" class="money_title_btn">Register</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="faq_section section">
    @include('web.common.faq_section')
</section>
<section class="scheme_cta section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="fund_man_expert_home" data-aos="fade-up" data-aos-duration="500">
                    <h2>Know Your Scheme</h2>
                    <p>Pro membership brings exclusive and timely data at your fingertips. Discover your next great investment idea quicker and easier</p>
                    <a href="#" class="money_title_btn me-3">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="as_seen_on_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="as_seen_slider_inner text-center">
                    <h4>As Seen On</h4>
                    <div class="as_seen_slider">
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client1.jpg')}}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client2.jpg')}}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client3.jpg')}}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client4.jpg')}}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client5.jpg')}}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client6.jpg')}}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{asset('themes/frontend/assets/v1/img/client1.jpg')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop