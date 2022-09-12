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
<div class="custom-banner no-bg fund-managers-banner">
	<div class="container">
		@if(isset($dataArr['custom_fields']['textarea_29']))
		<h1 class="f-b">{!! nl2br($dataArr['custom_fields']['textarea_29']['value']) !!}</h1>
		@endif
	</div>
</div>

<div class="fund-experts-wrap">
	<div class="container">
		<div class="row">

			<div class="col-lg-7 col-md-7 col-sm-12 fund-expert-lft">
				<h3>{{ $dataArr['title'] }}</h3>
				<div class="row align-items-center">
					<div class="col-lg-5 col-md-6 col-sm-12 fund-el-profile-lft">
						@if( $fundManMdl->media != null )
						@if( $fundManMdl->media['path'] )
						<x-img src="{{ $defDataArr['media_folder'].$fundManMdl->media->path }}" alt="{{ $fundManMdl->media->alt }}" title="{{ $fundManMdl->media->title }}" class="img-fluid" />
						@endif
						@endif
					</div>
					<div class="col-lg-7 col-md-6 colsm-12 fund-el-profile-rgt">
						<span class="name">{{ $fundManMdl->name }}</span>
						@if($fundManMdl->designation)
						<span class="title-1">{{ $fundManMdl->designation }}</span>
						@endif
						@if($fundManMdl->company_name)
						<span class="title-2">{{ $fundManMdl->company_name }}</span>
						@endif
					</div>
				</div>
				<div class="fund-expert-p-para">
					{!! $fundManMdl->description !!}
				</div>
				@if($fundManMdl->disclaimer || $fundManMdl->disclaimer_note)
				<div class="disclaimer-bottom">
					@if($fundManMdl->disclaimer)
					<div class="disclaimer-wrap br-5 box-shadow border-s bg-gry text-green-h">
						{!! $fundManMdl->disclaimer !!}
					</div>
					@endif
					@if($fundManMdl->disclaimer_note)
					<div class="disclaimer-note">
						<h6 class="text-green">{!! nl2br($fundManMdl->disclaimer_note) !!}</h6>
					</div>
					@endif
				</div>
				@endif
			</div>

			<div class="col-lg-5 col-md-5 col-sm-12 fund-expert-rgt">
				@if(isset($dataArr['custom_fields']['textarea_53']))
				<h3 class="text-green">{!! nl2br($dataArr['custom_fields']['textarea_53']['value']) !!}</h3>
				@endif
				<div class="experts-interviews-wrap">
					@if(count($fundManListMdl) > 0)
					@foreach($fundManListMdl as $key => $record)
					<div class="row align-items-center">
						<div class="col-lg-6 col-md-6 col-sm-12 fund-el-profile-lft expert-interviews-lft">
							@if( $record->media != null )
							@if( $record->media['path'] )
							<x-link url="{{ route('web.fundman', $record->slug) }}">
								<x-img src="{{ $defDataArr['media_folder'].$record->media->path }}" alt="{{ $record->media->alt }}" title="{{ $record->media->title }}" class="img-fluid" />
							</x-link>
							@endif
							@endif
						</div>
						<div class="col-lg-6 col-md-6 colsm-12 expert-interviews-rgt">
							<x-link url="{{ route('web.fundman', $record->slug) }}">
								<span class="name">{{ $record->name }}</span>
							</x-link>
							@if($record->designation)
							<span class="title-1">{{ $record->designation }}</span>
							@endif
							@if($record->company_name)
							<span class="title-2">{{ $record->company_name }}</span>
							@endif
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>

		</div>
	</div>
</div>
@stop