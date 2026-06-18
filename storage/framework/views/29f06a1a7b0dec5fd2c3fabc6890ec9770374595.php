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
        <fund-performance image_path="<?php echo e(asset('themes/frontend/assets/v1/img/')); ?>"></fund-performance>
        <div class="clearfix">&nbsp;</div>
    </div> -->

<section class="compare_scheme">
    <div class="container tab_snap_shot new-shot">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link  <?php if((isset($type) && ($type == 'return' || $type == 'return2')) || !isset($type)): ?> active <?php endif; ?>" id="pills-Return-tab" role="tab" aria-controls="pills-Return" aria-selected="false" href="/fund-performance?fund_code=<?php echo e($request->fund_code); ?>&type=return "><i class="ph-calendar-check"></i> Return</a></li>

            <li class="nav-item" role="presentation"><a class="nav-link <?php if(isset($type) && ($type == 'ratio')): ?> active <?php endif; ?>" id="pills-Ratio-tab" role="tab" aria-controls="pills-Ratio" aria-selected="true" href="/fund-performance?fund_code=<?php echo e($request->fund_code); ?>&type=ratio"><i class="ph-calendar"></i> Ratio</a></li>

            <li class="nav-item" role="presentation"><a class="nav-link <?php if(isset($type) && ($type == 'portfolio')): ?> active <?php endif; ?>" id="pills-Portfolio-tab" role="tab" aria-controls="pills-Portfolio" aria-selected="false" href="/fund-performance?fund_code=<?php echo e($request->fund_code); ?>&type=portfolio "><i class="ph-calendar"></i> Portfolio</a></li>





        </ul>
        <div class="comp_schem_bdr">
            <div class="tab_snap_shot">
                <div class="tab-content" id="pills-tabContent">


                    <div class="tab-pane fade active show" id="pills-Ratio" role="tabpanel" aria-labelledby="pills-Ratio-tab">
                        <div class="datatable_ll performance_compare_top_table mt-4">
                            <h4>Scheme Name:</h4>
                            <div class="row">
                                <div class="col-md-12 col-md-4">
                                    <div tabindex="-1" class="multiselect" role="combobox" aria-owns="listbox-null">
                                        <select name="fund_type" id="fund_type" class="select2"
                                            data-placeholder="Select Fund Category" onchange="window.location.href='/fund-performance?fund_code='+encodeURIComponent(this.value)+'&type=<?php echo e($type); ?>' ">
                                            <option value="">Select Fund Classification</option>
                                            <?php if(isset($fund_master)): ?>
                                            <?php $__currentLoopData = $fund_master; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val->fund_code); ?>"
                                                <?php echo e(isset($request->fund_code) && $request->fund_code == $val->fund_code ? 'selected' : ''); ?>>
                                                <?php echo e($val->fund_name); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="datatable_ll mt-3">
                            <?php if($fund_details_ratios): ?>
                                <div class="mt-3 bordr-only">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4 mb-2"><b>NAV: <?php echo e($fund_details_ratios['nav']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>NAV Date : <?php echo e($fund_details_ratios['nav_entry_date']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Category:<?php echo e($fund_details_ratios['category']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>AAUM: (Crores) <?php echo e(($fund_details_ratios['aaum'])?$fund_details_ratios['aaum']/100:''); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Scheme Commencement Date:<?php echo e($fund_details_ratios['fund_opened']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Fund Manager: <?php echo e($fund_details_ratios['fund_man']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Schemes in Category (No.): <?php echo e($fund_details_ratios['no_of_schemes']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Benchmark: <?php echo e($fund_details_ratios['benchmark']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Value: <?php echo e($fund_details_ratios['benchmark_closing_value']); ?></b></div>
                                        <div class="col-md-6 col-lg-4 mb-2"><b>Benchmark Date: <?php echo e($fund_details_ratios['benchmark_entry_date']); ?></b></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <?php if($fund_details_ratios): ?>
                        <div class="datatable_ll main_trer fund_performance_table">
                            <!-- FUND PERFORMANCE RETURNS TAB START -->

                            <?php if(($type == 'return' || $type == 'return2')): ?>
                            <div class="table-responsive">
                                <div class="fund_per_heading d-block d-sm-flex align-items-center justify-content-between hding-vue">
                                    <h4>Scheme Performance, <?php echo e($fund_details_ratios['fund_name']); ?> - <?php echo e(($type == 'return') ? 'Category as on '. $fund_details_ratios['nav_entry_date']  :'Benchmark as on '. $fund_details_ratios['benchmark_entry_date']); ?></h4>
                                    <div class="new-bttn">
                                        <a href="/fund-performance?fund_code=<?php echo e($request->fund_code); ?>&type=return" class="money_title_btn " <?php if((isset($type) && ($type=='return' )) || !isset($type)): ?>disabled="true" <?php endif; ?>>To Category</a>
                                        <a href="/fund-performance?fund_code=<?php echo e($request->fund_code); ?>&type=return2" class="money_title_btn " <?php if((isset($type) && ($type=='return2' )) || !isset($type)): ?>disabled="true" <?php endif; ?>>To Benchmark</a>
                                    </div>
                                </div>
                                <table id="" class="table dataTable no-footer table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <td class="dark_bg color_white text-center" colspan="9" style="border-radius: 7px;">Performance Compare To <span><?php echo e(($type == 'return') ? 'Category':'Benchmark'); ?></span></td>
                                        </tr>
                                        <tr>
                                            <th class="sorting" style="width: 47% !important;">Return <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>7 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>30 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>90 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>180 Days <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>1 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>2 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>3 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            <th>5 Year <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="category_data">
                                        <tr>
                                            <td>Scheme</td>
                                            <td><?php echo e(($returnData['return_scheme']->SEVENDAYS!='9999')?round($returnData['return_scheme']->SEVENDAYS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->THIRTYDAYS!='9999')?round($returnData['return_scheme']->THIRTYDAYS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->NINTYDAYS!='9999')?round($returnData['return_scheme']->NINTYDAYS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->SIXMONTHS!='9999')?round($returnData['return_scheme']->SIXMONTHS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->ONEYEAR!='9999')?round($returnData['return_scheme']->ONEYEAR,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->TWOYEAR!='9999')?round($returnData['return_scheme']->TWOYEAR,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->THREEYEAR!='9999')?round($returnData['return_scheme']->THREEYEAR,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->FIVEYEAR!='9999')?round($returnData['return_scheme']->FIVEYEAR,2):''); ?></td>

                                        </tr>
                                        <tr class="odd" id="scheme_sip_data_sip_return_tr">
                                            <td>Scheme SIP</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <?php if(isset($type) && ($type == 'return')): ?>
                                        <tr>
                                            <td>Category Average </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->category_avg) ? number_format($returnData['category_compare_data']['SEVENDAYS']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->category_avg) ? number_format($returnData['category_compare_data']['THIRTYDAYS']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->category_avg) ? number_format($returnData['category_compare_data']['NINTYDAYS']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->category_avg) ? number_format($returnData['category_compare_data']['SIXMONTHS']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->category_avg) ? number_format($returnData['category_compare_data']['ONEYEAR']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->category_avg) ? number_format($returnData['category_compare_data']['TWOYEAR']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->category_avg) ? number_format($returnData['category_compare_data']['THREEYEAR']->category_avg,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->category_avg) ? number_format($returnData['category_compare_data']['FIVEYEAR']->category_avg,2):''); ?> </td>

                                        </tr>
                                        <tr class="odd">
                                            <td>Category Median</td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->median) ? number_format($returnData['category_compare_data']['SEVENDAYS']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->median) ? number_format($returnData['category_compare_data']['THIRTYDAYS']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->median) ? number_format($returnData['category_compare_data']['NINTYDAYS']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->median) ? number_format($returnData['category_compare_data']['SIXMONTHS']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->median) ? number_format($returnData['category_compare_data']['ONEYEAR']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->median) ? number_format($returnData['category_compare_data']['TWOYEAR']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->median) ? number_format($returnData['category_compare_data']['THREEYEAR']->median,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->median) ? number_format($returnData['category_compare_data']['FIVEYEAR']->median,2):''); ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Category Leader</td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->leader_fund_name) ? $returnData['category_compare_data']['SEVENDAYS']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->leader) ? number_format($returnData['category_compare_data']['SEVENDAYS']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->leader_fund_name) ? $returnData['category_compare_data']['THIRTYDAYS']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->leader) ? number_format($returnData['category_compare_data']['THIRTYDAYS']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->leader_fund_name) ? $returnData['category_compare_data']['NINTYDAYS']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->leader) ? number_format($returnData['category_compare_data']['NINTYDAYS']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->leader_fund_name) ? $returnData['category_compare_data']['SIXMONTHS']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->leader) ? number_format($returnData['category_compare_data']['SIXMONTHS']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->leader_fund_name) ? $returnData['category_compare_data']['ONEYEAR']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->leader) ? number_format($returnData['category_compare_data']['ONEYEAR']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->leader_fund_name) ? $returnData['category_compare_data']['TWOYEAR']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->leader) ? number_format($returnData['category_compare_data']['TWOYEAR']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->leader_fund_name) ? $returnData['category_compare_data']['THREEYEAR']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->leader) ? number_format($returnData['category_compare_data']['THREEYEAR']->leader,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->leader_fund_name) ? $returnData['category_compare_data']['FIVEYEAR']->leader_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->leader) ? number_format($returnData['category_compare_data']['FIVEYEAR']->leader,2):''); ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Category Laggard</td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->laggard_fund_name) ? $returnData['category_compare_data']['SEVENDAYS']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->laggard) ? number_format($returnData['category_compare_data']['SEVENDAYS']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->laggard_fund_name) ? $returnData['category_compare_data']['THIRTYDAYS']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->laggard) ? number_format($returnData['category_compare_data']['THIRTYDAYS']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->laggard_fund_name) ? $returnData['category_compare_data']['NINTYDAYS']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->laggard) ? number_format($returnData['category_compare_data']['NINTYDAYS']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->laggard_fund_name) ? $returnData['category_compare_data']['SIXMONTHS']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->laggard) ? number_format($returnData['category_compare_data']['SIXMONTHS']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->laggard_fund_name) ? $returnData['category_compare_data']['ONEYEAR']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->laggard) ? number_format($returnData['category_compare_data']['ONEYEAR']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->laggard_fund_name) ? $returnData['category_compare_data']['TWOYEAR']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->laggard) ? number_format($returnData['category_compare_data']['TWOYEAR']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->laggard_fund_name) ? $returnData['category_compare_data']['THREEYEAR']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->laggard) ? number_format($returnData['category_compare_data']['THREEYEAR']->laggard,2):''); ?> </td>
                                            <td data-bs-toggle="tooltip" data-bs-html="true" title="<?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->laggard_fund_name) ? $returnData['category_compare_data']['FIVEYEAR']->laggard_fund_name:''); ?>"> <?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->laggard) ? number_format($returnData['category_compare_data']['FIVEYEAR']->laggard,2):''); ?> </td>
                                        </tr>
                                        <tr id="cat_dec">
                                            <td>Category Decile</td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->decile)? number_format($returnData['category_compare_data']['SEVENDAYS']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->decile)? number_format($returnData['category_compare_data']['THIRTYDAYS']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->decile)? number_format($returnData['category_compare_data']['NINTYDAYS']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->decile)? number_format($returnData['category_compare_data']['SIXMONTHS']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->decile)? number_format($returnData['category_compare_data']['ONEYEAR']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->decile)? number_format($returnData['category_compare_data']['TWOYEAR']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->decile)? number_format($returnData['category_compare_data']['THREEYEAR']->decile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->decile)? number_format($returnData['category_compare_data']['FIVEYEAR']->decile,0):''); ?> </td>
                                        </tr>
                                        <tr class="odd" id="cat_qur">
                                            <td>Category Quartile</td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SEVENDAYS']->quartile)? number_format($returnData['category_compare_data']['SEVENDAYS']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THIRTYDAYS']->quartile)? number_format($returnData['category_compare_data']['THIRTYDAYS']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['NINTYDAYS']->quartile)? number_format($returnData['category_compare_data']['NINTYDAYS']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['SIXMONTHS']->quartile)? number_format($returnData['category_compare_data']['SIXMONTHS']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['ONEYEAR']->quartile)? number_format($returnData['category_compare_data']['ONEYEAR']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['TWOYEAR']->quartile)? number_format($returnData['category_compare_data']['TWOYEAR']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['THREEYEAR']->quartile)? number_format($returnData['category_compare_data']['THREEYEAR']->quartile,0):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['category_compare_data']['FIVEYEAR']->quartile)? number_format($returnData['category_compare_data']['FIVEYEAR']->quartile,0):''); ?> </td>
                                        </tr>
                                        <?php endif; ?>

                                        <?php if(isset($type) && ($type == 'return2')): ?>
                                        <tr>
                                            <td><?php echo e($fund_details_ratios['benchmark']); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->SEVENDAYS!='0')?round($returnData['return_benchmark']->SEVENDAYS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->THIRTYDAYS!='0')?round($returnData['return_benchmark']->THIRTYDAYS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->NINTYDAYS!='0')?round($returnData['return_benchmark']->NINTYDAYS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->SIXMONTHS!='0')?round($returnData['return_benchmark']->SIXMONTHS,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->ONEYEAR!='0')?round($returnData['return_benchmark']->ONEYEAR,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->TWOYEAR!='0')?round($returnData['return_benchmark']->TWOYEAR,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->THREEYEAR!='0')?round($returnData['return_benchmark']->THREEYEAR,2):''); ?></td>
                                            <td><?php echo e(($returnData['return_benchmark']->FIVEYEAR!='0')?round($returnData['return_benchmark']->FIVEYEAR,2):''); ?></td>
                                        </tr>
                                        <tr id="benchmark_sip_data_sip_return_tr">
                                            <td><?php echo e($fund_details_ratios['benchmark']); ?> SIP</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Scheme ALPHA</td>
                                            <td><?php echo e(($returnData['return_scheme']->SEVENDAYS!='9999')?(round($returnData['return_scheme']->SEVENDAYS,2) - round($returnData['return_benchmark']->SEVENDAYS,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->THIRTYDAYS!='9999')?(round($returnData['return_scheme']->THIRTYDAYS,2) - round($returnData['return_benchmark']->THIRTYDAYS,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->NINTYDAYS!='9999')?(round($returnData['return_scheme']->NINTYDAYS,2) - round($returnData['return_benchmark']->NINTYDAYS,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->SIXMONTHS!='9999')?(round($returnData['return_scheme']->SIXMONTHS,2) - round($returnData['return_benchmark']->SIXMONTHS,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->ONEYEAR!='9999')?(round($returnData['return_scheme']->ONEYEAR,2) - round($returnData['return_benchmark']->ONEYEAR,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->TWOYEAR!='9999')?(round($returnData['return_scheme']->TWOYEAR,2) - round($returnData['return_benchmark']->TWOYEAR,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->THREEYEAR!='9999')?(round($returnData['return_scheme']->THREEYEAR,2) - round($returnData['return_benchmark']->THREEYEAR,2)):''); ?></td>
                                            <td><?php echo e(($returnData['return_scheme']->FIVEYEAR!='9999')?(round($returnData['return_scheme']->FIVEYEAR,2) - round($returnData['return_benchmark']->FIVEYEAR,2)):''); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Scheme High</td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['SEVENDAYS']->scheme_high) ? number_format($returnData['scheme_high_low_data']['SEVENDAYS']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['THIRTYDAYS']->scheme_high) ? number_format($returnData['scheme_high_low_data']['THIRTYDAYS']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['NINTYDAYS']->scheme_high) ? number_format($returnData['scheme_high_low_data']['NINTYDAYS']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['SIXMONTHS']->scheme_high) ? number_format($returnData['scheme_high_low_data']['SIXMONTHS']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['ONEYEAR']->scheme_high) ? number_format($returnData['scheme_high_low_data']['ONEYEAR']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['TWOYEAR']->scheme_high) ? number_format($returnData['scheme_high_low_data']['TWOYEAR']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['THREEYEAR']->scheme_high) ? number_format($returnData['scheme_high_low_data']['THREEYEAR']->scheme_high,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['FIVEYEAR']->scheme_high) ? number_format($returnData['scheme_high_low_data']['FIVEYEAR']->scheme_high,2):''); ?> </td>

                                        </tr>
                                        <tr>
                                            <td>Scheme Low</td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['SEVENDAYS']->scheme_low) ? number_format($returnData['scheme_high_low_data']['SEVENDAYS']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['THIRTYDAYS']->scheme_low) ? number_format($returnData['scheme_high_low_data']['THIRTYDAYS']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['NINTYDAYS']->scheme_low) ? number_format($returnData['scheme_high_low_data']['NINTYDAYS']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['SIXMONTHS']->scheme_low) ? number_format($returnData['scheme_high_low_data']['SIXMONTHS']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['ONEYEAR']->scheme_low) ? number_format($returnData['scheme_high_low_data']['ONEYEAR']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['TWOYEAR']->scheme_low) ? number_format($returnData['scheme_high_low_data']['TWOYEAR']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['THREEYEAR']->scheme_low) ? number_format($returnData['scheme_high_low_data']['THREEYEAR']->scheme_low,2):''); ?> </td>
                                            <td> <?php echo e(($returnData['scheme_high_low_data']['FIVEYEAR']->scheme_low) ? number_format($returnData['scheme_high_low_data']['FIVEYEAR']->scheme_low,2):''); ?> </td>

                                        </tr>
                                        <tr>
                                            <td>Benchmark High</td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['SEVENDAYS']->benchmark_high) ? number_format($returnData['benchmark_high_low_data']['SEVENDAYS']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['THIRTYDAYS']->benchmark_high) ? number_format($returnData['benchmark_high_low_data']['THIRTYDAYS']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['NINTYDAYS']->benchmark_high) ? number_format($returnData['benchmark_high_low_data']['NINTYDAYS']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['SIXMONTHS']->benchmark_high) ? number_format($returnData['benchmark_high_low_data']['SIXMONTHS']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['ONEYEAR']->benchmark_high)  && $returnData['return_benchmark']->ONEYEAR!='0') ? number_format($returnData['benchmark_high_low_data']['ONEYEAR']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['TWOYEAR']->benchmark_high)  && $returnData['return_benchmark']->TWOYEAR!='0') ? number_format($returnData['benchmark_high_low_data']['TWOYEAR']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['THREEYEAR']->benchmark_high)  && $returnData['return_benchmark']->THREEYEAR!='0') ? number_format($returnData['benchmark_high_low_data']['THREEYEAR']->benchmark_high,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['FIVEYEAR']->benchmark_high)  && $returnData['return_benchmark']->FIVEYEAR!='0') ? number_format($returnData['benchmark_high_low_data']['FIVEYEAR']->benchmark_high,2):''); ?> </td>

                                        </tr>
                                        <tr>
                                            <td>Benchmark Low</td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['SEVENDAYS']->benchmark_low) ? number_format($returnData['benchmark_high_low_data']['SEVENDAYS']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['THIRTYDAYS']->benchmark_low) ? number_format($returnData['benchmark_high_low_data']['THIRTYDAYS']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['NINTYDAYS']->benchmark_low) ? number_format($returnData['benchmark_high_low_data']['NINTYDAYS']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e(!empty($returnData['benchmark_high_low_data']['SIXMONTHS']->benchmark_low) ? number_format($returnData['benchmark_high_low_data']['SIXMONTHS']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['ONEYEAR']->benchmark_low) && $returnData['return_benchmark']->ONEYEAR!='0' ) ? number_format($returnData['benchmark_high_low_data']['ONEYEAR']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['TWOYEAR']->benchmark_low) && $returnData['return_benchmark']->TWOYEAR!='0' ) ? number_format($returnData['benchmark_high_low_data']['TWOYEAR']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['THREEYEAR']->benchmark_low) && $returnData['return_benchmark']->THREEYEAR!='0' ) ? number_format($returnData['benchmark_high_low_data']['THREEYEAR']->benchmark_low,2):''); ?> </td>
                                            <td> <?php echo e((!empty($returnData['benchmark_high_low_data']['FIVEYEAR']->benchmark_low) && $returnData['return_benchmark']->FIVEYEAR!='0' ) ? number_format($returnData['benchmark_high_low_data']['FIVEYEAR']->benchmark_low,2):''); ?> </td>

                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-5" style="width: 100%;">
                                <div id="chartContainer" style="height: 360px; width: 100%;">

                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- FUND PERFORMANCE RETURNS TAB END -->
                            <!-- FUND PERFORMANCE RETURNS RATIOS TAB START -->
                            <?php if(isset($type) && ($type == 'ratio')): ?>
                            <div class="datatable_ll main_trer fund_performance_table">
                                <div class="table-responsive">
                                    <table id="" class="table table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <td class="dark_bg color_white text-center" colspan="3" style="border-radius: 7px;">Ratio as on <?php echo e(!empty($returnData['one_year']['jensen_alpha']) ? date('d-m-Y',strtotime($returnData['one_year']['end_date'])): ''); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Scheme Name</th>
                                                <th>1 Year</th>
                                                <th>2 Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Jensen Alpha</td>
                                                <td><?php echo e(!empty($returnData['one_year']['jensen_alpha']) ? number_format($returnData['one_year']['jensen_alpha'],2): ''); ?></td>
                                                <td><?php echo e(!empty($returnData['two_year']['jensen_alpha']) ? number_format($returnData['two_year']['jensen_alpha'],2): ''); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Beta</td>
                                                <td><?php echo e(!empty($returnData['one_year']['beta']) ? number_format($returnData['one_year']['beta'],2): ''); ?></td>
                                                <td><?php echo e(!empty($returnData['two_year']['beta']) ? number_format($returnData['two_year']['beta'],2): ''); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Volatility</td>
                                                <td><?php echo e(!empty($returnData['one_year']['volatility']) ? number_format($returnData['one_year']['volatility'],2): ''); ?></td>
                                                <td><?php echo e(!empty($returnData['two_year']['volatility']) ? number_format($returnData['two_year']['volatility'],2): ''); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="fund-perform-ratio-table br-5 full-table-style-3">
                                    <table id="fund-perform-ratio-data-2" class=" table-striped" style="width: 100%;">
                                        <th> AAUM <?php echo e(!empty($returnData['last_aaum']->entry_date)?$returnData['last_aaum']->entry_date:''); ?> (in Crores) </th>
                                        <th> AAUM <?php echo e(!empty($returnData['f_aaum']->entry_date)?$returnData['f_aaum']->entry_date:''); ?> (in Crores) </th>
                                        <th> AAUM <?php echo e(!empty($returnData['s_aaum']->entry_date)?$returnData['s_aaum']->entry_date:''); ?> (in Crores) </th>
                                        <th> AAUM <?php echo e(!empty($returnData['t_aaum']->entry_date)?$returnData['t_aaum']->entry_date:''); ?> (in Crores) </th>
                                        <tbody>
                                            <tr>
                                                <td><?php echo e(!empty($returnData['last_aaum']->corpus_entry)?$returnData['last_aaum']->corpus_entry/100:''); ?></td>
                                                <td><?php echo e(!empty($returnData['f_aaum']->corpus_entry)?$returnData['f_aaum']->corpus_entry/100:''); ?></td>
                                                <td><?php echo e(!empty($returnData['s_aaum']->corpus_entry)?$returnData['s_aaum']->corpus_entry/100:''); ?></td>
                                                <td><?php echo e(!empty($returnData['t_aaum']->corpus_entry)?$returnData['t_aaum']->corpus_entry/100:''); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- FUND PERFORMANCE RETURNS RATIOS TAB END -->

                            <!-- FUND PERFORMANCE RETURNS PORTFOLIOS TAB START -->
                            <?php if(isset($type) && ($type == 'portfolio')): ?>
                            <div class="datatable_ll main_trer fund_performance_table">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped dataTable no-footer" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <td class="dark_bg color_white text-center" colspan="9" style="border-radius: 7px;">Portfolio Details </td>
                                            </tr>
                                            <tr>
                                                <th>No.of Scrips</th>
                                                <th>Wtd. PE </th>
                                                <th>Large Cap</th>
                                                <th>Very Large Cap</th>
                                                <th>Mid Cap</th>
                                                <th>Small Cap</th>
                                                <th>Corp Debt</th>
                                                <th>SOV</th>
                                                <th>Cash</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td><?php echo e($portfolioData->no_of_scripts); ?></td>
                                                <td><?php echo e($portfolioData->wt_pe); ?></td>
                                                <td><?php echo e($portfolioData->eq_large); ?></td>
                                                <td><?php echo e($portfolioData->eq_very_large); ?></td>
                                                <td><?php echo e($portfolioData->eq_mid); ?></td>
                                                <td><?php echo e($portfolioData->eq_small); ?></td>
                                                <td><?php echo e($portfolioData->debt); ?></td>
                                                <td><?php echo e($portfolioData->sov); ?></td>
                                                <td><?php echo e($portfolioData->cash); ?></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="">
                                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                    <a href="javascript://" class="money_title_btn" data-bs-toggle="modal" data-bs-target="#top_ten_scripts_div">Top 10 Scrips</a>&nbsp;&nbsp;
                                    <a href="javascript://" class="money_title_btn" data-bs-toggle="modal" data-bs-target="#top_ten_industries_div">Top 10 Industries</a>&nbsp;&nbsp;
                                    <a href="javascript://" class="money_title_btn" data-bs-toggle="modal" data-bs-target="#all_industries_div">All Industries</a>&nbsp;&nbsp;
                                </div>
                            </div>

                            <div class="modal fade fade" id="top_ten_scripts_div" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content fund-c-analysis">
                                        <div class="modal-header">
                                            <h6 class="">Top 10 Scrips</h6><button type="button" class="close" data-bs-dismiss="modal">×</button>
                                        </div>
                                        <div class="modal-body perform-paramtr c-snapchot-parent">
                                            <div class="changes_table dy-table-wrap">
                                                <div class="dy-table-block br-5">
                                                    <table class="table display dataTable no-footer table-striped table-responsive box-shadow ">
                                                        <thead>
                                                            <tr>
                                                                <th>Scrips </th>
                                                                <th>Content% </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($portfolioData->top_scrips)): ?>
                                                            <?php $__currentLoopData = $portfolioData->top_scrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scrips): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($scrips->scrip_name); ?></td>
                                                                <td class="text_right open-popup-scrip-industry"
                                                                    data-category="content_per" data-using="scrip"
                                                                    data-parameter="<?php echo e($scrips->scrip_name); ?>">
                                                                    <?php echo e(printValue($scrips->content_per)); ?>

                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade fade" id="top_ten_industries_div" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content fund-c-analysis">
                                        <div class="modal-header">
                                            <h6 class="">Top 10 Industries</h6><button type="button" class="close" data-bs-dismiss="modal">×</button>
                                        </div>
                                        <div class="modal-body perform-paramtr c-snapchot-parent">
                                            <div class="changes_table dy-table-wrap">
                                                <div class="dy-table-block br-5">
                                                    <table class="table display dataTable no-footer table-striped table-responsive box-shadow ">
                                                        <thead>
                                                            <tr>
                                                                <th>Industry </th>
                                                                <th>Content% </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($portfolioData->top_industries)): ?>
                                                            <?php $__currentLoopData = $portfolioData->top_industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td class="text_left"><?php echo e($industry->industry); ?></td>
                                                                <td class="text_left open-popup-scrip-industry"
                                                                    data-using="industry" data-category="content_per"
                                                                    data-parameter="<?php echo e($industry->industry); ?>">
                                                                    <?php echo e(printValue($industry->content_per)); ?>

                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade fade" id="all_industries_div" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content fund-c-analysis">
                                        <div class="modal-header">
                                            <h6 class="">All Industries</h6><button type="button" class="close" data-bs-dismiss="modal">×</button>
                                        </div>
                                        <div class="modal-body perform-paramtr c-snapchot-parent">
                                            <div class="changes_table dy-table-wrap">
                                                <div class="dy-table-block br-5">
                                                    <table class="table display dataTable no-footer table-striped table-responsive box-shadow ">
                                                        <thead>
                                                            <tr>
                                                                <th>Industry </th>
                                                                <th>Content% </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($portfolioData->all_industries)): ?>
                                                            <?php $__currentLoopData = $portfolioData->all_industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all_industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td class="text_left"><?php echo e($all_industry->industry); ?></td>
                                                                <td class="text_left open-popup-scrip-industry"
                                                                    data-using="industry" data-category="content_per"
                                                                    data-parameter="<?php echo e($all_industry->industry); ?>">
                                                                    <?php echo e(printValue($all_industry->content_per)); ?>

                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- FUND PERFORMANCE RETURNS PORTFOLIOS TAB END -->

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

</section>
<script src="https://myplexus.com/themes/frontend/assets/v1/js/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
    var table = new DataTable('.dataTable', {
        info: false,
        ordering: true,
        paging: false,
        searching: false,
        order: [],
    });


    <?php if ($type == 'return' || $type == 'return2') { ?>
        var chart = {
            colorSet: "greenShades",
            backgroundColor: "#fff  ",
            theme: "light2",
            animationEnabled: true,
            axisY: {
                includeZero: false,
                title: "Scheme",
                suffix: " "
            },
            toolTip: {
                shared: "true"
            },
            legend: {
                cursor: "pointer",
                itemclick: this.toggleDataSeries
            },
            title: {
                text: "Scheme NAV Chart"
            },
            data: [{
                type: "spline",
                showInLegend: true,
                yValueFormatString: "##.00",
                name: "NAV Value",
                dataPoints: <?php echo json_encode($returnData['dataPoints'], JSON_NUMERIC_CHECK) ?>
            }]
        };
        CanvasJS.addColorSet("greenShades", ["#4661EE", "#EC5657", "#1BCDD1", "#8FAABB", "#B08BEB", "#3EA0DD", "#F5A52A", "#23BFAA", "#FAA586", "#EB8CC6"]);
        this.chart = new CanvasJS.Chart("chartContainer", chart);
        this.chart.render();


        // SIP Calc        
        scheme_sip_data_sip_return();
        <?php
        if ($type == 'return2') { ?>
            benchmark_sip_data_sip_return();
        <?php
        }
        ?>
        //quartile_decile_return();
    <?php
    }
    ?>



    function scheme_sip_data_sip_return() {
        var currentRow = $('#scheme_sip_data_sip_return_tr');
        $.ajax({
            url: "<?= URL::to('api/v1/fund-performance-scheme-sip'); ?>",
            type: 'GET',
            data: {
                fund_code: "<?= $request->fund_code ?>",
            },
            success: function(response) {
                // var datas = response.datas;				
                //var datas = JSON.parse(response);
                console.log(response);
                let sipDataArr = response.data.scheme_sip_data

                for (var keyDur of Object.keys(sipDataArr)) {

                    let all_values = (sipDataArr[keyDur].ALLVALUES) ? JSON.parse(sipDataArr[keyDur].ALLVALUES) : ''
                    let all_dates = (sipDataArr[keyDur].ALLDATES) ? JSON.parse(sipDataArr[keyDur].ALLDATES) : ''
                    let sip_return = calculate_sip(all_dates, all_values)
                    if (isNaN(sip_return)) {
                        sip_return = '';
                    } else {
                        sip_return = parseFloat(sip_return).toFixed(2);
                    }
                    sipDataArr[keyDur].sip_return = sip_return
                }
                //that.scheme_sip_data = sipDataArr
                //console.log('Scheme sip data');
                //console.log(sipDataArr);
                currentRow.find("td:eq(4)").text(sipDataArr.SIXMONTHS.sip_return);
                currentRow.find("td:eq(5)").text(sipDataArr.ONEYEAR.sip_return);
                currentRow.find("td:eq(6)").text(sipDataArr.TWOYEAR.sip_return);
                currentRow.find("td:eq(7)").text(sipDataArr.THREEYEAR.sip_return);
                currentRow.find("td:eq(8)").text(sipDataArr.FIVEYEAR.sip_return);

            },
            error: function(xhr, status, error) {
                console.log(error);
                //alert("Error occurred.");
            }
        });
    }

    function benchmark_sip_data_sip_return() {
        var currentRow = $('#benchmark_sip_data_sip_return_tr');
        $.ajax({
            url: "<?= URL::to('api/v1/fund-performance-benchmark-sip'); ?>",
            type: 'GET',
            data: {
                fund_code: "<?= $request->fund_code ?>",
            },
            success: function(response) {
                // var datas = response.datas;				
                //var datas = JSON.parse(response);
                //console.log(response);
                let sipDataArr = response.data.benchmark_sip_data

                for (var keyDur of Object.keys(sipDataArr)) {

                    let all_values = (sipDataArr[keyDur].ALLVALUES) ? JSON.parse(sipDataArr[keyDur].ALLVALUES) : ''
                    let all_dates = (sipDataArr[keyDur].ALLDATES) ? JSON.parse(sipDataArr[keyDur].ALLDATES) : ''
                    let sip_return = calculate_sip(all_dates, all_values)
                    if (isNaN(sip_return)) {
                        sip_return = '';
                    } else {
                        sip_return = parseFloat(sip_return).toFixed(2);
                    }
                    sipDataArr[keyDur].sip_return = sip_return
                }
                //that.benchmark_sip_data = sipDataArr
                console.log('Benchmark sip data');
                console.log(sipDataArr);
                currentRow.find("td:eq(4)").text(sipDataArr.SIXMONTHS.sip_return);
                <?php 
                if(!empty($returnData['return_benchmark']) && $returnData['return_benchmark']->ONEYEAR!='0'){ 
                ?>
                currentRow.find("td:eq(5)").text(sipDataArr.ONEYEAR.sip_return);
                <?php
                }
                if(!empty($returnData['return_benchmark']) && $returnData['return_benchmark']->TWOYEAR!='0'){
                ?>
                currentRow.find("td:eq(6)").text(sipDataArr.TWOYEAR.sip_return);
                <?php 
                }
                if(!empty($returnData['return_benchmark']) && $returnData['return_benchmark']->THREEYEAR!='0'){ 
                ?>
                currentRow.find("td:eq(7)").text(sipDataArr.THREEYEAR.sip_return);
                <?php
                }
                if(!empty($returnData['return_benchmark']) && $returnData['return_benchmark']->FIVEYEAR!='0'){ 
                ?>
                currentRow.find("td:eq(8)").text(sipDataArr.FIVEYEAR.sip_return);
                <?php
                }
                ?>
            },
            error: function(xhr, status, error) {
                console.log(error);
                //alert("Error occurred.");
            }
        });
    }


    function calculate_sip(dates, values) {
        let that = this
        //alert(dates+' '+values);
        //console.log('All Values: ', values);
        //console.log('All Dates: ', dates);			
        var x = XIRR(values, dates, 0.1);
        //alert(x);

        x = x * 100;
        //document.write(x);
        return x;
    }

    function XIRR(values, dates, guess) {
        // Credits: algorithm inspired by Apache OpenOffice
        // Calculates the resulting amount
        var irrResult = function(values, dates, rate) {
            var r = rate + 1;
            var result = values[0];
            for (var i = 1; i < values.length; i++) {
                result += values[i] / Math.pow(r, moment(dates[i]).diff(moment(dates[0]), 'days') / 365);
            }
            //console.log(result);
            // alert(result);
            return result;
        }

        // Calculates the first derivation
        var irrResultDeriv = function(values, dates, rate) {
            var r = rate + 1;
            var result = 0;
            for (var i = 1; i < values.length; i++) {
                var frac = moment(dates[i]).diff(moment(dates[0]), 'days') / 365;
                result -= frac * values[i] / Math.pow(r, frac + 1);
            }
            return result;
        }

        // Check that values contains at least one positive value and one negative value
        var positive = false;
        var negative = false;
        for (var i = 0; i < values.length; i++) {
            if (values[i] > 0) positive = true;
            if (values[i] < 0) negative = true;
        }

        // Return error if values does not contain at least one positive value and one negative value
        if (!positive || !negative) return '#NUM!';

        // Initialize guess and resultRate
        var guess = (typeof guess === 'undefined') ? 0.1 : guess;
        var resultRate = guess;

        // Set maximum epsilon for end of iteration
        var epsMax = 1e-10;

        // Set maximum number of iterations
        var iterMax = 60;

        // Implement Newton's method
        var newRate, epsRate, resultValue;
        var iteration = 0;
        var contLoop = true;
        do {
            resultValue = irrResult(values, dates, resultRate);
            newRate = resultRate - resultValue / irrResultDeriv(values, dates, resultRate);
            epsRate = Math.abs(newRate - resultRate);
            resultRate = newRate;
            contLoop = (epsRate > epsMax) && (Math.abs(resultValue) > epsMax);
        } while (contLoop && (++iteration < iterMax));
        if (contLoop) return '#NUM!';
        // Return internal rate of return

        console.log(resultRate);

        return resultRate;
    }



    function quartile_decile_return() {
        var cat_qurRow = $('#cat_qur');
        var cat_decRow = $('#cat_dec');
        $.ajax({
            url: "<?= URL::to('api/v1/fund-performance-compare-category-new'); ?>",
            type: 'GET',
            data: {
                fund_code: "<?= $request->fund_code ?>",
            },
            success: function(response) {
                // var datas = response.datas;				
                //var datas = JSON.parse(response);
                console.log(response);

                let dataArr = response.data.category_compare_data;
                cat_qurRow.find("td:eq(1)").text(dataArr.SEVENDAYS.quartile);
                cat_qurRow.find("td:eq(2)").text(dataArr.THIRTYDAYS.quartile);
                cat_qurRow.find("td:eq(3)").text(dataArr.NINTYDAYS.quartile);
                cat_qurRow.find("td:eq(4)").text(dataArr.SIXMONTHS.quartile);
                cat_qurRow.find("td:eq(5)").text(dataArr.ONEYEAR.quartile);
                cat_qurRow.find("td:eq(6)").text(dataArr.TWOYEAR.quartile);
                cat_qurRow.find("td:eq(7)").text(dataArr.THREEYEAR.quartile);
                cat_qurRow.find("td:eq(8)").text(dataArr.FIVEYEAR.quartile);

                cat_decRow.find("td:eq(1)").text(dataArr.SEVENDAYS.decile);
                cat_decRow.find("td:eq(2)").text(dataArr.THIRTYDAYS.decile);
                cat_decRow.find("td:eq(3)").text(dataArr.NINTYDAYS.decile);
                cat_decRow.find("td:eq(4)").text(dataArr.SIXMONTHS.decile);
                cat_decRow.find("td:eq(5)").text(dataArr.ONEYEAR.decile);
                cat_decRow.find("td:eq(6)").text(dataArr.TWOYEAR.decile);
                cat_decRow.find("td:eq(7)").text(dataArr.THREEYEAR.decile);
                cat_decRow.find("td:eq(8)").text(dataArr.FIVEYEAR.decile);

            },
            error: function(xhr, status, error) {
                console.log(error);
                //alert("Error occurred.");
            }
        });
    }

    
</script>

<style>

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund-performance-new.blade.php ENDPATH**/ ?>