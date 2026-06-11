@extends('web.layout.infosolz_user_app')
@section('content')
    {{-- @dd($top_scrips); --}}
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.composition_report') }}">composition report</a></li>
                        <li>Top Scrips<br> Top Industries</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Top Scrips Top Industries</h2>
                    </div>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category" checked
                                                value="by_category"
                                                @if (isset($request) && $request->Category == 'by_category') {{ 'Checked' }} @endif
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
                                {{-- <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="month">
                                            <option value="1" {{ isset($month) && $month == 1 ? 'selected' : '' }}>
                                                January</option>
                                            <option value="2" {{ isset($month) && $month == 2 ? 'selected' : '' }}>
                                                February</option>
                                            <option value="3" {{ isset($month) && $month == 3 ? 'selected' : '' }}>
                                                March</option>
                                            <option value="4" {{ isset($month) && $month == 4 ? 'selected' : '' }}>
                                                April</option>
                                            <option value="5" {{ isset($month) && $month == 5 ? 'selected' : '' }}>May
                                            </option>
                                            <option value="6" {{ isset($month) && $month == 6 ? 'selected' : '' }}>June
                                            </option>
                                            <option value="7" {{ isset($month) && $month == 7 ? 'selected' : '' }}>July
                                            </option>
                                            <option value="8" {{ isset($month) && $month == 8 ? 'selected' : '' }}>
                                                August</option>
                                            <option value="9" {{ isset($month) && $month == 9 ? 'selected' : '' }}>
                                                September</option>
                                            <option value="10" {{ isset($month) && $month == 10 ? 'selected' : '' }}>
                                                October</option>
                                            <option value="11" {{ isset($month) && $month == 11 ? 'selected' : '' }}>
                                                November</option>
                                            <option value="12" {{ isset($month) && $month == 12 ? 'selected' : '' }}>
                                                December</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select name="year">
                                            <option value="2018" {{ isset($year) && $year == 2018 ? 'selected' : '' }}>
                                                2018</option>
                                            <option value="2019" {{ isset($year) && $year == 2019 ? 'selected' : '' }}>
                                                2019</option>
                                            <option value="2020" {{ isset($year) && $year == 2020 ? 'selected' : '' }}>
                                                2020</option>
                                            <option value="2021" {{ isset($year) && $year == 2021 ? 'selected' : '' }}>
                                                2021</option>
                                            <option value="2022" {{ isset($year) && $year == 2022 ? 'selected' : '' }}>
                                                2022</option>
                                            <option value="2023" {{ isset($year) && $year == 2023 ? 'selected' : '' }}>
                                                2023
                                            </option>
                                        </select>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <div class="form_group">
                                        <input type="number" placeholder="Top Record" name="limit"
                                            value="{{ isset($limit) ? $limit : '' }}">
                                    </div>
                                </div> --}}
                                <div class="col-md-6 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Classification">
                                            <option value="">Select Fund Classification</option>
                                            @if (isset($fund_type))
                                                @foreach ($fund_type as $val)
                                                    <option value="{{ $val->ft_id }}"
                                                        {{ isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : '' }}>
                                                        {{ $val->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('fund_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 div_hide_1">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'
                                            data-placeholder="Select Fund">
                                            <option value="">Select Fund</option>
                                            @if (isset($fund_master))
                                                @foreach ($fund_master as $val)
                                                    <option value="{{ $val->fund_id }}"
                                                        @if (isset($fund_details) && is_array($fund_details) && in_array($val->fund_code, $fund_details)) selected @endif>
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



                                @include('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $year ?? '',
                                    'selectedMonth' => $month ?? '',
                                    'size' => 6,
                                ])


                                <div class="col-md-6">
                                    <div class="form_group">
                                        <label for="limit">Show:</label>
                                        <select name="limit" id="limit" class="select2">
                                            <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        {{-- <button type="submit" id="classification" disabled="">show by
                                            classification</button>
                                        <button type="submit" id="fund_type" disabled="">show by fund</button> --}}
                                        @isset($top_scrips)
                                            <p>Showing top {{ count($top_scrips) }} results</p>
                                        @endisset

                                        <button type="submit" name="search" id="submit_btn" value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <input type="hidden" name="fund_codes" id="fund_codes" value="{{ isset($fund_details) ? json_encode($fund_details) : ''}}">
                    <input type="hidden" name="lastDate" id="lastDate" value="{{ isset($lastDate) ? $lastDate : ''}}">
                    @if (isset($top_scrips) && isset($top_industries))
                        <div class="wm_tab">
                            <ul class="tabs">
                                <li>
                                    <a class="active" onclick="switchTab('quartile')">Top Scrip</a>
                                    {{-- <a class="active" href="#">Top Scrips</a> --}}
                                </li>
                                <li>
                                    <a onclick="switchTab('decile')">Top Industry</a>
                                    {{-- <a href="#">Top Industries</a> --}}
                                </li>
                            </ul>
                        </div>


                        <div class="tabsct">
                            <div class="tab">
                                <div class="quartile_tab">
                                    <div class="fund_section new_fund_section">
                                        <ul>
                                            <li>
                                                <p>Top scrips :</p>
                                                @if (isset($monthName) && isset($year))
                                                    <span>For the month of {{ $monthName }},{{ $year }}</span>
                                                @endif
                                            </li>
                                            {{-- <li>
                                            <p>top record :</p>
                                            @if (isset($limit))
                                                <span>{{ $limit }}</span>
                                            @endif
                                        </li> --}}
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
                                        <table class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th>name of the scrips</th>
                                                    <th>industry</th>
                                                    <th class="text_center">content %</th>
                                                    <th class="text_center">Ammount (in Cr.)</th>
                                                </tr>
                                            </thead>
                                            @if (isset($top_scrips))
                                                <tbody>
                                                    @foreach ($top_scrips as $scrips)
                                                        <tr>
                                                            <td>{{ $scrips->scrip_name }}</td>
                                                            <td>{{ $scrips->industry }}</td>
                                                            <td class="text_right open-popup-scrip-industry" data-category="content_per" data-using="scrip" data-parameter="{{$scrips->scrip_name}}">
                                                                {{ number_format($scrips->content_per, 2) }}
                                                            </td>
                                                            <td class="text_right open-popup-scrip-industry" data-using="scrip" data-category="amount" data-parameter="{{$scrips->scrip_name}}">
                                                                {{ number_format($scrips->amount, 2) ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="decile">
                                    <div class="fund_section new_fund_section">
                                        <ul>
                                            <li>
                                                <p>Top industries :</p>
                                                @if (isset($monthName) && isset($year))
                                                    <span>For the month of {{ $monthName }},{{ $year }}</span>
                                                @endif
                                            </li>

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
                                        <table class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th class="text_left">name of the Industries</th>
                                                    <th class="text_center">category</th>
                                                    <th class="text_center">content %</th>
                                                    <th class="text_center">Ammount (in Cr.)</th>
                                                </tr>
                                            </thead>
                                            @if (isset($top_industries))
                                                <tbody>
                                                    @foreach ($top_industries as $industry)
                                                        <tr>
                                                            <td class="text_left">{{ $industry->industry }}</td>
                                                            <td class="text_left">{{ $industry->category }}</td>
                                                            <td class="text_left open-popup-scrip-industry" data-using="industry" data-category="content_per" data-parameter="{{$industry->industry}}">
                                                                {{ number_format($industry->content_per, 2) }}
                                                            </td>
                                                            <td class="text_left open-popup-scrip-industry" data-using="industry" data-category="amount" data-parameter="{{$industry->industry}}">
                                                                {{ number_format($industry->amount, 2) ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
            </div>

            <div class="popup-overlay"></div>
            <div class="table_popup">
                <div class="graph_table">
                    <h4>Fund Changes</h4>
                    <div class="table_overflow table_height">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Fund Name </th>
                                    <th>% Change </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
@endsection

<script>
    function set_fund_select_val() {

        var thiss = $('#fund_Category').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log(thiss + '  ' + count);

        if (thiss == 'by_fund') {

            if (count >= 2 && count <= 20) {
                // console.log('enable');
                $('#submit_btn').prop('disabled', false);
            } else {
                // console.log('disabled');
                // alert('Funds selection limit minimum 4 and maximum 20');
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }


        } else {
            $('#submit_btn').prop('disabled', false);
        }
    }

    function get_fund_types(thiss) {

        var count = $('#allocation_select_fund').select2('data').length;

        if (thiss == 'by_category') {

            $('#submit_btn').prop('disabled', false);
        } else if (thiss == 'by_fund') {

            if (count >= 2 && count <= 20) {
                // console.log('enable');
                $('#submit_btn').prop('disabled', false);
            } else {
                // console.log('disabled');
                // alert('Funds selection limit minimum 4 and maximum 20');
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }

        }
    }
</script>
