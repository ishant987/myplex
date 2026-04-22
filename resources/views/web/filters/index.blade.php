@extends('web.layout.infosolz_user_app')

@section('content')
    @php
        $history = session()->has('history') ? session('history') : [];
        $disable = count($history) > 0 ? true : false;
        // echo '<pre>';
        // print_r($history);
        // exit();
        if (isset($fund_absolute_return) && count($fund_absolute_return) > 0) {
            // dd($fund_absolute_return);
            $ratio_array = ['beta', 'volatility', 'tracking_error'];
            if (isset($report_category) && in_array($report_category, $ratio_array)) {
                $fund_absolute_return = custom_sort($fund_absolute_return);
                // asort($fund_absolute_return);
            } else {
                $fund_absolute_return = custom_sort($fund_absolute_return, 'dsc');
                // arsort($fund_absolute_return);
            }

            if (isset($records) && $records > 0) {
                $fund_absolute_return = array_slice($fund_absolute_return, 0, $records, true);
            }
        }
        // dd($fund_absolute_return);
    @endphp

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li>filters</li>
                    </ul>
                </div>

                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>filters</h2>
                    </div>
                    <div class="light_green_bg">
                        <form class="mb-4" action="">
                            <input type="hidden" name="disable" value="{{ $disable }}">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="ranking" value="range"
                                                    {{ $disable ? 'disabled' : '' }} checked>
                                                Range
                                            </label>
                                            <label>
                                                <input type="radio" name="ranking" value="as_on"
                                                    {{ $disable ? 'disabled' : '' }}>
                                                As on
                                            </label>
                                            @error('ranking')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show">
                                        <div class="form_group">
                                            <input type="text" class={{ $disable ? '' : 'datepicker' }}
                                                placeholder="Start date" name="start_date"
                                                value="{{ old('start_date', $start_date ?? '') }}" readonly>
                                            @error('start_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show">
                                        <div class="form_group">
                                            <input type="text" class={{ $disable ? '' : 'datepicker' }}
                                                placeholder="End date" name="end_date"
                                                value="{{ old('end_date', $end_date ?? '') }}" readonly>
                                            @error('end_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_hide">
                                        <div class="form_group">
                                            <input type="text" name="as_on_date"
                                                class={{ $disable ? '' : 'datepicker' }} placeholder="date"
                                                value="{{ old('as_on_date', $as_on_date ?? '') }}" readonly>
                                        </div>
                                    </div>

                                    <input type="hidden" id="checkedFundIds" value=""
                                        name="checkedFundIds">

                                    <input type="hidden" id="fundIds" value="{{ $checkedFundIds ?? '' }}"
                                        name="allfundIds">

                                    <div class="col-md-4 div_hide">
                                        <div class="form_group">
                                            <select name="as_on_time_frame" {{ $disable ? 'disabled' : '' }}>
                                                <option value="1_month" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '1_month') selected @endif>1
                                                    Month</option>
                                                <option value="3_months" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '3_months') selected @endif>3
                                                    Months</option>
                                                <option value="6_months" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '6_months') selected @endif>6
                                                    Months</option>
                                                <option value="1_year" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '1_year') selected @endif>1
                                                    Year</option>
                                                <option value="2_years" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '2_years') selected @endif>2
                                                    Years</option>
                                                <option value="3_years" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '3_years') selected @endif>3
                                                    Years</option>
                                                <option value="5_years" @if (old('as_on_time_frame', $as_on_time_frame ?? '') == '5_years') selected @endif>5
                                                    Years</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-3">
                                        <div class="form_group">
                                            <select>
                                                <option value="">Duration</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="Category" value="by_category"
                                                    onclick='get_fund_types_js(this.value)'
                                                    @if (!isset($Category) || (isset($Category) && $Category == 'by_category')) {{ 'Checked' }} @endif
                                                    {{ $disable ? 'disabled' : '' }}>
                                                By Category
                                            </label>
                                            <label>
                                                <input type="radio" name="Category" value="by_fund"
                                                    onclick='get_fund_types_js(this.value)'
                                                    @if (isset($Category) && $Category == 'by_fund') {{ 'Checked' }} @endif
                                                    {{ $disable ? 'disabled' : '' }}>
                                                By Fund
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show_1">
                                        <div class="form_group">
                                            <select name="fund_type" id="fund_type" class="select2"
                                                data-placeholder="Select Fund Classification"
                                                onchange="fund_type_change(this)" {{ $disable ? 'disabled' : '' }}>
                                                <option value="">Select Fund Classification</option>
                                                @if (isset($all_fund_types))
                                                    @foreach ($all_fund_types as $val)
                                                        <option value="{{ $val->ft_id }}"
                                                            {{ isset($fund_type) && $fund_type == $val->ft_id ? 'selected' : '' }}>
                                                            {{ $val->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('fund_type')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <span class="" id="fund_type_msgg" style="color:#379962;"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_hide_1">
                                        <div class="form_group multiple_select">
                                            <select name="fund_id[]" class="select2 multiple" multiple
                                                id="select_fund_multiple" data-max="20" data-min="4"
                                                onchange='fund_multiple(this)' data-placeholder="Select Fund"
                                                {{ $disable ? 'disabled' : '' }}>
                                                <option value="">Select Fund</option>
                                                @if (isset($all_funds))
                                                    @foreach ($all_funds as $val)
                                                        <option value="{{ $val->fund_id }}"
                                                            @if (isset($fund_id) && is_array($fund_id) && in_array($val->fund_id, $fund_id)) selected @endif>
                                                            {{ $val->fund_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('fund_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>

                                    <div class="col-md-4"
                                        style="{{ isset($records) || old('records') ? '' : 'display: none;' }}"
                                        id="record">
                                        <div class="form_group">
                                            <input type="number" placeholder="Records" name="records" id="record_val"
                                                value="{{ old('records', $records ?? '') }}"
                                                {{ $disable ? 'disabled' : '' }}>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-md-4">
                                        <div class="form_group radio_btn">
                                            <label>
                                                <input type="radio" name="filter" value="by_ratio"
                                                    {{ !isset($filter) || (isset($filter) && $filter == 'by_ratio') ? 'checked' : '' }}>
                                                By Ratio
                                            </label>
                                            <label>
                                                <input type="radio" name="filter" value="by_composition"
                                                    @if (isset($filter) && $filter == 'by_composition') {{ 'checked' }} @endif>
                                                By Composition
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_show_2" id="ratio">
                                        <div class="form_group">
                                            <select name="report_category">
                                                <option value="">Ratio</option>
                                                <optgroup label="Return Ratio">
                                                    <option value="returns"
                                                        {{ old('report_category', request('report_category')) == 'returns' ? 'selected' : '' }}>
                                                        Returns/CAGR
                                                    </option>
                                                    <option value="jensens_alpha"
                                                        {{ old('report_category', request('report_category')) == 'jensens_alpha' ? 'selected' : '' }}>
                                                        Jensen’s alpha
                                                    </option>
                                                    <option value="sharpe"
                                                        {{ old('report_category', request('report_category')) == 'sharpe' ? 'selected' : '' }}>
                                                        Sharpe
                                                    </option>
                                                    <option value="treynor"
                                                        {{ old('report_category', request('report_category')) == 'treynor' ? 'selected' : '' }}>
                                                        Treynor
                                                    </option>
                                                    <option value="information_ratio"
                                                        {{ old('report_category', request('report_category')) == 'information_ratio' ? 'selected' : '' }}>
                                                        Information Ratio
                                                    </option>
                                                    <option value="one_month_rolling_return"
                                                        {{ old('report_category', request('report_category')) == 'one_month_rolling_return' ? 'selected' : '' }}>
                                                        1 month Rolling Return
                                                    </option>
                                                </optgroup>

                                                <optgroup label="Risk Ratio">
                                                    <option value="beta"
                                                        {{ old('report_category', request('report_category')) == 'beta' ? 'selected' : '' }}>
                                                        Beta
                                                    </option>
                                                    <option value="volatility"
                                                        {{ old('report_category', request('report_category')) == 'volatility' ? 'selected' : '' }}>
                                                        Volatility
                                                    </option>
                                                    <option value="tracking_error"
                                                        {{ old('report_category', request('report_category')) == 'tracking_error' ? 'selected' : '' }}>
                                                        Tracking Error
                                                    </option>
                                                </optgroup>
                                            </select>
                                            @error('report_category')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 div_hide_2" id="composition">
                                        <div class="form_group">
                                            <select name="composition" id="composition_value">
                                                <option value="">Select Composition</option>
                                                <option value="scrip"
                                                    {{ old('composition', request('composition')) == 'scrip' ? 'selected' : '' }}>
                                                    Scrip</option>
                                                <option value="industry"
                                                    {{ old('composition', request('composition')) == 'industry' ? 'selected' : '' }}>
                                                    Industry</option>
                                                <option value="aum"
                                                    {{ old('composition', request('composition')) == 'aum' ? 'selected' : '' }}>
                                                    AUM</option>
                                                <option value="fund_manager"
                                                    {{ old('composition', request('composition')) == 'fund_manager' ? 'selected' : '' }}>
                                                    Fund Manager</option>
                                            </select>
                                        </div>
                                        @error('composition')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4" id="scrip"
                                        style="display: {{ $errors->has('fund_scrips') || old('fund_scrips') || request('fund_scrips') ? 'block' : 'none' }}">
                                        <div class="form_group">
                                            <select class="select2" name="fund_scrips" data-placeholder="select scrips">
                                                <option value="">select scrips</option>
                                                @foreach ($mpx_fund_scrips as $scr)
                                                    <option value="{{ $scr->actual_scrip }}"
                                                        {{ old('fund_scrips', request('fund_scrips', isset($getData['fund_scrips']) ? $getData['fund_scrips'] : '')) == $scr->actual_scrip ? 'selected' : '' }}>
                                                        {{ $scr->actual_scrip }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fund_scrips')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger" id="fund_msgg"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="industry"
                                        style="display: {{ $errors->has('industry') || old('industry') || request('industry') ? 'block' : 'none' }}">
                                        <div class="form_group">
                                            <select class="select2" name="industry" data-placeholder="select industries">
                                                <option value="">select industries</option>
                                                @foreach ($industries as $industry)
                                                    <option value="{{ $industry->industry }}"
                                                        {{ old('industry', request('industry', isset($getData['industry']) ? $getData['industry'] : '')) == $industry->industry ? 'selected' : '' }}>
                                                        {{ $industry->industry }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('industry')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-3">
                                        <div class="form_group">
                                            <select>
                                                <option value="">Return Ratio</option>
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-12">
                                        <div class="bttn_grp">
                                            @error('checkedFundIds')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <button type="submit" name="search" id="submit_btn"
                                                value="search">Search</button>
                                            <a href="{{ route('user.filters') }}" id="fund_type_btn">Reset</a>
                                            {{-- <button type="submit" name="search" id="fund_type_btn"
                                                value="search">Reset</button> --}}
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                    @if (isset($fund_absolute_return))

                        {{-- <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    @if (isset($fund_id) && count($fund_id) > 0)
                                        <p>Fund Names : </p>
                                        <span>
                                            @foreach ($fund_id as $item)
                                                {{ getNameTable('fund_master', 'fund_name', 'fund_id', $item) }},
                                            @endforeach
                                        </span>
                                    @elseif(isset($fund_type))
                                        <p>Fund Type : </p>
                                        <span>{{ getNameTable('fund_type', 'name', 'ft_id', $fund_type) }}</span>
                                    @endif
                                </li>
                                <li>
                                    <p>Composition : </p>
                                    <span>{{ isset($composition) ? str_replace('_', ' ', $composition) : 'N/A' }}</span>
                                </li>
                                <li>
                                    <p>Return Ratio : </p>
                                    <span>{{ isset($report_category) ? str_replace('_', ' ', $report_category) : 'N/A' }}</span>
                                </li>
                            </ul>
                        </div> --}}

                        @if (isset($history))
                            @foreach ($history as $key => $h)
                                {{-- {{$key}} --}}
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        @if (isset($h['filter']) && $h['filter'] == 'by_composition')
                                            <li>
                                                @php
                                                    $monthName = date('F', strtotime($h['last_date']));
                                                    $year = date('Y', strtotime($h['last_date']));
                                                @endphp
                                                <p>Date : </p>
                                                <span>for the month of {{ $monthName }}, {{ $year }}</span>
                                            </li>
                                        @elseif(isset($h['filter']) && $h['filter'] == 'by_ratio')
                                            <li>
                                                <p>Start Date : </p>
                                                <span>{{ date('d-m-Y', strtotime($h['start_date'])) }}</span>
                                            </li>
                                            <li>
                                                <p>End Date : </p>
                                                <span>{{ date('d-m-Y', strtotime($h['end_date'])) }}</span>
                                            </li>
                                        @endif
                                        <li>
                                            @if (isset($h['Category']) && $h['Category'] == 'by_fund')
                                                <p>Fund Names : </p>
                                                <span>
                                                    @foreach ($h['fund_id'] as $item)
                                                        {{ getNameTable('fund_master', 'fund_name', 'fund_id', $item) }},
                                                    @endforeach
                                                </span>
                                            @elseif(isset($h['Category']) && $h['Category'] == 'by_category')
                                                <p>Fund Type : </p>
                                                <span>{{ getNameTable('fund_type', 'name', 'ft_id', $h['fund_type']) }}</span>
                                            @endif
                                        </li>
                                        @if (isset($h['filter']))
                                            <li>
                                                <p>Filtered : </p>
                                                <span>{{ isset($h['filter']) ? str_replace('_', ' ', $h['filter']) : 'N/A' }}</span>
                                            </li>
                                            @if ($h['filter'] == 'by_ratio')
                                                <li>
                                                    <p>Return Ratio : </p>
                                                    <span>{{ isset($h['report_category']) ? str_replace('_', ' ', $h['report_category']) : 'N/A' }}</span>
                                                </li>
                                            @elseif($h['filter'] == 'by_composition')
                                                <li>
                                                    <p>Composition : </p>
                                                    <span>{{ isset($h['composition']) ? str_replace('_', ' ', $h['composition']) : 'N/A' }}</span>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            @endforeach
                        @endif

                        <div class="graph_table">
                            <table class="table filter_datatable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="all_check" id="all_check" onclick="allcheck()">
                                        </th>
                                        <th>Fund name</th>
                                        <th class="text_center">Value</th>
                                        @if (!isset($composition) || (isset($composition) && $composition != 'fund_manager'))
                                            <th class="text_center">Rank</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($fund_absolute_return) > 0)
                                        @php $i = 1 @endphp
                                        @foreach ($fund_absolute_return as $fund_id => $fund_return)
                                            <tr>
                                                <td><input type="checkbox" id="checkbox_{{ $fund_id }}"
                                                        onclick='selectDynamicFund({{ $fund_id }})' class="fundCheck"></td>
                                                {{-- <td><input type="checkbox" id="checkbox_{{ $fund_id }}"
                                                        class="fundCheck" data-fundId="{{ $fund_id }}"></td> --}}

                                                <td>{{ getNameTable('fund_master', 'fund_name', 'fund_id', $fund_id) }}
                                                </td>

                                                <td class="text_right">
                                                    {{ is_numeric($fund_return) ? printValue($fund_return) : 'N/A' }}
                                                </td>

                                                @if (!isset($composition) || (isset($composition) && $composition != 'fund_manager'))
                                                    <td class="text_right">
                                                        {{-- {{ ($fund_return != 'N/A' || $fund_return > 0) ? $i : 'N/A' }} --}}
                                                        {{ is_numeric($fund_return) ? $i : 'N/A' }}

                                                    </td>
                                                @endif

                                            </tr>
                                            @php $i++ @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text_center" colspan="4">
                                                No data available in table
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
                @if (isset($fund_absolute_return))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
              @endif
            </div>
        </div>
    </div>

    <script>
        function fund_type_change(selectElement) {
            var selectedValue = selectElement.value;

            $.ajax({
                url: '/filters/fund_count',
                type: 'GET',
                data: {
                    fund_type_id: selectedValue,
                },
                success: function(response) {
                    $('#fund_type_msgg').html('There are ' + response +
                        ' funds in this fund type. Select How many records you want to show.');
                    $('#record_val').val(response);
                    $('#record').show();

                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        }

        function allcheck() {
            var isChecked = $('#all_check').prop('checked');
            var fundIds = $('#fundIds').val().split(',').filter(Boolean);

            fundIds.forEach(function(fundId) {
                $('#checkbox_' + fundId).prop('checked', isChecked);
            });

            $('#checkedFundIds').val(fundIds.join(','));
        }



        function selectDynamicFund(fundId) {
            var currentValues = $('#checkedFundIds').val().split(',').filter(Boolean);
            var isChecked = $('#checkbox_' + fundId).is(':checked');

            if (isChecked) {
                if (!currentValues.includes(fundId.toString())) {
                    currentValues.push(fundId);
                }
            } else {
                currentValues = currentValues.filter(function(id) {
                    return id !== fundId.toString();
                });
            }

            var isCheckedAll = $('#all_check').prop('checked');
            if (isCheckedAll) {
                $('#all_check').prop('checked', false);
            }

            console.log('currentValues===',currentValues);

            $('#checkedFundIds').val(currentValues.join(','));
        }
       

        document.querySelectorAll('input[name="Category"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var recordValue = document.getElementById('record_val').value;
                if (this.checked) {
                    // console.log('Selected value:', this.value);
                    if (this.value == 'by_category' && recordValue > 0) {
                        document.getElementById('record').style.display = 'block';
                    } else {
                        document.getElementById('record').style.display = 'none';
                    }
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {

            function updateDisplay() {
                var selectedValue = document.querySelector('input[name="filter"]:checked').value;
                var ratioElement = document.getElementById('ratio');
                var compositionElement = document.getElementById('composition');
                var scripElement = document.getElementById('scrip');
                var industryElement = document.getElementById('industry');

                if (ratioElement && compositionElement) {
                    if (selectedValue === 'by_ratio') {
                        document.getElementById('ratio').style.display = 'block';
                        document.getElementById('composition').style.display = 'none';

                        industryElement.style.display = 'none';
                        scripElement.style.display = 'none';

                    } else if (selectedValue === 'by_composition') {
                        document.getElementById('ratio').style.display = 'none';
                        document.getElementById('composition').style.display = 'block';
                    }
                }

                updateCompositionDisplay();
            }

            updateDisplay();

            document.querySelectorAll('input[name="filter"]').forEach(function(radio) {
                radio.addEventListener('change', updateDisplay);
            });

            function updateCompositionDisplay() {
                var selectedFilterValue = document.querySelector('input[name="filter"]:checked').value;
                var selectedValue = document.getElementById('composition_value').value;
                var scripElement = document.getElementById('scrip');
                var industryElement = document.getElementById('industry');

                if (selectedFilterValue === 'by_composition' && selectedValue === 'scrip') {
                    scripElement.style.display = 'block';
                    industryElement.style.display = 'none';
                } else if (selectedFilterValue === 'by_composition' && selectedValue === 'industry') {
                    scripElement.style.display = 'none';
                    industryElement.style.display = 'block';
                } else {
                    scripElement.style.display = 'none';
                    industryElement.style.display = 'none';
                }
            }

            updateCompositionDisplay();

            document.getElementById('composition_value').addEventListener('change', updateCompositionDisplay);
        });
    </script>
@endsection
