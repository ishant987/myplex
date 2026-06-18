<?php $attributes = $attributes->exceptProps([
'id' =>'large-Modal',
'idclass' => '',
'class' => 'modal-lg'
]); ?>
<?php foreach (array_filter(([
'id' =>'large-Modal',
'idclass' => '',
'class' => 'modal-lg'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="modal fade <?php echo e($idclass); ?>" id="<?php echo e($id); ?>" tabindex="-1" role="dialog">
   <div class="modal-dialog <?php echo e($class); ?>" role="document">

      <?php echo e($slot); ?>


   </div>
</div><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/components/form/modal.blade.php ENDPATH**/ ?>