<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
    
    <?php echo $__env->make('web.layout.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <div >
    
    <?php echo $__env->make('web.layout.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
    
    <?php echo $__env->yieldContent('content'); ?>
    
    
    
    <?php echo $__env->make('web.layout.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    
    
</body>
<?php echo $__env->make('web.layout.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</html><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/web/layout/app.blade.php ENDPATH**/ ?>