@extends('themes.backend.layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Subscription Details</h5>
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
    <div class="card-block">
        <p><strong>User:</strong> {{ optional($subscription->user)->getFullName() ?: '-' }}</p>
        <p><strong>Email:</strong> {{ optional($subscription->user)->email ?: '-' }}</p>
        <p><strong>Plan:</strong> {{ optional($subscription->plan)->name ?: $subscription->subscription_type ?: '-' }}</p>
        <p><strong>Status:</strong> {{ $subscription->displayStatus() }}</p>
        <p><strong>Billing Cycle:</strong> {{ $subscription->billing_cycle ?: '-' }}</p>
        <p><strong>Amount:</strong> {{ $subscription->currency }} {{ number_format((float) $subscription->amount, 2) }}</p>
        <p><strong>Razorpay Order ID:</strong> {{ $subscription->razorpay_order_id ?: '-' }}</p>
        <p><strong>Razorpay Payment ID:</strong> {{ $subscription->razorpay_payment_id ?: '-' }}</p>
        <p><strong>Razorpay Subscription ID:</strong> {{ $subscription->razorpay_subscription_id ?: '-' }}</p>
        <p><strong>Start Date:</strong> {{ optional($subscription->starts_at)->format('d M Y h:i A') ?: '-' }}</p>
        <p><strong>End Date:</strong> {{ optional($subscription->ends_at)->format('d M Y h:i A') ?: '-' }}</p>
        <p><strong>Expiry Date:</strong> {{ $subscription->subscription_expiry_date ? \Carbon\Carbon::parse($subscription->subscription_expiry_date)->format('d M Y') : '-' }}</p>
        <p><strong>Created:</strong> {{ optional($subscription->created_at)->format('d M Y h:i A') ?: '-' }}</p>

        @if ($subscription->user)
        <hr>
        <h6>User Subscription Snapshot</h6>
        <p><strong>User Subscription Status:</strong> {{ $subscription->user->subscription_status ?: '-' }}</p>
        <p><strong>User Expiry Date:</strong> {{ $subscription->user->subscription_expiry_date ? \Carbon\Carbon::parse($subscription->user->subscription_expiry_date)->format('d M Y') : '-' }}</p>
        <p><strong>Trial Ends At:</strong> {{ optional($subscription->user->trial_ends_at)->format('d M Y h:i A') ?: '-' }}</p>
        @endif
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
                    @forelse ($subscription->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->razorpay_order_id ?: '-' }}</td>
                        <td>{{ $transaction->razorpay_payment_id ?: '-' }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->currency }} {{ number_format((float) $transaction->amount, 2) }}</td>
                        <td>{{ $transaction->failure_reason ?: '-' }}</td>
                        <td>{{ optional($transaction->created_at)->format('d M Y h:i A') ?: '-' }}</td>
                    </tr>
                    @if (!empty($transaction->metadata))
                    <tr>
                        <td colspan="7"><pre class="mb-0">{{ json_encode($transaction->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre></td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7">No payment transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
