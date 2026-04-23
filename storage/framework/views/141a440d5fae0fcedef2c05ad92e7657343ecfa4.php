<?php $attributes = $attributes->exceptProps([
    'url' => '#',
    'class' => '',
    'id' => '',
    'title' => '',
    'target' => '',
    'message' => '',
    'role' => ''
]); ?>
<?php foreach (array_filter(([
    'url' => '#',
    'class' => '',
    'id' => '',
    'title' => '',
    'target' => '',
    'message' => '',
    'role' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<a <?php if($class): ?> class="<?php echo e($class); ?>" <?php endif; ?> href="<?php echo e($url); ?>" <?php if($title != ''): ?> title="<?php echo e($title); ?>" <?php endif; ?> <?php if($target != ''): ?> target="<?php echo e($target); ?>" <?php endif; ?> <?php if($message != ''): ?> data-message="<?php echo e($message); ?>" <?php endif; ?>  <?php if($id != ''): ?> id="<?php echo e($id); ?>" <?php endif; ?> <?php if($role != ''): ?> role="<?php echo e($role); ?>" <?php endif; ?>><?php echo e($slot); ?></a>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/link.blade.php ENDPATH**/ ?>