@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.indices_report') }}">indices report</a></li>
                        <li>Indices History</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="{{ route('user.indices-history') }}" method="get" id="searchForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select class="select2 multiple index_select" multiple name="indices[]"
                                            data-placeholder="Select Indices" id="select_fund_multiple" data-max="6"
                                            onchange='fund_multiple(this)'>
                                            <option value="">Select Indices</option>
                                            @foreach ($indices as $index)
                                                <option value="{{ $index->corelation }}"
                                                    @if (isset($request['indices']) && in_array($index->corelation, $request['indices'])) selected @endif>{{ $index->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger" id="fund_msgg"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="Start Date"
                                            name="start_date"
                                            value="{{ !empty($request['start_date']) ? \Carbon\Carbon::parse($request['start_date'])->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="End Date" name="end_date"
                                            value="{{ !empty($request['end_date']) ? \Carbon\Carbon::parse($request['end_date'])->format('Y-m-d') : '' }}">
                                        <input type="hidden" id="indices_graph" value="{{ json_encode($indices_vals) }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    

                    <div class="share_pdf">
                                
                        <div class="sharethis-inline-share-buttons" ></div>
                        
                    </div>

                    @if (count($indices_vals) != 0)
                        <div class="graph_section">
                            <div id="chartContainer" style="height: 500px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    @else
                        <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div>
                    @endif

                    

                </div>
                @if (isset($indices_vals))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
              @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script>
        function initIndicesHistoryPage() {
            var indicesGraphField = document.getElementById('indices_graph');

            if (!indicesGraphField) {
                return;
            }

            var indicesGraphData = indicesGraphField.value;

            if (indicesGraphData !== '') {
                indicesGraphData = JSON.parse(indicesGraphData);

                var seriesData = [];

                for (var index in indicesGraphData) {
                    if (Object.prototype.hasOwnProperty.call(indicesGraphData, index)) {
                        var series = {
                            name: index,
                            data: [],
                            dataLabels: {
                                enabled: false
                            }
                        };

                        indicesGraphData[index].forEach(function(item) {
                            var date = new Date(item[0]).getTime();
                            var value = parseFloat(item[1]);

                            if (!isNaN(value)) {
                                series.data.push([date, value]);
                            }
                        });

                        seriesData.push(series);
                    }
                }

                Highcharts.chart('chartContainer', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Indices History'
                    },
                    xAxis: {
                        type: 'datetime',
                        title: {
                            text: 'Date'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Value'
                        },
                        min: 0
                    },
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: false
                            }
                        }
                    },
                    series: seriesData
                });
            }

            if (window.jQuery) {
                $('.highcharts-credits').hide();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initIndicesHistoryPage);
        } else {
            initIndicesHistoryPage();
        }
    </script>
@endpush

<style type="text/css">
    
.highcharts-label.highcharts-series-label{
    display: none;
}

</style>
