@extends('web.layout.infosolz_user_app')
@section('content')

<div class="inner_main">
<div class="page_detail">
        <div class="inner_padding">
        <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{route('user.auth-dashboard')}}">Dashboard</a></li>
                    <li><a href="{{route('user.ratio_dashboard')}}">Ratio Reports</a></li>
                    <li>Weekly snapshot</li>
                </ul>
            </div>

            <div class="perform_head">
                <h2>Weekly snapshot</h2>
            </div>
            <section class="monthly_snapshop_sec">
            <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="container">
                <div class="wm_tab">
                    <ul>
                        <li>
                            <a class="active" href="{{route('user.weekly_snapshot_new', ['date'=>$end_date])}}">Weekly</a>
                        </li>
                        <li>
                            <a href="{{route('user.monthly_snapshot_new', ['date'=>$end_date])}}">Monthly</a>
                        </li>
                    </ul>
                </div>
                <div class="light_green_bg month_bg">
                <form method="GET" action="" id="dateForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <input type="text" placeholder="As on Date" class="datepicker" name="date" id="dateInput" value="{{ date('d-m-Y', strtotime($end_date)) }}">
                                {{-- <button class="btn btn-success" type="submit">Search</button> --}}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="bttn_grp">
                                <button class="btn btn-success" type="submit">Search</button>
                            </div>
                        </div>
                        
                        <!-- <div class="col-md-4">
                            <div class="form_group">
                                <div class="input-group date" id="boot-datepicker">
                                    <input type="text" class="form-control" id="date"/>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </form>
                </div>
                <input type="hidden" value="weekly" name="type" id="type">
                <div class="fund_section new_fund_section monthly_new">
                    <ul>
                        <li>
                            <p>Weekly Snapshot Report :</p>
                            <span>{{ date('d/m/Y', strtotime($start_date)) }} to {{ date('d/m/Y', strtotime($end_date)) }}</span>
                        </li>
                    </ul>

                    <div class="share_pdf new-share-pdf">
                        <div class="sharethis-inline-share-buttons" ></div>
                        <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}"></a>

                    </div>
                </div>
                <div class="row all_tables"  id="pdfData">
                    
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
                                    @foreach ($array_bse as $indices_details)
                                        <tr>
                                            {{-- <td>{{ getNameTableMultiple('indices_master','name','corelation',$indices_details->name, 'status', '1') }}</td> --}}
                                            <td>{{$indices_details->name}}</td>
                                            <td class="text_right">{{ number_format($indices_details->cur_value, 2) }}</td>
                                            <td class="text_right">{{ number_format($indices_details->PER_CHANGE, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @elseif($i==2)
                                    @foreach ($array_nse as $indices_details)
                                        <tr>
                                            {{-- <td>{{ getNameTableMultiple('indices_master','name','corelation',$indices_details->name, 'status', '1') }}</td> --}}
                                              <td>{{$indices_details->name}}</td>
                                            <td class="text_right">{{ number_format($indices_details->cur_value, 2) }}</td>
                                            <td class="text_right">{{ number_format($indices_details->PER_CHANGE, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($array_global_it as $indices_details)
                                        <tr>
                                            {{-- <td>{{ getNameTableMultiple('indices_master','name','corelation',$indices_details->name, 'status', '1') }}</td> --}}
                                              <td>{{$indices_details->name}}</td>
                                            <td class="text_right">{{ number_format($indices_details->cur_value, 2) }}</td>
                                            <td class="text_right">{{ number_format($indices_details->PER_CHANGE, 2) }}</td>
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
                                @foreach($changes_currency as $curr_details)
                                    <tr>
                                        <td>{{$curr_details->name}}</td>
                                        <td class="text_right">{{number_format($curr_details->cur_value,2)}}</td>
                                        <td class="text_right">{{number_format($curr_details->PER_CHANGE,2)}}</td>
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
                                @foreach($changes_commodity as $commodity_details)
                                    <tr>
                                        <td>{{$commodity_details->name}}</td>
                                        <td class="text_right">{{number_format($commodity_details->cur_value,2)}}</td>
                                        <td class="text_right">{{number_format($commodity_details->PER_CHANGE,2)}}</td>
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
                                @foreach($weekly_benchmark as $benchmark_details)
                                <tr>
                                    <td class="open_popup" FundTypeID="{{ $benchmark_details->FundTypeID }}">{{$benchmark_details->FUNDTYPE}}</td>
                                    <td class="text_right">{{number_format($benchmark_details->CHANGEVALUE,2)}}</td>
                                    <td class="text_right">{{number_format($benchmark_details->MEDIANVAL,2)}}</td>
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
                            @foreach($weekly_best_funds as $scheme_details)
                                    <tr>
                                        <td>{{$scheme_details->fund_name}}</td>
                                        <td>{{$scheme_details->name}}</td>
                                        <td class="text_right">{{number_format($scheme_details->weekly_change,2)}}</td>
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
            @if (isset($changes_indices))
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

<script>

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
            doc.text('Weekly Snapshot', pageWidth / 2, 35, { align: 'center' });

           doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);
            doc.text('Weekly Snapshot Report :', 15, 50);
            doc.text(`{{ date('d/m/Y', strtotime($start_date)) }} to {{ date('d-m-Y', strtotime($end_date)) }}`, 15, 55);

            var yPosition = 70;

            // 1. BSE Index
            doc.text('BSE Index', 15, yPosition);
            yPosition += 10;
            var bseData = [];
            @foreach ($array_bse as $indices_details)
                bseData.push(['{{ $indices_details->name }}', '{{ number_format($indices_details->cur_value, 2) }}', '{{ number_format($indices_details->PER_CHANGE, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['BSE Indices', 'Closing Value', '% Change']],
                body: bseData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 2. NSE Index
            doc.text('NSE Index', 15, yPosition);
            yPosition += 10;
            var nseData = [];
            @foreach ($array_nse as $indices_details)
                nseData.push(['{{ $indices_details->name }}', '{{ number_format($indices_details->cur_value, 2) }}', '{{ number_format($indices_details->PER_CHANGE, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['NSE Indices', 'Closing Value', '% Change']],
                body: nseData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 3. Global & Sectoral Index
            doc.text('Global & Sectoral Index', 15, yPosition);
            yPosition += 10;
            var globalData = [];
            @foreach ($array_global_it as $indices_details)
                globalData.push(['{{ $indices_details->name }}', '{{ number_format($indices_details->cur_value, 2) }}', '{{ number_format($indices_details->PER_CHANGE, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['Global/Sectoral Indices', 'Closing Value', '% Change']],
                body: globalData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // 4. Currency Changes
            doc.text('Currency Changes', 15, yPosition);
            yPosition += 10;
            var currencyData = [];
            @foreach ($changes_currency as $curr_details)
                currencyData.push(['{{ $curr_details->name }}', '{{ number_format($curr_details->cur_value, 2) }}', '{{ number_format($curr_details->PER_CHANGE, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['Currency', '₹', '% Change']],
                body: currencyData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

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
            @foreach ($weekly_benchmark as $benchmark_details)
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
            @foreach ($weekly_best_funds as $scheme_details)
                schemeData.push(['{{ $scheme_details->fund_name }}', '{{ $scheme_details->name }}', '{{ number_format($scheme_details->weekly_change, 2) }}']);
            @endforeach
            doc.autoTable({
                head: [['Scheme Name', 'Category', 'Return %']],
                body: schemeData,
                startY: yPosition,
                headStyles: { fillColor: [45, 135, 23] },
            });
            yPosition = doc.lastAutoTable.finalY + 10;

            // Save the document
            var currentDate = new Date();
            var fileName = 'Weekly-Snapshot-' + currentDate.toISOString().split('T')[0] + '.pdf';
            doc.save(fileName);
        };
    });
});

</script>