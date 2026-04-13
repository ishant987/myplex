<?php $attributes = $attributes->exceptProps([
'id' => '',
'class' => 'form-control',
]); ?>
<?php foreach (array_filter(([
'id' => '',
'class' => 'form-control',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<input id="<?php echo e($id); ?>" <?php echo e($attributes->merge(['class' => $class ])); ?> type="password">
<span toggle="#<?php echo e($id); ?>" class="fa fa-fw fa-eye field-icon toggle-password"></span><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/components/form/field/password.blade.php ENDPATH**/ ?>