<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <meta name="myplexus-layout-version" content="filters-debug-2026-04-22-01">
            <title>myplexus | Ratio</title>
            <link rel="shortcut icon" href="{{asset('themes/frontend/assets/infosolz/images/favicon.png')}}" type="image/x-icon">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/all.min.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/jquery-ui.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/login.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/style.css')}}">
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

                .left_menu {
                    display: flex;
                    flex-direction: column;
                }

                .left_menu .menu-main,
                .left_menu .menu-bottom {
                    list-style: none;
                    margin: 0;
                    padding: 0;
                }

                .left_menu .menu-bottom {
                    margin-top: auto;
                    padding-top: 16px;
                }

                .left_menu .menu-bottom li + li {
                    margin-top: 4px;
                }

                .left_menu .menu-bottom a {
                    color: #fff;
                }

                .left_menu .menu-bottom img {
                    filter: brightness(0) invert(1);
                }
            </style>
        </head>
        <body>
        @php($isLockedScreen = !empty($lock_access_screen) || request()->routeIs('user.subscription_lock'))
        <header class="head">
                <div class="top_bar">
                    <div class="tgl_menu">
                        <a href="{{route('user.index_dashboard')}}" class="inner_logo">
                            <img class="logo1" src="{{asset('themes/frontend/assets/v1/img/logo_dash.png')}}" alt="">
                            <img class="logo2" src="{{asset('themes/frontend/assets/infosolz/images/small_logo.png')}}" alt="">
                        </a>
                        <div id="toggle">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div>
                    </div>
                    <ul class="welcome">
                        @if($isLockedScreen)
                        <li><a href="{{ $subscription_cta_url ?? route('web.subscription.index') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/wel.png')}}" alt="">Subscription Plans</a></li>
                        <li><a href="{{ route('user.logout') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/log.png')}}" alt="">Logout</a></li>
                        @else
                        <li><a href="{{ route('user.index_dashboard') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/wel.png')}}" alt="">Welcome to Dashboard</a></li>
                        <li><a href="{{ route('user.notifications') }}">
                            <i>
                                <img src="{{asset('themes/frontend/assets/infosolz/images/noti.png')}}" alt="">
                                <span>0</span>
                            </i>
                            Notification</a></li>
                        <li><a href="{{ route('user.logout') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/log.png')}}" alt="">Logout</a></li>
                        @endif
                    </ul>
                </div>
                <div class="subscription_heading">
                    <div class="subs_in">
                        @if(!empty($show_expired_warning))
                        <!-- red warning--> <i class="fa-solid fa-triangle-exclamation red"></i> <p>{{ !empty($expiry_date_display) ? 'Subscription will expire on' : 'Subscription has expired' }}</p> {{ $expiry_date_display ?? '' }} <a href="{{ $subscription_cta_url ?? '#' }}">subscription</a> 
                        
                        @elseif(!empty($show_renew_warning))
                        <!-- yellow last 4 day before warning--> <i class="fa-solid fa-triangle-exclamation yellow"></i>  <p>Subscription will expire on</p> {{ $expiry_date_display ?? date('d/m/Y', strtotime($expiry_date)) }}, Please renew <a href="{{ $subscription_cta_url ?? '#' }}">subscription</a>
                        @elseif(!empty($expiry_date))
                        <!-- green subscription warning--> <i class="fa-solid fa-bell green"></i> <p>Subscription will expire on</p> {{ date('d/m/Y', strtotime($expiry_date)) }}
                        @else
                        <i class="fa-solid fa-bell green"></i> <p>Subscription is active.</p>
                        @endif
                    </div>
                </div>
                <nav class="left_menu same_height">
                    @if($isLockedScreen)
                    <ul class="menu-bottom">
                        <li class="active"><a href="{{ $subscription_cta_url ?? route('web.subscription.index') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/wel.png') }}" alt="">Subscription Plans</a></li>
                    </ul>
                    @else
                    <ul class="menu-main">
                        <li class="{{ request()->routeIs('user.ratio_dashboard', 'user.quick_ratio', 'user.weekly_snapshot*', 'user.monthly_snapshot*', 'user.fund_factsheet', 'user.performance_ratios', 'user.stats', 'user.quartile_decile', 'user.comparative', 'user.r_square_comparison') ? 'active' : '' }}"><a href="{{route('user.ratio_dashboard')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/ratop_report.png') }}" alt="">Ratio Reports</a></li>
                        <li class="{{ request()->routeIs('user.ratio_analysis', 'user.risk_ratio', 'user.return_ratio', 'user.sortino_ratio') ? 'active' : '' }}"><a href="{{route('user.ratio_analysis')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/ratio_ana.png') }}" alt=""> Ratio Analysis</a></li>
                        <li class="{{ request()->routeIs('user.composition_report', 'user.allocation_snapshot', 'user.scheme_portfolio', 'user.occurrence_report', 'user.top_script_rop_industry', 'user.new_script_new_industry', 'user.boomers', 'user.busters') ? 'active' : '' }}"><a href="{{route('user.composition_report')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/compos.png') }}" alt="">Composition Report</a></li>
                        <li class="{{ request()->routeIs('user.indies_report', 'user.indices_report', 'user.indices-history', 'user.indices-composition', 'user.schemes-associated-with-index', 'user.indices-report.*', 'user.index_vs_NAV') ? 'active' : '' }}"><a href="{{route('user.indies_report')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/indies.png') }}" alt="">Indices Report</a></li>
                        <li class="{{ request()->routeIs('user.model_portfolio') ? 'active' : '' }}"><a href="{{route('user.model_portfolio')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/model.png') }}" alt="">Model Portfolio</a></li>
                        <li class="{{ request()->routeIs('user.filters', 'user.filters.*') ? 'active' : '' }}"><a href="{{route('user.filters')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/filter.png') }}" alt="">Filters</a></li>
                        <li class="{{ request()->routeIs('user.predictive', 'user.predictive.*') ? 'active' : '' }}"><a href="{{route('user.predictive')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/predic.png') }}" alt="">Predictive</a></li>
                    </ul>
                    <ul class="menu-bottom">
                        <li class="{{ request()->routeIs('web.subscription.index') ? 'active' : '' }}"><a href="{{ route('web.subscription.index') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/wel.png') }}" alt="">Subscription Plans</a></li>
                        @if(auth()->check() && auth()->user()->hasWhiteLabel())
                        <li class="{{ request()->routeIs('user.whitelabel_settings') || request()->routeIs('user.whitelabel_settings.save') ? 'active' : '' }}">
                            <a href="{{ route('user.whitelabel_settings') }}"><img src="{{asset('themes/frontend/assets/infosolz/images/wel.png') }}" alt="">White Label Settings</a>
                        </li>
                        @endif
                    </ul>
                    @endif
                </nav>
        </header>

            <script src="{{asset('themes/frontend/assets/infosolz/js/jquery.min.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/jquery-ui.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/icon.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/main.js')}}"></script>
            <script src="{{ mix('js/vue-app.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ratioDashboardUrl = @json(route('user.ratio_dashboard'));

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

          @yield('content')
          <footer class="main_foot">
            <p>Copyright © {{date('Y')}} <span>myplexus.com</span>. All Rights Reserved.</p>
          </footer>

            <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
            @stack('scripts')
        </body>
    </html>
