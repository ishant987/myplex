<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Secure User Details</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>PAN</th>
                        <th>ARN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($user->getFullName() ?: '-'); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e(optional($user->created_at)->format('d M Y')); ?></td>
                        <td><?php echo e(optional($user->sensitiveDetails)->pan ?: $user->pan ?: '-'); ?></td>
                        <td><?php echo e(optional($user->sensitiveDetails)->arn ?: $user->arn ?: '-'); ?></td>
                        <td><a href="<?php echo e(route('admin.secure-panel.users.show', $user->u_id)); ?>">View</a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/admin/secure-panel/users/index.blade.php ENDPATH**/ ?>