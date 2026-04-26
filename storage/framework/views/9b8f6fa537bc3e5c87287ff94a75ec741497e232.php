<?php $__env->startSection('content'); ?>
<div class="inner_main">
    <div class="page_detail">
        <div class="inner_padding">
            <style>
                .profile_page {
                    display: grid;
                    gap: 24px;
                }

                .profile_intro {
                    display: grid;
                    grid-template-columns: minmax(0, 1.6fr) minmax(260px, 0.9fr);
                    gap: 20px;
                    align-items: stretch;
                }

                .profile_card {
                    background: #fff;
                    border-radius: 22px;
                    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
                    padding: 24px;
                }

                .profile_hero {
                    display: flex;
                    gap: 20px;
                    align-items: center;
                    min-height: 100%;
                }

                .profile_avatar {
                    width: 88px;
                    height: 88px;
                    border-radius: 24px;
                    background: linear-gradient(135deg, #0f9d58, #69b53f);
                    color: #fff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 32px;
                    font-weight: 700;
                    letter-spacing: 1px;
                    flex: 0 0 88px;
                }

                .profile_hero h1 {
                    margin: 0 0 10px;
                    color: #122033;
                    font-size: 32px;
                    line-height: 1.1;
                }

                .profile_hero p,
                .profile_stat p {
                    margin: 0;
                    color: #64748b;
                }

                .profile_meta {
                    display: flex;
                    gap: 10px;
                    flex-wrap: wrap;
                    margin-top: 14px;
                }

                .profile_meta span {
                    background: #f3f8f4;
                    color: #0f5132;
                    border-radius: 999px;
                    padding: 8px 14px;
                    font-size: 13px;
                    font-weight: 600;
                }

                .profile_actions {
                    display: flex;
                    gap: 12px;
                    flex-wrap: wrap;
                    margin-top: 18px;
                }

                .profile_actions a {
                    background: #122033;
                    color: #fff;
                    border-radius: 999px;
                    padding: 11px 18px;
                    font-size: 14px;
                    font-weight: 600;
                    text-decoration: none;
                }

                .profile_actions a.secondary {
                    background: #e8f3ec;
                    color: #0f5132;
                }

                .profile_snapshot {
                    display: grid;
                    gap: 14px;
                }

                .profile_stat {
                    border: 1px solid #e8edf3;
                    border-radius: 18px;
                    padding: 16px 18px;
                }

                .profile_stat strong {
                    display: block;
                    margin-top: 6px;
                    color: #122033;
                    font-size: 18px;
                }

                .profile_sections {
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 20px;
                }

                .profile_section_title {
                    margin: 0 0 18px;
                    color: #122033;
                    font-size: 20px;
                }

                .profile_field_list {
                    display: grid;
                    gap: 14px;
                }

                .profile_field {
                    border-bottom: 1px solid #edf2f7;
                    padding-bottom: 12px;
                }

                .profile_field:last-child {
                    border-bottom: 0;
                    padding-bottom: 0;
                }

                .profile_field span {
                    display: block;
                    color: #64748b;
                    font-size: 13px;
                    margin-bottom: 4px;
                }

                .profile_field strong {
                    color: #122033;
                    font-size: 15px;
                    line-height: 1.5;
                    word-break: break-word;
                }

                .profile_table_card h2 {
                    margin: 0 0 18px;
                    color: #122033;
                    font-size: 22px;
                }

                .profile_table_wrap {
                    overflow-x: auto;
                }

                .profile_table {
                    width: 100%;
                    min-width: 720px;
                    border-collapse: collapse;
                }

                .profile_table th,
                .profile_table td {
                    padding: 14px 12px;
                    border-bottom: 1px solid #edf2f7;
                    text-align: left;
                    vertical-align: top;
                    color: #334155;
                    font-size: 14px;
                }

                .profile_table th {
                    color: #122033;
                    font-size: 13px;
                    text-transform: uppercase;
                    letter-spacing: 0.04em;
                }

                .profile_empty {
                    color: #64748b;
                    margin: 0;
                }

                @media (max-width: 991px) {
                    .profile_intro,
                    .profile_sections {
                        grid-template-columns: 1fr;
                    }
                }

                @media (max-width: 640px) {
                    .profile_card {
                        padding: 18px;
                        border-radius: 18px;
                    }

                    .profile_hero {
                        align-items: flex-start;
                        flex-direction: column;
                    }

                    .profile_hero h1 {
                        font-size: 28px;
                    }
                }
            </style>

            <div class="profile_page">
                <div class="profile_intro">
                    <div class="profile_card">
                        <div class="profile_hero">
                            <div class="profile_avatar">
                                <?php echo e(strtoupper(substr(trim(($profileUser->f_name ?? 'U') . ' ' . ($profileUser->l_name ?? '')), 0, 1))); ?>

                            </div>
                            <div>
                                <h1><?php echo e(trim($profileUser->getFullName()) ?: 'User Profile'); ?></h1>
                                <p><?php echo e($profileUser->email ?: '-'); ?></p>
                                <div class="profile_meta">
                                    <span><?php echo e(ucfirst($profileUser->subscription_status ?: 'trial')); ?></span>
                                    <span><?php echo e($profileUser->company ?: (optional($profileUser->sensitiveDetails)->company_name ?: 'Individual User')); ?></span>
                                </div>
                                <div class="profile_actions">
                                    <a href="<?php echo e(route('web.edit.profile')); ?>">Edit Profile</a>
                                    <a href="<?php echo e(route('web.reset.password')); ?>" class="secondary">Reset Password</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile_snapshot">
                        <div class="profile_card profile_stat">
                            <p>Subscription Access</p>
                            <strong><?php echo e(!empty($has_active_subscription) ? 'Active' : ucfirst($profileUser->subscription_status ?: 'Inactive')); ?></strong>
                        </div>
                        <div class="profile_card profile_stat">
                            <p>Expires On</p>
                            <strong><?php echo e($expiry_date_display ?? 'Not available'); ?></strong>
                        </div>
                        <div class="profile_card profile_stat">
                            <p>Mobile</p>
                            <strong><?php echo e($profileUser->mobile ?: '-'); ?></strong>
                        </div>
                    </div>
                </div>

                <div class="profile_sections">
                    <?php $__currentLoopData = $profileSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionTitle => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile_card">
                            <h2 class="profile_section_title"><?php echo e($sectionTitle); ?></h2>
                            <div class="profile_field_list">
                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="profile_field">
                                        <span><?php echo e($label); ?></span>
                                        <strong><?php echo e(filled($value) ? $value : '-'); ?></strong>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="profile_card profile_table_card">
                    <h2>Subscription History</h2>
                    <?php if($subscriptionHistory->isEmpty()): ?>
                        <p class="profile_empty">No subscription history is available for this account yet.</p>
                    <?php else: ?>
                        <div class="profile_table_wrap">
                            <table class="profile_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <th>Billing</th>
                                        <th>Amount</th>
                                        <th>Order ID</th>
                                        <th>Payment ID</th>
                                        <th>Start</th>
                                        <th>End</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $subscriptionHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($subscription->id); ?></td>
                                            <td><?php echo e(optional($subscription->plan)->name ?: ($subscription->subscription_type ?: '-')); ?></td>
                                            <td><?php echo e($subscription->displayStatus()); ?></td>
                                            <td><?php echo e($subscription->billing_cycle ?: '-'); ?></td>
                                            <td><?php echo e($subscription->currency ?: 'INR'); ?> <?php echo e(number_format((float) $subscription->amount, 2)); ?></td>
                                            <td><?php echo e($subscription->razorpay_order_id ?: '-'); ?></td>
                                            <td><?php echo e($subscription->razorpay_payment_id ?: '-'); ?></td>
                                            <td><?php echo e(optional($subscription->starts_at)->format('d M Y') ?: '-'); ?></td>
                                            <td><?php echo e(optional($subscription->ends_at)->format('d M Y') ?: ($subscription->subscription_expiry_date ? \Carbon\Carbon::parse($subscription->subscription_expiry_date)->format('d M Y') : '-')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="profile_card profile_table_card">
                    <h2>Payment Transactions</h2>
                    <?php if($paymentHistory->isEmpty()): ?>
                        <p class="profile_empty">No payment transactions are available for this account yet.</p>
                    <?php else: ?>
                        <div class="profile_table_wrap">
                            <table class="profile_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subscription ID</th>
                                        <th>Order ID</th>
                                        <th>Payment ID</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Failure Reason</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $paymentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($transaction->id); ?></td>
                                            <td><?php echo e($transaction->subscription_id ?: '-'); ?></td>
                                            <td><?php echo e($transaction->razorpay_order_id ?: '-'); ?></td>
                                            <td><?php echo e($transaction->razorpay_payment_id ?: '-'); ?></td>
                                            <td><?php echo e($transaction->status ?: '-'); ?></td>
                                            <td><?php echo e(number_format((float) $transaction->amount, 2)); ?></td>
                                            <td><?php echo e($transaction->currency ?: '-'); ?></td>
                                            <td><?php echo e($transaction->failure_reason ?: '-'); ?></td>
                                            <td><?php echo e(optional($transaction->created_at)->format('d M Y h:i A') ?: '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.infosolz_user_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/auth/profile.blade.php ENDPATH**/ ?>