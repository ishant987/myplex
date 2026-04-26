<li>
    <a href="<?php echo e(route($route)); ?>" class="dashboard_card">
        <figure>
            <img src="<?php echo e(asset($icon)); ?>" alt="<?php echo e($title); ?>">
        </figure>
        <div class="dashboard_card_text">
            <span class="dashboard_card_title"><?php echo e($title); ?></span>
            <span class="dashboard_card_subtitle"><?php echo e($subtitle); ?></span>
        </div>
        <span class="dashboard_card_arrow" aria-hidden="true">
            <i class="fa-solid fa-angle-right"></i>
        </span>
    </a>
</li>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/partials/dashboard-card.blade.php ENDPATH**/ ?>