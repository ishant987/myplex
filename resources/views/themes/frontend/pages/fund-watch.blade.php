@extends('themes.frontend.layouts.app')
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
<link rel="stylesheet" href="{{asset('themes/frontend/assets/jquery-bar-rating-master/dist/themes/fontawesome-stars.css')}}">
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
<div class="custom-banner no-bg fund-watch-landing-page">
    <div class="container">
        <h1 class="f-b">{{ $dataArr['title'] }}</h1>
    </div>
</div>

<div class="blog-wrapper fund-watch-listing fw-single-page">
    <div class="container">
        <div class="blog-inner-wrapper">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 fw-single-block">
                    <h3>{{ $dataArr['item']->title }}</h3>
                    <div class="fw-single-content">
                        @if($dataArr['item']->description)
                        <p>{!! nl2br($dataArr['item']->description) !!}</p>
                        @endif
                    </div>
                    <div class="fw-pdf-donwload">
                        @if($dataArr['item']->file)
                        <x-link url="{{ $defDataArr['media_folder'].$dataArr['item']->file }}" target="_blank">Download PDF</x-link>
                        @endif
                    </div>
                    <div class="fw-single-file">
                        @if($dataArr['item']->file)
                        {{$defDataArr['media_folder'].$dataArr['item']->file}}
                        <embed src="{{ $defDataArr['media_folder'].$dataArr['item']->file }}" width="100%" height="375" type="application/pdf">
                        @endif
                    </div>
                </div>
                @include('themes.frontend.includes.fund-watch-sidebar')
            </div>
        </div>
    </div>
</div>
@stop