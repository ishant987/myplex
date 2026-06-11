<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    {{-- Head section --}}
    @include('web.layout.includes.head')
</head>

<body>
    <div >
    {{-- Header start --}}
    @include('web.layout.includes.header')
    {{-- Header end --}}
    {{-- Main start --}}
    {{-- Middle section start --}}
    @yield('content')
    {{-- Middle section end --}}
    {{-- Main end --}}
    {{-- Footer start --}}
    @include('web.layout.includes.footer')
    </div>
    {{-- Footer end --}}
    {{-- Javascript section --}}
</body>
@include('web.layout.includes.javascripts')

</html>