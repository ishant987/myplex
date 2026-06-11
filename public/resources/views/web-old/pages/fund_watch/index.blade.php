@extends('web.layout.app')
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
                        <section class="pentatech_section money_seriously_section fund_watch_setion_home nfo_monitor_home_section section">
                            <div class="container">
                                @if (count($WatchDataListModel) == 0)
                                    <p>{{ __('message.data_not_available') }}</p>
                                @else
                                    @foreach ($WatchDataListModel as $key => $record)
                                        <div class="archive-wrapper">
                                            <div class="archive-title"><h3>Recent Fund Watch</h3></div>
                                            <div class="row m-0 justify-content-between align-items-center">
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="single_blog">
                                                        <div class="blog_content">
                                                            <h4>
                                                                @php
                                                                    $id =base64_encode($record['fund_code']);
                                                                @endphp
                                                                <a
                                                                    href="{{ route('web.fundwatch.index',$id )}}">
                                                                    {{ $record['fund_details']['fund_name'] }}
                                                                </a>
                                                            </h4>
                                                            @if ($record['preamble'] != '')
                                                                <p>{!! \App\Lib\Core\Useful::getShortContent(strip_tags($record['preamble']), 150) !!}</p>
                                                            @endif
                                                            <div class="post_author d-flex align-items-enter">
                                                                <div class="posted_date d-flex align-items-enter"><i
                                                                        class="ph-calendar-blank-light"></i>
                                                                    {{ date($dateFormat, strtotime($record['updated_at'])) }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="blog-wrapper fund-watch-listing fw-single-page">
                                <div class="container">
                                    <div class="blog-inner-wrapper">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-12 col-sm-12 fw-single-block">
                                                <h3>NIPPON INDIA SMALLCAP INDEX 250 FUND</h3>
                                                <div class="fw-single-content">
                                                    <p>Investing in the equity market is a lot like the voyage of discovery that Alice undertook. With patience and discipline it could be the wondrous garden that Alice saw but one has to pass through the door no bigger than a rat hole to really make it work. But the real decision making comes in if we have to choose where to put in the money. </p>
                                                </div>
                                                <div class="fw-pdf-donwload">
                                                    <a class="money_title_btn" href="https://www.myplexus.com/storage/pdf/20210605Formatted Nippon India Smallcap Index 250 Fund.pdf" target="_blank">Download PDF</a>
                                                </div>
                                                <div class="fw-single-file">
                                                    <embed src="https://www.myplexus.com/storage/pdf/20210605Formatted Nippon India Smallcap Index 250 Fund.pdf" width="100%" height="375" type="application/pdf">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar">
                                                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                    <h6>Recent Fund Watch</h6>
                                                        <ul class="reset">
                                                            <li>
                                                                <a href="https://www.myplexus.com/fund-watch/5" class="active">NIPPON INDIA SMALLCAP INDEX 250 FUND</a>
                                                            </li>
                                                            <li>
                                                                <a href="https://www.myplexus.com/fund-watch/4">NIPPON INDIA 150 MIDCAP INDEX FUND</a>
                                                            </li>
                                                            <li>
                                                                <a href="https://www.myplexus.com/fund-watch/3">MIRAE ASSET EMERGING BLUECHIP FUND</a>
                                                            </li>
                                                        </ul>
                                                </div>
                            
                                                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                    <h6>Archives</h6>
                                                        <ul class="reset">
                                                            <li>
                                                                <a href="https://www.myplexus.com/fund-watch-list/2021">2021 <span>(2)</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="https://www.myplexus.com/fund-watch-list/2020">2020 <span>(3)</span></a>
                                                            </li>
                                                        </ul>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        
                    @stop
