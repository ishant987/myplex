
    <?php if($lumbsum != null): ?>
        <?php $__empty_1 = true; $__currentLoopData = $lumbsum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
			<?php if(!empty($val)): ?>
            <tr
                class="<?php echo e($loop->index % 2 ? 'even' : 'odd'); ?>">
                <td data-label="Time Frame"
                    class="sorting_1"><?php echo e($key); ?>

                </td>
                <td data-label="Amount"><?php echo e($val['amount']); ?>

                </td>
                <td data-label="Percentage %">
                    <?php echo e($val['percentage']); ?>%</td>
            </tr>
			<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="3">No data</td>
            </tr>
        <?php endif; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No data</td>
        </tr>
    <?php endif; ?><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/fund_watch/lumsum.blade.php ENDPATH**/ ?>