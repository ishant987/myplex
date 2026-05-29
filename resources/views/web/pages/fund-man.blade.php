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
        .login-banner {
            background-image: url('{{ $dataArr['image_path'] }}');
        }
    </style>
@endpush
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
                    <h4 class="f-b">{{ $dataArr['title'] }}</h4>
                  
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="sc-team-details-area sc-pt-100 sc-md-pt-80 sc-pb-200 sc-md-pb-150">
    <div class="container">
        <div class="row clearfix">
            <!-- sc-details-social -->
            <div class="sc-details-social col-lg-5 md-mb-50 sal-animate" data-sal="slide-right" data-sal-duration="800">
                <div class="inner-column">
                    <div class="image">
                        <!-- <img src="{{ asset('themes/frontend/assets/v1/img/vihangNaik.jpg') }}"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >			 -->
                        @if ($fundManMdl->media != null && $fundManMdl->media['path'])
                                                <img src="{{ $defDataArr['media_folder'] . $fundManMdl->media->path }}"
                                                    alt="{{ $fundManMdl->media->alt }}" title="{{ $fundManMdl->media->title }}"
                                                    class="img-fluid" />
                                            @endif														

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color">{{ $fundManMdl->name }}, {{$fundManMdl->designation ? $fundManMdl->designation : ''}}</h3>
                        <div class="text">{{$fundManMdl->company_name ? $fundManMdl->company_name  : ''}}</div>
                    </div>
                    <!-- <div class="social-box">
                        <a href="#"><i class="icon-linkedin-2"></i></a>
                        <a href="#"><i class="icon-twiter"></i></a>
                        <a href="#"><i class="icon-intragram"></i></a>
                        <a href="#"><i class="icon-facebook-2"></i></a>
                    </div> -->
                </div>
            </div>
            <!-- Content Section -->
            <div class="sc-team-content sc-pl-50 sc-md-pl-0 col-lg-7 sc-md-mt-45 sal-animate" data-sal="slide-left" data-sal-duration="800">
                <div class="inner-column">
                    <h2 class="sc-mb-30">Meet The Fund Expert</h2>
                    <p>{!! $fundManMdl->description !!}</p>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<section class="compare_section section">
    <div class="container">
        <div class="row">
            <div class="single-features-style1-box mb-4">
                <div class="col-md-12 aos-init" data-aos="fade-up" data-aos-duration="1000">
                    <div class="text-box d-block d-sm-flex align-items-center">
                        <h4>Experts Interviews</h4>					
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">		
			
			@foreach ($fundManListMdl as $key => $record)			
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="{{ $defDataArr['media_folder'] . $record->media->path }}" alt="{{ $record->media->alt }}" title="{{ $record->media->title }}" class="img-fluid" />
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="{{ route('web.fundman', $record->slug) }}"><h4>{{ $record->name }}</h4></a>				
					<p>
                        {{ $record->designation }} <br>
                        {{ $record->company_name }}
                    </p>
                 
                </div>
            </div> 
            @endforeach			
            
			
               
        </div>
       
    </div>
</section>
@stop
