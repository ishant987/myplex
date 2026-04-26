<?php $__env->startSection('content'); ?>
    <div class="inner_main">
        <div class="page_detail">
            <div class="inner_padding">
                <?php echo $__env->make('web.auth.partials.landing-dashboard', [
                    'landingSlug' => 'predictive',
                    'title' => 'Predictive',
                    'eyebrow' => 'Forward Signals',
                    'eyebrowIcon' => 'fa-solid fa-wave-square',
                    'description' => 'Use predictive ratios to examine alpha, Sharpe, and Treynor perspectives from one streamlined dashboard. The layout now gives these forward-looking tools a cleaner, easier starting point.',
                    'highlights' => [
                        ['title' => 'Alpha', 'description' => 'Use Jensen’s Alpha to evaluate excess return skill over benchmark.'],
                        ['title' => 'Sharpe', 'description' => 'Compare return per unit of total risk with less friction.'],
                        ['title' => 'Treynor', 'description' => 'Assess beta-adjusted return for benchmark-sensitive analysis.'],
                    ],
                    'cards' => [
                        ['route' => 'user.predictive.jensen-alpha', 'icon' => 'new-images/New-Scrips.png', 'title' => "By Jensen's Alpha", 'subtitle' => 'Measure excess return skill'],
                        ['route' => 'user.predictive.sharp-ratio', 'icon' => 'new-images/Indices-Composition.png', 'title' => 'By Sharpe', 'subtitle' => 'Compare return per risk'],
                        ['route' => 'user.predictive.trenyor', 'icon' => 'new-images/Occurrence-Report.png', 'title' => 'By Treynor', 'subtitle' => 'Assess beta-adjusted return'],
                    ],
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/predictive/index.blade.php ENDPATH**/ ?>