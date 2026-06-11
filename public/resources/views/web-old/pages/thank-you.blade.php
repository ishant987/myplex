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
                    <h1 class="f-b">{{ $dataArr['title'] }}</h1>
                    @if ($dataArr['descp'] != '')
                    <p>{!! $dataArr['descp'] !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>  
    <div class="custom-banner no-bg login-banner">
        <div class="container">
           <div class="clearfix">&nbsp;</div>
        </div>
    </div>
@stop
