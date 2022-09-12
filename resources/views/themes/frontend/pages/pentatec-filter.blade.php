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
<div class="custom-banner no-bg pent-banner">
    <div class="container">
        @if (isset($dataArr['custom_fields']['textarea_29']))
        <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
        @endif
    </div>
</div>

<div class="pent-filter">
    <div class="container">
        <h3 class="text-center">{{ $dataArr['title'] }}</h3>
        <div class="pent-filter-wrap">
            @if (isset($dataArr['custom_fields']['editor_70']))
            {!! $dataArr['custom_fields']['editor_70']['value'] !!}
            @endif
        </div>
    </div>
</div>

<div class="pent-content-block bg-gry">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-12 pent-cnt-lft">
                @if (isset($dataArr['custom_fields']['textarea_69']))
                <span>{!! nl2br($dataArr['custom_fields']['textarea_69']['value']) !!}</span>
                @endif
            </div>
            <div class="col-sm-12 pent-cnt-rgt">
                {!! $dataArr['descp'] !!}
            </div>
        </div>
    </div>
</div>
@stop