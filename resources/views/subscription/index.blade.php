@extends('web.layout.app')

@section('content')
<div class="banner" style="background: linear-gradient(135deg, #0c4a6e, #0369a1);">
    <div class="container py-5 text-white">
        <h1 class="mb-3">Subscription Plans</h1>
        <p class="mb-0">Unlock deeper mutual fund insights, advisor tools, and portfolio analytics with a MyPlexus plan.</p>
    </div>
</div>

<div class="body_main py-5">
    <div class="container">
        <div class="alert alert-info mb-4">
            @guest
            Start your free trial — no credit card required.
            @else
                @if ($user->hasActiveSubscription() && $activeSubscription)
                Your {{ optional($activeSubscription->plan)->name ?: 'subscription' }} plan is active until {{ optional($activeSubscription->ends_at)->format('d M Y') }}.
                @elseif ($user->isOnTrial())
                Your trial ends on {{ optional($user->trial_ends_at)->format('d M Y') }}.
                @else
                Choose a plan to continue using premium MyPlexus features.
                @endif
            @endguest
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

        <div class="row">
            @foreach ($plans as $plan)
            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm {{ $plan->slug === 'standard' ? 'border-primary' : '' }}">
                    <div class="card-body d-flex flex-column">
                        @if ($plan->slug === 'standard')
                        <span class="badge badge-primary mb-3 align-self-start">Recommended</span>
                        @endif
                        <h3>{{ $plan->name }}</h3>
                        <p class="display-4 mb-2">
                            <span class="plan-price" data-monthly="{{ number_format($plan->price_monthly, 2) }}" data-yearly="{{ number_format($plan->price_yearly, 2) }}">
                                {{ number_format($plan->price_monthly, 2) }}
                            </span>
                            <small class="text-muted">INR</small>
                        </p>
                        <p class="text-muted cycle-label mb-4">per month</p>
                        <ul class="mb-4">
                            @foreach ($plan->features ?? [] as $feature)
                            <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        <button
                            type="button"
                            class="btn btn-primary mt-auto get-started-btn"
                            data-plan-id="{{ $plan->id }}"
                            data-plan-name="{{ $plan->name }}"
                            data-monthly="{{ number_format($plan->price_monthly, 2, '.', '') }}"
                            data-yearly="{{ number_format($plan->price_yearly, 2, '.', '') }}"
                        >
                            Get Started
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
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
                @auth
                <button type="button" class="btn btn-primary" id="payWithRazorpay">Pay with Razorpay</button>
                @else
                <a href="{{ route('web.login') }}" class="btn btn-primary">Login to continue</a>
                @endauth
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var billingCycle = 'monthly';
    var selectedPlan = null;
    var csrfToken = '{{ csrf_token() }}';
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
        fetch('{{ route('web.subscription.verify') }}', {
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
            name: 'MyPlexus',
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

            fetch('{{ route('web.subscription.checkout') }}', {
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
@endsection
