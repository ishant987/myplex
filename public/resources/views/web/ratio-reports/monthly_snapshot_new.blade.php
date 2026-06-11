@extends('web.layout.infosolz_user_app')
@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                    <li><a href="{{route('user.ratio_dashboard')}}">Ratio Reports</a></li>
                    <li>Monthly snapshot</li>
                </ul>
            </div>

          

                <section class="monthly_snapshop_sec">
                <a href="{{ route('user.ratio_dashboard') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="container">
                        <div class="wm_tab">
                            <ul>
                                <li>
                                    <a href="{{ route('user.weekly_snapshot_new', ['date' => $to_date]) }}">Weekly</a>
                                </li>
                                <li>
                                    <a class="active"
                                        href="{{ route('user.monthly_snapshot_new', ['date' => $to_date]) }}">Monthly</a>
                                </li>
                            </ul>
                        </div>
                        <div class="light_green_bg month_bg">
                            <form method="GET" action="" id="dateForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form_group">
                                            <input type="date" class="form-control" name="date"
                                                id="dateInput" value="{{ date('Y-m-d', strtotime($to_date)) }}">

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="bttn_grp">
                                            <button class="btn btn-success" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        @if(!empty($message))
                        <div class="alert alert-warning mt-3">
                            {{ $message }}
                        </div>
                        @endif
                        <input type="hidden" value="monthly" name="type" id="type">
                        <div class="fund_section new_fund_section monthly_new">
                            <ul>
                                <li>
                                    <p>Monthly Snapshot Report :</p>
                                    <span>{{ date('d/m/Y', strtotime($from_date)) }} to {{ date('d-m-Y', strtotime($to_date)) }}</span>
                                </li>
                            </ul>

                            <div class="share_pdf new-share-pdf">
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                        src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}"></a>

                            </div>
                        </div>
                        <div class="row all_tables" id="pdfData">
                            
                            @for($i=1;$i<=3;$i++)
                            <div class="col-md-4">
                                <div class="graph_table green_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon1.png" alt="">@if($i==1){{' BSE Index'}}@elseif($i==2){{' NSE Index'}}@else{{ ' Global & Sectoral Index' }}@endif</h4>
                                    <table class="table bs_ns_gl datatable">
                                        <thead>
                                            <tr>
                                                <th>Indices </th>
                                                <th class="text_center">Closing Value </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($i==1)
                                            @foreach (($array_bse ?? collect()) as $indices_details)
                                                <tr>
                                                    {{-- <td>{{ getNameTableMultiple('indices_master','name','corelation',$indices_details->name, 'status', '1') }}</td> --}}
                                                    <td>{{$indices_details->name}}</td>
                                                    <td class="text_right">{{ printValue($indices_details->cur_value) }}</td>
                                                    <td class="text_right">{{ printValue($indices_details->PER_CHANGE) }}</td>
                                                </tr>
                                            @endforeach
                                        @elseif($i==2)
                                            @foreach (($array_nse ?? collect()) as $indices_details)
                                                <tr>
                                                    {{-- <td>{{ getNameTableMultiple('indices_master','name','corelation',$indices_details->name, 'status', '1') }}</td> --}}
                                                    <td>{{ $indices_details->name }}</td>

                                                    <td class="text_right">{{ printValue($indices_details->cur_value) }}</td>
                                                    <td class="text_right">{{ printValue($indices_details->PER_CHANGE) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach (($array_global_it ?? collect()) as $indices_details)
                                                <tr>
                                                    {{-- <td>{{ getNameTableMultiple('indices_master','name','corelation',$indices_details->name, 'status', '1') }}</td> --}}

                                                    <td>{{ $indices_details->name }}</td>

                                                    <td class="text_right">{{ printValue($indices_details->cur_value) }}</td>
                                                    <td class="text_right">{{ printValue($indices_details->PER_CHANGE) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endfor
                            <div class="col-md-4">
                                <div class="graph_table sky_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon2.png" alt=""> Currency Changes</h4>
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Currency </th>
                                                <th class="text_center">₹ </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (($changes_currency ?? collect()) as $curr_details)
                                                <tr>
                                                    <td>{{ $curr_details->name }}</td>
                                                    <td class="text_right">{{ printValue($curr_details->cur_value) }}</td>
                                                    <td class="text_right">{{ printValue($curr_details->PER_CHANGE) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="graph_table yellow_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon3.png" alt=""> Commodity Changes</h4>
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Commodity </th>
                                                <th class="text_center">₹ </th>
                                                <th class="text_center">% Change </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (($changes_commodity ?? collect()) as $commodity_details)
                                                <tr>
                                                    <td>{{ $commodity_details->name }}</td>
                                                    <td class="text_right">{{ printValue($commodity_details->cur_value) }}</td>
                                                    <td class="text_right">{{ printValue($commodity_details->PER_CHANGE) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="graph_table orange_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon4.png" alt=""> Percentage Change by Category of Funds(Returns)</h4>
                                    <div class="">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Fund Category </th>
                                                <th class="text_center">% Change(Returns)</th>
                                                <th class="text_center">Median </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (($monthly_benchmark ?? collect()) as $benchmark_details)
                                                <tr>
                                                    <td class="open_popup" FundTypeID="{{ $benchmark_details->FundTypeID }}">{{ $benchmark_details->FUNDTYPE }}</td>
                                                    <td class="text_right">{{ printValue($benchmark_details->CHANGEVALUE_NEW) }}</td>
                                                    <td class="text_right">{{ printValue($benchmark_details->MEDIANVAL_NEW) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    

                                    

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="graph_table blue_bg">
                                    <h4><img src="https://myplexus.tech2dev.xyz//themes/frontend/assets/infosolz/images/icon5.png" alt=""> 10 Best Performing Schemes</h4>
                                    <div class="">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Scheme Name </th>
                                                <th>Category</th>
                                                <th class="text_center">Return % </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (($best_schemes ?? collect()) as $scheme_details)
                                                <tr>
                                                    <td>{{ $scheme_details->fund_name }}</td>
                                                    <td>{{ $scheme_details->name }}</td>
                                                    <td class="text_right">{{ printValue($scheme_details->monthly_change) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="popup-overlay"></div>
                                    <div class="table_popup">
                                        <div class="graph_table">
                                            <h4>Fund Changes</h4>
                                            <div class="table_overflow table_height">
                                                <table class="table pop_up_datatable">
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
                </section>

                @if (isset($changes_currency))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
           
                    
            @endif
            </div>
        </div>
    </div>
@endsection

<style>
.new-share-pdf{
    top:0 !important;
}
</style>


<Script>

document.addEventListener('DOMContentLoaded', function() {
    var exportButton = document.getElementById('exportPDF');

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
            doc.text('Monthly Snapshot', pageWidth / 2, 35, { align: 'center' });

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);
            doc.text('Monthly Snapshot Report :', 15, 50);
            doc.text(`{{ date('d/m/Y', strtotime($from_date)) }} to {{ date('d-m-Y', strtotime($to_date)) }}`, 15, 55);

            var yPosition = 70;

            // 1. BSE, NSE, Global and Sectoral Index (Separate Tables)
            @if($array_bse)
                doc.text('BSE Index', 15, yPosition);
                yPosition += 10;
                var bseData = [];
                @foreach ($array_bse as $indices_details)
                    bseData.push(['{{ $indices_details->name }}', '{{ printValue($indices_details->cur_value) }}', '{{ printValue($indices_details->PER_CHANGE) }}']);
                @endforeach
                // Sort BSE Data (you can change the sorting criteria as needed)
                bseData.sort((a, b) => a[1] - b[1]); // Sorting by closing value
                doc.autoTable({
                    head: [['BSE Indices', 'Closing Value', '% Change']],
                    body: bseData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            @endif

            @if($array_nse)
                doc.text('NSE Index', 15, yPosition);
                yPosition += 10;
                var nseData = [];
                @foreach ($array_nse as $indices_details)
                    nseData.push(['{{ $indices_details->name }}', '{{ printValue($indices_details->cur_value) }}', '{{ printValue($indices_details->PER_CHANGE) }}']);
                @endforeach
                // Sort NSE Data
                nseData.sort((a, b) => a[1] - b[1]);
                doc.autoTable({
                    head: [['NSE Indices', 'Closing Value', '% Change']],
                    body: nseData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            @endif

            @if($array_global_it)
                doc.text('Global & Sectoral Index', 15, yPosition);
                yPosition += 10;
                var globalData = [];
                @foreach ($array_global_it as $indices_details)
                    globalData.push(['{{ $indices_details->name }}', '{{ printValue($indices_details->cur_value) }}', '{{ printValue($indices_details->PER_CHANGE) }}']);
                @endforeach
                // Sort Global Data
                globalData.sort((a, b) => a[1] - b[1]);
                doc.autoTable({
                    head: [['Global/Sectoral Indices', 'Closing Value', '% Change']],
                    body: globalData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            @endif

            // Continue with the rest of your tables in a similar fashion
            // For Currency Changes
            @if($changes_currency)
                doc.text('Currency Changes', 15, yPosition);
                yPosition += 10;
                var currencyData = [];
                @foreach ($changes_currency as $curr_details)
                    currencyData.push(['{{ $curr_details->name }}', '{{ printValue($curr_details->cur_value) }}', '{{ printValue($curr_details->PER_CHANGE) }}']);
                @endforeach
                // Sort Currency Data
                currencyData.sort((a, b) => a[1] - b[1]);
                doc.autoTable({
                    head: [['Currency', '₹', '% Change']],
                    body: currencyData,
                    startY: yPosition,
                    headStyles: { fillColor: [45, 135, 23] },
                });
                yPosition = doc.lastAutoTable.finalY + 10;
            @endif


            // 5. Commodity Changes
            doc.text('Commodity Changes', 15, yPosition);
            yPosition += 10;
            var commodityData = [];
            @foreach ($changes_commodity as $commodity_details)
                commodityData.push(['{{ $commodity_details->name }}', '{{ number_format($commodity_details->cur_value, 2) }}', '{{ number_format($commodity_details->PER_CHANGE, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['Commodity', '₹', '% Change']],
                body: commodityData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 6. Percentage Change by Category of Funds
            doc.text('Percentage Change by Category of Funds (Returns)', 15, yPosition);
            yPosition += 10;
            var benchmarkData = [];
            @foreach ($monthly_benchmark as $benchmark_details)
                benchmarkData.push(['{{ $benchmark_details->FUNDTYPE }}', '{{ number_format($benchmark_details->CHANGEVALUE, 2) }}', '{{ number_format($benchmark_details->MEDIANVAL, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['Fund Category', '% Change (Returns)', 'Median']],
                body: benchmarkData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 7. 10 Best Performing Schemes
            doc.text('10 Best Performing Schemes', 15, yPosition);
            yPosition += 10;
            var schemeData = [];
            @foreach ($best_schemes as $scheme_details)
                schemeData.push(['{{ $scheme_details->fund_name }}', '{{ $scheme_details->name }}', '{{ number_format($scheme_details->monthly_change, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['Scheme Name', 'Category', 'Return %']],
                body: schemeData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // And so on for the other data tables...

            // Save the document
            var currentDate = new Date();
            var fileName = 'Monthly-Snapshot-' + currentDate + '.pdf';
            doc.save(fileName);
        };
    });
});





</Script>
