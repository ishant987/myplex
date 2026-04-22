@extends('web.layout.infosolz_user_app')
@section('content')
    @php
        $fund_names = '';
    @endphp
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.composition_report') }}">composition report</a></li>
                        <li>Occurrence Report</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="wm_tab">
                        <ul class="tabs">
                            {{-- <li>
                                <a class="{{ isset($getData) ? ($getData['scrip_industry'] == 'industry' ? 'active' : '') : 'active' }}"
                                    id="quartile_tab" data-value="industry"
                                    onclick="industry_scrip_select(this)">Industry</a>
                            </li> --}}
                            <li>
                                <!-- <a class="{{ isset($getData) && $getData['scrip_industry'] == 'scrip' ? 'active' : '' }}"
                                                    id="decile_tab" data-value="scrip" onclick="industry_scrip_select(this)">Scrip</a> -->
                                <a class="@if (isset($getData['scrip_industry'])) @if ($getData['scrip_industry'] == 'scrip')
                                            active @endif
@else
active
                                         @endif"
                                    id="decile_tab" data-value="scrip" onclick="industry_scrip_select(this)">Scrip</a>
                            </li>
                            <li>
                                <!-- <a class="@if (isset($getData['scrip_industry'])) @if ($getData['scrip_industry'] == 'industry')
                                            active @endif
@else
active
                                         @endif

                                "
                                                    id="quartile_tab" data-value="industry"
                                                    onclick="industry_scrip_select(this)">Industry</a> -->
                                <a class="{{ isset($getData) && $getData['scrip_industry'] == 'industry' ? 'active' : '' }}"
                                    id="quartile_tab" data-value="industry"
                                    onclick="industry_scrip_select(this)">Industry</a>
                            </li>


                        </ul>
                    </div>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">

                                {{-- <input type="hidden" name="scrip_industry" id="scrip_industry" value="{{ isset($getData['scrip_industry']) ? $getData['scrip_industry'] : ''}}"> --}}

                                <!-- <input type="hidden" name="scrip_industry" id="scrip_industry"
                                                    value="@if (isset($getdata)) @if ($getData['scrip_industry'] == 'industry')
                                            industry
                                            @elseif($getData['scrip_industry'] == 'scrip')
                                            scrip @endif
@else
industry
                                        @endif"> -->

                                <input type="hidden" name="scrip_industry" id="scrip_industry"
                                    value="@if (isset($getdata)) @if ($getData['scrip_industry'] == 'industry') industry @elseif($getData['scrip_industry'] == 'scrip') scrip @endif
@else
scrip @endif">



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

                                <div class="col-md-4 div_hide_1">
                                    <div class="form_group">
                                        <select name="fund_id[]" class="select2 multiple" multiple
                                            id="allocation_select_fund" onchange="set_fund_select_val(this.value)">
                                            @foreach ($all_funds as $fund)
                                                <option value="{{ $fund->fund_id }}"
                                                    @if (old('fund_id') !== null && in_array($fund->fund_id, (array) old('fund_id'))) selected
                                                    @elseif (isset($fund_ids) && in_array($fund->fund_id, $fund_ids))
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

                                <div class="col-md-4 div_show_1">
                                    <div class="form_group">
                                        <select name="fund_type_id" class="select2" data-placeholder="Select Fund Type">
                                            <option value="">Select Fund Type</option>
                                            @foreach ($all_fund_types as $fund_type)
                                                <option value="{{ $fund_type->ft_id }}"
                                                    @if ($fund_type->ft_id == old('fund_type_id', isset($getData) ? $getData['fund_type_id'] : null)) selected @endif>
                                                    {{ $fund_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fund_type_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="col-md-4 industry"
                                                    style="{{ isset($getData) ? ($getData['scrip_industry'] == 'industry' ? 'display:block' : 'display:none') : 'display:block' }}"> -->
                                <div class="col-md-4 industry"
                                    style="{{ isset($getData) && $getData['scrip_industry'] == 'industry' ? 'display:block' : 'display:none' }}">
                                    <div class="form_group">
                                        <select class="select2" name="industry" data-placeholder="Select Industry">
                                            <option value="">Select Industry</option>
                                            @foreach ($industries as $industry)
                                                <option
                                                    value="{{ $industry->industry }}"{{ isset($getData['industry']) && $getData['industry'] == $industry->industry ? 'selected' : '' }}>
                                                    {{ $industry->industry }} </option>
                                            @endforeach
                                        </select>
                                        @error('industry')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- <div class="col-md-4 scrip"
                                                    style="{{ isset($getData) && $getData['scrip_industry'] == 'scrip' ? 'display:block' : 'display:none' }}"> -->
                                <div class="col-md-4 scrip"
                                    style="{{ isset($getData) ? ($getData['scrip_industry'] == 'scrip' ? 'display:block' : 'display:none') : 'display:block' }}">
                                    <div class="form_group">
                                        <select class="select2" name="fund_scrips" data-placeholder="Select Scrip">
                                            <option value="">Select Scrip</option>
                                            @foreach ($mpx_fund_scrips as $scr)
                                                <option
                                                    value="{{ $scr->actual_scrip }}"{{ isset($getData['fund_scrips']) && $getData['fund_scrips'] == $scr->actual_scrip ? 'selected' : '' }}>
                                                    {{ $scr->actual_scrip }}</option>
                                            @endforeach
                                        </select>
                                        @error('fund_scrips')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @include('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $getData['year'] ?? '',
                                    'selectedMonth' => $getData['month'] ?? '',
                                    'size' => 6,
                                ])

                                {{-- <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="month" id="month" required>
                                            <option value="">select month</option>
                                            @foreach ($months as $m)
                                                <option value="{{ $m }}"
                                                    {{ isset($gatData['month']) && $gatData['month'] == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                                            @endforeach
                                        </select>
                                        @error('month')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="year" id="year" required>
                                            <option value="">select year</option>
                                            @foreach ($years as $y)
                                                <option
                                                    value="{{ $y }}"{{ isset($request->year) && $request->year == $y ? 'selected' : '' }}>
                                                    {{ $y }}</option>
                                            @endforeach
                                        </select>
                                        @error('year')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" name="search" id="submit_btn" value="search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (isset($fund_composition))
                        <div class="fund_section new_fund_section">
                            <ul>
                                @if (isset($getData['month']) && isset($getData['year']))
                                    <li>
                                        <p>Occurrence Report : </p> <span> For month of
                                            {{ isset($getData['month']) ? date('F', mktime(0, 0, 0, $getData['month'], 10)) : 'N/A' }},
                                            {{ isset($getData['year']) ? $getData['year'] : 'N/A' }}</span>
                                    </li>
                                @endif

                                @if (isset($getData['scrip_industry']) && $getData['scrip_industry'] == 'scrip')

                                    <li>
                                        <p>Scrip Name: </p>

                                        <span>{{ getNameTable('scrips', 'actual_scrip', 'actual_scrip', $getData['fund_scrips']) }},
                                        </span>

                                    </li>
                                @elseif(isset($getData['scrip_industry']) && $getData['scrip_industry'] == 'industry')
                                    <li>
                                        <p>Industry Name: </p>

                                        <span>{{ getNameTable('fund_composition', 'industry', 'industry', $getData['industry']) }},
                                        </span>

                                    </li>

                                @endif

                                @if (isset($fund_type_get_data->name))
                                    <li>
                                        <p>Fund type : </p>
                                        <span>{{ isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A' }}</span>
                                    </li>
                                @elseif(!empty($getData['fund_id']))
                                    <li>
                                        <p>Fund Names: </p>

                                        @foreach ((array) $getData['fund_id'] as $fund_id)
                                            @php
                                                $fund_names .=
                                                    getNameTable('fund_master', 'fund_name', 'fund_id', $fund_id) .
                                                    ', ';
                                            @endphp
                                        @endforeach
                                        <span>{{ rtrim($fund_names, ', ') }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">

                                <div class="sharethis-inline-share-buttons"></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                        src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}"></a>

                            </div>
                            <table class="table datatable" id="pdfData">
                                <thead>
                                    <tr>
                                        <th class="text_left">name of the Fund</th>
                                        <th class="text_left">
                                            @if ($getData['scrip_industry'] == 'industry') Industry
                                                Name
                                            @elseif($getData['scrip_industry'] == 'scrip')
                                                Scrip Name @endif
                                        </th>
                                        <th class="text_center">content (%)</th>
                                        {{-- <th class="text_center">Amount(Rs.In Cr)</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($fund_composition) && count($fund_composition) > 0)
                                        @foreach ($fund_composition as $val)
                                            <tr>
                                                <td class="text_left">
                                                    {{ getNameTable('fund_master', 'fund_name', 'fund_code', $val->fund_code) }}
                                                </td>

                                                @if ($getData['scrip_industry'] == 'industry')
                                                    <td class="text_left">
                                                        {{ isset($val->industry) ? $val->industry : 'N/A' }}
                                                    </td>
                                                @elseif($getData['scrip_industry'] == 'scrip')
                                                    <td class="text_left">
                                                        {{ isset($val->scrip_name) ? $val->scrip_name : 'N/A' }}
                                                    </td>
                                                @endif


                                                <td class="text_right">
                                                    {{ isset($val->content_per) ? printValue($val->content_per) : '0' }}
                                                </td>
                                                {{-- <td class="text_right">
                                                    {{ isset($val->amount) ? printValue($val->amount) : '0' }}
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text_center">No information available for this
                                                search
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
                @if (isset($fund_composition))
                    <div class="disclaimer">
                        <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                    </div>


                @endif
            </div>
        </div>
    </div>
    {{-- @dd($fund_names); --}}
@endsection


<script>
    function get_classification(thiss) {
        decile

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

    function get_fund_by_scrips(thiss) {

        var scrips_name = thiss;

        var url = '{{ route('user.get_fund_by_scrips') }}';

        $.ajax({
            type: "GET",
            url: url,
            data: {
                'scrips_name': scrips_name
            },
            success: function(response) {

                $('#fund_master').html(response);

            }
        });

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

    function industry_scrip_select(element) {
        var dataValue = element.getAttribute('data-value');
        $('#scrip_industry').val(dataValue);
        if (dataValue === 'scrip') {
            $('.industry').hide();
            $('.scrip').show();
        } else if (dataValue === 'industry') {
            $('.industry').show();
            $('.scrip').hide();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('exportPDF');

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
                doc.text('Occurrence Report', pageWidth / 2, 35, {
                    align: 'center'
                });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);


                var fundNames = "{{ isset($fund_names) ? rtrim($fund_names, ', ') : '' }}";


                var startX = 15;
                var lineHeight = 10;
                var yPosition = 70;


                // Start replacing this section with new HTML-based data

                // Scrips Boomers (Month, Year)
                @if (isset($getData['month']) && isset($getData['year']))
                    var scripsBoomersText =
                        `Occurrence Report: For the month of {{ isset($getData['month']) ? date('F', mktime(0, 0, 0, $getData['month'], 10)) : 'N/A' }}, {{ isset($getData['year']) ? $getData['year'] : 'N/A' }}`;
                    doc.text(scripsBoomersText, 15, 70);
                @endif

                var yPosition = 80; // Adjust the position to move after the first text

                // Limit
                // @if (isset($limit))
                //     var limitText = `Limit: {{ isset($limit) ? $limit : '' }}`;
                //     doc.text(limitText, 15, yPosition);
                //     yPosition += 10;
                // @endif

                // Fund Classification
                @if (($getData['Category'] ?? '') == 'by_category')
                    var fundClassificationText =
                        `Fund Classification: {{ isset($fund_type_get_data->name) ? $fund_type_get_data->name : 'N/A' }}`;
                    doc.text(fundClassificationText, 15, yPosition);
                    yPosition += 10;
                @endif
                
                // Fund Name
                @if (($getData['Category'] ?? '') == 'by_fund')
                    // Split the fund names if too long to fit within 180 units (adjust width as necessary)
                    var splitFundNames = doc.splitTextToSize(fundNames, 160);
                    doc.text('Fund Names: ', startX, yPosition);
                    yPosition += 10;
                    doc.text(splitFundNames, startX, yPosition); // This will handle multiple lines
                    yPosition += splitFundNames.length *
                        lineHeight; // Adjust yPosition based on the number of lines
                @endif
                // End of replacing section

                var table = new DataTable('#pdfData');
                var tableData = [];
                table.rows({
                    search: 'applied'
                }).data().each(function(row) {
                    tableData.push(row);
                });

                var middle_name = `{{isset($getData) && $getData['scrip_industry'] == 'industry' ? 'Industry Name' : 'Scrip Name' }}`;
                doc.autoTable({
                    head: [
                        ['Name of The Fund', middle_name, 'Content(%)']
                    ],
                    body: tableData,
                    startX: 15,
                    startY: yPosition + 10,
                    headStyles: {
                        fillColor: [45, 135, 23]
                    }
                });

                var currentDate = new Date();
                var fileName = 'Occurrence-Report-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    });
</script>
