@extends('web.layout.infosolz_user_app')

@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                        <li><a href="{{route('user.indices_report')}}">indices report</a></li>
                        <li>Boomers</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="perform_head">
                        <h2>Indices Boomers</h2>
                    </div>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select class="select2" name="indices[]" data-placeholder="Select Indices">
                                            <option value="">Select Indices</option>
                                            @foreach ($indices as $index)
                                                <option value="{{ $index->corelation }}"
                                                    @if (isset($indices_name) && in_array($index->corelation, $indices_name)) selected @endif>
                                                    {{ $index->name }}
                                                </option>
                                            @endforeach

                                            @error('indices')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form_group">
                                        <input type="number" name="limit" placeholder="Limit" value="{{isset($limit)?$limit:''}}">

                                        @error('limit')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>1st period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month" id="month" required data-placeholder="Select month">
                                                    <option value="">select month</option>
                                                    @foreach ($months as $m)
                                                        <option value="{{ $m }}"
                                                            {{ isset($month) && $month == $m ? 'selected' : '' }}>
                                                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                                                    @endforeach
                                                    @error('month')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="year" id="year" required onchange="get_second_month_year(this.value)" data-placeholder="Select Year">
                                                    <option value="">select year</option>
                                                    @foreach ($years as $y)
                                                        <option
                                                            value="{{ $y }}"{{ isset($year) && $year == $y ? 'selected' : '' }}>
                                                            {{ $y }}</option>
                                                    @endforeach
                                                    @error('year')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>2nd period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month_second" id="month_second" required
                                                    onchange="get_second_period(this.value)" data-placeholder="Select Month">
                                                    <option value="">select month</option>
                                                    @foreach ($months as $m)
                                                        <option value="{{ $m }}"
                                                            {{ isset($month_second) && $month_second == $m ? 'selected' : '' }}>
                                                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                                                    @endforeach
                                                    @error('month_second')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="year_second" id="year_second" required data-placeholder="Select Year">
                                                    <option value="">select year</option>
                                                    @foreach ($years as $y)
                                                        <option
                                                            value="{{ $y }}"{{ isset($year_second) && $year_second == $y ? 'selected' : '' }}>
                                                            {{ $y }}</option>
                                                    @endforeach
                                                    @error('year_second')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>

                @if(isset($month) && isset($month_second) && isset($year) && isset($year_second) && isset($limit))
                <div class="wm_tab">
                    <ul class="tabs">
                        <li>
                            <a class="active" href="javascript:void(0)">Scrip</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">Industry</a>
                        </li>
                    </ul>
                </div>

                <div class="tabsct">
                    <div class="tab">
                        <div class="fund_section new_fund_section">
                            <ul>
                                @if(isset($month) && isset($month_second) && isset($year) && isset($year_second) )
                                <li>
                                    <p>Scrips Boomers :</p>
                                    <span>For the month of
                                        {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }},
                                        {{ isset($year) ? $year : 'N/A' }} to
                                        {{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }},
                                        {{ isset($year_second) ? $year_second : 'N/A' }}</span>
                                </li>
                                @endif

                                @if(isset($limit))
                                <li>
                                    <p>Limit :</p>
                                    <span>{{ $limit ?? '' }}</span>
                                </li>
                                @endif

                                @if(isset($indices_records) && count($indices_records)>0)
                                <li>
                                    <p>Indices :</p>
                                    @foreach($indices_records as $val)
                                    <span>{{$val->name." , "}}</span>
                                    @endforeach
                                </li>
                                @endif
                              
                            </ul>
                        </div>

                        <div class="graph_table">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="text_left">name of the Scrip </th>
                                        <th class="text_center">Percentage change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($results_scrips))
                                        @foreach ($results_scrips as $item)

                                        @if($item->percentage_new !=0 && $item->percentage_old !=0)
                                        @php                                        

                                          $scrip_percentage = (((floatval($item->percentage_new)) - (floatval($item->percentage_old)))/(floatval($item->percentage_old)))*100;
                                        @endphp

                                           @if(($scrip_percentage >0) && ($scrip_percentage >= $limit)) 
                                            <tr>
                                                {{-- <td class="text_left open_scrip" correlation_new = {{ $item->correlation_new}}>{{$item->scrip_name}}</td>
                                                <td class="text_left open_scrip_percentage">{{number_format($scrip_percentage,2)}}</td> --}}

                                                <td class="text_left" correlation_new = {{ $item->correlation_new}}>{{$item->scrip_name}}</td>
                                                <td class="text_right">{{number_format($scrip_percentage,2)}}</td>
                                            </tr>                                            
                                            @endif
                                           @endif
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2">No information available for this search</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>



                        {{-- <div class="popup-overlay"></div>
                        <div class="scrip_popup cmn_tbl">
                            <div class="graph_table">
                                <h4>Name of the Scrip </h4>
                                <div class="table_overflow table_height">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>abc </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
                        </div> --}}


                        <!-- <div class="popup-overlay"></div> -->
                        {{-- <div class="scrip_percentage_popup cmn_tbl">
                            <div class="graph_table">
                                <h4>Percentage change </h4>
                                <div class="table_overflow table_height">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>abc </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
                        </div> --}}

                    </div>
                    <div class="tab">
                        <div class="fund_section new_fund_section">
                            <ul>
                                @if(isset($month) && isset($month_second) && isset($year) && isset($year_second) )
                                <li>
                                    <p>Industries Boomers :</p>
                                    <span>For the month of
                                        {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }},
                                        {{ isset($year) ? $year : 'N/A' }} to
                                        {{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }},
                                        {{ isset($year_second) ? $year_second : 'N/A' }}</span>
                                </li>
                                @endif

                                @if(isset($limit))
                                <li>
                                    <p>Limit :</p>
                                    <span>{{ $limit ?? '' }}</span>
                                </li>
                                @endif

                                @if(isset($indices_records) && count($indices_records)>0)
                                <li>
                                    <p>Indices :</p>
                                    @foreach($indices_records as $val)
                                    <span>{{$val->name." , "}}</span>
                                    @endforeach
                                </li>
                                @endif
                              
                            </ul>
                        </div>

                        <div class="graph_table">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th class="text_left">name of the Industry </th>
                                        <th class="text_center">Percentage change</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($results_industry))
                                        @foreach ($results_industry as $item)
                                        @if($item->percentage_new !=0 && $item->percentage_old !=0)
                                        @php
                                        $industry_percentage = (((floatval($item->percentage_new)) - (floatval($item->percentage_old)))/(floatval($item->percentage_old)))*100;
                                      @endphp

                                        @if(($industry_percentage > 0) && ($industry_percentage >= $limit))

                                            {{-- <tr>
                                                <td class="text_left open_industry" correlation_new = {{ $item->correlation_new}}>{{$item->industry}}</td>
                                                <td class="text_left open_industry_percentage">{{number_format($industry_percentage,2)}}</td>
                                            </tr> --}}

                                            <tr>
                                                <td class="text_left" correlation_new = {{ $item->correlation_new}}>{{$item->industry}}</td>
                                                <td class="text_right">{{number_format($industry_percentage,2)}}</td>
                                            </tr>
                                       
                                        @endif
                                        @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No information available for this search</td>
                                        </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="popup-overlay"></div>
                        <div class="industry_popup cmn_tbl">
                            <div class="graph_table">
                                <h4>Name of the Industry </h4>
                                <div class="table_overflow table_height">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>abc </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
                        </div> --}}


                        <!-- <div class="popup-overlay"></div> -->
                        {{-- <div class="industry_percentage_popup cmn_tbl">
                            <div class="graph_table">
                                <h4>Percentage change </h4>
                                <div class="table_overflow table_height">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>abc </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                            <tr>
                                                <td>xyz</td>
                                                <td class="text_right">000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button class="close_popup"><i class="fa-solid fa-xmark"></i></button>
                        </div> --}}
                    </div>
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
    function get_classification(thiss) {

        if (thiss == 'classification') {

            $('#fund_type_div').removeAttr('style');
            $('#fund_type').prop('required', true);


            $('#fund_master').prop('required', false);
            $('#fund_master').val('0');


            $('#fund_name_div').attr('style', 'display:none');

        } else if (thiss == 'fund') {

            $('#fund_type_div').attr('style', 'display:none');
            $('#fund_type').prop('required', false);

            $('#fund_type').val('0');


            $('#fund_master').prop('required', true);

            $('#fund_name_div').removeAttr('style');


        }


    }


    function get_second_month_year(thiss){

var first_year = thiss;

var first_month = parseInt($('#month').val());

var currentDate = new Date();

// Get the current year
var currentYear = currentDate.getFullYear();

// Get the current month number (0-11, where 0 is January and 11 is December)
var currentMonth = currentDate.getMonth() + 1; //

var month_opt = '';
var year_opt ='';

if((first_year == currentYear) && (first_month == currentMonth)){     //for 2nd month//

    

        month_opt += '<option value="">Please select proper first period month</option>';

        year_opt += '<option value="">Please select proper first period year</option>';



    } else if((first_year < currentYear) && (first_month < currentMonth)){

    for(var i =currentYear ; i >= first_year; i--) {
        
        year_opt += '<option value="' + i + '">' + i + '</option>';
    }


    for(var m = 1; m<=12; m++){

        month_opt += '<option value="' + m + '">' + getMonthName(m) + '</option>';

        }




}else if((first_year == currentYear) && (first_month < currentMonth)){

    
        
        year_opt += '<option value="' + first_year + '">' + first_year + '</option>';
    


    for(var m = (first_month+1); m<= currentMonth; m++){

        month_opt += '<option value="' + m + '">' + getMonthName(m) + '</option>';

        }


}

$('#month_second').html(month_opt);

$('#year_second').html(year_opt);




}



function get_second_period(second_month) {

var first_month = parseInt($('#month').val());
var first_year = parseInt($('#year').val());

 var currentDate = new Date();

// Get the current year
var currentYear = currentDate.getFullYear();

// Get the current month number (0-11, where 0 is January and 11 is December)
var currentMonth = currentDate.getMonth() + 1; //

var options = '';

if(second_month > first_month) {
    for(var i = currentYear; i >= (first_year); i--) {
        
        options += '<option value="' + i + '">' + i + '</option>';
    }

}

else{

    for(var i =currentYear ; i >= (first_year+1); i--) {
        options += '<option value="' + i + '">' + i + '</option>';
    }

}

$('#year_second').html(options);

}

function getMonthName(monthNumber) {

var monthNames = [
"January", "February", "March", "April", "May", "June",
"July", "August", "September", "October", "November", "December"
];
// Subtract 1 from monthNumber to get the correct index (0-11)
return monthNames[monthNumber - 1];
}
</script>
