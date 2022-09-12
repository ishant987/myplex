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
<link rel="stylesheet" href="{{asset('themes/frontend/assets/jquery-bar-rating-master/dist/themes/fontawesome-stars.css')}}">
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
<div class="custom-banner no-bg fw-banner nfo-banner">
    <div class="container">
        <div class="nfo-banner-wrapper">
            <div class="nfo-banner-wrapper-lft">
                <div class="banner-align-lft fw-title">
                    <h1 class="f-b">{{ $dataArr['title'] }}</h1>
                    <h3 class="f-sb text-green">{{ $dataArr['item']['fund_name'] }}</h1>
                </div>
            </div>
            <div class="nfo-banner-wrapper-rgt">
                <div class="nfo-company-image">
                    @if ($dataArr['item']->media != null)
                        @if ($dataArr['item']->media['path'])
                            <x-img src="{{ $defDataArr['media_folder'] . $dataArr['item']->media->path }}" alt="{{ $dataArr['item']->media->alt }}" title="{{ $dataArr['item']->media->title }}" />
                        @endif
                    @endif
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="nfo-fund-facts">
    <div class="container">
        <div class="nfo-fund-inner bg-gry border-s box-shadow br-5">
            <h5 class="text-green">Fund Facts</h5>
            <ul>
                <li>
                    <div class="facts-title"><span>Name of Fund:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['fund_name'] }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Opening:</span></div>
                    <div class="facts-title-2"><span>{{ date($dateFormat, strtotime($dataArr['item']['fund_opening'])) }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Closing:</span></div>
                    <div class="facts-title-2"><span>{{ date($dateFormat, strtotime($dataArr['item']['fund_closing'])) }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Scheme Type:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']->fundtype->name }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Minimum Investment:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['minimum_investment'] }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Plan:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['plan'] }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Options:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['options'] }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Entry Load:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['entry_load'] }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Exit Road:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['exit_load'] }}</span></div>
                </li>
                <li>
                    <div class="facts-title"><span>Thereafter:</span></div>
                    <div class="facts-title-2"><span>{{ $dataArr['item']['thereafter'] }}</span></div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="fund-stats-wrap">
    <div class="container">
        <div class="fund-stats-inner-wrap br-5 bg-gradient no-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12 fund-stats-common fund-stats-lft">
                    <h3>Fund Stats</h3>
                    <div class="fs-content">
                        <span>Objective</span>
                        <p>{!! nl2br($dataArr['item']['objective']) !!}</p>
                    </div>
                    <div class="fund-stats-data">
                        <ul class="d-flex">
                            <li><p>Benchmark:</p></li>
                            <li><p>{{ $dataArr['item']->indices->name }}</p></li>
                            <li><p>Fund Manager:</p></li>
                            <li><p>{{ $dataArr['item']['fund_manager'] }}</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 fund-stats-common asset-allocation-rgt">
                    <h3>Asset Allocation</h3>
                    <div class="allocation-data d-flex">
                        <div class="a-data">
                            <span class="data">{{ $dataArr['item']['aa_col1_value'] }}</span>
                            <span class="title">{{ $dataArr['item']['aa_col1_text'] }}</span>
                        </div>
                        <div class="a-data">
                            <span class="data">{{ $dataArr['item']['aa_col2_value'] }}</span>
                            <span class="title">{{ $dataArr['item']['aa_col2_text'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="compare-existing-scheme">
    <div class="container">
        <div class="compare-top-title br-5 bg-dg base-pad">
            <h6>Comparable existing schemes</h6>
        </div>
        <div class="compare-scheme-table table-w">
            <div class="compare-table-wrap border-s br-5">
                <table id="comparable-schemes" class="bg-gry box-shadow">
                    <tbody>
                        <tr>
                            <td>{{ $dataArr['item']['ces_row1_col1_text'] }}</td>
                            <td>{{ $dataArr['item']['ces_row1_col2_text'] }}</td>
                            <td>{{ $dataArr['item']['ces_row1_col3_text'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $dataArr['item']['ces_row2_col1_text'] }}</td>
                            <td>{{ $dataArr['item']['ces_row2_col2_text'] }}</td>
                            <td>{{ $dataArr['item']['ces_row2_col3_text'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="fund-stats-wrap fund-prog">
    <div class="container">
        <div class="fund-stats-inner-wrap br-5 bg-gradient no-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12 fund-stats-common fund-stats-lft">
                    <h3>Fund Prognosis</h3>
                    <div class="fs-content">
                        <span>Idea Distiller</span>
                        <p>{!! nl2br($dataArr['item']['idea_distiller']) !!}</p>
                    </div>
                    <div class="fund-stats-data">
                        <ul class="d-flex">
                            <li><p>Fund House AAUM:</p></li>
                            <li><p>{{ $dataArr['item']['fund_house_aaum'] }}</p></li>
                            <li><p>Fund Manager:</p></li>
                            <li><p>{{ $dataArr['item']['fund_manager_experience'] }}</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 fund-stats-common asset-allocation-rgt">
                    <h3>Scheme DNA
                        <span>4 fundamentals</span>
                    </h3>
                    <ul class="scheme-data">
                        <li>
                            <span>UNIQNESS</span>
                            <select id="uniqness">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>  
                            </select>
                        </li>
                        <li>
                            <span>RETURN</span>
                            <select id="return">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>  
                            </select>
                        </li>
                        <li>
                            <span>RISK</span>
                            <select id="risk">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>  
                            </select>
                        </li>
                        <li>
                            <span>OPERABILITY</span>
                            <select id="operability">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>  
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="oomp-factor no-bg">
    <div class="container">
        <div class="oomp-wrap br-5">
            <h3>OOMP Factor</h3>
            <p>{!! nl2br($dataArr['item']['oomph_factor']) !!}</p>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script src="{{asset('themes/frontend/assets/jquery-bar-rating-master/dist/jquery.barrating.min.js')}}"></script>
<script>
    $(function() {
        $('#uniqness').barrating({
            theme: 'fontawesome-stars',
            initialRating: {{ $dataArr['item']['uniqness'] }},
            readonly: true
        });
        $('#return').barrating({
            theme: 'fontawesome-stars',
            initialRating: {{ $dataArr['item']['return'] }},
            readonly: true
        });
        $('#risk').barrating({
            theme: 'fontawesome-stars',
            initialRating: {{ $dataArr['item']['risk'] }},
            readonly: true
        });
        $('#operability').barrating({
            theme: 'fontawesome-stars',
            initialRating: {{ $dataArr['item']['operability'] }},
            readonly: true
        });
    });
</script>
@endpush