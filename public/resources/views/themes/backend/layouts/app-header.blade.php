<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    {{-- Head section --}}
    @include('themes.backend.includes.head')
  </head>

  @if(View::hasSection('themebg-pattern'))
    <body themebg-pattern="@yield('themebg-pattern')">
  @else
    <body>
  @endif

  {{-- Pre-loader start --}}
  @include('themes.backend.includes.preloader')
  {{-- Pre-loader end --}}

  @if(View::hasSection('with-header-bar'))
  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    @yield('content')
  </div>  
  @else
    @yield('content')
  @endif

  {{-- Footer section --}}
  @include('themes.backend.includes.footer')

  {{-- Javascript section --}}
  @include('themes.backend.includes.javascripts')

  </body>
</html>