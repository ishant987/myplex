@extends('themes.backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Secure User Details</h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>PAN</th>
                        <th>ARN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->getFullName() ?: '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->created_at)->format('d M Y') }}</td>
                        <td>{{ optional($user->sensitiveDetails)->pan ?: $user->pan ?: '-' }}</td>
                        <td>{{ optional($user->sensitiveDetails)->arn ?: $user->arn ?: '-' }}</td>
                        <td><a href="{{ route('admin.secure-panel.users.show', $user->u_id) }}">View</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>
@endsection
