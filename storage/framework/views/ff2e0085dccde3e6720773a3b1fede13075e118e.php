<?php $attributes = $attributes->exceptProps([
    'url',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.add_new_txt'),
    'target' => ''
]); ?>
<?php foreach (array_filter(([
    'url',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.add_new_txt'),
    'target' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<a href="<?php echo e($url); ?>" <?php echo e($attributes->merge(['class' => 'btn waves-effect waves-light btn-sm f-right btn-primary '.$class ])); ?> data-toggle="tooltip" data-placement="<?php echo e($placement); ?>" data-trigger="hover" data-original-title="<?php echo e($title); ?>" <?php if($target != ''): ?> target="<?php echo e($target); ?>" <?php endif; ?>><i class="icofont icofont-plus"></i></a><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/link_add_new.blade.php ENDPATH**/ ?>