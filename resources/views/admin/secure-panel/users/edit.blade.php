@extends('themes.backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Sensitive Details</h5>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('admin.secure-panel.users.update', $user->u_id) }}">
            @csrf
            <div class="row">
                @foreach ([
                    'company_name' => 'Company Name',
                    'contact_person' => 'Contact Person',
                    'city' => 'City',
                    'state' => 'State',
                    'pan' => 'PAN',
                    'arn' => 'ARN',
                    'gst' => 'GST',
                    'bank_name' => 'Bank Name',
                    'account_holder_name' => 'Account Holder Name',
                    'account_number' => 'Account Number',
                    'ifsc_code' => 'IFSC Code',
                ] as $field => $label)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="{{ $field }}">{{ $label }}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="{{ $field }}"
                            name="{{ $field }}"
                            value="{{ old($field, optional($user->sensitiveDetails)->{$field}) }}"
                        >
                    </div>
                </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Save Details</button>
        </form>
    </div>
</div>
@endsection
