<?php $__env->startSection('content'); ?>
   

<div class="card-section">
    
    <div class="container">
        <h3 class="report-heading">Report Dashboard</h3>
        <div class="card-wrapper">
            <div class="card">
                <a href="<?php echo e(url('report-beta')); ?>">Beta </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-volatility')); ?>">Volatility </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-jensens-alpla')); ?>">Jensen's Alpha </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-sharpe')); ?>">Sharpe</a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-treynor')); ?>">Treynor</a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-tracking-error')); ?>">Tracking Error </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-information-ratio')); ?>">Information Ratio </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-r-squere')); ?>">R Square </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-skewness')); ?>">Skewness   </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-kurtosis')); ?>">Kurtosis   </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-sip-return')); ?>">SIP Return</a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-rolling-return')); ?>">Rolling Return</a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-cagr')); ?>">CAGR Return </a>
            </div>

            <div class="card">
                <a href="<?php echo e(url('report-sortino')); ?>">Sortino Ratio</a>
            </div>
        </div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.infosolz_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/infosolz-calculator/list.blade.php ENDPATH**/ ?>