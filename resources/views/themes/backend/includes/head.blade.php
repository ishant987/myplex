<title>{{ config('app.name') }} :: Administrator</title>
<!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 10]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="base-url" content="{{ url('/') }}">
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="{{asset('themes/backend/images/favicon/apple-icon-57x57.png')}}">
<link rel="apple-touch-icon" sizes="60x60" href="{{asset('themes/backend/images/favicon/apple-icon-60x60.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{asset('themes/backend/images/favicon/apple-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('themes/backend/images/favicon/apple-icon-76x76.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{asset('themes/backend/images/favicon/apple-icon-114x114.png')}}">
<link rel="apple-touch-icon" sizes="120x120" href="{{asset('themes/backend/images/favicon/apple-icon-120x120.png')}}">
<link rel="apple-touch-icon" sizes="144x144" href="{{asset('themes/backend/images/favicon/apple-icon-144x144.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('themes/backend/images/favicon/apple-icon-152x152.png')}}">
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('themes/backend/images/favicon/apple-icon-180x180.png')}}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{asset('themes/backend/images/favicon/android-icon-192x192.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('themes/backend/images/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="96x96" href="{{asset('themes/backend/images/favicon/favicon-96x96.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('themes/backend/images/favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('themes/backend/images/favicon/manifest.json')}}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{asset('themes/backend/images/favicon/ms-icon-144x144.png')}}">
<meta name="theme-color" content="#6A8DC8">

<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
<!-- Required Fremwork -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/bower_components/bootstrap/css/bootstrap.min.css')}}">
<!-- waves.css -->
<link rel="stylesheet" href="{{asset('themes/backend/files/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
<!-- themify-icons line icon -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/assets/icon/themify-icons/themify-icons.css')}}">
<!-- ico font -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/assets/icon/icofont/css/icofont.css')}}">
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/assets/icon/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/assets/css/jquery.mCustomScrollbar.css')}}">

@if(View::hasSection('dataTables'))
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
@endif

@if(View::hasSection('datetimeRangePicker'))
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endif

@if(View::hasSection('datetimePicker'))
<link href="{{asset('themes/assets/datetime-picker/jquery-ui.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('themes/assets/datetime-picker/jquery-ui-timepicker-addon.css')}}" rel="stylesheet" type="text/css">
@endif

@if(View::hasSection('select2'))
<!-- Select 2 css -->
<link rel="stylesheet" href="{{asset('themes/backend/files/bower_components/select2/css/select2.min.css')}}" />
@endif

@if(View::hasSection('fancybox'))
<link rel="stylesheet" type="text/css" href="{{asset('themes/assets/fancybox-v3.2.5/dist/jquery.fancybox.min.css')}}" media="screen" />
@endif

@if(View::hasSection('editor'))
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
@endif

@if(View::hasSection('autocomplete'))
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@endif

<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/files/assets/css/style.css')}}">
<!-- Custom Style -->
<link rel="stylesheet" type="text/css" href="{{asset('themes/backend/css/custom-style.css')}}">

@yield('page-css-styles')
@yield('section-css-styles')
@stack('styles')

@yield('canonical')

<script>
BFS = {
	base_url: '{{ Config::get('app.url') }}'
};
</script>
