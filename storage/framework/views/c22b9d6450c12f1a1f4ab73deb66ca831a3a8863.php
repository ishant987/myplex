<?php $attributes = $attributes->exceptProps([
    'class'=> '',
    'fldclass' => '',
    'name',
    'id' => '',
    'value' => '',
    'checked' => '',
    'labelName' => '',
    'required' => '',
    'disabled' => '',
    'readonly' => '',
	'error'=>'',
    'info'=>''
]); ?>
<?php foreach (array_filter(([
    'class'=> '',
    'fldclass' => '',
    'name',
    'id' => '',
    'value' => '',
    'checked' => '',
    'labelName' => '',
    'required' => '',
    'disabled' => '',
    'readonly' => '',
	'error'=>'',
    'info'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="form-group form-check <?php echo e($class); ?>">
	<label class="form-check-label" for="<?php echo e($id?$id:''); ?>">
  	<input id="<?php echo e($id); ?>" type="checkbox" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" <?php if( ($checked != "" && $value != "") && ($value == $checked) ): ?> checked="checked" <?php endif; ?> <?php if($required == "true"): ?> required="required" <?php endif; ?> <?php if($disabled == "true"): ?> disabled="disabled" <?php endif; ?> <?php if($readonly == "true"): ?> readonly="readonly" <?php endif; ?> class="form-check-input <?php echo e($fldclass); ?>"/>
  	<?php if($labelName): ?>
        <span class="checkmark"></span><?php echo e($labelName); ?>

    <?php endif; ?>
    <?php if($info): ?>
        <small class="form-text text-muted"><?php echo $info; ?></small>
    <?php endif; ?>
    <?php if($error): ?>
       <small class="form-text text-error"><?php echo e($error); ?></small>
    <?php endif; ?>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/group_lyt4_checkbox.blade.php ENDPATH**/ ?>