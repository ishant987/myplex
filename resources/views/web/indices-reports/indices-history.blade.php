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
                                        <input type="date" class="form-control" placeholder="Start Date" name="start_date"
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

    <!-- Highcharts library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
    let indicesGraphData = document.getElementById('indices_graph').value;

    if (indicesGraphData !== '') {
        indicesGraphData = JSON.parse(indicesGraphData);

        let seriesData = [];
        console.log('indicesGraphData====',indicesGraphData);
        

        // Prepare series data for each index
        for (let index in indicesGraphData) {
            if (indicesGraphData.hasOwnProperty(index)) {
                let series = {
                    name: index,
                    data: [],
                    dataLabels: {
                        enabled: false // Ensure data labels are disabled
                    }
                };

                indicesGraphData[index].forEach((item) => {
                    // Ensure date is parsed correctly (example assumes item[0] is the date)
                    let date = new Date(item[0]).getTime(); // Convert to timestamp
                    let value = parseFloat(item[1]); // Convert value to number

                    if (!isNaN(value)) { // Check if value is a valid number
                        series.data.push([date, value]);
                    } else {
                        console.warn(`Invalid data value encountered: ${item[1]}`);
                    }
                });

                seriesData.push(series);
            }
        }

        // Initialize Highcharts chart
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
                min: 0 // Adjust as needed
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: false // Disable data labels for the line chart
                    }
                }
            },
            series: seriesData, // Assign series data
            
        });
    } else {
        console.error('No data found for indicesGraphData.');
    }

    $('.highcharts-credits').hide();
});
    </script>
@endsection

<style type="text/css">
    
.highcharts-label.highcharts-series-label{
    display: none;
}

</style>
