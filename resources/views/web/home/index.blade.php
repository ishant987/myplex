@extends('web.layout.app')
@section('moneycontrol') @stop
@section('vue-js') @stop
@section('captcha') @stop
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
            <div class="col-md-12 col-lg-3 px-0">
                <div class="left_slider_sec">
                    <h4 class="mb-4">Market Update</h4>
                     <div class="her_banner_left_slide">
						 
					</div>
                </div>
            </div>
            <div class="col-md-12 col-lg-9 px-0">
                <div class="hero_banner_right_slider">
                    <div class="single_slider_for">
                        <img src="{{ asset('themes/frontend/assets/v1/img/home1.jpeg') }}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInUp">Wealth is not just about money. It's about
                                what all you can do with it. It is having your own story of progress. And living it
                                every single day. So go ahead, imagine a future you want to shape.</p>
                            <!-- <a href="/compare-scheme" class="banner_btn btn animate__animated animate__fadeInLeft">Compare</a> -->
                        </div>
                    </div>
                    <div class="single_slider_for">
                        <img src="{{ asset('themes/frontend/assets/v1/img/banner-2.jpg') }}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInUp">Wealth is not just about money. It's about
                                what all you can do with it. It is having your own story of progress. And living it
                                every single day. So go ahead, imagine a future you want to shape.</p>
                            <!-- <a href="/compare-scheme" class="banner_btn btn animate__animated animate__fadeInLeft">Compare</a> -->
                        </div>
                    </div>
					<div class="single_slider_for">
                        <img src="{{ asset('themes/frontend/assets/v1/img/banner-3.jpg') }}" class="img-fluid" />
                        <div class="slider_caption">
                            <h2 class="animate__animated animate__fadeInUp">Invest in the freedom to choose</h2>
                            <p class="animate__animated animate__fadeInUp">Wealth is not just about money. It's about
                                what all you can do with it. It is having your own story of progress. And living it
                                every single day. So go ahead, imagine a future you want to shape.</p>
                            <!-- <a href="/compare-scheme" class="banner_btn btn animate__animated animate__fadeInLeft">Compare</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="latest_from_myplexus_sec">
    <div class="container-fliud">
        <div class="row">
            <div class="col-md-12">
                <div class="latest_inner_sec">
                    
					<div class="compare_titile text-center aos-init">
                    	<h2>Latest from myplexus</h2>
                	</div>
					
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single_rserach">
                                <div class="latest_header">Best fund for SIP</div>
                                <p class='text-white px-2'>Aditya Birla Sun Life Flexi Cap Fund</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_rserach">
                                <div class="latest_header">Best fund for SIP</div>
                                <p class='text-white px-2'>Future Value Calculator?</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single_rserach">
                                <div class="latest_header">Best fund for SIP</div>
                                <p class='text-white px-2'>With Compare Scheme</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section> -->
<section class="service-style1-area">
    <div class="service-style1-bg" style="background-image: url(assets/images/backgrounds/service-style1.jpg);">
    </div>
    <div class="container">

        <div class="row">
            <div class="col-xl-12">
                <div class="service-style1-title">
                    <div class="sec-title">
                        <h2>Latest From myplexus</h2>
                        <!-- <div class="sub-title">
                            <p>The bank that builds better relationships.</p>
                        </div> -->
                    </div>
                    <div class="get-assistant-box">
                        <a href="#"><span class="icon-chatting"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="service-style1-tab">
                    

                    <!--Start Tabs Content Box-->
                    <div class="tabs-content-box">
                        
                        <!--Tab-->
                        <div class="tab-content-box-item tab-content-box-item-active" id="companies">
                            <div class="service-style1-tab-content-box-item">
                                @if(count($allnewfroms) >= 3)
                                <div class="row">
                                    <!--Start Single Service Box Style1-->
                                    <div class="col-xl-4 col-lg-4 mt-4">
                                        <div class="single-service-box-style1 h-100">
											<div class="top-float blog">
												<p class="mb-0">{{ $allnewfroms[0]->type_id }}</p>
											</div>
                                            <div class="icon">
                                                <span class="icon-safebox"></span>
                                            </div>
                                            
                                            <h3><a href="{{ $allnewfroms[0]->link }}" target="_blank">{{ $allnewfroms[0]->title }}</a></h3>
                                            <div class="border-box"></div>
                                            <!--<p>Aditya Birla Sun Life Flexi Cap Fund</p>-->
                                            <!-- <h6><span>*</span> Interest rate up to 5% p.a</h6> -->
                                            <div class="btn-box">
                            <a href="{{ $allnewfroms[0]->link }}" target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Single Service Box Style1-->
                                    <!--Start Single Service Box Style1-->
                                    <div class="col-xl-4 col-lg-4 mt-4">
                                        <div class="single-service-box-style1 h-100">
											<div class="top-float">
												<p class="mb-0">{{ $allnewfroms[1]->type_id }}</p>
											</div>
                                            <div class="icon">
                                                <span class="icon-online"></span>
                                            </div>
                                          <h3><a href="{{ $allnewfroms[1]->link }}" target="_blank">{{ $allnewfroms[1]->title }}</a></h3>
                                            <div class="border-box"></div>
                                            <!--<p>Future Value Calculator?</p> -->
                                            <!-- <h6><span>*</span> Terms &amp; Conditions</h6> -->
                                            <div class="btn-box"> 
                                           <a href="{{ $allnewfroms[1]->link }}" target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Single Service Box Style1-->
                                    <!--Start Single Service Box Style1-->
                                    <div class="col-xl-4 col-lg-4 mt-4">
                                        <div class="single-service-box-style1 h-100">
											<div class="top-float">
												<p class="mb-0">{{ $allnewfroms[2]->type_id }}</p>
											</div>
                                            <div class="icon">
                                                <span class="icon-loan"></span>
                                            </div>
                                            <h3><a href="{{ $allnewfroms[2]->link }}" target="_blank">{{ $allnewfroms[2]->title }}</a></h3>
                                            <div class="border-box"></div>
                                            <!--<p>With Compare Scheme</p> -->
                                            <!-- <h6><span>*</span> Check today’s Interest Rates</h6> -->
                                            <div class="btn-box">
                                                <a href="{{ $allnewfroms[2]->link }}" target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Single Service Box Style1-->
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!--End Tabs Content Box-->

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
                    <h2>Powerful Tools For Mutual Fund Research</h2>
                </div>
            </div>
            <div class="col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="single_abt_item" data-aos="fade-up" data-aos-duration="1500">
                            <div class="abt_icon d-flex align-items-center">
                                <img src="{{ asset('themes/frontend/assets/v1/img/ranking-icon.png') }}" />
                                <h4>Category wise Return & Risk Ranking</h4>
                            </div>
                            <div class="single_abt_content">
                                <p>Performance parameters and recommendations of fund rankings in terms of quality of return, volatility, and risk incurred.</p>
                                <!-- <a href="/monthly-ranking">Go To Categorywise Return <i class="ph-arrow-right"></i></a> -->
                                  <!-- <div class="form-group pt-4 w-100">
									  <select class="form-control dropdown-toggle" id="sel1" name="sellist1">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									  </select>
                                </div> -->
                               <div class="dropdown tools_dropdown">
                                    <select class="form-select select2" id="risk-management" aria-label="Default select example" onchange="performance(this.value, 'risk')">
                                        <option value="">Open this select menu</option>
										@if($performaceResponses['success'])
											@foreach ($performaceResponses['data'] as $performaceResponse)
												<option value="{{ $performaceResponse['ft_id'] }}">{{ $performaceResponse['name'] }}</option>
											@endforeach
										@endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="single_abt_item " data-aos="fade-up" data-aos-duration="1500">
                            <div class="abt_icon d-flex align-items-center">
                                <img src="{{ asset('themes/frontend/assets/v1/img/fund-icon.png') }}" />
                                <h4>Category Performance Snapshot</h4>
                            </div>
                            <div class="single_abt_content">
                                <p>Categorizing and indexing fund's performance over multiple time frames to understand its risk adjusted returns, ratios, and portfolios.</p>
                                <!-- <a href="/fund-performance">Go To Category Performance <i class="ph-arrow-right"></i></a> -->
                                <div class="dropdown tools_dropdown">									
									<select class="form-select select2" aria-label="Default select example" onchange="performance(this.value, 'performance-snapshot')">
                                        <option value="">Open this select menu</option>
										@if($performaceResponses['success'])
											@foreach ($performaceResponses['data'] as $performaceResponse)
												<option value="{{ $performaceResponse['ft_id'] }}">{{ $performaceResponse['name'] }}</option>
											@endforeach
										@endif
                                    </select>
									
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="single_abt_item " data-aos="fade-up" data-aos-duration="1500">
                            <div class="abt_icon d-flex align-items-center">
                                <img src="{{ asset('themes/frontend/assets/v1/img/performance-icon.png') }}" />
                                <h4>Scheme Performance, Ratios & Highlights:</h4>
                            </div>
                            <div class="single_abt_content">
                                <p>A detailed insight into scheme performance, the asset allocation of the scheme and how it has been constructed over time.</p>
                                <!-- <a href="/performance-snapshot">Go To Scheme Performance <i class="ph-arrow-right"></i></a> -->
                                <div class="dropdown tools_dropdown">
                                    <select class="form-select select2" aria-label="Default select example" onchange="performance(this.value, 'fund-performance')">
                                        <option value="">Open this select menu</option>
										@if($fundReponses['success'])
											@foreach ($fundReponses['data'] as $fundResponse)
												<option value="{{ $fundResponse['fund_code'] }}">{{ $fundResponse['fund_name'] }}</option>
											@endforeach
										@endif
                                    </select>
                                </div>
								
								
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
                    <h2>Compare: Scheme, Index, Currency, Commodity...</h2>
                    <!-- <p>Specialized calculation algorithms that allow you to make the most informed decisions.</p> -->
                </div>
            </div>
        </div>
        <div class="row columns_padding_25 columns_margin_bottom_30">
			
            <div class="col-md-12 text-center">
                <!-- <div class="workflow inline-block columns_padding_0">
                    <div class="row columns_margin_bottom_0">
                        <div class="col-xs-4 compare_schemes_design">
                            <h4 class="text-uppercase margin_0">Daily Price</h4>
                        </div>
                        <div class="col-xs-4 col-xs-offset-4 compare_schemes_design">
                            <h4 class="text-uppercase margin_0">Composition</h4>
                        </div>
                    </div>
                    <img src="{{ asset('themes/frontend/assets/v1/img/workflow.png') }}" alt="">
                    <div class="row columns_margin_bottom_0">
                        <div class="col-xs-12">
                            <h4 class="text-uppercase">Ratio</h4>

                        </div>
                    </div>
                </div> -->
                <div class="row columns_padding_25">
                    <div class="col-lg-4 col-md-4 mt-5">
						
                        <div class="with_padding teaser text-center px-5 px-md-0" data-aos="fade-up" data-aos-duration="1000">
                            <!-- <div class="teaser_icon">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/daily-price-icon.png') }}" />
								
                            </div>
                                
                            <h4 class="text-uppercase"><a href="/compare-scheme?compare_price_type=scheme_scheme">Daily Price</a></h4>
                             <p class="fontsize_14">Daily updates on the current prices of different funds track a scheme's historical performance and total expense ratio among other parameters.</p> -->
                             <div class="single-features-style1-box">
                                <div class="shape-left">
                                    <img src="https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/shape-1.png" alt="">
                                </div>
                                <div class="shape-bottom">
                                    <img src="https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/shape-2.png" alt="">
                                </div>
                                <div class="counting-box">
                                    <div class="counting-box-bg" style="background-image: url(https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/counting-box-bg.png);">										
									</div>
                                    <h3></h3>
                                </div>
                                <div class="text-box">
                                    <a href="/compare-scheme?compare_price_type=scheme_scheme"><h4>Daily Price</h4></a>
                                    <!-- <h3>Fixed Returns with Peace of Mind</h3> -->
                                    <p>Daily updates on the current prices of different funds track a scheme's historical performance and total expense ratio among other parameters.</p>
                                    <div class="btn-box">
                                        <a href="/compare-scheme?compare_price_type=scheme_scheme">
                                            Compare
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>       
                           </div>   
                        </div>
                    
                    <div class="col-lg-4 col-md-4 mt-5">
                            <div class="with_padding teaser text-center" data-aos="fade-up" data-aos-duration="1000">
                                <!-- <div class="teaser_icon">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/ratio-icon.png') }}" />
                                </div>
                                
                                    <h4 class="text-uppercase"><a href="/compare-scheme?compare_ratio_type=information_ratio">Ratio</a></h4>
                                    <p class="fontsize_14">We provide investors with detailed information on various ratios such as return/risk, Sharpe, alpha and beta. This helps you get a holistic view of the fund.</p> -->
                                  <div class="single-features-style1-box">
                                <div class="shape-left">
                                    <img src="https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/shape-1.png" alt="">
                                </div>
                                <div class="shape-bottom">
                                    <img src="https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/shape-2.png" alt="">
                                </div>
                                <div class="counting-box">
                                    <div class="counting-box-bg" style="background-image: url(https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/counting-box-bg.png);">										
									</div>
                                    <h3></h3>
                                </div>
                                <div class="text-box">
                                    <a href="/compare-scheme?compare_price_type=scheme_scheme"><h4>Ratio</h4></a>
                                    <!-- <h3>Fixed Returns with Peace of Mind</h3> -->
                                    <p>We provide investors with detailed information on various ratios such as return/risk, Sharpe, alpha and beta. This helps you get a holistic view of the fund.</p>
                                    <div class="btn-box">
                                        <a href="/compare-scheme?compare_ratio_type=information_ratio">
                                            Compare
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div> 
                               
                            </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mt-5">
                            <div class="with_padding teaser text-center" data-aos="fade-up" data-aos-duration="1000">
                                <!-- <div class="teaser_icon">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/composition-icon.png') }}" />
                                </div>
                              
                                <h4 class="text-uppercase">  <a href="/compare-scheme?compare_composition_type=top_industry">Composition</a></h4>
                                    <p class="fontsize_14">Users can view the composition of their portfolios to understand the asset allocation and identify any potential rebalancing opportunities.</p>-->
                                  <div class="single-features-style1-box">
                                <div class="shape-left">
                                    <img src="https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/shape-1.png" alt="">
                                </div>
                                <div class="shape-bottom">
                                    <img src="https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/shape-2.png" alt="">
                                </div>
                                <div class="counting-box">
                                    <div class="counting-box-bg" style="background-image: url(https://st.ourhtmldemo.com/new/finbank-demo/assets/images/shapes/counting-box-bg.png);">										
									</div>
                                    <h3></h3>
                                </div>
                                <div class="text-box">
                                    <a href="/compare-scheme?compare_price_type=scheme_scheme"><h4>Composition</h4></a>
                                    <!-- <h3>Fixed Returns with Peace of Mind</h3> -->
                                    <p>Users can view the composition of their portfolios to understand the asset allocation and identify any potential rebalancing opportunities.</p>
                                    <div class="btn-box">
                                        <a href="/compare-scheme?compare_composition_type=top_industry">
                                            Compare
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div> 
                                
                            </div>
                    </div>
                </div>
            </div>

        </div>
        
            
</section>
<!-- <section class="compare_section section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="compare_titile text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Compare: Scheme, Index, Currency, Commodity...</h2>
                    <p>Specialized calculation algorithms that allow you to make the most informed decisions.</p>
                </div>
            </div>
        </div>
        <div class="row align-items-end"> -->
            <!-- <div class="col-lg-6 offset-lg-0 col-md-10 offset-md-1" data-aos="fade-up" data-aos-duration="1500">
                <div class="compare_left_sction">
                    <img src="{{ asset('themes/frontend/assets/v1/img/compare-sheme-img.png') }}" class="img-fluid" />
                </div>
            </div> -->
            <!-- <div class="col-lg-4 col-md-4">
                 <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{ asset('themes/frontend/assets/v1/img/daily-price-icon.png') }}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Daily Price</h4>
                            <p>Daily updates on the current prices of different funds track a scheme's historical performance and total expense ratio among other parameters.</p>
                            <a href="/compare-scheme?compare_price_type=scheme_scheme">Compare Now!</a>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-4">
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{ asset('themes/frontend/assets/v1/img/ratio-icon.png') }}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Ratio</h4>
                            <p>We provide investors with detailed information on various ratios such as return/risk, Sharpe, alpha and beta. This helps you get a holistic view of the fund.</p>
                            <a href="/compare-scheme?compare_ratio_type=information_ratio">Compare Now!</a>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-4">
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{ asset('themes/frontend/assets/v1/img/composition-icon.png') }}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Composition</h4>
                            <p>Users can view the composition of their portfolios to understand the asset allocation and identify any potential rebalancing opportunities.</p>
                            <a href="/compare-scheme?compare_composition_type=top_industry">Compare Now!</a>
                        </div>
                    </div>
            </div> -->
            <!-- <div class="col-lg-6 col-md-12">
                <div class="right_compare">
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{ asset('themes/frontend/assets/v1/img/daily-price-icon.png') }}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Daily Price</h4>
                            <p>Daily updates on the current prices of different funds track a scheme's historical performance and total expense ratio among other parameters.</p>
                            <a href="/compare-scheme?compare_price_type=scheme_scheme">Compare Now!</a>
                        </div>
                    </div>
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{ asset('themes/frontend/assets/v1/img/ratio-icon.png') }}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Ratio</h4>
                            <p>We provide investors with detailed information on various ratios such as return/risk, Sharpe, alpha and beta. This helps you get a holistic view of the fund.</p>
                            <a href="/compare-scheme?compare_ratio_type=information_ratio">Compare Now!</a>
                        </div>
                    </div>
                    <div class="single_right_compare d-flex align-items-start mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="right_compare_icon">
                            <img src="{{ asset('themes/frontend/assets/v1/img/composition-icon.png') }}" />
                        </div>
                        <div class="righ_compare_content ms-4">
                            <h4>Composition</h4>
                            <p>Users can view the composition of their portfolios to understand the asset allocation and identify any potential rebalancing opportunities.</p>
                            <a href="/compare-scheme?compare_composition_type=top_industry">Compare Now!</a>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- </div>
    </div>
</section> -->
<section class="money_seriously_section section">
    <div class="container">
        <div class="row">
            <div class="money_seriously_title mb-4 mb-md-5">
                <div class="col-md-12" data-aos="fade-up" data-aos-duration="1000">
                    <div class="money_seriously_title d-block d-sm-flex align-items-center">
                        <h4>Money, Seriously!!</h4>					
						
                        <p>
                            Mutual funds have become a popular investment option in recent years, as they offer the potential for higher returns than more traditional investments such as savings accounts or bonds.
                            However, merely tracking the historical returns and fund rankings will not help you choose the right fund. Here, we discuss topics such as investment objectives, levels of financial freedom, performance parameters, and how they will help you understand what to look for in a fund. We will also cover some key concepts such as risk and return, asset allocation, and diversification.

                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">		
			
			@foreach($blogResponses as $value)			
            <div class="col-md-4 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="{{ $value['img'] }}" class="img-fluid" />
                </div>
                <div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>{{ $value['title'] }}</h4>					
					<p>
                        {{ Str::limit(strip_tags($value['short_desc']), 200, '...') }} 
                    </p>
                   <a href="{{ $value['link'] }}" target="_blank">Read More</a>
                </div>
            </div> 
            @endforeach 
			
               
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="https://blog.myplexus.com/" class="money_title_btn type2">View All Articles</a>
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
                    <p data-aos="fade-up" data-aos-duration="1000">Our financial calculators can help you determine the best investment strategy for your needs taking into account your investment objective, level of financial freedom, and other performance parameters.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills justify-content-center calculator_nav_pills mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="Planner-tab" data-bs-toggle="tab" data-bs-target="#Planner" type="button" role="tab" aria-controls="Planner" aria-selected="true">Planner</button>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Performance-tab" data-bs-toggle="tab" data-bs-target="#Performance" type="button" role="tab" aria-controls="Performance" aria-selected="false">Performance</button>
                    </li> -->
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="Planner" role="tabpanel" aria-labelledby="Planner-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="calculator_inner d-md-flex d-block align-items-center-between justify-content-center w-100">
                                    <div class="single_calculator">
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="500">
                                            <a href="https://myplexus.com/calctest?cal=sip">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/lumpsum.png') }}" />
                                                <h4>SIP Planner</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="https://myplexus.com/calctest?cal=lump">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/sip.png') }}" />
                                                <h4>Lumpsum Fund Planner</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="https://myplexus.com/calctest?cal=retire">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon2.png') }}" />
                                                <h4>Retirement Planner</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="{{ route('web.calculators') }}?tab=risk-tol-eval">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon4.png') }}" />
                                                <h4>Risk Tolerance Evaluator</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
										<span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="https://myplexus.com/calctest?cal=inflation">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon1.png') }}" />
                                                <h4>Inflation Calculator</h4>
                                            </a>
                                        </div>
                                    </div>
									<div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="500">
                                            <a href="https://myplexus.com/calctest?cal=pills-goal1">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/calculator-icon2.png') }}" />
                                                <h4>Goal Planner</h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="tab-pane fade" id="Performance" role="tabpanel" aria-labelledby="Performance-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="calculator_inner d-md-flex d-block align-items-center-between justify-content-center w-100">
                                    <div class="single_calculator">
                                        <span class="right_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="500">
                                            <a href="{{ route('web.calculators') }}?tab=pills-monthly1">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/lumpsum.png') }}" />
                                                <h4>Lumpsum Calculator</h4>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single_calculator have_before">
                                        <span class="left_circle d-none d-sm-block"></span>
                                        <div data-aos="zoom-in" data-aos-duration="1000">
                                            <a href="{{ route('web.calculators') }}?tab=sip-planner">
                                                <img src="{{ asset('themes/frontend/assets/v1/img/sip.png') }}" />
                                                <h4>SIP Calculator</h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
                        <!-- <p>Investing in the equity market is a lot like the voyage of discovery that Alice undertook. With patience and discipline it could be the wondrous garden that Alice saw but one has to pass through the door no bigger than a rat hole to really make it work. But the real decision making comes in if we have to choose where to put in the money. Stay on top of the latest happenings in your investments with this helpful newsletter. You'll learn about price updates, breaking news and views & recommendations delivered right to you—every day!</p> -->
                        <!--<a href="#" class="money_title_btn type2">View All Funds</a>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
			@if(count($fndWtchMdl) > 0)
            @php $i =1; @endphp
            @if($i <= 2)
                @foreach($fndWtchMdl as $newfndWtchMdl)
				<div class="col-md-6 mb-4" data-aos="fade-up" data-aos-duration="{{500*$i}}">
					<div class="money_left_sec">
						<div class="fund_watch_home_sec_single_img">
                        <img src="{{ env('ADMIN_SITE') }}/assets/images/{{ $fndWtchMdl[0]->logo }}" />
						</div>
					</div>
					<div class="money_right_section">
						@php
                           $fid =base64_encode($newfndWtchMdl->fundDetails->fund_code);
							
                         @endphp
						<h4><a href="{{ url('new-fundwatch') }}/{{$fid}}" target="_blank">{{ $newfndWtchMdl->fundDetails->fund_name }}</a></h4>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
							the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
							of type and scrambled it to make a type specimen book.</p>
						<a href="#">View More Details</a>-->

					</div>
				</div>
                @endforeach
            @endif    
                <?php /* ?>
				<div class="col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
					<div class="money_left_sec">
						<div class="fund_watch_home_sec_single_img">
                        <img src="{{ env('ADMIN_SITE') }}/assets/images/{{ $fndWtchMdl[1]->logo }}" />
						</div>
					</div>
					<div class="money_right_section">
						@php
                           $sid =base64_encode($fndWtchMdl[1]->fundDetails->fund_code);
                         @endphp
						<h4><a href="{{ url('new-fundwatch') }}/{{$sid}}" target="_blank">{{ $fndWtchMdl[1]->fundDetails->fund_name }}</a></h4>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
							the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
							of type and scrambled it to make a type specimen book.</p>
						<a href="#">View More Details</a>-->
					</div>
				</div>
                <?php */ ?>
            @else
            <p style="color: white; font-weight:bold;">No Data Found</p>
			@endif
			<div class="col-md-12 text-center">
            @if(count($fndWtchMdl) > 0)
                <a href="{{ url('new-fundwatch-list') }}" class="money_title_btn type2">View More</a>
            @endif
            </div>
        </div>
        <!-- <div class="row mt-4" data-aos="fade-up" data-aos-duration="500">
            <div class="col-md-12 text-center">
                <a href="#" class="money_title_btn type2">View All Funds</a>
            </div>
        </div> -->
    </div>
</section>
<section class="Paathshaala_NFO section">
    <div class="patshala-new">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 patshala-left pl-0">
                    <h3>Paathshaala</h3>
                        <div class="patshala-new-lft br-5 ml-3">
                            <ul>
                                <li><a href="/mutual-fund-taxation">Mutual Fund Taxation</a></li>
                                <li><a href="/mutual-fund-classifications">Mutual Fund Classifications</a></li>
                                <li><a href="/know-the-ratio">Know The Ratio</a></li>
                                <li><a href="/#">Thoughts and Opinion on Funds</a></li>
                                <li><a href="/mutual-fund-dictionary">Mutual Fund Dictionary</a></li>
                            </ul>
                        </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 patshala-right pl-0">
                    <h3>NFO Monitor</h3>
                    <div class="patshala-new-rgt ml-3">
                        <ul>
                            @foreach ($nfoMdl as $key => $val)
                            <li><a href="{{url('/nfo-monitor').'/'.$val->no_id}}">{{$val->fund_name}}</a></li>
                            @endforeach							
							 <!--<li><a href="#">SBI Bluechip Fund</a></li> -->
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section class="money_seriously_section fund_watch_setion_home nfo_monitor_home_section section">
    <div class="container">
        <div class="row">
            <div class="calculator_title text-center mb-4">
                <div class="col-md-12" data-aos="fade-up" data-aos-duration="1000">
                    
                    
                        <h4>NFO Monitor</h4>
                        <p>If you're interested in investing in a new mutual fund, it's important to track the NFO (new fund offer) so you don't miss the subscription period. With our NFO monitor, you can set up alerts and get all the information you need to make an informed decision about whether or not to invest. </p>
                   
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            @foreach ($nfoMdl as $key => $val)
            <div class="col-md-4 mb-4">
                <div class="money_left_sec" data-aos="fade-up" data-aos-duration="500">
                    @if ($val->media != null)
                    <div class="fund_watch_home_sec_single_img">
                        <img src="{{ $BlogImagePath . $val->media->path }}" alt="{{ $val->media->title }}" />
                    </div> 
                    @endif
                </div>
                <a href="{{url('/nfo-monitor').'/'.$val->no_id}}"><div class="money_right_section" data-aos="fade-up" data-aos-duration="1000">
                    <h4>{{$val->fund_name}}</h4>
                     <p>{{$val->objective}}</p> 
                    
                </div></a>
            </div>
            
            @endforeach
            <div class="col-md-4 mb-4">
                <div class="money_left_sec aos-init aos-animate" data-aos="fade-up" data-aos-duration="500">
                                        
                                    </div>
                    <a href="https://new.myplexus.com/nfo-monitor/247"> <div class="money_right_section aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                    <h4>HDFC NIFTY Midcap 150 ETF</h4>
                    
                </div></a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="{{ route('web.nfomonitor.list') }}" class="money_title_btn ">View All Monitor</a>
            </div>
        </div>
    </div>
</section> -->

<!-- <section class="fund_expert_section section">
  
    <div class="container">
        <div class="row align-items-center meet_fund_expert">
            <div class="col-md-4">
                <img class='w-100' src="{{ asset('themes/frontend/assets/v1/img/fund_expert.png') }}">
            </div>
            <div class="col-md-8 px-5">
				<a href="/fund-man-details">
                <div class="fund_man_expert_home" data-aos="fade-up" data-aos-duration="500">
                    <h2>Meet The Fund Man</h2>
                    <h4>Vihang Naik</h4>
                    <p>Fund Manager - Equity Investments<br>L&T Investment Management Limited</p>
                    
                </div>
				</a>
            </div>
        </div>
    </div>
</section> -->

<!-- .container -->
</section>
    <!-- <section class="compare_section section">
        <div class="container">
            <div class="row">
                <div class="single-features-style1-box mb-4">
                    <div class="col-md-12 aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <div class="calculator_title text-center">
                            <h4>Experts Interviews</h4>					
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center expt-row">		
                
                <div class="col-fund mb-4">
                    <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('themes/frontend/assets/v1/img/vihangNaik.jpg') }}" class="img-fluid">
                    </div>
                    <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                        <a href="/fund-man-details"><h4>Vihang Naik</h4></a>				
                        <p>
                            Chief Investment Officer <br>
                            Baroda Asset Management India Limited
                        </p>
                    
                    </div>
                </div> 		
                <div class="col-fund mb-4">
                    <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('themes/frontend/assets/v1/img/aniruddhaNaha.jpg') }}" class="img-fluid">
                    </div>
                    <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                        <a href="/fund-man-details/aniruddha-naha"><h4>Aniruddha Naha</h4></a>				
                        <p>
                            Director & Senior Fund Manager <br>
                            PGIM Investments
                        </p>
                    
                    </div>
                </div>   
                            
                <div class="col-fund mb-4">
                    <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('themes/frontend/assets/v1/img/sanjayChawla.jpg') }}" class="img-fluid">
                    </div>
                    <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                        <a href="/fund-man-details/sanjay-chawla"><h4>Sanjay Chawla</h4></a>				
                        <p>
                            Chief Investment Officer <br>
                            Baroda Asset Management India Limited
                        </p>
                    
                    </div>
                </div> 
                            
                <div class="col-fund mb-4">
                    <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('themes/frontend/assets/v1/img/shridattaBhandwaldar.jpg') }}" class="img-fluid">
                    </div>
                    <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                        <a href="https://www.myplexus.com/meet-the-fund-man/shridatta-bhandwaldar"><h4>Shridatta Bhandwaldar</h4></a>				
                        <p>
                            Head Equities <br>
                            Canara Robeco Mutual Fund
                        </p>
                    
                    </div>
                </div> 
                <div class="col-fund mb-4">
                    <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('themes/frontend/assets/v1/img/shreyasDevalkar.jpg') }}" class="img-fluid">
                    </div>
                    <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                        <a href="/fund-man-details/shreyas-devalkar"><h4>Shreyas Devalkar</h4></a>				
                        <p>
                            Fund Manager <br>
                            Axis Mutual Fund
                        </p>
                    
                    </div>
                </div> 
                
                
            </div>
       
        </div>
    </section> -->
    <section class="compare_section section">
        <div class="container">
            <div class="row">
                <div class="single-features-style1-box mb-4">
                    <div class="col-md-12 aos-init" data-aos="fade-up" data-aos-duration="1000">
                        <div class="calculator_title text-center">
                            <h4>Experts Interviews</h4>					
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="2000">
                    <div class="MultiCarousel-inner">
                        <div class="item">
                            <div class="pad15">
                                <div class="money_left_sec car-img">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/vihangNaik.jpg') }}" class="img-fluid">
                                </div>
                                <div class="money_right_section expertHeight">	
                                    <a href="/fund-man-details"><h4>Vihang Naik</h4></a>				
                                    <p>
                                        Chief Investment Officer <br>
                                        Baroda Asset Management India Limited
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="pad15">
                                <div class="money_left_sec car-img" >
                                    <img src="{{ asset('themes/frontend/assets/v1/img/aniruddhaNaha.jpg') }}" class="img-fluid">
                                </div>
                                <div class="money_right_section expertHeight ">	
                                    <a href="/fund-man-details/aniruddha-naha"><h4>Aniruddha Naha</h4></a>				
                                    <p>
                                        Director & Senior Fund Manager <br>
                                        PGIM Investments
                                    </p>
                                
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="pad15">
                                <div class="money_left_sec car-img">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/sanjayChawla.jpg') }}" class="img-fluid">
                                </div>
                                <div class="money_right_section expertHeight">	
                                    <a href="/fund-man-details/sanjay-chawla"><h4>Sanjay Chawla</h4></a>				
                                    <p>
                                        Chief Investment Officer <br>
                                        Baroda Asset Management India Limited
                                    </p>
                                
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="pad15">
                                <div class="money_left_sec car-img">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/shridattaBhandwaldar.jpg') }}" class="img-fluid">
                                </div>
                                <div class="money_right_section expertHeight">	
                                    <a href="/fund-man-details/shridatta-bhandwaldar"><h4>Shridatta Bhandwaldar</h4></a>				
                                    <p>
                                        Head Equities <br>
                                        Canara Robeco Mutual Fund
                                    </p>
                                
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="pad15">
                                <div class="money_left_sec car-img">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/shreyasDevalkar.jpg') }}" class="img-fluid">
                                </div>
                                <div class="money_right_section expertHeight aos-init">	
                                    <a href="/fund-man-details/shreyas-devalkar"><h4>Shreyas Devalkar</h4></a>				
                                    <p>
                                        Fund Manager <br>
                                        Axis Mutual Fund
                                    </p>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousal_btn leftLst"><</button>
                    <button class="carousal_btn rightLst">></button>
                </div>
            </div>
        
        </div>
    </section>

<section class="testimonial_section_home section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="calculator_title text-center">
                    <h4 data-aos="fade-up" data-aos-duration="500">Testimonials</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">Don’t just take our word for it.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="testimonial_inner">
                    <div class="testimonial_slider">
                        <div class="single_testimonila_slide">
                            <div class="single_slider_message">
                                <img src="{{ asset('themes/frontend/assets/v1/img/quote.png') }}" />
                                <p>As and when this ongoing crisis settles, I can see a shift happening among smart advisors and clients from chasing returns to giving more attention to understanding, evaluating and monitoring RISK. Afterall Returns and Risk are two sides of the same coin. Internationally, many successful advisors promote themselves as risk managers first and then as investment managers to their clients. Prasun is a rare professional who has persevered in this science for many years now and myplexus.com is a platform that continues to evolve in helping bring all aspects of risk to clients and advisors alike. We all see returns but have you seen a simple visual representation of quality of returns ? Ultimately the choices you make, the routines you change and the habits you make or break will define if you have stepped up from any challenge. Make a habit of being more risk aware. myplexus.com is an easy place to start.

                                </p>
                            </div>
                            <div class="testimonila_user_group_sec d-flex align-items-center justify-content-center">
                                <div class="user_img_group">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/1647351746-ajit.jpg') }}" />
                                </div>
                                <div class="user_details_group">
                                    <h4>Ajit Menon</h4>
                                    <p>Chief Executive Officer, </p>
                                    <p>PGIM India Asset Management</p>
                                </div>
                            </div>
                        </div>
                        <div class="single_testimonila_slide">
                            <div class="single_slider_message">
                                <img src="{{ asset('themes/frontend/assets/v1/img/quote.png') }}" />
                                <p>When you marry deep industry experience with insights gained over a long tenure as an advisor to investors is born www.myplexus.com. I would highly recommend it for anyone with an interest in mutual funds. With easy to understand layout, insights via a blog, calculators and superb research tools - it has something for both the lay investor or the seasoned one. Prasunjit's ability to articulate economy and mutual fund industry issues provides wonderful engagement for everyone on the website. His desire to expand the reach of mutual funds to newer segments of the market will ensure that this website will continue to grow in popularity.
                                </p>
                            </div>
                            <div class="testimonila_user_group_sec d-flex align-items-center justify-content-center">
                                <div class="user_img_group">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/1647351746-Absm.jpg') }}" />
                                </div>
                                <div class="user_details_group">
                                    <h4>Arun Prasad G</h4>
                                    <p>Deputy Chief Executive Officer, </p>
                                    <p>BOI AXA Investment Managers Pvt. Ltd.</p>
                                </div>
                            </div>
                        </div>
						<div class="single_testimonila_slide">
                            <div class="single_slider_message">
                                <img src="{{ asset('themes/frontend/assets/v1/img/quote.png') }}" />
                                <p>I met Prasunjit about 5 years ago and we were scheduled for a 30 minutes meeting, but his passion and eagerness to understand the MF business stretched it to a couple of hours. But I realised that there is someone rising in the East who would change the paradigm of Research and help the MF Industry.My Plexus .com is amongst the best in class platforms that provides the finest research on Mutual Funds in the industry. myplexus.com is amongst the best in class platforms that provides the finest research on Mutual Funds in the industry. The type of research available is exhaustive with the latest data, and hence, can cater to various segments of clients & intermediaries. The Platform has used some innovative and in-house built quantitative models which have been successful in predictive analysis. And even with the comprehensive tools and information the platform is very user friendly and easy to navigate. I see myplexus.com emerging amongst the Top Research platforms in the country and wish them all the very best.
                                </p>
                            </div>
                            <div class="testimonila_user_group_sec d-flex align-items-center justify-content-center">
                                <div class="user_img_group">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/1647351746-saugataC.jpg') }}" />
                                </div>
                                <div class="user_details_group">
                                    <h4>Saugata Chatterjee</h4>
                                    <p>Co- Chief Business Officer, </p>
                                    <p>Nippon India Mutual Fund</p>
                                </div>
                            </div>
                        </div>
						<div class="single_testimonila_slide">
                            <div class="single_slider_message">
                                <img src="{{ asset('themes/frontend/assets/v1/img/quote.png') }}" />
                                <p>myplexus.com provides data and analysis like no other platform. It is a very evolved and contemporary platform to evaluate fund performance. The comparisons between funds that it provides by using exhaustive statistical tools lend to it the credibility that investors and advisors will certainly benefit from. Certain features and tools myplexus.com utilises provide insights unmatched anywhere else.

                                </p>
                            </div>
                            <div class="testimonila_user_group_sec d-flex align-items-center justify-content-center">
                                <div class="user_img_group">
                                    <img src="{{ asset('themes/frontend/assets/v1/img/1647351746-waqur.jpg') }}" />
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
                    <p data-aos="fade-up" data-aos-duration="1000">We provide a range of services for financial advisers, including access to our fund research, performance data and analytical tools that will help you make the best investment decisions for your clients.</p>
                    <a data-aos="fade-up" data-aos-duration="1500" href="#" class="money_title_btn  type2 ms-0">Discover</a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <div class="research_right_sec">
                    <div class="research_row d-md-block d-lg-flex d-block align-items-center mb-40">
                        <div class="single_reserch d-flex align-items-center text-end mr-40 gb-right" data-aos="fade-up" data-aos-duration="1000">
                            <h4>Premium screens on various themes</h4>
                            <div class="research_icon">
                                <img src="{{ asset('themes/frontend/assets/v1/img/research1.png') }}" />
                            </div>
                        </div>
                        <div class="single_reserch d-flex align-items-center" data-aos="fade-down" data-aos-duration="1000">
                            <div class="research_icon">
                                <img src="{{ asset('themes/frontend/assets/v1/img/research2.png') }}" />
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
                                <img src="{{ asset('themes/frontend/assets/v1/img/research3.png') }}" />
                            </div>
                        </div>
                        <div class="single_reserch d-flex align-items-center" data-aos="fade-down" data-aos-duration="1000">
                            <div class="research_icon">
                                <img src="{{ asset('themes/frontend/assets/v1/img/research4.png') }}" />
                            </div>
                            <h4>Premium and customizable filters</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="patshala-sec" id="askExpert">
    <div class="container-fluid">
        <div class="row">
            <h3 data-aos="fade-up" data-aos-duration="500" class="aos-init aos-animate">Ask An Expert</h3>
            <p data-aos="fade-up" data-aos-duration="1000" class="aos-init aos-animate text-center">We bring a wealth of expereince and know-how to the table.</p>
            <div class="col-lg-4 col-md-4 col-sm-12 patshala">
                                
                <div class="patshala-lft-wrap d-flex">
                    <div class="expert-says border-s box-shadow bg-gry br-5">
                        <div class="expert-data">
                            <div class="exp-profile">
                                <img src="https://www.myplexus.com/storage/Vikash-dp-1651751729.jpg/user/78/78/100" alt="Vikash" title="Vikash">                                                                                                                                <span class="qName">Vikash Kumar </span>
                            </div>
                            <!-- <div class="exp-btn">
                                <a href="https://www.myplexus.com/ask-an-expert">View All</a>
                            </div> -->
                            <div class="clear"></div>
                        </div>
                        <div class="expert-para">
                            <p><span class="quote-1">"</span>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly ...<span class="quote-2">"</span></p>
                        </div>
                        
                    </div>
                                    </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 patshala">
                <div class="patshala-lft-wrap d-flex">
                    <div class="expert-says border-s box-shadow bg-gry br-5">
                        <div class="expert-data">
                            <div class="exp-profile">
                                <img src="https://www.myplexus.com/storage/Vikash-dp-1651751729.jpg/user/78/78/100" alt="Vikash" title="Vikash">                                                                                                                                <span class="qName">Vikash Kumar </span>
                            </div>
                            <!-- <div class="exp-btn">
                                <a href="https://www.myplexus.com/ask-an-expert">View All</a>
                            </div> -->
                            <div class="clear"></div>
                        </div>
                        <div class="expert-para">
                            <p><span class="quote-1">"</span>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly ...<span class="quote-2">"</span></p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 patshala">
                <div class="patshala-lft-wrap d-flex">
                    <div class="expert-says border-s box-shadow bg-gry br-5">
                        <div class="expert-data">
                            <div class="exp-profile">
                                <img src="https://www.myplexus.com/storage/Vikash-dp-1651751729.jpg/user/78/78/100" alt="Vikash" title="Vikash">                                                                                                                                <span class="qName">Vikash Kumar </span>
                            </div>
                            <!-- <div class="exp-btn">
                                <a href="https://www.myplexus.com/ask-an-expert">View All</a>
                            </div> -->
                            <div class="clear"></div>
                        </div>
                        <div class="expert-para">
                            <p><span class="quote-1">"</span>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly ...<span class="quote-2">"</span></p>
                        </div>
                        
                    </div>
                </div>
            </div>
           
        </div>
        <div class="row">
            <div class="col-md-12 mt-3 text-center">		
                <button type="button" class="money_title_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Ask Your Query Here
                </button>
			</div>
        </div>
    </div>
</section>
<!-- <section class="ask_the_expert_sec section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="calculator_title text-center">
                    <h4 data-aos="fade-up" data-aos-duration="500">Ask The Experts</h4>
                    <p data-aos="fade-up" data-aos-duration="1000">We bring a wealth of expereince and know-how to the table.</p>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="ask_expert_slider">
                    <div class="single_ask_expert">
						<div class="single_ask_footer d-flex align-items-center">
                            <span></span> <h4>Vikash Kumar</h4>
                            
                        </div>
						<br>
                        <img src="{{ asset('themes/frontend/assets/v1/img/quote-green.png') }}" />
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                            alteration in some form, by injected humour, or randomised words which don't look even slightly
                            ...</p>
                        
                    </div>

                    <div class="single_ask_expert">
						<div class="single_ask_footer d-flex align-items-center">
                            <span></span> <h4>Vikash Kumar</h4>
                            
                        </div>
						<br>
                        <img src="{{ asset('themes/frontend/assets/v1/img/quote-green.png') }}" />
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                            alteration in some form, by injected humour, or randomised words which don't look even slightly
                            ...</p>
                        
                    </div>
                    <div class="single_ask_expert">
						<div class="single_ask_footer d-flex align-items-center">
                            <span></span> <h4>Vikash Kumar</h4>
                            
                        </div>
						<br>
                        <img src="{{ asset('themes/frontend/assets/v1/img/quote-green.png') }}" />
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                            alteration in some form, by injected humour, or randomised words which don't look even slightly
                            ...</p>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <a href="{{ route('web.ask-expert') }}" class="money_title_btn">Ask An Expert</a>
            </div>
        </div>
    </div>
</section> -->
<!-- <section class="pathshaala_section section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="calculator_title text-center" data-aos="fade-up" data-aos-duration="500">
                   <h4 data-aos="fade-up" data-aos-duration="500">Paathshaala</h4>
                </div>
				
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-4 mb-4">
               
                <a href="#">
                    <div class="pathshaala_section_card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                        <h4>Mutual Fund Taxation</h4>
                   
                    
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
               
                <a href="#">
                    <div class="pathshaala_section_card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                        <h4>Mutual Fund Classifications</h4>
                   
                    
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
               
                <a href="#">
                    <div class="pathshaala_section_card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                        <h4>Know The Ratio</h4>
                   
                    
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
               
                <a href="#">
                    <div class="pathshaala_section_card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                        <h4>Thoughts and Opinion on Funds</h4>
                   
                    
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
               
               <a href="#">
                   <div class="pathshaala_section_card aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                       <h4>Mutual Fund Dictionary</h4>
                  
                   
                   </div>
               </a>
           </div>
        </div>
    </div>
</section> -->
<section class="cta_section section">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-5">
                <div class="fund_man_expert_home" data-aos="fade-up" data-aos-duration="500">
                    <h2>Performance Synopsis</h2>
                    <p>You can access performance data for all of our funds on our website. In addition,
                        we also offer a range of analytical tools that can help you evaluate a fund's performance and choose the right one for your clients.</p>
                    <!-- <a href="{{ route('web.login') }}" class="money_title_btn type2 me-3 ms-0">Login</a> -->
                    <!-- <a href="{{ route('web.investor-signup') }}" class="money_title_btn type2">Register</a> -->
                    <a href="{{ route('user.user_login') }}" class="money_title_btn type2 me-3 ms-0">Login</a>
                    <a href="{{ route('user.registration') }}" class="money_title_btn type2">Register</a>
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
            <div class="col-md-7 col-lg-5">
                <div class="fund_man_expert_home" data-aos="fade-up" data-aos-duration="500">
                    <h2>Know Your Scheme</h2>
                    <p>When considering schemes, it's vital to know the risk levels, returns, and other parameters, like asset allocation and periodic rebalancing, for the respective fund categories.</p>
                    <a href="{{ route('web.know.your.scheme') }}" class="money_title_btn ms-0 type2">Get Started</a>
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
                            <img src="{{ asset('themes/frontend/assets/v1/img/client1.jpg') }}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{ asset('themes/frontend/assets/v1/img/client2.jpg') }}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{ asset('themes/frontend/assets/v1/img/client3.jpg') }}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{ asset('themes/frontend/assets/v1/img/client4.jpg') }}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{ asset('themes/frontend/assets/v1/img/client5.jpg') }}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{ asset('themes/frontend/assets/v1/img/client6.jpg') }}" />
                        </div>
                        <div class="single_slider_seen">
                            <img src="{{ asset('themes/frontend/assets/v1/img/client1.jpg') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="press-release">
    <div class="container">
        <div class="row justify-content-center align-items-center press-header">
            <div class="col press-lft">
                <h3>In The News</h3>
            </div>
            
        </div>
        <div class="row news-blocks">
            <div class="col-lg-4 col-md-md-4 col-sm-12">
                <div class="news-inner-block">
                    <a href="https://utiswatantra.utimf.com/video/how-mfs-can-help-students-working-professionals-to-achieve-financial-goals/" target="_blank"><img src="https://www.myplexus.com/storage/news/nws-1652244031-et-now-1.jpg" class="img-fluid" alt="How MFs can help students &amp; working professionals to achieve financial goals" title="How MFs can help students &amp; working professionals to achieve financial goals">                                                                        <span>How MFs can help students &amp; working professionals to achieve financial goals</span></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-md-4 col-sm-12">
                <div class="news-inner-block">
                    <a href="https://www.youtube.com/watch?v=TxcGBzLRriI" target="_blank"><img src="https://www.myplexus.com/storage/news/nws-1652244003-you-tube-1.jpg" class="img-fluid" alt="Thoughts on the pathway for #FinancialFreedom" title="Thoughts on the pathway for #FinancialFreedom">                                                                        <span>Thoughts on the pathway for #FinancialFreedom</span></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-md-4 col-sm-12">
                <div class="news-inner-block">
                    <a href="https://www.businesstoday.in/moneytoday/mutual-fund/rushing-to-lose/story/7205.html" target="_blank"><img src="https://www.myplexus.com/storage/news/nws-1652243948-bs-1.jpg" class="img-fluid" alt="How can the well researched picks you found attractive?" title="How can the well researched picks you found attractive?">                                                                        <span>How can the well researched picks you found attractive?</span></a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center press-header">
            <div class="col-md-12 mt-3 text-center">
				<a href="/in-the-news" class="money_title_btn">View All</a>
			</div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ask Your Query</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="phone">Phone No.:</label>
                <input type="number" pattern="[0-9]{10}" class="form-control" name="phone" id="phone">
            </div>
            <div class="form-group">
                <label for="query">Your Query:</label>
                <input type="text" class="form-control" name="query" id="name">
            </div>
            
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <button type="submit" class="btn money_title_btn">Submit</button>
      </div>
    </div>
  </div>
</div>
@stop

@push('scripts')
<script>
	
	function formatDate() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}
	
    function performance(pval, plabel)
    {
        //console.log(pval, plabel);
		
		if(plabel == 'fund-performance' && pval != "")
		{
				window.location.href = 'fund-performance?fund_code='+encodeURIComponent(pval);
		}
		
		if(plabel == 'performance-snapshot' && pval != "")
		{
			window.location.href = 'performance-snapshot?fund_type_id='+pval+'&type=weekly&report_category=return&date='+formatDate();
		}
		
		if(plabel == 'risk' && pval != "")
		{
			let risk_val = $('#risk-management option:selected').text();		
			
			window.location.href = 'monthly-ranking?fund_classification='+encodeURIComponent(risk_val);
		}
		/*if(value){
            
        }*/
    }
</script>
    <script>
    $('.select2').select2();
		
		$(function() { 
		
			loadNews();		
		
		});
		
		function loadNews()
{
    $.ajax({
            url: "{{ route('web.get.news') }}",
            type: "get",
            dataType: 'json',
            success: function(data) {
                $("#loadNewsWrapper").removeClass('hide');
				//console.log(data);
				 //$(".her_banner_left_slide").html(data);
				let html = "";
				if(data.data.length >= 1)
				{
					for(var i=0; i<data.data.length; i++)
					{						
						html += data.data[i];						
					}
					
				}
				console.log(html);
                $(".her_banner_left_slide").html(html);
				$('.her_banner_left_slide').slick('refresh');
				//$('.her_banner_left_slide').slick('reinit');
            },
            error: function() {
                $("#loadNewsWrapper").addClass('hide');
            }
        });
}
		
		
</script>
<script>
$(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();




    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});
</script>
@endpush
