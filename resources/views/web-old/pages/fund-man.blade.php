@extends('web.layout.app')
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
                    @push('styles')
                        <style>
                            .custom-banner {
                                background-image: url('{{ $dataArr['image_path'] }}');
                            }
                        </style>
                    @endpush
                @endif
                @if ($dataArr['full_url'])
                    @section('cur-url'){{ $dataArr['full_url'] }}@stop
                    @endif
                    @section('content')
                        <div class="custom-banner no-bg fund-managers-banner">
                            <div class="container">
                                @if (isset($dataArr['custom_fields']['textarea_29']))
                                    <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
                                @endif
                            </div>
                        </div>
                        <section class="inner_banner_section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="inner_section_banner">
                                            <h4>Meet The Fund Man</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="abt_page_section founder_about pb-0">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="abt_right_img_wrapper" data-aos="fade-up" data-aos-duration="1500">
                                            @if ($fundManMdl->media != null && $fundManMdl->media['path'])
                                                <img src="{{ $defDataArr['media_folder'] . $fundManMdl->media->path }}"
                                                    alt="{{ $fundManMdl->media->alt }}" title="{{ $fundManMdl->media->title }}"
                                                    class="img-fluid" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="page_abt_inner" data-aos="fade-down" data-aos-duration="1000">
                                            <h4>{{ $fundManMdl->name }}, {{$fundManMdl->designation ? $fundManMdl->designation : ''}}</h4>
                                            <h5>{{$fundManMdl->company_name ? $fundManMdl->company_name  : ''}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
						<section class="interview_sec">
							<div class="container">
								{!! $fundManMdl->description !!}
							</div>
							<div class="disclaimer-note">
								<h6 class="text-green">{!! nl2br($fundManMdl->disclaimer_note) !!}</h6>
							</div>
						</section>
						<section class="recent_interview">
							<div class="container">
								<h4>Recent Interviews</h4>                 
								<div class="recent_interview_slider">
									@foreach ($fundManListMdl as $key => $record)
									<div class="slider_inerr">
										<div class="inter_seen">
											<div class="inter_seen_img">
											<img src="{{ $defDataArr['media_folder'] . $record->media->path }}"
											alt="{{ $record->media->alt }}"
											title="{{ $record->media->title }}" class="img-fluid" />
											</div>
											<x-link url="{{ route('web.fundman', $record->slug) }}">
											<h5>
													{{ $record->name }}
												</h5>
											</x-link>
											<p>{{ $record->designation }}</p>
											<p>{{ $record->company_name }}</p>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</section>
                    @stop
