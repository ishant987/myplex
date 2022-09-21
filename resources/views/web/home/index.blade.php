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
                    <div class="slider-nav">
                    <div class="single_slider_nav">
                        <img src="{{asset('themes/frontend/assets/v1/img/banner1.jpg')}}" class="img-fluid" />
                    </div>
                    <div class="single_slider_nav">
                        <img src="{{asset('themes/frontend/assets/v1/img/banner2.jpg')}}" class="img-fluid" />
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-9 px-0">
                <div class="slider-for">
                    <div class="single_slider_for">
                        <img src="{{asset('themes/frontend/assets/v1/img/banner1.jpg')}}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInLeft">Wealth is not just about money. It's about what all you can do with it. It is having your own story of progress. And living it every single day. So go ahead, imagine a future you want to shape.</p>
                            <a href="#" class="banner_btn btn animate__animated animate__fadeInLeft">Discover</a>
                        </div>
                    </div>
                     <div class="single_slider_for">
                        <img src="{{asset('themes/frontend/assets/v1/img/banner2.jpg')}}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInLeft">Wealth is not just about money. It's about what all you can do with it. It is having your own story of progress. And living it every single day. So go ahead, imagine a future you want to shape.</p>
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
                    <img class="fund_ballon" src="{{asset('themes/frontend/assets/v1/img/fund-ballon.png')}}"/>
                    <div class="latest_header">Latest from myplexus</div>
                    <div class="latest_inner_body d-block d-sm-flex align-items-center">
                    <div class="tag_latest">
                        <h4 class="red_bg">Aditya Birla Sun Life </h4>
                        <h4 class="green_tag">Flexi Cap Fund</h4>
                    </div>
                    <div class="latest_txt">An open dynamic equity scheme investing across large cap, mid cap, small cap stock)</div>
                    <button class="latest_form_btn me-5">Invest Now!</button>
                    <img class="win_sip ms-0 mr-md-5" src="{{asset('themes/frontend/assets/v1/img/win-sip.png')}}"/>
                </div>
                </div>
                
            </div>
        </div>
    </div>
</section>




<section class="abt_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-6">
                <div class="abt_img">
                    <h2 data-aos="fade-up" data-aos-duration="1000">Powerful Tools For <br>Mutual Fund Research</h2>
                    <img data-aos="fade-up" data-aos-duration="1500" src="{{asset('themes/frontend/assets/v1/img/abt-image.jpg')}}" class="img-fluid" />
                </div>
            </div>
            <div class="col-md-12 col-lg-6" id="vue-app-selections-home">
                <div class="abt_content">
                    <selections-home image_path="{{asset('themes/frontend/assets/v1/img/')}}"></selections-home>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="compare_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 mb-4">
                <div class="compare_titile text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Compare Schemes</h2>
                    <p>Professional service uses specialised, project management<br> techniques to oversee the...</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-0 col-md-10 offset-md-1" data-aos="fade-up" data-aos-duration="1500">
                <div class="compare_left_sction">
                    <img src="{{asset('themes/frontend/assets/v1/img/compare-scheme-bg.jpg')}}" class="img-fluid" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="right_compare">
                    <p data-aos="fade-up" data-aos-duration="1000">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                    <p data-aos="fade-up" data-aos-duration="1000">Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form,</p>

                    <div class="compare_accrodian_sec mt-4">
                        

                            <ul class="accordion" id="accordion">
                                <li class="accordion__item is-open">
                                    <div class="accordion__link js-accordion-link"> <img src="{{asset('themes/frontend/assets/v1/img/daily-price-icon.png')}}" /> <span>Daily Price</span>
                                        <div class="acc_icon_group">
                                            <i class="ph-plus-bold"></i>
                                            <i class="ph-minus-bold"></i> 
                                        </div>
                                    </div>
                                    <ul class="accordion__submenu js-accordion-submenu" style="display: block;">
                                        <div class="accordion-body pt-2">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                        </div>
                                    </ul>
                                </li>
                                <li class="accordion__item">
                                    <div class="accordion__link js-accordion-link"><img src="{{asset('themes/frontend/assets/v1/img/ratio-icon.png')}}" /><span>Ratio</span>
                                        <div class="acc_icon_group">
                                            <i class="ph-plus-bold"></i>
                                            <i class="ph-minus-bold"></i> 
                                        </div>
                                    </div>
                                    <ul class="accordion__submenu js-accordion-submenu" style="display: none;">
                                        <div class="accordion-body pt-2">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                        </div>
                                    </ul>
                                </li>
                                <li class="accordion__item">
                                    <div class="accordion__link js-accordion-link"><img src="{{asset('themes/frontend/assets/v1/img/composition-icon.png')}}" /><span>Composition</span>
                                        <div class="acc_icon_group">
                                            <i class="ph-plus-bold"></i>
                                            <i class="ph-minus-bold"></i> 
                                        </div>
                                    </div>
                                    <ul class="accordion__submenu js-accordion-submenu" style="display: none;">
                                        <div class="accordion-body pt-2">
                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                        <button data-aos="fade-up" data-aos-duration="1000" class="compare_scheme_btn btn-block">Compare Schemes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="money_seriously_section">
    <div class="container">
        <div class="row">
            <div class="money_seriously_title d-sm-flex d-block align-items-center justify-content-between mb-4">
                <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
                    <h4>Money, Seriously!!</h4>
                    <p>Pro membership brings exclusive and timely data at your fingertips. Discover your next great investment idea quicker and easier</p>
                </div>
                <div>
                    <a href="#" class="money_title_btn">Read More</a>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-duration="1000">
                <div class="money_left_sec">
                    <img src="{{asset('themes/frontend/assets/v1/img/money-seriusly-img.jpg')}}" class="img-fluid" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="money_right_section">
                    <h4 data-aos="fade-up" data-aos-duration="1000">Growth v/s Value Investing: Which One to Choose?</h4>
                    <p data-aos="fade-up" data-aos-duration="1500">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    <a data-aos="fade-up" data-aos-duration="2000" href="#">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="calulator_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 mb-4">
                <div class="calculator_title text-center">
                    <h4 data-aos="fade-up" data-aos-duration="1000">Calculator</h4>
                    <p data-aos="fade-up" data-aos-duration="1500">Pro membership brings exclusive and timely data at your fingertips. Discover your next great investment idea quicker and easier.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="calculator_inner d-md-flex d-block align-items-center-between w-100">
                    <div class="single_calculator">
                        <span class="right_circle d-none d-sm-block"></span>
                        <div data-aos="zoom-in" data-aos-duration="500">
                            <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon1.png')}}" />
                            <h4>SIP Planner</h4>
                        </div>
                    </div>
                    <div class="single_calculator have_before">
                        <span class="left_circle d-none d-sm-block"></span>
                        <span class="right_circle d-none d-sm-block"></span>
                        <div data-aos="zoom-in" data-aos-duration="1000">
                            <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon2.png')}}" />
                            <h4>SIP Performance Calculator</h4>
                        </div>
                    </div>
                    <div class="single_calculator have_before">
                        <span class="left_circle d-none d-sm-block"></span>
                        <span class="right_circle d-none d-sm-block"></span>
                        <div data-aos="zoom-in" data-aos-duration="1500">
                            <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon3.png')}}" />
                            <h4>Inflation Calculator</h4>
                        </div>
                    </div>
                    <div class="single_calculator have_before">
                        <span class="left_circle d-none d-sm-block"></span>
                        <span class="right_circle d-none d-sm-block"></span>
                        <div data-aos="zoom-in" data-aos-duration="2000">
                            <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon4.png')}}" />
                            <h4>Retiremen Calculator</h4>
                        </div>
                    </div>
                    <div class="single_calculator have_before">
                        <span class="left_circle d-none d-sm-block"></span>
                        <div data-aos="zoom-in" data-aos-duration="2500">
                            <img src="{{asset('themes/frontend/assets/v1/img/calculator-icon5.png')}}" />
                            <h4>Riak Tolerance Evaluator</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="research_section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="research_titile">
                    <h4 data-aos="fade-up" data-aos-duration="500">Research Better,<br> Invest Smarter</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Pro membership brings exclusive and timely data at your fingertips.Discover your next great investment idea quicker and easier</p>
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

<section class="investor_section pb-0" style="background: url({{asset('themes/frontend/assets/v1/img/twitter-msg-bg.png')}}) #fbfbfb; background-repeat: no-repeat; background-position: right; background-size: contain">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6">
                <div class="investor_left_section">
                    <h4 data-aos="fade-up" data-aos-duration="500">See What Other <br> Investors Are Saying</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Don’t just take our word for it...</p>
                    <img data-aos="fade-up" data-aos-duration="1500" src="{{asset('themes/frontend/assets/v1/img/invetor-man.png')}}" class="img-fluid" />
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

<section class="faq_section">
    @include('web.common.faq_section')
</section>
@stop