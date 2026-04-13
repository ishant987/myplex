<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    {{-- Head section --}}
    @include('themes.backend.includes.head')
  </head>

  <body @yield('themebg-pattern')>

  {{-- Pre-loader start --}}
  @include('themes.backend.includes.preloader')
  {{-- Pre-loader end --}}

<section @yield('section-class')>
  <!-- Container-fluid starts -->
  <div class="container">
      <div class="row">
          <div class="col-sm-12">
            <!-- Authentication card start -->
            @yield('content')
            <!-- end of form -->
          </div>
          <!-- end of col-sm-12 -->
      </div>
      <!-- end of row -->
  </div>
  <!-- end of container-fluid -->
</section> 

  {{-- Footer section --}}
  @include('themes.backend.includes.footer')

  {{-- Javascript section --}}
  @include('themes.backend.includes.javascripts')

  </body>
</html>