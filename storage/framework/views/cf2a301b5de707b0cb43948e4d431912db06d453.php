<?php if($result != null): ?>
    <?php $__empty_1 = true; $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="<?php echo e($loop->index % 2 ? 'even' : 'odd'); ?>">
            <td data-label="Time Frame" class="sorting_1" date="<?php echo e($val['date']); ?>"><?php echo e($val['period']); ?>

            </td>
            <td data-label="Amount"><?php if($val['rank'] != 0): ?><?php echo e($val['rank'] + 1); ?><?php else: ?> NA <?php endif; ?>
            </td>
            <td data-label="Percentage %">
                <?php if($val['active_funds']): ?><?php echo e($val['active_funds']); ?><?php else: ?> NA <?php endif; ?></td>
			<td data-label="Category Decile">
                <?php if($val['decile']): ?><?php echo e($val['decile']); ?><?php else: ?> NA <?php endif; ?></td>
			<td data-label="Category Quartile">
                <?php if($val['quartile']): ?><?php echo e($val['quartile']); ?><?php else: ?> NA <?php endif; ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="3">No data</td>
        </tr>
    <?php endif; ?>
<?php else: ?>
    <tr>
        <td colspan="3">No data</td>
    </tr>
<?php endif; ?>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/pages/fund_watch/return_less_rank.blade.php ENDPATH**/ ?>