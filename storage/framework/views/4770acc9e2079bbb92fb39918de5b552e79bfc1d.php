<?php $attributes = $attributes->exceptProps([
'for'=>'',
'label'=>'', 
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
]); ?>
<?php foreach (array_filter(([
'for'=>'',
'label'=>'', 
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="form-group col-sm-6 <?php echo e($class); ?> <?php echo e($error?'has-danger':''); ?>">
	<label class="col-form-label" for="<?php echo e($for?$for:''); ?>">
		<?php echo e($label?$label:''); ?>

		<?php if($required == 'true' || $required == 'y'): ?><span class="required">*</span><?php endif; ?>
	</label>
	<?php echo e($slot); ?>

	<?php if($info): ?>
	<small class="form-text text-muted"><?php echo $info; ?></small>
	<?php endif; ?>  
	<?php if($error): ?>
	<small class="form-text text-error"><?php echo e($error); ?></small>
	<?php endif; ?>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/group_lyt3_6_6.blade.php ENDPATH**/ ?>