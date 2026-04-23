<?php $attributes = $attributes->exceptProps([
    'name' => 'media_id',
    'id' => '',
    'class' => '',
    'type' => 'button',
    'text' => ''
]); ?>
<?php foreach (array_filter(([
    'name' => 'media_id',
    'id' => '',
    'class' => '',
    'type' => 'button',
    'text' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => 'btn '.$class ])); ?> name="<?php echo e($name); ?>" <?php if($id): ?> id="<?php echo e($id); ?>" <?php endif; ?>><?php echo e($text); ?></button><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/field/button_def.blade.php ENDPATH**/ ?>