@extends('web.layout.app')
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
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif

@section('vue-js') @stop
@section('content')
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>NFO Monitor</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="info_monitor_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="info_monitor_inner">
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Fund Facts</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Name of Funds:</h4>
                                <label>Mahindra Manulife Flexi Cap Yojana</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Opening:</h4>
                                <label>30-july-2021</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Closing:</h4>
                                <label>13-August-2021</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Minimum Investment:</h4>
                                <label>Re. 1,000/- and in multiples of Re. 1/- thereafter </label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Plan:</h4>
                                <label>Reguler & Direct</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Options:</h4>
                                <label>Growth Dividend</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Entry Load:</h4>
                                <label>NIL</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Exit Load:</h4>
                                <label>Up to 3 monts-0.5% (Thereafter-NIL)</label>
                            </div>
                        </div>
                    </div>
                     <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Fund Stats</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Objective:</h4>
                                <label>The investment objective of the scheme is to generate long term capital appreciations by investing in a diversified portfolio or equity  and equity - related securities across market capitalization.</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Benchmark:</h4>
                                <label>Nifty 500 Index TRI</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Fund Manager:</h4>
                                <label>Manish Lodha, Fatema Pacha</label>
                            </div>
                        </div>
                    </div>
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Asset Allocation</h4>
                        </div>
                        <div class="fund_fact_wrapper asset_aloocate">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">                                   
                                <label><span>65%-100%</span> Equity</label>
                                <label><span>65%-100%</span> Money Market</label>
                            </div>
                        </div>
                    </div>
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Comparable Existing Scheme</h4>
                        </div>
                        <div class="fund_fact_wrapper Comparable_facts">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Baroda Dynamic Equity:</h4>
                                <label><span>8.68 (6M)</span> 27.55 (1Y)</label>
                            </div>
                             <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Invesco India Dynamic Equity:</h4>
                                <label><span>8.68 (6M)</span> 27.55 (1Y)</label>
                            </div>
                        </div>
                    </div>
                     <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Fund Prognosis</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Idea Distiller:</h4>
                                <label>A flexible orientation in portfolio helps in mitigating risk and provides a much higher and diversified scope for investments. And the fund house needs to plug this product gap in its portfolio.</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Fund House AAUM:</h4>
                                <label>Re. 5663.63 Crore (As on 30.06.2021)</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                 <h4>Fund House AAUM:</h4>
                                <label>Experienced above 14 years.</label>
                            </div>
                        </div>
                    </div>
                     <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Scheme DNA</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="scheme_dna d-block d-sm-flex align-items-center">
                                <div class="single_scheme_dna">
                                    <h4>UniQness</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill"></i>
                                        <i class="ph-star-fill"></i>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Return</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill"></i>
                                        <i class="ph-star-fill"></i>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Risk</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill"></i>
                                        <i class="ph-star-fill"></i>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Operability</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill active"></i>
                                        <i class="ph-star-fill"></i>
                                        <i class="ph-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title green_bg_title">
                            <h4>Oomph Factor</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <label>A fund house must have a very large bounquet of offerings with it if it has to make a mark withe their investors, sales people and advisors. There are plentty of well performing flexi funds around so why rush to buy this one. Wait for it to perfor and then perhaps the decision will be easier.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@push('style')
@endpush