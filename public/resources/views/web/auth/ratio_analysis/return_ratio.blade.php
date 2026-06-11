@extends('web.layout.infosolz_user_app')
@section('content')

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
                    {{-- <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a> --}}
                    <div class="perform_head">
                        <h2>Return Ratio</h2>
                    </div>

                    <div class="light_green_bg">
                        <form method="GET" action="">
                            <input type="hidden" name="quartile_set" id="quartile_set"
                                value="{{ isset($quartile_set) ? $quartile_set : 'quartile' }}">

                            <div class="row">
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

                                <div class="col-md-4">
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
                                <div class="col-md-4 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Classification">
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

                                <div class="col-md-4 div_hide_1">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'>
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
                            <table class="table datatable">
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


                                        $ranks = [];

                                        $rank = 1;
                                        

                                        foreach ($sortedFundReturns as $key => $value) {
                                            if($value == 'N/A' || $value =''){
                                            $ranks[$key] = 'N/A';
                                            }else{
                                            $ranks[$key] = $rank++;
                                            }
                                        }


                                    @endphp
                                    @endif


                                    @if (isset($sortedFundReturns) && count($sortedFundReturns) > 0)
                                    @foreach ($sortedFundReturns as $fundId => $value)
                                        <tr>
                                            <td class="text_left">
                                                {{ getNameTable('fund_master', 'fund_name', 'fund_id', $fundId) }}</td>
                                            <td class="text_right">{{ printValue($value) }}</td>
                                            <td class="text_right">{{ $ranks[$fundId] }}</td>
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
                        {!! printNoData() !!}
                    @endif
                </div>
            </div>
        </div>

    </div>



@endsection

<script>
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


    function index_enable(thiss){

        if(thiss == 'one_month_rolling_return'){

            $('#indexxes').hide();
            $('#index_id').val(1);

        }else{
            $('#indexxes').show();
            $('#index_id').val('');


        }

    }
</script>
