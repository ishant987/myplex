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
<div class="custom-banner no-bg nfo-monitor-banner">
<div class="container">
			<h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
		<?php if($reqYear > 0): ?>
		<h3 class="f-sb text-green"><?php echo e('NFO From '.$reqYear); ?></h1>
		<?php endif; ?>
	</div>
</div>

<div class="nfo-archives">
        <div class="container">
			<?php if(count($dataListModel) == 0): ?>
				<p><?php echo e(__('message.data_not_available')); ?></p>
			<?php else: ?>
				<?php if($reqYear > 0): ?>
					<div class="archive-wrapper">
						<div class="archives-posts">
							<div class="row m-0 archive-row">
							<?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="archive-block">
									<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.nfomonitor', $record['no_id'])).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.nfomonitor', $record['no_id'])).'']); ?><?php echo e($record['fund_name']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
									<?php if($record['objective'] != ''): ?>
										<p><?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record['objective']), 80); ?></p>
									<?php endif; ?>
									<h6>Posted On <span class="archive-post-date"><?php echo e(date($dateFormat, strtotime($record['post_date']))); ?></span></h6>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				<?php else: ?>
					<?php $__currentLoopData = $dataListModel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="archive-wrapper">
						<div class="row m-0 justify-content-between align-items-center">
							<div class="archive-title"><h3><?php echo e($key == 0 ? 'Recent NFO' : 'Archives From '.$record['archive']['year']); ?> <span class="posts-count">(<?php echo e($record['archive']['tot']); ?>)</span></h3></div>
							<div class="archive-view-all">
								<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.nfomonitor.list', $record['archive']['year'])).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.nfomonitor.list', $record['archive']['year'])).'']); ?>View All <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							</div>
						</div>
						<div class="archives-posts">
							<div class="row m-0 archive-row">
								<?php if(count($record['items']) == 0): ?>
									<p><?php echo e(__('message.data_not_available')); ?></p>
								<?php else: ?>
									<?php $__currentLoopData = $record['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="archive-block">
										<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.nfomonitor', $record2['no_id'])).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.nfomonitor', $record2['no_id'])).'']); ?><?php echo e($record2['fund_name']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
										<?php if($record2['objective'] != ''): ?>
											<p><?php echo \App\Lib\Core\Useful::getShortContent(strip_tags($record2['objective']), 80); ?></p>
										<?php endif; ?>
										<h6>Posted On <span class="archive-post-date"><?php echo e(date($dateFormat, strtotime($record2['post_date']))); ?></span></h6>
									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			<?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/nfo-monitor-list.blade.php ENDPATH**/ ?>