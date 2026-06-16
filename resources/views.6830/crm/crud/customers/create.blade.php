{{-- @extends('layouts.app')
@section('title', 'Create Customer')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Customer</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="lead_id" class="form-label">Lead ID</label>
                        <select name="lead_id" id="lead_id" class="form-control @error('lead_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select Lead</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id || (isset($leadId) && $leadId === $lead->id) ? 'selected' : '' }}>{{ $lead->id }} - {{ $lead->name }}</option>
                            @endforeach
                        </select>
                        @error('lead_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id || (isset($userId) && $iserId === $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')
@section('title', 'Create Customer')
@section('content')
<div class="p-3 pt-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Customer and User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="lead_id" class="form-label">Select Lead</label>
                            <select name="lead_id" id="lead_id" class="form-select" required>
                                <option value="">Select a Lead</option>
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- User Creation Form -->
                        <div class="mb-3">
                            <label for="user_password" class="form-label">User Password</label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required>
                        </div>
                        <!-- End User Creation Form -->
                        <button type="submit" class="btn btn-primary">Create Customer and User</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
