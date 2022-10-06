@extends('themes.frontend.layouts.app')
@section('owl-carousel') @stop
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
    .custom-banner {
        background-image: url('{{ $dataArr['image_path'] }}');
    }
</style>
@endpush
@endif
@if ($dataArr['full_url'])
@section('cur-url'){{ $dataArr['full_url'] }}@stop
@endif
@if (isset($dataArr['custom_fields']['image_44']))
@push('styles')
<style>
    .about-us-goals .goals-wrapper {
        background-image: url('{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_44']['value'] }}');
    }
</style>
@endpush
@endif
@section('content')
<div class="custom-banner no-bg about-us-banner">
    <div class="container">
        @if (isset($dataArr['custom_fields']['textarea_29']))
        <h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
        @endif
    </div>
</div>

<div class="about-us-main">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-6 col-sm-12 about-us-lft">
                @if (isset($dataArr['custom_fields']['textarea_30']))
                <h3>{!! nl2br($dataArr['custom_fields']['textarea_30']['value']) !!}</h3>
                @endif
                @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_31']))
                <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_31']['value'] }}" class="img-fluid" />
                @endif
                {!! $dataArr['descp'] !!}
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 about-us-rgt">
                @if (isset($dataArr['custom_fields']['textarea_33']))
                <h3>{!! nl2br($dataArr['custom_fields']['textarea_33']['value']) !!}</h3>
                @endif
                @if (isset($dataArr['custom_fields']['editor_34']))
                {!! $dataArr['custom_fields']['editor_34']['value'] !!}
                @endif
                <div class="timeline-wrap">
                    <div class="timeline-block timeline-block-1">
                        @if (isset($dataArr['custom_fields']['text_35']))
                        <h3>{{ $dataArr['custom_fields']['text_35']['value'] }}</h3>
                        @endif
                        @if (isset($dataArr['custom_fields']['textarea_36']))
                        <p>{!! nl2br($dataArr['custom_fields']['textarea_36']['value']) !!}</p>
                        @endif
                    </div>
                    <div class="timeline-block timeline-block-2">
                        @if (isset($dataArr['custom_fields']['text_37']))
                        <h3>{{ $dataArr['custom_fields']['text_37']['value'] }}</h3>
                        @endif
                        @if (isset($dataArr['custom_fields']['textarea_38']))
                        <p>{!! nl2br($dataArr['custom_fields']['textarea_38']['value']) !!}</p>
                        @endif
                    </div>
                    <div class="timeline-block timeline-block-3">
                        @if (isset($dataArr['custom_fields']['text_39']))
                        <h3>{{ $dataArr['custom_fields']['text_39']['value'] }}</h3>
                        @endif
                        @if (isset($dataArr['custom_fields']['textarea_40']))
                        <p>{!! nl2br($dataArr['custom_fields']['textarea_40']['value']) !!}</p>
                        @endif
                    </div>
                    <div class="timeline-block timeline-block-4">
                        @if (isset($dataArr['custom_fields']['text_41']))
                        <span>{{ $dataArr['custom_fields']['text_41']['value'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="g-ads-sec g-ads-sec-3">
    <div class="container">
        <div class="ads-continer">
            @if (isset($defDataArr['media_folder']) && isset($dataArr['custom_fields']['image_58']))
            @if (isset($dataArr['custom_fields']['text_59']))
            <x-link url="{{ $dataArr['custom_fields']['text_59']['value'] }}" target="_blank">
                <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_58']['value'] }}" />
            </x-link>
            @else
            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['custom_fields']['image_58']['value'] }}" />
            @endif
            @endif
        </div>
    </div>
</div>

<div class="about-us-commitment bg-gry">
    <div class="container">
        <div class="row justify-content-between">
            <div class="commit-lft">
                @if (isset($dataArr['custom_fields']['textarea_42']))
                <h3>{!! nl2br($dataArr['custom_fields']['textarea_42']['value']) !!}</h3>
                @endif
            </div>
            <div class="commit-rgt">
                @if (isset($dataArr['custom_fields']['editor_43']))
                {!! $dataArr['custom_fields']['editor_43']['value'] !!}
                @endif
            </div>
        </div>
    </div>
</div>

<div class="about-us-goals">
    <div class="container">
        <div class="goals-wrapper no-bg br-5">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    @if (isset($dataArr['custom_fields']['text_45']))
                    <h3>{{ $dataArr['custom_fields']['text_45']['value'] }}</h3>
                    @endif
                    @if (isset($dataArr['custom_fields']['editor_46']))
                    {!! $dataArr['custom_fields']['editor_46']['value'] !!}
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    @if (isset($dataArr['custom_fields']['text_47']))
                    <h3>{{ $dataArr['custom_fields']['text_47']['value'] }}</h3>
                    @endif
                    @if (isset($dataArr['custom_fields']['editor_48']))
                    {!! $dataArr['custom_fields']['editor_48']['value'] !!}
                    @endif
                    @if (isset($dataArr['custom_fields']['textarea_49']))
                    <span class="title">{!! nl2br($dataArr['custom_fields']['textarea_49']['value']) !!}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="our-team-slider">
    <div class="container">
        @if (isset($dataArr['custom_fields']['text_50']))
        <h3 class="text-center text-green">{{ $dataArr['custom_fields']['text_50']['value'] }}</h3>
        @endif
        <div class="our-team-para text-center m-auto">
            @if (isset($dataArr['custom_fields']['textarea_51']))
            <p>{{ $dataArr['custom_fields']['textarea_51']['value'] }}</p>
            @endif
        </div>
        @if (count($teamMdl) > 0)
        <div class="our-team-carousel">
            <div class="owl-carousel owl-theme">
                @foreach ($teamMdl as $key => $record)
                <div class="item">
                    <div class="team-c-col">
                        <div class="team-c-img">
                            @if ($record->media != null)
                            @if ($record->media['path'])
                            <x-img src="{{ $defDataArr['media_folder'] . $record->media->path }}" alt="{{ $record->media->alt }}" title="{{ $record->media->title }}" />
                            @endif
                            @endif
                        </div>
                        <div class="team-c-cnt">
                            <div class="team-c-bio">
                                <span class="team-name">{{ $record->name }}</span>
                                @if ($record->designation)
                                <span class="team-position">{{ $record->designation }}</span>
                                @endif
                            </div>
                            <div class="team-c-connect">
                                @if ($record->linkedin_link)
                                <x-link url="{{ $record->linkedin_link }}" target="_blank">
                                    <x-img src="{{ asset('themes/frontend/assets/images/linkedin-icon-4.jpg') }}" />
                                </x-link>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@stop
@push('scripts')
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false,
                    margin: 20
                },
                600: {
                    items: 4,
                    nav: false,
                    dots: false,
                    margin: 30
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    dots: false,
                    margin: 40
                }
            }
        });
    });
</script>
@endpush