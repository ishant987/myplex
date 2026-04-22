@extends('web.layout.infosolz_user_app')
@section('content')
    @php
        $selectedRanking = old('ranking', $request->ranking ?? 'range');
        $selectedCompareType = old('compare_type', $request->compare_type ?? 'Scheme');
        $isAsOnMode = $selectedRanking === 'as_on';
    @endphp
    <style>
        .r-square-toggle {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .r-square-toggle p {
            margin: 0;
            font-weight: 600;
        }

        .r-square-toggle a {
            min-width: 112px;
            text-align: center;
        }

        .r-square-form .subs_in.bttn_grp {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .r-square-form .subs_in.bttn_grp p {
            margin: 0;
        }
    </style>

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="head_brdcm">
                        <ul class="brdcmb">
                            <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                            <li><a href="{{ route('user.ratio_dashboard') }}">Ratio Reports</a></li>
                            <li>R-Square Ratios Reports</li>
                        </ul>
                    </div>
                 
                    <div class="light_green_bg r-square-form">
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

                                <div class="col-md-4 ">
                                    <div class="subs_in bttn_grp w-100 mb-3">
                                        <p>Select Primary </p>   
                                        <a href="javascript:void(0)">Scheme</a>         
                                    </div>
                                    <div class="form_group">
                                        <select name="scheme_id" class="select2 " id=""
                                            data-placeholder="Select Primary Scheme" >        
                                                <option value="">Select Primary Scheme</option>                                    
                                                @foreach ($funds as $fund)
                                                    <option value="{{ $fund->fund_id }}"
                                                        @if ($fund->fund_id == old('fund_id', $request->scheme_id)) selected
                                                     @endif>
                                                        {{ $fund->fund_name }}
                                                    </option>
                                                @endforeach
                                              
                                        </select>
                                        @error('fund_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="Category" id="Category" value=by_fund>
                                    
                                </div>

                                <div class="col-md-8 ">
                                    
                                    <div class="subs_in bttn_grp w-100 mb-3 r-square-toggle" style="z-index:1;">
                                        <p>Compare With </p>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Scheme');selectCompareTypeList('Scheme');" class="@if ($selectedCompareType == 'Scheme') bg-secondary @endif">Scheme</a>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Index');selectCompareTypeList('Index');" class="@if ($selectedCompareType == 'Index') bg-secondary @endif">Index</a>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Currency');selectCompareTypeList('Currency');" class="@if ($selectedCompareType == 'Currency') bg-secondary @endif">Currency</a>
                                        <a href="javascript:void(0)" onclick="$('#compare_type').val('Commodity');selectCompareTypeList('Commodity');" class="@if ($selectedCompareType == 'Commodity') bg-secondary @endif">Commodity</a>                                    
                                    </div>
                                    <div class="form_group d-none">
                                        <select name="compare_type" id="compare_type" onchange=" selectCompareTypeList(this.value);">
                                            <option value="Scheme"  @if (old('compare_type', $request->compare_type) == 'Scheme') selected @endif > Scheme </option>
                                            <option value="Index"  @if (old('compare_type', $request->compare_type) == 'Index') selected @endif > Index </option>
                                            <option value="Currency"  @if (old('compare_type', $request->compare_type) == 'Currency') selected @endif > Currency </option>
                                            <option value="Commodity"  @if (old('compare_type', $request->compare_type) == 'Commodity') selected @endif > Commodity </option>
                                        </select>
                                        @error('compare_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form_group">
                                        
                                        <div id="fund_wrapper" class="@if ($selectedCompareType != 'Scheme') d-none @endif">
                                            <select name="fund_id[]" class=" select2  multiple" multiple
                                                id="allocation_select_fund" onchange ='fund_multiple(this,"scheme")'
                                                data-placeholder="Select Schemes" data-min="1"  data-max="10" style="">
                                                    @foreach ($funds as $fund)
                                                        <option value="{{ $fund->fund_id }}"
                                                            @if ($fund->fund_id == old('fund_id', $request->fund_id)) selected
                                                        @elseif(isset($fund_id) && in_array($fund->fund_id, $fund_id))
                                                        selected @endif>
                                                            {{ $fund->fund_name }}
                                                        </option>
                                                    @endforeach
                                                
                                            </select>
                                        </div>
                                        <div id="index_wrapper" class="@if ($selectedCompareType != 'Index') d-none @endif">
                                            <select name="index_id[]" class=" select2  multiple " multiple
                                                id="allocation_select_index" onchange ='fund_multiple(this,"index")'
                                                data-placeholder="Select Indexes" data-min="1"  data-max="10" style="">
                                                    @foreach ($indices as $indice)
                                                        <option value="{{ $indice->idc_id }}"
                                                            @if ($indice->idc_id == old('idc_id', $request->index_id)) selected
                                                        @elseif(isset($index_id) && in_array($indice->idc_id, $index_id))
                                                        selected @endif>
                                                            {{ $indice->name }}
                                                        </option>
                                                    @endforeach
                                                
                                            </select>
                                        </div>
                                        <div id="currency_wrapper" class="@if ($selectedCompareType != 'Currency') d-none @endif">
                                            <select name="currency_id[]" class="  select2 multiple " multiple
                                                id="allocation_select_currency" onchange ='fund_multiple(this,"currency")'
                                                data-placeholder="Select Currencies" data-min="1"  data-max="10" style="">  
                                                    @foreach ($currencies as $currency)
                                                    @if($currency->is_comodity=='0')
                                                        <option value="{{ $currency->cm_id }}"
                                                            @if ($currency->cm_id == old('cm_id', $request->currency_id)) selected
                                                        @elseif(isset($currency_id) && in_array($currency->cm_id, $currency_id))
                                                        selected @endif>
                                                            {{ $currency->name }}
                                                        </option>
                                                    @endif
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div id="commodity_wrapper" class="@if ($selectedCompareType != 'Commodity') d-none @endif">
                                            <select name="commodity_id[]" class=" select2  multiple" multiple
                                                id="allocation_select_commodity" onchange ='fund_multiple(this,"commodity")'
                                                data-placeholder="Select Commodities" data-min="1"  data-max="10" style="">  
                                                    @foreach ($currencies as $commodity)
                                                    @if($commodity->is_comodity=='1')
                                                        <option value="{{ $commodity->cm_id }}"
                                                            @if ($commodity->cm_id == old('cm_id', $request->commodity_id)) selected
                                                        @elseif(isset($commodity_id) && in_array($commodity->cm_id, $commodity_id))
                                                        selected @endif>
                                                            {{ $commodity->name }}
                                                        </option>
                                                    @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 ">
                                    
                                    
                                    
                                </div>

                                <input type="hidden" name="report_category" value="r_square">


                                



                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (isset($request) &&
                            isset($start_date) &&
                            isset($end_date) &&
                            $request->Category != '' &&
                            $request->report_category != '')


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
                                        {{ 'R Sqaure' }}
                                    </span>
                                </li>

                                @if (!empty($as_on_time_frame_data))
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

                                

                                
                                    <li>
                                        <p>primary Fund Name :</p>
                                        <span>{{ $schemeMaterData->fund_name ?? '' }}</span>
                                    </li>
                                
                                @if (isset($request) && $request->Category == 'by_fund')
                                    <li>
                                        <p>Compare {{ strtolower($request->compare_type ?? 'scheme') }} names :</p>
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
                                <a href="javascript:void(0)" id="exportPDF" class="pdf d-none"><img
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
                                        @foreach ($sortedFundReturns as $Id => $value)
                                            <tr>
                                                <td class="text_left">
                                                    @if($request->compare_type=='Scheme')
                                                    {{ getNameTable('fund_master', 'fund_name', 'fund_id', $Id) }}
                                                    @elseif($request->compare_type=='Index')
                                                    {{ getNameTable('indices_master', 'name', 'idc_id', $Id) }}
                                                    @elseif($request->compare_type=='Currency')
                                                    {{ getNameTable('currency_master', 'name', 'cm_id', $Id) }}
                                                    @elseif($request->compare_type=='Commodity')
                                                    {{ getNameTable('currency_master', 'name', 'cm_id', $Id) }}
                                                    @endif
                                                </td>
                                                <td class="text_right">
                                                    {{ is_numeric(printValue($value)) ? printValue($value) : ' ' }}</td>
                                                <td class="text_right">{{ printRank($ranks[$Id]) }}</td>
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
                    @else
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

<script>
    function selectedCompareCount(type) {
        var map = {
            Scheme: '#allocation_select_fund',
            Index: '#allocation_select_index',
            Currency: '#allocation_select_currency',
            Commodity: '#allocation_select_commodity'
        };

        return ($(map[type]).val() || []).length;
    }

    function toggleRankingFields() {
        var ranking = $('input[name="ranking"]:checked').val() || 'range';
        var isAsOn = ranking === 'as_on';

        $('.div_show').toggle(!isAsOn);
        $('.div_hide').toggle(isAsOn);

        $('input[name="start_date"], input[name="end_date"]').prop('disabled', isAsOn);
        $('input[name="as_on_date"], select[name="as_on_time_frame"]').prop('disabled', !isAsOn);
    }

    function selectCompareTypeList(type) {
        $('#compare_type').val(type);
        $('#fund_wrapper, #index_wrapper, #currency_wrapper, #commodity_wrapper').addClass('d-none');

        if (type === 'Scheme') {
            $('#fund_wrapper').removeClass('d-none');
        } else if (type === 'Index') {
            $('#index_wrapper').removeClass('d-none');
        } else if (type === 'Currency') {
            $('#currency_wrapper').removeClass('d-none');
        } else if (type === 'Commodity') {
            $('#commodity_wrapper').removeClass('d-none');
        }

        $('.r-square-toggle a').removeClass('bg-secondary');
        $('.r-square-toggle a').filter(function() {
            return $(this).text().trim() === type;
        }).addClass('bg-secondary');

        updateCompareSelectionState();
    }

    function updateCompareSelectionState() {
        var type = $('#compare_type').val() || 'Scheme';
        var count = selectedCompareCount(type);

        if (count >= 1 && count <= 10) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            return;
        }

        $('#fund_msgg').html('<p>Selection limit minimum 1 and maximum 10 for <b>' + type + '</b></p>');
        $('#submit_btn').prop('disabled', true);
    }

    function fund_multiple() {
        updateCompareSelectionState();
    }


    document.addEventListener('DOMContentLoaded', function() {
        toggleRankingFields();
        selectCompareTypeList($('#compare_type').val() || 'Scheme');

        $('input[name="ranking"]').on('change', toggleRankingFields);
        $('#allocation_select_fund, #allocation_select_index, #allocation_select_currency, #allocation_select_commodity').on('change', function() {
            updateCompareSelectionState();
        });

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

                var fundClassification = "{{ isset($fund_type_name) ? $fund_type_name[0] : '' }}";

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
    });
</script>
