<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
  <head>
    
    <?php echo $__env->make('themes.backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </head>

  <body <?php echo $__env->yieldContent('themebg-pattern'); ?>>

  
  <?php echo $__env->make('themes.backend.includes.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  

<section <?php echo $__env->yieldContent('section-class'); ?>>
  <!-- Container-fluid starts -->
  <div class="container">
      <div class="row">
          <div class="col-sm-12">
            <!-- Authentication card start -->
            <?php echo $__env->yieldContent('content'); ?>
            <!-- end of form -->
          </div>
          <!-- end of col-sm-12 -->
      </div>
      <!-- end of row -->
  </div>
  <!-- end of container-fluid -->
</section> 

  
  <?php echo $__env->make('themes.backend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->make('themes.backend.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  </body>
</html><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/themes/backend/layouts/app-no-header.blade.php ENDPATH**/ ?>