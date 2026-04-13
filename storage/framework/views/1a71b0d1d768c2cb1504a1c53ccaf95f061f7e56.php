<?php $attributes = $attributes->exceptProps(['theme' => 'border', 'type' => 'info', 'title'=>'', 'message'=>'']); ?>
<?php foreach (array_filter((['theme' => 'border', 'type' => 'info', 'title'=>'', 'message'=>'']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php if($type): ?>
<div <?php echo e($attributes->merge(['class' => 'alert alert-'.$type.' '.$theme.'-'.$type])); ?>>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
	<?php if($title): ?>
	<strong><?php echo $title; ?>&nbsp;</strong>
	<?php endif; ?>  
	<?php echo $message; ?>

</div>
<?php endif; ?>

<?php if(count($errors) > 0): ?>
  <div class="alert alert-danger <?php echo e($theme.'-danger'); ?>">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
      <ul>
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
  </div>
<?php endif; ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/alert.blade.php ENDPATH**/ ?>