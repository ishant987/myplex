<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{csrf_token()}}">
<meta name="base-url" content="{{ url('/') }}">
<title>@yield('page-title') | {{ config('app.name') }}</title>
    @if(View::hasSection('meta-keywords'))
        <meta name="keywords" content="@yield('meta-keywords')">
    @endif
    @if(View::hasSection('moneycontrol'))
<link rel="stylesheet" href="https://stat.moneycontrol.co.in/mccss/mcradar/https_style.css?ver=1.6" />
@endif
<link href="{{asset('themes/frontend/assets/v1/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('themes/frontend/assets/v1/css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/phosphor-icons"></script>
<style>
    
.live-market-data .live-market-wrap {
    position: relative;
    /* top: -20px; */
    z-index: 99;
    background: #fff;
    /* border: 1px solid #d9d9d9; */
    border-radius: 5px;
    padding: 10px 15px;
}

.live-market-data .live-market-wrap #marketRadar {
    width: 100%;
    border: 0;
    box-shadow: none;
}


.live-market-data .live-market-wrap .tpSec {
    background: transparent !important;
}

.live-market-data .live-market-wrap .stockDsl {
    margin: 0 !important;
    width: 100% !important;
    float: right !important;
}

.live-market-data .live-market-wrap #marketRadar .stockDsl .mrdBox {
    height: 100%;
}

.live-market-data .live-market-wrap p {
    line-height: 16px;
}

    </style>
