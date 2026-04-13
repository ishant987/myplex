<?php $attributes = $attributes->exceptProps([
    'class' => 'btn-primary',
    'type' => 'submit',
    'text' => __('admin.save_txt'),
    'value' => ''
]); ?>
<?php foreach (array_filter(([
    'class' => 'btn-primary',
    'type' => 'submit',
    'text' => __('admin.save_txt'),
    'value' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => 'btn btn-mat waves-effect waves-light m-b-0 '.$class ])); ?> <?php if($value): ?> value="<?php echo e($value); ?>" <?php endif; ?>><?php echo e($text); ?></button><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/components/form/field/button.blade.php ENDPATH**/ ?>