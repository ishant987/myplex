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
<div class="custom-banner no-bg the-news-banner">
    <div class="container">
        @if($dataArr['descp'])
        <h1 class="f-b">{!! $dataArr['descp'] !!}</h1>
        @endif
    </div>
</div>

<div class="news-listing">
    <div class="container">
        <div class="row">
            @if(count($dataListMdl) == 0)
            <p>{{ __('message.data_not_available') }}</p>
            @else
            @foreach ($dataListMdl as $key => $record)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="new-listing-wrapper">
                    <div class="news-listing-img">
                        @if($record->news_source_link != '')
                        <x-link url="{{ $record->news_source_link }}" target="_blank">
                            @endif
                            @if($record->media_type != '')
                            @switch($record->media_type)
                            @case('i')
                            <x-img src="{{ $defDataArr['media_folder'] . $record->image }}" alt="{{ $record->title }}" title="{{ $record->title }}" class="img-fluid" />
                            @break
                            @case('v')
                            @switch($record->video_from)
                            @case('l')
                            {{ \App\Lib\Core\Core::htmlVideoPlayer($defDataArr['media_folder'].$record->video_data) }}
                            @break
                            @case('y')
                            @if($record->video_image != '')
                            <x-img src="{{ $defDataArr['media_folder'] . $record->video_image }}" alt="{{ $record->title }}" title="{{ $record->title }}" class="img-fluid" />
                            @endif
                            @break
                            @endswitch
                            @break
                            @endswitch
                            @endif
                            @if($record->news_source_link != '')
                        </x-link>
                        @endif
                    </div>
                    <div class="new-lisiting-title">
                        @if($record->news_source_link != '')
                        <x-link url="{{ $record->news_source_link }}" target="_blank">{{ $record->title }}</x-link>
                        @else
                        {{ $record->title }}
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@stop