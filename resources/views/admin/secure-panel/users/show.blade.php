@extends('themes.backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>User Profile</h5>
        <a href="{{ route('admin.secure-panel.users.edit', $user->u_id) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
    <div class="card-block">
        <p><strong>Name:</strong> {{ $user->getFullName() ?: '-' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Joining Date:</strong> {{ optional($user->created_at)->format('d M Y') ?: '-' }}</p>
        <p><strong>Company:</strong> {{ optional($user->sensitiveDetails)->company_name ?: $user->company ?: '-' }}</p>
        <p><strong>Contact Person:</strong> {{ optional($user->sensitiveDetails)->contact_person ?: $user->contact_person ?: '-' }}</p>
        <p><strong>PAN:</strong> {{ optional($user->sensitiveDetails)->pan ?: $user->pan ?: '-' }}</p>
        <p><strong>ARN:</strong> {{ optional($user->sensitiveDetails)->arn ?: $user->arn ?: '-' }}</p>
        <p><strong>GST:</strong> {{ optional($user->sensitiveDetails)->gst ?: $user->gst ?: '-' }}</p>
        <p><strong>Bank Name:</strong> {{ optional($user->sensitiveDetails)->bank_name ?: '-' }}</p>
        <p><strong>Account Number:</strong> {{ optional($user->sensitiveDetails)->account_number ?: '-' }}</p>
        <p><strong>IFSC:</strong> {{ optional($user->sensitiveDetails)->ifsc_code ?: '-' }}</p>
        <p><strong>Subscription Status:</strong> {{ $user->subscription_status ?: '-' }}</p>
        <p><strong>Subscription Expiry Date:</strong> {{ $user->subscription_expiry_date ? \Carbon\Carbon::parse($user->subscription_expiry_date)->format('d M Y') : '-' }}</p>
        <p><strong>Trial Ends At:</strong> {{ optional($user->trial_ends_at)->format('d M Y h:i A') ?: '-' }}</p>
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
                    @forelse ($user->razorpaySubscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->id }}</td>
                        <td>{{ optional($subscription->plan)->name ?: $subscription->subscription_type ?: '-' }}</td>
                        <td>{{ $subscription->displayStatus() }}</td>
                        <td>{{ $subscription->billing_cycle ?: '-' }}</td>
                        <td>{{ $subscription->currency }} {{ number_format((float) $subscription->amount, 2) }}</td>
                        <td>{{ $subscription->razorpay_order_id ?: '-' }}</td>
                        <td>{{ $subscription->razorpay_payment_id ?: '-' }}</td>
                        <td><a href="{{ route('admin.subscriptions.show', $subscription->id) }}">View</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">No subscriptions found.</td>
                    </tr>
                    @endforelse
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
                    @forelse ($user->paymentTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->subscription_id ?: '-' }}</td>
                        <td>{{ $transaction->razorpay_order_id ?: '-' }}</td>
                        <td>{{ $transaction->razorpay_payment_id ?: '-' }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->currency }} {{ number_format((float) $transaction->amount, 2) }}</td>
                        <td>{{ optional($transaction->created_at)->format('d M Y h:i A') ?: '-' }}</td>
                    </tr>
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
