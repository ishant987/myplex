<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{csrf_token()}}">
<meta name="base-url" content="{{ url('/') }}">
<title>@yield('page-title') | {{ config('app.name') }}</title>
@if(View::hasSection('meta-keywords'))
<meta name="keywords" content="@yield('meta-keywords')">
@endif
@if(View::hasSection('meta-description'))
<meta name="description" content="@yield('meta-description')">
@endif
<link rel="canonical" href="@yield('cur-url')" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{'@'.config('app.name')}}" />
<meta name="twitter:creator" content="{{'@'.config('app.name')}}" />
<meta name="twitter:title" content="@yield('meta-title')" />
@if(View::hasSection('meta-description'))
<meta name="twitter:description" content="@yield('meta-description')">
@endif
@if(View::hasSection('meta-image'))
<meta name="twitter:image" content="@yield('meta-image')" />
@endif
<meta property="og:locale" content="en_US" />
<meta property="og:site_name" content="{{config('app.name')}}" />
<meta property="og:type" content="article">
<meta property="og:url" content="@yield('cur-url')" />
<meta property="og:title" content="@yield('meta-title')" />
@if(View::hasSection('meta-image'))
<meta property="og:image" content="@yield('meta-image')" />
@endif
@if(View::hasSection('meta-description'))
<meta property="og:description" content="@yield('meta-description')">
@endif
<meta property="og:rich_attachment" content="true" />
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('themes/frontend/assets/images/favicon/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('themes/frontend/assets/images/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('themes/frontend/assets/images/favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('themes/frontend/assets/images/favicon/site.webmanifest')}}">
<link rel="mask-icon" href="{{asset('themes/frontend/assets/images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@if(View::hasSection('moneycontrol'))
<link rel="stylesheet" href="https://stat.moneycontrol.co.in/mccss/mcradar/https_style.css?ver=1.6" />
@endif
@if(View::hasSection('select2'))
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endif
@if(View::hasSection('owl-carousel'))
<link rel="stylesheet" href="{{asset('themes/frontend/assets/styles/owl-carousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('themes/frontend/assets/styles/owl-carousel/owl.theme.default.min.css')}}">
@endif
@if(View::hasSection('datatables'))
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endif
@if(View::hasSection('fancybox'))
<link rel="stylesheet" type="text/css" href="{{asset('themes/assets/fancybox-v3.2.5/dist/jquery.fancybox.min.css')}}" media="screen" />
@endif
<link rel="stylesheet" href="{{asset('themes/frontend/assets/styles/style.css')}}">
<link rel="stylesheet" href="{{asset('themes/frontend/assets/styles/responsive.css')}}">
<link rel="stylesheet" href="{{asset('themes/frontend/assets/styles/dev.css')}}">
@yield('page-css-styles')
@yield('section-css-styles')
@stack('styles')
@yield('canonical')
<script>
    BFS = {
        base_url: '{{ Config::get('
        app.url ') }}'
    };
</script>