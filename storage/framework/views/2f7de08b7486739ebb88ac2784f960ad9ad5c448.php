<?php $attributes = $attributes->exceptProps([
    'class' => '',
    'type' => 'text',
    'readonly' => false
]); ?>
<?php foreach (array_filter(([
    'class' => '',
    'type' => 'text',
    'readonly' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<input <?php echo e($attributes->merge(['class' => 'form-control '.$class ])); ?> type="<?php echo e($type); ?>" <?php if($readonly): ?> readonly="readonly" <?php endif; ?>>
<?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/components/form/field/text.blade.php ENDPATH**/ ?>