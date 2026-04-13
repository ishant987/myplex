<?php $attributes = $attributes->exceptProps([
    'class' => '',
    'type' => 'submit',
    'text'
]); ?>
<?php foreach (array_filter(([
    'class' => '',
    'type' => 'submit',
    'text'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => 'btn btn-primary btn-md btn-block waves-effect waves-light text-center '.$class ])); ?>><?php echo e($text); ?></button><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/components/form/field/button2.blade.php ENDPATH**/ ?>