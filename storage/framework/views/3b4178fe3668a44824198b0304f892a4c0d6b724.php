<?php $attributes = $attributes->exceptProps([
    'url',
    'class'=>'b-b-primary text-primary',
    'placement' => 'top',
    'title' => '',
    'target' => ''
]); ?>
<?php foreach (array_filter(([
    'url',
    'class'=>'b-b-primary text-primary',
    'placement' => 'top',
    'title' => '',
    'target' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<a href="<?php echo e($url); ?>" class="<?php echo e($class); ?>" data-toggle="tooltip" data-placement="<?php echo e($placement); ?>" data-trigger="hover" data-original-title="<?php echo e($title); ?>" <?php if($target != ''): ?> target="<?php echo e($target); ?>" <?php endif; ?>><?php echo e($slot); ?></a><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/link_tooltip.blade.php ENDPATH**/ ?>