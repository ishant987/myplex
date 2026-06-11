<?php
    $loggedInUser = Auth::user();
    $whiteLabelBranding = $loggedInUser ? $loggedInUser->whiteLabelBranding() : [
        'is_white_label' => false,
        'company_name' => null,
        'logo_url' => asset('themes/frontend/assets/infosolz/images/small_logo.png'),
        'header_logo_url' => asset('themes/frontend/assets/v1/img/logo_dash.png'),
        'has_custom_logo' => false,
    ];
    $whiteLabelBrandingJson = json_encode([
        'isWhiteLabel' => !empty($whiteLabelBranding['is_white_label']),
        'companyName' => $whiteLabelBranding['company_name'],
        'logoUrl' => $whiteLabelBranding['logo_url'],
    ]);
    $subscriptionNotice = null;

    if ($loggedInUser) {
        $today = \Carbon\Carbon::today();
        $activeSubscriptions = $loggedInUser->razorpaySubscriptions()
            ->with('plan')
            ->whereIn('status', ['a', 'active'])
            ->get()
            ->filter(function ($subscription) use ($today) {
                $expiry = $subscription->ends_at ?: $subscription->subscription_expiry_date;

                return !empty($expiry) && \Carbon\Carbon::parse($expiry)->endOfDay()->gte($today);
            });

        $whiteLabelSubscription = $activeSubscriptions
            ->first(function ($subscription) {
                return strtolower((string) optional($subscription->plan)->slug) === 'white-label'
                    || strtolower((string) $subscription->subscription_type) === 'white-label';
            });

        $standardSubscription = $activeSubscriptions
            ->first(function ($subscription) {
                $slug = strtolower((string) optional($subscription->plan)->slug);
                $type = strtolower((string) $subscription->subscription_type);

                return in_array($slug, ['basic', 'premium'], true)
                    || in_array($type, ['basic', 'premium'], true);
            });

        $renewalNoticeDays = 15;

        if ($loggedInUser->subscription_status === 'trial' && !empty($loggedInUser->subscription_expiry_date)) {
            $trialExpiry = \Carbon\Carbon::parse($loggedInUser->subscription_expiry_date);
            if ($trialExpiry->copy()->endOfDay()->lt($today) || $today->gte($trialExpiry->copy()->subDays($renewalNoticeDays)->startOfDay())) {
                $subscriptionNotice = [
                    'type' => $trialExpiry->copy()->endOfDay()->lt($today) ? 'expired' : 'renew',
                    'expiry' => $trialExpiry,
                    'message' => $trialExpiry->copy()->endOfDay()->lt($today)
                        ? 'Trial is expired, Please renew'
                        : 'Trial subscription will expire on',
                ];
            }
        } elseif ($whiteLabelSubscription) {
            $whiteLabelExpiry = \Carbon\Carbon::parse($whiteLabelSubscription->ends_at ?: $whiteLabelSubscription->subscription_expiry_date);
            if ($whiteLabelExpiry->copy()->endOfDay()->lt($today) || $today->gte($whiteLabelExpiry->copy()->subDays($renewalNoticeDays)->startOfDay())) {
                $subscriptionNotice = [
                    'type' => $whiteLabelExpiry->copy()->endOfDay()->lt($today) ? 'expired' : 'renew',
                    'expiry' => $whiteLabelExpiry,
                    'message' => $whiteLabelExpiry->copy()->endOfDay()->lt($today)
                        ? 'White label subscription is expired, Please renew'
                        : 'White label subscription will expire on',
                ];
            }
        } elseif ($standardSubscription) {
            $standardExpiry = \Carbon\Carbon::parse($standardSubscription->ends_at ?: $standardSubscription->subscription_expiry_date);
            if ($standardExpiry->copy()->endOfDay()->lt($today) || $today->gte($standardExpiry->copy()->subDays($renewalNoticeDays)->startOfDay())) {
                $subscriptionNotice = [
                    'type' => $standardExpiry->copy()->endOfDay()->lt($today) ? 'expired' : 'renew',
                    'expiry' => $standardExpiry,
                    'message' => $standardExpiry->copy()->endOfDay()->lt($today)
                        ? 'Subscription is expired, Please renew'
                        : 'Subscription will expire on',
                ];
            }
        } elseif (!empty($loggedInUser->subscription_expiry_date)) {
            $fallbackExpiry = \Carbon\Carbon::parse($loggedInUser->subscription_expiry_date);
            if ($fallbackExpiry->copy()->endOfDay()->lt($today)) {
                $subscriptionNotice = [
                    'type' => 'expired',
                    'expiry' => $fallbackExpiry,
                    'message' => 'Subscription is expired, Please renew',
                ];
            }
        }
    }
?>
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
                            <img class="logo1" src="<?php echo e($whiteLabelBranding['header_logo_url']); ?>" alt="<?php echo e($whiteLabelBranding['company_name'] ?: 'myplexus'); ?>">
                            <img class="logo2" src="<?php echo e($whiteLabelBranding['logo_url']); ?>" alt="<?php echo e($whiteLabelBranding['company_name'] ?: 'myplexus'); ?>">
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
                <?php if($subscriptionNotice): ?>
                <div class="subscription_heading">
                        <div class="sub_in_pdng">
                        <div class="subs_in">
                        <a href="<?php echo e(route('web.subscriptions.index')); ?>">Renew</a>
                        <?php if($subscriptionNotice['type'] === 'expired'): ?>
                            <p><?php echo e($subscriptionNotice['message']); ?></p>
                        <?php else: ?>
                            <p><?php echo e($subscriptionNotice['message']); ?></p> <?php echo e($subscriptionNotice['expiry']->format('d/m/Y')); ?>, Please renew
                        <?php endif; ?>

                        <i class="fa-solid fa-xmark close"></i>
                        </div>
                   </div>
                </div>
                <?php endif; ?>
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
                        <li <?php if(isset($active_menu) && $active_menu == 'model_portfolio'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route('user.model_portfolio')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/model.png')); ?>" alt="">Model Portfolio
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
                        <?php if(!empty($whiteLabelBranding['is_white_label'])): ?>
                            <li <?php if(isset($active_menu) && $active_menu == 'white_label_branding'): ?> class="active" <?php endif; ?>>
                                <a href="<?php echo e(route('user.white_label.branding')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/model.png')); ?>" alt="">White Label Branding</a>
                            </li>
                        <?php endif; ?>
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
        <script>
            window.myplexBranding = <?php echo $whiteLabelBrandingJson; ?>;
        </script>
        <?php echo $__env->make('web.layout.includes.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/infosolz_user_app.blade.php ENDPATH**/ ?>