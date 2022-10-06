@extends('web.layout.app')
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
<section class="inner_banner_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="inner_section_banner">
					<h4>{{$dataArr['title']}}</h4>
					<p>{{$dataArr['meta_descp']}}</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="info_monitor_sec">
	<div class="container">
		<div class="row">
			<div class="col-md-12" id="vue-app">
					<mutual-fund-lib></mutual-fund-lib>
			</div>
		</div>
	</div>
</section>
<div class="mutual-fund-table d-none">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 search_dictionary ">
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
	$(document).ready(function() {
		// $('#mutualFundDictionaryTable').DataTable({
		// 	processing: true,
		// 	serverSide: true,
		// 	"aLengthMenu": [
		// 		[50, 100, 200, 500, 1000],
		// 		[50, 100, 200, 500, 1000]
		// 	],
		// 	"iDisplayLength": 50,
		// 	ajax: "{{route('web.mutualfunddictionary.list')}}",
		// 	columns: [{
		// 			data: 'title'
		// 		},
		// 		{
		// 			data: 'description'
		// 		},
		// 	]
		// });
	});
</script>
@endpush