@extends('web.layout.app')
@if (isset($dataArr['meta_title']))
@section('page-title'){{ $dataArr['meta_title'] }}@stop
@else
@section('page-title'){{ $dataArr['title'] }}@stop
@endif
@if (isset($dataArr['meta_key']))
@section('meta-keywords'){{ $dataArr['meta_key'] }}@stop
@endif
@if (isset($dataArr['meta_descp']))
@section('meta-description'){{ $dataArr['meta_descp'] }}@stop
@endif
@if (isset($dataArr['image_path']))
@section('meta-image'){{ $dataArr['image_path'] }}@stop
@endif
@if ($dataArr['full_url'])
@section('cur-url'){{ $dataArr['full_url'] }}@stop
@endif
@section('content')

<div class="banner" style="background: url(https://myplexus.com/themes/frontend/assets/v1/img/inner_banner.png)">
    <div class="container">
        <h1>Fund watch</h1>
        <h4>All funds list</h4>
    </div>
</div>

<div class="body_main">
    <div class="container">
        <div class="body_content">
            <div class="content_left">
                <div class="new_fund">
                    @if(count($fundWatch) == 0)
                    <p class="text-center">{{ __('message.data_not_available') }}</p>
                    @else
                        @if($reqYear > 0)
                        <div class="pentatech_filter_title m-3">
                            <h4>{{ $reqYear.' ('.count($fundWatch).')'}}</h4>
                        </div>
                        @endif

                        @foreach($fundWatch as $funds)
                        <div class="new_fund_single">
                            <img src="{{ env('ADMIN_SITE') }}/assets/images/{{ $funds->logo }}" alt="">
                            <h3>{{!empty($funds->fundDetails)?$funds->fundDetails->fund_name:'N/A'}}</h3>
                            <h3 class="">Date of posting : {{ date('d M Y',strtotime($funds->published_date)) }}</h3>
                            <p class="pre_text">{!! $funds->preamble !!}</p>
                            @php $fund_code_viewMore = base64_encode($funds->fundDetails->fund_code); @endphp
                            <a href="{{ url('new-fundwatch') }}/{{$fund_code_viewMore}}" target="_blank">View More</a>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- <div class="content_right">
                    <h2 class="arc">Recent Posts</h2>

                    <div class="m_fund">
                    <ul>
                        <li>
                            <a href="#">BARODA BNP PARIBAS Mid Cap</a>
                            <figure>
                                <a href="#"><img src="https://myplexus.com/themes/frontend/assets/v1/img/fund.png" alt=""></a>
                            </figure>
                        </li>
                        <li>
                            <a href="#">BARODA BNP PARIBAS Mid Cap</a>
                            <figure>
                                <a href="#"><img src="https://myplexus.com/themes/frontend/assets/v1/img/fund.png" alt=""></a>
                            </figure>
                        </li>
                    </ul>
                </div>

                <h2 class="arc arc_new">Archives</h2>

                <div class="m_fund arc_yr">
                    <a href="#">2022 <span>(6)</span></a>
                    <a href="#">2024 <span>(2)</span></a>
                </div>
                </div> -->

            <div class="content_right">
                <h2 class="arc">Recent Posts</h2>
                <div class="m_fund">
                    <ul>
                        @foreach($recentPosts as $recentPost)
                        <li>
                            @php $fund_code_encoded = base64_encode($recentPost->fundDetails->fund_code); @endphp
                            <a href="{{ url('new-fundwatch') }}/{{$fund_code_encoded}}" target="_blank">
                                {{ $recentPost->fundDetails->fund_name }}
                            </a>
                            @if($recentPost->logo)
                            <figure>
                                <a href="{{ url('new-fundwatch') }}/{{$fund_code_encoded}}" target="_blank"><img src="{{ env('ADMIN_SITE') }}/assets/images/{{ $recentPost->logo }}" alt=""></a>
                            </figure>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>

                <h2 class="arc arc_new">Archives</h2>
                <div class="m_fund arc_yr">
                    @foreach($archiveData as $archive)
                    <a href="{{ url('new-fundwatch-list') }}/{{$archive->creation_year}}">{{$archive->creation_year}} <span>({{$archive->record_count}})</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection