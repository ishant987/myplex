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
<div class="custom-banner no-bg fund-watch-landing-page">
	<div class="container">
		<h1 class="f-b">{{ $dataArr['title'] }}</h1>
	</div>
</div>

<div class="blog-wrapper fund-watch-listing">
	<div class="container">
		<div class="blog-inner-wrapper">
			<div class="row">
				<div class="col-lg-9 col-md-12 col-sm-12 fw-listing-cols">
					<div class="row">
						@if(count($dataListModel) == 0)
						<p>{{ __('message.data_not_available') }}</p>
						@else
						@foreach($dataListModel as $key => $record)
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="fw-cols-block">
								<x-link url="{{ route('web.fundwatch', $record['fw_id']) }}">{{ $record['title'] }}</x-link>
								<p>{!! \App\Lib\Core\Useful::getShortContent(strip_tags($record['description']), 80) !!}</p>
								<span class="date">Posted On <span class="posted-date">{{ date($dateFormat, strtotime($record['created_at'])) }}</span></span>
							</div>
						</div>
						@endforeach
						@endif
					</div>
				</div>
				@include('themes.frontend.includes.fund-watch-sidebar')
			</div>
		</div>
	</div>
</div>
@stop