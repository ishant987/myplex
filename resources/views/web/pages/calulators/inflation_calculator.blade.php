@extends('web.layout.app')
@section('captcha') @stop
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
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Inflation Calculator</h4>
                    <p>
                        {{-- {!! nl2br($dataArr['descp'])!!} --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@if(session()->has('username') && session()->has('useremail') )

<div id="vue-app">
    <inflation-calculator image_path="{{asset('themes/frontend/assets/v1/img/')}}" sip_faqs="" sip_pdf_url="{{ isset($dataArr['custom_fields']['text_68'])?$dataArr['custom_fields']['text_68']['value']:'' }}" username="{{ session()->get('username') }}" useremail="{{ session()->get('useremail') }}"></inflation-calculator>
</div>
@else
<section >
    <div class="container">
        <div class="row" style="display: flex;justify-content: center;align-items: center;">
            <div class="col-md-4" > 
                @include('web.common.login',['source'=>'calucator'])
            </div>
        </div>
    </div>
</section>
@endif
@stop
@push('scripts')
    <script>
        $('.cal_sign_in').click(function(){
            $('.login_form').submit();
        });
    </script>
@endpush