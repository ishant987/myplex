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
        <monthly-ranking page_title="<?php echo e($dataArr['title']); ?>"  page_description="<?php echo e($dataArr['descp']); ?>" page_image="<?php echo e($dataArr['image_path']); ?>"></monthly-ranking>
    </div> -->


<section class="info_monitor_sec">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-block d-sm-flex align-items-center justify-content-between mb-3">
                    <div class="monthly_ranking_text">
                        <p class="sub_gren_title">For The Month of <?php echo e(!empty($responseArr['to_date'])?$responseArr['to_date']:''); ?></p>
                    </div>
                </div>
                <div class="mb-2">
                    <div tabindex="-1" class="multiselect" role="combobox" aria-owns="listbox-null">
                        <select name="fund_type_id" id="fund_type_id" class="select2"
                            data-placeholder="Select Fund Category" onchange="window.location.href='monthly-ranking?fund_classification='+encodeURIComponent(this.value) ">
                            <option value="">Select Fund Classification</option>
                            <?php if(isset($fund_types)): ?>
                            <?php $__currentLoopData = $fund_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val->name); ?>"
                                <?php echo e(isset($type_id) && $type_id == $val->ft_id ? 'selected' : ''); ?>>
                                <?php echo e($val->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <p class="mt-3">Type of Fund : <?php echo e($fund_name); ?></p>
                    <div class="share_pdf" style="position: relative; padding-left: 80%; top: -38px; display: flex; align-items: center; gap: 10px;">

                        <div class="sharethis-inline-share-buttons"></div>
                        <!-- <a href="javascript:void(0)" id="exportPDF" class="pdf"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/pdf.png')); ?>" width="24"></a> -->

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="info_monitor_inner">
                    <div class="info_monitor_inner_wrapper">
                        <div class="monthly_ranking_table">
                            <div class="datatable_ll main_trer">
                                <div class="table-responsive">
                                    <table id="example" class="table table-responsive table-striped box-shadow dataTable no-footer" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="background-color: rgb(0, 102, 94) !important;"></th>
                                                <th colspan="3" style="background-color: rgb(34, 34, 34) !important;">Ranking</th>
                                            </tr>
                                            <tr>
                                                <th class="sorting sorting_asc"> Name of Fund <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting"> AAUM(Crores) <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting"> Return % (1 Year)<span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting"> Consistency <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting"> Fund Volatility <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                                <th class="sorting"> Market Risk <span class="filter__arrow"><i class="ph-arrows-down-up-bold"></i></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($dataArr2)): ?>
                                            <?php $__currentLoopData = $dataArr2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr class="">
                                                <td data-label="Name of Fund"><?php echo e($data->fund_name); ?></td>
                                                <td data-label="AAUM"><span> <?php echo e(!empty($data->aaum)?number_format(($data->aaum/100),2):''); ?></span></td>
                                                <td data-label="Return %"><span><?php echo e((!empty($data->one_year_return) && $data->one_year_return!='N/A')?$data->one_year_return : ''); ?></span></td>
                                                <td data-label="Return Quality">
                                                    <div class="return_quality_td">
                                                        <?php if(isset($data->return_quality) && !empty($data->one_year_return) && $data->one_year_return!='N/A'): ?>
                                                        <?php for($rq_i = 1; $rq_i <= $data->return_quality; $rq_i++): ?>
                                                            <i class="ph-star-fill active" id="<?php echo e($rq_i); ?>"></i>
                                                            <?php endfor; ?>

                                                            <?php for($rq_i2 = 1; $rq_i2 <= 5-$data->return_quality; $rq_i2++): ?>
                                                                <i class="ph-star-fill grey" id="<?php echo e($rq_i2); ?>empty"></i>
                                                                <?php endfor; ?>

                                                                <?php else: ?>

                                                                <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td data-label="Volitilty">
                                                    <?php if(isset($data->volatality) && !empty($data->one_year_return) && $data->one_year_return!='N/A'): ?>
                                                    <?php for($v_i = 1; $v_i <= $data->volatality; $v_i++): ?>
                                                        <img src="/images/fire_icon.png" title="<?php echo e($v_i); ?>" alt="<?php echo e($v_i); ?>" style="padding-right: 2px;">
                                                        <?php endfor; ?>
                                                        <?php else: ?>

                                                        <?php endif; ?>
                                                </td>
                                                <td data-label="Market Risk">
                                                    <?php if(isset($data->market_risk) && !empty($data->one_year_return) && $data->one_year_return!='N/A'): ?>
                                                    <?php for($mr_i = 1; $mr_i <= $data->market_risk; $mr_i++): ?>
                                                        <img src="/images/fire_icon.png" title="<?php echo e($mr_i); ?>" alt="<?php echo e($mr_i); ?>" style="padding-right: 2px;">
                                                        <?php endfor; ?>
                                                        <?php else: ?>

                                                        <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                        </tbody><!--v-if-->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/monthly-ranking.blade.php ENDPATH**/ ?>