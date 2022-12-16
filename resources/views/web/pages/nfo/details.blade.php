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
                    <h4>{{ $dataArr['title'] }}</h4>
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
                                <label>{{ $dataArr['item']['fund_name'] }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Opening:</h4>
                                <label>{{ date($dateFormat, strtotime($dataArr['item']['fund_opening'])) }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Closing:</h4>
                                <label>{{ date($dateFormat, strtotime($dataArr['item']['fund_closing'])) }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Minimum Investment:</h4>
                                <label>{{ $dataArr['item']['minimum_investment'] }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Plan:</h4>
                                <label>{{ $dataArr['item']['plan'] }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Options:</h4>
                                <label>{{ $dataArr['item']['options'] }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Entry Load:</h4>
                                <label>{{ $dataArr['item']['entry_load'] }}</label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Exit Load:</h4>
                                <label>{{ $dataArr['item']['exit_load'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="info_monitor_inner_wrapper mb-3">
                                <div class="info_title">
                                    <h4>Fund Stats</h4>
                                </div>
                                <div class="fund_fact_wrapper">
                                    <div class="single_facts mb-2">
                                        <h4>Objective:</h4>
                                     <label>{!! nl2br($dataArr['item']['objective']) !!}</label>
                                    </div>
                                    <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <h4>Benchmark:</h4>
                                        <label>{{ $dataArr['item']->indices->name }}</label>
                                    </div>
                                    <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <h4>Fund Manager:</h4>
                                        <label>{{ $dataArr['item']['fund_manager'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="info_monitor_inner_wrapper mb-3">
                                <div class="fund_fact_wrapper asset_aloocate">
                                    <h4>Asset Allocation</h4>
                                    <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <label><span>{{ $dataArr['item']['aa_col1_value'] }}</span> {{ $dataArr['item']['aa_col1_text'] }}</label>
                                        <label><span>{{ $dataArr['item']['aa_col2_value'] }}</span> {{ $dataArr['item']['aa_col2_text'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Comparable Existing Scheme</h4>
                        </div>
                        <div class="fund_fact_wrapper Comparable_facts">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>{{ $dataArr['item']['ces_row1_col1_text'] }}</h4>
                                <label>
                                    <span>
                                        {{ $dataArr['item']['ces_row1_col2_text'] }}
                                    </span>
                                    {{ $dataArr['item']['ces_row1_col3_text'] }}
                                </label>
                            </div>
                             <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>{{ $dataArr['item']['ces_row2_col1_text'] }}</h4>
                                <label>
                                    <span>
                                        {{ $dataArr['item']['ces_row2_col2_text'] }}
                                    </span>
                                    {{ $dataArr['item']['ces_row2_col3_text'] }}
                                </label>
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
                                <label>
                                    {!! nl2br($dataArr['item']['idea_distiller']) !!}
                                </label>    
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Fund House AAUM:</h4>
                                <label>
                                    {{ $dataArr['item']['fund_house_aaum'] }}
                                </label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                 <h4>Fund House AAUM:</h4>
                                <label>
                                    {{ $dataArr['item']['fund_manager_experience'] }}   
                                </label>
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
                                        @for ($i =1 ; $i <= $dataArr['item']['uniqness'] ; $i++)
                                            <i class="ph-star-fill active"></i>
                                        @endfor
                                        @for ($i =1 ; $i <= 5-$dataArr['item']['uniqness'] ; $i++)
                                            <i class="ph-star-fill"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Return</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                            @for ($i =1 ; $i <= $dataArr['item']['return'] ; $i++)
                                                <i class="ph-star-fill active"></i>
                                            @endfor
                                            @for ($i =1 ; $i <= 5-$dataArr['item']['return'] ; $i++)
                                                <i class="ph-star-fill"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Risk</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                            @for ($i =1 ; $i <= $dataArr['item']['risk'] ; $i++)
                                                <i class="ph-star-fill active"></i>
                                            @endfor
                                            @for ($i =1 ; $i <= 5-$dataArr['item']['risk'] ; $i++)
                                                <i class="ph-star-fill"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Operability</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                            @for ($i =1 ; $i <= $dataArr['item']['operability'] ; $i++)
                                                <i class="ph-star-fill active"></i>
                                            @endfor
                                            @for ($i =1 ; $i <= 5-$dataArr['item']['operability'] ; $i++)
                                                <i class="ph-star-fill"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="info_title">
                            <h4>Oomph Factor</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <label>
                                    {!! nl2br($dataArr['item']['oomph_factor']) !!}
                                </label>
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