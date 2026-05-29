<?php $__env->startSection('content'); ?>

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        <div class="all_dash dashboard">
                            <h1 class="page_heading">Dashboard</h1>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('user.ratio_dashboard')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/ratio-reports.png')); ?>" alt=""></figure>
                                        <h4>Ratio Reports</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.ratio_analysis')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/ratio-analysis.png')); ?>" alt=""></figure>
                                        <h4>Ratio Analysis</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.composition_report')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/composition-report.png')); ?>" alt=""></figure>
                                        <h4>Composition <br>Report</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.indices_report')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/indies-report.png')); ?>" alt=""></figure>
                                        <h4>Indices Report</h4>
                                    </a>
                                </li>
                                
                               
                                <li>
                                    <a href="<?php echo e(route('user.filters')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/filters.png')); ?>" alt=""></figure>
                                        <h4>Filters</h4>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo e(route('user.predictive')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/predictive.png')); ?>" alt=""></figure>
                                        <h4>Predictive</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                   
                </div>
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/dashboard.blade.php ENDPATH**/ ?>