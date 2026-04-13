<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
    
    <?php echo $__env->make('themes.frontend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <div >
    
    <?php echo $__env->make('themes.frontend.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
    
    <?php echo $__env->yieldContent('content'); ?>
    
    
    
    <?php echo $__env->make('themes.frontend.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    
    
    <?php echo $__env->make('themes.frontend.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/themes/frontend/layouts/app.blade.php ENDPATH**/ ?>