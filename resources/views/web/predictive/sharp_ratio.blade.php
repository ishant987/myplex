@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                        <li><a href="{{route('user.predictive')}}">Predictive</a></li>
                        <li>By Sharp Ratio</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="fund_id" class="select2" id="allocation_select_fund"
                                            onchange="set_fund_select_val(this.value)">
                                            @foreach ($fundMasterData as $fund)
                                                <option value="{{ $fund->fund_id }}"
                                                    @if ($fund->fund_id == old('fund_id', data_get($getData ?? [], 'fund_id'))) selected @endif>
                                                    {{ $fund->fund_name }}
                                                </option>
                                            @endforeach
                                        </select>


                                        @error('fund_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <p>Date : <span id="date">N/A</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <p>Index Name : <span id="indices_name">N/A</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <p>Index Value : <span id="indices_value">0.0</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="number" name="expected_index" placeholder="Expected Future Index"
                                            value="{{ $expected_index ?? '' }}">
                                    </div>
                                </div>
                                <input type="hidden" name="current_date" id="current_date">
                                <div class="col-md-2">
                                    <div class="bttn_grp alpha_btn">
                                        <button type="submit" name="duration" value="6">6m</button>
                                        <button type="submit" name="duration" value="1">1y</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="share_pdf">
                                
                        <div class="sharethis-inline-share-buttons" ></div>
                        
                    </div>
                    
                    <input type="hidden" name="indices_name" id="indices_details_name"
                        value="{{ isset($indices_details) ? $indices_details->name : '' }}">
                    <input type="hidden" name="fund_name" id="fund_details_name"
                        value="{{ isset($fund_details) ? $fund_details->fund_name : '' }}">
                    <input type="hidden" name="graph_date[]" id="graph_date"
                        value="{{ isset($graph_date) ? json_encode($graph_date) : '' }}">
                    <input type="hidden" name="nav_value[]" id="nav_value"
                        value="{{ isset($nav_value) ? json_encode($nav_value) : '' }}">
                    <input type="hidden" name="closing_value[]" id="closing_value"
                        value="{{ isset($closing_value) ? json_encode($closing_value) : '' }}">

                    {{-- <div class="fund_section new_fund_section">
                        <ul>
                            <li>
                                <p>Current daye :</p>
                                <span>00/00/0000</span>
                            </li>
                            <li>
                                <p>Index name :</p>
                                <span>abc</span>
                            </li>
                            <li>
                                <p>Current value :</p>
                                <span>11.5</span>
                            </li>
                        </ul>
                    </div> --}}

                    <div class="graph_section">
                        {{-- <img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/graph.png"
                            alt=""> --}}

                        <div id="container1"></div>
                    </div>

                </div>
                @if (isset($indices_details))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
              @endif
            </div>
        </div>

    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script>
        function set_fund_select_val(fundId) {

            $.ajax({
                url: '{{ url('fund-details') }}?id=' + fundId,
                type: 'GET',
                success: function(data) {
                    $('#date').html(data.entry_date);
                    $('#indices_name').html(data.name);
                    $('#indices_value').html(data.closing_value);
                    $('#current_date').val(data.entry_date);
                },
                error: function(xhr, status, error) {
                    // console.error('AJAX Error: ' + error);
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            var fund_id = document.getElementById('allocation_select_fund').value;
            set_fund_select_val(fund_id);
        });
    </script>

    <script>
        var indicesName = document.getElementById('indices_details_name').value || 'Index';
        var fundName = document.getElementById('fund_details_name').value || 'Fund NAV';

        var graphDates = @json($graph_date ?? []);
        var navValues = @json($nav_value ?? []);
        var closingValues = @json($closing_value ?? []);

        // console.log("Indices Name:", indicesName);
        // console.log("Fund Name:", fundName);
        // console.log("Graph Dates:", graphDates);
        // console.log("NAV Values:", navValues);
        // console.log("Closing Values:", closingValues);

        var value1_text = indicesName;
        var value2_text = fundName;
        var graph_data1_date = graphDates;
        var graph_data1_value = closingValues;
        var graph_data2_date = graphDates;
        var graph_data2_value = navValues;

        Highcharts.chart('container1', {
            chart: {
                type: 'spline',
                zoomType: 'xy'
            },

            title: {
                text: ''
            },

            xAxis: {
                type: 'datetime',
                labels: {
                    formatter: function() {
                        return Highcharts.dateFormat('%Y-%m-%d', this.value);
                    }
                },
                tickPositioner: function() {
                    // Combine both graph_data1_date and graph_data2_date to show all available dates
                    let allDates = graph_data1_date.concat(graph_data2_date).map(function(date) {
                        return Date.parse(date);
                    });

                    // Sort the dates and return unique values
                    allDates = Array.from(new Set(allDates.sort(function(a, b) {
                        return a - b;
                    })));

                    return allDates;
                }
            },

            yAxis: [{
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: value1_text,
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    }
                },
                {
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: value2_text,
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true
                }
            ],
            time: {
                useUTC: false
            },

            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },

            legend: {
                title: {
                    text: ''
                }
            },

            series: [{
                    yAxis: 0,
                    name: value1_text,
                    marker: {
                        enabled: true,
                        symbol: 'circle'
                    },
                    data: graph_data1_date.map(function(date, i) {
                        return [Date.parse(date), graph_data1_value[i]];
                    }),
                    color: 'red',
                    lineWidth: 1
                },
                {
                    name: value2_text,
                    yAxis: 1,
                    marker: {
                        enabled: true,
                        symbol: 'circle'
                    },
                    data: graph_data2_date.map(function(date, i) {
                        return [Date.parse(date), graph_data2_value[i]];
                    }),
                    color: 'blue',
                    lineWidth: 1,
                    type: 'spline' // Ensures this part is curved
                }
            ]
        });
    </script>
@endsection
