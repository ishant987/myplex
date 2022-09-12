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
<div class="custom-banner no-bg faq-banner">
	<div class="container">
		@if(isset($dataArr['custom_fields']['textarea_29']))
		<h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
		@endif
	</div>
</div>

<div class="faq-main">
	<div class="container">
		{!! $dataArr['descp'] !!}
		<div class="faq-wrap">
			@if(count($dataArr['faqs']) == 0)
			<p>{{ __('message.data_not_available') }}</p>
			@else
			<div id="accordion">
				@foreach($dataArr['faqs'] as $index => $faq)
				<div class="card">
					<div class="card-header" id="heading_{{$faq->faq_id}}">
						<h5 class="mb-0">
							<button class="btn btn-link{{ ($index == 0)?'':' collapsed' }}" data-toggle="collapse" data-target="#collapse_{{$faq->faq_id}}" aria-expanded="{{ ($index == 0)?'true':'false' }}" aria-controls="collapse_{{$faq->faq_id}}">
								{{$faq->title}}
							</button>
						</h5>
					</div>
					<div id="collapse_{{$faq->faq_id}}" class="collapse{{ ($index == 0)?' show':'' }}" aria-labelledby="heading_{{$faq->faq_id}}" data-parent="#accordion">
						<div class="card-body">
							@if($faq->descp)
							<p>{!! nl2br($faq->descp) !!}</p>
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