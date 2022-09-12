<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{csrf_token()}}">
<meta name="base-url" content="{{ url('/') }}">
<title>@yield('page-title') | {{ config('app.name') }}</title>
    @if(View::hasSection('meta-keywords'))
        <meta name="keywords" content="@yield('meta-keywords')">
    @endif
<link href="{{asset('themes/frontend/assets/v1/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('themes/frontend/assets/v1/css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/phosphor-icons"></script>