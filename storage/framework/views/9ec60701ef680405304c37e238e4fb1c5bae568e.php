<?php $__env->startSection('vue-js'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
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
                        <section class="pentatech_section money_seriously_section fund_watch_setion_home nfo_monitor_home_section section">
                           
                            <div class="blog-wrapper fund-watch-listing fw-single-page">
                                <div class="container">
                                    <div class="blog-inner-wrapper">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-12 col-sm-12 fw-single-block">
												<?php if(isset($createdAt)): ?>
																								
													<?php $__currentLoopData = $createdAt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<div class="card mb-3">
															<div class="card-body">
                                                                <img src="https://myplexus.com/themes/frontend/assets/v1/img/nippon.jpg" alt="" class="card_img">
																<h3 class="m-2"><?php echo e($filterDate->title); ?></h3>
																	<p class="card-title m-2"><?php echo e($filterDate->description); ?></p>
																
																<a class="btn btn-success m-2" href="<?php echo e(route('web.fundwatch.index',base64_encode($filterDate->fund_code))); ?>" target="_blank">View more</a>
															</div>
														</div>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													 
												<?php else: ?>
												 <?php for($i=0; $i<count($fundWatchTitle); $i++): ?>
																<?php
																	$sid =base64_encode($fundWatchData[$i]->fund_code);
																?>
														<?php if($sid!=""): ?>
															<div class="card mb-3">
																<div class="card-body">
                                                                <img src="https://myplexus.com/themes/frontend/assets/v1/img/nippon.jpg" alt="" class="card_img">
																	<h3 class="m-2"><?php echo e($fundWatchTitle[$i]->title); ?></h3>
																	<p class="card-title m-2"><?php echo e($fundWatchDescription[$i]->description); ?></p>
																	<a class="btn btn-success m-2" href="<?php echo e(route('web.fundwatch.index', $sid)); ?>" target="_blank">View more</a>
																</div>
															</div>
														<?php endif; ?>
													<?php endfor; ?>
												
												<?php endif; ?>
                                                

                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar">
                                                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                    <h6>Recent Fund Watch</h6>
                                                        <ul class="reset">
																														
															 <?php $__currentLoopData = $fundWatchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fwdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php
                           										$sid =base64_encode($fwdata->fund_code);
                         									?>
															<?php if($sid!=""): ?>
																<li>
																	
																	
																	<a href="<?php echo e(route('web.fundwatch.index', $sid )); ?>" target="_blank" style="color: #1b103a"> <?php echo e($fwdata->title); ?> </a>
																	
																</li>
															<?php endif; ?>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                   
                                                           
                                                        </ul>
                                                </div>
                            
                                                <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
                                                    <h6>Archives</h6>
                                                        <ul class="reset">
                                                            <li>
                                                                <a href="https://www.new.myplexus.com/fund-watch-list/2021">2021 <span>(2)</span></a>
                                                            </li>
                                                            <li>
                                                                <a href="https://www.new.myplexus.com/fund-watch-list/2023">2023 <span>(1)</span></a>
                                                            </li>
                                                        </ul>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund_watch/index.blade.php ENDPATH**/ ?>