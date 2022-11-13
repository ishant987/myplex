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
<div class="custom-banner no-bg nfo-monitor-banner">
<div class="container">
			<h1 class="f-b">{{ $dataArr['title'] }}</h1>
		@if($reqYear > 0)
		<h3 class="f-sb text-green">{{ 'NFO From '.$reqYear }}</h1>
		@endif
	</div>
</div>

<div class="nfo-archives">
        <div class="container">
			@if(count($dataListModel) == 0)
				<p>{{ __('message.data_not_available') }}</p>
			@else
				@if($reqYear > 0)
					<div class="archive-wrapper">
						<div class="archives-posts">
							<div class="row m-0 archive-row">
							@foreach($dataListModel as $key => $record)
								<div class="archive-block">
									<x-link url="{{ route('web.nfomonitor', $record['no_id']) }}">{{ $record['fund_name'] }}</x-link>
									@if($record['objective'] != '')
										<p>{!! \App\Lib\Core\Useful::getShortContent(strip_tags($record['objective']), 80) !!}</p>
									@endif
									<h6>Posted On <span class="archive-post-date">{{ date($dateFormat, strtotime($record['post_date'])) }}</span></h6>
								</div>
							@endforeach
							</div>
						</div>
					</div>
				@else
					@foreach($dataListModel as $key => $record)
					<div class="archive-wrapper">
						<div class="row m-0 justify-content-between align-items-center">
							<div class="archive-title"><h3>{{ $key == 0 ? 'Recent NFO' : 'Archives From '.$record['archive']['year'] }} <span class="posts-count">({{ $record['archive']['tot'] }})</span></h3></div>
							<div class="archive-view-all">
								<x-link url="{{ route('web.nfomonitor.list', $record['archive']['year']) }}">View All</x-link>
							</div>
						</div>
						<div class="archives-posts">
							<div class="row m-0 archive-row">
								@if(count($record['items']) == 0)
									<p>{{ __('message.data_not_available') }}</p>
								@else
									@foreach($record['items'] as $key => $record2)
									<div class="archive-block">
										<x-link url="{{ route('web.nfomonitor', $record2['no_id']) }}">{{ $record2['fund_name'] }}</x-link>
										@if($record2['objective'] != '')
											<p>{!! \App\Lib\Core\Useful::getShortContent(strip_tags($record2['objective']), 80) !!}</p>
										@endif
										<h6>Posted On <span class="archive-post-date">{{ date($dateFormat, strtotime($record2['post_date'])) }}</span></h6>
									</div>
									@endforeach
								@endif
							</div>
						</div>
					</div>
					@endforeach
				@endif
			@endif
        </div>
    </div>
@stop