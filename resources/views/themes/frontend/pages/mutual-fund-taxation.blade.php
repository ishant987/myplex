@extends('themes.frontend.layouts.app')
@section('select2') @stop
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
<div class="custom-banner no-bg fw-banner mutual-fund-class-banner">
    <div class="container">
        <h1 class="f-b">{!! nl2br($dataArr['title']) !!}</h1>
    </div>
</div>

<div class="mutual-f-taxation bg-gry">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 col-md-5 col-sm-12 mutual-f-tax-rgt">
                <h3>{{ $fundTxnMdl->title }}</h3>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 mutual-f-tax-lft">
                @if(count($fundTxnListMdl) > 0)
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 select2-styles mutual-f-tax-in-lft">
                        <select id="mutual_fund_taxation" class="js-example-placeholder-single js-states form-control" onchange="window.location='{{ url('/mutual-fund-taxation/') }}/' + this.value;">
                            @foreach($fundTxnListMdl as $key => $record)
                            <option value="{{ $record->ft_id }}" {{ ($record->ft_id == $fundTxnMdl->ft_id)?'selected=selected':'' }}>{{ $record->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($fundTxnMdl->file)
<div class="mutual-fund-pdf-wrap">
    <div class="container">
        <div class="inner-pdf-wrap br-5 border-s box-shadow">
            <embed src="{{ $defDataArr['media_folder'].$fundTxnMdl->file }}" type="application/pdf" width="100%" height="500px">
        </div>
    </div>
</div>
@endif
@include('themes.frontend.includes.patshala-newsletter')
@stop
@push('scripts')
<script>
    $('#mutual_fund_taxation').select2({
        placeholder: "Recent Archives"
    });
</script>
@endpush