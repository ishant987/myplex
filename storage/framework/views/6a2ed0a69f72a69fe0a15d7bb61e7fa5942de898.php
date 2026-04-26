<?php $__env->startSection('content'); ?>

<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <h1 class="page_heading">Dashboard</h1>
            <div class="all_dash">
                <ul>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.ratio_dashboard', 'icon' => 'new-images/dh1.png', 'title' => 'Ratio Reports', 'subtitle' => 'Explore report snapshots'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.ratio_analysis', 'icon' => 'new-images/Risk-Ratio.png', 'title' => 'Ratio Analysis', 'subtitle' => 'Compare key ratio insights'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.composition_report', 'icon' => 'new-images/Composition.png', 'title' => 'Composition Report', 'subtitle' => 'Review holdings and mix'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.indies_report', 'icon' => 'new-images/Indices-History.png', 'title' => 'Indies Report', 'subtitle' => 'Track index-linked trends'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.model_portfolio', 'icon' => 'new-images/dh3.png', 'title' => 'Model Portfolio', 'subtitle' => 'Open curated allocations'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.filters', 'icon' => 'new-images/By-Ratios.png', 'title' => 'Filters', 'subtitle' => 'Narrow down fund results'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('web.auth.partials.dashboard-card', ['route' => 'user.predictive', 'icon' => 'new-images/Occurrence-Report.png', 'title' => 'Predictive', 'subtitle' => 'View forward-looking metrics'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/index_dashboard.blade.php ENDPATH**/ ?>