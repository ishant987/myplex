<nav class="navbar header-navbar pcoded-header ">
   <div class="navbar-wrapper">
      <div class="navbar-logo company-name">
         <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
         <i class="ti-menu"></i>
         </a>
         <a href="/" target="_blank">
            <h1><?php echo e(config('app.name')); ?></h1>
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
               <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.img','data' => ['src' => ''.e(asset('themes/backend/files/assets/images/avatar-4.jpg')).'','class' => 'img-radius','alt' => ''.e(auth()->guard('admin')->user()->display_name).'','title' => ''.e(auth()->guard('admin')->user()->display_name).'']]); ?>
<?php $component->withName('img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['src' => ''.e(asset('themes/backend/files/assets/images/avatar-4.jpg')).'','class' => 'img-radius','alt' => ''.e(auth()->guard('admin')->user()->display_name).'','title' => ''.e(auth()->guard('admin')->user()->display_name).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
               <span><?php echo e(auth()->guard('admin')->user()->display_name); ?></span>
               <i class="ti-angle-down"></i>
               </a>
               <ul class="show-notification profile-notification">
                  <li class="waves-effect waves-light">
                     <a href="<?php echo e(route('admin.profile')); ?>">
                     <i class="ti-user"></i> <?php echo e(__('admin.my_profile_txt')); ?></a>
                  </li>
                  <li class="waves-effect waves-light">
                     <a href="<?php echo e(route('admin.logout')); ?>">
                     <i class="ti-layout-sidebar-left"></i> <?php echo e(__('admin.logout_txt')); ?></a>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
   </div>
</nav><?php /**PATH /var/www/vhosts/new.myplexus.com/httpdocs/my-plexus/resources/views/themes/backend/includes/header.blade.php ENDPATH**/ ?>