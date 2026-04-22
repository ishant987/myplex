@extends('web.layout.infosolz_user_app')
@section('content')

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.composition_report') }}">composition report</a></li>
                        <li>Scheme Portfolio</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">

                                {{-- <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="fund_type" id="fund_type" required onchange="get_funds(this.value)" class="select2">
                                            <option value="">Select Fund Classification</option>
                                            @if (isset($fund_type))
                                                @foreach ($fund_type as $val)
                                                    <option value="{{ $val->ft_id }}"
                                                        {{ isset($fund_type_get) && $fund_type_get == $val->ft_id ? 'selected' : '' }}>
                                                        {{ $val->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="form_group">
                                        <select name="fund_master" id="fund_master" class="select2">
                                            <option>Select Any Funds</option>
                                            @if (isset($fund_master))
                                                @foreach ($fund_master as $val)
                                                    <option value="{{ $val->fund_code }}"
                                                        {{ request()->get('fund_master') == $val->fund_code ? 'selected' : '' }}>
                                                        {{ $val->fund_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="month" id="month" required>
                                            <option value="">select month</option>
                                            @foreach ($months as $m)
                                                <option value="{{ $m }}"
                                                    {{ isset($month) && $month == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <select name="year" id="year" required>
                                            <option value="">select year</option>
                                            @foreach ($years as $y)
                                                <option
                                                    value="{{ $y }}"{{ isset($year) && $year == $y ? 'selected' : '' }}>
                                                    {{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="bttn_grp">
                                        <button type="submit" name="search" value="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (isset($scrips) && count($scrips) > 0)
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>AUM of fund(Rs.In Crores):</p>
                                    <span>{{ isset($total_corpus_entry) ? number_format($total_corpus_entry,2): '' }}</span>
                                </li>

                                <li>
                                    <p>name of Fund :</p>
                                    <span>{{ is_object($fund_details ?? null) ? $fund_details->fund_name : '' }}</span>
                                </li>
                                <li>
                                    <p>Scheme Portfolio :</p>
                                    <span>For the month of
                                        {{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : '' }},{{ isset($year) ? $year : '' }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">

                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                
                            </div>

                            <table class="table datatable"  id="pdfData">
                                <thead>
                                    <tr>
                                        <th>Name of the Scrip</th>
                                        <th>industry</th>
                                        <th>category</th>
                                        <th class="text_center">content (%)</th>
                                        <th class="text_center">Amount(Rs.In Crores)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scrips as $val)
                                        <tr>
                                            <td class="text_left">{{ isset($val->scrip_name) ? $val->scrip_name : '' }}
                                            </td>
                                            <td class="text_left">{{ isset($val->industry) ? $val->industry : '' }}</td>
                                            <td class="text_left">{{ isset($val->category) ? $val->category : '' }}</td>
                                            <td class="text_right">
                                                {{ isset($val->content_per) ? printValue($val->content_per) : '' }}
                                            </td>

                                            <td class="text_right">
                                                {{ isset($val->amount) ? printValue($val->amount) : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>
                @if (isset($scrips))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
           
                    
            @endif
            </div>
        </div>

    </div>



@endsection

<script>
    function get_funds(thiss) {

        var fund_type_id = thiss;

        var url = "{{ route('user.get_funds') }}";

        $.ajax({
            type: "GET",
            url: url,
            data: {
                'type_id': fund_type_id
            },
            success: function(response) {

                $('#fund_master').html(response);

            }
        });

    }



document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF');

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
            doc.text('Scheme Portfolio', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);

            // Fetch dynamic data for AUM, fund name, and scheme portfolio
            var aumFund = "{{ isset($total_corpus_entry) ? number_format($total_corpus_entry, 2) : '' }}";
            var fundName = "{{ is_object($fund_details ?? null) ? $fund_details->fund_name : '' }}";
            var schemePortfolioMonth = "{{ isset($month) ? date('F', mktime(0, 0, 0, $month, 10)) : '' }}";
            var schemePortfolioYear = "{{ isset($year) ? $year : '' }}";

            var startX = 15;
            var yPosition = 70;

            // Adding AUM of fund
            doc.text('AUM of Fund (Rs.In Crores): ' + aumFund, startX, yPosition);
            yPosition += 10;

            // Adding name of the fund
            doc.text('Name of Fund: ' + fundName, startX, yPosition);
            yPosition += 10;

            // Adding scheme portfolio details
            doc.text('Scheme Portfolio: For the month of ' + schemePortfolioMonth + ', ' + schemePortfolioYear, startX, yPosition);
            yPosition += 10;

            // Adding table data (your existing DataTable logic)
            var table = new DataTable('#pdfData');
            var tableData = [];
            table.rows({ search: 'applied' }).data().each(function(row) {
                tableData.push(row);
            });

            doc.autoTable({
                head: [['Fund Name', 'Ratio', 'Rank']],
                body: tableData,
                startX: startX,
                startY: yPosition + 10,
                headStyles: { fillColor: [45, 135, 23] }
            });

            var currentDate = new Date();
            var fileName = 'Scheme-Portfolio-' + currentDate + '.pdf';

            doc.save(fileName);
        };
    });
});


</script>
