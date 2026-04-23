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
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumbWrapper">
					<?php echo e(Breadcrumbs::render('web.page', $dataArr)); ?>

				</div>
			</div>
		</div>
	</div>
</section>

<?php echo $__env->make('themes.frontend.includes.user-account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="eventslikeSections">
	<div class="container">
		<div class="row">
			
			<?php if(session()->has('alert')): ?>
			<div class="col-md-12">
				<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.alert','data' => ['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']]); ?>
<?php $component->withName('form.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => ''.e(session()->get('alert')).'','title' => ''.e(session()->get('title')).'','message' => ''.e(session()->get('message')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
			</div>
			<?php endif; ?>
			

			<?php if(count($dataList) == 0): ?>
				<div class="col-md-12"><p><?php echo e(__('message.data_not_available')); ?></p></div>
			<?php else: ?>
				<div class="col-md-6 text-left">
					<p class="total-draft"><?php echo e($dataList->total()); ?> <?php if($dataList->total() == 1): ?><?php echo e($defDataArr['askexpert_lang']['draft_txt']); ?><?php else: ?><?php echo e($defDataArr['askexpert_lang']['drafts_txt']); ?><?php endif; ?></p>
				</div>
				<div class="col-md-6 text-right">
					<form action="<?php echo e(route('web.answer.draft.delete', 'all')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<button type="submit" class="delete-draft-all" onclick="return confirm('<?php echo e($defDataArr['askexpert_lang']['warning']['delete_draft']); ?>');">
							<?php echo e($defDataArr['askexpert_lang']['dlt_all_draft_txt']); ?>

						</button>
					</form>
				</div>
				<div class="col-md-12">
					<?php $__currentLoopData = $dataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="textBlocks wow fadeIn" data-wow-duration="500ms" data-wow-delay="600ms">
						<div class="textBlocksInner">
							<label class="label"><?php echo e($defDataArr['askexpert_lang']['question_txt']); ?>:</label>
							<h4><?php echo $answer->question->question; ?></h4>
							<label class="label"><?php echo e($defDataArr['askexpert_lang']['answer_txt']); ?>: </label>
							<p><?php echo $answer->answer; ?></p>
						</div>
						<div class="blockMeta">
							<div class="iconsTag iconsTag w-100">
								<ul>
									<li><div class="edit-draft"><span><a data-fancybox data-type="iframe" data-src="<?php echo e(route('web.draft-answer', $answer->aeqa_id)); ?>" href="javascript:;" title="<?php echo e($defDataArr['askexpert_lang']['edit_draft_txt']); ?>"><?php echo e($defDataArr['askexpert_lang']['edit_draft_txt']); ?></a></span></div></li>
									<li>
										<div class="delete-draft">
											<span>
												<form action="<?php echo e(route('web.answer.draft.delete', $answer->aeqa_id)); ?>" method="post">
													<?php echo e(csrf_field()); ?>

													<button type="submit" class="delete-btn" onclick="return confirm('<?php echo e($defDataArr['askexpert_lang']['warning']['delete_draft']); ?>');">
														<?php echo e($defDataArr['askexpert_lang']['dlt_draft_txt']); ?>

													</button>
												</form>
											</span>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			<?php endif; ?>

			<div class="col-md-12">
				<?php echo e($dataList->links()); ?>

			</div>

		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/draft-answers.blade.php ENDPATH**/ ?>