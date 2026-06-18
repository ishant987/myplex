<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    
    <?php echo $__env->make('themes.frontend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>

    
    
    <?php echo $__env->yieldContent('content'); ?>
    
    


<?php echo $__env->make('themes.frontend.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/layouts/app-popup.blade.php ENDPATH**/ ?>