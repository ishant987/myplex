<?php $__env->startSection('content'); ?>

<div class="inner_main">
            <div class="page_detail">
                    <div class="inner_padding">
                        <div class="profile_panel">
                            <div class="profile_panel__identity">
                                <div class="profile_panel__avatar">
                                    <?php echo e(strtoupper(substr(trim(($userdetails->f_name ?? 'U') . ' ' . ($userdetails->l_name ?? '')), 0, 1))); ?>

                                </div>
                                <div class="profile_panel__meta">
                                    <p class="profile_panel__label">My Profile</p>
                                    <h2><?php echo e(trim(($userdetails->f_name ?? '') . ' ' . ($userdetails->l_name ?? '')) ?: 'User Profile'); ?></h2>
                                    <p><?php echo e($userdetails->email ?? '-'); ?></p>
                                </div>
                            </div>
                            <div class="profile_panel__details">
                                <div class="profile_panel__item">
                                    <span>Mobile</span>
                                    <strong><?php echo e($userdetails->mobile ?: '-'); ?></strong>
                                </div>
                                <div class="profile_panel__item">
                                    <span>Subscription</span>
                                    <strong><?php echo e(ucfirst($userdetails->subscription_status ?: ($has_active_subscription ? 'active' : 'trial'))); ?></strong>
                                </div>
                                <div class="profile_panel__item">
                                    <span>Expiry</span>
                                    <strong><?php echo e(!empty($expiry_date) ? date('d M Y', strtotime($expiry_date)) : '-'); ?></strong>
                                </div>
                            </div>
                            <div class="profile_panel__actions">
                                <a href="<?php echo e(route('web.edit.profile')); ?>" class="profile_btn primary">Edit Profile</a>
                                <a href="<?php echo e(route('web.reset.password')); ?>" class="profile_btn secondary">Reset Password</a>
                            </div>
                        </div>

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
                                <li>
                                    <a href="<?php echo e(route('user.notifications')); ?>">
                                        <figure><img src="<?php echo e(asset('new-images/dh4.png')); ?>" alt=""></figure>
                                        <h4>Notifications</h4>
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

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/dashboard.blade.php ENDPATH**/ ?>