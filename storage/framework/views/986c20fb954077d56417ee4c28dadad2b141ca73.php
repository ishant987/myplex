<meta charset="utf-8">
<link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.png')); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="base-url" content="<?php echo e(url('/')); ?>">
<title><?php echo $__env->yieldContent('page-title'); ?> | <?php echo e(config('app.name')); ?></title>
<?php if(View::hasSection('meta-keywords')): ?>
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta-keywords'); ?>">
<?php endif; ?>
<?php if(View::hasSection('meta-description')): ?>
    <meta name="description" content="<?php echo $__env->yieldContent('meta-description'); ?>">
<?php endif; ?>
<?php if(View::hasSection('meta-description')): ?>
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta-description'); ?>">
<?php endif; ?>
<meta property="og:locale" content="en_US" />
<meta property="og:site_name" content="<?php echo e(config('app.name')); ?>" />
<meta property="og:type" content="article">
<!-- <meta property="og:url" content="<?php echo $__env->yieldContent('cur-url'); ?>" />
<meta property="og:title" content="<?php echo $__env->yieldContent('meta-title'); ?>" /> -->
<meta property="og:url" content="<?php echo e(config('app.name')); ?>" />
<meta property="og:title" content="<?php echo e(config('app.name')); ?>" />
<meta property="og:image" content="<?php echo e(config('app.name')); ?>" />

<?php if(View::hasSection('meta-image')): ?>
<!-- <meta property="og:image" content="<?php echo $__env->yieldContent('meta-image'); ?>" /> -->
<?php endif; ?>
<?php if(View::hasSection('moneycontrol')): ?>
    <link rel="stylesheet" href="https://stat.moneycontrol.co.in/mccss/mcradar/https_style.css?ver=1.6" />
<?php endif; ?>
<link href="<?php echo e(asset('themes/frontend/assets/v1/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo e(asset('themes/frontend/assets/v1/css/style.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

<link href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="<?php echo e(asset('themes/frontend/assets/v1/css/all.min.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://unpkg.com/phosphor-icons"></script>
<?php echo $__env->yieldPushContent('style'); ?>
<style>
    .live-market-data .live-market-wrap {
        position: relative;
        /* top: -20px; */
        z-index: 99;
        background: #fff;
        /* border: 1px solid #d9d9d9; */
        border-radius: 5px;
        padding: 10px 15px;
    }

    .live-market-data .live-market-wrap #marketRadar {
        width: 100%;
        border: 0;
        box-shadow: none;
    }


    .live-market-data .live-market-wrap .tpSec {
        background: transparent !important;
    }

    .live-market-data .live-market-wrap .stockDsl {
        margin: 0 !important;
        width: 100% !important;
        float: right !important;
    }

    .live-market-data .live-market-wrap #marketRadar .stockDsl .mrdBox {
        height: 100%;
    }

    .live-market-data .live-market-wrap p {
        line-height: 16px;
    }
</style>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/includes/head.blade.php ENDPATH**/ ?>