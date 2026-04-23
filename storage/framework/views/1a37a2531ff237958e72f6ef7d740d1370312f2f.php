<?php $__env->startSection('datatables'); ?> <?php $__env->stopSection(); ?>
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
<div class="custom-banner no-bg fw-banner monthly-ranking">
	<div class="container">
		<div class="banner-align-lft fw-title">
			<h1 class="f-b"><?php echo e($dataArr['title']); ?></h1>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="mutual-fund-table">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<table id='mutualFundDictionaryTable' class="box-shadow">
					<thead>
						<tr>
							<th><?php echo e(__('web.mutualfunddictionary.col1_txt')); ?></th>
							<th><?php echo e(__('web.mutualfunddictionary.col2_txt')); ?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
	$(document).ready(function() {
		$('#mutualFundDictionaryTable').DataTable({
			processing: true,
			serverSide: true,
			"aLengthMenu": [
				[50, 100, 200, 500, 1000],
				[50, 100, 200, 500, 1000]
			],
			"iDisplayLength": 50,
			ajax: "<?php echo e(route('web.mutualfunddictionary.list')); ?>",
			columns: [{
					data: 'title'
				},
				{
					data: 'description'
				},
			]
		});
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('themes.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/pages/mutual-fund-dictionary.blade.php ENDPATH**/ ?>