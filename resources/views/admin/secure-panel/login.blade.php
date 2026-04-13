@extends('themes.backend.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Secure Panel Access</h5>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('admin.secure-panel.authenticate') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password">Secondary Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Enter Secure Panel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
