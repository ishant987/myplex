<?php $attributes = $attributes->exceptProps([
    'class' => '',
    'id' => '',,
    'required' => '',
    'setdefaultoption' => 'true',
    'defaultoption' => __('admin.def_drop_optn_styl1_txt'),
    'defaultoptionvalue' => '',
    'selected' => '',
    'disabled' => '',
    'readonly' => '',
    'options' => []
]); ?>
<?php foreach (array_filter(([
    'class' => '',
    'id' => '',,
    'required' => '',
    'setdefaultoption' => 'true',
    'defaultoption' => __('admin.def_drop_optn_styl1_txt'),
    'defaultoptionvalue' => '',
    'selected' => '',
    'disabled' => '',
    'readonly' => '',
    'options' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<select id="<?php echo e($id); ?>" <?php echo e($attributes->merge(['class' => 'form-control '.$class ])); ?> <?php if($required == "true"): ?> required="required" <?php endif; ?> <?php if($disabled == "true"): ?> disabled="disabled" <?php endif; ?> <?php if($readonly == "true"): ?> readonly="readonly" <?php endif; ?>>
	<?php if($setdefaultoption): ?><option value="<?php echo e($defaultoptionvalue); ?>"><?php echo e($defaultoption); ?></option><?php endif; ?>
	<?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<option value="<?php echo e($key); ?>" <?php echo e(( isset($selected) && $key == $selected ) ? 'selected' : ''); ?>> 
		<?php echo e($value); ?> 
		</option>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
 </select><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/field/select.blade.php ENDPATH**/ ?>