<?php if(isset($dataArr['meta_title'])): ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['meta_title']); ?><?php $__env->stopSection(); ?>
<?php else: ?>
<?php $__env->startSection('page-title'); ?><?php echo e($dataArr['title']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_key'])): ?>
<?php $__env->startSection('meta-keywords'); ?><?php echo e($dataArr['meta_key']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['meta_descp'])): ?>
<?php $__env->startSection('meta-description'); ?><?php echo e($dataArr['meta_descp']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if(isset($dataArr['image_path'])): ?>
<?php $__env->startSection('meta-image'); ?><?php echo e($dataArr['image_path']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>
<?php if($dataArr['full_url']): ?>
<?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- <div id="vue-app">
    <weekly-snapshot page_title="<?php echo e($dataArr['title']); ?>"  page_description="<?php echo e($dataArr['descp']); ?>" page_image="<?php echo e($dataArr['image_path']); ?>" image_path="<?php echo e(asset('themes/frontend/assets/v1/img/')); ?>"></weekly-snapshot>
<div class="clearfix">&nbsp;</div>
</div> -->



<div class="custom-banner no-bg fw-bannerfund-portfolio-banner monthly-ranking monthly-snapshot-banner">
    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4>Weekly Snapshot</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="monthly_snapshop_sec">
    <div class="container">
        <div class="fund-c-analysis m-t-30 m-b-30 monthly-compo">
            <div class="container p-0">
                <div class="snapshot_inner">
                    <div class="snapshot_header" style="padding: 0px 3px;">
                        <p>Weekly Snapshot Report: <?php echo e(date('d/m/Y', strtotime($from_date))); ?> to <?php echo e(date('d/m/Y', strtotime($to_date))); ?></p>
                    </div>
                    <div class="perform-paramtr monthly-compo-wrap weekly-snapshot-cols">
                        <div class="row perform-pmtr-lumpsum">
                            <?php for($i=1;$i<=3;$i++): ?>
                                <div class="col-lg-4 col-md-12 col-sm-12 box_border_right">
                                <div class="dy-table-wrap">
                                    <div class="dy-table-block br-5 index_changes_header">
                                        <h4><?php if($i==1): ?><?php echo e(' BSE Index'); ?><?php elseif($i==2): ?><?php echo e(' NSE Index'); ?><?php else: ?><?php echo e(' Global & Sectoral Index'); ?><?php endif; ?></h4>
                                        <div class="changes_table">
                                            <table id="best-monthly-index" class="table display dataTable no-footer table-striped table-responsive box-shadow">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting sorting_asc">Indices <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="sorting">Closing Value <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        <th class="sorting">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($i==1): ?>
                                                    <?php $__currentLoopData = $data['array_bse']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        
                                                        <td><?php echo e($indices_details->name); ?></td>
                                                        <td class="text_right"><?php echo e(printValue($indices_details->cur_value)); ?></td>
                                                        <td class="text_right"><?php echo e(printValue($indices_details->PER_CHANGE)); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php elseif($i==2): ?>
                                                    <?php $__currentLoopData = $data['array_nse']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        
                                                        <td><?php echo e($indices_details->name); ?></td>

                                                        <td class="text_right"><?php echo e(printValue($indices_details->cur_value)); ?></td>
                                                        <td class="text_right"><?php echo e(printValue($indices_details->PER_CHANGE)); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <?php $__currentLoopData = $data['array_global_it']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indices_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        

                                                        <td><?php echo e($indices_details->name); ?></td>

                                                        <td class="text_right"><?php echo e(printValue($indices_details->cur_value)); ?></td>
                                                        <td class="text_right"><?php echo e(printValue($indices_details->PER_CHANGE)); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php endfor; ?>
                        <div class="col-lg-4 col-md-12 col-sm-12 box_border_right">
                            <div class="dy-table-wrap">
                                <div class="dy-table-block br-5 index_changes_header">
                                    <h4>Currency Changes</h4>
                                    <div class="changes_table">
                                        <table id="best-currency" class="table display dataTable no-footer table-striped table-responsive box-shadow">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc">Currency <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">₹ <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $data['changes_currency']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curr_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($curr_details->name); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($curr_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($curr_details->PER_CHANGE)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 box_border_right">
                            <div class="dy-table-wrap">
                                <div class="dy-table-block br-5 index_changes_header">
                                    <h4>Commodity Changes</h4>
                                    <div class="changes_table">
                                        <table id="best-commodity" class="table display dataTable no-footer table-striped table-responsive box-shadow">
                                            <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc">Commodity <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">₹ <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                    <th class="sorting">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $data['changes_commodity']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commodity_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($commodity_details->name); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($commodity_details->cur_value)); ?></td>
                                                    <td class="text_right"><?php echo e(printValue($commodity_details->PER_CHANGE)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 fund-c-analysis m-t-30 custom-sort-table monthly-snap-full weekly-snapshot-blocks">
        <div class="snapshot_inner">
            <div class="container p-0">
                <div class="perform-paramtr c-snapchot-parent">
                    <div class="col-lg-12 col-md-12 col-sm-12 perform-pmtr-lumpsum">
                        <div class="dy-table-wrap">
                            <div class="dy-table-block br-5 total-table hide-table">
                                <div class="row m-0">
                                    <div class="col-lg-6 col-md-12 col-sm-12 pl-0 weekly-table-block-one">
                                        <div class="changes_table ws-table-wrap">
                                            <div class="table-top opened"><!-- <div class="table-top opened" > -->
                                                <div class="main_trer monthly_snap_shot_table">
                                                    <div class="dy-table-block br-5 index_changes_header">
                                                        <h4>Percentage Change by Category of Funds</h4>
                                                    </div>
                                                </div><!-- <div class="align-right-block"><img src="../../images/toggle-arrow.png" /></div> -->
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table dataTable no-footer table-striped" role="grid">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting" style="width: 47% !important;">Fund Category <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            <th class="sorting">% Change <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            <th class="sorting">Median <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $data['weekly_benchmark']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benchmark_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="open_popup2 cursor-pointer" FundTypeID="<?php echo e($benchmark_details->FundTypeID); ?>" data-bs-toggle="modal" data-bs-target="#reject"><?php echo e($benchmark_details->FUNDTYPE); ?></td>
                                                            <td class="text_right"><?php echo e(number_format($benchmark_details->CHANGEVALUE,2)); ?></td>
                                                            <td class="text_right"><?php echo e(number_format($benchmark_details->MEDIANVAL,2)); ?></td>
                                                        </tr>
                                                        
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 pr-0 weekly-table-block-two">
                                        <div class="changes_table ws-table-wrap">
                                            <div class="table-top opened">
                                                <div class="main_trer monthly_snap_shot_table">
                                                    <div class="dy-table-block br-5 index_changes_header">
                                                        <h4>10 Best Performing Schemes</h4>
                                                    </div><!-- <div class="align-right-block"><img src="../../images/toggle-arrow.png" /></div> -->
                                                    <table id="best-funds" class="table display dataTable no-footer table-striped table-responsive box-shadow">
                                                        <thead>
                                                            <tr>
                                                                <th class="sorting sorting_asc">Scheme Name <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                                <th class="sorting">Category <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                                <th class="sorting">Return % <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__currentLoopData = $data['best_schemes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($scheme_details->fund_name); ?></td>
                                                                <td><?php echo e($scheme_details->name); ?></td>
                                                                <td class="text_right"><?php echo e(printValue($scheme_details->weekly_change)); ?></td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" placeholder="As on Date" name="date" id="dateInput" value="<?php echo e($to_date); ?>">
                <input type="hidden" value="weekly" name="type" id="type">

                <div class="modal fade fade" id="reject" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content fund-c-analysis">
                            <div class="modal-header">
                                <h6 class="">Fund Changes</h6><button type="button" class="close" data-bs-dismiss="modal">×</button>
                            </div>
                            <div class="modal-body perform-paramtr c-snapchot-parent">
                                <div class="changes_table dy-table-wrap">
                                    <div class="dy-table-block br-5">


                                        <table class="table display dataTable no-footer table-striped table-responsive box-shadow pop_up_datatable">
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
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <div class="popup-overlay"></div>
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
                    </div> -->



            </div>
        </div>
    </div><!-- </div> -->
    </div>
</section>

<script src="https://myplexus.com/themes/frontend/assets/v1/js/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    var table = new DataTable('.table', {
        info: false,
        ordering: true,
        paging: false,
        searching: false,
    });


    $(".open_popup2").click(function() {
        var FundTypeID = $(this).attr('FundTypeID');
        var dateInputValue = $("#dateInput").val();
        var typeValue = $("#type").val();

        var html = null;

        $.ajax({
            url: '/getChangesFundNew',
            method: 'GET',
            data: {
                fund_type_id: FundTypeID,
                date: dateInputValue,
                type: typeValue
            },
            success: function(response) {
                console.log(response)
                if ($.fn.DataTable.isDataTable('.pop_up_datatable')) {
                    $('.pop_up_datatable').DataTable().clear().destroy();
                }

                // Append data rows
                if (response.changes_fund && response.changes_fund.length > 0) {
                    $.each(response.changes_fund, function(index, fund) {
                        html += '<tr>';
                        html += '<td>' + fund.fund_name + '</td>';
                        html += '<td>' + parseFloat(fund.change_value).toFixed(2) + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="2">No data found</td></tr>';
                }

                $('.pop_up_datatable tbody').html(html);

                $('.pop_up_datatable').DataTable({
                    searching: false,
                    paging: false,
                    info: false
                });

                //$(".popup-overlay, .table_popup").show();
            },
            error: function(xhr, status, error) {

                console.error(error);
            }
        });

        // $(".popup-overlay, .table_popup").show();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/weekly-snapshot.blade.php ENDPATH**/ ?>