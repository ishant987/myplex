@extends('web.layout.infosolz_user_app')

@section('content')

    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.indices_report') }}">indices report</a></li>
                        <li>Schemes Associated<br> With Index</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form_group">
                                        <select name="selected_index" class="select2" data-placeholder="Select Index">
                                            <option value="">Select Indices</option>
                                            @foreach ($indices as $index_val)
                                                <option value="{{ $index_val->name }}"
                                                    {{ !empty($request) && $request->selected_index == $index_val->name ? 'Selected' : '' }}>
                                                    {{ $index_val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form_group">
                                        <input type="date" class="form-control" name="date" placeholder="Date"
                                            value="{{ !empty($request->date) ? \Carbon\Carbon::parse($request->date)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="classification">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (isset($all_schemes) && count($all_schemes) > 0)
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Index Name :</p>
                                    <span>{{ !empty($request) ? $request->selected_index : '' }}</span>
                                </li>
                                <li>
                                    <p>As On : </p>
                                    <span>{{ !empty($request) ? date('d/m/Y', strtotime($request->date)) : '' }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">
                                
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF-schemes-associated" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                
                            </div>
                            <table class="table datatable" id="pdfData-schemes-associated">
                                <thead>
                                    <tr>
                                        <th class="text_left">Schemes name</th>
                                        <th class="text_left">Fund Category</th>
                                        <th class="text_center">NAV (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_schemes as $schemes)
                                        <tr>
                                            <td class="text_left">{{ $schemes->fund_name }}</td>
                                            <td class="text_left">{{ $schemes->classification }}</td>
                                            <td class="text_right">{{ printValue($schemes->closing_nav) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {!! printNoData() !!}
                    @endif
                </div>

                @if (isset($all_schemes))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
              @endif
            </div>
        </div>

    </div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('exportPDF-schemes-associated');

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

                // Add image (logo) to the PDF
                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                // Add title
                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Schemes Associated With Index', pageWidth / 2, 35, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Add Index Name and Date
                var indexName = "{{ !empty($request) ? $request->selected_index : '' }}";
                doc.text(`Index Name: ${indexName}`, 15, 50);

                var asOnDate = "{{ !empty($request) ? date('d/m/Y', strtotime($request->date)) : '' }}";
                doc.text(`As On: ${asOnDate}`, 15, 60);

                // Set the starting Y position for the table
                var yPosition = 70;

                // Get table data
                var table = document.getElementById('pdfData-schemes-associated');
                var tableData = [];

                table.querySelectorAll('tbody tr').forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                // Add table to the PDF
                doc.autoTable({
                    head: [['Schemes Name', 'Fund Category', 'NAV (Rs.)']],
                    body: tableData,
                    startX: 15,
                    startY: yPosition + 10,
                    headStyles: { fillColor: [45, 135, 23] },
                    columnStyles: {
                        2: { halign: 'right' } // Align the NAV column to the right
                    }
                });

                // Generate file name
                var currentDate = new Date();
                var fileName = 'Schemes-Associated-With-Index-' + currentDate.toISOString().split('T')[0] + '.pdf';
            
                // Save the PDF
                doc.save(fileName);
            };
        });
    });



</script>
