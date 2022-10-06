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
<section class="here_section">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="slider_img">
                    <img src="{{asset('themes/frontend/assets/v1/img/faq-banner.jpg')}}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-caption">
                    <h2 class="animate__animated animate__fadeInUp">FAQ <span>-Frequently Asked Question</span></h2>
                    <p class="animate__animated animate__fadeInLeft">The mutual fund industry is fast becoming the preferred savings and investment vehicle for most of us.</p>
                    <div class="caption_bg "></div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="faq_section">
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <div class="faq_left_filter">
                    <li class="single_radio">
                        <input type="radio" id="faq1"/>
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
                </div>
            </div>
            <div class="col-md-8">
                        @include('web.common.faq_list')
            </div>
        </div>
    </div>
</section>
@stop
