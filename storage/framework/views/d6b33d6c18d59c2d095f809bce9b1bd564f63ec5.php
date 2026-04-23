<?php $attributes = $attributes->exceptProps([
'class' => '',
'label' => '',
'name' => '',
'id' => '',
'value' => '',
'checked' => '',
'required' => '',
'disabled' => '',
'readonly' => ''
]); ?>
<?php foreach (array_filter(([
'class' => '',
'label' => '',
'name' => '',
'id' => '',
'value' => '',
'checked' => '',
'required' => '',
'disabled' => '',
'readonly' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<input class="form-check-input <?php echo e($class); ?>" id="<?php echo e($id); ?>" type="radio" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" <?php if( ($checked != "" && $value != "") && ($value == $checked) ): ?> checked="checked" <?php endif; ?> <?php if($required == "true"): ?> required="required" <?php endif; ?> <?php if($disabled == "true"): ?> disabled="disabled" <?php endif; ?> <?php if($readonly == "true"): ?> readonly="readonly" <?php endif; ?>>
<label class="form-check-label" for="<?php echo e($id); ?>"><?php echo e($label); ?></label>
<div class="check"></div>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/field/radio2.blade.php ENDPATH**/ ?>