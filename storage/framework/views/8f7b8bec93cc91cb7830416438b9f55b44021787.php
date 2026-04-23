<?php $__env->startSection('content'); ?>
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Subscription Details</h5>
        <a href="<?php echo e(route('admin.subscriptions.index')); ?>" class="btn btn-secondary btn-sm">Back</a>
    </div>
    <div class="card-block">
        <p><strong>User:</strong> <?php echo e(optional($subscription->user)->getFullName() ?: '-'); ?></p>
        <p><strong>Email:</strong> <?php echo e(optional($subscription->user)->email ?: '-'); ?></p>
        <p><strong>Plan:</strong> <?php echo e(optional($subscription->plan)->name ?: $subscription->subscription_type ?: '-'); ?></p>
        <p><strong>Status:</strong> <?php echo e($subscription->displayStatus()); ?></p>
        <p><strong>Billing Cycle:</strong> <?php echo e($subscription->billing_cycle ?: '-'); ?></p>
        <p><strong>Amount:</strong> <?php echo e($subscription->currency); ?> <?php echo e(number_format((float) $subscription->amount, 2)); ?></p>
        <p><strong>Razorpay Order ID:</strong> <?php echo e($subscription->razorpay_order_id ?: '-'); ?></p>
        <p><strong>Razorpay Payment ID:</strong> <?php echo e($subscription->razorpay_payment_id ?: '-'); ?></p>
        <p><strong>Razorpay Subscription ID:</strong> <?php echo e($subscription->razorpay_subscription_id ?: '-'); ?></p>
        <p><strong>Start Date:</strong> <?php echo e(optional($subscription->starts_at)->format('d M Y h:i A') ?: '-'); ?></p>
        <p><strong>End Date:</strong> <?php echo e(optional($subscription->ends_at)->format('d M Y h:i A') ?: '-'); ?></p>
        <p><strong>Expiry Date:</strong> <?php echo e($subscription->subscription_expiry_date ? \Carbon\Carbon::parse($subscription->subscription_expiry_date)->format('d M Y') : '-'); ?></p>
        <p><strong>Created:</strong> <?php echo e(optional($subscription->created_at)->format('d M Y h:i A') ?: '-'); ?></p>

        <?php if($subscription->user): ?>
        <hr>
        <h6>User Subscription Snapshot</h6>
        <p><strong>User Subscription Status:</strong> <?php echo e($subscription->user->subscription_status ?: '-'); ?></p>
        <p><strong>User Expiry Date:</strong> <?php echo e($subscription->user->subscription_expiry_date ? \Carbon\Carbon::parse($subscription->user->subscription_expiry_date)->format('d M Y') : '-'); ?></p>
        <p><strong>Trial Ends At:</strong> <?php echo e(optional($subscription->user->trial_ends_at)->format('d M Y h:i A') ?: '-'); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Payment Transactions</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Payment ID</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Failure Reason</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $subscription->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($transaction->id); ?></td>
                        <td><?php echo e($transaction->razorpay_order_id ?: '-'); ?></td>
                        <td><?php echo e($transaction->razorpay_payment_id ?: '-'); ?></td>
                        <td><?php echo e($transaction->status); ?></td>
                        <td><?php echo e($transaction->currency); ?> <?php echo e(number_format((float) $transaction->amount, 2)); ?></td>
                        <td><?php echo e($transaction->failure_reason ?: '-'); ?></td>
                        <td><?php echo e(optional($transaction->created_at)->format('d M Y h:i A') ?: '-'); ?></td>
                    </tr>
                    <?php if(!empty($transaction->metadata)): ?>
                    <tr>
                        <td colspan="7"><pre class="mb-0"><?php echo e(json_encode($transaction->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre></td>
                    </tr>
                    <?php endif; ?>
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

<?php echo $__env->make('themes.backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/admin/subscriptions/show.blade.php ENDPATH**/ ?>