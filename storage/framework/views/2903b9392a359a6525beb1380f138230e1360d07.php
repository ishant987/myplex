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
<button type="button" <?php echo e($attributes->merge(['class' => 'close '.$class ])); ?> data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/field/button_model.blade.php ENDPATH**/ ?>