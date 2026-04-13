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
			<div class="col-md-12" id="vue-app">
					<mutual-fund-lib></mutual-fund-lib>
			</div>
		</div>
	</div>
</section>
<div class="mutual-fund-table d-none">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 search_dictionary ">
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
	$(document).ready(function() {
		// $('#mutualFundDictionaryTable').DataTable({
		// 	processing: true,
		// 	serverSide: true,
		// 	"aLengthMenu": [
		// 		[50, 100, 200, 500, 1000],
		// 		[50, 100, 200, 500, 1000]
		// 	],
		// 	"iDisplayLength": 50,
		// 	ajax: "<?php echo e(route('web.mutualfunddictionary.list')); ?>",
		// 	columns: [{
		// 			data: 'title'
		// 		},
		// 		{
		// 			data: 'description'
		// 		},
		// 	]
		// });
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/mutual-fund-dictionary.blade.php ENDPATH**/ ?>