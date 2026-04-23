<?php $attributes = $attributes->exceptProps([
    'class' => '',
    'value' => '',
    'rows' => 5
]); ?>
<?php foreach (array_filter(([
    'class' => '',
    'value' => '',
    'rows' => 5
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<textarea <?php echo e($attributes->merge(['class' => 'form-control '.$class ])); ?> rows="<?php echo e($rows); ?>"><?php echo e($value); ?></textarea><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/field/textarea.blade.php ENDPATH**/ ?>