@extends('web.layout.app')
@if (isset($dataArr['meta_title']))
    @section('page-title'){{ $dataArr['meta_title'] }}@stop
    @else
    @section('page-title'){{ $dataArr['title'] | $fundMaster->fund_name }}@stop
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

                    @section('vue-js') @stop
                    @section('content')

                        <section class="inner_banner_section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="inner_section_banner">
                                            <h4>Fund Watch : {{ $fundMaster->fund_name }}</h4>
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
                                                            {{ $fundWatch->preamble }}
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
                                                                    <td class="text-center">{{ $fundMaster->classification }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Bench Mark:</td>
                                                                    <td class="text-center">{{ $fundMaster->indices_name }}</td>
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
                                                    <div class="pentatech_inner" id="aaum_chart_div" style="height: 500px;">

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
                                                    <div
                                                        class="pentatech_filter_title fund_watch_title m-3 d-block d-sm-flex justify-content-between">
                                                        <h4>Research Team Members</h4>
                                                        <ul class="d-block d-sm-flex p-0 m-0">
                                                            @php
                                                                $team = explode(',', $fundWatch->team);
                                                            @endphp
                                                            @foreach ($team as $key => $val)
                                                                <li>{{ $key + 1 }}.{{ $val }}</li>
                                                            @endforeach

                                                        </ul>
                                                    </div>
                                                    <div class="pentatech_inner">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="r_team_member_left">
                                                                    <h4>Fund Philosophy</h4>
                                                                    <p>
                                                                        {{ $fundWatch->philosophy }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="r_team_member_left investment">
                                                                    <h4>Investment Style</h4>
                                                                    <p> {{ $fundWatch->investment_style }}</p>
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
                                                                    <div id="example_wrapper"
                                                                        class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-6"></div>
                                                                            <div class="col-sm-12 col-md-6"></div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 ">
                                                                                <table 
                                                                                    class="table table-striped no-footer"
                                                                                    style="width: 100%;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="green_bg sorting sorting_asc"
                                                                                                tabindex="0" aria-controls="example"
                                                                                                rowspan="1" colspan="1"
                                                                                                aria-sort="ascending"
                                                                                                aria-label="Time Frame: activate to sort column descending"
                                                                                                style="width: 213px;">Time Frame</th>
                                                                                            <th class="dark_bg sorting" tabindex="0"
                                                                                                aria-controls="example" rowspan="1"
                                                                                                colspan="1"
                                                                                                aria-label="Amount: activate to sort column ascending"
                                                                                                style="width: 156px;">Amount</th>
                                                                                            <th class="dark_bg sorting" tabindex="0"
                                                                                                aria-controls="example" rowspan="1"
                                                                                                colspan="1"
                                                                                                aria-label="Percentage %: activate to sort column ascending"
                                                                                                style="width: 244px;">Percentage %</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody class="lumsum_table_body">

                                                                                    </tbody>
                                                                                </table>
                                                                                
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-5"></div>
                                                                            <div class="col-sm-12 col-md-7"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p>* % One (AGR) 1 Year and Annual</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="pentatech_filter_title fund_watch_title m-3">
                                                        <h4>SIP (Amount Invested } Rs. 1,00.000/-)</h4>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive">
                                                                    <table  class="table table-striped" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg">Time Frame</th>
                                                                                <th class="dark_bg">Amount</th>
                                                                                <th class="dark_bg">Percentage %</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="sip_body">

                                                                        </tbody>
                                                                    </table>
                                                                    <p>* % One (AGR) 1 Year and Annual</p>
                                                                </div>
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
                                                                <div class="table-responsive ">
                                                                    <table  class="table table-striped" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg">Return</th>
                                                                                <th class="dark_bg">6 M</th>
                                                                                <th class="dark_bg">1 Y</th>
                                                                                <th class="dark_bg">2 Y</th>
                                                                                <th class="dark_bg">3 Y</th>
                                                                                <th class="dark_bg">5 Y</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="retunr_continus_table">
                                                                            
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
                                                                    <table  class="table table-striped" style="width:100%">
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
                                                        <p>A scheme that has been over a decade in existence. In the initial period, there were
                                                            enormous challenges that nearly threatened the existence of the scheme and perhaps
                                                            the fund house too. Currently occupying the Large and midcap category and with a
                                                            fund manager who has been in charge for all of its life brings a certain comfort to
                                                            the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in
                                                            returns, recognition and asset growth since 2018.</p>
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
                                                    <div class="pentatech_inner" id="returnLessIndex_chart_div" style="height: 500px;">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="pentatech_filter_title m-3">
                                                        <h4>Return Less Index Rank</h4>
                                                    </div>
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer">
                                                                <div class="table-responsive ">
                                                                    <table 
                                                                        class="table table-striped no-footer"
                                                                        style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="green_bg sorting sorting_asc"
                                                                                    tabindex="0" aria-controls="example"
                                                                                    rowspan="1" colspan="1"
                                                                                    aria-sort="ascending"
                                                                                    aria-label="Time Frame: activate to sort column descending"
                                                                                    style="width: 213px;">Time Frame</th>
                                                                                <th class="dark_bg sorting" tabindex="0"
                                                                                    aria-controls="example" rowspan="1"
                                                                                    colspan="1"
                                                                                    aria-label="Amount: activate to sort column ascending"
                                                                                    style="width: 156px;">Rank</th>
                                                                                <th class="dark_bg sorting" tabindex="0"
                                                                                    aria-controls="example" rowspan="1"
                                                                                    colspan="1"
                                                                                    aria-label="Percentage %: activate to sort column ascending"
                                                                                    style="width: 244px;">Active funds</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="return_less_rank_table">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="px-3">
                                                        <p>A scheme that has been over a decade in existence. In the initial period, there were
                                                            enormous challenges that nearly threatened the existence of the scheme and perhaps
                                                            the fund house too. Currently occupying the Large and midcap category and with a
                                                            fund manager who has been in charge for all of its life brings a certain comfort to
                                                            the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in
                                                            returns, recognition and asset growth since 2018.</p>
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
                                            <img src="{{asset('themes/frontend/assets/v1/img/fund-watch-graph.jpg')}}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-md-6 ps-0">
                                        <div class="cta_prameter_content">
                                            <p>A scheme that has been over a decade in existence. In the initial period, there were enormous
                                                challenges that nearly threatened the existence of the scheme and perhaps the fund house too.
                                                Currently occupying the Large and midcap category and with a fund manager who has been in charge
                                                for all of its life brings a certain comfort to the investors, Mirae Asset Emerging Bluechip
                                                fund has occupied pole position in returns, recognition and asset growth since 2018.</p>
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
                                                                <div class="table-responsive ">
                                                                    <table  class="table table-striped" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="dark_bg">Ratios</th>
                                                                                <th class="dark_bg">Jensen’s Alpha</th>
                                                                                <th class="dark_bg">Beta</th>
                                                                                <th class="dark_bg">Votality</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="risk_alpha_table">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="px-3">
                                                        <p>A scheme that has been over a decade in existence. In the initial period, there were
                                                            enormous challenges that nearly threatened the existence of the scheme and perhaps
                                                            the fund house too. Currently occupying the Large and midcap category and with a
                                                            fund manager who has been in charge for all of its life brings a certain comfort to
                                                            the investors, Mirae Asset Emerging Bluechip fund has occupied pole position in
                                                            returns, recognition and asset growth since 2018.</p>
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
                                                    <p>{{ $fundWatch->composition_analysis_top }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="px-3">
                                                        <div class="">
                                                            <div class="datatable_ll main_trer performance_parameter_table">
                                                                <div class="table-responsive comp_html">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="px-3">
                                                        <p>{{ $fundWatch->composition_analysis_top }}</p>
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
                                                                <div class="table-responsive ">
                                                                    <table  class="table table-striped" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="dark_bg">Equity</th>
                                                                                <th class="dark_bg">Debt</th>
                                                                                <th class="dark_bg">SOV</th>
                                                                                <th class="dark_bg">Cash</th>
                                                                                <th class="dark_bg">Other Cuurency</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="portfolio_break_up">
                                                                           
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
                                            <p>{{ $fundWatch->feedback }}</p>
                                        </div>
                                        <p><b>Disclaimer:</b> The entire report is based on independent utilization of statistical tools for
                                            evaluating performance in mutual funds. myplexus.com and its personnel have taken every precaution
                                            to ensure the authenticity of data. Every precaution has been taken to ensure the statistical
                                            outputs are correct. However, myplexus.com or any of its personnel cannot be held responsible for
                                            outcome of actions taken on the basis of its report on this fund or any other</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <input type="hidden" value="{{ $AAUMValue }}" id="aaum_values">
                        <input type="hidden" value="{{ $returnLessIndex }}" id="returnLessIndex">
                        <input type="hidden" value="{{ $fundMaster->fund_code }}" id="fund_code">
                        <input type="hidden" value="{{ $fundMaster->fund_type_id }}" id="fund_type">
                        <input type="hidden" value="{{ $fundMaster->indices_name }}" id="indices_name">
                        <div id="loaging_image" class="d-none">
                            <img  class="text-center mt-3" src="{{asset('themes/frontend/assets/v1/img/loading.gif')}}" alt="">
                        </div>
                    @stop
                    @push('scripts')
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
                        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                        <script type="text/javascript">
                        let loadingImage='<img  class="text-center mt-3" src="{{asset('themes/frontend/assets/v1/img/loading.gif')}}" alt="">';
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawVisualization);
                            google.charts.setOnLoadCallback(drawreturnLessIndex);
                            let fund_code = $('#fund_code').val();
                            let indices_name = $('#indices_name').val();
                            let fund_type = $('#fund_type').val();
                            getReturnLessRank();
                            getFundCompostion();
                            schemeSIP();
                            getLumSum();
                            getRiskAdjustedAlpha();
                            getReturnContinus();
                            getPortfolioBreakUp();

                            function drawVisualization() {
                                // Some raw data (not necessarily accurate)\
                                let aaum_data = $('#aaum_values').val();
                                var data = google.visualization.arrayToDataTable(JSON.parse(aaum_data));

                                var options = {
                                    title: "{{ $fundMaster->fund_name }}",
                                    // vAxis: {
                                    //     title: 'Cups'
                                    // },
                                    // hAxis: {
                                    //     title: 'Month'
                                    // },
                                    seriesType: 'bars',
                                    series: {
                                        5: {
                                            type: 'line'
                                        }
                                    }
                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('aaum_chart_div'));
                                chart.draw(data, options);
                            }

                            function drawreturnLessIndex() {
                                // Some raw data (not necessarily accurate)\
                                let returnLessIndex = $('#returnLessIndex').val();
                                var data = google.visualization.arrayToDataTable(JSON.parse(returnLessIndex));

                                var options = {
                                    title: "{{ $fundMaster->fund_name }}",
                                    // vAxis: {
                                    //     title: 'Cups'
                                    // },
                                    // hAxis: {
                                    //     title: 'Month'
                                    // },
                                    seriesType: 'bars',
                                    series: {
                                        5: {
                                            type: 'line'
                                        }
                                    }
                                };

                                var chart = new google.visualization.ComboChart(document.getElementById('returnLessIndex_chart_div'));
                                chart.draw(data, options);
                            }

                            function getFundCompostion() {
                                $('.comp_html').html(loadingImage);
                                axios.get('/fund-watch/fund-compositon/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.comp_html').html(res.data.html);
                                        }
                                    })
                            }

                            function getLumSum() {
                                $('.lumsum_table_body').html(loadingImage);
                                axios.get('/fund-watch/fund-lumsum/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.lumsum_table_body').html(res.data.html);
                                        }
                                    })
                            }

                            function getRiskAdjustedAlpha() {
                                $('.risk_alpha_table').html(loadingImage);
                                axios.get('/fund-watch/fund-risk-alpha/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.risk_alpha_table').html(res.data.html);
                                        }
                                    })
                            }

                            function getPortfolioBreakUp() {
                                $('.portfolio_break_up').html(loadingImage);
                                axios.get('/fund-watch/fund-portfolio-break-up/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.portfolio_break_up').html(res.data.html);
                                        }
                                    })
                            }

                            function getReturnContinus() {
                                $('.retunr_continus_table').html(loadingImage);
                                axios.get('/fund-watch/fund-return-continus/' + fund_code)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.retunr_continus_table').html(res.data.html);
                                        }
                                    })
                            }

                            function getReturnLessRank() {
                                $('.return_less_rank_table').html(loadingImage);
                                axios.get('/fund-watch/fund-return-less-rank/' + fund_code + '/' + fund_type + '/' + indices_name)
                                    .then(res => {
                                        if (res.data.status == 'success') {
                                            $('.return_less_rank_table').html(res.data.html);
                                        }
                                    })
                            }
                            async function schemeSIP() {
                                $('.sip_body').html(loadingImage);
                                await axios.get('/fund-watch/fund-sip/' + fund_code)
                                    .then(response => {
                                        let sipDataArr = response.data.scheme_sip_data
                                        for (var keyDur of Object.keys(sipDataArr)) {

                                            let all_values = JSON.parse(sipDataArr[keyDur].ALLVALUES)
                                            let all_dates = JSON.parse(sipDataArr[keyDur].ALLDATES)
                                            let sip_return = calculate_sip(all_dates, all_values)
                                            if (isNaN(sip_return)) {
                                                sip_return = '';
                                            } else {
                                                sip_return = parseFloat(sip_return).toFixed(2);
                                            }
                                            sipDataArr[keyDur].sip_return = sip_return
                                        }
                                        let SIPHTML = '';
                                        $.each(sipDataArr, function(key, val) {
                                            SIPHTML += '<tr>';
                                            SIPHTML += '<td data-label="Time Frame">' + key + '</td>';
                                            SIPHTML += '<td data-label="Amount">' + val.CURRENTVALUE + '</td>';
                                            SIPHTML += '<td data-label="Percentage %"> ' + val.sip_return + '%</td>';
                                            SIPHTML += '</tr>';
                                        });
                                        $('.sip_body').html(SIPHTML);
                                        // console.log(sipDataArr, SIPHTML);
                                    })
                                    .catch(error => {
                                        //var message = error.response.data.message || error.message
                                        console.log(error);
                                    })
                                    .finally(() => {
                                        // that.process = false
                                    })
                            }

                            function calculate_sip(dates, values) {
                                //alert(dates+' '+values);
                                var x = XIRR(values, dates, 0.1);
                                //alert(x);
                                x = x * 100;
                                //document.write(x);
                                return x;
                            }

                            function XIRR(values, dates, guess) {
                                // Credits: algorithm inspired by Apache OpenOffice

                                // Calculates the resulting amount
                                var irrResult = function(values, dates, rate) {
                                    var r = rate + 1;
                                    var result = values[0];
                                    for (var i = 1; i < values.length; i++) {
                                        result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
                                    }
                                    return result;
                                }

                                // Calculates the first derivation
                                var irrResultDeriv = function(values, dates, rate) {
                                    var r = rate + 1;
                                    var result = 0;
                                    for (var i = 1; i < values.length; i++) {
                                        var frac = moment(dates[i]).diff(moment(dates[0]), 'days') / 365;
                                        result -= frac * values[i] / Math.pow(r, frac + 1);
                                    }
                                    return result;
                                }

                                // Check that values contains at least one positive value and one negative value
                                var positive = false;
                                var negative = false;
                                for (var i = 0; i < values.length; i++) {
                                    if (values[i] > 0) positive = true;
                                    if (values[i] < 0) negative = true;
                                }

                                // Return error if values does not contain at least one positive value and one negative value
                                if (!positive || !negative) return '#NUM!';

                                // Initialize guess and resultRate
                                var guess = (typeof guess === 'undefined') ? 0.1 : guess;
                                var resultRate = guess;

                                // Set maximum epsilon for end of iteration
                                var epsMax = 1e-10;

                                // Set maximum number of iterations
                                var iterMax = 60;

                                // Implement Newton's method
                                var newRate, epsRate, resultValue;
                                var iteration = 0;
                                var contLoop = true;
                                do {
                                    resultValue = irrResult(values, dates, resultRate);
                                    newRate = resultRate - resultValue / irrResultDeriv(values, dates, resultRate);
                                    epsRate = Math.abs(newRate - resultRate);
                                    resultRate = newRate;
                                    contLoop = (epsRate > epsMax) && (Math.abs(resultValue) > epsMax);
                                } while (contLoop && (++iteration < iterMax));
                                if (contLoop) return '#NUM!';
                                // Return internal rate of return
                                return resultRate;
                            }
                        </script>
                    @endpush
