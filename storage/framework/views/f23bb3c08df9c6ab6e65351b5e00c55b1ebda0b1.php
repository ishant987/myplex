<?php $attributes = $attributes->exceptProps([
    'name'=>'tp_rst_btn',
    'id'=>'tp_rst_btn',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.reset_txt'),
    'text' => __('admin.reset_txt'),
]); ?>
<?php foreach (array_filter(([
    'name'=>'tp_rst_btn',
    'id'=>'tp_rst_btn',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.reset_txt'),
    'text' => __('admin.reset_txt'),
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button id="<?php echo e($id); ?>" <?php echo e($attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-c-p btn-warning '.$class ])); ?> type="submit" name="<?php echo e($name); ?>" data-toggle="tooltip" data-placement="<?php echo e($placement); ?>" data-trigger="hover" data-original-title="<?php echo e($title); ?>" onclick="return resetfilter();"><?php echo e($text); ?></button><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/btn_reset.blade.php ENDPATH**/ ?>