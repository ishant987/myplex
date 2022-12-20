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
                        <section class="money_seriously_section fund_watch_setion_home nfo_monitor_home_section section">
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
                        </section>
                    @stop
