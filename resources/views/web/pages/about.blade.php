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
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
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
                    <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels may be blood vessels (veins, apillaries) or lymphatic vessels. The nerves are typically axons outside the central nervous system.</p>
                    <p>The financial systems today are a close copy of the network of nerves. Equally complex and confounding. But myplexus.com is the ordering of this complex into a largely simplified and understandable one, in the context of the saving and investment instruments.</p>
                    <p>Source: Wikipedia https://en.wikipedia.org/wiki/Plexus</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="abt_right_img_wrapper" data-aos="fade-up" data-aos-duration="1500">
                    <img src="{{asset('themes/frontend/assets/v1/img/abt-right-img.jpg')}}" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="page_abt_second_sec" style="background: url({{asset('themes/frontend/assets/v1/img/second_abt_arrow.png')}}) #010800; background-repeat: no-repeat; background-position: left; background-size: cover">
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="second_abt_cont" data-aos="fade-down" data-aos-duration="1000">
                    <h4>The Various Metrics of Performance is Synthesised into Numbers</h4>
                    <p>Product life cycles will compress. Variations in performances will manifest itself more frequently. Risk evaluation will take centre-stage for marking the success or failure of every financial product or solution.</p>
                    <p>Unbiased, user defined statistical tools will be the bedrock for understanding performance and evaluating efficacy of funds and fund managers in delivering returns quantum, providing it consistently and most specifically managing its various risk factors within manageable levels.</p>
                    <p>But where will the technically able as well as the lay person converge to find out all this?? myplexus.com aims to be this platform. Over time, myplexus should be the most preferred option for the individual, the corporate investor, the fund professional for checking out the fund’s overview as well as technical details. In a manner that is easy, simple, structured. And UNBIASED. And USER DEFINED.</p>
                    <p>And myplexus.com will continue to evolve. With more evaluation tools. Continuously contemporize. And remain the most relevant.</p>
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
                    <p data-aos="fade-down" data-aos-duration="1500">We, at myplexus.com believe the financial intermediation and personal finance industry in India is going through the fastest evolutionary stage and in the coming days this is only going to become more hectic.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3" data-aos="fade-down" data-aos-duration="500">
                <div class="single_vison">
                    <div class="single_vison_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/vision1.png')}}" />
                    </div>
                    <h4>Return</h4>
                    <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels may be blood vessels (veins, capillaries) or lymphatic vessels.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-down" data-aos-duration="1000">
                <div class="single_vison">
                    <div class="single_vison_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/vision2.png')}}" />
                    </div>
                    <h4>Portfolio Allocation</h4>
                    <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels may be blood vessels (veins, capillaries) or lymphatic vessels.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-down" data-aos-duration="1500">
                <div class="single_vison">
                    <div class="single_vison_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/vision3.png')}}" />
                    </div>
                    <h4>Peer Comparison</h4>
                    <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels may be blood vessels (veins, capillaries) or lymphatic vessels.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-down" data-aos-duration="2000">
                <div class="single_vison">
                    <div class="single_vison_img">
                        <img src="{{asset('themes/frontend/assets/v1/img/vision4.png')}}" />
                    </div>
                    <h4>Risk Ratios</h4>
                    <p>A plexus (from the Latin for "braid") is a branching network of vessels or nerves. The vessels may be blood vessels (veins, capillaries) or lymphatic vessels.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mission_section" style="background-image: url({{asset('themes/frontend/assets/v1/img/mission-bg.jpg')}}); background-position: center; background-size: cover; background-repeat: no-repeat">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="mission_content" data-aos="fade-down" data-aos-duration="1500">
                    <h4>Our Mission</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us. However, selections and preferences are still locked in the antiquated time period returns only.</p>
                    <p>At myplexus.com we provide multiple statistical parameters, portfolio components and construction, and time frames to choose to evaluate fund performance. A better understanding leads to better product choice twhich increases our prosperity and improves our well-being.</p>
                    <p>In essence, therefore, it is our goal to provide current tools for fund performance evaluation that will help us in choosing the right savings and investment product in the mutual fund space to increase our happiness and live a more profound life.</p>
                    <p>Live better, through research!!!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="faq_section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 mb-4">
                <div class="faq_title text-center">
                    <h4 data-aos="fade-down" data-aos-duration="1500">Frequently Asked Question</h4>
                    <p data-aos="fade-down" data-aos-duration="1500">Pro membership brings exclusive and timely data at your fingertips.<br> Discover your next great investment idea quicker and easier</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="faq_inner">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What is a Mutual Fund?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Mutual fund is a mechanism for pooling money by issuing units to the investors and investing funds in securities in accordance with objectives as disclosed in offer document.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How is a mutual fund set up?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Mutual fund is a mechanism for pooling money by issuing units to the investors and investing funds in securities in accordance with objectives as disclosed in offer document.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How is the applicable NAV determined?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Mutual fund is a mechanism for pooling money by issuing units to the investors and investing funds in securities in accordance with objectives as disclosed in offer document.
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