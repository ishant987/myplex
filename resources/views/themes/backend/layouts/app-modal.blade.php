<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    {{-- Head section --}}
    @include('themes.backend.includes.head')
  </head>

  <body>

  {{-- Pre-loader start --}}
  @if(View::hasSection('preloader'))
  @include('themes.backend.includes.preloader')
  @endif
  {{-- Pre-loader end --}}
  <!-- Container-fluid starts -->
  @yield('content')

  {{-- Javascript section --}}
  @include('themes.backend.includes.javascripts')

  </body>
</html>