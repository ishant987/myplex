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
<?php $__env->startPush('styles'); ?>
    <style>
        .login-banner {
            background-image: url('<?php echo e($dataArr['image_path']); ?>');
        }
    </style>
<?php $__env->stopPush(); ?>
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
                    <h4 class="f-b"><?php echo e($dataArr['title']); ?></h4>
                  
                </div>
            </div>
        </div>
    </div>
</section>  
<section class="sc-team-details-area sc-pt-100 sc-md-pt-80 sc-pb-200 sc-md-pb-150">
    <div class="container">
        <div class="row clearfix">
            <!-- sc-details-social -->
            <div class="sc-details-social col-lg-5 md-mb-50 sal-animate" data-sal="slide-right" data-sal-duration="800">
                <div class="inner-column">
                    <div class="image">
                        <!-- <img src="<?php echo e(asset('themes/frontend/assets/v1/img/vihangNaik.jpg')); ?>"  class="img-fluid"  alt="Vihang Naik"  title="Vihang Naik"     >			 -->
                        <?php if($fundManMdl->media != null && $fundManMdl->media['path']): ?>
                                                <img src="<?php echo e($defDataArr['media_folder'] . $fundManMdl->media->path); ?>"
                                                    alt="<?php echo e($fundManMdl->media->alt); ?>" title="<?php echo e($fundManMdl->media->title); ?>"
                                                    class="img-fluid" />
                                            <?php endif; ?>														

                    </div>
                    <div class="team-content text-center">
                        <h3 class="team-title title-color"><?php echo e($fundManMdl->name); ?>, <?php echo e($fundManMdl->designation ? $fundManMdl->designation : ''); ?></h3>
                        <div class="text"><?php echo e($fundManMdl->company_name ? $fundManMdl->company_name  : ''); ?></div>
                    </div>
                    <!-- <div class="social-box">
                        <a href="#"><i class="icon-linkedin-2"></i></a>
                        <a href="#"><i class="icon-twiter"></i></a>
                        <a href="#"><i class="icon-intragram"></i></a>
                        <a href="#"><i class="icon-facebook-2"></i></a>
                    </div> -->
                </div>
            </div>
            <!-- Content Section -->
            <div class="sc-team-content sc-pl-50 sc-md-pl-0 col-lg-7 sc-md-mt-45 sal-animate" data-sal="slide-left" data-sal-duration="800">
                <div class="inner-column">
                    <h2 class="sc-mb-30">Meet The Fund Expert</h2>
                    <p><?php echo $fundManMdl->description; ?></p>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<section class="compare_section section">
    <div class="container">
        <div class="row">
            <div class="single-features-style1-box mb-4">
                <div class="col-md-12 aos-init" data-aos="fade-up" data-aos-duration="1000">
                    <div class="text-box d-block d-sm-flex align-items-center">
                        <h4>Experts Interviews</h4>					
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">		
			
			<?php $__currentLoopData = $fundManListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>			
            <div class="col-md-3 mb-4">
                <div class="money_left_sec aos-init" data-aos="fade-up" data-aos-duration="1000">
                 	<img src="<?php echo e($defDataArr['media_folder'] . $record->media->path); ?>" alt="<?php echo e($record->media->alt); ?>" title="<?php echo e($record->media->title); ?>" class="img-fluid" />
                </div>
                <div class="money_right_section expertHeight aos-init" data-aos="fade-up" data-aos-duration="1000">	
                    <a href="<?php echo e(route('web.fundman', $record->slug)); ?>"><h4><?php echo e($record->name); ?></h4></a>				
					<p>
                        <?php echo e($record->designation); ?> <br>
                        <?php echo e($record->company_name); ?>

                    </p>
                 
                </div>
            </div> 
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
            
			
               
        </div>
       
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund-man.blade.php ENDPATH**/ ?>