
        <?php $__empty_1 = true; $__currentLoopData = $RiskAdjustedAlpha; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td data-label="Ratios"><?php echo e($key); ?></td>
                <td data-label="Jensen’s Alpha">
                    <?php echo e(round($val['jensen_alpha'], 2)); ?></td>
                <td data-label="Beta"><?php echo e(round($val['beta'], 2)); ?></td>
                <td data-label="Votality">
                    <?php echo e(round($val['volatality'], 2)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4">No data</td>
            </tr>
        <?php endif; ?>
  <?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/fund_watch/risk_adjusted_alpha.blade.php ENDPATH**/ ?>