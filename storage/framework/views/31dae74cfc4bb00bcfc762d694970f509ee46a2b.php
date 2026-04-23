<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
  <head>
    
    <?php echo $__env->make('themes.backend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>    
  </head>
  <body>

  
  <?php echo $__env->make('themes.backend.includes.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
      
      <?php echo $__env->make('themes.backend.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      
      <div class="pcoded-main-container">
        <div class="pcoded-wrapper"> 

          
          <?php echo $__env->make('themes.backend.includes.leftnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          

          <div class="pcoded-content">
            <div class="pcoded-inner-content">
              
              <div class="main-body">
                <div class="page-wrapper p-0">
                  <div class="page-body">
                  
                  <?php echo $__env->make('themes.backend.includes.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                  
                  <?php echo $__env->yieldContent('content'); ?>
                  
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  

  
  <?php echo $__env->make('themes.backend.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  </body>
</html>


<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/backend/layouts/app.blade.php ENDPATH**/ ?>