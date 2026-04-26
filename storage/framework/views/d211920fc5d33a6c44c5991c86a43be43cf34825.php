<div class="content-form bg-lightblue account-nav-card">
    <div class="account-nav-head">
        <p>Account</p>
        <h4>Settings</h4>
    </div>
    <div class="list-group account-nav-list">
        <a href="<?php echo e(route('web.myaccount')); ?>" class="list-group-item list-group-item-action<?php echo e(request()->routeIs('web.myaccount') ? ' active' : ''); ?>">
            My Account
        </a>
        <a href="<?php echo e(route('web.edit.profile')); ?>" class="list-group-item list-group-item-action<?php echo e(request()->routeIs('web.edit.profile') ? ' active' : ''); ?>">
            Edit Profile
        </a>
        <a href="<?php echo e(route('web.reset.password')); ?>" class="list-group-item list-group-item-action<?php echo e(request()->routeIs('web.reset.password') ? ' active' : ''); ?>">
            Reset Password
        </a>
        <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('user.logout')); ?>" class="list-group-item list-group-item-action">
            Logout
        </a>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/themes/frontend/includes/user-left-nav.blade.php ENDPATH**/ ?>