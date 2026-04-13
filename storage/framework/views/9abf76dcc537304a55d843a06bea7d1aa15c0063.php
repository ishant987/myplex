<?php $attributes = $attributes->exceptProps([
    'class' => ''
]); ?>
<?php foreach (array_filter(([
    'class' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<input <?php echo e($attributes->merge(['class' => 'form-control '.$class ])); ?> type="file"><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/components/form/field/file.blade.php ENDPATH**/ ?>