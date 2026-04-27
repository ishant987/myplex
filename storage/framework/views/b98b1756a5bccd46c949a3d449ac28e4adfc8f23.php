<?php $__env->startSection('content'); ?>
<style>
    .subscription-page .banner {
        background: linear-gradient(135deg, #00665e, #16ab6c);
    }

    .subscription-page .status-card,
    .subscription-page .plan-card {
        border: 1px solid #dfe7e4;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.06);
    }

    .subscription-page .plan-card.featured {
        border-color: #16ab6c;
    }

    .subscription-page .btn-primary,
    .subscription-page .badge-primary {
        background-color: #16ab6c;
        border-color: #16ab6c;
    }

    .subscription-page .btn-primary:hover,
    .subscription-page .btn-primary:focus,
    .subscription-page .btn-primary:active {
        background-color: #00665e;
        border-color: #00665e;
    }

    .subscription-page .price {
        font-size: 2.2rem;
        font-weight: 700;
        color: #0d2a22;
    }

    .subscription-page .muted-note {
        color: #587067;
        font-size: 0.95rem;
    }
</style>

<?php
    $currentPlanSlug = optional(optional($activeSubscription)->plan)->slug;
    $isTrialUser = auth()->check() && $user->isOnTrial();
    $isActiveUser = auth()->check() && $user->hasActiveSubscription();
    $hasUsedTrial = $hasUsedTrial ?? false;
?>

<div class="subscription-page">
    <div class="banner">
        <div class="container py-5 text-white">
            <h1 class="mb-3">Subscription Plans</h1>
            <p class="mb-0">Choose the right MyPlexus plan, continue after trial expiry, or upgrade with pro-rata credit.</p>
        </div>
    </div>

    <div class="body_main py-5">
        <div class="container">
            <div class="status-card p-4 mb-4">
                <?php if(session('success')): ?>
                <div class="alert alert-success mb-3"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <?php if(auth()->guard()->guest()): ?>
                <h2 class="h4 mb-2">Start with full access</h2>
                <p class="mb-0">Create an account to get a 15-day trial on Basic or Premium, then subscribe whenever you are ready.</p>
                <?php else: ?>
                    <?php if($user->hasActiveSubscription() && $activeSubscription): ?>
                    <h2 class="h4 mb-2">Current plan: <?php echo e(optional($activeSubscription->plan)->name ?: 'Active Subscription'); ?></h2>
                    <p class="mb-3">Your access is active until <?php echo e(optional($activeSubscription->ends_at)->format('d M Y') ?: $user->accessExpiresAt()?->format('d M Y')); ?>. Upgrades automatically apply your remaining balance as credit.</p>
                    <a href="#plans" class="btn btn-outline-success">Upgrade or Change Plan</a>
                    <?php elseif($user->isOnTrial()): ?>
                    <h2 class="h4 mb-2">Free trial active</h2>
                    <p class="mb-3">Your trial ends on <?php echo e(optional($user->trial_ends_at)->format('d M Y')); ?>. You can continue using the trial or choose a paid plan right now.</p>
                    <a href="<?php echo e(route('user.index_dashboard')); ?>" class="btn btn-outline-success">Continue With Free Trial</a>
                    <p class="muted-note mt-3 mb-0">This is your one-time free trial. Upgrading to Premium will not start a second trial.</p>
                    <?php else: ?>
                    <h2 class="h4 mb-2">Subscription required</h2>
                    <p class="mb-0">Your access is inactive. Choose any plan below to continue using premium MyPlexus features.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if($plans->isEmpty()): ?>
            <div class="alert alert-warning">
                Subscription plans are not available right now.
            </div>
            <?php else: ?>
            <div id="plans" class="row">
                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $planAllowsTrial = match ($plan->slug) {
                        'basic', 'premium' => true,
                        'white-label' => false,
                        default => (bool) ($plan->allow_trial ?? false),
                    };
                    $durationLabel = match ($plan->slug) {
                        'basic' => '4 Days',
                        'premium' => '12 Months',
                        'white-label' => 'Per Month',
                        default => ((int) ($plan->duration_months ?? 0) > 0
                            ? ((int) $plan->duration_months . ' ' . ((int) $plan->duration_months === 1 ? 'Month' : 'Months'))
                            : 'Plan Duration'),
                    };
                    $preview = $upgradePreview[$plan->id] ?? [
                        'is_upgrade' => false,
                        'original_amount' => (float) $plan->price_monthly,
                        'credit' => 0,
                        'upgrade_amount' => (float) $plan->price_monthly,
                        'days_remaining' => 0,
                    ];
                    $isCurrentPlan = $currentPlanSlug === $plan->slug && $user && $user->hasActiveSubscription();
                    $buttonLabel = $preview['is_upgrade'] ? 'Upgrade Now' : 'Subscribe';
                    if ($isCurrentPlan) {
                        $buttonLabel = 'Current Plan';
                    } elseif ($isTrialUser) {
                        $buttonLabel = 'Choose This Plan';
                    } elseif ($isActiveUser && !$preview['is_upgrade']) {
                        $buttonLabel = $plan->slug === 'white-label' ? 'Switch to White Label' : 'Change Plan';
                    }
                ?>
                <div class="col-lg-4 mb-4">
                    <div class="plan-card h-100 p-4 d-flex flex-column <?php echo e($plan->slug === 'premium' ? 'featured' : ''); ?>">
                        <?php if($plan->slug === 'premium'): ?>
                        <span class="badge badge-primary mb-3 align-self-start">Best Value</span>
                        <?php elseif($plan->slug === 'white-label'): ?>
                        <span class="badge badge-dark mb-3 align-self-start">Branding</span>
                        <?php endif; ?>

                        <h3 class="mb-1"><?php echo e($plan->name); ?></h3>
                        <?php if($isCurrentPlan): ?>
                        <p class="text-success font-weight-bold mb-2">Your current plan</p>
                        <?php elseif($preview['is_upgrade']): ?>
                        <p class="text-success font-weight-bold mb-2">Upgrade available from <?php echo e($preview['current_plan_name']); ?></p>
                        <?php elseif($plan->slug === 'white-label'): ?>
                        <p class="text-success font-weight-bold mb-2">Brand your PDFs and reports</p>
                        <?php endif; ?>
                        <p class="muted-note mb-3"><?php echo e($durationLabel); ?></p>
                        <div class="price mb-2">INR <?php echo e(number_format((float) $plan->price_monthly, 2)); ?></div>

                        <?php if($preview['is_upgrade'] && !$isCurrentPlan): ?>
                        <p class="mb-1"><strong>Upgrade today:</strong> INR <?php echo e(number_format((float) $preview['upgrade_amount'], 2)); ?></p>
                        <p class="muted-note mb-3">Credit applied: INR <?php echo e(number_format((float) $preview['credit'], 2)); ?> for <?php echo e($preview['days_remaining']); ?> remaining days.</p>
                        <p class="muted-note mb-3">Current plan: <?php echo e($preview['current_plan_name']); ?></p>
                        <?php elseif($planAllowsTrial && !$hasUsedTrial): ?>
                        <p class="muted-note mb-3">Includes a 0-day trial for new users.</p>
                        <?php elseif($planAllowsTrial && $hasUsedTrial): ?>
                        <p class="muted-note mb-3">Free trial already used. This plan starts as a paid subscription.</p>
                        <?php else: ?>
                        <p class="muted-note mb-3">No free trial. Best for branded client-facing PDFs.</p>
                        <?php endif; ?>

                        <ul class="mb-4 pl-3">
                            <?php $__currentLoopData = $plan->features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($feature); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <button
                            type="button"
                            class="btn <?php echo e($isCurrentPlan ? 'btn-secondary' : 'btn-primary'); ?> mt-auto get-started-btn"
                            data-plan-id="<?php echo e($plan->id); ?>"
                            data-plan-name="<?php echo e($plan->name); ?>"
                            data-plan-duration="<?php echo e((int) $plan->duration_months); ?>"
                            data-plan-price="<?php echo e(number_format((float) $plan->price_monthly, 2, '.', '')); ?>"
                            data-upgrade-amount="<?php echo e(number_format((float) $preview['upgrade_amount'], 2, '.', '')); ?>"
                            data-credit="<?php echo e(number_format((float) $preview['credit'], 2, '.', '')); ?>"
                            data-is-upgrade="<?php echo e($preview['is_upgrade'] ? '1' : '0'); ?>"
                            <?php if($isCurrentPlan): ?> disabled <?php endif; ?>
                        >
                            <?php echo e($buttonLabel); ?>

                        </button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Confirm Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-2"><strong>Plan:</strong> <span id="selectedPlanName"></span></p>
                <p class="mb-2"><strong>Duration:</strong> <span id="selectedPlanDuration"></span></p>
                <p class="mb-2"><strong>Full amount:</strong> INR <span id="selectedPlanAmount"></span></p>
                <p class="mb-2 d-none" id="creditRow"><strong>Pro-rata credit:</strong> INR <span id="selectedPlanCredit"></span></p>
                <p class="mb-0"><strong>Pay now:</strong> INR <span id="selectedPlanPayable"></span></p>
            </div>
            <div class="modal-footer">
                <?php if(auth()->guard()->check()): ?>
                <button type="button" class="btn btn-primary" id="payWithRazorpay">Pay with Razorpay</button>
                <?php else: ?>
                <a href="<?php echo e(route('web.login')); ?>" class="btn btn-primary">Login to continue</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var selectedPlan = null;
    var csrfToken = '<?php echo e(csrf_token()); ?>';
    var paymentModalElement = document.getElementById('paymentModal');
    var paymentModal = null;

    if (paymentModalElement && window.bootstrap && window.bootstrap.Modal) {
        paymentModal = new window.bootstrap.Modal(paymentModalElement);
    }

    function showPaymentModal() {
        if (paymentModal) {
            paymentModal.show();
            return;
        }

        if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) {
            window.jQuery(paymentModalElement).modal('show');
        }
    }

    function hidePaymentModal() {
        if (paymentModal) {
            paymentModal.hide();
            return;
        }

        if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) {
            window.jQuery(paymentModalElement).modal('hide');
        }
    }

    function parseJsonResponse(response) {
        return response.text().then(function (text) {
            var data = {};

            if (text) {
                try {
                    data = JSON.parse(text);
                } catch (error) {
                    data = { message: text };
                }
            }

            if (!response.ok) {
                throw new Error(data.message || 'Request failed. Please check Razorpay configuration and logs.');
            }

            return data;
        });
    }

    function submitVerification(orderId, paymentId, signature) {
        fetch('<?php echo e(route('web.subscription.verify')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                razorpay_order_id: orderId,
                razorpay_payment_id: paymentId,
                razorpay_signature: signature
            })
        })
        .then(parseJsonResponse)
        .then(function (data) {
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }

            alert(data.message || 'Payment verified successfully.');
        })
        .catch(function (error) {
            alert(error.message || 'Unable to verify payment right now.');
        });
    }

    function openRazorpayCheckout(orderData) {
        var options = {
            key: orderData.key_id,
            amount: orderData.amount,
            currency: orderData.currency,
            order_id: orderData.order_id,
            name: orderData.company_name || 'MyPlexus',
            description: orderData.plan_name,
            prefill: {
                name: orderData.user_name,
                email: orderData.user_email,
                contact: orderData.user_phone
            },
            theme: { color: '#16ab6c' },
            handler: function(response) {
                submitVerification(
                    response.razorpay_order_id,
                    response.razorpay_payment_id,
                    response.razorpay_signature
                );
            },
            modal: {
                ondismiss: function() {
                    alert('Checkout closed before payment completion.');
                }
            }
        };

        var rzp = new Razorpay(options);
        rzp.on('payment.failed', function(response) {
            alert(response.error.description || 'Payment failed.');
        });
        rzp.open();
    }

    document.querySelectorAll('.get-started-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            selectedPlan = button;

            document.getElementById('selectedPlanName').textContent = button.dataset.planName;
            document.getElementById('selectedPlanDuration').textContent = button.dataset.planDuration + ' month' + (button.dataset.planDuration === '1' ? '' : 's');
            document.getElementById('selectedPlanAmount').textContent = button.dataset.planPrice;
            document.getElementById('selectedPlanPayable').textContent = button.dataset.upgradeAmount;
            document.getElementById('selectedPlanCredit').textContent = button.dataset.credit;
            document.getElementById('creditRow').classList.toggle('d-none', button.dataset.isUpgrade !== '1');

            showPaymentModal();
        });
    });

    var payButton = document.getElementById('payWithRazorpay');
    if (payButton) {
        payButton.addEventListener('click', function () {
            if (!selectedPlan) {
                return;
            }

            fetch('<?php echo e(route('web.subscription.checkout')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    plan_id: selectedPlan.dataset.planId
                })
            })
            .then(parseJsonResponse)
            .then(function (data) {
                if (data.order_id) {
                    hidePaymentModal();
                    openRazorpayCheckout(data);
                    return;
                }

                alert(data.message || 'Unable to start checkout.');
            })
            .catch(function (error) {
                alert(error.message || 'Unable to connect to the checkout service.');
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/subscription/index.blade.php ENDPATH**/ ?>