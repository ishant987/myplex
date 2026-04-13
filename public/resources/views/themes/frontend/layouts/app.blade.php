<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    {{-- Head section --}}
    @include('themes.frontend.includes.head')
</head>

<body>
    <div >
    {{-- Header start --}}
    @include('themes.frontend.includes.header')
    {{-- Header end --}}
    {{-- Main start --}}
    {{-- Middle section start --}}
    @yield('content')
    {{-- Middle section end --}}
    {{-- Main end --}}
    {{-- Footer start --}}
    @include('themes.frontend.includes.footer')
    </div>
    {{-- Footer end --}}
    {{-- Javascript section --}}
    @include('themes.frontend.includes.javascripts')
</body>

</html>