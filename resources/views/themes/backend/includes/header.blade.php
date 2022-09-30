<nav class="navbar header-navbar pcoded-header ">
   <div class="navbar-wrapper">
      <div class="navbar-logo company-name">
         <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
         <i class="ti-menu"></i>
         </a>
         <a href="/" target="_blank">
            <h1>{{ config('app.name') }}</h1>
         </a>
         <a class="mobile-options waves-effect waves-light">
         <i class="ti-more"></i>
         </a>
      </div>
      <div class="navbar-container container-fluid">
         <ul class="nav-left">
            <li>
               <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
            </li>
            <li>
               <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
               <i class="ti-fullscreen"></i>
               </a>
            </li>
         </ul>
         <ul class="nav-right">
            <li class="user-profile header-notification">
               <a href="javascript:void(0);" class="waves-effect waves-light">
               <x-img src="{{ asset('themes/backend/files/assets/images/avatar-4.jpg') }}" class="img-radius" alt="{{ auth()->guard('admin')->user()->display_name }}" title="{{ auth()->guard('admin')->user()->display_name }}" />
               <span>{{ auth()->guard('admin')->user()->display_name }}</span>
               <i class="ti-angle-down"></i>
               </a>
               <ul class="show-notification profile-notification">
                  <li class="waves-effect waves-light">
                     <a href="{{ route('admin.profile') }}">
                     <i class="ti-user"></i> {{ __('admin.my_profile_txt') }}</a>
                  </li>
                  <li class="waves-effect waves-light">
                     <a href="{{ route('admin.logout') }}">
                     <i class="ti-layout-sidebar-left"></i> {{ __('admin.logout_txt') }}</a>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
   </div>
</nav>