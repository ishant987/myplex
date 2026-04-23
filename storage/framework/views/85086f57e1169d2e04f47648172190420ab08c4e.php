<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
            <meta name="myplexus-layout-version" content="filters-debug-2026-04-22-01">
            <title>myplexus | Ratio</title>
            <link rel="shortcut icon" href="<?php echo e(asset('themes/frontend/assets/infosolz/images/favicon.png')); ?>" type="image/x-icon">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/all.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/jquery-ui.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/login.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/style.css')); ?>">
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
            <style>
                .select2-container {
                    width: 100% !important;
                }

                .datepicker {
                    cursor: pointer;
                }

                .datepicker-wrap {
                    position: relative;
                    width: 100%;
                }

                .datepicker-wrap .datepicker {
                    padding-right: 44px;
                }

                .datepicker-trigger {
                    position: absolute;
                    top: 50%;
                    right: 10px;
                    transform: translateY(-50%);
                    border: 0;
                    background: transparent;
                    color: #3ca05e;
                    width: 28px;
                    height: 28px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    padding: 0;
                    z-index: 3;
                }

                .datepicker-trigger:focus {
                    outline: none;
                    box-shadow: none;
                }

                .datepicker-trigger i {
                    pointer-events: none;
                }

                .ui-datepicker {
                    z-index: 9999 !important;
                }

                .share_pdf .pdf,
                .new-share-pdf .pdf {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 44px;
                    height: 44px;
                    flex: 0 0 44px;
                }

                .share_pdf .pdf img,
                .new-share-pdf .pdf img {
                    width: 100%;
                    max-width: 44px;
                    height: auto;
                    display: block;
                }

                .dataTables_wrapper {
                    width: 100%;
                }

                .dataTables_wrapper .dataTables_filter,
                .dataTables_wrapper .dataTables_length {
                    margin-bottom: 12px;
                }
            </style>
        </head>
        <body>
        <header class="head">
                <div class="top_bar">
                    <div class="tgl_menu">
                        <a href="<?php echo e(route('user.ratio_dashboard')); ?>" class="inner_logo">
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
                        <li><a href="<?php echo e(route('user.ratio_dashboard')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt="">Welcome to Dashboard</a></li>
                        <li><a href="<?php echo e(route('user.notifications')); ?>">
                            <i>
                                <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/noti.png')); ?>" alt="">
                                <span>0</span>
                            </i>
                            Notification</a></li>
                        <li><a href="<?php echo e(route('user.logout')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/log.png')); ?>" alt="">Logout</a></li>
                    </ul>
                </div>
                <div class="subscription_heading">
                    <div class="subs_in">
                        <?php if(!empty($show_expired_warning)): ?>
                        <!-- red warning--> <i class="fa-solid fa-triangle-exclamation red"></i> <p><?php echo e(!empty($expiry_date_display) ? 'Subscription will expire on' : 'Subscription has expired'); ?></p> <?php echo e($expiry_date_display ?? ''); ?> <a href="<?php echo e($subscription_cta_url ?? '#'); ?>">subscription</a> 
                        
                        <?php elseif(!empty($show_renew_warning)): ?>
                        <!-- yellow last 4 day before warning--> <i class="fa-solid fa-triangle-exclamation yellow"></i>  <p>Subscription will expire on</p> <?php echo e($expiry_date_display ?? date('d/m/Y', strtotime($expiry_date))); ?>, Please renew <a href="<?php echo e($subscription_cta_url ?? '#'); ?>">subscription</a>
                        <?php elseif(!empty($expiry_date)): ?>
                        <!-- green subscription warning--> <i class="fa-solid fa-bell green"></i> <p>Subscription will expire on</p> <?php echo e(date('d/m/Y', strtotime($expiry_date))); ?>

                        <?php else: ?>
                        <i class="fa-solid fa-bell green"></i> <p>Subscription is active.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <nav class="left_menu same_height">
                    <ul>
                        <li class="<?php echo e(request()->routeIs('user.ratio_dashboard') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.ratio_dashboard')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratop_report.png')); ?>" alt="">Ratio Reports</a></li>
                        <li class="<?php echo e(request()->routeIs('user.ratio_analysis') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.ratio_analysis')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratio_ana.png')); ?>" alt=""> Ratio Analysis</a></li>
                        <li class="<?php echo e(request()->routeIs('user.composition_report') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.composition_report')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/compos.png')); ?>" alt="">Composition Report</a></li>
                        <li class="<?php echo e(request()->routeIs('user.indies_report') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.indies_report')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/indies.png')); ?>" alt="">Indies Report</a></li>
                        <li class="<?php echo e(request()->routeIs('user.model_portfolio') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.model_portfolio')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/model.png')); ?>" alt="">Model Portfolio</a></li>
                        <li class="<?php echo e(request()->routeIs('user.filters') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.filters')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/filter.png')); ?>" alt="">Filters</a></li>
                        <li class="<?php echo e(request()->routeIs('user.predictive') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.predictive')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/predic.png')); ?>" alt="">Predictive</a></li>
                    </ul>
                </nav>
        </header>

            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery.min.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery-ui.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/icon.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/main.js')); ?>"></script>
            <script src="<?php echo e(mix('js/vue-app.js')); ?>"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ratioDashboardUrl = <?php echo json_encode(route('user.ratio_dashboard'), 15, 512) ?>;

                    function initializeBackButtons() {
                        document.querySelectorAll('.head_brdcm').forEach(function (breadcrumb) {
                            var newPage = breadcrumb.nextElementSibling;

                            if (!newPage || !newPage.classList.contains('new_page')) {
                                return;
                            }

                            var directChildren = Array.prototype.slice.call(newPage.children || []);
                            var backButton = directChildren.find(function (child) {
                                return child.matches && child.matches('a.back_btn');
                            });

                            if (!backButton || breadcrumb.querySelector('a.back_btn')) {
                                return;
                            }

                            breadcrumb.prepend(backButton);
                        });

                        document.querySelectorAll('a.back_btn').forEach(function (backButton) {
                            backButton.setAttribute('aria-label', 'Go back');

                            backButton.addEventListener('click', function (event) {
                                var hasUsableHistory = window.history.length > 1 && document.referrer;
                                var sameOriginReferrer = hasUsableHistory && document.referrer.indexOf(window.location.origin) === 0;

                                if (sameOriginReferrer) {
                                    event.preventDefault();
                                    window.history.back();
                                    return;
                                }

                                if (backButton.getAttribute('href') === '#' || !backButton.getAttribute('href')) {
                                    event.preventDefault();
                                    window.location.href = ratioDashboardUrl;
                                }
                            });
                        });
                    }

                    function initializeDatepickers() {
                        if (!(window.jQuery && $.fn.datepicker)) {
                            return;
                        }

                        $('.datepicker').each(function () {
                            var $input = $(this);

                            if ($input.parent().hasClass('datepicker-wrap')) {
                                return;
                            }

                            $input.wrap('<div class="datepicker-wrap"></div>');
                            $('<button type="button" class="datepicker-trigger" aria-label="Open calendar"><i class="fa-regular fa-calendar"></i></button>')
                                .insertAfter($input);
                        });

                        $('.datepicker').attr('readonly', true);

                        $('.datepicker').datepicker('destroy').datepicker({
                            dateFormat: 'dd-mm-yy',
                            changeMonth: true,
                            changeYear: true,
                            numberOfMonths: 1,
                            showButtonPanel: true,
                            yearRange: '-100:+20',
                            constrainInput: false
                        });

                        $('.datepicker').off('focus click').on('focus click', function () {
                            $(this).datepicker('show');
                        });

                        $(document).off('click.datepickerTrigger').on('click.datepickerTrigger', '.datepicker-trigger', function (event) {
                            event.preventDefault();

                            var $input = $(this).siblings('.datepicker');

                            if ($input.length) {
                                $input.datepicker('show');
                                $input.trigger('focus');
                            }
                        });

                        $(document).off('click.datepickerWrap').on('click.datepickerWrap', '.datepicker-wrap', function (event) {
                            if ($(event.target).hasClass('datepicker-trigger')) {
                                return;
                            }

                            var $input = $(this).find('.datepicker');

                            if ($input.length) {
                                $input.datepicker('show');
                            }
                        });
                    }

                    try {
                        initializeBackButtons();
                    } catch (error) {
                        console.error('Back button initialization failed:', error);
                    }

                    try {
                        initializeDatepickers();
                    } catch (error) {
                        console.error('Datepicker initialization failed:', error);
                    }

                    console.log('Myplexus layout version:', 'filters-debug-2026-04-22-01');

                    if (window.jQuery && $.fn.select2) {
                        $('.select2').select2();
                    }
                });
            </script>

          <?php echo $__env->yieldContent('content'); ?>
          <footer class="main_foot">
            <p>Copyright © <?php echo e(date('Y')); ?> <span>myplexus.com</span>. All Rights Reserved.</p>
          </footer>

            <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
            <?php echo $__env->yieldPushContent('scripts'); ?>
        </body>
    </html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/infosolz_user_app.blade.php ENDPATH**/ ?>