@extends('themes.frontend.layouts.app')
@section('datatables') @stop
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
<div class="custom-banner no-bg fw-banner monthly-ranking">
	<div class="container">
		<div class="banner-align-lft fw-title">
			<h1 class="f-b">{{$dataArr['title']}}</h1>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="mutual-fund-table">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<table id='mutualFundDictionaryTable' class="box-shadow">
					<thead>
						<tr>
							<th>{{ __('web.mutualfunddictionary.col1_txt') }}</th>
							<th>{{ __('web.mutualfunddictionary.col2_txt') }}</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@stop
@push('scripts')
<script>
	$(document).ready(function() {
		$('#mutualFundDictionaryTable').DataTable({
			processing: true,
			serverSide: true,
			"aLengthMenu": [
				[50, 100, 200, 500, 1000],
				[50, 100, 200, 500, 1000]
			],
			"iDisplayLength": 50,
			ajax: "{{route('web.mutualfunddictionary.list')}}",
			columns: [{
					data: 'title'
				},
				{
					data: 'description'
				},
			]
		});
	});
</script>
@endpush