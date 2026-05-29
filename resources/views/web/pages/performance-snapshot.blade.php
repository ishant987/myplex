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

@section('vue-js') @stop
@section('content')
<div class="custom-banner no-bg fw-banner @if(!$dataArr['image_path']) fund-portfolio-banner  @endif" @if($dataArr['image_path']) style="background-image:url({{$dataArr['image_path']}})" @endif>

    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4>{{$dataArr['title']}}</h4>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- <div id="vue-app">
    <performance-snapshot page_title="{{$dataArr['title']}}"  page_description="{{$dataArr['descp']}}" page_image="{{ $dataArr['image_path'] }}"></performance-snapshot>
</div> -->


<section class="info_monitor_sec">
    <div class="compare-scemes-sec investing-tools perform-snapshot-tabs select2-styles">
        <div class="container tab_snap_shot new-shot scnd-shot">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item" role="presentation"><a class="nav-link @if((isset($request->type) && ($request->type == 'weekly')) || !isset($request->type)) active @endif" href="/performance-snapshot?fund_type_id={{$request->fund_type_id}}&type=weekly&report_category={{$request->report_category}}&date={{$request->date}}"> Weekly </a></li>
                <li class="nav-item" role="presentation"><a class="nav-link @if(isset($request->type) && ($request->type == 'monthly')) active @endif" href="/performance-snapshot?fund_type_id={{$request->fund_type_id}}&type=monthly&report_category={{$request->report_category}}&date={{$request->date}}"> Monthly </a></li>
            </ul>
            <div class="comp_schem_bdr">
                <div class="tab_snap_shot">
                    <div class="tab-wrapper">
                        <div class="tab-content">
                            <div id="" class="tab-pane fade in active show">
                                <form action="#" method="get">
                                    <div class="invst-wrap wrp-new">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div class="dp__main dp__theme_light custom-input readonly-datepicker">
                                                    <input type="text" placeholder="As on Date" class="datepicker custom-input" name="date"
                                                id="dateInput" value="@if(isset($request->date)) {{$request->date}} @endif">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div tabindex="-1" class="multiselect" role="combobox" aria-owns="listbox-null">
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
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                            <select id="report-category" name="report_category"
                                            data-placeholder="Select" class="custom-input">
                                                <option value="">Select</option>
                                                <option value="return" @if(isset($request->report_category) && $request->report_category == 'return') selected @endif>Return %</option>
                                                <option value="indices" @if(isset($request->report_category) && $request->report_category == 'indices') selected @endif>Indices</option>
                                                <option value="return_less_index" @if(isset($request->report_category) && $request->report_category == 'return_less_index') selected @endif>Return Less Index</option>
                                                @if(isset($request->type) && $request->type == 'monthly')
                                                <option value="corpus_change" @if(isset($request->report_category) && $request->report_category == 'corpus_change') selected @endif>Corpus Changes</option>
                                                @endif
                                            </select>
                                            </div>
                                            <input type="hidden" name="type" id="type" value="{{$responseArr['type']}}">
                                            <div class="col-3 text-center px-0"><button type="submit" class="perform-submit money_title_btn btn">Submit</button></div>
                                        </div>
                                    </div>
                                </form><!--v-if-->
                                <div class="datatable_ll main_trer fund_performance_table perform-snapshot-table full-table-style-2 custom-sort-table main-trer-wrapper">
                                    <div class="share_pdf">
                                        <div class="sharethis-inline-share-buttons" ></div>
                                        <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                                src="{{ asset('themes/frontend/assets/infosolz/images/pdf.png') }}" width="24"></a>
                                    </div>
                                    <div class="row bordr-only mb-2">
										<div class="col-md-6 col-lg-4 mb-2"><b>Type:</b> 
                                            @if (isset($request->type))
                                                @switch($request->type)
                                                    @case('weekly')
                                                    Weekly
                                                    @break

                                                    @case('monthly')
                                                    Monthly
                                                    @break
                                                    
                                                @endswitch
                                            @endif
                                        </div>
										<div class="col-md-6 col-lg-4 mb-2"><b>As On: </b>{{ isset($request->date) ? date('d/m/Y', strtotime($request->date)) : '00/00/0000' }} </div>
										<div class="col-md-6 col-lg-4 mb-2"><b>By:</b> 
                                            @if (isset($request->report_category))
                                                @switch($request->report_category)
                                                    @case('return')
                                                        Return %
                                                    @break

                                                    @case('indices')
                                                        Indices
                                                    @break

                                                    @case('return_less_index')
                                                        Return Less Index
                                                    @break

                                                    @case('corpus_change')
                                                        Corpus Change
                                                    @break
                                                    
                                                @endswitch
                                            @endif
                                        </div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Fund Classification:</b> {{ isset($request_fund_type->name) ? $request_fund_type->name : '' }} </div>
									</div>	
                                    

                                    @if(isset($request->type) && ($request->type == 'weekly'))
                                    @if(isset($responseArr) && ($request->report_category == 'return'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-return">
                                        
                                            <table id="performance-weekly" class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                    <th class="sorting sorting_asc">Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">Index Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">Daily <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">7 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">14 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">30 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">60 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td>{{$quickRatio->fund_name}}</td>
                                                                <td>{{ $quickRatio->indices_name }}</td>

                                                                <td class="text_right">{{ is_numeric(printValue($quickRatio->{'1DAYS'}))?printValue($quickRatio->{'1DAYS'}):' ' }}</td>
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
                                            <table id="performance-weekly" class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting sorting_asc">Index Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="sorting">7 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="sorting">14 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="sorting">30 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="sorting">60 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
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
                                            <table id="performance-weekly" class="display w-100 dataTable">
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
                                                                <td>{{$quickRatio->fund_name}}</td>
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


                                    <!-- ========Molthly====== -->
                                    
                                    @if(isset($request->type) && ($request->type == 'monthly'))
                                    @if(isset($responseArr) && ($request->report_category == 'return'))
                                        @if(isset($responseArr['snapshot_data']))
                                        <div class="weekly-return">
                                            <table class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th>Index Name  <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Six Months <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">One Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Two Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Three Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td>{{$quickRatio->fund_name}}</td>
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
                                            <table class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Index Name  <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Six Months <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">One Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Two Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Three Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
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
                                            <table class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Six Months <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">One Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Two Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Three Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td>{{$quickRatio->fund_name}}</td>
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
                                            <table class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Current Amount (Rs.in Crores) <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">Change Amount (Rs.in Crores) <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center"> (%) Change  <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($responseArr['snapshot_data']))
                                                        @foreach ($responseArr['snapshot_data'] as $quickRatio)
                                                            <tr>
                                                                <td>{{$quickRatio->fund_name}}</td>
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
                                            <table class="display w-100 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fund Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">7 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">14 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">30 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="text_center">60 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://myplexus.com/themes/frontend/assets/v1/js/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    var table = new DataTable('.dataTable', {
        info: false,
        ordering: true,
        paging: false,
        searching: false,
    });

    
</script>
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
            img.src = (window.myplexBranding && window.myplexBranding.logoUrl) ? window.myplexBranding.logoUrl : "{{ asset('themes/frontend/assets/infosolz/images/small_logo.png') }}";
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

                //var table = new DataTable('.dataTable');
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

@stop
