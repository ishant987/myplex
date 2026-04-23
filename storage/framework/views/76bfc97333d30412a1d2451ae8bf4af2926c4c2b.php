<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Subscriptions</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(optional($subscription->user)->getFullName() ?: '-'); ?></td>
                        <td><?php echo e(optional($subscription->user)->email ?: '-'); ?></td>
                        <td><?php echo e(optional($subscription->plan)->name ?: $subscription->subscription_type); ?></td>
                        <td><span class="badge badge-info"><?php echo e($subscription->displayStatus()); ?></span></td>
                        <td><?php echo e(optional($subscription->starts_at)->format('d M Y') ?: '-'); ?></td>
                        <td><?php echo e(optional($subscription->ends_at)->format('d M Y') ?: '-'); ?></td>
                        <td><?php echo e(number_format((float) $subscription->amount, 2)); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.subscriptions.show', $subscription->id)); ?>">Details</a>
                            <?php if($subscription->user && Route::has('admin.secure-panel.users.show')): ?>
                            | <a href="<?php echo e(route('admin.secure-panel.users.show', $subscription->user->u_id)); ?>">User</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8">No subscription records found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($subscriptions->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/admin/subscriptions/index.blade.php ENDPATH**/ ?>