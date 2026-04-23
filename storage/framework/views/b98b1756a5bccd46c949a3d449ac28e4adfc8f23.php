<?php $__env->startSection('content'); ?>
<style>
    .subscription-page .banner {
        background: linear-gradient(135deg, #00665e, #16ab6c);
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

    .subscription-page .btn-outline-primary {
        color: #00665e;
        border-color: #00665e;
    }

    .subscription-page .btn-outline-primary:hover,
    .subscription-page .btn-outline-primary:focus,
    .subscription-page .btn-outline-primary.active {
        color: #fff;
        background-color: #00665e;
        border-color: #00665e;
    }

    .subscription-page .border-primary {
        border-color: #16ab6c !important;
    }
</style>

<div class="subscription-page">
<div class="banner">
    <div class="container py-5 text-white">
        <h1 class="mb-3">Subscription Plans</h1>
        <p class="mb-0">Unlock deeper mutual fund insights, advisor tools, and portfolio analytics with a MyPlexus plan.</p>
    </div>
</div>

<div class="body_main py-5">
    <div class="container">
        <div class="alert alert-info mb-4">
            <?php if(auth()->guard()->guest()): ?>
            Start your free trial — no credit card required.
            <?php else: ?>
                <?php if($user->hasActiveSubscription() && $activeSubscription): ?>
                Your <?php echo e(optional($activeSubscription->plan)->name ?: 'subscription'); ?> plan is active until <?php echo e(optional($activeSubscription->ends_at)->format('d M Y')); ?>.
                <?php elseif($user->isOnTrial()): ?>
                Your trial ends on <?php echo e(optional($user->trial_ends_at)->format('d M Y')); ?>.
                <?php else: ?>
                Choose a plan to continue using premium MyPlexus features.
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
            <div>
                <h2 class="mb-2">Find the right fit</h2>
                <p class="text-muted mb-0">Compare plans and switch between monthly and yearly pricing instantly.</p>
            </div>
            <div class="btn-group mt-3 mt-md-0" role="group" aria-label="Billing cycle toggle">
                <button type="button" class="btn btn-primary billing-toggle active" data-cycle="monthly">Monthly</button>
                <button type="button" class="btn btn-outline-primary billing-toggle" data-cycle="yearly">Yearly</button>
            </div>
        </div>

        <?php if($plans->isEmpty()): ?>
        <div class="alert alert-warning">
            Subscription plans are not available right now. Please add active rows to the <code>subscription_plans</code> table or run the subscription plan seeder.
        </div>
        <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm <?php echo e($plan->slug === 'standard' ? 'border-primary' : ''); ?>">
                    <div class="card-body d-flex flex-column">
                        <?php if($plan->slug === 'standard'): ?>
                        <span class="badge badge-primary mb-3 align-self-start">Recommended</span>
                        <?php endif; ?>
                        <h3><?php echo e($plan->name); ?></h3>
                        <p class="display-4 mb-2">
                            <span class="plan-price" data-monthly="<?php echo e(number_format($plan->price_monthly, 2)); ?>" data-yearly="<?php echo e(number_format($plan->price_yearly, 2)); ?>">
                                <?php echo e(number_format($plan->price_monthly, 2)); ?>

                            </span>
                            <small class="text-muted">INR</small>
                        </p>
                        <p class="text-muted cycle-label mb-4">per month</p>
                        <ul class="mb-4">
                            <?php $__currentLoopData = $plan->features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($feature); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button
                            type="button"
                            class="btn btn-primary mt-auto get-started-btn"
                            data-plan-id="<?php echo e($plan->id); ?>"
                            data-plan-name="<?php echo e($plan->name); ?>"
                            data-monthly="<?php echo e(number_format($plan->price_monthly, 2, '.', '')); ?>"
                            data-yearly="<?php echo e(number_format($plan->price_yearly, 2, '.', '')); ?>"
                        >
                            Get Started
                        </button>
                    </div>
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
                <p class="mb-2"><strong>Billing:</strong> <span id="selectedBillingCycle"></span></p>
                <p class="mb-0"><strong>Amount:</strong> INR <span id="selectedPlanAmount"></span></p>
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
    var billingCycle = 'monthly';
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

    function updatePrices() {
        document.querySelectorAll('.plan-price').forEach(function (node) {
            node.textContent = billingCycle === 'yearly' ? node.dataset.yearly : node.dataset.monthly;
        });

        document.querySelectorAll('.cycle-label').forEach(function (node) {
            node.textContent = billingCycle === 'yearly' ? 'per year' : 'per month';
        });

        document.querySelectorAll('.billing-toggle').forEach(function (button) {
            var active = button.dataset.cycle === billingCycle;
            button.classList.toggle('btn-primary', active);
            button.classList.toggle('btn-outline-primary', !active);
            button.classList.toggle('active', active);
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
            theme: { color: '#1a73e8' },
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

    document.querySelectorAll('.billing-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            billingCycle = button.dataset.cycle;
            updatePrices();

            if (selectedPlan) {
                document.getElementById('selectedBillingCycle').textContent = billingCycle;
                document.getElementById('selectedPlanAmount').textContent = billingCycle === 'yearly' ? selectedPlan.dataset.yearly : selectedPlan.dataset.monthly;
            }
        });
    });

        document.querySelectorAll('.get-started-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            selectedPlan = button;
            document.getElementById('selectedPlanName').textContent = button.dataset.planName;
            document.getElementById('selectedBillingCycle').textContent = billingCycle;
            document.getElementById('selectedPlanAmount').textContent = billingCycle === 'yearly' ? button.dataset.yearly : button.dataset.monthly;
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
                    plan_id: selectedPlan.dataset.planId,
                    billing_cycle: billingCycle
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

    updatePrices();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/subscription/index.blade.php ENDPATH**/ ?>