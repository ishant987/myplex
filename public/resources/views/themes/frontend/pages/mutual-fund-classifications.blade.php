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
<div class="custom-banner no-bg fw-banner mutual-fund-class-banner">
    <div class="container">
        <h1 class="f-b">{!! nl2br($dataArr['title']) !!}</h1>
    </div>
</div>

<div class="mutual-f-taxation mutual-f-class bg-gry">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 col-md-5 col-sm-12 mutual-f-class-lft">
                <h3>{{ $fundClsMdl->title }}</h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mutual-f-class-rgt">
                @if(count($fundClsListMdl) > 0)
                <ul class="nav nav-tabs">
                    @foreach($fundClsListMdl as $key => $record)
                    <li {{ ($record->fc_id == $fundClsMdl->fc_id)?'class=active':'' }}>
                        <a href="{{ route('web.mutualfundclassifications', $record->fc_id) }}" {{ ($record->fc_id == $fundClsMdl->fc_id)?'class=active':'' }}>{{ $record->title }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@if($fundClsMdl->file)
<div class="mutual-fund-pdf-wrap">
    <div class="container">
        <div class="inner-pdf-wrap br-5 border-s box-shadow">
            <embed src="{{ $defDataArr['media_folder'].$fundClsMdl->file }}" type="application/pdf" width="100%" height="500px">
        </div>
    </div>
</div>
@endif
@include('themes.frontend.includes.patshala-newsletter')
@stop