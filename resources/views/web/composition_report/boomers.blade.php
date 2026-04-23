@extends('web.layout.infosolz_user_app')

@section('content')
@php
    $data_type = $data_type ?? ((isset($request) && data_get($request, 'Category') === 'by_fund') ? 'fund' : 'category');
    $results_scrips = $results_scrips ?? collect();
    $results_industry = $results_industry ?? collect();
    $isByFundMode = isset($request) && data_get($request, 'Category') === 'by_fund';
    $boomersScripRows = collect($results_scrips)->filter(function ($scrp) use ($limit) {
        return (float) data_get($scrp, 'percentage_change', 0) > 0
            && (float) data_get($scrp, 'percentage_change', 0) >= (float) $limit;
    })->values();
    $boomersIndustryRows = collect($results_industry)->filter(function ($inds) use ($limit) {
        return (float) data_get($inds, 'percentage_change', 0) > 0
            && (float) data_get($inds, 'percentage_change', 0) >= (float) $limit;
    })->values();
@endphp

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                    <li><a href="{{route('user.composition_report')}}">composition report</a></li>
                    <li>Boomers</li>
                </ul>
            </div>
            <div class="new_page">
            <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                
                <div class="light_green_bg">
                    <form action=""> 
                            <div class="row">
                            
                                <div class="col-md-4">
                                    <div class="form_group radio_btn">
                                    <label>
                                        <input type="radio" id="type_Category" name="Category" value="by_category" @if(!$isByFundMode) checked @endif onclick='get_fund_types(this.value)'>
                                        By Category
                                    </label>
                                    <label>
                                        <input type="radio" id="fund_Category" name="Category" value="by_fund" @if($isByFundMode) checked @endif onclick='get_fund_types(this.value)'>
                                        By Fund
                                    </label>
                                    </div>
                                    
                            </div>

                            <div class="col-md-4">
                                <div class="form_group">
                                    <input type="text" name="limit" value="{{isset($limit)?$limit:''}}" placeholder="Limit">

                                    @error('limit')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 div_show_1" style="{{ $isByFundMode ? 'display:none;' : '' }}">
                                <div class="form_group">
                                    <select name="fund_type_id" id="fund_type_id" class="select2" data-placeholder="Select Fund Classification" @if(!$isByFundMode) required @endif>
                                        <option value=""></option>
                                        @foreach($all_fund_types as $fund_type)
                                            <option value="{{ $fund_type->ft_id }}" 
                                                @if($fund_type->ft_id == old('fund_type_id', $request->fund_type_id)) selected @endif>
                                                {{ $fund_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fund_type_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <span class="text-danger" id="category_msgg"></span>
                                
                                </div>

                                <div class="col-md-4 div_hide_1" style="{{ $isByFundMode ? '' : 'display:none;' }}">
                                    <div class="form_group">
                                        <select name="fund_id[]"  class="select2 multiple" multiple id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'>
                                            @foreach($all_funds as $fund)
                                                <option value="{{ $fund->fund_id }}" 
                                                    @if($fund->fund_id == old('fund_id', $request->fund_id)) selected
                                                    @elseif(isset($request->fund_id) && in_array($fund->fund_id,$request->fund_id))
                                                    selected
                                                    @endif>
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

                            <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>1st period</label>
                                    <div class="col-md-6">
                                    <div class="form_group">
                                        <select class="select2" name="month" id="month" required data-placeholder="Select Month">
                                            <option value="">select month</option>
                                           @foreach($months as $m)
                                           <option value="{{$m}}" {{isset($month)&& $month==$m?'selected':''}}>{{date('F', mktime(0, 0, 0, $m, 10))}}</option>
                                           @endforeach
                                        </select>

                                        @error('month')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form_group">
                                <select class="select2" name="year" id="year" required onchange="get_second_month_year(this.value)" data-placeholder="Select Year">
                                    <option value="">select year</option>
                                  @foreach($years as $y)
                                  <option value="{{$y}}"{{isset($year)&& $year==$y?'selected':''}}>{{$y}}</option>
                                  @endforeach
                                </select>

                                @error('year')
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
                                        <select class="select2" name="month_second" id="month_second" required onchange="get_second_period(this.value)" data-placeholder="Select Month">
                                            <option value="">select month</option>
                                           @foreach($months as $m)
                                           <option value="{{$m}}" {{isset($month_second)&& $month_second==$m?'selected':''}}>{{date('F', mktime(0, 0, 0, $m, 10))}}</option>
                                           @endforeach
                                        </select>

                                        @error('month_second')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form_group">
                                <select class="select2" name="year_second" id="year_second" required data-placeholder="Select Year">
                                    <option value="">select year</option>
                                  @foreach($years as $y)
                                  <option value="{{$y}}"{{isset($year_second)&& $year_second==$y?'selected':''}}>{{$y}}</option>
                                  @endforeach
                                </select>
                                @error('year_second')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                                    </div>
                                </div>
                            
                            
                            <div class="col-md-12">
                                <div class="bttn_grp">
                                    <button type="submit" id="submit_btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if(!empty($message))
                <div class="graph_table">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text_center">{{ $message }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @elseif(isset($month) && isset($month_second) && isset($year) && isset($year_second) && isset($limit))

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
                            <p>scrips Boomers :</p>
                            <span>For the month of {{isset($month)?date('F', mktime(0, 0, 0, $month, 10)):'N/A'}}, {{isset($year)?$year:'N/A'}} to {{isset($month_second)?date('F', mktime(0, 0, 0, $month_second, 10)):'N/A'}}, {{isset($year_second)?$year_second:'N/A'}}</span>
                        </li>
                        @endif

                        @if(isset($limit))
                        <li>
                            <p>limit :</p>
                            <span>{{isset($limit)?$limit:''}}</span>
                        </li>
                        @endif

                       

                        @if (isset($request) && $request->Category == 'by_category')
                        <li>
                            <p>fund classification :</p>
                            <span>{{isset($fund_type_get_data->name)?$fund_type_get_data->name:'N/A' }}</span>
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
                        <a href="javascript:void(0)" id="exportPDF-scrip" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                        
                    </div>
                    <table class="table datatable" id="pdfData-scrip">
                        <thead>
                            <tr>
                                <th class="text_left">Scrip Name</th>
                                <th class="text_center">Percentage change</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                         @if($boomersScripRows->isNotEmpty())
                        @foreach($boomersScripRows as $scrp)
                        <tr>
                            <td class="text_left">{{isset($scrp['scrip_name'])?$scrp['scrip_name']:''}}</td>
                            <td class="text_right">{{isset($scrp['percentage_change'])?number_format($scrp['percentage_change'], 2):'0'}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="2">No information available for this search</td>
                        </tr>
                        @endif
                            
                        </tbody>
                    </table>
                </div>
                    </div>
                    <div class="tab">
                    <div class="fund_section new_fund_section">
                        <ul>
                            @if(isset($month) && isset($month_second) && isset($year) && isset($year_second) )
                        <li>
                            <p>Industries Boomers :</p>
                            <span>For the month of {{isset($month)?date('F', mktime(0, 0, 0, $month, 10)):'N/A'}}, {{isset($year)?$year:'N/A'}} to {{isset($month_second)?date('F', mktime(0, 0, 0, $month_second, 10)):'N/A'}}, {{isset($year_second)?$year_second:'N/A'}}</span>
                        </li>
                        @endif

                        @if(isset($limit))
                        <li>
                            <p>limit :</p>
                            <span>{{isset($limit)?$limit:''}}</span>
                        </li>
                        @endif

                        @if (isset($request) && $request->Category == 'by_category')
                        <li>
                            <p>fund classification :</p>
                            <span>{{isset($fund_type_get_data->name)?$fund_type_get_data->name:'N/A' }}</span>
                        </li>
                    @endif

                        @if(isset($request) && $request->Category == 'by_fund')
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
                        <a href="javascript:void(0)" id="exportPDF-industry" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                        
                    </div>
                    <table class="table datatable" id="pdfData-industry">
                        <thead>
                            <tr>
                                <th class="text_left">Industry Name </th>
                                <th class="text_center">Percentage change</th>
                            </tr>
                        </thead>
                        <tbody>

                         @if($boomersIndustryRows->isNotEmpty())
                            @foreach($boomersIndustryRows as $scrp)
                            <tr>
                                <td class="text_left">{{isset($scrp['industry_name'])?$scrp['industry_name']:''}}</td>
                                <td class="text_right">{{isset($scrp['percentage_change'])?number_format($scrp['percentage_change'], 2):'0'}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No information available for this search</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                    </div>
                </div>

                @else
                {!! printNoData() !!}
                @endif

            </div>
            @if (isset($results_industry))
            <div class="disclaimer">
                <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
            </div>
       
                
        @endif
        </div>
    </div>
              
</div>

@endsection

<script>
    function get_classification(thiss){

if(thiss =='classification'){

   $('#fund_type_div').removeAttr('style');
   $('#fund_type').prop('required',true);


   $('#fund_master').prop('required',false);
   $('#fund_master').val('0');


   $('#fund_name_div').attr('style','display:none');

}else if(thiss == 'fund'){

   $('#fund_type_div').attr('style','display:none');
   $('#fund_type').prop('required',false);

   $('#fund_type').val('0');


   $('#fund_master').prop('required',true);

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



function set_fund_select_val() {
var thiss = $('input[name="Category"]:checked').val();

var count = $('#allocation_select_fund').select2('data').length;


 console.log(thiss+'  '+count);

    if (thiss == 'by_fund') {
   
        if (count >= 2 && count <= 10) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
            
        } else {
            $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 10 for <b>Funds</b></p>');
            $('#submit_btn').prop('disabled', true);
        }  

    
    } else {

        $('#submit_btn').prop('disabled', false);

    }

}

function validate_category_selection() {
    var selectedCategory = $('input[name="Category"]:checked').val() || 'by_category';
    var selectedFundType = $('#fund_type_id').val();

    if (selectedCategory === 'by_category') {
        if (selectedFundType) {
            $('#category_msgg').html('');
            $('#submit_btn').prop('disabled', false);
        } else {
            $('#category_msgg').html('<p>Select a <b>Fund Classification</b> to run this report.</p>');
            $('#submit_btn').prop('disabled', true);
        }
    }
}

function get_fund_types(thiss){
    $('.div_show_1').toggle(thiss === 'by_category');
    $('.div_hide_1').toggle(thiss === 'by_fund');
    $('#fund_type_id').prop('required', thiss === 'by_category');

    var count = $('#allocation_select_fund').select2('data').length;

    if(thiss == 'by_category'){
        $('#fund_msgg').html('');
        validate_category_selection();
    }else if(thiss == 'by_fund'){
        $('#category_msgg').html('');
        if (count >= 2 && count <= 10) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
        } else {
            $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 10 for <b>Funds</b></p>');
            $('#submit_btn').prop('disabled', true);
        }  

    }
}




document.addEventListener('DOMContentLoaded', function() {
    get_fund_types($('input[name="Category"]:checked').val() || 'by_category');
    $('#fund_type_id').on('change', validate_category_selection);
    var exportButton = document.getElementById('exportPDF-scrip');

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
            doc.text('Boomers Scrip', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";


            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Start replacing this section with new HTML-based data
            
            // Scrips Boomers (Month, Year)
            @if(isset($month) && isset($month_second) && isset($year) && isset($year_second))
                var scripsBoomersText = `Boomers: For the month of {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }}, {{ isset($year) ? $year : 'N/A' }} to {{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }}, {{ isset($year_second) ? $year_second : 'N/A' }}`;
                doc.text(scripsBoomersText, 15, 70);
            @endif

            var yPosition = 80; // Adjust the position to move after the first text

            // Limit
            @if(isset($limit))
                var limitText = `Limit: {{ isset($limit) ? $limit : '' }}`;
                doc.text(limitText, 15, yPosition);
                yPosition += 10;
            @endif

            // Fund Classification
            @if (isset($request) && $request->Category == 'by_category')
                var fundClassificationText = `Fund Classification: {{ isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A' }}`;
                doc.text(fundClassificationText, 15, yPosition);
                yPosition += 10;
            @endif

            // Fund Name
            @if (isset($request) && $request->Category == 'by_fund')
                // Split the fund names if too long to fit within 180 units (adjust width as necessary)
                var splitFundNames = doc.splitTextToSize(fundNames, 160);
                doc.text('Fund Name: ', startX, yPosition);
                yPosition += 10;
                doc.text(splitFundNames, startX, yPosition);  // This will handle multiple lines
                yPosition += splitFundNames.length * lineHeight; // Adjust yPosition based on the number of lines
            @endif

            // End of replacing section

            var table = new DataTable('#pdfData-scrip');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Scrip Name', 'Percentage change']],
                body: tableData,
                startX: 15,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Boomers-Scrip-' + currentDate + '.pdf';

            doc.save(fileName);
        };
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF-industry');

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
            doc.text('Boomers Industry', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);


            var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";


            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;


            // Start replacing this section with new HTML-based data
            
            // Scrips Boomers (Month, Year)
            @if(isset($month) && isset($month_second) && isset($year) && isset($year_second))
                var scripsBoomersText = `Boomers: For the month of {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }}, {{ isset($year) ? $year : 'N/A' }} to {{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }}, {{ isset($year_second) ? $year_second : 'N/A' }}`;
                doc.text(scripsBoomersText, 15, 70);
            @endif

            var yPosition = 80; // Adjust the position to move after the first text

            // Limit
            @if(isset($limit))
                var limitText = `Limit: {{ isset($limit) ? $limit : '' }}`;
                doc.text(limitText, 15, yPosition);
                yPosition += 10;
            @endif

            // Fund Classification
            @if (isset($request) && $request->Category == 'by_category')
                var fundClassificationText = `Fund Classification: {{ isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A' }}`;
                doc.text(fundClassificationText, 15, yPosition);
                yPosition += 10;
            @endif

            // Fund Name
            @if (isset($request) && $request->Category == 'by_fund')
                // Split the fund names if too long to fit within 180 units (adjust width as necessary)
                var splitFundNames = doc.splitTextToSize(fundNames, 160);
                doc.text('Fund Name: ', startX, yPosition);
                yPosition += 10;
                doc.text(splitFundNames, startX, yPosition);  // This will handle multiple lines
                yPosition += splitFundNames.length * lineHeight; // Adjust yPosition based on the number of lines
            @endif
            // End of replacing section

            var table = new DataTable('#pdfData-industry');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Industry Name', 'Percentage change']],
                body: tableData,
                startX: 15,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Boomers-Industry-' + currentDate + '.pdf';

            doc.save(fileName);
        };
    });
});

  

</script>
