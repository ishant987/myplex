<?php $attributes = $attributes->exceptProps([
    'name'=>'download_img',
    'id'=>'download_img',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.download_img_txt'),
    'form_name' => 'listDataForm',
    'message' => '',
]); ?>
<?php foreach (array_filter(([
    'name'=>'download_img',
    'id'=>'download_img',
    'class'=>'',
    'placement' => 'top',
    'title' => __('admin.download_img_txt'),
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
<button id="<?php echo e($id); ?>" <?php echo e($attributes->merge(['class' => 'btn waves-effect waves-light btn-sm btn-primary f-right m-r-5 '.$class ])); ?> type="submit" name="<?php echo e($name); ?>" data-toggle="tooltip" data-placement="<?php echo e($placement); ?>" data-trigger="hover" data-original-title="<?php echo e($title); ?>" onclick="return bulkImageDownload(this, '<?php echo e($form_name); ?>', '<?php echo e($message); ?>');"><i class="icofont icofont-download-alt"></i></button>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/btn_img_download.blade.php ENDPATH**/ ?>