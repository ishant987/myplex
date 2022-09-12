<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    {{-- Head section --}}
    @include('themes.frontend.includes.head')
</head>
<body>

    {{-- Main start --}}
    {{-- Middle section start --}}
    @yield('content')
    {{-- Middle section end --}}
    {{-- Main end --}}

{{-- Javascript section --}}
@include('themes.frontend.includes.javascripts')

</body>
</html>