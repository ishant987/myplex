@extends('web.layout.app')
@if(isset($dataArr['meta_title']))
@section('page-title'){{$dataArr['meta_title']}}@stop
@else
@section('page-title'){{$dataArr['title']}}@stop
@endif
@if(isset($dataArr['meta_key']))
@section('meta-keywords'){{$dataArr['meta_key']}}@stop
@endif
@if(isset($dataArr['meta_descp']))
@section('meta-description'){{$dataArr['meta_descp']}}@stop
@endif
@if(isset($dataArr['image_path']))
@section('meta-image'){{$dataArr['image_path']}}@stop
@endif
@if($dataArr['full_url'])
@section('cur-url'){{$dataArr['full_url']}}@stop
@endif

<!-- @section('vue-js') @stop -->
@section('content')

<!-- <div id="vue-app">
    <fund-composition-snapshot page_title="{{$dataArr['title']}}"  page_description="{{$dataArr['descp']}}" page_image="{{ $dataArr['image_path'] }}">
        </fund-composition-snapshot>
    </div> -->
<div class="custom-banner no-bg fw-banner monthly-ranking">
    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4>Composition Snapshot</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<section class="info_monitor_sec">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div tabindex="-1" class="multiselect" role="combobox" aria-owns="listbox-null">

                    <select name="fund_type_id" id="fund_type_id" class="select2"
                        data-placeholder="Select Fund Category" onchange="window.location.href='composition-snapshot?fund_type_id='+this.value ">
                        <option value="">Select Fund Classification</option>
                        @if (isset($fund_types))
                        @foreach ($fund_types as $val)
                        <option value="{{ $val->ft_id }}"
                            {{ isset($fund_type_id) && $fund_type_id == $val->ft_id ? 'selected' : '' }}>
                            {{ $val->name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="banner-align-rgt fw-downlaod-btn"></div>
            </div>
        </div>
        @if (!empty($heading_name)) <p class="sub_gren_title">
            Composition Snapshot of: <span>{{$heading_name}}</span>
        <div class="share_pdf" style="position: relative;  display: flex; align-items: center; gap: 10px;">

            <div class="sharethis-inline-share-buttons"></div>
            <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="{{asset('themes/frontend/assets/infosolz/images/pdf.png')}}" width="24"></a>

        </div>

        </p>@endif

        <div class="row">
            <div class="col-md-12">
                <div class="info_monitor_inner">
                    <div class="info_monitor_inner_wrapper mb-3">
                        <div class="monthly_ranking_table">
                            <div class="datatable_ll main_trer">
                                <div class="table-responsive">
                                    <div id="example_wrapper" class="dataTables_wrapper no-footer">
                                        <!-- <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span> -->
                                        <table class="table datatable table-striped" id="pdfData">

                                            <thead>
                                                <tr>
                                                    <th colspan="2" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"></th>
                                                    <th colspan="2" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"> Debt </th>
                                                    <th colspan="4" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"> Equity </th>
                                                    <th colspan="1" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"></th>
                                                    <th colspan="1" rowspan="1" style="background-color: rgb(34, 34, 34) !important;"></th>
                                                </tr>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Name of the Fund : activate to sort column descending" width="20%" style="text-align: left; width: 214px;" aria-sort="ascending"> Name of the Fund <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Cash% : activate to sort column ascending" width="9%" style="text-align: left; width: 80px;"> Cash% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Sov% : activate to sort column ascending" width="9%" style="text-align: left; width: 80px;"> Sov% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Corp Debt% : activate to sort column ascending" style="text-align: left; width: 82px;"> Corp <br>Debt% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Small Cap% : activate to sort column ascending" style="text-align: left; width: 74px;"> Small <br>Cap% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Mid Cap% : activate to sort column ascending" style="text-align: left; width: 74px;"> Mid <br>Cap% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Large Cap% : activate to sort column ascending" style="text-align: left; width: 74px;"> Large<br> Cap% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Very Large Cap&amp;nbsp;% : activate to sort column ascending" style="text-align: left; width: 83px;"> Very Large<br> Cap&nbsp;% <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Others : activate to sort column ascending" width="9%" style="text-align: left; width: 80px;"> Others <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=" Wt&amp;nbsp;PE : activate to sort column ascending" width="9%" style="text-align: left; width: 80px;"> Wt&nbsp;PE <span class="filter__arrow"><a href="javascript:void(0)"><i class="ph-arrows-down-up-bold"></i></a></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($fund_snapshot))
                                                @foreach ($fund_snapshot as $item)
                                                    @if(in_array($item->fund_name,$fundsArr))
                                                <tr>
                                                    <td class="text_left">{{ $item->fund_name }}</td>
                                                    <td class="text_right">{{ $item->cash }}</td>
                                                    <td class="text_right">{{ $item->sov }}</td>
                                                    <td class="text_right">{{ $item->debt }}</td>
                                                    <td class="text_right">{{ $item->eq_small }}</td>
                                                    <td class="text_right">{{ $item->eq_mid }}</td>
                                                    <td class="text_right">{{ $item->eq_large }}</td>
                                                    <td class="text_right">{{ $item->eq_very_large }}</td>
                                                    <td class="text_right">{{ $item->others_val }}</td>
                                                    <td class="text_right">{{ $item->wt_pe }}</td>
                                                </tr>
                                                    @endif
                                                @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div><!--v-if-->
                                </div>
                            </div>
                        </div>
                        <div class="classification-disc">
                            <h6 class="text-green">Disclaimer</h6>
                            <ul>
                                <li> For loss making scrips, earnings are considered as zero. </li>
                                <li> Loss Making Scrips have not been taken into account for calculation of total fund portfolio weighted PE. </li>
                                <li> Equity Mutual Fund and ETF are added to Others </li>
                                <li> P/E Ratio(TTM) is considered for calculating weighted PE </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://myplexus.com/themes/frontend/assets/v1/js/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    var table = new DataTable('#pdfData', {
        info: false,
        ordering: true,
        paging: false,
        searching: false,
    });

    document.addEventListener('DOMContentLoaded', function() {
        var exportButton = document.getElementById('exportPDF');

        exportButton.addEventListener('click', function() {
            var {
                jsPDF
            } = window.jspdf;
            var doc = new jsPDF();

            // Load logo image
            var img = new Image();
            img.src = (window.myplexBranding && window.myplexBranding.logoUrl) ? window.myplexBranding.logoUrl : "{{ asset('themes/frontend/assets/infosolz/images/small_logo.png') }}";
            img.onload = function() {
                var pageWidth = doc.internal.pageSize.getWidth();
                var imgWidth = 50;
                var imgHeight = 20;
                var centerX = (pageWidth - imgWidth) / 2;

                doc.addImage(img, 'PNG', centerX, 10, imgWidth, imgHeight);

                doc.setFontSize(16);
                doc.setTextColor(45, 135, 23);
                doc.text('Alloction Snaoshot', pageWidth / 2, 35, {
                    align: 'center'
                });

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

                
                var fundClassification = "{{ isset($fund_type_name) ? $fund_type_name[0] : '' }}";
                if (fundClassification) {
                    doc.text('Fund Classification:', startX, yPosition);
                    doc.text(fundClassification, startX + 100, yPosition);
                    yPosition += lineHeight;
                }
                

              

                var table = new DataTable('#pdfData');
                var tableData = [];
                table.rows({
                    search: 'applied'
                }).data().each(function(row) {
                    tableData.push(row);
                });

                doc.autoTable({
                    head: [
                        [{
                                content: '',
                                colSpan: 4
                            },
                            {
                                content: 'Equity',
                                colSpan: 4,
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: '',
                                colSpan: 2
                            }
                        ],
                        [{
                                content: 'Name of the Fund',
                                styles: {
                                    halign: 'left'
                                }
                            },
                            {
                                content: 'Cash %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'SOV %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Corp debt %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Small cap %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Mid cap %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Large cap %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Very large cap %',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Others',
                                styles: {
                                    halign: 'center'
                                }
                            },
                            {
                                content: 'Wt. PE',
                                styles: {
                                    halign: 'center'
                                }
                            }
                        ]
                    ],
                    body: tableData,
                    startX: startX,
                    startY: yPosition + 10,
                    headStyles: {
                        fillColor: [45, 135, 23],
                        textColor: [255, 255, 255]
                    },
                    styles: {
                        halign: 'center'
                    }
                });

                // Save the PDF with a generated filename
                var currentDate = new Date();
                var fileName = 'Alloction-Snaoshot-' + currentDate + '.pdf';
                doc.save(fileName);
            };
        });
    });
</script>
@stop
