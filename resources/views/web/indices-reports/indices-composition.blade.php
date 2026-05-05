@extends('web.layout.infosolz_user_app')

@section('content')
    @php
        $selectedIndexValue = is_array($indices_name ?? null) ? ($indices_name[0] ?? '') : ($indices_name ?? '');
    @endphp
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <div class="head_brdcm">
                    <ul class="brdcmb">
                        <li><a href="{{ route('user.auth-dashboard') }}">dashboard</a></li>
                        <li><a href="{{ route('user.indices_report') }}">indices report</a></li>
                        <li>Indices Composition</li>
                    </ul>
                </div>
                <div class="new_page">
                    <a href="#" class="back_btn"><i class="fa-solid fa-arrow-left"></i></a>

                    <div class="light_green_bg">
                        <form action="" id="indices-composition-form" novalidate>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <select class="select2" name="indices" id="indices" data-placeholder="Select Indices">
                                            <option value="">Select Indices</option>
                                            @foreach ($indices as $index)
                                                <option value="{{ $index->corelation }}"
                                                    @if ($selectedIndexValue !== '' && $index->corelation == $selectedIndexValue) selected @endif>{{ $index->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <input type="text" class="datepicker" placeholder="End Date">
                                    </div>
                                </div> --}}

                                @include('web.layout.includes.year_month', [
                                    'yearFieldName' => 'year',
                                    'monthFieldName' => 'month',
                                    'selectedYear' => $year ?? '',
                                    'selectedMonth' => $month ?? '',
                                    'size' => 3,
                                ])

                                <div class="col-md-2">
                                    <div class="bttn_grp">
                                        <button type="submit" id="classification">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (!empty($message))
                        <div class="alert alert-warning mt-3">
                            {{ $message }}
                        </div>
                    @endif
                    @if (isset($indices_composition))
                        <div class="fund_section new_fund_section">
                            <ul>
                                <li>
                                    <p>Benchmark :</p>
                                    <span>{{ $selectedIndexValue }}</span>
                                </li>
                                <li>
                                    <p>Indices Composition : </p>
                                    @if (isset($year) && isset($month))
                                        <span>For the Month of {{ date('F', mktime(0, 0, 0, $month, 1, $year)) }},
                                            {{ $year }}</span>
                                    @endif

                                </li>
                            </ul>
                        </div>

                        <div class="graph_table">
                            <div class="share_pdf">
                                    
                                <div class="sharethis-inline-share-buttons" ></div>
                                <a href="javascript:void(0)" id="exportPDF-indices-composition" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" ></a>
                                
                            </div>
                            <table class="table datatable" id="pdfData-indices-composition">
                                <thead>
                                    <tr>
                                        <th>name of the scrip</th>
                                        <th>type</th>
                                        <th>industry</th>
                                        <th class="text_center">percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($indices_composition)
                                        @foreach ($indices_composition as $item)
                                            <tr>
                                                <td>{{ $item['scrip_name'] }}</td>
                                                <td>{{ $item['type'] }}</td>
                                                <td>{{ $item['industry'] }}</td>
                                                <td class="text_right">{{ number_format($item['percentage'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endisset

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="graph_section">
                            <p style="text-align: center;">Please search above to show the results</p>
                        </div>
                    @endif
                </div>
                @if (isset($indices_composition))
                <div class="disclaimer">
                    <p><strong>Disclaimer : </strong>{{ $disclaimer }}</p>
                </div>
              @endif
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() 
    {
        var form = document.getElementById('indices-composition-form');
        var indexSelect = document.getElementById('indices');
        var monthSelect = document.getElementById('month');
        var yearSelect = document.getElementById('year');

        function openSelect2(selectElement) {
            if (window.jQuery && $.fn.select2 && selectElement) {
                $(selectElement).select2('open');
            } else if (selectElement) {
                selectElement.focus();
            }
        }

        if (yearSelect && monthSelect) {
            $(yearSelect).on('change select2:select', function() {
                if (this.value && !monthSelect.value) {
                    openSelect2(monthSelect);
                }
            });
        }

        if (form) {
            form.addEventListener('submit', function(event) {
                if (indexSelect && !indexSelect.value) {
                    event.preventDefault();
                    openSelect2(indexSelect);
                    return;
                }

                if (yearSelect && !yearSelect.value) {
                    event.preventDefault();
                    openSelect2(yearSelect);
                    return;
                }

                if (monthSelect && !monthSelect.value) {
                    event.preventDefault();
                    openSelect2(monthSelect);
                }
            });
        }

        var exportButton = document.getElementById('exportPDF-indices-composition');

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
                doc.text('Indices Composition', pageWidth / 2, 35, { align: 'center' });

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);

                // Add the benchmark name
                var benchmarkName = "{{ $selectedIndexValue }}";
                doc.text(`Benchmark: ${benchmarkName}`, 15, 50);

                // Add the date (Month and Year)
                @if (isset($month) && isset($year))
                    var compositionDate = `For the Month of {{ date('F', mktime(0, 0, 0, $month, 1)) }}, {{ $year }}`;
                    // doc.text(compositionDate, 15, 60);
                    doc.text(`Indices Composition: ${compositionDate}`, 15, 60);
                @endif

                var yPosition = 70;

                
                var table = document.getElementById('pdfData-indices-composition');
                var tableData = [];

                table.querySelectorAll('tbody tr').forEach(function(row) {
                    var rowData = [];
                    row.querySelectorAll('td').forEach(function(cell) {
                        rowData.push(cell.innerText);
                    });
                    tableData.push(rowData);
                });

                doc.autoTable({
                    head: [['Name Of The Scrip', 'Type', 'Industry', 'Percentage']],
                    body: tableData,
                    startX: 15,
                    startY: yPosition + 10,
                    headStyles: { fillColor: [45, 135, 23] },
                    columnStyles: {
                        3: { halign: 'right' }
                    }
                });

                var currentDate = new Date();
                // var fileName = 'Indices-Composition-' + currentDate.toISOString().split('T')[0] + '.pdf';
                var fileName = 'Indices-Composition-' + currentDate + '.pdf';
            
                doc.save(fileName);
            };
        });
    });
</script>
