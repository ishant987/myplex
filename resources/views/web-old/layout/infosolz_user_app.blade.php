<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>myplexus | Ratio</title>
            <link rel="shortcut icon" href="{{asset('themes/frontend/assets/infosolz/images/favicon.png')}}" type="image/x-icon">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/all.min.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/jquery-ui.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/login.css')}}">
            <link rel="stylesheet" href="{{asset('themes/frontend/assets/infosolz/css/style.css')}}">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
            
        </head>
        <body>
        <header class="head">
                <div class="top_bar">
                    <div class="tgl_menu">
                        <a href="{{route('user.ratio_dashboard')}}" class="inner_logo">
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
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/wel.png')}}" alt="">Welcome to Dashboard</a></li>
                        <li><a href="#">
                            <i>
                                <img src="{{asset('themes/frontend/assets/infosolz/images/noti.png')}}" alt="">
                                <span>2</span>
                            </i>
                            Notification</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/log.png')}}" alt="">Logout</a></li>
                    </ul>
                </div>
                <div class="subscription_heading">
                    <div class="subs_in">
                        @if($expiry_date < $current_date)
                        <!-- red warning--> <i class="fa-solid fa-triangle-exclamation red"></i> <p>Subscription is expired, Please renew</p> <a  href="{{ route('user.subscription', ['cal' => 'subcription']) }}">subscription</a> 
                        
                        @elseif($current_date <= $fiveDaysBeforeExpiry)
                        <!-- yellow last 4 day before warning--> <i class="fa-solid fa-triangle-exclamation yellow"></i>  <p>Subscription will expire on</p> {{ date('d/m/Y', strtotime($expiry_date)) }}, Please renew <a  href="{{ route('user.subscription', ['cal' => 'subcription']) }}">subscription</a>
                        @else
                        <!-- green subscription warning--> <i class="fa-solid fa-bell green"></i> <p>Subscription will expire on</p> {{ date('d/m/Y', strtotime($expiry_date)) }}
                        @endif
                    </div>
                </div>
                <nav class="left_menu same_height">
                    <ul>
                        <li class="active"><a href="{{route('user.ratio_dashboard')}}"><img src="{{asset('themes/frontend/assets/infosolz/images/ratop_report.png') }}" alt="">Ratio Reports</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/ratio_ana.png') }}" alt=""> Ratio Analysis</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/compos.png') }}" alt="">Composition Report</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/indies.png') }}" alt="">Indies Report</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/model.png') }}" alt="">Model Portfolio</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/filter.png') }}" alt="">Filters</a></li>
                        <li><a href="#"><img src="{{asset('themes/frontend/assets/infosolz/images/predic.png') }}" alt="">Predictive</a></li>
                    </ul>
                </nav>
        </header>
          @yield('content')
          <footer class="main_foot">
            <p>Copyright © {{date('Y')}} <span>myplexus.com</span>. All Rights Reserved.</p>
          </footer>

            <script src="{{asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/jquery.min.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/jquery-ui.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/icon.js')}}"></script>
            <script src="{{asset('themes/frontend/assets/infosolz/js/main.js')}}"></script>

            <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
        </body>
        @include('web.layout.includes.javascripts')
    </html>
