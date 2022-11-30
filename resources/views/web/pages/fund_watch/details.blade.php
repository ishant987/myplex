@extends('web.layout.app')
{{-- @if(isset($dataArr['meta_title']))
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
@endif --}}

@section('vue-js') @stop
@section('content')
    
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Fund Watch : {{$fundMaster->fund_name}}</h4>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pentatech_section section">
    <div class="container">
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pentatech_filter_title m-3">
                                <h4>Preamble</h4>
                            </div>
                            <div class="pentatech_inner">
                                <p>
                                    {{$fundWatch->preamble}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pentatech_filter_title m-3">
                                <h4>Fund Details</h4>
                            </div>
                            <div class="pentatech_inner fund_watch_2_table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Fund Details:</td>
                                            <td class="text-center">9th August 2010</td>
                                        </tr>
                                        <tr>
                                            <td>Fund Type:</td>
                                            <td class="text-center">Regular Plan - Growth | 59.60</td>
                                        </tr>
                                        <tr>
                                            <td>Bench Mark:</td>
                                            <td class="text-center">{{$fundMaster->indices_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pentatech_filter_title m-3">
                                <h4>Management Details</h4>
                            </div>
                            <div class="pentatech_inner fund_watch_2_table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Fund Details:</td>
                                            <td class="text-center">9th August 2010</td>
                                        </tr>
                                        <tr>
                                            <td>Fund Type:</td>
                                            <td class="text-center">Regular Plan - Growth | 59.60</td>
                                        </tr>
                                        <tr>
                                            <td>Bench Mark:</td>
                                            <td class="text-center">High Value</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pentatech_filter_title m-3">
                                <h4>AAUM Growth</h4>
                            </div>
                            <div class="pentatech_inner">
                                <img src="img/fund-watch-graph.jpg" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pentatech_filter_title fund_watch_title m-3 d-block d-sm-flex justify-content-between">
                                <h4>Research Team Members</h4>
                                <ul class="d-block d-sm-flex p-0 m-0">
                                    @php
                                    $team =explode(',',$fundWatch->team);
                                    @endphp
                                    @foreach ($team as $key=>$val )
                                    <li>{{$key+1}}.{{$val}}</li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                            <div class="pentatech_inner">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="r_team_member_left">
                                            <h4>Fund Philosophy</h4>
                                            <p>
                                                {{$fundWatch->philosophy}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="r_team_member_left investment">
                                            <h4>Investment Style</h4>
                                            <p> {{$fundWatch->investment_style}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                    <h2>Performance Parameter</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pentatech_filter_title fund_watch_title m-3">
                                <h4>Lumpsum (Amount Invested } Rs. 1,00.000/-)</h4>
                            </div>
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example" class="table table-striped dataTable no-footer" style="width: 100%;">
                                                <thead>
                                                    <tr><th class="green_bg sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Time Frame: activate to sort column descending" style="width: 213px;">Time Frame</th><th class="dark_bg sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Amount: activate to sort column ascending" style="width: 156px;">Amount</th><th class="dark_bg sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Percentage %: activate to sort column ascending" style="width: 244px;">Percentage %</th></tr>
                                                </thead>
                                                <tbody>
                                               @if($lumbsum!=null)    
                                                @forelse($lumbsum as $key=>$val )
                                                    <tr class="{{$loop->index%2 ? 'even' : 'odd'}}">
                                                        <td data-label="Time Frame" class="sorting_1">{{$key}}</td>
                                                        <td data-label="Amount">{{$val['amount']}}</td>
                                                        <td data-label="Percentage %"> {{$val['percentage']}}%</td>
                                                    </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3">No data</td>
                                                </tr>
                                                @endforelse
                                                @else
                                                <tr>
                                                    <td colspan="3">No data</td>
                                                </tr>
                                                @endif
                                            </table></div></div><div class="row"><div class="col-sm-12 col-md-5"></div><div class="col-sm-12 col-md-7"></div></div></div>
                                            <p>* % One (AGR) 1 Year and Annual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pentatech_filter_title fund_watch_title m-3">
                                <h4>Lumpsum (Amount Invested } Rs. 1,00.000/-)</h4>
                            </div>
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="green_bg">Time Frame</th>
                                                        <th class="dark_bg">Amount</th>
                                                        <th class="dark_bg">Percentage %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="Time Frame">1 Year</td>
                                                        <td data-label="Amount">9625/-</td>
                                                        <td data-label="Percentage %"> 2.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Time Frame">2 Year</td>
                                                        <td data-label="Amount">9625/-</td>
                                                        <td data-label="Percentage %"> 2.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Time Frame">3 Year</td>
                                                        <td data-label="Amount">9625/-</td>
                                                        <td data-label="Percentage %"> 2.25%</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <p>* % One (AGR) 1 Year and Annual</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pentatech_filter_title fund_watch_title m-3">
                                <h4>Return (Continious)</h4>
                            </div>
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="green_bg">Return</th>
                                                        <th class="dark_bg">6 M</th>
                                                        <th class="dark_bg">1 Y</th>
                                                        <th class="dark_bg">2 Y</th>
                                                        <th class="dark_bg">3 Y</th>
                                                        <th class="dark_bg">4 Y</th>
                                                        <th class="dark_bg">5 Y</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="Return">Benchmark</td>
                                                        <td data-label="6M">10/-</td>
                                                        <td data-label="1Y">10/-</td>
                                                        <td data-label="2Y">10/-</td>
                                                        <td data-label="3Y">10/-</td>
                                                        <td data-label="4Y">10/-</td>
                                                        <td data-label="5Y">10/-</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Return">Scheme</td>
                                                        <td data-label="6M">10/-</td>
                                                        <td data-label="1Y">10/-</td>
                                                        <td data-label="2Y">10/-</td>
                                                        <td data-label="3Y">10/-</td>
                                                        <td data-label="4Y">10/-</td>
                                                        <td data-label="5Y">10/-</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Return">Category AV</td>
                                                        <td data-label="6M">10/-</td>
                                                        <td data-label="1Y">10/-</td>
                                                        <td data-label="2Y">10/-</td>
                                                        <td data-label="3Y">10/-</td>
                                                        <td data-label="4Y">10/-</td>
                                                        <td data-label="5Y">10/-</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pentatech_filter_title fund_watch_title m-3">
                                <h4>Return (Continious)</h4>
                            </div>
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="green_bg">Return</th>
                                                        <th class="dark_bg">6 M</th>
                                                        <th class="dark_bg">1 Y</th>
                                                        <th class="dark_bg">2 Y</th>
                                                        <th class="dark_bg">3 Y</th>
                                                        <th class="dark_bg">4 Y</th>
                                                        <th class="dark_bg">5 Y</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="Return">Benchmark</td>
                                                        <td data-label="6M">10/-</td>
                                                        <td data-label="1Y">10/-</td>
                                                        <td data-label="2Y">10/-</td>
                                                        <td data-label="3Y">10/-</td>
                                                        <td data-label="4Y">10/-</td>
                                                        <td data-label="5Y">10/-</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Return">Scheme</td>
                                                        <td data-label="6M">10/-</td>
                                                        <td data-label="1Y">10/-</td>
                                                        <td data-label="2Y">10/-</td>
                                                        <td data-label="3Y">10/-</td>
                                                        <td data-label="4Y">10/-</td>
                                                        <td data-label="5Y">10/-</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Return">Category AV</td>
                                                        <td data-label="6M">10/-</td>
                                                        <td data-label="1Y">10/-</td>
                                                        <td data-label="2Y">10/-</td>
                                                        <td data-label="3Y">10/-</td>
                                                        <td data-label="4Y">10/-</td>
                                                        <td data-label="5Y">10/-</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div class="px-3">
                                <p>A scheme that has been over a decade in existence. In the initial period, there were enormous challenges that nearly threatened the existence of the scheme and perhaps the fund house too. Currently occupying the Large and midcap category and with a fund manager who has been in charge for all of its life brings a certain comfort to the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in returns, recognition and asset growth since 2018.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pentatech_filter_title m-3">
                                <h4>Return Less Index</h4>
                            </div>
                            <div class="pentatech_inner">
                                <img src="img/fund-watch-graph.jpg" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pentatech_filter_title m-3">
                                <h4>Return Less Index Rank</h4>
                            </div>
                            <div class="pentatech_inner">
                                <img src="img/fund-watch-graph.jpg" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="px-3">
                                <p>A scheme that has been over a decade in existence. In the initial period, there were enormous challenges that nearly threatened the existence of the scheme and perhaps the fund house too. Currently occupying the Large and midcap category and with a fund manager who has been in charge for all of its life brings a certain comfort to the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in returns, recognition and asset growth since 2018.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="parametaer_cta_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="cta_parameter_graph">
                    <img src="img/fund-watch-graph.jpg" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6 ps-0">
                <div class="cta_prameter_content">
                    <p>A scheme that has been over a decade in existence. In the initial period, there were enormous challenges that nearly threatened the existence of the scheme and perhaps the fund house too. Currently occupying the Large and midcap category and with a fund manager who has been in charge for all of its life brings a certain comfort to the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in returns, recognition and asset growth since 2018.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-5">
    <div class="container">
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                    <h2>Performance Parameter</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pentatech_filter_title fund_watch_title m-3">
                                <h4>Risk Adjusted Alpha (Jensen’s) and The Risk Ratios</h4>
                            </div>
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="dark_bg">Ratios</th>
                                                        <th class="dark_bg">Jensen’s Alpha</th>
                                                        <th class="dark_bg">Beta</th>
                                                        <th class="dark_bg">Votality</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="Ratios">H1 FY’ 17-18</td>
                                                        <td data-label="Jensen’s Alpha">2.06</td>
                                                        <td data-label="Beta">25.6%</td>
                                                        <td data-label="Votality">13950.10</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Ratios">H1 FY’ 17-18</td>
                                                        <td data-label="Jensen’s Alpha">2.06</td>
                                                        <td data-label="Beta">25.6%</td>
                                                        <td data-label="Votality">13950.10</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-label="Ratios">H1 FY’ 17-18</td>
                                                        <td data-label="Jensen’s Alpha">2.06</td>
                                                        <td data-label="Beta">25.6%</td>
                                                        <td data-label="Votality">13950.10</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="px-3">
                                <p>A scheme that has been over a decade in existence. In the initial period, there were enormous challenges that nearly threatened the existence of the scheme and perhaps the fund house too. Currently occupying the Large and midcap category and with a fund manager who has been in charge for all of its life brings a certain comfort to the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in returns, recognition and asset growth since 2018.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                    <h2>Fund Composition Analysis</h2>
                    <div class="col-md-12">
                        <div class="px-3">
                            <p>{{$fundWatch->composition_analysis_top}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        @foreach($fundCompAnalysis['headers'] as $key=>$val)
                                                            <th class="dark_bg">{{$val}}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($fundCompAnalysis['result'])
                                                        @foreach($fundCompAnalysis['result'] as $key=>$valus)
                                                        <tr>
                                                            <td>
                                                                {{$key}}
                                                            </td>
                                                            @foreach ($valus as $val )
                                                                <td>
                                                                    {{$val}}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="{{count($fundCompAnalysis['headers'])}}" align="center">No data</td>
                                                    </tr>
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="px-3">
                                <p>{{$fundWatch->composition_analysis_top}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper fund_watch_parameter_wrapper">
                    <div class="pentatech_filter_title fund_watch_title m-3">
                        <h4>Portfolio Breakup</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="px-3">
                                <div class="">
                                    <div class="datatable_ll main_trer performance_parameter_table">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="dark_bg">Equity</th>
                                                        <th class="dark_bg">Debt</th>
                                                        <th class="dark_bg">SOV</th>
                                                        <th class="dark_bg">Cash</th>
                                                        <th class="dark_bg">Other Cuurency</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="Scripe">{{$PortFoliBreakup['Equity']}}</td>
                                                        <td data-label="Debt">{{$PortFoliBreakup['Corporate Debt']}}</td>
                                                        <td data-label="SOV">{{$PortFoliBreakup['SOV']}}</td>
                                                        <td data-label="Cash">{{$PortFoliBreakup['Cash']}}</td>
                                                        <td data-label="Other Cuurency">{{$PortFoliBreakup['Others']}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="fund_watch_feedback mb-4">
                    <h4>Myplexus.com Feedback</h4>
                    <p>{{$fundWatch->feedback}}</p>
                </div>
                <p><b>Disclaimer:</b> The entire report is based on independent utilization of statistical tools for evaluating performance in mutual funds. myplexus.com and its personnel have taken every precaution to ensure the authenticity of data. Every precaution has been taken to ensure the statistical outputs are correct. However, myplexus.com or any of its personnel cannot be held responsible for outcome of actions taken on the basis of its report on this fund or any other</p>
            </div>
        </div>
    </div>
</section>
@stop
@push('style')
@endpush