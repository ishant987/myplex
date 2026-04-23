<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
  <head>
    
    <?php echo $__env->make('themes.backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </head>

  <body>

  
  <?php if(View::hasSection('preloader')): ?>
  <?php echo $__env->make('themes.backend.includes.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>
  
  <!-- Container-fluid starts -->
  <?php echo $__env->yieldContent('content'); ?>

  
  <?php echo $__env->make('themes.backend.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  </body>
</html><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/layouts/app-modal.blade.php ENDPATH**/ ?>