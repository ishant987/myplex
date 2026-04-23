@extends('web.layout.infosolz_user_app')
@section('content')
    @php
        $scrips = $scrips ?? collect();
        $industry = $industry ?? collect();
        $isByFundMode = isset($request) && data_get($request, 'Category') === 'by_fund';
    @endphp

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.composition_report') }}">composition report</a></li>
                        <li>New Scrips<br> New Industries</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" id="type_Category" name="Category"
                                                value="by_category"
                                                @if (!$isByFundMode) checked @endif
                                                onclick='get_fund_types(this.value)'>
                                            By Category
                                        </label>
                                        <label>
                                            <input type="radio" id="fund_Category" name="Category" value="by_fund"
                                                @if ($isByFundMode) checked @endif
                                                onclick='get_fund_types(this.value)'>
                                            By Fund
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="active_tab" value="{{ $active_tab ?? '' }}" id="active-tab-input">
                                {{-- <div class="col-md-5">
                                    <div class="form_group radio_btn">
                                        <label>
                                            <input type="radio" name="classification" id="range"
                                                value="classification" onclick="get_classification(this.value)"
                                                {{ isset($classification) && $classification == 'classification' ? 'checked' : 'checked' }}>
                                            By category
                                        </label>
                                        <label>
                                            <input type="radio" name="classification" id="as_on" value="fund"
                                                onclick="get_classification(this.value)"
                                                {{ isset($classification) && $classification == 'fund' ? 'checked' : '' }}>
                                            By fund
                                        </label>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-6" id="fund_type_div"
                                    @if (isset($classification) && $classification == 'fund') style='display:none' @endif>
                                    <div class="form_group">
                                        <select class="select2" name="fund_type" id="fund_type" required>
                                            <option value="">Select Fund Classification</option>
                                            @if (isset($fund_type))
                                                @foreach ($fund_type as $val)
                                                    <option value="{{ $val->ft_id }}"
                                                        {{ isset($get_fund_type) && $get_fund_type == $val->ft_id ? 'selected' : '' }}>
                                                        {{ $val->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7"
                                    @if (isset($classification) && $classification == 'classification') style='display:none'
                                
                                @elseif(isset($classification) && $classification == 'fund')
    
                                style=""
                                
                                @else style="display: none" @endif
                                    id="fund_name_div">
                                    <div class="form_group">
                                        <select class="select2" name="fund_master" id="fund_master">
                                            <option>select any funds</option>
                                            @if (isset($fund_master))
                                                @foreach ($fund_master as $val)
                                                    <option value="{{ $val->fund_code }}"
                                                        {{ isset($get_fund_master) && $get_fund_master == $val->fund_code ? 'selected' : '' }}>
                                                        {{ $val->fund_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-md-6 div_show_1" style="{{ $isByFundMode ? 'display:none;' : '' }}">
                                    <div class="form_group">
                                        <select name="fund_type_id" id="fund_type_id" class="select2"
                                            data-placeholder="Select Fund Classification" @if(!$isByFundMode) required @endif>
                                            <option value=""></option>
                                            @if (isset($all_fund_types))
                                                @foreach ($all_fund_types as $fund_type)
                                                    <option value="{{ $fund_type->ft_id }}"
                                                        @if ($fund_type->ft_id == old('fund_type_id', $request->fund_type_id ?? $fund_type_id ?? '')) selected @endif>
                                                        {{ $fund_type->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('fund_type_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <span class="text-danger" id="category_msgg"></span>
                                </div>

                                <div class="col-md-6 div_hide_1" style="{{ $isByFundMode ? '' : 'display:none;' }}">
                                    <div class="form_group multiple_select">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange ='set_fund_select_val(this.value)'>
                                            @if (isset($all_funds))
                                                @foreach ($all_funds as $fund)
                                                    <option value="{{ $fund->fund_id }}"
                                                        @if ($fund->fund_id == old('fund_id', $request->fund_id)) selected
                                            @elseif(isset($fund_id) && in_array($fund->fund_id, $fund_id))
                                            selected @endif>
                                                        {{ $fund->fund_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('fund_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <span class="text-danger" id="fund_msgg"></span>
                                </div>

                                <div class="col-md-6">
                                    <div class="row date_sec">
                                        <label>1st period</label>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <select class="select2" name="month" id="month" required>
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
                                                <select class="select2" name="year" id="year" required
                                                    onchange="get_second_month_year(this.value)">
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
                                                    onchange="get_second_period(this.value)">
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
                                                <select class="select2" name="year_second" id="year_second" required>
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
                                        <button type="submit" name="search" id="submit_btn"
                                            value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <input type="hidden" name="fund_codes" id="fund_codes"
                        value="{{ isset($fundCodes) ? json_encode($fundCodes) : '' }}">
                    <input type="hidden" name="lastDate" id="lastDate" value="{{ isset($lastDate) ? $lastDate : '' }}">

                    @if (!empty($message))
                        <div class="graph_table">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text_center">{{ $message }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @elseif (isset($month) && isset($year) && isset($month_second) && isset($year_second) && $request->Category != '')

                        <div class="wm_tab">
                            <ul class="tabs">
                                <li>
                                    <a onclick="switchTab('scrip')" class="active" href="javascript:void(0)">Scrips</a>
                                </li>
                                <li>
                                    <a onclick="switchTab('indus')" href="javascript:void(0)">Industries</a>
                                </li>
                            </ul>
                        </div>


                        <div class="tabsct">
                            <div class="tab" style="{{ (isset($active_tab) && $active_tab == 'scrip') || is_null($active_tab) ? 'display:block' : 'display:none' }}">
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <li>
                                            <p>Top scrips :</p>
                                            <span>From the month of
                                                {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }},
                                                {{ isset($year) ? $year : 'N/A' }} to
                                                {{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }},
                                                {{ isset($year_second) ? $year_second : 'N/A' }}</span>
                                        </li>

                                        @if (isset($request) && $request->Category == 'by_category')
                                            <li>
                                                <p>fund classification :</p>
                                                <span>{{ isset($fund_type_name) ? $fund_type_name : '' }}</span>
                                            </li>
                                        @endif

                                        @if (isset($fund_id) && $request->Category == 'by_fund')
                                            <li>
                                                <p>fund name :</p>
                                                @foreach ($fund_id as $id)
                                                    <span>{{ getNameTable('fund_master', 'fund_name', 'fund_id', $id) }},
                                                    </span>
                                                @endforeach
                                            </li>
                                        @endif

                                    </ul>
                                </div>

                                <div class="graph_table">
                                    <div class="share_pdf">
                                
                                        <div class="sharethis-inline-share-buttons" ></div>
                                        <a href="javascript:void(0)" id="exportPDF-scrips" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                        
                                    </div>
                                    <table class="table datatable" id="pdfData-scrips">
                                        <thead>
                                            <tr>
                                                <th>name of the scrips</th>
                                                <th class="text_center">content %</th>
                                                <th class="text_center">Amount (in Cr.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($scrips->count() > 0)
                                                @foreach ($scrips as $sc)
                                                    @if (number_format($sc->content_per, 2) > 0)
                                                        <tr>
                                                            <td>{{ isset($sc->scrip_name) ? $sc->scrip_name : 'N/A' }}</td>
                                                            <td class="text_right open-popup-scrip-industry"
                                                                data-category="content_per" data-using="scrip"
                                                                data-parameter="{{ $sc->scrip_name }}">
                                                                {{ isset($sc->content_per) ? number_format($sc->content_per, 2) : '0' }}
                                                            </td>
                                                            <td class="text_right open-popup-scrip-industry"
                                                                data-using="scrip" data-category="amount"
                                                                data-parameter="{{ $sc->scrip_name }}">
                                                                {{ printValue($sc->amount) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">No information available for this search</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab"  style="{{isset($active_tab) && $active_tab == 'indus' ? 'display:block' : 'display:none'}}">
                                <div class="fund_section new_fund_section">
                                    <ul>
                                        <li>
                                            <p>Top Industries :</p>
                                            <span>From the month of
                                                {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }},
                                                {{ isset($year) ? $year : 'N/A' }} to
                                                {{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }},
                                                {{ isset($year_second) ? $year_second : 'N/A' }}</span>
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
                                    <div class="share_pdf">
                                
                                        <div class="sharethis-inline-share-buttons" ></div>
                                        <a href="javascript:void(0)" id="exportPDF-industries" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                        
                                    </div>
                                    <table class="table datatable" id="pdfData-industries">
                                        <thead>
                                            <tr>
                                                <th class="text_left">name of the Industries</th>
                                                <th class="text_center">content %</th>
                                                <th class="text_center">Amount (in Cr.)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($industry->count() > 0)
                                                @foreach ($industry as $inds)
                                                    @if (number_format($inds->content_per, 2) > 0)
                                                        <tr>
                                                            <td class="text_left">
                                                                {{ isset($inds->industry) ? $inds->industry : 'N/A' }}</td>
                                                            <td class="text_left open-popup-scrip-industry"
                                                                data-using="industry" data-category="content_per"
                                                                data-parameter="{{ $inds->industry }}">
                                                                {{ isset($inds->content_per) ? number_format($inds->content_per, 2) : '0' }}
                                                            </td>
                                                            <td class="text_left open-popup-scrip-industry"
                                                                data-using="industry" data-category="amount"
                                                                data-parameter="{{ $inds->industry }}">
                                                                {{ isset($inds->amount) ? number_format($inds->amount,2) : '0' }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">No information available for this search</td>
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
                @if (isset($industry))
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                    </div>
                @endif
            </div>
            <div class="popup-overlay"></div>
            
        </div>

    </div>



@endsection

<script>
    function set_fund_select_val() {
        var thiss = $('input[name="Category"]:checked').val();
        var count = $('#allocation_select_fund').select2('data').length;

        console.log(thiss + '  ' + count);

        if (thiss == 'by_fund') {

            if (count >= 2 && count <= 20) {
                $('#fund_msgg').html('');
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
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


    function get_fund_types(thiss) {
        $('.div_show_1').toggle(thiss === 'by_category');
        $('.div_hide_1').toggle(thiss === 'by_fund');
        $('#fund_type_id').prop('required', thiss === 'by_category');

        var count = $('#allocation_select_fund').select2('data').length;

        if (thiss == 'by_category') {
            $('#fund_msgg').html('');
            validate_category_selection();
        } else if (thiss == 'by_fund') {
            $('#category_msgg').html('');

            if (count >= 2 && count <= 20) {
                $('#fund_msgg').html('');
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }

        }
    }


    function get_second_month_year(thiss) {

        var first_year = thiss;

        var first_month = parseInt($('#month').val());

        var currentDate = new Date();

        // Get the current year
        var currentYear = currentDate.getFullYear();

        // Get the current month number (0-11, where 0 is January and 11 is December)
        var currentMonth = currentDate.getMonth() + 1; //

        var month_opt = '';
        var year_opt = '';

        if ((first_year == currentYear) && (first_month == currentMonth)) { //for 2nd month//



            month_opt += '<option value="">Please select proper first period month</option>';

            year_opt += '<option value="">Please select proper first period year</option>';



        } else if ((first_year < currentYear) && (first_month < currentMonth)) {

            for (var i = currentYear; i >= first_year; i--) {

                year_opt += '<option value="' + i + '">' + i + '</option>';
            }


            for (var m = 1; m <= 12; m++) {

                month_opt += '<option value="' + m + '">' + getMonthName(m) + '</option>';

            }




        } else if ((first_year == currentYear) && (first_month < currentMonth)) {



            year_opt += '<option value="' + first_year + '">' + first_year + '</option>';



            for (var m = (first_month + 1); m <= currentMonth; m++) {

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

        if (second_month > first_month) {
            for (var i = currentYear; i >= (first_year); i--) {

                options += '<option value="' + i + '">' + i + '</option>';
            }

        } else {

            for (var i = currentYear; i >= (first_year + 1); i--) {
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

    function switchTab(tab_name){
        $('#active-tab-input').val(tab_name);
    }

    document.addEventListener('DOMContentLoaded', function() {
        get_fund_types($('input[name="Category"]:checked').val() || 'by_category');
        $('#fund_type_id').on('change', validate_category_selection);
    });







    document.addEventListener('DOMContentLoaded', function() {
    var exportButtonIndustries = document.getElementById('exportPDF-industries');

    if (!exportButtonIndustries) {
        return;
    }

    exportButtonIndustries.addEventListener('click', function() {
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
            doc.text('New Industries', pageWidth / 2, 35, { align: 'center' });
            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Adding top industries dynamic information
            var month = "{{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }}";
            var year = "{{ isset($year) ? $year : 'N/A' }}";
            var monthSecond = "{{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }}";
            var yearSecond = "{{ isset($year_second) ? $year_second : 'N/A' }}";
            var industriesHeaderText = `Top Industries: From the month of ${month}, ${year} to ${monthSecond}, ${yearSecond}`;
            doc.text(industriesHeaderText, 15, yPosition);
            yPosition += lineHeight;

            @if (isset($request) && $request->Category == 'by_category')
                var fundClassificationText = `Fund Classification: {{ isset($fund_type_name) ? $fund_type_name : 'N/A' }}`;
                doc.text(fundClassificationText, 15, yPosition);
                yPosition += lineHeight;
            @endif

            @if (isset($request) && $request->Category == 'by_fund')
                var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";
                doc.text('Fund Name: ' + fundNames, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Data table for industries
            var table = new DataTable('#pdfData-industries');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push([row[0], row[1], row[2]]);
            });

            doc.autoTable({
                head: [['Industry Name', 'Content %', 'Amount (in Cr.)']],
                body: tableData,
                startX: 15,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'New Industries-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});

// Similar modifications can be made for the "Top Scrips" section.

document.addEventListener('DOMContentLoaded', function() {
    var exportButtonScrips = document.getElementById('exportPDF-scrips');

    if (!exportButtonScrips) {
        return;
    }

    exportButtonScrips.addEventListener('click', function() {
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
            doc.text('New Scrips', pageWidth / 2, 35, { align: 'center' });
            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            // Adding top scrips dynamic information
            var month = "{{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : 'N/A' }}";
            var year = "{{ isset($year) ? $year : 'N/A' }}";
            var monthSecond = "{{ isset($month_second) ? date('F', mktime(0, 0, 0, $month_second, 10)) : 'N/A' }}";
            var yearSecond = "{{ isset($year_second) ? $year_second : 'N/A' }}";
            var scripsHeaderText = `Top Scrips: From the month of ${month}, ${year} to ${monthSecond}, ${yearSecond}`;
            doc.text(scripsHeaderText, 15, yPosition);
            yPosition += lineHeight;

            @if (isset($request) && $request->Category == 'by_category')
                var fundClassificationText = `Fund Classification: {{ isset($fund_type_name) ? $fund_type_name : 'N/A' }}`;
                doc.text(fundClassificationText, 15, yPosition);
                yPosition += lineHeight;
            @endif

            @if (isset($request) && $request->Category == 'by_fund')
                var fundNames = "{{ isset($fund_id) ? implode(', ', array_map(fn($id) => getNameTable('fund_master', 'fund_name', 'fund_id', $id), $fund_id)) : '' }}";
                doc.text('Fund Name: ' + fundNames, startX, yPosition);
                yPosition += lineHeight;
            @endif

            // Data table for scrips
            var table = new DataTable('#pdfData-scrips');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push([row[0], row[1], row[2]]);
            });

            doc.autoTable({
                head: [['Scrip Name', 'Content %', 'Amount (in Cr.)']],
                body: tableData,
                startX: 15,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'New Scrips-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});





</script>
