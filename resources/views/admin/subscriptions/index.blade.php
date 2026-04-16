@extends('themes.backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Subscriptions</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscriptions as $subscription)
                    <tr>
                        <td>{{ optional($subscription->user)->getFullName() ?: '-' }}</td>
                        <td>{{ optional($subscription->user)->email ?: '-' }}</td>
                        <td>{{ optional($subscription->plan)->name ?: $subscription->subscription_type }}</td>
                        <td><span class="badge badge-info">{{ $subscription->displayStatus() }}</span></td>
                        <td>{{ optional($subscription->starts_at)->format('d M Y') ?: '-' }}</td>
                        <td>{{ optional($subscription->ends_at)->format('d M Y') ?: '-' }}</td>
                        <td>{{ number_format((float) $subscription->amount, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.subscriptions.show', $subscription->id) }}">Details</a>
                            @if ($subscription->user && Route::has('admin.secure-panel.users.show'))
                            | <a href="{{ route('admin.secure-panel.users.show', $subscription->user->u_id) }}">User</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">No subscription records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection
