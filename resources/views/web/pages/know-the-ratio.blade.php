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
                        <h4>know the ratio</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="compare_scheme">
        <div class="container">        
            <div class="comp_schem_bdr">
                <div class="optimal">
                    <h4 class="heading_opt">Optimal Portfolio Theory and Mutual Funds</h4>
                    <div class="optimal_box">                        
                        <div class="return_box">
                            <span class="return_text">Return%</span>
                            <div class="return_box_main">
                                <div class="dotted_border">
                                    <div class="dash_border"></div>
                                    <div class="main_five_box box-1" data-aos="fade-right" data-aos-duration="3000">
                                        <div class="dot_box"></div>
                                        <div class="dot_dot_text">
                                            <div class="d-flex align-items-center">
                                                <span>01</span>
                                                <p>Money Marjat or Goverment Treasury Funds will have lower risk and lower returns</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main_five_box box-2" data-aos="fade-right" data-aos-duration="2500">
                                        <div class="dot_box"></div>
                                        <div class="dot_dot_text">
                                            <div class="d-flex align-items-center">
                                                <span>02</span>
                                                <p>Investments grade corporate bond Funds</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main_five_box box-3" data-aos="fade-right" data-aos-duration="2000">
                                        <div class="dot_box"></div>
                                        <div class="dot_dot_text">
                                            <div class="d-flex align-items-center">
                                                <span>03</span>
                                                <p>Blue chip (Large Cap) Funds</p>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="main_five_box box-4" data-aos="fade-right" data-aos-duration="1500">
                                        <div class="dot_box"></div>
                                        <div class="dot_dot_text">
                                            <div class="d-flex align-items-center">
                                                <span>04</span>
                                                <p>Mid-Cap Funds</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main_five_box box-5" data-aos="fade-right" data-aos-duration="1000">
                                        <div class="dot_box"></div>
                                        <div class="dot_dot_text">
                                            <div class="d-flex align-items-center">
                                                <span>05</span>
                                                <p>Small caps funds will have highers risk and higher return potencial</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="return_btm_text">Risk & (STANDARD DEVIATION)</span>
                            <p>One examination of the relationship between portfolio returns and risk is the efficient frontier, a curve that is a part of the modern portfolio theory. The curve forms from a graph plotting return and risk indicated by volatility, which is represented by standard deviation. According to the modern portfolio theory, funds lying on the curve are yielding the maximum return possible given the amount of volatility.</p>
                            <p>Notice that as standard deviation increases, so does the return. In the above chart, once expected returns of a portfolio reach a certain level, an investor must take on a large amount of volatility for a small increase in return. Obviously portfolios that have a risk/return relationship plotted far below the curve are not optimal as the investor is taking on a large amount of instability for a small return. To determine if the proposed fund has an optimal return for the amount of volatility acquired, an investor needs to do an analysis of the fund's standard deviation.</p>
                            <p>Note that the modern portfolio theory and volatility are not the only means investors use to determine and analyze risk, which may be caused by many different factors in the market. Not all investors therefore evaluate the chance of losses the same way - things like risk tolerance and investment strategy will affect how an investor views his or her exposure to risk.</p>     
                        </div>
                    </div>
                    <div class="rto_accordian">
                        <div class="accordion" id="accordionExample">
                            @foreach($dataArr['know_the_ratio'] as $index => $record)
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading{{$record->ktr_id}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$record->ktr_id}}" aria-expanded="true" aria-controls="collapse{{$record->ktr_id}}">
                                    {{$record->title}}
                                    <div class="acc_icon_group2">
                                        <i class="ph-plus-bold"></i>
                                        <i class="ph-minus-bold"></i>
                                    </div>
                                </button>
                              </h2>
                              <div id="collapse{{$record->ktr_id}}" class="accordion-collapse collapse {{ ($index == 0)?'show':'' }}" aria-labelledby="heading{{$record->ktr_id}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $record->description !!}
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>   
   
<div class="faq-main know-ratio-wrap d-none">
    <div class="container">
        <h3>{{ $dataArr['title'] }}</h3>
        <div class="faq-wrap">
            @if(count($dataArr['know_the_ratio']) == 0)
            <p>{{ __('message.data_not_available') }}</p>
            @else
            <div id="accordion">
                @foreach($dataArr['know_the_ratio'] as $index => $record)
                <div class="card">
                    <div class="card-header" id="heading_{{$record->ktr_id}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link{{ ($index == 0)?'':' collapsed' }}" data-toggle="collapse" data-target="#collapse_{{$record->ktr_id}}" aria-expanded="{{ ($index == 0)?'true':'false' }}" aria-controls="collapse_{{$record->ktr_id}}">{{$record->title}}</button>
                        </h5>
                    </div>
                    <div id="collapse_{{$record->ktr_id}}" class="collapse{{ ($index == 0)?' show':'' }}" aria-labelledby="heading_{{$record->ktr_id}}" data-parent="#accordion">
                        <div class="card-body">
                            @if( $record->media != null )
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-sm-12 know-ration-para">
                                    {!! $record->description !!}
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 know-ration-img">
                                    @if( $record->media['path'] )
                                    <x-img src="{{ $defDataArr['media_folder'].$record->media->path }}" alt="{{ $record->media->alt }}" title="{{ $record->media->title }}" />
                                    @endif
                                </div>
                            </div>
                            @else
                            {!! $record->description !!}
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@stop