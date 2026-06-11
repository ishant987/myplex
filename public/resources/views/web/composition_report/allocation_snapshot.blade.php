@extends('web.layout.infosolz_user_app')
@section('content')

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.composition_report') }}">composition report</a></li>
                        <li>Composition<br> Allocation Snapshot</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Composition Allocation Snapshot</h2>
                    </div>

                    {{-- <div class="light_green_bg">
                    <form action=""> 
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <select name="month" id="month">
                                       @foreach ($months as $m)
                                       <option value="{{$m}}">{{date('F', mktime(0, 0, 0, $m, 10))}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <select>
                                      @foreach ($years as $y)
                                      <option value="{{$y}}">{{$y}}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form_group">
                                    <select name="fund_master" id="fund_master" >
                                        <option>select any funds</option>
                                        @if (isset($fund_master))
                                            @foreach ($fund_master as $val)
                                            <option value="{{ $val->fund_id }}" {{isset($fund_master_ID) && (intval($fund_master_ID) == $val->fund_id)?'selected':''}}>
                                                {{ $val->fund_name }}
                                            </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form_group">
                                    <select>
                                        <option value="">Select Fund</option>
                                        <option value="">Bse 200</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="bttn_grp">
                                    <button type="submit" id="classification" disabled="">show by classification</button>
                                    <button type="submit" id="fund_type" disabled="">show by fund</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> --}}

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    {{-- <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="Category" checked value="by_category"
                                                @if (isset($request) && $request->Category == 'by_category') {{ 'Checked' }} @endif onclick='get_fund_types_js(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" name="Category" value="by_fund"
                                                @if (isset($request) && $request->Category == 'by_fund') {{ 'Checked' }} @endif onclick='get_fund_types_js(this.value)'>
                                            By Fund
                                        </label>
                                    </div> --}}
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
                                                2021</option>
                                            <option value="2023" {{ isset($year) && $year == 1 ? 'selected' : '' }}>2023
                                            </option>
                                        </select>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-4">
                                    <div class="form_group">
                                        <input type="number" placeholder="Top Record" name="limit"
                                            value="{{ isset($limit) ? $limit : '' }}">
                                    </div>
                                </div> --}}
                                <div class="col-md-6 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Category">
                                            <option value="">Select Fund Classification</option>
                                            @if (isset($fund_type))
                                                @foreach ($fund_type as $val)
                                                    <option value="{{ $val->ft_id }}"
                                                        {{ isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : '' }}>
                                                        {{ $val->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 div_hide_1">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" data-max="2"
                                            onchange ='set_fund_select_val(this.value)'>
                                            <option value="">Select Fund</option>
                                            @if (isset($fund_master))
                                                @foreach ($fund_master as $val)
                                                    <option value="{{ $val->fund_id }}"
                                                        @if (isset($fund_details) && is_array($fund_details) && in_array($val->fund_id, array_column($fund_details, 'fund_id'))) selected @endif>
                                                        {{ $val->fund_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
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
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        {{-- <button type="submit" id="classification" disabled="">show by
                                        classification</button>
                                    <button type="submit" id="fund_type" disabled="">show by fund</button> --}}

                                        {{-- <button type="submit" name="search" id="fund_type_btn"
                                        value="search">Search</button> --}}

                                        <button type="submit" id="submit_btn">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(isset($monthName) && isset($year) && isset( $request->Category))
                    <div class="fund_section new_fund_section">
                        <ul>
                            <li>
                                <p>Composition Allocation Snapshot :</p>
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
                   
                        <div class="graph_table allo_data">
                            <!-- <table class="table allo">
                                <thead>
                                    <tr>
                                        <th colspan=""></th>
                                        <th colspan="" class="text_center">Equity</th>
                                        <th colspan=""></th>
                                    </tr>
                                </thead>

                            </table> -->
                            <table class="table datatable">

                                <thead>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th colspan="4" class="text_center">Equity</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    <tr>
                                        <td class="text_left">Name of the Fund</td>
                                        <td class="text_center">Cash %</td>
                                        <td class="text_center">SOV %</td>
                                        <td class="text_center">Corp debt %</td>
                                        <td class="text_center">Small cap %</td>
                                        <td class="text_center">Mid cap %</td>
                                        <td class="text_center">Large cap %</td>
                                        <td class="text_center">Very large cap %</td>
                                        <td class="text_center">Others</td>
                                        <td class="text_center">Wt. PE</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    @if (isset($fund_snapshot))
                                    @foreach ($fund_snapshot as $item)
                                        <tr>
                                            <td class="text_left">{{ $item->fund_name }}</td>
                                            <td class="text_right">{{ $item->cash }}</td>
                                            <td class="text_right">{{ $item->sov }}</td>
                                            <td class="text_right">{{ $item->debt }}</td>
                                            <td class="text_right">{{ $item->eq_small }}</td>
                                            <td class="text_right">{{ $item->eq_mid }}</td>
                                            <td class="text_right">{{ $item->eq_large }}</td>
                                            <td class="text_right">{{ $item->eq_very_large }}</td>
                                            <td class="text_right">{{ $item->others_val }}</td>
                                            <td class="text_right">{{ $item->wt_pe }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9">No information available for this search</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
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
