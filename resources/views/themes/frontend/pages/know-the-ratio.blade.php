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
<div class="custom-banner no-bg know-ratios-banner">
    <div class="container">
        @if(isset($dataArr['custom_fields']['textarea_29']))
        <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
        @endif
    </div>
</div>

<div class="faq-main know-ratio-wrap">
    <div class="container">
        <h3>{{ $dataArr['title'] }}</h3>
        <div class="faq-wrap">
            @if(count($dataArr['know_the_ratio']) == 0)
            <p>{{ __('message.data_not_available') }}</p>
            @else
            <div id="accordion">
                @foreach($dataArr['know_the_ratio'] as $index => $record)
                <div class="card">
                    <div class="card-header" id="heading_{{$record->ktr_id}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link{{ ($index == 0)?'':' collapsed' }}" data-toggle="collapse" data-target="#collapse_{{$record->ktr_id}}" aria-expanded="{{ ($index == 0)?'true':'false' }}" aria-controls="collapse_{{$record->ktr_id}}">{{$record->title}}</button>
                        </h5>
                    </div>
                    <div id="collapse_{{$record->ktr_id}}" class="collapse{{ ($index == 0)?' show':'' }}" aria-labelledby="heading_{{$record->ktr_id}}" data-parent="#accordion">
                        <div class="card-body">
                            @if( $record->media != null )
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-sm-12 know-ration-para">
                                    {!! $record->description !!}
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 know-ration-img">
                                    @if( $record->media['path'] )
                                    <x-img src="{{ $defDataArr['media_folder'].$record->media->path }}" alt="{{ $record->media->alt }}" title="{{ $record->media->title }}" />
                                    @endif
                                </div>
                            </div>
                            @else
                            {!! $record->description !!}
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@include('themes.frontend.includes.patshala-newsletter')
@stop