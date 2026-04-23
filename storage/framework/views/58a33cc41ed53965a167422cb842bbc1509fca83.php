<?php $__env->startSection('content'); ?>

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                    <div class="head_brdcm">
                        <ul class="brdcmb">
                            <li><a href="<?php echo e(route('user.auth-dashboard')); ?>">dashboard</a></li>
                            <li>Indices Report</li>
                        </ul>
                    </div>
                        <div class="all_dash">
                            <h1 class="page_heading">Indices Report</h1>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('user.indices-history')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Indices-History.png')); ?>" alt=""></figure>
                                        <h4>Indices History</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.indices-composition')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Indices-Composition.png')); ?>" alt=""></figure>
                                        <h4>Indices<br> Composition</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.schemes-associated-with-index')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Schemes-Associated-With-Index.png')); ?>" alt=""></figure>
                                        <h4>Schemes<br> Associated <br>With Index</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.indices-report.boomers')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Boomers.png')); ?>" alt=""></figure>
                                        <h4>Boomers</h4>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('user.indices-report.busters')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Busters.png')); ?>" alt=""></figure>
                                        <h4>Busters</h4>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="<?php echo e(route('user.index_vs_NAV')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/Index-vs-NAV.png')); ?>" alt=""></figure>
                                        <h4>Index vs NAV</h4>
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

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/indices-reports/index.blade.php ENDPATH**/ ?>