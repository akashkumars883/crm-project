@extends('layouts.app')
@section('title', 'Create Vendor User Account')
@section('content')
<div class="p-3 pt-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Vendor User Account</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor-users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="vendor_id" class="form-label">Select Vendor</label>
                            <select name="vendor_id" id="vendor_id" class="form-select" required>
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- User Creation Form -->
                        <div class="mb-3">
                            <label for="user_password" class="form-label">User Password</label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required>
                        </div>
                        <!-- End User Creation Form -->
                        <button type="submit" class="btn btn-primary">Create Vendor User Account</button>
                        <a href="{{ route('vendor-users.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
