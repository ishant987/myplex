@extends('web.layout.infosolz_user_app')
@section('content')

    @php
        $selectedRanking = old('ranking', $request->ranking ?? 'range');
        $selectedCategory = old('Category', $request->Category ?? 'by_category');
        $isAsOnMode = $selectedRanking === 'as_on';
        $isByFundMode = $selectedCategory === 'by_fund';
    @endphp

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="head_brdcm">
                        <ul class="brdcmb">
                            <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                            <li><a href="{{ route('user.ratio_dashboard') }}">Ratio Reports</a></li>
                            <li>Performance Ratios</li>
                        </ul>
                    </div>
                    <div class="perform_head">
                        <h2>Performance Ratios</h2>
                    </div>

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="{{ isset($quartile_set) ? $quartile_set : 'quartile' }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="ranking" value="range"
                                                {{ old('ranking', $request->ranking ?? 'range') === 'range' ? 'checked' : '' }}>
                                            Range
                                        </label>
                                        <label>
                                            <input type="radio" name="ranking" value="as_on"
                                                {{ old('ranking', $request->ranking ?? 'range') === 'as_on' ? 'checked' : '' }}>
                                            As on
                                        </label>
                                        @error('ranking')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 div_show" style="{{ $isAsOnMode ? 'display:none;' : '' }}">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="Start date" name="start_date"
                                            {{ $isAsOnMode ? 'disabled' : '' }}
                                            value="{{ $request->has('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('Y-m-d') : old('start_date') }}">
                                        @error('start_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 div_show" style="{{ $isAsOnMode ? 'display:none;' : '' }}">
                                    <div class="form_group">
                                        <input type="date" class="form-control" placeholder="End date" name="end_date"
                                            {{ $isAsOnMode ? 'disabled' : '' }}
                                            value="{{ $request->has('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('Y-m-d') : old('end_date') }}">
                                        @error('end_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide" style="{{ $isAsOnMode ? '' : 'display:none;' }}">
                                    <div class="form_group">
                                        <input type="date" name="as_on_date" class="form-control" placeholder="date"
                                            {{ $isAsOnMode ? '' : 'disabled' }}
                                            value="{{ !empty($request->as_on_date) ? \Carbon\Carbon::parse($request->as_on_date)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide" style="{{ $isAsOnMode ? '' : 'display:none;' }}">
                                    <div class="form_group">
                                        <select name="as_on_time_frame" {{ $isAsOnMode ? '' : 'disabled' }}>
                                            <option value="1_month"
                                                @if (isset($request) && $request->as_on_time_frame == '1_month') {{ 'selected' }} @endif>1 Month
                                            </option>
                                            <option value="3_months"
                                                @if (isset($request) && $request->as_on_time_frame == '3_months') {{ 'selected' }} @endif>3 Months
                                            </option>
                                            <option value="6_months"
                                                @if (isset($request) && $request->as_on_time_frame == '6_months') {{ 'selected' }} @endif>6 Months
                                            </option>
                                            <option value="1_year"
                                                @if (isset($request) && $request->as_on_time_frame == '1_year') {{ 'selected' }} @endif>1 Year
                                            </option>
                                            <option value="2_year"
                                                @if (isset($request) && $request->as_on_time_frame == '2_year') {{ 'selected' }} @endif>2 Year
                                            </option>
                                            <option value="3_years"
                                                @if (isset($request) && $request->as_on_time_frame == '3_years') {{ 'selected' }} @endif>3 Years
                                            </option>
                                            <option value="5_years"
                                                @if (isset($request) && $request->as_on_time_frame == '5_years') {{ 'selected' }} @endif>5 Years
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category"
                                                value="by_category"
                                                @if (!isset($request) || empty($request->Category) || $request->Category == 'by_category') {{ 'Checked' }} @endif
                                                onclick='get_fund_types(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                @if (isset($request) && $request->Category == 'by_fund') {{ 'Checked' }} @endif
                                                onclick='get_fund_types(this.value)'>
                                            By Fund
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-4 div_show_1" style="{{ $isByFundMode ? 'display:none;' : '' }}">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2"
                                            data-placeholder="Select Fund Classification" {{ $isByFundMode ? 'disabled' : '' }}>
                                            <option value=""></option>
                                            @foreach ($all_fund_types as $fund_type)
                                                <option value="{{ $fund_type->ft_id }}"
                                                    @if ($fund_type->ft_id == old('fund_type_id', $request->fund_type_id)) selected @endif>
                                                    {{ $fund_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fund_type_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <!-- <div class="col-md-4">
                                                            <div class="form_group">
                                                                <select name="report_category">
                                                                    <option value="">Report Category</option>
                                                                    <option value="returns"
                                                                        @if (old('report_category', $request->report_category) == 'returns') selected @endif>
                                                                        Returns %
                                                                    </option>
                                                                    <option value="indices"
                                                                        @if (old('report_category', $request->report_category) == 'indices') selected @endif>
                                                                        Indices
                                                                    </option>
                                                                    <option value="return_less_index"
                                                                        @if (old('report_category', $request->report_category) == 'return_less_index') selected @endif>
                                                                        Return Less Index
                                                                    </option>
                                                                </select>
                                                                @error('report_category')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
                                                            </div>
                                                            
                                                        </div> -->

                                <div class="col-md-4 div_hide_1" style="{{ $isByFundMode ? '' : 'display:none;' }}">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='fund_multiple(this)'
                                            data-placeholder="Select Fund" data-min="4" data-min="2" data-max="10" {{ $isByFundMode ? '' : 'disabled' }}>
                                            @foreach ($all_funds as $fund)
                                                <option value="{{ $fund->fund_id }}"
                                                    @if ($fund->fund_id == old('fund_id', $request->fund_id)) selected
                                                @elseif(isset($fund_id) && in_array($fund->fund_id, $fund_id))
                                                selected @endif>
                                                    {{ $fund->fund_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fund_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <span class="text-danger" id="fund_msgg"></span>
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="report_category">

                                            <optgroup label="Return Ratio">
                                                <option value="returns"
                                                    @if (old('report_category', $request->report_category) == 'returns') selected @endif>
                                                    Returns/CAGR
                                                </option>
                                                <option value="jensens_alpha"
                                                    @if (old('report_category', $request->report_category) == 'jensens_alpha') selected @endif>
                                                    Jensen’s alpha
                                                </option>
                                                <option value="sharpe" @if (old('report_category', $request->report_category) == 'sharpe') selected @endif>
                                                    Sharpe
                                                </option>
                                                <option value="treynor"
                                                    @if (old('report_category', $request->report_category) == 'treynor') selected @endif>
                                                    Treynor
                                                </option>
                                                <option value="information_ratio"
                                                    @if (old('report_category', $request->report_category) == 'information_ratio') selected @endif>
                                                    Information Ratio
                                                </option>
                                                <option value="one_month_rolling_return"
                                                    @if (old('report_category', $request->report_category) == 'one_month_rolling_return') selected @endif>
                                                    1 month Rolling Return
                                                </option>
                                            </optgroup>

                                            <optgroup label="Risk Ratio">


                                                <option value="beta" @if (old('report_category', $request->report_category) == 'beta') selected @endif>
                                                    Beta
                                                </option>
                                                <option value="volatility"
                                                    @if (old('report_category', $request->report_category) == 'volatility') selected @endif>
                                                    Volatility
                                                </option>
                                                <option value="tracking_error"
                                                    @if (old('report_category', $request->report_category) == 'tracking_error') selected @endif>
                                                    Tracking Error
                                                </option>
                                            </optgroup>

                                            <optgroup label="Symmetry Ratio">
                                                <option value="skewness"
                                                    @if (old('report_category', $request->report_category) == 'skewness') selected @endif>
                                                    Skewness
                                                </option>
                                                <option value="kurtosis"
                                                    @if (old('report_category', $request->report_category) == 'kurtosis') selected @endif>
                                                    Kurtosis
                                                </option>
                                            </optgroup>

                                            <optgroup label="Correlation">
                                                <option value="r_square"
                                                    @if (old('report_category', $request->report_category) == 'r_square') selected @endif>
                                                    R Sqaure
                                                </option>
                                            </optgroup>

                                            <!-- <option value="cagr"
                                                                        @if (old('report_category', $request->report_category) == 'cagr') selected @endif>
                                                                        CAGR
                                                                    </option> -->
                                        </select>
                                        @error('report_category')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- <div class="col-md-4 div_hide_1">
                                                            <div class="form_group">
                                                                <select name="fund_id">
                                                                    @foreach ($all_funds as $fund)
    <option value="{{ $fund->fund_id }}"
                                                                            @if ($fund->fund_id == old('fund_id', $request->fund_id)) selected @endif>
                                                                            {{ $fund->fund_name }}
                                                                        </option>
    @endforeach
                                                                </select>
                                                                @error('fund_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
                                                            </div>
                                                            
                                                        </div> -->




                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (!empty($message))
                        <div class="alert alert-warning mt-3">
                            {{ $message }}
                        </div>
                    @endif

                    @if (($report_data_ready ?? false) &&
                            isset($request) &&
                            $request->Category != '' &&
                            $request->report_category != '' &&
                            (($request->Category === 'by_category' && !empty($request->fund_type_id)) ||
                                ($request->Category === 'by_fund' && !empty($fund_names))))


                        <div class="fund_section new_fund_section">

                            <ul>

                                @if (($request->ranking ?? 'range') === 'as_on')
                                    <li>
                                        <p>As on date :</p>
                                        <span>{{ !empty($request->as_on_date) ? date('d/m/Y', strtotime($request->as_on_date)) : '00/00/0000' }}</span>
                                    </li>
                                @else
                                    <li>
                                        <p>Start date :</p>
                                        <span>{{ isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000' }}</span>
                                    </li>

                                    <li>
                                        <p>End date :</p>
                                        <span>{{ isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000' }}</span>
                                    </li>
                                @endif



                                <li>
                                    <p>By Ratio :</p>

                                    <span>
                                        @if (isset($request->report_category) && $request->report_category == 'returns')
                                            {{ 'Returns/CAGR' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'jensens_alpha')
                                            {{ 'Jensen’s alpha' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'sharpe')
                                            {{ 'Sharpe' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'treynor')
                                            {{ 'Treynor' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'information_ratio')
                                            {{ 'Information Ratio' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'one_month_rolling_return')
                                            {{ '1 month Rolling Return' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'beta')
                                            {{ 'Beta' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'volatility')
                                            {{ 'Volatility' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'tracking_error')
                                            {{ 'Tracking Error' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'skewness')
                                            {{ 'Skewness' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'kurtosis')
                                            {{ 'Kurtosis' }}
                                        @elseif(isset($request->report_category) && $request->report_category == 'r_square')
                                            {{ 'R Sqaure' }}
                                        @endif
                                    </span>
                                </li>

                                @if (isset($as_on_time_frame_data))
                                    <li>
                                        <p>Duration :</p>
                                        <span>
                                            @if (isset($request) && $request->as_on_time_frame == '1_month')
                                                {{ '1 Month' }}
                                            @elseif(isset($request) && $request->as_on_time_frame == '3_months')
                                                {{ '3 Month' }}
                                            @elseif(isset($request) && $request->as_on_time_frame == '6_months')
                                                {{ '6 Month' }}
                                            @elseif(isset($request) && $request->as_on_time_frame == '1_year')
                                                {{ '1 Year' }}
                                            @elseif(isset($request) && $request->as_on_time_frame == '2_year')
                                                {{ '2 Year' }}
                                            @elseif(isset($request) && $request->as_on_time_frame == '3_years')
                                                {{ '3 Years' }}
                                            @elseif(isset($request) && $request->as_on_time_frame == '5_years')
                                                {{ '5 Years' }}
                                            @endif
                                        </span>
                                    </li>
                                @endif

                                @if (isset($request) && $request->Category == 'by_category')
                                    <li>
                                        <p>fund classification :</p>
                                        <span>{{ isset($fund_type_name) ? $fund_type_name : '' }}</span>
                                    </li>
                                @endif

                                @if (isset($request) && $request->Category == 'by_fund')
                                    <li>
                                        <p>fund name :</p>
                                        <span>{{ isset($fund_names) ? $fund_names : '' }}</span>
                                    </li>
                                @endif

                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">

                                <!-- <a href="javascript:void(0)" class="mb-3"><i class="fa-solid fa-share-nodes"></i></a> -->


                                <!-- ShareThis Inline Share Buttons (Hidden) -->
                                <!-- <div class="sharethis-inline-share-buttons" id="shareThisWidget" style="visibility: hidden; height: 0;"></div> -->
                                <div class="sharethis-inline-share-buttons"></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                        src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}"></a>

                            </div>
                            <table class="table datatable" id="pdfData">
                                <thead>
                                    <tr>
                                        <th class="text_left">fund name</th>
                                        <th class="text_center">ratio</th>
                                        <th class="text_center">rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($stat_result['fund_absolute_return']) && count($stat_result['fund_absolute_return']) > 0)
                                        @php
                                            $fundReturns = $stat_result['fund_absolute_return'];

                                            // dd($request->report_category,$fundReturns);

                                            $ratio_array = ['beta', 'volatility', 'tracking_error'];

                                            if (isset($request->report_category) && isset($fundReturns)) {
                                                if (in_array($request->report_category, $ratio_array)) {
                                                    asort($fundReturns);
                                                } else {
                                                    arsort($fundReturns);
                                                }
                                            }

                                            // Convert the sorted array to a collection if needed
                                            $sortedFundReturns = collect($fundReturns)->toArray();
                                            //print_r($sortedFundReturns);

                                            $ranks = [];

                                            $rank = 1;
                                            foreach ($sortedFundReturns as $key => $value) {
                                                if ($value == 'N/A') {
                                                    $ranks[$key] = ' ';
                                                } else {
                                                    $ranks[$key] = $rank++;
                                                }
                                            }

                                        @endphp
                                    @endif
                                    @php
                                        //print_r($sortedFundReturns);
                                    @endphp
                                    @if (isset($sortedFundReturns) && count($sortedFundReturns) > 0)
                                        @foreach ($sortedFundReturns as $fundId => $value)
                                            <tr>
                                                <td class="text_left">
                                                    {{ getNameTable('fund_master', 'fund_name', 'fund_id', $fundId) }}</td>
                                                <td class="text_right">
                                                    {{ is_numeric(printValue($value)) ? printValue($value) : ' ' }}</td>
                                                <td class="text_right">{{ printRank($ranks[$fundId]) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No information available for this search</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @elseif (empty($message))
                        {!! printNoData() !!}
                    @endif
                </div>
                @if (isset($sortedFundReturns))
                    <div class="disclaimer">
                        <p><strong>Note : </strong>For the calculations, the first working day is considered in case of
                            Starting and Ending day.</p>
                    </div>
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function selectedFundCount() {
        var selectedValues = $('#allocation_select_fund').val() || [];
        return selectedValues.length;
    }

    function updateFundSelectionState() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var count = selectedFundCount();

        if (category !== 'by_fund') {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        if (count >= 2 && count <= 10) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 10 for <b>Funds</b></p>');
        $('#submit_btn').prop('disabled', true);
    }

    function toggleRankingFields() {
        var ranking = $('input[name="ranking"]:checked').val() || 'range';
        var isAsOn = ranking === 'as_on';

        $('.div_show').toggle(!isAsOn);
        $('.div_hide').toggle(isAsOn);

        $('input[name="start_date"], input[name="end_date"]').prop('disabled', isAsOn);
        $('input[name="as_on_date"], select[name="as_on_time_frame"]').prop('disabled', !isAsOn);
    }

    function toggleCategoryFields() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var isByFund = category === 'by_fund';

        $('.div_show_1').toggle(!isByFund);
        $('.div_hide_1').toggle(isByFund);

        $('select[name="fund_type_id"]').prop('disabled', isByFund);
        $('select[name="fund_id[]"]').prop('disabled', !isByFund);
    }

    function set_fund_select_val() {
        updateFundSelectionState();
    }

    function fund_multiple(selectElement) {
        updateFundSelectionState();
    }


    function get_date(thiss) {

        if (thiss == 'Range') {

            $('#from_date_div').show();
            $('#year_month').prop('required', false);
            $('#year_month_div').attr('style', 'display:none');
            $('#to_date').attr('placeholder', 'End Date');


        } else if (thiss == 'As on') {

            $('#from_date_div').hide(); // $('#from_date_div').val('');

            $('#from_date').prop('required', false);
            $('#year_month_div').removeAttr('style');
            $('#year_month').prop('required', true);
            $('#to_date').attr('placeholder', 'Date');

        }

    }

    function get_classification(thiss) {

        if (thiss == 'classification') {

            $('#fund_type_div').removeAttr('style');
            $('#fund_type').prop('required', true);


            $('#fund_master').prop('required', false);

            $('#fund_name_div').attr('style', 'display:none');

        } else if (thiss == 'fund') {

            $('#fund_type_div').attr('style', 'display:none');
            $('#fund_type').prop('required', false);


            $('#fund_master').prop('required', true);

            $('#fund_name_div').removeAttr('style');


        }

    }


    function get_fund_types(thiss) {
        toggleCategoryFields();
        updateFundSelectionState();
    }


    function initPerformanceRatiosPage() {
        toggleRankingFields();
        toggleCategoryFields();
        updateFundSelectionState();

        $('input[name="ranking"]').on('change', toggleRankingFields);
        $('input[name="Category"]').on('change', function() {
            get_fund_types(this.value);
        });
        $('#allocation_select_fund').on('change', updateFundSelectionState);

        var exportButton = document.getElementById('exportPDF');

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

                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Performance Ratios', pageWidth / 2, 35, {
                    align: 'center'
                });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and ratio details
                var startDate =
                    "{{ isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000' }}";
                var endDate =
                    "{{ isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000' }}";
                var ratio =
                    @if (isset($request->report_category))
                        @switch($request->report_category)
                            @case('returns')
                            'Returns/CAGR'
                            @break

                            @case('jensens_alpha')
                            'Jensen’s alpha'
                            @break

                            @case('sharpe')
                            'Sharpe'
                            @break

                            @case('treynor')
                            'Treynor'
                            @break

                            @case('information_ratio')
                            'Information Ratio'
                            @break

                            @case('one_month_rolling_return')
                            '1 month Rolling Return'
                            @break

                            @case('beta')
                            'Beta'
                            @break

                            @case('volatility')
                            'Volatility'
                            @break

                            @case('tracking_error')
                            'Tracking Error'
                            @break

                            @case('skewness')
                            'Skewness'
                            @break

                            @case('kurtosis')
                            'Kurtosis'
                            @break

                            @case('r_square')
                            'R Sqaure'
                            @break
                        @endswitch
                    @endif ;
                var duration =
                    @if (isset($as_on_time_frame_data))
                        @switch($request->as_on_time_frame)
                            @case('1_month')
                            '1 Month'
                            @break

                            @case('3_months')
                            '3 Months'
                            @break

                            @case('6_months')
                            '6 Months'
                            @break

                            @case('1_year')
                            '1 Year'
                            @break

                            @case('2_year')
                            '2 Years'
                            @break

                            @case('3_years')
                            '3 Years'
                            @break

                            @case('5_years')
                            '5 Years'
                            @break

                            @default
                            null
                        @endswitch
                    @else
                        null
                    @endif ;

                var fundClassification = "{{ isset($fund_type_name) ? $fund_type_name : '' }}";

                var startX = 15;
                var lineHeight = 10;
                var tableStartY = 70;

                doc.text(`Start date: ${startDate}`, startX, tableStartY - 20);
                doc.text(`End date: ${endDate}`, startX + 100, tableStartY - 20);

                doc.text(`By Ratio: ${ratio}`, startX, tableStartY - 10);
                // doc.text(`Duration: ${duration}`, startX + 100, tableStartY - 10);
                if (duration !== null) {
                    doc.text(`Duration: ${duration}`, startX + 100, tableStartY - 10);
                }

                if ("{{ $request->Category }}" == 'by_category') {
                    doc.text(`Fund Classification: ${fundClassification}`, startX, tableStartY);
                }

                var table = new DataTable('#pdfData');
                var tableData = [];
                table.rows({
                    search: 'applied'
                }).data().each(function(row) {
                    tableData.push(row);
                });

                doc.autoTable({
                    head: [
                        ['Fund Name', 'Ratio', 'Rank']
                    ],
                    body: tableData,
                    startX: startX,
                    startY: tableStartY + 10,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    }
                });

                var currentDate = new Date();

                var fileName = 'Performance-Ratios-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPerformanceRatiosPage);
    } else {
        initPerformanceRatiosPage();
    }
</script>
@endpush
