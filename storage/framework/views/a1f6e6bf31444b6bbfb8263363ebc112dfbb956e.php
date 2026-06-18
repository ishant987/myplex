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
<div class="custom-banner no-bg fw-banner <?php if(!$dataArr['image_path']): ?> fund-portfolio-banner  <?php endif; ?>" <?php if($dataArr['image_path']): ?> style="background-image:url(<?php echo e($dataArr['image_path']); ?>)" <?php endif; ?>>

    <section class="inner_banner_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner_section_banner">
                        <h4><?php echo e($dataArr['title']); ?></h4>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- <div id="vue-app">
    <performance-snapshot page_title="<?php echo e($dataArr['title']); ?>"  page_description="<?php echo e($dataArr['descp']); ?>" page_image="<?php echo e($dataArr['image_path']); ?>"></performance-snapshot>
</div> -->


<section class="info_monitor_sec">
    <div class="compare-scemes-sec investing-tools perform-snapshot-tabs select2-styles">
        <div class="container tab_snap_shot new-shot scnd-shot">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item" role="presentation"><a class="nav-link <?php if((isset($request->type) && ($request->type == 'weekly')) || !isset($request->type)): ?> active <?php endif; ?>" href="/performance-snapshot?fund_type_id=<?php echo e($request->fund_type_id); ?>&type=weekly&report_category=<?php echo e($request->report_category); ?>&date=<?php echo e($request->date); ?>"> Weekly </a></li>
                <li class="nav-item" role="presentation"><a class="nav-link <?php if(isset($request->type) && ($request->type == 'monthly')): ?> active <?php endif; ?>" href="/performance-snapshot?fund_type_id=<?php echo e($request->fund_type_id); ?>&type=monthly&report_category=<?php echo e($request->report_category); ?>&date=<?php echo e($request->date); ?>"> Monthly </a></li>
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
                                                id="dateInput" value="<?php if(isset($request->date)): ?> <?php echo e($request->date); ?> <?php endif; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div tabindex="-1" class="multiselect" role="combobox" aria-owns="listbox-null">
                                                    <select name="fund_type_id" class="select2"
                                                        data-placeholder="Select Fund Classification">
                                                        <option value=""></option>
                                                        <?php $__currentLoopData = $all_fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($fund_type->ft_id); ?>"
                                                            <?php if($fund_type->ft_id == old('fund_type_id', $request->fund_type_id)): ?> selected <?php endif; ?>>
                                                            <?php echo e($fund_type->name); ?>

                                                        </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                            <select id="report-category" name="report_category"
                                            data-placeholder="Select" class="custom-input">
                                                <option value="">Select</option>
                                                <option value="return" <?php if(isset($request->report_category) && $request->report_category == 'return'): ?> selected <?php endif; ?>>Return %</option>
                                                <option value="indices" <?php if(isset($request->report_category) && $request->report_category == 'indices'): ?> selected <?php endif; ?>>Indices</option>
                                                <option value="return_less_index" <?php if(isset($request->report_category) && $request->report_category == 'return_less_index'): ?> selected <?php endif; ?>>Return Less Index</option>
                                                <?php if(isset($request->type) && $request->type == 'monthly'): ?>
                                                <option value="corpus_change" <?php if(isset($request->report_category) && $request->report_category == 'corpus_change'): ?> selected <?php endif; ?>>Corpus Changes</option>
                                                <?php endif; ?>
                                            </select>
                                            </div>
                                            <input type="hidden" name="type" id="type" value="<?php echo e($responseArr['type']); ?>">
                                            <div class="col-3 text-center px-0"><button type="submit" class="perform-submit money_title_btn btn">Submit</button></div>
                                        </div>
                                    </div>
                                </form><!--v-if-->
                                <div class="datatable_ll main_trer fund_performance_table perform-snapshot-table full-table-style-2 custom-sort-table main-trer-wrapper">
                                    <div class="share_pdf">
                                        <div class="sharethis-inline-share-buttons" ></div>
                                        <a href="javascript:void(0)" id="exportPDF" class="pdf"><img
                                                src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" width="24"></a>
                                    </div>
                                    <div class="row bordr-only mb-2">
										<div class="col-md-6 col-lg-4 mb-2"><b>Type:</b> 
                                            <?php if(isset($request->type)): ?>
                                                <?php switch($request->type):
                                                    case ('weekly'): ?>
                                                    Weekly
                                                    <?php break; ?>

                                                    <?php case ('monthly'): ?>
                                                    Monthly
                                                    <?php break; ?>
                                                    
                                                <?php endswitch; ?>
                                            <?php endif; ?>
                                        </div>
										<div class="col-md-6 col-lg-4 mb-2"><b>As On: </b><?php echo e(isset($request->date) ? date('d/m/Y', strtotime($request->date)) : '00/00/0000'); ?> </div>
										<div class="col-md-6 col-lg-4 mb-2"><b>By:</b> 
                                            <?php if(isset($request->report_category)): ?>
                                                <?php switch($request->report_category):
                                                    case ('return'): ?>
                                                        Return %
                                                    <?php break; ?>

                                                    <?php case ('indices'): ?>
                                                        Indices
                                                    <?php break; ?>

                                                    <?php case ('return_less_index'): ?>
                                                        Return Less Index
                                                    <?php break; ?>

                                                    <?php case ('corpus_change'): ?>
                                                        Corpus Change
                                                    <?php break; ?>
                                                    
                                                <?php endswitch; ?>
                                            <?php endif; ?>
                                        </div>
										<div class="col-md-6 col-lg-4 mb-2"><b>Fund Classification:</b> <?php echo e(isset($request_fund_type->name) ? $request_fund_type->name : ''); ?> </div>
									</div>	
                                    

                                    <?php if(isset($request->type) && ($request->type == 'weekly')): ?>
                                    <?php if(isset($responseArr) && ($request->report_category == 'return')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->fund_name); ?></td>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>

                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'1DAYS'}))?printValue($quickRatio->{'1DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'indices')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'return_less_index')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->fund_name); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'7DAYS'}))?printValue($quickRatio->{'7DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'14DAYS'}))?printValue($quickRatio->{'14DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'30DAYS'}))?printValue($quickRatio->{'30DAYS'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'60DAYS'}))?printValue($quickRatio->{'60DAYS'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php endif; ?>


                                    <!-- ========Molthly====== -->
                                    
                                    <?php if(isset($request->type) && ($request->type == 'monthly')): ?>
                                    <?php if(isset($responseArr) && ($request->report_category == 'return')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->fund_name); ?></td>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>

                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'indices')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->indices_name); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($responseArr) && ($request->report_category == 'return_less_index')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->fund_name); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'sixmonths'}))?printValue($quickRatio->{'sixmonths'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'oneyear'}))?printValue($quickRatio->{'oneyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'twoyear'}))?printValue($quickRatio->{'twoyear'}):' '); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'threeyear'}))?printValue($quickRatio->{'threeyear'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(isset($responseArr) && ($request->report_category == 'corpus_change')): ?>
                                        <?php if(isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($quickRatio->fund_name); ?></td>
                                                                <td class="text_right"><?php echo e(printValue($quickRatio->corpus_entry/100)); ?></td>
                                                                <td class="text_right"><?php echo e(printValue($quickRatio->corpus_change/100)); ?></td>
                                                                <td class="text_right"><?php echo e(is_numeric(printValue($quickRatio->{'percentage_change'}))?printValue($quickRatio->{'percentage_change'}):' '); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php endif; ?>

                                    <!-- ======End Molthly====== -->
                                     
                                    <?php if(!isset($responseArr['snapshot_data'])): ?>
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
                                                    <?php if(isset($responseArr['snapshot_data'])): ?>
                                                        <?php $__currentLoopData = $responseArr['snapshot_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickRatio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td colspan="7" class="text-center">No information is available for this search</td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
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
            img.src = (window.myplexBranding && window.myplexBranding.logoUrl) ? window.myplexBranding.logoUrl : "<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>";
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
                    "<?php echo e(isset($request->date) ? date('d/m/Y', strtotime($request->date)) : '00/00/0000'); ?>";
                
                    var ratio =
                    <?php if(isset($request->report_category)): ?>
                        <?php switch($request->report_category):
                            case ('return'): ?>
                            'Return %'
                            <?php break; ?>

                            <?php case ('indices'): ?>
                            'Indices'
                            <?php break; ?>

                            <?php case ('return_less_index'): ?>
                            'Return Less Index'
                            <?php break; ?>

                            <?php case ('corpus_change'): ?>
                            'Corpus Change'
                            <?php break; ?>
                            
                        <?php endswitch; ?>
                    <?php endif; ?> ;

                    var type =
                    <?php if(isset($request->type)): ?>
                        <?php switch($request->type):
                            case ('weekly'): ?>
                            'Weekly'
                            <?php break; ?>

                            <?php case ('monthly'): ?>
                            'Monthly'
                            <?php break; ?>
                            
                        <?php endswitch; ?>
                    <?php endif; ?> ;

                var fundClassification = "<?php echo e(isset($request_fund_type->name) ? $request_fund_type->name : ''); ?>";

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
                <?php if(isset($request->type) && $request->type =='weekly'): ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return'): ?>
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
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='indices'): ?>
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
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return_less_index'): ?>
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
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(isset($request->type) && $request->type =='monthly'): ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return'): ?>
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
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='indices'): ?>
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
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='return_less_index'): ?>
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
                    <?php endif; ?>
                    <?php if(isset($request->report_category) && $request->report_category =='corpus_change'): ?>
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
                    <?php endif; ?>
                <?php endif; ?>

                var currentDate = new Date();

                var fileName = 'Quick-Ratio-' + currentDate + '.pdf';

                doc.save(fileName);
            };
        });
    });


</Script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/performance-snapshot.blade.php ENDPATH**/ ?>