<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>
                <?php if(isset($browser_title)): ?> myplexus | <?php echo e($browser_title); ?> <?php else: ?> myplexus | Ratio <?php endif; ?>
            </title>
            <link rel="shortcut icon" href="<?php echo e(asset('themes/frontend/assets/infosolz/images/favicon.png')); ?>" type="image/x-icon">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/all.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/jquery-ui.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/login.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/style.css')); ?>">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
            
            <link href="<?php echo e(asset('themes/frontend/assets/v1/css/datatable-common.css')); ?>" rel="stylesheet" />

            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
            

            
        </head>
        <body>
            
        <div class="preloader hide_pre_loader"><div class="animate"></div></div>

        <header class="head">
                <div class="top_bar">
                    <div class="tgl_menu">
                        <a href="<?php echo e(route('user.auth-dashboard')); ?>" class="inner_logo">
                            <img class="logo1" src="<?php echo e(asset('themes/frontend/assets/v1/img/logo_dash.png')); ?>" alt="">
                            <img class="logo2" src="<?php echo e(asset('themes/frontend/assets/infosolz/images/small_logo.png')); ?>" alt="">
                        </a>
                        <div id="toggle">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div>
                    </div>
                    <ul class="welcome">
                        <li><a href="#"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt=""><span>Welcome</span> <?php echo e((Auth::user()->f_name !='') ? Auth::user()->f_name : 'User'); ?></a></li>
                        <li><a href="#">
                            <i>
                                <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/noti.png')); ?>" alt="">
                                
                            </i>
                            Notification</a></li>
                        <li><a href="<?php echo e(route('user.logout')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/log.png')); ?>" alt="">Logout</a></li>
                    </ul>
                </div>
                <div class="subscription_heading">
                        <div class="sub_in_pdng">
                        <div class="subs_in">
                        <?php if($expiry_date < $current_date): ?>
                        <!-- red warning--> 
                         <!-- <i class="fa-solid fa-triangle-exclamation red"></i>  -->
                         <a  href="<?php echo e(route('web.subscriptions.index')); ?>">Renew</a>
                         <p>Subscription is expired, Please renew</p>  
                        
                        <?php elseif($current_date <= $fiveDaysBeforeExpiry): ?>
                        <!-- yellow last 4 day before warning-->
                          <!-- <i class="fa-solid fa-triangle-exclamation yellow"></i>  -->
                          <a  href="<?php echo e(route('web.subscriptions.index')); ?>">Renew</a>
                           <p>Subscription will expire on</p> <?php echo e(date('d/m/Y', strtotime($expiry_date))); ?>, Please renew 
                        <?php else: ?>
                        <!-- green subscription warning--> 
                         <!-- <i class="fa-solid fa-bell green"></i> -->
                          <p>Subscription will expire on</p> <?php echo e(date('d/m/Y', strtotime($expiry_date))); ?>

                        <?php endif; ?>

                        <i class="fa-solid fa-xmark close"></i>
                        </div>
                   </div>
                </div>
                <nav class="left_menu same_height">
                    <ul>
                        <li <?php if(isset($active_menu) && $active_menu == 'dashboard'): ?> class="active" <?php endif; ?>><a href="<?php echo e(route('user.ratio_dashboard')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratop_report.png')); ?>" alt="">Ratio Reports</a></li>
                        <li <?php if(isset($active_menu) && $active_menu == 'ratio_analysis_list'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route('user.ratio_analysis')); ?>">
                               <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratio_ana.png')); ?>" alt=""> Ratio Analysis
                            </a>
                        </li>
                        
                        <li <?php if(isset($active_menu) && $active_menu == 'composition_report_list'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route('user.composition_report')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/compos.png')); ?>" alt="">Composition Report
                            </a>
                        </li>
                        <li <?php if(isset($active_menu) && $active_menu == 'indices_report_list'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route('user.indices_report')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/indies.png')); ?>" alt="">Indices Report
                            </a>
                        </li>
                        <li>
                            <a href="#"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/model.png')); ?>" alt="">Model Portfolio
                            </a>
                        </li>
                        <li <?php if(isset($active_menu) && $active_menu == 'filters_list'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route('user.filters')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/filter.png')); ?>" alt="">Filters
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('user.predictive')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/predic.png')); ?>" alt="">Predictive
                            </a>
                        </li>
                        <li <?php if(isset($active_menu) && $active_menu == 'subscription'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route('web.subscriptions.index')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratop_report.png')); ?>" alt="">Subscription Plans</a>
                        </li>
                    </ul>
                </nav>
        </header>
          <?php echo $__env->yieldContent('content'); ?>
          <footer class="main_foot">
            <p>Copyright © <?php echo e(date('Y')); ?> <span>myplexus.com</span>. All Rights Reserved.</p>
          </footer>

            <!-- <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery.min.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery-ui.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/icon.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/main.js')); ?>"></script> -->

            <!-- <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div> -->

            
        </body>
        <?php echo $__env->make('web.layout.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/infosolz_user_app.blade.php ENDPATH**/ ?>