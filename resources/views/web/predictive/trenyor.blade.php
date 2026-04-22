@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                        <li><a href="{{route('user.predictive')}}">Predictive</a></li>
                        <li>By Trenyor</li>
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

                    @if (!empty($message))
                        <div class="graph_table">
                            <p>{{ $message }}</p>
                        </div>
                    @elseif (!empty($fund_series) || !empty($index_series))
                        <div class="graph_section">
                            <div id="container1"></div>
                        </div>
                    @else
                        <div class="graph_table">
                            <p>Select a scheme and period to view the graph.</p>
                        </div>
                    @endif

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

    @if (!empty($fund_series) || !empty($index_series))
        <script>
            var indexSeries = @json($index_series ?? []);
            var fundSeries = @json($fund_series ?? []);

            indexSeries = (indexSeries || []).map(function(point) {
                return [Date.parse(point[0]), point[1]];
            }).filter(function(point) {
                return !isNaN(point[0]) && point[1] !== null;
            });

            fundSeries = (fundSeries || []).map(function(point) {
                return [Date.parse(point[0]), point[1]];
            }).filter(function(point) {
                return !isNaN(point[0]) && point[1] !== null;
            });

            Highcharts.chart('container1', {
                chart: {
                    type: 'spline',
                    zoomType: 'x'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: [{
                    title: {
                        text: '{{ addslashes($indices_details->name ?? ($fund_details->indices_name ?? 'Index')) }}'
                    }
                }, {
                    title: {
                        text: '{{ addslashes($fund_details->fund_name ?? 'Fund NAV') }}'
                    },
                    opposite: true
                }],
                time: {
                    useUTC: false
                },
                tooltip: {
                    shared: true
                },
                series: [{
                    name: '{{ addslashes($indices_details->name ?? ($fund_details->indices_name ?? 'Index')) }}',
                    yAxis: 0,
                    data: indexSeries,
                    color: '#d94f30'
                }, {
                    name: '{{ addslashes($fund_details->fund_name ?? 'Fund NAV') }}',
                    yAxis: 1,
                    data: fundSeries,
                    color: '#1f5f99'
                }]
            });
        </script>
    @endif
@endsection
