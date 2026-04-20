@extends('web.layout.infosolz_user_app')
@section('content')
    {{-- @dd($fund_id) --}}
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.ratio_dashboard') }}">Ratio Reports</a></li>
                        <li>Quartile & Decile</li>
                    </ul>
                </div>

                <div class="perform_head">
                    <h2>Quartile & Decile</h2>
                </div>

                <div class="new_page">

                    <div class="wm_tab">
                        <ul class="tabs">
                            <li>
                                <a class="{{ isset($request->quartile_set) ? ($request->quartile_set == 'quartile' ? 'active' : '') : 'active' }}"
                                    id="quartile_tab" data-value="quartile" onclick="max_min_fund(this)">Quartile</a>
                            </li>
                            <li>
                                <a class="{{ isset($request->quartile_set) && $request->quartile_set == 'decile' ? 'active' : '' }}"
                                    id="decile_tab" data-value="decile" onclick="max_min_fund(this)">Decile</a>
                            </li>
                        </ul>
                    </div>

                    {{-- <div class="perform_head q_d">
                    <h2 class="quartile active">Quartile Score</h2>
                    <h2 class="decile">Decile Score</h2>
                </div> --}}

                    <input type="hidden" name="quartile_status" id="quartile_status"
                        value="{{ isset($quartile_set) ? $quartile_set : '' }}">

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="{{ isset($quartile_set) ? $quartile_set : 'quartile' }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category" checked
                                                value="by_category"
                                                @if (isset($request) && $request->Category == 'by_category') {{ 'Checked' }} @endif
                                                onclick='get_fund_types_js(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                @if (isset($request) && $request->Category == 'by_fund') {{ 'Checked' }} @endif
                                                onclick='get_fund_types_js(this.value)'>
                                            By Fund
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Type"
                                            id="fund_type">
                                            <option value="">Select Fund Type</option>
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

                                <div class="col-md-4 div_hide_1">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple id="select_fund_multiple"
                                            data-max="20" multiple onchange='fund_multiple(this)'>
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
                                        <span class="text-danger" id="fund_msgg"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="report_category">
                                            <option value="">Ratio</option>
                                            <optgroup label="Return Ratio">
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

                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="ranking" value="range" checked>
                                            Range
                                        </label>
                                        <label>
                                            <input type="radio" name="ranking" value="as_on">
                                            As on
                                        </label>
                                        @error('ranking')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 div_show">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" placeholder="Start date" name="start_date"
                                            value="{{ $request->has('start_date') ? $request->start_date : old('start_date') }}">
                                        @error('start_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 div_show">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" placeholder="End date" name="end_date"
                                            value="{{ $request->has('end_date') ? $request->end_date : old('end_date') }}">
                                        @error('end_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide">
                                    <div class="form_group">
                                        <input type="text" name="as_on_date" class="datepicker" placeholder="date"
                                            value="{{ $request->as_on_date }}">
                                    </div>
                                </div>
                                <div class="col-md-4 div_hide">
                                    <div class="form_group">
                                        <select name="as_on_time_frame">
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

                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" id="submit_btn">Search</button>
                                        <!-- <button type="submit" name="submit" value="search_by_fund">show by fund</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (isset($request) && $request->Category != '' && $request->report_category != '')
                        <div class="tabsct">
                            {{-- <div class="tab"> --}}

                            <div class="quartile_table"
                                @if (isset($quartile_set) && $quartile_set == 'quartile') style="display: block;" @else style="display: none;" @endif>
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <li>
                                            <p>start date :</p>
                                            <span>{{ isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '' }}</span>
                                        </li>
                                        <li>
                                            <p>end date :</p>
                                            <span>{{ isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '' }}</span>
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

                                        {{-- @if (isset($request->report_category) && $request->report_category == 'one_month_rolling_return')
                                                <li>
                                                    <p>Values as on :</p>
                                                    <span>{{ date('d/m/Y', strtotime($start_date))}} to {{ date('d/m/Y', strtotime($end_date))}}</span>
                                                </li>
                                            @endif --}}


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
                                        <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                                        <a href="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/pdf-sample.pdf"
                                            download class="pdf"><img
                                                src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/pdf.png"
                                                alt=""></a>
                                    </div>

                                    <table class="table {{ isset($quartile_set) && $quartile_set === 'quartile' ? 'datatable' : ''}}">
                                        <thead>
                                            <tr>
                                                <th class="text_left">fund name</th>
                                                <th class="text_center">ratio</th>
                                                <th class="text_center">Quartile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($quartile_set) && $quartile_set === 'quartile')
                                                @if (isset($quartile_decile_result['fund_absolute_return']) && isset($quartile_decile_result['decile']))
                                                    @php
                                                        $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                                        if (
                                                            isset($report_category) &&
                                                            isset($quartile_decile_result['fund_absolute_return'])
                                                        ) {
                                                            if (in_array($report_category, $ratio_array)) {
                                                                asort($quartile_decile_result['fund_absolute_return']);

                                                                asort($quartile_decile_result['quartile']);

                                                            } else {
                                                                arsort($quartile_decile_result['fund_absolute_return']);

                                                                arsort($quartile_decile_result['quartile']);


                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($quartile_decile_result['fund_absolute_return'] as $fundId => $value)
                                                        <tr>
                                                            <td class="text_left">
                                                                {{ getNameTable('fund_master', 'fund_name', 'fund_id', $fundId) }}
                                                            </td>
                                                            <td class="text_right">{{ printValue($value) }}</td>
                                                            <td class="text_right">
                                                                {{ (intval($quartile_decile_result['quartile'][$fundId]) > 0) && (printValue($value) !='N/A') ? intval($quartile_decile_result['quartile'][$fundId]) : 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3">No records found</td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td colspan="3">No information available for this search</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                            {{-- <div class="tab"> --}}
                            <div class="decile_table"
                                @if (isset($quartile_set) && $quartile_set == 'decile') style="display: block;" @else style="display: none;" @endif>
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <li>
                                            <p>start date :</p>
                                            <span>{{ isset($start_date) ? date('d/m/Y', strtotime($start_date)) : '' }}</span>
                                        </li>
                                        <li>
                                            <p>end date :</p>
                                            <span>{{ isset($end_date) ? date('d/m/Y', strtotime($end_date)) : '' }}</span>
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

                                        {{-- @if (isset($request->report_category) && $request->report_category == 'one_month_rolling_return')
                                            <li>
                                                <p>Values as on :</p>
                                                <span>{{ date('d/m/Y', strtotime($start_date))}} to {{ date('d/m/Y', strtotime($end_date))}}</span>
                                            </li>
                                        @endif --}}


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
                                        <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                                        <a href="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/pdf-sample.pdf"
                                            download class="pdf"><img
                                                src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/pdf.png"
                                                alt=""></a>
                                    </div>
                                    <table class="table {{ isset($quartile_set) && $quartile_set === 'decile' ? 'datatable' : ''}}">
                                        <thead>
                                            <tr>
                                                <th class="text_left">fund name</th>
                                                <th class="text_center">ratio</th>
                                                <th class="text_center">Decile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($request->quartile_set) && $request->quartile_set === 'decile')
                                                @if (isset($quartile_decile_result['fund_absolute_return']) && isset($quartile_decile_result['decile']))
                                                    @php
                                                        $ratio_array = ['beta', 'volatility', 'tracking_error'];
                                                        if (
                                                            isset($request->report_category) &&
                                                            isset($quartile_decile_result['fund_absolute_return'])
                                                        ) {
                                                            if (in_array($request->report_category, $ratio_array)) {
                                                                asort($quartile_decile_result['fund_absolute_return']);

                                                                asort($quartile_decile_result['decile']);

                                                            } else {
                                                                arsort($quartile_decile_result['fund_absolute_return']);

                                                                arsort($quartile_decile_result['decile']);

                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($quartile_decile_result['fund_absolute_return'] as $fundId => $value)
                                                        <tr>
                                                            <td class="text_left">
                                                                {{ getNameTable('fund_master', 'fund_name', 'fund_id', $fundId) }}
                                                            </td>
                                                            <td class="text_right">{{ printValue($value) }}</td>
                                                            <td class="text_right">
                                                                {{ (intval($quartile_decile_result['decile'][$fundId]) > 0) && (printValue($value) !='N/A') ? intval($quartile_decile_result['decile'][$fundId]) : 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3">No records found</td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td colspan="3">No information available for this search</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    /*function get_fund_types(thiss) {
        // alert(thiss);
        if (thiss === 'by_fund') {
            $('#type_Category').removeAttr('checked', 'checked');
            $('#fund_Category').attr('checked', 'checked');
        } else if (thiss === 'by_category') {
            $('#type_Category').attr('checked', 'checked');
            $('#fund_Category').removeAttr('checked', 'checked');
        }
    }

    function max_min_fund(element) {

        var value = element.getAttribute('data-value');
        // console.log(value);

        $('#quartile_set').val(value);

        // $('#fund_msgg').html('');

        var quartile_set = $('#quartile_set').val();
        var thiss = $('#fund_Category').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log('quartile_set:', quartile_set);
        console.log('Category:', thiss);
        console.log('count:', count);

        if (thiss == 'by_fund') {

            if (quartile_set == 'quartile') {

                $('#fund_msgg').html('<p>Funds selection limit minimum 4 and maximum 20 for <b>Quartile</b></p>');

                if (count >= 4 && count <= 20) {
                    $('#submit_btn').prop('disabled', false);
                } else {

                    $('#submit_btn').prop('disabled', true);
                }
            } else if (quartile_set == 'decile') {

                $('#fund_msgg').html('<p>Funds selection limit minimum 10 and maximum 20 for <b>Decile</b></p>');
                console.log(count);
                if (count >= 10 && count <= 20) {

                    $('#submit_btn').prop('disabled', false);
                } else {

                    $('#submit_btn').prop('disabled', true);
                }
            }
        } else {
            $('#submit_btn').prop('disabled', false);
        }


    }

    window.onload = function() {

        // alert('onload');

        var get_quartile = $('#quartile_set').val();

        var thiss = $('#fund_Category').val();


        $('#submit_btn').prop('disabled', false);

        console.log('q--' + get_quartile);

        if (get_quartile == 'quartile') {
            var element = document.getElementById('quartile_tab');

            $('#quartile_tab').attr('class', 'active');
            $('#decile_tab').removeAttr('class', 'active');


        } else if (get_quartile == 'decile') {
            var element = document.getElementById('decile_tab');


            $('#quartile_tab').removeAttr('class', 'active');
            $('#decile_tab').attr('class', 'active');

        } else {
            var element = document.getElementById('quartile_tab');
        }

        max_min_fund(element);

        // $('#quartile_set').value(element);
    }

    function set_fund_select_val() {

        var quartile_set = $('#quartile_set').val();
        var thiss = $('#fund_Category').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log('quartile_set:', quartile_set);
        console.log('Category:', thiss);
        console.log('count:', count);

        if (thiss == 'by_fund') {
            if (quartile_set == 'quartile') {
                if (count >= 4 && count <= 20) {
                    // console.log('enable');
                    $('#submit_btn').prop('disabled', false);
                } else {
                    // console.log('disabled');
                    // alert('Funds selection limit minimum 4 and maximum 20');
                    $('#fund_msgg').html('<p>Funds selection limit minimum 4 and maximum 20 for <b>Quartile</b></p>');
                    $('#submit_btn').prop('disabled', true);
                }
            } else if (quartile_set == 'decile') {
                if (count >= 10 && count <= 20) {
                    $('#submit_btn').prop('disabled', false);
                } else {
                    // alert('Funds selection limit minimum 10 and maximum 20');
                    $('#fund_msgg').html('<p>Funds selection limit minimum 10 and maximum 20 for <b>Decile</b></p>');

                    $('#submit_btn').prop('disabled', true);
                }
            }
        } else {
            $('#submit_btn').prop('disabled', false);
        }
    }*/

    function max_min_fund(element) {
        var value = element.getAttribute('data-value');

        $('#quartile_set').val(value);

        var selectedOptions = $('#select_fund_multiple').val() || [];
        var selectedCategory = $('input[name="Category"]:checked').val();

        var min = 0;

        var message = '';
        if (value === 'quartile') {
            $('#select_fund_multiple').attr('data-min', 4);
            var min = 4;
            message = '<p>You need to select at least ' + min + ' and maximum 20 funds.</p>';

            $('.decile_table').hide();
            $('.quartile_table').show();
        } else if (value === 'decile') {
            $('#select_fund_multiple').attr('data-min', 10);
            var min = 10;
            message = '<p>You need to select at least ' + min + ' and maximum 20 funds.</p>';

            $('.quartile_table').hide();
            $('.decile_table').show();
        }

        $('#fund_msgg').html(message);

        // console.log(selectedCategory == 'by_fund');

        // console.log('selectedOptions====',selectedOptions);

        if (selectedCategory == 'by_fund') {
            if (selectedOptions.length >= min) {
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#submit_btn').prop('disabled', true);
            }
        } else {
            $('#submit_btn').prop('disabled', false);
        }
    }

    window.addEventListener('load', function() {
        document.getElementById('select_fund_multiple').setAttribute('data-min', 4);
        var value = document.getElementById('quartile_set').value;
    });
</script>
