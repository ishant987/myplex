<?php $attributes = $attributes->exceptProps([
'for'=>'',
'label'=>'', 
 'class'=>'',
 'error'=>''
]); ?>
<?php foreach (array_filter(([
'for'=>'',
'label'=>'', 
 'class'=>'',
 'error'=>''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="form-group form-primary <?php echo e($class); ?> <?php echo e($error?'has-danger':''); ?>">
  <?php echo e($slot); ?>

  <?php if($error): ?>
  <div class="col-form-label"><?php echo e($error); ?></div>
  <?php endif; ?>
  <span class="form-bar"></span>
  <label for="<?php echo e($for?$for:''); ?>" class="float-label"><?php echo e($label?$label:''); ?></label>
</div><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/components/form/group_lyt2.blade.php ENDPATH**/ ?>