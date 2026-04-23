@extends('web.layout.infosolz_user_app')
@section('content')
    @php
        $isByFundMode = isset($request) && $request->Category === 'by_fund';
    @endphp

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
                                <div class="col-md-6 div_show_1" style="{{ $isByFundMode ? 'display:none;' : '' }}">
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

                                <div class="col-md-6 div_hide_1" style="{{ $isByFundMode ? '' : 'display:none;' }}">
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

                    @if(!empty($has_searched))
                    <div class="fund_section new_fund_section">
                        <ul>
                            <li>
                                <p>Composition Allocation Snapshot :</p>
                                @if (isset($monthName) && isset($year))
                                    <span>For the month of {{ $monthName }},{{ $year }}</span>
                                @endif
                            </li>
                           
                            @if (isset($request) && $request->Category == 'by_category' && !empty($fund_type_name))
                            <li>
                                <p>fund classification :</p>
                                <span>{{ isset($fund_type_name) ? $fund_type_name : '' }}</span>
                            </li>
                        @endif

                        @if (isset($request) && $request->Category == 'by_fund' && !empty($fund_names))
                        <li>
                            <p>fund name :</p>
                            <span>{{ isset($fund_names) ? $fund_names : '' }}</span>
                        </li>
                        @endif
                        </ul>
                    </div>
                   
                        <div class="graph_table allo_data">
                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                
                            </div>
                            <!-- <table class="table allo">
                                <thead>
                                    <tr>
                                        <th colspan=""></th>
                                        <th colspan="" class="text_center">Equity</th>
                                        <th colspan=""></th>
                                    </tr>
                                </thead>

                            </table> -->
                            <table class="table datatable"  id="pdfData">

                                <thead>
                                    <tr>
                                        <th class="text_left">Name of the Fund</th>
                                        <th class="text_center">Cash %</th>
                                        <th class="text_center">SOV %</th>
                                        <th class="text_center">Corp debt %</th>
                                        <th class="text_center">Small cap %</th>
                                        <th class="text_center">Mid cap %</th>
                                        <th class="text_center">Large cap %</th>
                                        <th class="text_center">Very large cap %</th>
                                        <th class="text_center">Others</th>
                                        <th class="text_center">Wt. PE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    @if (isset($fund_snapshot) && count($fund_snapshot) > 0)
                                    @foreach ($fund_snapshot as $item)
                                        <tr>
                                            <td class="text_left">{{ $item['fund_name'] }}</td>
                                            <td class="text_right">{{ $item['cash'] }}</td>
                                            <td class="text_right">{{ $item['sov'] }}</td>
                                            <td class="text_right">{{ $item['debt'] }}</td>
                                            <td class="text_right">{{ $item['eq_small'] }}</td>
                                            <td class="text_right">{{ $item['eq_mid'] }}</td>
                                            <td class="text_right">{{ $item['eq_large'] }}</td>
                                            <td class="text_right">{{ $item['eq_very_large'] }}</td>
                                            <td class="text_right">{{ $item['others_val'] }}</td>
                                            <td class="text_right">{{ $item['wt_pe'] }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10">No information available for this search</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
                @if (isset($fund_snapshot) && count($fund_snapshot) > 0)

                


                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                    <div class="all_note" style="
                    padding-left: 16px;
                ">
                    <ul>
                        <li>For loss making scrips, earnings are considered as zero.</li>
                        <li>Loss Making Scrips have not been taken into account for calculation of total fund portfolio weighted PE.</li>
                        <li>Equity Mutual Fund and ETF are added to Others.</li>
                        <li>P/E Ratio (TTM) is considered for calculating weighted PE.</li>

                      </ul>
                    </div>
                </div>
           
                    
            @endif
            </div>
        </div>
    </div>
@endsection
<script>
    function updateAllocationModeUI(mode) {
        var isByFund = mode === 'by_fund';
        $('.div_show_1').toggle(!isByFund);
        $('.div_hide_1').toggle(isByFund);

        if (!isByFund) {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
        } else {
            set_fund_select_val();
        }
    }

    function set_fund_select_val() {
        var thiss = $('input[name="Category"]:checked').val();
        var count = ($('#allocation_select_fund').val() || []).length;

        if (thiss == 'by_fund') {
            if (count >= 2 && count <= 20) {
                $('#fund_msgg').html('');
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#fund_msgg').html('<p>Selection limit minimum 2 and maximum 20 for <b>Funds</b></p>');
                $('#submit_btn').prop('disabled', true);
            }
        } else {
            $('#fund_msgg').html('');
            $('#submit_btn').prop('disabled', false);
        }
    }

    function get_fund_types(thiss) {
        updateAllocationModeUI(thiss);
    }

    document.addEventListener('DOMContentLoaded', function() {
    var selectedCategory = $('input[name="Category"]:checked').val() || 'by_category';
    updateAllocationModeUI(selectedCategory);
    $('#allocation_select_fund').on('change', set_fund_select_val);

    var exportButton = document.getElementById('exportPDF');

    if (!exportButton) {
        return;
    }

    exportButton.addEventListener('click', function() {
        var { jsPDF } = window.jspdf;
        var doc = new jsPDF();

        // Load logo image
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
            doc.text('Alloction Snaoshot', pageWidth / 2, 35, { align: 'center' });

            var startX = 15;
            var lineHeight = 10;
            var yPosition = 70;

            var monthName = "{{ isset($monthName) ? $monthName : '' }}";
            var year = "{{ isset($year) ? $year : '' }}";

            if (monthName && year) {
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);
                doc.text('Composition Allocation Snapshot:', startX, yPosition);
                doc.text('For the month of ' + monthName + ', ' + year, startX + 100, yPosition);
                yPosition += lineHeight;
            }

            @if (isset($request) && $request->Category == 'by_category')
                var fundClassification = "{{ isset($fund_type_name) ? $fund_type_name[0] : '' }}";
                if (fundClassification) {
                    doc.text('Fund Classification:', startX, yPosition);
                    doc.text(fundClassification, startX + 100, yPosition);
                    yPosition += lineHeight;
                }
            @endif

            @if (isset($request) && $request->Category == 'by_fund')
                var fundNames = "{{ isset($fund_names) ? $fund_names : '' }}";
                if (fundNames) {
                    doc.text('Fund Name:', startX, yPosition);
                    doc.text(fundNames, startX + 100, yPosition);
                    yPosition += lineHeight;
                }
            @endif

            var table = new DataTable('#pdfData');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

                doc.autoTable({
                head: [
                    [
                        { content: 'Name of the Fund', styles: { halign: 'left' } },
                        { content: 'Cash %', styles: { halign: 'center' } },
                        { content: 'SOV %', styles: { halign: 'center' } },
                        { content: 'Corp debt %', styles: { halign: 'center' } },
                        { content: 'Small cap %', styles: { halign: 'center' } },
                        { content: 'Mid cap %', styles: { halign: 'center' } },
                        { content: 'Large cap %', styles: { halign: 'center' } },
                        { content: 'Very large cap %', styles: { halign: 'center' } },
                        { content: 'Others', styles: { halign: 'center' } },
                        { content: 'Wt. PE', styles: { halign: 'center' } }
                    ]
                ],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23], textColor: [255, 255, 255] },
                styles: { halign: 'center' }
            });

            // Save the PDF with a generated filename
            var currentDate = new Date();
            var fileName = 'Alloction-Snaoshot-' + currentDate + '.pdf';
            doc.save(fileName);
        };
    });
});



</script>
