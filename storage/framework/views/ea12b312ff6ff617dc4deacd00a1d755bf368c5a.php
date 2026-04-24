<?php $__env->startSection('content'); ?>

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        

                        <div class="all_dash">
                            <h1 class="page_heading">Ratio Reports</h1>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('user.quick_ratio')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh1.png')); ?>" alt=""></figure>
                                        <h4>Quick <span>Ratios</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.weekly_snapshot_new')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh2.png')); ?>" alt=""></figure>
                                        <h4>Weekly <span>Snapshot</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.monthly_snapshot_new')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh2.png')); ?>" alt=""></figure>
                                        <h4>Monthly <span>Snapshot</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.fund_factsheet')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh3.png')); ?>" alt=""></figure>
                                        <h4>Fund <span>Factsheet</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.performance_ratios')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh4.png')); ?>" alt=""></figure>
                                        <h4>Performance <span>Ratios</span></h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.quartile_decile')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh5.png')); ?>" alt=""></figure>
                                        <h4>Quartile &amp;<br> Decile</h4>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="<?php echo e(route('user.comparative')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh6.png')); ?>" alt=""></figure>
                                        <h4>Comparative</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.r_square_comparison')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh6.png')); ?>" alt=""></figure>
                                        <h4>R-Square <span>Comparison</span></h4>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>

                        <!-- <div class="dash_boxes">
                            <ul>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 1</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 2</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 3</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 4</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 5</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                                <li>
                                    <div class="box_icon">
                                        <figure><img src="images/box_icon.png" alt=""></figure>
                                        <h4>Ratio 6</h4>
                                    </div>
                                    <p>It is a long established fact that a reader will be...</p>
                                    <a href="#">More <img src="images/right_arw.png" alt=""></a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                   
                </div>
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/ratio_index.blade.php ENDPATH**/ ?>