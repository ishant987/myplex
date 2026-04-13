<?php $attributes = $attributes->exceptProps([
    'name'=>'delete',
    'id'=>'delete',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.multiple_delete_txt'),
    'form_name' => 'listDataForm',
    'message' => '',
]); ?>
<?php foreach (array_filter(([
    'name'=>'delete',
    'id'=>'delete',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.multiple_delete_txt'),
    'form_name' => 'listDataForm',
    'message' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<button id="<?php echo e($id); ?>" <?php echo e($attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-danger f-right m-r-5 '.$class ])); ?> type="submit" name="<?php echo e($name); ?>" data-toggle="tooltip" data-placement="<?php echo e($placement); ?>" data-trigger="hover" data-original-title="<?php echo e($title); ?>" onclick="return bulkDelete(this, '<?php echo e($form_name); ?>', '<?php echo e($message); ?>');"><i class="icofont icofont-ui-delete"></i></button><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/components/form/btn_multi_delete.blade.php ENDPATH**/ ?>