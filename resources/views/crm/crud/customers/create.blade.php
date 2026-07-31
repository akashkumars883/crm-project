@extends('layouts.app')
@section('title', 'Create Customer')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('customers.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Create Customer and User</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="lead_id" class="form-label fw-semibold">Select Lead <span class="text-danger">*</span></label>
                                <select name="lead_id" id="lead_id" class="form-select" required>
                                    <option value="">Select a Lead</option>
                                    @foreach ($leads as $lead)
                                        <option value="{{ $lead->id }}">{{ $lead->name }} ({{ $lead->email ?? 'No Email' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="user_password" class="form-label fw-semibold">Password (Optional)</label>
                                <input type="text" name="user_password" id="user_password" class="form-control" placeholder="Leave blank to auto-generate password">
                                <small class="text-muted mt-1 d-block">
                                    <i class="ti ti-info-circle text-primary me-1"></i>
                                    If left blank, an 8-character secure password will be generated automatically.
                                </small>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Create Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
