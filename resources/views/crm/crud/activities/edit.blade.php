@extends('layouts.app')
@section('title', 'Edit Activity')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('activities.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Edit Activity #{{ $activity->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-semibold">Activity Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $activity->title) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="activity_type_id" class="form-label fw-semibold">Activity Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="activity_type_id" name="activity_type_id" required>
                                    <option value="">Select Activity Type</option>
                                    @foreach ($activityTypes as $activityType)
                                        <option value="{{ $activityType->id }}"{{ $activity->activity_type_id == $activityType->id ? ' selected' : '' }}>{{ $activityType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="contact_method_id" class="form-label fw-semibold">Contact Method <span class="text-danger">*</span></label>
                                <select class="form-select" id="contact_method_id" name="contact_method_id" required>
                                    <option value="">Select Method</option>
                                    @foreach ($contactMethods as $contactMethod)
                                        <option value="{{ $contactMethod->id }}"{{ $activity->contact_method_id == $contactMethod->id ? ' selected' : '' }}>{{ $contactMethod->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="lead_id" class="form-label fw-semibold">Lead <span class="text-danger">*</span></label>
                                <select class="form-select" id="lead_id" name="lead_id" required>
                                    <option value="">Select a Lead</option>
                                    @foreach ($leads as $lead)
                                        <option value="{{ $lead->id }}"{{ $activity->lead_id == $lead->id ? ' selected' : '' }}>{{ $lead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="customer_id" class="form-label fw-semibold">Customer</label>
                                <select class="form-select" id="customer_id" name="customer_id">
                                    <option value="">Select a Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"{{ $activity->customer_id == $customer->id ? ' selected' : '' }}>{{ $customer->lead->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="project_id" class="form-label fw-semibold">Project</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Select a Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"{{ $activity->project_id == $project->id ? ' selected' : '' }}>Project #{{ $project->id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description / Notes</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $activity->description) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Update Activity</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
