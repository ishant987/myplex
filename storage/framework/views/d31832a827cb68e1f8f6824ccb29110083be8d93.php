<?php $__env->startSection('content'); ?>

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        <div class="all_dash">
                            <h1 class="page_heading">Predictive</h1>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route("user.predictive.jensen-alpha")); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/New-Scrips.png')); ?>" alt=""></figure>
                                        <h4>By Jensen's Alpha</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route("user.predictive.sharp-ratio")); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Indices-Composition.png')); ?>" alt=""></figure>
                                        <h4>By Sharpe</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route("user.predictive.trenyor")); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Occurrence-Report.png')); ?>" alt=""></figure>
                                        <h4>By Treynor</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                </div>
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/predictive/index.blade.php ENDPATH**/ ?>