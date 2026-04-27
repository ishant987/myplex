@extends('web.layout.app')

@section('content')
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

@php
    $currentPlanSlug = optional(optional($activeSubscription)->plan)->slug;
    $isTrialUser = auth()->check() && $user->isOnTrial();
    $isActiveUser = auth()->check() && $user->hasActiveSubscription();
    $hasUsedTrial = $hasUsedTrial ?? false;
@endphp

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
                @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif
                @guest
                <h2 class="h4 mb-2">Start with full access</h2>
                <p class="mb-0">Create an account to get a 15-day trial on Basic or Premium, then subscribe whenever you are ready.</p>
                @else
                    @if ($user->hasActiveSubscription() && $activeSubscription)
                    <h2 class="h4 mb-2">Current plan: {{ optional($activeSubscription->plan)->name ?: 'Active Subscription' }}</h2>
                    <p class="mb-3">Your access is active until {{ optional($activeSubscription->ends_at)->format('d M Y') ?: $user->accessExpiresAt()?->format('d M Y') }}. Upgrades automatically apply your remaining balance as credit.</p>
                    <a href="#plans" class="btn btn-outline-success">Upgrade or Change Plan</a>
                    @elseif ($user->isOnTrial())
                    <h2 class="h4 mb-2">Free trial active</h2>
                    <p class="mb-3">Your trial ends on {{ optional($user->trial_ends_at)->format('d M Y') }}. You can continue using the trial or choose a paid plan right now.</p>
                    <a href="{{ route('user.index_dashboard') }}" class="btn btn-outline-success">Continue With Free Trial</a>
                    <p class="muted-note mt-3 mb-0">This is your one-time free trial. Upgrading to Premium will not start a second trial.</p>
                    @else
                    <h2 class="h4 mb-2">Subscription required</h2>
                    <p class="mb-0">Your access is inactive. Choose any plan below to continue using premium MyPlexus features.</p>
                    @endif
                @endguest
            </div>

            @if ($plans->isEmpty())
            <div class="alert alert-warning">
                Subscription plans are not available right now.
            </div>
            @else
            <div id="plans" class="row">
                @foreach ($plans as $plan)
                @php
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
                @endphp
                <div class="col-lg-4 mb-4">
                    <div class="plan-card h-100 p-4 d-flex flex-column {{ $plan->slug === 'premium' ? 'featured' : '' }}">
                        @if ($plan->slug === 'premium')
                        <span class="badge badge-primary mb-3 align-self-start">Best Value</span>
                        @elseif ($plan->slug === 'white-label')
                        <span class="badge badge-dark mb-3 align-self-start">Branding</span>
                        @endif

                        <h3 class="mb-1">{{ $plan->name }}</h3>
                        @if ($isCurrentPlan)
                        <p class="text-success font-weight-bold mb-2">Your current plan</p>
                        @elseif ($preview['is_upgrade'])
                        <p class="text-success font-weight-bold mb-2">Upgrade available from {{ $preview['current_plan_name'] }}</p>
                        @elseif ($plan->slug === 'white-label')
                        <p class="text-success font-weight-bold mb-2">Brand your PDFs and reports</p>
                        @endif
                        <p class="muted-note mb-3">{{ $durationLabel }}</p>
                        <div class="price mb-2">INR {{ number_format((float) $plan->price_monthly, 2) }}</div>

                        @if ($preview['is_upgrade'] && !$isCurrentPlan)
                        <p class="mb-1"><strong>Upgrade today:</strong> INR {{ number_format((float) $preview['upgrade_amount'], 2) }}</p>
                        <p class="muted-note mb-3">Credit applied: INR {{ number_format((float) $preview['credit'], 2) }} for {{ $preview['days_remaining'] }} remaining days.</p>
                        <p class="muted-note mb-3">Current plan: {{ $preview['current_plan_name'] }}</p>
                        @elseif ($planAllowsTrial && !$hasUsedTrial)
                        <p class="muted-note mb-3">Includes a 0-day trial for new users.</p>
                        @elseif ($planAllowsTrial && $hasUsedTrial)
                        <p class="muted-note mb-3">Free trial already used. This plan starts as a paid subscription.</p>
                        @else
                        <p class="muted-note mb-3">No free trial. Best for branded client-facing PDFs.</p>
                        @endif

                        <ul class="mb-4 pl-3">
                            @foreach ($plan->features ?? [] as $feature)
                            <li>{{ $feature }}</li>
                            @endforeach
                        </ul>

                        <button
                            type="button"
                            class="btn {{ $isCurrentPlan ? 'btn-secondary' : 'btn-primary' }} mt-auto get-started-btn"
                            data-plan-id="{{ $plan->id }}"
                            data-plan-name="{{ $plan->name }}"
                            data-plan-duration="{{ (int) $plan->duration_months }}"
                            data-plan-price="{{ number_format((float) $plan->price_monthly, 2, '.', '') }}"
                            data-upgrade-amount="{{ number_format((float) $preview['upgrade_amount'], 2, '.', '') }}"
                            data-credit="{{ number_format((float) $preview['credit'], 2, '.', '') }}"
                            data-is-upgrade="{{ $preview['is_upgrade'] ? '1' : '0' }}"
                            @if($isCurrentPlan) disabled @endif
                        >
                            {{ $buttonLabel }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
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

            fetch('{{ route('web.subscription.checkout') }}', {
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
@endsection
