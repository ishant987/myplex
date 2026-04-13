<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<link rel="canonical" href="<?php echo $__env->yieldContent('cur-url'); ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?php echo e('@'.config('app.name')); ?>" />
<meta name="twitter:creator" content="<?php echo e('@'.config('app.name')); ?>" />
<meta name="twitter:title" content="<?php echo $__env->yieldContent('meta-title'); ?>" />
<?php if(View::hasSection('meta-description')): ?>
<meta name="twitter:description" content="<?php echo $__env->yieldContent('meta-description'); ?>">
<?php endif; ?>
<?php if(View::hasSection('meta-image')): ?>
<meta name="twitter:image" content="<?php echo $__env->yieldContent('meta-image'); ?>" />
<?php endif; ?>
<meta property="og:locale" content="en_US" />
<meta property="og:site_name" content="<?php echo e(config('app.name')); ?>" />
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo $__env->yieldContent('cur-url'); ?>" />
<meta property="og:title" content="<?php echo $__env->yieldContent('meta-title'); ?>" />
<?php if(View::hasSection('meta-image')): ?>
<meta property="og:image" content="<?php echo $__env->yieldContent('meta-image'); ?>" />
<?php endif; ?>
<?php if(View::hasSection('meta-description')): ?>
<meta property="og:description" content="<?php echo $__env->yieldContent('meta-description'); ?>">
<?php endif; ?>
<meta property="og:rich_attachment" content="true" />
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('themes/frontend/assets/images/favicon/apple-touch-icon.png')); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('themes/frontend/assets/images/favicon/favicon-32x32.png')); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('themes/frontend/assets/images/favicon/favicon-16x16.png')); ?>">
<link rel="manifest" href="<?php echo e(asset('themes/frontend/assets/images/favicon/site.webmanifest')); ?>">
<link rel="mask-icon" href="<?php echo e(asset('themes/frontend/assets/images/favicon/safari-pinned-tab.svg')); ?>" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php if(View::hasSection('moneycontrol')): ?>
<link rel="stylesheet" href="https://stat.moneycontrol.co.in/mccss/mcradar/https_style.css?ver=1.6" />
<?php endif; ?>
<?php if(View::hasSection('select2')): ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php endif; ?>
<?php if(View::hasSection('owl-carousel')): ?>
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/styles/owl-carousel/owl.carousel.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/styles/owl-carousel/owl.theme.default.min.css')); ?>">
<?php endif; ?>
<?php if(View::hasSection('datatables')): ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<?php endif; ?>
<?php if(View::hasSection('fancybox')): ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('themes/assets/fancybox-v3.2.5/dist/jquery.fancybox.min.css')); ?>" media="screen" />
<?php endif; ?>
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/styles/style.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/styles/responsive.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/styles/dev.css')); ?>">
<?php echo $__env->yieldContent('page-css-styles'); ?>
<?php echo $__env->yieldContent('section-css-styles'); ?>
<?php echo $__env->yieldPushContent('styles'); ?>
<?php echo $__env->yieldContent('canonical'); ?>
<script>
    BFS = {
        base_url: '<?php echo e(Config::get('
        app.url ')); ?>'
    };
</script><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/themes/frontend/includes/head.blade.php ENDPATH**/ ?>