<?php $attributes = $attributes->exceptProps(['class' => '']); ?>
<?php foreach (array_filter((['class' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<h4 <?php echo e($attributes->merge(['class' => 'sub-title '.$class ])); ?>><?php echo e($slot); ?></h4><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/section_label.blade.php ENDPATH**/ ?>