<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <?php $__currentLoopData = $fundCompAnalysis['headers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th class="dark_bg"><?php echo e($val); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </thead>
    <tbody>
        <?php if($fundCompAnalysis['result']): ?>
            <?php $__currentLoopData = $fundCompAnalysis['result']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$valus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php echo e($key); ?>

                </td>
                <?php $__currentLoopData = $valus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td>
                        <?php echo e($val); ?>

                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <tr>
            <td colspan="<?php echo e(count($fundCompAnalysis['headers'])); ?>" align="center">No data</td>
        </tr>
        <?php endif; ?>

    </tbody>
</table><?php /**PATH /var/www/vhosts/myplexus.com/httpdocs/resources/views/web/pages/fund_watch/fund_composition.blade.php ENDPATH**/ ?>