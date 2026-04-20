@extends('web.layout.infosolz_user_app')
@section('content')
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
            <div class="head_brdcm">
                <ul class="brdcmb">
                    <li><a href="{{route('user.auth-dashboard')}}">dashboard</a></li>
                    <li><a href="{{route('user.ratio_dashboard')}}">Ratio Reports</a></li>
                    <li>Quick Ratio</li>
                </ul>
            </div>

            <div class="perform_head">
                        <h2>Quick Ratio</h2>
            </div>

                <section class="monthly_snapshop_sec">
                <a href="{{ route('user.ratio_dashboard') }}" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="container">
                        <div class="wm_tab">
                            <ul>
                                <li>
                                    @php 
                                    $currentUrl = url()->current();
                                    @endphp
                                    <a href="javascript:void(0)" id="tab-weekly" onclick="tabSelect('weekly')" class="@if((isset($request->type) && ($request->type == 'weekly')) || !isset($request->type)) active @endif">Weekly</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" id="tab-monthly" onclick="tabSelect('monthly')" class="@if(isset($request->type) && ($request->type == 'monthly')) active @endif">Monthly</a>
                                </li>
                            </ul>
                        </div>
                        <div class="light_green_bg month_bg">
                            <form method="GET" action="" id="dateForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <input type="text" placeholder="As on Date" class="datepicker" name="date"
                                                id="dateInput" value="@if(isset($request->date)) {{$request->date}} @endif">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form_group">
                                            <select name="fund_type_id" class="select2"
                                            data-placeholder="Select Fund Classification">
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
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <select id="report-category" name="report_category"
                                            data-placeholder="Select">
                                                <option value="">Select</option>
                                                <option value="return" @if(isset($request->report_category) && $request->report_category == 'return') selected @endif>Return %</option>
                                                <option value="indices" @if(isset($request->report_category) && $request->report_category == 'indices') selected @endif>Indices</option>
                                                <option value="return_less_index" @if(isset($request->report_category) && $request->report_category == 'return_less_index') selected @endif>Return Less Index</option>
                                                @if(isset($request->type) && $request->type == 'monthly')
                                                <option value="corpus_change" @if(isset($request->report_category) && $request->report_category == 'corpus_change') selected @endif>Corpus Changes</option>
                                                @endif
                                            </select>
                                            @error('report_category')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="bttn_grp">
                                            @php
                                            $type = 'weekly';
                                                if(isset($request->type) && ($request->type == 'monthly')){
                                                    $type = 'monthly';
                                                } 
                                            @endphp
                                            <input type="hidden" name="type" id="type" value="{{$type}}">
                                            <button class="perform-submit money_title_btn btn" type="submit">Search</button>
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
                        

                        @if(isset($request) && !empty($request->date) && !empty($request->fund_type_id))
                        <div class="light_green_bg">
                            <div class="perform-snapshot-points mt-2 bordr-only prfrm-snapst">
                                <ul>
                                    <li>
                                        <p>Term of Fund : 
                                            <span>Long Term</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>Type of Fund : 
                                        <span>@if(isset($request_fund_type->name)) {{$request_fund_type->name}}@endif</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>As On :
                                        <span>@if(isset($request->date)) {{date('d/m/Y',strtotime($request->date))}} @endif</span>
                                        </p>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                        
                        @endif
                        <div class="row all_tables" id="pdfData">
                            
                            
                            <div class="col-md-12">
                                <div class="graph_table orange_bg">

                                    <div class="share_pdf">
                                        <div class="sharethis-inline-share-buttons" ></div>
                                        <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                                src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}"></a>

                                    </div>
                                    
                                    <!-- ======Weekly====== -->
                                    @if(isset($request->type) && ($request->type == 'weekly'))
                                    @if(isset($responseArr) && ($request->report_category == 'return'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-return">
                                        
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th>Index Name </th>
                                                        <th class="text_center">Daily</th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code={{$quickRatio->fund_code}}" target="_blank">{{$quickRatio->fund_name}}</a></td>
                                                                <td>{{ $quickRatio->indices_name }}</td>

                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'5DAYS'}))?printValue($quickRatio->{'5DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif

                                    @if(isset($responseArr) && ($request->report_category == 'indices'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-indices">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Index Name </th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td>{{ $quickRatio->indices_name }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif

                                    @if(isset($responseArr) && ($request->report_category == 'return_less_index'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-return-less-index">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code={{$quickRatio->fund_code}}" target="_blank">{{$quickRatio->fund_name}}</a></td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif

                                    @endif

                                    <!-- ======End Weekly====== -->
                                    <!-- ========Molthly====== -->
                                    
                                    @if(isset($request->type) && ($request->type == 'monthly'))
                                    @if(isset($responseArr) && ($request->report_category == 'return'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-return">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th>Index Name </th>
                                                        <th class="text_center">Six Months</th>
                                                        <th class="text_center">One Year</th>
                                                        <th class="text_center">Two Year</th>
                                                        <th class="text_center">Three Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code={{$quickRatio->fund_code}}" target="_blank">{{$quickRatio->fund_name}}</a></td>
                                                                <td>{{ $quickRatio->indices_name }}</td>

                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif

                                    @if(isset($responseArr) && ($request->report_category == 'indices'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-indices">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Index Name </th>
                                                        <th class="text_center">Six Months</th>
                                                        <th class="text_center">One Year</th>
                                                        <th class="text_center">Two Year</th>
                                                        <th class="text_center">Three Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td>{{ $quickRatio->indices_name }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif

                                    @if(isset($responseArr) && ($request->report_category == 'return_less_index'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-return-less-index">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">Six Months</th>
                                                        <th class="text_center">One Year</th>
                                                        <th class="text_center">Two Year</th>
                                                        <th class="text_center">Three Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code={{$quickRatio->fund_code}}" target="_blank">{{$quickRatio->fund_name}}</a></td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' ' }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif
                                    @if(isset($responseArr) && ($request->report_category == 'corpus_change'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-corpus-change">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">Current Amount (Rs.in Crores)</th>
                                                        <th class="text_center">Change Amount (Rs.in Crores)</th>
                                                        <th class="text_center"> (%) Change </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td><a class="text-white" href="/fund-performance?fund_code={{$quickRatio->fund_code}}" target="_blank">{{$quickRatio->fund_name}}</a></td>
                                                                <td class="text_right">{{ printValue($quickRatio->corpus_entry/100) }}</td>
                                                                <td class="text_right">{{ printValue($quickRatio->corpus_change/100) }}</td>
                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'percentage_change'}))?printValue($quickRatio->{'percentage_change'}):' ' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    @endif

                                    @endif

                                    <!-- ======End Molthly====== -->
                                     
                                    @if(!isset($responseArr['snapshot_data']))
                                    <div class="weekly-return-less-index">
                                            <table class="table  datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name</th>
                                                        <th class="text_center">7 Days</th>
                                                        <th class="text_center">14 Days</th>
                                                        <th class="text_center">30 Days</th>
                                                        <th class="text_center">60 Days</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td colspan="7" class="text-center">No information is available for this search</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                            
                    </div>
                </section>

                @if (isset($responseArr))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
           
                    
            @endif
            </div>
        </div>
    </div>
<script>
function tabSelect(val) {

    $("#type").val(val);
    if (val == 'weekly') {
        $("#tab-weekly").addClass('active');
        $("#tab-monthly").removeClass('active');
        $('#report-category option[value="corpus_change"]').remove();
    } else {
        $("#tab-weekly").removeClass('active');
        $("#tab-monthly").addClass('active');
        
        $('#report-category').append(
            '<option value="corpus_change" @if(isset($request->report_category) && $request->report_category == "corpus_change") selected @endif>Corpus Changes</option>'
        );
    }
}
</Script>
@endsection

<style>
    .share_pdf {
    position: static !important;
    right: 0;
    top: -38px;
    display: flex;
    align-items: center;
    gap: 10px;
    float: right;
    padding-bottom: 10px;
}
</style>

<Script>


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
                doc.text('Quick Ratio', pageWidth / 2, 35, {
                    align: 'center'
                });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Date and ratio details
                var startDate =
                    "{{ isset($request->date) ? date('d/m/Y', strtotime($request->date)) : '00/00/0000' }}";
                
                    var ratio =
                    @if (isset($request->report_category))
                        @switch($request->report_category)
                            @case('return')
                            'Return %'
                            @break

                            @case('indices')
                            'Indices'
                            @break

                            @case('return_less_index')
                            'Return Less Index'
                            @break

                            @case('corpus_change')
                            'Corpus Change'
                            @break
                            
                        @endswitch
                    @endif ;

                    var type =
                    @if (isset($request->type))
                        @switch($request->type)
                            @case('weekly')
                            'Weekly'
                            @break

                            @case('monthly')
                            'Monthly'
                            @break
                            
                        @endswitch
                    @endif ;

                var fundClassification = "{{ isset($request_fund_type->name) ? $request_fund_type->name : '' }}";

                var startX = 15;
                var lineHeight = 10;
                var tableStartY = 70;

                if (type !== null) {
                    doc.text(`Type: ${type}`, startX, tableStartY - 20);
                }

                doc.text(`As On: ${startDate}`, startX, tableStartY - 10);

                if (fundClassification !== null) {
                
                    doc.text(`Fund Classification: ${fundClassification}`, startX, tableStartY);
                }

                doc.text(`By: ${ratio}`, startX +100, tableStartY - 10);

                var table = new DataTable('.datatable');
                var tableData = [];

                table.rows({ search: 'applied' }).data().each(function(row) {
                    var strippedRow = row.map(cell => cell.replace(/<[^>]+>/g, '')); // Remove HTML tags
                    tableData.push(strippedRow);
                });

                /*table.rows({ search: 'applied' }).data().each(function(row) {
                    var processedRow = row.map(cell => {
                        // Remove HTML tags and replace blank cells with "N/A"
                        var plainText = cell.replace(/<[^>]+>/g, '');
                        return plainText.trim() === '' ? 'N/A' : plainText;
                    });
                    tableData.push(processedRow);
                });*/
                @if (isset($request->type) && $request->type =='weekly')
                    @if (isset($request->report_category) && $request->report_category =='return')
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Index Name', 'Daily', '7 Days', '14 Days', '30 Days', '60 Days']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },      
                                5: { halign: 'right' },      
                                6: { halign: 'right' },      
                            }
                        });
                    @endif
                    @if (isset($request->report_category) && $request->report_category =='indices')
                        doc.autoTable({
                            head: [
                                ['Index Name', '7 Days', '14 Days', '30 Days', '60 Days']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },      
                            }
                        });
                    @endif
                    @if (isset($request->report_category) && $request->report_category =='return_less_index')
                        doc.autoTable({
                            head: [
                                ['Fund Name', '7 Days', '14 Days', '30 Days', '60 Days']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },      
                            }
                        });
                    @endif
                @endif

                @if (isset($request->type) && $request->type =='monthly')
                    @if (isset($request->report_category) && $request->report_category =='return')
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Index Name', 'Six Months', 'One Year', 'Two Year', 'Three Year']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },   
                                5: { halign: 'right' },   
                            }
                        });
                    @endif
                    @if (isset($request->report_category) && $request->report_category =='indices')
                        doc.autoTable({
                            head: [
                                ['Index Name', 'Six Months', 'One Year', 'Two Year', 'Three Year']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },   
                            }
                        });
                    @endif
                    @if (isset($request->report_category) && $request->report_category =='return_less_index')
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Six Months', 'One Year', 'Two Year', 'Three Year']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },  
                                4: { halign: 'right' },   
                            }
                        });
                    @endif
                    @if (isset($request->report_category) && $request->report_category =='corpus_change')
                        doc.autoTable({
                            head: [
                                ['Fund Name', 'Current Amount (Rs.in Crores)', 'Change Amount (Rs.in Crores)', '(%) Change']
                            ],
                            body: tableData,
                            startX: startX,
                            startY: tableStartY + 10,
                            headStyles: {
                                fillColor: [45, 135, 23]
                            },
                            columnStyles: {
                                // Apply right alignment to specific columns
                                1: { halign: 'right' },  
                                2: { halign: 'right' },  
                                3: { halign: 'right' },    
                            }
                        });
                    @endif
                @endif

                var currentDate = new Date();

                var fileName = 'Quick-Ratio-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    });


</Script>

