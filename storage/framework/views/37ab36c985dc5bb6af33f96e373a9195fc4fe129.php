<?php $__env->startSection('captcha'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('jquery-validate'); ?> <?php $__env->stopSection(); ?>
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
<div class="custom-banner no-bg faq-banner">
	<div class="container">
		<?php if(isset($dataArr['custom_fields']['textarea_29'])): ?>
		<h1 class="f-b"><?php echo nl2br($dataArr['custom_fields']['textarea_29']['value']); ?></h1>
		<?php endif; ?>
	</div>
</div>

<div class="faq-main">
	<div class="container">
		<?php echo $dataArr['descp']; ?>

		<div class="faq-wrap">
			<?php if(count($dataArr['faqs']) == 0): ?>
			<p><?php echo e(__('message.data_not_available')); ?></p>
			<?php else: ?>
			<div id="accordion">
				<?php $__currentLoopData = $dataArr['faqs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="card">
					<div class="card-header" id="heading_<?php echo e($faq->faq_id); ?>">
						<h5 class="mb-0">
							<button class="btn btn-link<?php echo e(($index == 0)?'':' collapsed'); ?>" data-toggle="collapse" data-target="#collapse_<?php echo e($faq->faq_id); ?>" aria-expanded="<?php echo e(($index == 0)?'true':'false'); ?>" aria-controls="collapse_<?php echo e($faq->faq_id); ?>">
								<?php echo e($faq->title); ?>

							</button>
						</h5>
					</div>
					<div id="collapse_<?php echo e($faq->faq_id); ?>" class="collapse<?php echo e(($index == 0)?' show':''); ?>" aria-labelledby="heading_<?php echo e($faq->faq_id); ?>" data-parent="#accordion">
						<div class="card-body">
							<?php if($faq->descp): ?>
							<p><?php echo nl2br($faq->descp); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php echo $__env->make('themes.frontend.includes.patshala-newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/faq.blade.php ENDPATH**/ ?>