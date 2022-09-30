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
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif

@section('vue-js') @stop
@section('content')
<div class="custom-banner no-bg  @if(!$dataArr['image_path']) fw-banner sip-planner-banner  @endif" style="@if($dataArr['image_path']) background-image:url({{$dataArr['image_path']}}) @endif" >
	<div class="container">
		<h1 class="f-b">{{$dataArr['title']}}</h1>
		@if($dataArr['descp']) <h3 class="f-sb text-green">{!! $dataArr['descp'] !!}</h3> @endif
	</div>
</div>
<div id="vue-app">
	<fund-performance></fund-performance>
</div>
@stop