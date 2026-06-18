<?php $attributes = $attributes->exceptProps([
    'href' => '0',
    'class' => '',
    'src' => ''
]); ?>
<?php foreach (array_filter(([
    'href' => '0',
    'class' => '',
    'src' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<a url="javascript:;" data-href="<?php echo e($href); ?>" data-fancybox-media data-type="iframe" data-src="<?php echo e($src); ?>" id="featuredImg-<?php echo e($href); ?>" <?php echo e($attributes->merge(['class' => 'btn btn-primary btn-mini waves-effect waves-light '.$class ])); ?>><?php echo e($slot); ?></a><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/link_media_popup.blade.php ENDPATH**/ ?>