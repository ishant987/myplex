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

<div class="fund-experts-wrap">
	<div class="container">
		<div class="row">

			<div class="col-lg-7 col-md-7 col-sm-12 fund-expert-lft">
				<h3><?php echo e($dataArr['title']); ?></h3>
				<div class="row align-items-center">
					<div class="col-lg-5 col-md-6 col-sm-12 fund-el-profile-lft">
						<?php if( $fundManMdl->media != null ): ?>
						<?php if( $fundManMdl->media['path'] ): ?>
						<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'].$fundManMdl->media->path).'','alt' => ''.e($fundManMdl->media->alt).'','title' => ''.e($fundManMdl->media->title).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'].$fundManMdl->media->path).'','alt' => ''.e($fundManMdl->media->alt).'','title' => ''.e($fundManMdl->media->title).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
						<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="col-lg-7 col-md-6 colsm-12 fund-el-profile-rgt">
						<span class="name"><?php echo e($fundManMdl->name); ?></span>
						<?php if($fundManMdl->designation): ?>
						<span class="title-1"><?php echo e($fundManMdl->designation); ?></span>
						<?php endif; ?>
						<?php if($fundManMdl->company_name): ?>
						<span class="title-2"><?php echo e($fundManMdl->company_name); ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="fund-expert-p-para">
					<?php echo $fundManMdl->description; ?>

				</div>
				<?php if($fundManMdl->disclaimer || $fundManMdl->disclaimer_note): ?>
				<div class="disclaimer-bottom">
					<?php if($fundManMdl->disclaimer): ?>
					<div class="disclaimer-wrap br-5 box-shadow border-s bg-gry text-green-h">
						<?php echo $fundManMdl->disclaimer; ?>

					</div>
					<?php endif; ?>
					<?php if($fundManMdl->disclaimer_note): ?>
					<div class="disclaimer-note">
						<h6 class="text-green"><?php echo nl2br($fundManMdl->disclaimer_note); ?></h6>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="col-lg-5 col-md-5 col-sm-12 fund-expert-rgt">
				<?php if(isset($dataArr['custom_fields']['textarea_53'])): ?>
				<h3 class="text-green"><?php echo nl2br($dataArr['custom_fields']['textarea_53']['value']); ?></h3>
				<?php endif; ?>
				<div class="experts-interviews-wrap">
					<?php if(count($fundManListMdl) > 0): ?>
					<?php $__currentLoopData = $fundManListMdl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="row align-items-center">
						<div class="col-lg-6 col-md-6 col-sm-12 fund-el-profile-lft expert-interviews-lft">
							<?php if( $record->media != null ): ?>
							<?php if( $record->media['path'] ): ?>
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundman', $record->slug)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundman', $record->slug)).'']); ?>
								<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e($defDataArr['media_folder'].$record->media->path).'','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'','class' => 'img-fluid']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e($defDataArr['media_folder'].$record->media->path).'','alt' => ''.e($record->media->alt).'','title' => ''.e($record->media->title).'','class' => 'img-fluid']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
						</div>
						<div class="col-lg-6 col-md-6 colsm-12 expert-interviews-rgt">
							<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link','data' => ['url' => ''.e(route('web.fundman', $record->slug)).'']]); ?>
<?php $component->withName('link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['url' => ''.e(route('web.fundman', $record->slug)).'']); ?>
								<span class="name"><?php echo e($record->name); ?></span>
							 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							<?php if($record->designation): ?>
							<span class="title-1"><?php echo e($record->designation); ?></span>
							<?php endif; ?>
							<?php if($record->company_name): ?>
							<span class="title-2"><?php echo e($record->company_name); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/fund-man.blade.php ENDPATH**/ ?>