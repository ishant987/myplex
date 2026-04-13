<div class="header-top bg-b">
  <div class="container">
    <div class="row welcome">
      <div class="col-lg-4 col-md-4 col-sm-12 header-1">
        @if(isset($optsDbArr['welcome_txt']))
        <p>{{ $optsDbArr['welcome_txt'] }}</p>
        @endif
      </div>
      <div class="col-lg-8 col-md-8 col-sm-12 header-2">
        <div class="row">
          <div class="col-lg-9 col-md-9 col-sm-12 header-menu pr-0">
            {!! $webtopquicklinkmenu !!}
          </div>
          <div class="col-lg-3 col-md-3 col-12 login-nav">
            <ul class="navbar-nav d-flex flex-row justify-content-end">
              @if(!\Auth::check())
              <li class="user-login">
                <x-link url="{{ route('web.login') }}">{{ __('auth.sign_in_txt') }}</x-link>.
              </li>
              <li class="user-register">
                <x-link url="{{ route('web.signup') }}">{{ __('auth.sign_up_txt') }}</x-link>
              </li>
              @else
              <li class="user-login">
                <x-link url="{{ route('web.myaccount') }}">{{ __('auth.dshbrd_txt') }}</x-link>
              </li>
              <li class="user-register">
                <x-link url="{{ route('web.logout') }}">{{ __('auth.logout_txt') }}</x-link>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<nav class="main-menu navbar navbar-expand-lg p-0">
  <div class="container">
    <x-link url="/" class="navbar-brand">
      @if(isset($optsDbArr['media_folder']) && isset($optsDbArr['logo']))
      <x-img src="{{ $optsDbArr['media_folder'].$optsDbArr['logo'] }}" />
      @endif
    </x-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse align-items-end justify-content-end" id="navbarSupportedContent">
      {!! $webprimarymenu !!}
    </div>
  </div>
</nav>