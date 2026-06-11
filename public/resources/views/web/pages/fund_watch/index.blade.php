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
                           {{-- <div class="container">
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
                            </div> --}}
                            <div class="blog-wrapper fund-watch-listing fw-single-page">
                                <div class="container">
                                    <div class="blog-inner-wrapper">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-12 col-sm-12 fw-single-block">
												@if(isset($createdAt))
																								
													@foreach($createdAt as $filterDate)
														<div class="card mb-3">
															<div class="card-body">
                                                                <img src="https://myplexus.com/themes/frontend/assets/v1/img/nippon.jpg" alt="" class="card_img">
																<h3 class="m-2">{{$filterDate->title}}</h3>
																	<p class="card-title m-2">{{$filterDate->description}}</p>
																
																<a class="btn btn-success m-2" href="{{ route('web.fundwatch.index',base64_encode($filterDate->fund_code))}}" target="_blank">View more</a>
															</div>
														</div>
													@endforeach
													 
												@else
												 @for($i=0; $i<count($fundWatchTitle); $i++)
																@php
																	$sid =base64_encode($fundWatchData[$i]->fund_code);
																@endphp
														@if($sid!="")
															<div class="card mb-3">
																<div class="card-body">
                                                                <img src="https://myplexus.com/themes/frontend/assets/v1/img/nippon.jpg" alt="" class="card_img">
																	<h3 class="m-2">{{$fundWatchTitle[$i]->title}}</h3>
																	<p class="card-title m-2">{{$fundWatchDescription[$i]->description}}</p>
																	<a class="btn btn-success m-2" href="{{ route('web.fundwatch.index', $sid)}}" target="_blank">View more</a>
																</div>
															</div>
														@endif
													@endfor
												
												@endif
                                                

                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar">
                                                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                    <h6>Recent Fund Watch</h6>
                                                        <ul class="reset">
																														
															 @foreach($fundWatchData as $fwdata)
															@php
                           										$sid =base64_encode($fwdata->fund_code);
                         									@endphp
															@if($sid!="")
																<li>
																	
																	
																	<a href="{{ route('web.fundwatch.index', $sid )}}" target="_blank" style="color: #1b103a"> {{$fwdata->title}} </a>
																	
																</li>
															@endif
															@endforeach                                                   
                                                           
                                                        </ul>
                                                </div>
                            
                                                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                    <h6>Archives</h6>
                                                        <ul class="reset">
                                                            <li>
                                                                <a href="https://www.new.myplexus.com/fund-watch-list/2021">2021 <span>(2)</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="https://www.new.myplexus.com/fund-watch-list/2023">2023 <span>(1)</span></a>
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
