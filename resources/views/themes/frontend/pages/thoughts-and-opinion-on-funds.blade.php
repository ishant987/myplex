@extends('themes.frontend.layouts.app')
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
<div class="custom-banner no-bg about-us-banner">
    <div class="container">
        @if(isset($dataArr['custom_fields']['textarea_29']))
        <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
        @endif
    </div>
</div>

<div class="opinions-funds bg-gry">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 opinions-funds-title">
                {!! $dataArr['descp'] !!}
            </div>
        </div>
    </div>
</div>

<div class="opinions-wrap">
    <div class="container">
        @if(count($fundSgsListMdl) > 0)
        @foreach($fundSgsListMdl as $key => $record)
        <div class="opinions-blocks br-5 border-s bg-gry box-shadow">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12 op-title">
                    <h5>{{ $record->title }}</h5>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 op-download">
                    @if($record->file)
                    <x-link url="{{ $defDataArr['media_folder'].$record->file }}" target="_blank">{{ __('web.download_pdf_txt') }}</x-link>
                    @endif
                </div>
            </div>
            <div class="opinions-content">
                {!! $record->description !!}
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@include('themes.frontend.includes.patshala-newsletter')
@stop