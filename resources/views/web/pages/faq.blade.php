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
                    <h4>FAQ</h4>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="faq_section section">
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
