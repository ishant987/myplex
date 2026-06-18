<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
  <head>
    
    <?php echo $__env->make('themes.backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </head>

  <?php if(View::hasSection('themebg-pattern')): ?>
    <body themebg-pattern="<?php echo $__env->yieldContent('themebg-pattern'); ?>">
  <?php else: ?>
    <body>
  <?php endif; ?>

  
  <?php echo $__env->make('themes.backend.includes.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  

  <?php if(View::hasSection('with-header-bar')): ?>
  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <?php echo $__env->yieldContent('content'); ?>
  </div>  
  <?php else: ?>
    <?php echo $__env->yieldContent('content'); ?>
  <?php endif; ?>

  
  <?php echo $__env->make('themes.backend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->make('themes.backend.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  </body>
</html><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/layouts/app-header.blade.php ENDPATH**/ ?>