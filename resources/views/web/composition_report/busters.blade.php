@extends('web.layout.infosolz_user_app')

@section('content')

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                    <li><a href="{{route('user.composition_report')}}">composition report</a></li>
                    <li>Busters</li>
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
                                        <input type="radio" id="type_Category" name="Category" checked value="by_category"  @if(isset($request) && $request->Category=="by_category"){{ 'Checked' }}@endif onclick='get_fund_types(this.value)'>
                                        By Category
                                    </label>
                                    <label>
                                        <input type="radio" id="fund_Category" name="Category" value="by_fund" @if(isset($request) && $request->Category=="by_fund"){{ 'Checked' }}@endif onclick='get_fund_types(this.value)'>
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
                            <div class="col-md-4 div_show_1" style="{{ isset($request) && $request->Category == 'by_fund' ? 'display:none;' : '' }}">
                                <div class="form_group">
                                    <select name="fund_type_id" class="select2" data-placeholder="Select Fund Classification">
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
                                
                                </div>

                                <div class="col-md-4 div_hide_1" style="{{ isset($request) && $request->Category == 'by_fund' ? '' : 'display:none;' }}">
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
                    <table class="table datatable"  id="pdfData-scrip">
                        <thead>
                            <tr>
                                <th class="text_left">Scrip Name</th>
                                <th class="text_center">Percentage change</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($data_type == 'category')

                            @if(isset($results_scrips) && count($results_scrips)>0)
                            @foreach($results_scrips as $scrp)
                            @php
                               $scrip_percentage = (((floatval($scrp['end_date_growth'])) - (floatval($scrp['start_date_growth'])))/(floatval($scrp['start_date_growth'])))*100;
                            @endphp
                                @if(($scrip_percentage < 0 ) && ($scrip_percentage <=(-$limit)))  
                            <tr>
                                <td class="text_left">{{isset($scrp['scrip_name'])?$scrp['scrip_name']:''}}</td>
                                <td class="text_right">{{isset($scrip_percentage)?number_format($scrip_percentage, 2):'0'}}</td>
                            </tr>
                            @endif
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No information available for this search</td>
                            </tr>
                            @endif

                            @elseif($data_type == 'fund')

                            @if(isset($results_scrips) && count($results_scrips)>0)
                            @foreach($results_scrips as $scrp)
                            
                           
                            @if(($scrp['percentage_change'] < 0) && ($scrp['percentage_change'] <=(-$limit)))
                            <tr>
                                <td class="text_left">{{isset($scrp['scrip_name'])?$scrp['scrip_name']:''}}</td>
                                <td class="text_right">{{isset($scrp['percentage_change'])?number_format($scrp['percentage_change'], 2):'0'}}</td>
                            </tr>
                            @endif
                        
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No information available for this search</td>
                            </tr>
                            @endif
    
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

                    <table class="table datatable"  id="pdfData-industry">
                        <thead>
                            <tr>
                                <th class="text_left">Industry Name </th>
                                <th class="text_center">Percentage change</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($data_type =='category')
                            @if(isset($results_industry) && count($results_industry)>0)
                            @foreach($results_industry as $inds)
                            @php
                             $percentage = (((floatval($inds['end_date_growth'])) - (floatval($inds['start_date_growth'])))/(floatval($inds['start_date_growth'])))*100;
                            @endphp

                                @if(($percentage < 0 ) && ($percentage <=(-$limit)))    

                            <tr>
                                <td class="text_left">{{isset($inds['industry'])?$inds['industry']:''}}</td>
                                <td class="text_left">{{isset($percentage)? number_format($percentage, 2):'N/A'}}</td>
                            </tr>
                            @endif
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No information available for this search</td>
                            </tr>
                            @endif

                            @elseif($data_type == 'fund')

                            @if(isset($results_industry) && count($results_industry)>0)
                            @foreach($results_industry as $scrp)
                            
                           
                            @if(($scrp['percentage_change'] < 0) && ($scrp['percentage_change'] <=(-$limit)))
                            <tr>
                                <td class="text_left">{{isset($scrp['industry_name'])?$scrp['industry_name']:''}}</td>
                                <td class="text_right">{{isset($scrp['percentage_change'])?number_format($scrp['percentage_change'], 2):'0'}}</td>
                            </tr>
                            @endif
                        
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No information available for this search</td>
                            </tr>
                            @endif
    
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

var thiss = $('#fund_Category').val();

var count = $('#allocation_select_fund').select2('data').length;


 console.log(thiss+'  '+count);

    if (thiss == 'by_fund') {
   
        if (count >= 2 && count <= 10) {
            // console.log('enable');
            $('#submit_btn').prop('disabled', false);
            
        } else {
            // console.log('disabled');
            // alert('Funds selection limit minimum 4 and maximum 20');
            $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 10 for <b>Funds</b></p>');
            $('#submit_btn').prop('disabled', true);
        }  

    
    } else {

        $('#submit_btn').prop('disabled', false);

    }

}


function get_fund_types(thiss){
    $('.div_show_1').toggle(thiss === 'by_category');
    $('.div_hide_1').toggle(thiss === 'by_fund');

    var count = $('#allocation_select_fund').select2('data').length;

    if(thiss == 'by_category'){
        $('#fund_msgg').html('');
        $('#submit_btn').prop('disabled', false);
    }else if(thiss == 'by_fund'){
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
    var exportButton = document.getElementById('exportPDF-scrip');

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
            doc.text('Busters Scrip', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Scrips Boomers (Month, Year)
            @if(isset($month) && isset($month_second) && isset($year) && isset($year_second))
                var scripsBoomersText = `Boomers: For the month of {{ date('F', mktime(0, 0, 0, $month, 10)) }}, {{ $year }} to {{ date('F', mktime(0, 0, 0, $month_second, 10)) }}, {{ $year_second }}`;
                doc.text(scripsBoomersText, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Limit
            @if(isset($limit))
                var limitText = `Limit: {{ $limit }}`;
                doc.text(limitText, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Fund Classification
            @if (isset($request) && $request->Category == 'by_category')
                var fundClassificationText = `Fund Classification: {{ isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A' }}`;
                doc.text(fundClassificationText, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Fund Name
            @if (isset($request) && $request->Category == 'by_fund')
                var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";
                var splitFundNames = doc.splitTextToSize(fundNames, 160); // Split long names to fit within width
                doc.text('Fund Name:', startX, yPosition);
                yPosition += lineHeight;
                doc.text(splitFundNames, startX, yPosition);
                yPosition += splitFundNames.length * lineHeight; // Adjust for the number of lines
            @endif

            // Generate the table with the scrip data
            var table = new DataTable('#pdfData-scrip');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Scrip Name', 'Percentage change']],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Busters-Scrip-' + currentDate.toISOString().slice(0, 10) + '.pdf';

            doc.save(fileName);
        };
    });
});






document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF-industry');

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
            doc.text('Busters Industry', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Scrips Boomers (Month, Year)
            @if(isset($month) && isset($month_second) && isset($year) && isset($year_second))
                var scripsBoomersText = `Boomers: For the month of {{ date('F', mktime(0, 0, 0, $month, 10)) }}, {{ $year }} to {{ date('F', mktime(0, 0, 0, $month_second, 10)) }}, {{ $year_second }}`;
                doc.text(scripsBoomersText, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Limit
            @if(isset($limit))
                var limitText = `Limit: {{ $limit }}`;
                doc.text(limitText, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Fund Classification
            @if (isset($request) && $request->Category == 'by_category')
                var fundClassificationText = `Fund Classification: {{ isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A' }}`;
                doc.text(fundClassificationText, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Fund Name
            @if (isset($request) && $request->Category == 'by_fund')
                var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";
                var splitFundNames = doc.splitTextToSize(fundNames, 160); // Split long names to fit within width
                doc.text('Fund Name:', startX, yPosition);
                yPosition += lineHeight;
                doc.text(splitFundNames, startX, yPosition);
                yPosition += splitFundNames.length * lineHeight; // Adjust for the number of lines
            @endif

            // Generate the table with the scrip data
            var table = new DataTable('#pdfData-industry');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Industry Name', 'Percentage change']],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Busters-Industry-' + currentDate.toISOString().slice(0, 10) + '.pdf';

            doc.save(fileName);
        };
    });
});



  

</script>
