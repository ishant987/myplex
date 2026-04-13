<?php $attributes = $attributes->exceptProps([
    'style' => 'primary',
    'class'=> '',
    'fldclass' => '',
    'name',
    'id' => '',
    'value' => '',
    'checked' => '',
    'labelName' => '',
    'required' => '',
    'disabled' => '',
    'readonly' => ''
]); ?>
<?php foreach (array_filter(([
    'style' => 'primary',
    'class'=> '',
    'fldclass' => '',
    'name',
    'id' => '',
    'value' => '',
    'checked' => '',
    'labelName' => '',
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
<div class="checkbox-fade fade-in-<?php echo e($style); ?> <?php echo e($class); ?>">
    <label>
       <input id="<?php echo e($id); ?>" type="checkbox" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" <?php if( ($checked != "" && $value != "") && ($value == $checked) ): ?> checked="checked" <?php endif; ?> class="<?php echo e($fldclass); ?>" <?php if($required == "true"): ?> required="required" <?php endif; ?> <?php if($disabled == "true"): ?> disabled="disabled" <?php endif; ?> <?php if($readonly == "true"): ?> readonly="readonly" <?php endif; ?> />
        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-<?php echo e($style); ?>"></i></span>
        <?php if($labelName): ?>
        <span class="text-inverse"><?php echo e($labelName); ?></span>
        <?php endif; ?>
    </label>
</div><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/components/form/field/checkbox.blade.php ENDPATH**/ ?>