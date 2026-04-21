@extends('web.layout.infosolz_user_app')
@section('content')
    @php
        $selectedCategory = old('Category', $request->Category ?? 'by_category');
        $selectedQuartileSet = old('quartile_set', $quartile_set ?? 'quartile');
        $isByFundMode = $selectedCategory === 'by_fund';
    @endphp
    <style>
        .fund_section.new_fund_section ul.comparative-summary {
            display: flex !important;
            flex-wrap: wrap;
            gap: 24px;
            align-items: flex-start;
        }

        .fund_section.new_fund_section ul.comparative-summary > li {
            min-width: 0;
            float: none !important;
        }

        .fund_section.new_fund_section ul.comparative-summary > li.summary-period {
            width: calc(50% - 12px);
        }

        .fund_section.new_fund_section ul.comparative-summary > li.summary-detail {
            width: calc(50% - 12px);
        }

        .fund_section.new_fund_section ul.comparative-summary > li.summary-period:nth-child(2) {
            margin-left: 0;
        }

        .comparative-summary .summary-period {
            display: flex;
            flex-wrap: nowrap;
            gap: 18px;
            align-items: flex-start;
        }

        .comparative-summary .summary-period b {
            min-width: 108px;
            font-size: 18px;
        }

        .comparative-summary .summary-period figure,
        .comparative-summary .summary-detail {
            margin: 0;
            min-width: 0;
        }

        .comparative-summary .summary-detail span {
            display: block;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            line-height: 1.45;
        }

        @media (max-width: 991px) {
            .fund_section.new_fund_section ul.comparative-summary > li.summary-period,
            .fund_section.new_fund_section ul.comparative-summary > li.summary-detail {
                width: 100%;
            }

            .comparative-summary .summary-period {
                flex-wrap: wrap;
            }
        }
    </style>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.ratio_dashboard') }}">Ratio Reports</a></li>
                        <li>Comparative</li>
                    </ul>
                </div>
                
                <div class="new_page">
                    <div class="wm_tab">
                        <ul class="tabs">
                            <li>
                                <a class="{{ isset($quartile_set) ? ($quartile_set == 'quartile' ? 'active' : '') : 'active' }}"
                                    id="quartile_tab" data-value="quartile" onclick="max_min_fund(this)">Quartile</a>
                            </li>
                            <li>
                                <a class="{{ isset($quartile_set) && $quartile_set == 'decile' ? 'active' : '' }}"
                                    id="decile_tab" data-value="decile" onclick="max_min_fund(this)">Decile</a>
                            </li>
                        </ul>
                    </div>
                    {{-- <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Comparative Quartile & Decile</h2>
                    </div> --}}

                    <input type="hidden" name="quartile_status" id="quartile_status"
                        value="{{ isset($quartile_set) ? $quartile_set : '' }}">

                    <div class="light_green_bg">
                        <form action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="{{ isset($quartile_set) ? $quartile_set : 'quartile' }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="Category" value="by_category"
                                                {{ $selectedCategory === 'by_category' ? 'checked' : '' }}
                                                onclick='get_fund_types_js(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" name="Category" value="by_fund"
                                                {{ $selectedCategory === 'by_fund' ? 'checked' : '' }}
                                                onclick='get_fund_types_js(this.value)'>
                                            By Fund
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>1st period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="date" placeholder="Start Date" class="form-control"
                                                    name="p_one_start_date" required
                                                    value="{{ old('p_one_start_date', isset($p_one_start_date) ? date('Y-m-d', strtotime($p_one_start_date)) : '') }}">
                                                @error('p_one_start_date')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="date" placeholder="End Date" class="form-control"
                                                    name="p_one_end_date" required
                                                    value="{{ old('p_one_end_date', isset($p_one_end_date) ? date('Y-m-d', strtotime($p_one_end_date)) : '') }}">

                                                @error('p_one_end_date')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>2nd period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="date" placeholder="Start Date" class="form-control"
                                                    name="p_two_start_date" required
                                                    value="{{ old('p_two_start_date', isset($p_two_start_date) ? date('Y-m-d', strtotime($p_two_start_date)) : '') }}">

                                                @error('p_two_start_date')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <input type="date" placeholder="End Date" class="form-control"
                                                    name="p_two_end_date" required
                                                    value="{{ old('p_two_end_date', isset($p_two_end_date) ? date('Y-m-d', strtotime($p_two_end_date)) : '') }}">

                                                @error('p_two_end_date')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 div_show_1" style="{{ $isByFundMode ? 'display:none;' : '' }}">
                                    <div class="form_group">
                                        <select name="fund_type_id" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Classification"
                                            {{ $isByFundMode ? 'disabled' : '' }}>
                                            <option value=""></option>
                                            @if (isset($fund_type))
                                                @foreach ($fund_type as $val)
                                                    <option value="{{ $val->ft_id }}"
                                                        {{ isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : '' }}>
                                                        {{ $val->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('fund_type_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 div_hide_1" style="{{ $isByFundMode ? '' : 'display:none;' }}">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" id="select_fund_multiple"
                                            data-max="20" data-min="{{ $selectedQuartileSet === 'decile' ? 10 : 4 }}"
                                            multiple onchange='fund_multiple(this)' {{ $isByFundMode ? '' : 'disabled' }}>
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
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="report_category">
                                        
                                            <optgroup label="Return Ratio">
                                                <option value="returns" @if (old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'returns') selected @endif>
                                                    Returns/CAGR
                                                </option>
                                                <option value="jensens_alpha"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'jensens_alpha') selected @endif>
                                                    Jensen’s alpha
                                                </option>
                                                <option value="sharpe" @if (old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'sharpe') selected @endif>
                                                    Sharpe
                                                </option>
                                                <option value="treynor" @if (old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'treynor') selected @endif>
                                                    Treynor
                                                </option>
                                                <option value="information_ratio"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'information_ratio') selected @endif>
                                                    Information Ratio
                                                </option>
                                                <option value="one_month_rolling_return"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'one_month_rolling_return') selected @endif>
                                                    1 month Rolling Return
                                                </option>
                                            </optgroup>

                                            <optgroup label="Risk Ratio">
                                                <option value="beta" @if (old(
                                                        'report_category',
                                                        isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'beta') selected @endif>
                                                    Beta
                                                </option>
                                                <option value="volatility"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'volatility') selected @endif>
                                                    Volatility
                                                </option>
                                                <option value="tracking_error"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'tracking_error') selected @endif>
                                                    Tracking Error
                                                </option>
                                            </optgroup>

                                            <optgroup label="Symmetry Ratio">
                                                <option value="skewness"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'skewness') selected @endif>
                                                    Skewness
                                                </option>
                                                <option value="kurtosis"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'kurtosis') selected @endif>
                                                    Kurtosis
                                                </option>
                                            </optgroup>

                                            <optgroup label="Correlation">
                                                <option value="r_square"
                                                    @if (old(
                                                            'report_category',
                                                            isset($request) ? $request->report_category : (isset($report_category) ? $report_category : null)) == 'r_square') selected @endif>
                                                    R Square
                                                </option>
                                            </optgroup>
                                        </select>
                                        @error('report_category')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        {{-- <button type="button">show by classification</button> --}}
                                        {{-- <button type="button">show by fund</button> --}}
                                        <button type="submit" name="search" id="submit_btn"
                                            value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- <div class="wm_tab">
                        <ul>
                            <li>
                                <a class="active" href="#">Quartile</a>
                            </li>
                            <li>
                                <a href="#">Decile</a>
                            </li>
                        </ul>
                    </div> --}}

                    @if (isset($p_one_quartile_decile_result) &&
                            isset($p_one_quartile_decile_result['fund_absolute_return']) &&
                            isset($p_two_quartile_decile_result) &&
                            isset($p_two_quartile_decile_result['fund_absolute_return']))
                        <div class="fund_section new_fund_section">
                            <ul class="comparative-summary">
                                <li class="summary-period">
                                    <b>1st period -</b>
                                    <figure>
                                        <p>start date :</p>
                                        <span>{{ isset($p_one_start_date) ? date('d-m-Y', strtotime($p_one_start_date)) : 'N/A' }}</span>
                                    </figure>
                                    <figure>
                                        <p>end date :</p>
                                        <span>{{ isset($p_one_end_date) ? date('d-m-Y', strtotime($p_one_end_date)) : 'N/A' }}</span>
                                    </figure>
                                </li>
                                <li class="summary-period">
                                    <b>2nd period -</b>
                                    <figure>
                                        <p>start date :</p>
                                        <span>{{ isset($p_two_start_date) ? date('d-m-Y', strtotime($p_two_start_date)) : 'N/A' }}</span>
                                    </figure>
                                    <figure>
                                        <p>end date :</p>
                                        <span>{{ isset($p_two_end_date) ? date('d-m-Y', strtotime($p_two_end_date)) : 'N/A' }}</span>
                                    </figure>
                                </li>
                                <li class="summary-detail">
                                    <p>by functions :</p>
                                    <span>{{ ucwords(str_replace('_', ' ', $report_category ?? 'N/A')) }}</span>
                                </li>
                                @if (isset($fund_type_id))
                                    <li class="summary-detail">
                                        <p>fund classification :</p>
                                        <span>{{ getNameTable('fund_type', 'name', 'ft_id', $fund_type_id) }}</span>
                                    </li>
                                @elseif(isset($fund_id))
                                    <li class="summary-detail">
                                        <p>fund names :</p>
                                        <span>
                                            @foreach ($fund_id as $item)
                                                {{ getNameTable('fund_master', 'fund_name', 'fund_id', $item) }},
                                            @endforeach
                                        </span>
                                    </li>
                                @endif

                                {{-- <li>
                                <p>Fund type :</p>
                                <span>abc</span>
                            </li> --}}
                            </ul>
                        </div>

                        <div class="quartile_tab">
                            <div class="graph_table">

                                <div class="share_pdf">
                                    <div class="sharethis-inline-share-buttons"></div>
                                    <a href="javascript:void(0)" id="exportPDFquartile" class="pdf"><img
                                            src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}"></a>

                                </div>

                                <table class="table comp">
                                    <thead>
                                        <tr>
                                            <th style="width: 67%;"></th>
                                            <th colspan="2" class="text_center">1st period</th>
                                            <th colspan="2" class="text_center">2nd period</th>
                                        </tr>
                                    </thead>
                                </table>

                                <table class="table comp2 datatable" id="pdfData">
                                    <thead>
                                        <tr>
                                            <th class="text_left">Name of the Fund</th>

                                            <th class="text_center">Rank</th>
                                            <th class="text_center">Ratio</th>

                                            <th class="text_center">Rank</th>
                                            <th class="text_center">Ratio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                            // if (
                                            //     isset($report_category) &&
                                            //     isset($p_one_quartile_decile_result['fund_absolute_return'])
                                            // ) {
                                            //     if (in_array($report_category, $ratio_array)) {
                                            //         asort($p_one_quartile_decile_result[$quartile_set]);
                                            //     } else {
                                            //         arsort($p_one_quartile_decile_result[$quartile_set]);
                                            //     }
                                            // }

                                            if (
                                                isset($quartile_set) &&
                                                isset($p_one_quartile_decile_result[$quartile_set]) &&
                                                count($p_one_quartile_decile_result[$quartile_set]) > 0
                                            ) {
                                                // dd(($p_one_quartile_decile_result[$quartile_set]);
                                                $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                                if (
                                                    isset($report_category) &&
                                                    in_array($report_category, $ratio_array)
                                                ) {
                                                    $p_one_quartile_decile_result[$quartile_set] = custom_sort(
                                                        $p_one_quartile_decile_result[$quartile_set],
                                                    );
                                                    // asort(($p_one_quartile_decile_result[$quartile_set]);
                                                } else {
                                                    $p_one_quartile_decile_result[$quartile_set] = custom_sort(
                                                        $p_one_quartile_decile_result[$quartile_set],
                                                        'dsc',
                                                    );
                                                    // arsort(($p_one_quartile_decile_result[$quartile_set]);
                                                }
                                            }
                                        @endphp

                                        @foreach ($p_one_quartile_decile_result[$quartile_set] as $fundId => $val)
                                            <tr class="data">
                                                <td class="text_left" id='fund_names'>
                                                    {{ getNameTable('fund_master', 'fund_name', 'fund_id', $fundId) }}
                                                </td>

                                                <td class="text_right">
                                                    @if ($quartile_set == 'quartile')
                                                        {{ is_numeric($p_one_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_one_quartile_decile_result['quartile'][$fundId]) : printRank('N/A') }}
                                                    @else
                                                        {{ is_numeric($p_one_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_one_quartile_decile_result['decile'][$fundId]) : printRank('N/A') }}
                                                    @endif
                                                </td>

                                                <td class="text_right">
                                                    {{ printValue($p_one_quartile_decile_result['fund_absolute_return'][$fundId]) }}
                                                </td>

                                                <td class="text_right">
                                                    @if ($quartile_set == 'quartile')
                                                        {{ is_numeric($p_two_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_two_quartile_decile_result['quartile'][$fundId]) : printRank('N/A') }}
                                                    @else
                                                        {{ is_numeric($p_two_quartile_decile_result['fund_absolute_return'][$fundId]) ? printRank($p_two_quartile_decile_result['decile'][$fundId]) : printRank('N/A') }}
                                                    @endif
                                                </td>
                                                <td class="text_right">
                                                    {{ printValue($p_two_quartile_decile_result['fund_absolute_return'][$fundId]) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- <tr class="no-data" style="display: none">
                                                        <td colspan="5">No information available for this search</td>
                                                    </tr> -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
            </div>
            @if (isset($quartile_set) && isset($p_one_quartile_decile_result[$quartile_set]))
                <div class="disclaimer">
                    <p><strong>Note : </strong>For the calculations, the first working day is considered in case of Starting
                        and Ending day.</p>
                </div>
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection
<script>
    function currentComparativeMode() {
        return $('#quartile_set').val() || 'quartile';
    }

    function selectedFundCount() {
        return ($('#select_fund_multiple').val() || []).length;
    }

    function toggleCategoryFields() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var isByFund = category === 'by_fund';

        $('.div_show_1').toggle(!isByFund);
        $('.div_hide_1').toggle(isByFund);

        $('select[name="fund_type_id"]').prop('disabled', isByFund);
        $('select[name="fund_id[]"]').prop('disabled', !isByFund);
    }

    function updateComparativeSelectionState() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var mode = currentComparativeMode();
        var count = selectedFundCount();
        var min = mode === 'decile' ? 10 : 4;

        $('#select_fund_multiple').attr('data-min', min);

        if (category !== 'by_fund') {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        if (count >= min && count <= 20) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        $('#fund_msgg').html('<p>Selection limit minimum ' + min + ' and maximum 20 for <b>' + (mode === 'decile' ? 'Decile' : 'Quartile') + '</b></p>');
        $('#submit_btn').prop('disabled', true);
    }

    function max_min_fund(element) {
        var value = element.getAttribute('data-value');

        $('#quartile_set').val(value);
        $('#quartile_tab').toggleClass('active', value === 'quartile');
        $('#decile_tab').toggleClass('active', value === 'decile');
        updateComparativeSelectionState();
    }

    function get_fund_types_js(thiss) {
        toggleCategoryFields();
        updateComparativeSelectionState();
    }

    // function get_fund_types(thiss) {

    //     var count = $('#select_fund_multiple').select2('data').length;

    //     if (thiss == 'by_category') {

    //         $('#submit_btn').prop('disabled', false);
    //     } else if (thiss == 'by_fund') {

    //         fund_multiple();

    //     }
    // }

    // function fund_multiple(selectElement) {

    //     var min = parseInt($(selectElement).attr('data-min') || 0);
    //     var max = parseInt($(selectElement).attr('data-max') || Infinity);
    //     var selectedOptions = $(selectElement).val();

    //     // Check both min and max conditions in a single expression
    //     var isValidSelection = selectedOptions.length >= min && selectedOptions.length <= max;

    //     // Build the message based on validity
    //     var message = '';
    //     if (!isValidSelection) {
    //         if (selectedOptions.length > max) {
    //             message = '<p>You can select a maximum of ' + max + ' items.</p>';
    //         } else {
    //             message = '<p>You need to select at least ' + min + ' and maximum ' + max + ' funds.</p>';
    //         }
    //     }

    //     // Update button state based on validity
    //     $('#submit_btn').prop('disabled', !isValidSelection);

    //     // Display the message
    //     $('#fund_msgg').html(message);

    // }




    document.addEventListener('DOMContentLoaded', function() {
        toggleCategoryFields();
        updateComparativeSelectionState();

        $('input[name="Category"]').on('change', function() {
            get_fund_types_js(this.value);
        });
        $('#select_fund_multiple').on('change', updateComparativeSelectionState);

        var exportButton = document.getElementById('exportPDFquartile');

        if (!exportButton) {
            return;
        }

        exportButton.addEventListener('click', function() {
            var {
                jsPDF
            } = window.jspdf;
            var doc = new jsPDF();

            var img = new Image();
            img.src = "{{ asset('themes/frontend/assets/infosolz/images/small_logo.png') }}";
            img.onload = function() {
                var pageWidth = doc.internal.pageSize.getWidth();
                var imgWidth = 50;
                var imgHeight = 20;
                var centerX = (pageWidth - imgWidth) / 2;

                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                // Get active tab (Quartile or Decile)
                var activeTab = document.querySelector('.tabs .active').getAttribute('data-value');
                // var reportTitle = activeTab.charAt(0).toUpperCase() + activeTab.slice(1);
                var reportTitle = 'Comparative ' + activeTab.charAt(0).toUpperCase() + activeTab
                    .slice(1); // Add "Comparative" before the capitalized active tab

                // Title
                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text(reportTitle, pageWidth / 2, 35, {
                    align: 'center'
                });

                // Set Y position for the next text below the title
                var nextYPosition = 35 + 10; // 10 units below the title

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and functions details
                var startDate1 =
                    "{{ isset($p_one_start_date) ? date('d/m/Y', strtotime($p_one_start_date)) : '00/00/0000' }}";
                var endDate1 =
                    "{{ isset($p_one_end_date) ? date('d/m/Y', strtotime($p_one_end_date)) : '00/00/0000' }}";
                var startDate2 =
                    "{{ isset($p_two_start_date) ? date('d/m/Y', strtotime($p_two_start_date)) : '00/00/0000' }}";
                var endDate2 =
                    "{{ isset($p_two_end_date) ? date('d/m/Y', strtotime($p_two_end_date)) : '00/00/0000' }}";
                var functions =
                "{{ isset($report_category) ? $report_category : 'N/A' }}"; // Renamed variable
                var fundClassification =
                    "{{ isset($fund_type_id) ? getNameTable('fund_type', 'name', 'ft_id', $fund_type_id) : 'N/A' }}";

                //var fundClassification = "{{ isset($fund_type_name) ? $fund_type_name[0] : '' }}";
                var fundNameElement = document.getElementById('fund_names');
                var fundNames = fundNameElement ? fundNameElement.innerText : 'N/A';


                var startX = 15;
                // Set font to bold for the title
                doc.setFont("Helvetica", "bold"); // Change the font to bold
                doc.text("1st Period", startX, nextYPosition);
                nextYPosition += 10;

                // Set back to normal font for the rest of the text
                doc.setFont("Helvetica", "normal"); // Change back to normal font
                doc.text(`Start Date: ${startDate1}`, startX, nextYPosition);
                nextYPosition += 10;
                doc.text(`End Date: ${endDate1}`, startX, nextYPosition);
                nextYPosition += 10;

                doc.setFont("Helvetica", "bold"); // Change the font to bold
                doc.text("2nd Period", startX, nextYPosition);
                nextYPosition += 10;

                doc.setFont("Helvetica", "normal");
                doc.text(`Start Date: ${startDate2}`, startX, nextYPosition);
                nextYPosition += 10;
                doc.text(`End Date: ${endDate2}`, startX, nextYPosition);
                nextYPosition += 10;

                // Display Functions and Fund Classification
                doc.text(`By Functions: ${functions}`, startX, nextYPosition + 5);


                if (fundClassification !== 'N/A') {
                    doc.text(`Fund Classification: ${fundClassification}`, startX, nextYPosition +
                        40);
                }

                // if (fundNames !== '') {
                //     var wrappedFundNames = doc.splitTextToSize(fundNames, 180); // 180 defines the max width of text before breaking
                //     doc.text('Fund Name:', startX, yPosition);
                //     yPosition += 10;
                //     doc.text(wrappedFundNames, startX, yPosition);  // Write the wrapped text
                //     yPosition += (wrappedFundNames.length * 7); // Adjust yPosition based on the number of lines
                // }

                // Collect the table data from the DOM
                var tableData = [];
                var tableRows = document.querySelectorAll("#pdfData tbody tr");

                tableRows.forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll("td").forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                // Log collected table data
                console.log("Table Data:", tableData);

                // Generate table in PDF
                // doc.autoTable({
                //     startY: nextYPosition + 50, // Adjust to start the table below the other text
                //     head: [['Name of the Fund', 'Rank (1st)', 'Ratio (1st)', 'Rank (2nd)', 'Ratio (2nd)']], // Ensure header matches the content
                //     body: tableData
                // });

                // Generate table in PDF
                doc.autoTable({
                    startY: nextYPosition +
                    50, // Adjust to start the table below the other text
                    head: [
                        ['', {
                            content: '1st Period',
                            colSpan: 2
                        }, {
                            content: '2nd Period',
                            colSpan: 2
                        }],
                        ['Name of the Fund', 'Rank', 'Ratio', 'Rank',
                        'Ratio'] // Second level headers
                    ],
                    body: tableData,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    },
                });

                // Save the PDF
                var currentDate = new Date();
                var fileName = `${reportTitle}-${currentDate.toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);
            };
        });
    });
</script>
