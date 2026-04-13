@extends('web.layout.app')
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
@endif
@if($dataArr['full_url'])
    @section('cur-url'){{$dataArr['full_url']}}@stop
@endif

@section('vue-js') @stop
@section('content')


<!-- <div class="custom-banner no-bg cms-page">
    <div class="container">
        <h1 class="f-b">{{ $dataArr['title'] }}</h1>
    </div>
</div>   -->

<div id="vue-app" data-v-app="">

    <div class="custom-banner no-bg fw-bannerfund-portfolio-banner monthly-ranking monthly-snapshot-banner">
        <section class="inner_banner_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner_section_banner">
                        <h4 class="f-b">{{ $dataArr['title'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="blog-wrapper cms-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 cms-page-block">
                    {!! $dataArr['descp'] !!}
                </div>
            </div>
        </div>
    </div> 

</div>

@stop

