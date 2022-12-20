@extends('web.layout.app')
@section('captcha') @stop
@section('jquery-validate') @stop
@if(isset($dataArr['meta_title']))
@section('page-title'){{$dataArr['meta_title']}}@stop
@else
@section('page-title'){{$dataArr['title']}}@stop
@endif
@if(isset($dataArr['meta_key']))
@section('meta-keywords'){{$dataArr['meta_key']}}@stop
@endif
@if(isset($dataArr['meta_descp']))
@section('meta-description'){{$dataArr['meta_descp']}}@stop
@endif
@if(isset($dataArr['image_path']))
@section('meta-image'){{$dataArr['image_path']}}@stop
@push('styles')
<style>
	.custom-banner {
		background-image: url('{{ $dataArr['image_path'] }}');
	}
</style>
@endpush
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif
@section('content')
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>FAQ</h4>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="faq_section section">
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="faq_left_filter">
                    <div class="nav nav-tabs flex-column vertical-tab" id="nav-tab" role="tablist">
                        <button class="nav-link active faq-dot-1" id="nav-living-tab" data-bs-toggle="tab" data-bs-target="#nav-living" type="button" role="tab" aria-controls="nav-living" aria-selected="true">Diversify risk, for potential rewards</button>
                        <button class="nav-link faq-dot-2" id="nav-wardrobe-tab" data-bs-toggle="tab" data-bs-target="#nav-wardrobe" type="button" role="tab" aria-controls="nav-wardrobe" aria-selected="false">Money doesn’t get locked up.It gets invested!</button>
                        <button class="nav-link faq-dot-3" id="nav-modular-tab" data-bs-toggle="tab" data-bs-target="#nav-modular" type="button" role="tab" aria-controls="nav-modular" aria-selected="false">Don’t let money go. Let it grow!</button>
                        <button class="nav-link faq-dot-4" id="nav-bedroom-tab" data-bs-toggle="tab" data-bs-target="#nav-bedroom" type="button" role="tab" aria-controls="nav-bedroom" aria-selected="false">₹ 500 se toh sirf shuruwaat hai</button>
                    </div>
                </div>


                <!-- <div class="faq_left_filter">
                    <li class="single_radio">
                        <input type="radio" id="faq1" />
                        <label for="faq1">Diversify risk, for potential rewards</label>
                    </li>
                    <li class="single_radio">
                        <input type="radio" id="faq2" />
                        <label for="faq2">Money doesn’t get locked up.It gets invested!</label>
                    </li>
                    <li class="single_radio">
                        <input type="radio" id="faq3" />
                        <label for="faq3">Don’t let money go. Let it grow!</label>
                    </li>
                    <li class="single_radio">
                        <input type="radio" id="faq4" />
                        <label for="faq4">₹ 500 se toh sirf shuruwaat hai</label>
                    </li>
                </div> -->
            </div>
            <div class="col-md-12 col-lg-8">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-living" role="tabpanel" aria-labelledby="nav-living-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            What types of mutual funds can I invest in to diversify my risk?
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Investing in a variety of mutual fund schemes is the key to diversifying
                                            your risk. Equity, debt and hybrid funds all offer different levels of risk
                                            and reward. Index funds and sector-specific funds also present opportunities
                                            for diversification.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            How can I diversify my investments for greater rewards?
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Diversifying your investments is the key to achieving greater rewards.
                                            Investing in a variety of mutual funds, such as equity, debt, hybrid and
                                            index funds, will help spread out your risk. You may also consider investing
                                            in sector-specific funds to gain exposure to particular industries or
                                            markets.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            What other factors should I consider when diversifying my investments?
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            When diversifying your investments, it is important to consider the risk associated with each type of fund. Some funds may be more volatile than others, so you need to understand the potential risks and rewards associated with each investment before making a decision.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-wardrobe" role="tabpanel" aria-labelledby="nav-wardrobe-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                            What should be considered when selecting a mutual fund?

                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            When selecting a mutual fund, you should consider the following factors:
                                            past performance, fees and expenses, investment objectives, risks involved,
                                            fund manager's track record and experience, available services and the
                                            fund’s current portfolio.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            What are some of the benefits of investing in mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            One of the biggest benefits of investing in mutual funds is that they
                                            provide diversification. By investing in a variety of stocks, bonds and
                                            other securities, you can spread out risk and increase your chances of
                                            earning a return on your investment.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                            How can i get the best returns with mutual funds?
                                        </button>
                                    </h2>
                                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            In order to get the best returns with mutual funds, you need to research and
                                            select a fund that is well-suited for your risk tolerance and investment
                                            goals using tools such as our Compare Schemes to assess the fund's
                                            performance and risk profile.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-modular" role="tabpanel" aria-labelledby="nav-modular-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                                            What is a Mutual Fund?
                                        </button>
                                    </h2>
                                    <div id="collapse7" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual fund is a mechanism for pooling money by issuing units to the
                                            investors and investing
                                            funds in securities in accordance with objectives as disclosed in offer
                                            document.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                            How is a mutual fund set up?
                                        </button>
                                    </h2>
                                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual fund is a mechanism for pooling money by issuing units to the
                                            investors and investing
                                            funds in securities in accordance with objectives as disclosed in offer
                                            document.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                            How is the applicable NAV determined?
                                        </button>
                                    </h2>
                                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual fund is a mechanism for pooling money by issuing units to the
                                            investors and investing
                                            funds in securities in accordance with objectives as disclosed in offer
                                            document.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-bedroom" role="tabpanel" aria-labelledby="nav-bedroom-tab">
                        <div class="faq_inner">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true" aria-controls="collapse10">
                                            What is a Mutual Fund?
                                        </button>
                                    </h2>
                                    <div id="collapse10" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual fund is a mechanism for pooling money by issuing units to the
                                            investors and investing
                                            funds in securities in accordance with objectives as disclosed in offer
                                            document.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                            How is a mutual fund set up?
                                        </button>
                                    </h2>
                                    <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual fund is a mechanism for pooling money by issuing units to the
                                            investors and investing
                                            funds in securities in accordance with objectives as disclosed in offer
                                            document.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                            How is the applicable NAV determined?
                                        </button>
                                    </h2>
                                    <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mutual fund is a mechanism for pooling money by issuing units to the
                                            investors and investing
                                            funds in securities in accordance with objectives as disclosed in offer
                                            document.
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



@stop
