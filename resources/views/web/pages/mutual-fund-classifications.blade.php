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
                    <h4>{!! nl2br($dataArr['title']) !!}</h4>
                    <p>The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="compare_scheme">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="comp_schem_bdr mb-4">
                    <div class="plan_faq mt-0">
                        <div class="faq_title">
                            <h4>Debt Funds</h4>
                        </div>
                        <div class="single_faq_calc">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc1.png')}}" />
                                        <h4>Liquid & Money Market Funds</h4>
                                        <p>A money market funds invest predominantly in highly liquid money market and debt securities such as treasury bills, commercial paper, certificate of deposit etc. Liquid funds have a maturity period of 91 days. Money market funds have a maturity period of 1 year.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc2.png')}}" />
                                        <h4>Income Funds</h4>
                                        <p>Income Funds mainly focus on generating regular income by investing in high dividend generating stocks, corporate bonds, government securities etc. SEBI classifies income funds as those debt funds whose Macaulay duration is 4 years and more. </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc3.png')}}" />
                                        <h4>Fixed Maturity Plans</h4>
                                        <p>Fixed Maturity Plans are closed-ended debt fund which comes with fixed lock-in period and limited investment window. Investor can only invest in such securities during NFO (new fund offering). The tenure of an FMP may range from 30days to 60 months.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc4.png')}}" />
                                        <h4>Capital Protection Oriented Fund</h4>
                                        <p>Capital Protection-Oriented Funds aim to protect investor’s capital. The minimum debt exposure is fixed at 80% which manages to generate 100% of the principal invested and the remaining 20% comprising equity manages to generate an upside to the portfolio.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc5.png')}}" />
                                        <h4>Interval Funds</h4>
                                        <p>Interval Fund is a mutual fund wherein the fund house allows to purchaseor sell the units only during specified transaction periods (STPs) at predetermined intervals.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc6.png')}}" />
                                        <h4>Multiple Yield Fund</h4>
                                        <p>Multiple Yield Funds are Hybrid Debt-Oriented Funds that invests predominantly in debt instruments and to some extent in dividend-yielding equities.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc7.png')}}" />
                                        <h4>Short-Term Fund</h4>
                                        <p>Short-Term Debt Funds primarily invest in debt instruments with shorter maturity or duration (1 to 3 years).
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc8.png')}}" />
                                        <h4>Floating Rate Funds</h4>
                                        <p>A Floating Rate Fund invests in bonds and debt instruments whose interest payments fluctuate with an underlying interest rate level. </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc9.png')}}" />
                                        <h4>Gilt Funds</h4>
                                        <p>Gilt Funds only invest in fixed-interest generating securities issued by the central and state government for various tenures.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc10.png')}}" />
                                        <h4>Dynamic Bond Fund</h4>
                                        <p>Dynamic Bond Funds are a class of debt mutual fund that alter allocations between short-term and long-term bonds based on interest rate movement.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc11.png')}}" />
                                        <h4>Monthly Income Plan</h4>
                                        <p>Monthly Income Plan invests in a combination of debt and equity securities. It invests pre-dominantly in debt securities and 15-25% in equities.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="single_classification">
                                        <img src="{{asset('themes/frontend/assets/v1/img/mfc12.png')}}" />
                                        <h4>Hybrid Debt</h4>
                                        <p>Monthly Income Plan invests in a combination of debt and equity securities. It invests pre-dominantly in debt securities and 15-25% in equities.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="comp_schem_bdr mb-4">
                    <div class="plan_faq mt-0">
                        <div class="faq_title">
                            <h4>Other Mutual Funds</h4>
                        </div>
                        <div class="single_faq_calc">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single_other_fund d-flex align-items-center justify-content-between">
                                        <p><i class="ph-file-pdf"></i> Hybrids Funds</p>
                                        <span><a href="#"><i class="ph-download-simple"></i></a></span>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="single_other_fund d-flex align-items-center justify-content-between">
                                        <p><i class="ph-file-pdf"></i> Mahindra Manulife Flexi Cap Yojana</p>
                                        <span><a href="#"><i class="ph-download-simple"></i></a></span>
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
{{-- <div class="mutual-f-taxation mutual-f-class bg-gry d-none">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 col-md-5 col-sm-12 mutual-f-class-lft">
                <h3>{{ $fundClsMdl->title }}</h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mutual-f-class-rgt">
                @if(count($fundClsListMdl) > 0)
                <ul class="nav nav-tabs">
                    @foreach($fundClsListMdl as $key => $record)
                    <li {{ ($record->fc_id == $fundClsMdl->fc_id)?'class=active':'' }}>
                        <a href="{{ route('web.mutualfundclassifications', $record->fc_id) }}" {{ ($record->fc_id == $fundClsMdl->fc_id)?'class=active':'' }}>{{ $record->title }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div> --}}
{{-- @if($fundClsMdl->file)
<div class="mutual-fund-pdf-wrap">
    <div class="container">
        <div class="inner-pdf-wrap br-5 border-s box-shadow">
            <embed src="{{ $defDataArr['media_folder'].$fundClsMdl->file }}" type="application/pdf" width="100%" height="500px">
        </div>
    </div>
</div>
@endif --}}
{{-- @include('themes.frontend.includes.patshala-newsletter') --}}
@stop