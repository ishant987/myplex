<?php $attributes = $attributes->exceptProps([
    'src',
    'class' => '',
    'id' => '',
    'alt' => config('app.name'),
    'title' => '',
    'width' => '',
    'height' => '',
    'data_id' => ''
]); ?>
<?php foreach (array_filter(([
    'src',
    'class' => '',
    'id' => '',
    'alt' => config('app.name'),
    'title' => '',
    'width' => '',
    'height' => '',
    'data_id' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<img src="<?php echo e($src); ?>" <?php if($class): ?> class="<?php echo e($class); ?>" <?php endif; ?> alt="<?php if($alt): ?><?php echo $alt; ?><?php else: ?><?php echo config('app.name'); ?><?php endif; ?>" <?php if($title): ?> title="<?php echo $title; ?>" <?php endif; ?> <?php if($width == true): ?> width="<?php echo e($width); ?>" <?php endif; ?> <?php if($height == true): ?> height="<?php echo e($height); ?>" <?php endif; ?> <?php if($data_id): ?> data-id="<?php echo e($data_id); ?>" <?php endif; ?> <?php if($id != ''): ?> id="<?php echo e($id); ?>" <?php endif; ?>><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/components/img.blade.php ENDPATH**/ ?>