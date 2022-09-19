<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    {{-- Head section --}}
    @include('themes.backend.includes.head')    
  </head>
  <body>

  {{-- Pre-loader start --}}
  {{-- @include('themes.backend.includes.preloader') --}}
  {{-- Pre-loader end --}}

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
      {{-- Top Header start --}}
      @include('themes.backend.includes.header')
      {{-- Top Header end --}}
      <div class="pcoded-main-container">
        <div class="pcoded-wrapper"> 

          {{-- Navigation start --}}
          @include('themes.backend.includes.leftnav')
          {{-- Navigation end --}}

          <div class="pcoded-content">
            <div class="pcoded-inner-content">
              {{-- Main-body start --}}
              <div class="main-body">
                <div class="page-wrapper p-0">
                  <div class="page-body">
                  {{-- Navigation start --}}
                  @include('themes.backend.includes.breadcrumb')
                  {{-- Navigation end --}}                  
                  {{-- Middle section start --}}
                  @yield('content')
                  {{-- Middle section end --}}
                  </div>
                </div>
              </div>
              {{-- Main-body start --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  

  {{-- Javascript section --}}
  @include('themes.backend.includes.javascripts')

  </body>
</html>


