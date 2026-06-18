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
<div class="custom-banner no-bg fund-watch-landing-page">
	<div class="container">
		<h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
	</div>
</div>

<div class="blog-wrapper fund-watch-listing">
	<div class="container">
		<div class="blog-inner-wrapper">
			<div class="row">
				<div class="col-lg-9 col-md-12 col-sm-12 fw-listing-cols">
					<div class="row">
						<?php if(count($dataListModel) == 0): ?>
						<p><?php echo e(__('message.data_not_available')); ?></p>
						<?php else: ?>
						<?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="fw-cols-block">
								<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundwatch', $record['fw_id'])).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundwatch', $record['fw_id'])).'']); ?><?php echo e($record['title']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
								<p><?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record['description']), 80); ?></p>
								<span class="date">Posted On <span class="posted-date"><?php echo e(date($dateFormat, strtotime($record['created_at']))); ?></span></span>
							</div>
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</div>
				</div>
				<?php echo $__env->make('themes.frontend.includes.fund-watch-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/fund-watch-list.blade.php ENDPATH**/ ?>