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


<section class="info_monitor_sec">
    <div class="container">
        <div class="row">
           

            <div class="col-lg-9 col-md-12 col-sm-12 fw-single-block">
                <div class="info_monitor_inner ">
                    <div class="info_monitor_inner_wrapper mb-3 Oomph_fact bg-gry border-s box-shadow br-5">
                        <div class="monitor_title">
                            <h4>Fund Fact</h4>
                        </div>
                        <div class="fund_fact_wrapper facts-color-black">
                            <div class="single_facts  d-block d-sm-flex align-items-center mb-2">
                                <h4>Name of Funds:</h4>
                                <label><?php echo e($dataArr['item']['fund_name']); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Opening:</h4>
                                <label><?php echo e(date($dateFormat, strtotime($dataArr['item']['fund_opening']))); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Closing:</h4>
                                <label><?php echo e(date($dateFormat, strtotime($dataArr['item']['fund_closing']))); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Minimum Investment:</h4>
                                <label><?php echo e($dataArr['item']['minimum_investment']); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Plan:</h4>
                                <label><?php echo e($dataArr['item']['plan']); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Options:</h4>
                                <label><?php echo e($dataArr['item']['options']); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Entry Load:</h4>
                                <label><?php echo e($dataArr['item']['entry_load']); ?></label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Exit Load:</h4>
                                <label><?php echo e($dataArr['item']['exit_load']); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-nfo-background bg-gry border-s box-shadow br-5 mb-3">
                        
                        <div class="col-md-12 col-lg-7 fund-stats-common fund-stats-lft">
                            <div class="info_monitor_inner_wrapper mb-3 ">
                                
                                    <h3>Fund Stats</h3>
                                
                                <div class="fund_fact_wrapper facts-color-white">
                                    <div class="single_facts mb-2">
                                        <h4>Objective:</h4>
                                     <label><?php echo nl2br($dataArr['item']['objective']); ?></label>
                                    </div>
                                    <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <h4>Benchmark:</h4>
                                        <label><?php echo e(!empty($dataArr['item']->indices->name) ? $dataArr['item']->indices->name : ""); ?></label>
                                    </div>
                                    <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <h4>Fund Manager:</h4>
                                        <label><?php echo e($dataArr['item']['fund_manager']); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5 fund-stats-common border-left">
                            <div class="info_monitor_inner_wrapper mb-3">
                                <div class="fund_fact_wrapper asset_aloocate">
                                    <h3>Asset Allocation</h3>
                                    <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <label><span><?php echo e($dataArr['item']['aa_col1_value']); ?></span> <?php echo e($dataArr['item']['aa_col1_text']); ?></label>
                                        <label><span><?php echo e($dataArr['item']['aa_col2_value']); ?></span> <?php echo e($dataArr['item']['aa_col2_text']); ?></label>
										
                                    </div>
									<div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                        <label><span><?php echo e($dataArr['item']['aa_col3_value']); ?></span> <?php echo e($dataArr['item']['aa_col3_text']); ?></label>
                                        <label><span><?php echo e($dataArr['item']['aa_col4_value']); ?></span> <?php echo e($dataArr['item']['aa_col4_text']); ?></label>										
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="info_monitor_inner_wrapper mb-3">
                        <div class="monitor_title">
                            <h4>Comparable Existing Scheme</h4>
                        </div>
                        <div class="fund_fact_wrapper Comparable_facts">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4><?php echo e($dataArr['item']['ces_row1_col1_text']); ?></h4>
                                <label>
                                    <span>
                                        <?php echo e($dataArr['item']['ces_row1_col2_text']); ?>

                                    </span>
                                    <?php echo e($dataArr['item']['ces_row1_col3_text']); ?>

                                </label>
                            </div>
                             <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4><?php echo e($dataArr['item']['ces_row2_col1_text']); ?></h4>
                                <label>
                                    <span>
                                        <?php echo e($dataArr['item']['ces_row2_col2_text']); ?>

                                    </span>
                                    <?php echo e($dataArr['item']['ces_row2_col3_text']); ?>

                                </label>
                            </div>
                        </div>
                    </div> -->
                    <div class="info_monitor_inner_wrapper compare-existing-scheme mb-3">
                            <div class="compare-top-title br-5 bg-dg base-pad">
                                <h6>Comparable existing schemes</h6>
                            </div>
                            <div class="compare-scheme-table table-w">
                                <div class="compare-table-wrap border-s br-5">
                                    <table id="comparable-schemes" class="bg-gry box-shadow">
                                        <tbody>
                                            <tr>
                                                <td><?php echo e($dataArr['item']['ces_row1_col1_text']); ?></td>
                                                <td><?php echo e($dataArr['item']['ces_row1_col2_text']); ?></td>
                                                <td><?php echo e($dataArr['item']['ces_row1_col3_text']); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e($dataArr['item']['ces_row2_col1_text']); ?></td>
                                                <td><?php echo e($dataArr['item']['ces_row2_col2_text']); ?></td>
                                                <td><?php echo e($dataArr['item']['ces_row2_col3_text']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <div class="info_monitor_inner_wrapper bg-nfo-background fund-prog bg-gry border-s box-shadow br-5 facts-color-white mb-3">
                        <div class="container">
                            <div class="fund-stats-inner-wrap br-5  ">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6 col-sm-12 fund-stats-common fund-stats-lft">
                                        <h3>Fund Prognosis</h3>
                                        <div class="fs-content">
                                            <span>Idea Distiller</span>
                                            <p> <?php echo nl2br($dataArr['item']['idea_distiller']); ?></p>
                                        </div>
                                        <div class="fund-stats-data">
                                            <ul class="d-flex">
                                                <li><p>Fund House AAUM:</p></li>
                                                <li><p> <?php echo e($dataArr['item']['fund_house_aaum']); ?></p></li>
                                                <li><p>Fund Manager:</p></li>
                                                <li><p> <?php echo e($dataArr['item']['fund_manager_experience']); ?></p></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-12 fund-stats-common asset-allocation-rgt border-left">
                                        <h3>Scheme DNA
                                            <span>4 fundamentals</span>
                                        </h3>
                                        <div class="fund_fact_wrapper">
                                            <div class="scheme_dna d-block d-sm-flex align-items-center">
                                                <!-- <div class="row"></div> -->
                                                <div class="single_scheme_dna">
                                                    <h4>Uniqueness</h4>
                                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                                        <?php for($i =1 ; $i <= $dataArr['item']['uniqness'] ; $i++): ?>
                                                            <i class="ph-star-fill active"></i>
                                                        <?php endfor; ?>
                                                        <?php for($i =1 ; $i <= 5-$dataArr['item']['uniqness'] ; $i++): ?>
                                                            <i class="ph-star-fill"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                                <div class="single_scheme_dna">
                                                    <h4>Return</h4>
                                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                                            <?php for($i =1 ; $i <= $dataArr['item']['return'] ; $i++): ?>
                                                                <i class="ph-star-fill active"></i>
                                                            <?php endfor; ?>
                                                            <?php for($i =1 ; $i <= 5-$dataArr['item']['return'] ; $i++): ?>
                                                                <i class="ph-star-fill"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single_scheme_dna">
                                                    <h4>Risk</h4>
                                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                                            <?php for($i =1 ; $i <= $dataArr['item']['risk'] ; $i++): ?>
                                                                <i class="ph-star-fill active"></i>
                                                            <?php endfor; ?>
                                                            <?php for($i =1 ; $i <= 5-$dataArr['item']['risk'] ; $i++): ?>
                                                                <i class="ph-star-fill"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single_scheme_dna">
                                                    <h4>Operability</h4>
                                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                                            <?php for($i =1 ; $i <= $dataArr['item']['operability'] ; $i++): ?>
                                                                <i class="ph-star-fill active"></i>
                                                            <?php endfor; ?>
                                                            <?php for($i =1 ; $i <= 5-$dataArr['item']['operability'] ; $i++): ?>
                                                                <i class="ph-star-fill"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- <div class="info_monitor_inner_wrapper bg-nfo-background bg-gry border-s box-shadow br-5 facts-color-white mb-3">
                        
                            <h4>Fund Prognosis</h4>
                        
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Idea Distiller:</h4>
                                <label>
                                    <?php echo nl2br($dataArr['item']['idea_distiller']); ?>

                                </label>    
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <h4>Fund House AAUM:</h4>
                                <label>
                                    <?php echo e($dataArr['item']['fund_house_aaum']); ?>

                                </label>
                            </div>
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                 <h4>Fund House AAUM:</h4>
                                <label>
                                    <?php echo e($dataArr['item']['fund_manager_experience']); ?>   
                                </label>
                            </div>
                        </div>
                    </div> -->
                     <!-- <div class="info_monitor_inner_wrapper bg-nfo-background bg-gry border-s box-shadow br-5 mb-3">
                        <div class="info_title">
                            <h4>Scheme DNA</h4>
                        </div>
                        <div class="fund_fact_wrapper">
                            <div class="scheme_dna d-block d-sm-flex align-items-center">
                                <div class="single_scheme_dna">
                                    <h4>Uniqueness</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <?php for($i =1 ; $i <= $dataArr['item']['uniqness'] ; $i++): ?>
                                            <i class="ph-star-fill active"></i>
                                        <?php endfor; ?>
                                        <?php for($i =1 ; $i <= 5-$dataArr['item']['uniqness'] ; $i++): ?>
                                            <i class="ph-star-fill"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Return</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                            <?php for($i =1 ; $i <= $dataArr['item']['return'] ; $i++): ?>
                                                <i class="ph-star-fill active"></i>
                                            <?php endfor; ?>
                                            <?php for($i =1 ; $i <= 5-$dataArr['item']['return'] ; $i++): ?>
                                                <i class="ph-star-fill"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Risk</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                            <?php for($i =1 ; $i <= $dataArr['item']['risk'] ; $i++): ?>
                                                <i class="ph-star-fill active"></i>
                                            <?php endfor; ?>
                                            <?php for($i =1 ; $i <= 5-$dataArr['item']['risk'] ; $i++): ?>
                                                <i class="ph-star-fill"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="single_scheme_dna">
                                    <h4>Operability</h4>
                                    <div class="star_wrape d-flex align-items-center justify-content-center">
                                        <div class="star_wrape d-flex align-items-center justify-content-center">
                                            <?php for($i =1 ; $i <= $dataArr['item']['operability'] ; $i++): ?>
                                                <i class="ph-star-fill active"></i>
                                            <?php endfor; ?>
                                            <?php for($i =1 ; $i <= 5-$dataArr['item']['operability'] ; $i++): ?>
                                                <i class="ph-star-fill"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="info_monitor_inner_wrapper Oomph_fact bg-nfo-background bg-gry border-s box-shadow br-5 facts-color-white mb-3">
                       
                            <h4>Oomph Factor</h4>
                        
                        <div class="fund_fact_wrapper">
                            <div class="single_facts d-block d-sm-flex align-items-center mb-2">
                                <label>
                                    <?php echo nl2br($dataArr['item']['oomph_factor']); ?>

                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar">
                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                    <h6>Recent NFO</h6>
                    <ul class="reset">
						<?php if($nfoMdl): ?>
							<?php $__currentLoopData = $nfoMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fomdl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li>
                            <a href="<?php echo e(url('/nfo-monitor').'/'.$fomdl->no_id); ?>"><?php echo e($fomdl->fund_name); ?></a>
                        </li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
						<?php endif; ?>
                       
                    </ul>
                </div>
                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                    <h6>Archives</h6>
                    <ul class="reset">
                        <?php if(!empty($archiveListModel)): ?>
                            <?php $__currentLoopData = $archiveListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ListModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(url('/nfo-monitor-list').'/'.$ListModel->year); ?>"><?php echo e($ListModel->year); ?> <span>( <?php echo e($ListModel->tot); ?> )</span></a>
                            </li>                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/nfo/details.blade.php ENDPATH**/ ?>