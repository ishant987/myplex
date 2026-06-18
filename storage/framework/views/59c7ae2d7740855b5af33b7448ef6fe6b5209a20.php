<?php
    $years = range(Carbon\Carbon::now()->year, Carbon\Carbon::now()->year - 4);
    // sort($years);
?>

<div class="col-md-<?php echo e($size ?? 4); ?>">
    <div class="form_group">
        <select name="<?php echo e($yearFieldName); ?>" id="dynamic_year" required>
            <option value="">Select Year</option>
            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yearValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($yearValue); ?>" <?php echo e(old($yearFieldName, isset($selectedYear) && $selectedYear == $yearValue) ? 'selected' : ''); ?>><?php echo e($yearValue); ?></option>            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>


<div class="col-md-<?php echo e($size ?? 4); ?>">
    <div class="form_group">
        <select name="<?php echo e($monthFieldName); ?>" id="dynamic_month" required <?php echo e(empty($selectedYear) ? 'disabled' : ''); ?>>
            <option value="">Select Month</option>
            <?php if($selectedYear): ?>
                <?php
                    $currentYear = date('Y');
                    $currentMonth = date('n');
                ?>
                <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($selectedYear < $currentYear || ($selectedYear == $currentYear && $monthValue < $currentMonth)): ?>
                        <option value="<?php echo e($monthValue); ?>"
                            <?php echo e(old($monthFieldName, isset($selectedMonth) && $selectedMonth == $monthValue) ? 'selected' : ''); ?>>
                            <?php echo e(DateTime::createFromFormat('!m', $monthValue)->format('F')); ?>

                        </option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/includes/year_month.blade.php ENDPATH**/ ?>