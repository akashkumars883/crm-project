@extends('layouts.app')
@section('title', 'Create Lead')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('leads.index') }}" class="text-black text-decoration-none me-1" title="Back to Leads"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-user-plus fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Add New Lead</h5>
                    <small class="text-black-50 font-12 text-capitalize">Create a new potential business opportunity</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <form action="{{ route('leads.store') }}" method="POST">
                @csrf
                
                <!-- Horizontal Row 1 -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <label for="name" class="form-label font-12 fw-semibold text-muted text-uppercase">Full Name</label>
                        <input type="text" class="form-control rounded-0 font-13" name="name" id="name" required placeholder="e.g. John Doe">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="phone" class="form-label font-12 fw-semibold text-muted text-uppercase">Phone</label>
                        <input type="text" class="form-control rounded-0 font-13" name="phone" id="phone" placeholder="e.g. +91 9876543210">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="email" class="form-label font-12 fw-semibold text-muted text-uppercase">Email</label>
                        <input type="email" class="form-control rounded-0 font-13" name="email" id="email" required placeholder="e.g. john@example.com">
                    </div>
                </div>

                <!-- Horizontal Row 2 -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <label for="lead_source_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Lead Source</label>
                        <select class="form-select rounded-0 font-13" name="lead_source_id" id="lead_source_id">
                            <option value="">Select Lead Source</option>
                            @foreach($leadSources as $leadSource)
                                <option value="{{ $leadSource->id }}">{{ $leadSource->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="lead_status_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Lead Status</label>
                        <select class="form-select rounded-0 font-13" name="lead_status_id" id="lead_status_id">
                            <option value="">Select Lead Status</option>
                            @foreach($leadStatuses as $leadStatus)
                                <option value="{{ $leadStatus->id }}">{{ $leadStatus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="assignee_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Assigned To</label>
                        <select class="form-select rounded-0 font-13" name="assignee_id" id="assignee_id">
                            <option value="">Select Supervisor / Manager</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Horizontal Row 3 -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="address" class="form-label font-12 fw-semibold text-muted text-uppercase">Address</label>
                        <input type="text" class="form-control rounded-0 font-13" name="address" id="address" placeholder="e.g. Street name, Area">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="notes" class="form-label font-12 fw-semibold text-muted text-uppercase">Notes / Requirements</label>
                        <textarea class="form-control rounded-0 font-13" name="notes" id="notes" rows="1" placeholder="Add custom notes here..."></textarea>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-primary btn-sm rounded-0 px-4 py-2 font-13 fw-semibold" style="width: auto !important;">Create Lead</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-sm rounded-0 px-4 py-2 font-13 fw-semibold" style="width: auto !important;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
