<?php
    $yearFieldName = $yearFieldName ?? 'year';
    $monthFieldName = $monthFieldName ?? 'month';
    $selectedYear = $selectedYear ?? '';
    $selectedMonth = $selectedMonth ?? '';
    $size = $size ?? 6;
    $months = $months ?? range(1, 12);
    $years = $years ?? range((int) now()->format('Y'), 1950);
?>

<div class="col-md-<?php echo e($size); ?>">
    <div class="form_group">
        <select name="<?php echo e($monthFieldName); ?>" id="<?php echo e($monthFieldName); ?>" class="select2" required data-placeholder="Select Month">
            <option value="">select month</option>
            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m); ?>" <?php echo e((string) $selectedMonth === (string) $m ? 'selected' : ''); ?>>
                    <?php echo e(date('F', mktime(0, 0, 0, (int) $m, 10))); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = [$monthFieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<div class="col-md-<?php echo e($size); ?>">
    <div class="form_group">
        <select name="<?php echo e($yearFieldName); ?>" id="<?php echo e($yearFieldName); ?>" class="select2" required data-placeholder="Select Year">
            <option value="">select year</option>
            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($y); ?>" <?php echo e((string) $selectedYear === (string) $y ? 'selected' : ''); ?>>
                    <?php echo e($y); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = [$yearFieldName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/includes/year_month.blade.php ENDPATH**/ ?>