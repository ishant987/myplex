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
                            .custom-banner {
                                background-image: url('<?php echo e($dataArr['image_path']); ?>');
                            }
                        </style>
                    <?php $__env->stopPush(); ?>
                <?php endif; ?>
                <?php if($dataArr['full_url']): ?>
                    <?php $__env->startSection('cur-url'); ?><?php echo e($dataArr['full_url']); ?><?php $__env->stopSection(); ?>
                    <?php endif; ?>
                    <?php $__env->startSection('content'); ?>
                        <div class="custom-banner no-bg fund-managers-banner">
                            <div class="container">
                                <?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
                                    <h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
                                <?php endif; ?>
                            </div>
                        </div>
                        <section class="inner_banner_section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="inner_section_banner">
                                            <h4>Meet The Fund Man</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="abt_page_section founder_about pb-0">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="abt_right_img_wrapper" data-aos="fade-up" data-aos-duration="1500">
                                            <?php if($fundManMdl->media != null && $fundManMdl->media['path']): ?>
                                                <img src="<?php echo e($defDataArr['media_folder'] . $fundManMdl->media->path); ?>"
                                                    alt="<?php echo e($fundManMdl->media->alt); ?>" title="<?php echo e($fundManMdl->media->title); ?>"
                                                    class="img-fluid" />
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <div class="page_abt_inner" data-aos="fade-down" data-aos-duration="1000">
                                            <h4><?php echo e($fundManMdl->name); ?>, <?php echo e($fundManMdl->designation ? $fundManMdl->designation : ''); ?></h4>
                                            <h5><?php echo e($fundManMdl->company_name ? $fundManMdl->company_name  : ''); ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
						<section class="interview_sec">
							<div class="container">
								<?php echo $fundManMdl->description; ?>

							</div>
							<div class="disclaimer-note">
								<h6 class="text-green"><?php echo nl2br($fundManMdl->disclaimer_note); ?></h6>
							</div>
						</section>
						<section class="recent_interview">
							<div class="container">
								<h4>Recent Interviews</h4>                 
								<div class="recent_interview_slider">
									<?php $__currentLoopData = $fundManListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="slider_inerr">
										<div class="inter_seen">
											<div class="inter_seen_img">
											<img src="<?php echo e($defDataArr['media_folder'] . $record->media->path); ?>"
											alt="<?php echo e($record->media->alt); ?>"
											title="<?php echo e($record->media->title); ?>" class="img-fluid" />
											</div>
											<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundman', $record->slug)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundman', $record->slug)).'']); ?>
											<h5>
													<?php echo e($record->name); ?>

												</h5>
											 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
											<p><?php echo e($record->designation); ?></p>
											<p><?php echo e($record->company_name); ?></p>
										</div>
									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							</div>
						</section>
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund-man.blade.php ENDPATH**/ ?>