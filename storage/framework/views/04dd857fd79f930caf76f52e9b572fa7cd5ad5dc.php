<?php $attributes = $attributes->exceptProps([
'label'=>'', 
'for'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>'',
'action'=>''
]); ?>
<?php foreach (array_filter(([
'label'=>'', 
'for'=>'',
'class'=>'',
'error'=>'',
'required'=>'',
'info'=>'',
'action'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="form-group has-primary row <?php echo e($class); ?> <?php echo e($error?'has-danger':''); ?>">
  <label for="<?php echo e($for?$for:''); ?>" class="col-sm-3 col-form-label">
  	<?php echo e($label?$label:''); ?> 
  	<?php if($required == 'true'): ?><span class="required">*</span><?php endif; ?>
  </label>
  <div class="col-sm-7">
    <?php echo e($slot); ?>  
    <?php if($info): ?>
    <div class="col-form-label info"><?php echo e($info); ?></div>
    <?php endif; ?>  
    <?php if($error): ?>
    <div class="col-form-label"><?php echo e($error); ?></div>
    <?php endif; ?>
  </div>
  <div class="col-sm-2">
    <?php if($action): ?>
    <div class="col-form-label action"><?php echo e($action); ?></div>
    <?php endif; ?> 
  </div>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/group_lyt1_3_7_2.blade.php ENDPATH**/ ?>