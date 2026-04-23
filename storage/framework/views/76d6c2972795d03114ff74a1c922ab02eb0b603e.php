<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>User Profile</h5>
        <a href="<?php echo e(route('admin.secure-panel.users.edit', $user->u_id)); ?>" class="btn btn-primary btn-sm">Edit</a>
    </div>
    <div class="card-block">
        <p><strong>Name:</strong> <?php echo e($user->getFullName() ?: '-'); ?></p>
        <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
        <p><strong>Joining Date:</strong> <?php echo e(optional($user->created_at)->format('d M Y') ?: '-'); ?></p>
        <p><strong>Company:</strong> <?php echo e(optional($user->sensitiveDetails)->company_name ?: $user->company ?: '-'); ?></p>
        <p><strong>Contact Person:</strong> <?php echo e(optional($user->sensitiveDetails)->contact_person ?: $user->contact_person ?: '-'); ?></p>
        <p><strong>PAN:</strong> <?php echo e(optional($user->sensitiveDetails)->pan ?: $user->pan ?: '-'); ?></p>
        <p><strong>ARN:</strong> <?php echo e(optional($user->sensitiveDetails)->arn ?: $user->arn ?: '-'); ?></p>
        <p><strong>GST:</strong> <?php echo e(optional($user->sensitiveDetails)->gst ?: $user->gst ?: '-'); ?></p>
        <p><strong>Bank Name:</strong> <?php echo e(optional($user->sensitiveDetails)->bank_name ?: '-'); ?></p>
        <p><strong>Account Number:</strong> <?php echo e(optional($user->sensitiveDetails)->account_number ?: '-'); ?></p>
        <p><strong>IFSC:</strong> <?php echo e(optional($user->sensitiveDetails)->ifsc_code ?: '-'); ?></p>
        <p><strong>Subscription Status:</strong> <?php echo e($user->subscription_status ?: '-'); ?></p>
        <p><strong>Subscription Expiry Date:</strong> <?php echo e($user->subscription_expiry_date ? \Carbon\Carbon::parse($user->subscription_expiry_date)->format('d M Y') : '-'); ?></p>
        <p><strong>Trial Ends At:</strong> <?php echo e(optional($user->trial_ends_at)->format('d M Y h:i A') ?: '-'); ?></p>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Subscription History</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Billing</th>
                        <th>Amount</th>
                        <th>Order ID</th>
                        <th>Payment ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $user->razorpaySubscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($subscription->id); ?></td>
                        <td><?php echo e(optional($subscription->plan)->name ?: $subscription->subscription_type ?: '-'); ?></td>
                        <td><?php echo e($subscription->displayStatus()); ?></td>
                        <td><?php echo e($subscription->billing_cycle ?: '-'); ?></td>
                        <td><?php echo e($subscription->currency); ?> <?php echo e(number_format((float) $subscription->amount, 2)); ?></td>
                        <td><?php echo e($subscription->razorpay_order_id ?: '-'); ?></td>
                        <td><?php echo e($subscription->razorpay_payment_id ?: '-'); ?></td>
                        <td><a href="<?php echo e(route('admin.subscriptions.show', $subscription->id)); ?>">View</a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8">No subscriptions found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Payment Transaction History</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subscription ID</th>
                        <th>Order ID</th>
                        <th>Payment ID</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $user->paymentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($transaction->id); ?></td>
                        <td><?php echo e($transaction->subscription_id ?: '-'); ?></td>
                        <td><?php echo e($transaction->razorpay_order_id ?: '-'); ?></td>
                        <td><?php echo e($transaction->razorpay_payment_id ?: '-'); ?></td>
                        <td><?php echo e($transaction->status); ?></td>
                        <td><?php echo e($transaction->currency); ?> <?php echo e(number_format((float) $transaction->amount, 2)); ?></td>
                        <td><?php echo e(optional($transaction->created_at)->format('d M Y h:i A') ?: '-'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7">No payment transactions found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/admin/secure-panel/users/show.blade.php ENDPATH**/ ?>