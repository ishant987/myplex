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
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.ratio_analysis') }}"> Ratio Analysis</a></li>
                        <li>Return Ratio</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="{{ isset($quartile_set) ? $quartile_set : 'quartile' }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="ranking" value="range"
                                                {{ $selectedRanking === 'range' ? 'checked' : '' }}>
                                            Range
                                        </label>
                                        <label>
                                            <input type="radio" name="ranking" value="as_on"
                                                {{ $selectedRanking === 'as_on' ? 'checked' : '' }}>
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
                                                {{ $selectedCategory === 'by_category' ? 'checked' : '' }}
                                                onchange="toggleCategoryFields(); updateFundSelectionState();">
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                {{ $selectedCategory === 'by_fund' ? 'checked' : '' }}
                                                onchange="toggleCategoryFields(); updateFundSelectionState();">
                                            By Fund
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-4 div_show_1" id="fund_type_wrap" style="{{ $isByFundMode ? 'display:none;' : '' }}">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Classification"
                                            {{ $isByFundMode ? 'disabled' : '' }}>
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

                                <div class="col-md-4 div_hide_1" id="fund_select_wrap" style="{{ $isByFundMode ? '' : 'display:none;' }}">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'
                                            {{ $isByFundMode ? '' : 'disabled' }}>
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

                                <div class="col-md-4" >
                                    <div class="form_group">
                                        <select name="report_category" onchange="index_enable(this.value)">
                                            <option value="">Ratio</option>

                                            <option value="returns" @if (old('report_category', $request->report_category) == 'returns') selected @endif>
                                                Returns/CAGR
                                            </option>
                                            <option value="jensens_alpha"
                                                @if (old('report_category', $request->report_category) == 'jensens_alpha') selected @endif>
                                                Jensen’s alpha
                                            </option>
                                            <option value="sharpe" @if (old('report_category', $request->report_category) == 'sharpe') selected @endif>
                                                Sharpe
                                            </option>
                                            <option value="treynor" @if (old('report_category', $request->report_category) == 'treynor') selected @endif>
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

                                
                                <div class="col-md-4" id="indexxes" @if(isset($request) &&($request->report_category == 'one_month_rolling_return')) style = 'display:none;' @else  @endif>
                                    <div class="form_group">
                                        <select name="index_id" id="index_id" class="select2" data-placeholder="Select Indices">
                                            <option value=""></option>
                                            @foreach($indices as $ind)

                                            <option value="{{ $ind->idc_id}}"  @if ($ind->idc_id == old('fund_type_id', $request->index_id)) selected @endif>{{$ind->name}}</option>

                                            @endforeach


                                        </select>
                                        @error('index_id')
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
                                    <span class="text-danger d-block mt-2" id="filter_msgg"></span>
                                </div>
                            </div>
                        </form>
                    </div>



                    @if(isset($request)&& isset($start_date) && isset($end_date) &&  $request->Category !='' && $request->report_category !='')

                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Start date :</p>
                                    <span>{{ isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000' }}</span>
                                </li>
                                <li>
                                    <p>End date :</p>
                                    <span>{{ isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000' }}</span>
                                </li>

                               

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

                            @if (isset($request) && $request->index_id != '')
                            <li>
                                <p>Index Name:</p>
                                <span>{{ isset($index_name->name) ? $index_name->name : '' }}</span>
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
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                
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

                                        // $sortedFundReturns = collect($fundReturns)->sortDesc()->toArray();

                                        arsort($fundReturns);

                                        // Convert the sorted array to a collection if needed
                                        $sortedFundReturns = collect($fundReturns)->toArray();


                                        $formattedArray = array_map(function($value) {
                                            return is_numeric($value) ? number_format($value, 2) : $value;
                                        }, $sortedFundReturns);

                                    $ranks = [];
                                    $rank = 1;
                                    $previousValue = null;
                                    $previousRank = 0;

                                    foreach ($formattedArray as $key => $value) {
                                        if ($value == 'N/A' || $value == '') {
                                            $ranks[$key] = 'N/A';
                                        } else {
                                            if ($value === $previousValue) {
                                                // Assign the same rank as the previous value
                                                $ranks[$key] = $previousRank;
                                            } else {
                                                // Assign current rank and update previous rank and value
                                                $ranks[$key] = $rank;
                                                $previousRank = $rank;
                                                $previousValue = $value;
                                            }
                                            $rank++;
                                        }
                                    }


                                    @endphp
                                    @endif


                                    @if (isset($formattedArray) && count($formattedArray) > 0)
                                    @foreach ($formattedArray as $fundId => $value)
                                        <tr>
                                            <td class="text_left">
                                                {{ getNameTable('fund_master', 'fund_name', 'fund_id', $fundId) }}</td>
                                            <td class="text_right">{{ printValue($value) }}</td>
                                            <td class="text_right">{{ printRank($ranks[$fundId]) }}</td>
                                        </tr>
                                    @endforeach
                                    {{-- @else
                                    <tr>
                                        <td colspan="3">No records found</td>
                                    </tr> --}}
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div> --}}
                        @if (!empty($message))
                            <div class="alert alert-warning mt-3">{{ $message }}</div>
                        @else
                            {!! printNoData() !!}
                        @endif
                    @endif
                </div>
                @if (isset($stat_result['fund_absolute_return']))
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

@php
    $pdfRatioLabel = null;

    if (isset($request->report_category)) {
        switch ($request->report_category) {
            case 'returns':
                $pdfRatioLabel = 'Returns/CAGR';
                break;
            case 'jensens_alpha':
                $pdfRatioLabel = 'Jensen’s alpha';
                break;
            case 'sharpe':
                $pdfRatioLabel = 'Sharpe';
                break;
            case 'treynor':
                $pdfRatioLabel = 'Treynor';
                break;
            case 'information_ratio':
                $pdfRatioLabel = 'Information Ratio';
                break;
            case 'one_month_rolling_return':
                $pdfRatioLabel = '1 month Rolling Return';
                break;
            case 'beta':
                $pdfRatioLabel = 'Beta';
                break;
            case 'volatility':
                $pdfRatioLabel = 'Volatility';
                break;
            case 'tracking_error':
                $pdfRatioLabel = 'Tracking Error';
                break;
            case 'skewness':
                $pdfRatioLabel = 'Skewness';
                break;
            case 'kurtosis':
                $pdfRatioLabel = 'Kurtosis';
                break;
            case 'r_square':
                $pdfRatioLabel = 'R Square';
                break;
        }
    }

    $pdfDurationLabel = null;

    if (isset($as_on_time_frame_data)) {
        switch ($request->as_on_time_frame) {
            case '1_month':
                $pdfDurationLabel = '1 Month';
                break;
            case '3_months':
                $pdfDurationLabel = '3 Months';
                break;
            case '6_months':
                $pdfDurationLabel = '6 Months';
                break;
            case '1_year':
                $pdfDurationLabel = '1 Year';
                break;
            case '2_year':
                $pdfDurationLabel = '2 Years';
                break;
            case '3_years':
                $pdfDurationLabel = '3 Years';
                break;
            case '5_years':
                $pdfDurationLabel = '5 Years';
                break;
        }
    }
@endphp

@push('scripts')
<script>
    function selectedFundCount() {
        return ($('#allocation_select_fund').val() || []).length;
    }

    function updateFundSelectionState() {
        var category = $('input[name="Category"]:checked').val() || 'by_category';
        var count = selectedFundCount();
        var ratio = $('select[name="report_category"]').val();
        var fundTypeId = $('select[name="fund_type_id"]').val();
        var message = '';

        if (!ratio) {
            message = 'Select a ratio to run this report.';
        } else if (category === 'by_category' && !fundTypeId) {
            message = 'Select a fund classification to run this report.';
        } else if (category === 'by_fund' && (count < 2 || count > 20)) {
            message = 'Selection limit minimum 2 and maximum 20 for Funds.';
        }

        $('#fund_msgg').html(category === 'by_fund' && message ? '<p>' + message + '</p>' : '');
        $('#filter_msgg').text(message && category !== 'by_fund' ? message : '');
        $('#submit_btn').prop('disabled', message !== '');
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
        var fundTypeWrap = $('#fund_type_wrap');
        var fundSelectWrap = $('#fund_select_wrap');
        var fundTypeSelect = $('select[name="fund_type_id"]');
        var fundSelect = $('select[name="fund_id[]"]');

        fundTypeWrap.toggle(!isByFund);
        fundSelectWrap.toggle(isByFund);

        fundTypeSelect.prop('disabled', isByFund);
        fundSelect.prop('disabled', !isByFund);

        if (isByFund) {
            $('#filter_msgg').text('');
        } else {
            $('#fund_msgg').empty();
        }

        if (fundTypeSelect.hasClass('select2-hidden-accessible')) {
            fundTypeSelect.trigger('change.select2');
        }

        if (fundSelect.hasClass('select2-hidden-accessible')) {
            fundSelect.trigger('change.select2');
        }
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




    function set_fund_select_val() {
        updateFundSelectionState();
    }


    function get_fund_types(thiss) {
        toggleCategoryFields();
        updateFundSelectionState();
    }


    function index_enable(thiss){

        if(thiss == 'one_month_rolling_return'){

            $('#indexxes').hide();
            $('#index_id').val(1);

        }else{
            $('#indexxes').show();
            $('#index_id').val('');


        }

    }

    function initReturnRatioPage() {
        toggleRankingFields();
        toggleCategoryFields();
        updateFundSelectionState();
        index_enable($('select[name="report_category"]').val());

        $('input[name="ranking"]').on('change', toggleRankingFields);
        $('input[name="Category"]').on('change', toggleCategoryFields);
        $('input[name="Category"]').on('change', updateFundSelectionState);
        $('#allocation_select_fund').on('change', updateFundSelectionState);
        $('select[name="fund_type_id"], select[name="report_category"]').on('change', updateFundSelectionState);

        var exportButton = document.getElementById('exportPDF');

        if (!exportButton) {
            return;
        }

        exportButton.addEventListener('click', function() {
            var { jsPDF } = window.jspdf;
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
                doc.text('Return Ratios', pageWidth / 2, 35, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                var startDate = "{{ isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '00/00/0000' }}";
                var endDate = "{{ isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '00/00/0000' }}";
                var ratio = @json($pdfRatioLabel);
                var duration = @json($pdfDurationLabel);
                var fundClassification = "{{ isset($fund_type_name) ? $fund_type_name[0] : '' }}";
                var indexName = "{{ isset($index_name->name) ? $index_name->name : '' }}";
                var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";

                var startX = 15;
                var lineHeight = 10;
                var yPosition = 70;

                doc.text('Start date: ' + startDate, startX, yPosition);
                doc.text('End date: ' + endDate, startX + 100, yPosition);
                yPosition += 10;

                doc.text('By Ratio: ' + ratio, startX, yPosition);
                if (duration !== null) {
                    doc.text('Duration: ' + duration, startX + 100, yPosition);
                }
                yPosition += 10;

                @if (isset($request) && $request->Category == 'by_category')
                    doc.text('Fund Classification: ' + fundClassification, startX, yPosition);
                    yPosition += 10;
                @endif

                @if (isset($request) && $request->index_id != '')
                    doc.text('Index Name: ' + indexName, startX, yPosition);
                    yPosition += 10;
                @endif

                @if (isset($request) && $request->Category == 'by_fund')
                    var splitFundNames = doc.splitTextToSize(fundNames, 160);
                    doc.text('Fund Name: ', startX, yPosition);
                    yPosition += 10;
                    doc.text(splitFundNames, startX, yPosition);
                    yPosition += splitFundNames.length * lineHeight;
                @endif

                var table = new DataTable('#pdfData');
                var tableData = [];
                table.rows({ search: 'applied' }).data().each(function(row) {
                    tableData.push(row);
                });

                doc.autoTable({
                    head: [['Fund Name', 'Ratio', 'Rank']],
                    body: tableData,
                    startX: startX,
                    startY: yPosition + 10,
                    headStyles: { fillColor: [45, 135, 23] }
                });

                var currentDate = new Date();
                var fileName = 'Return-Ratios-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initReturnRatioPage);
    } else {
        initReturnRatioPage();
    }
</script>
@endpush
