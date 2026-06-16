@extends('layouts.app')
@section('title', 'Edit Activity')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Activity</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="activity_type_id" class="form-label">Activity Type</label>
                        <select class="form-control" id="activity_type_id" name="activity_type_id" required>
                            <option value="">Select Activity Type</option>
                            @foreach ($activityTypes as $activityType)
                                <option value="{{ $activityType->id }}"{{ old('activity_type-Id') == $activityType->id ? ' selected' : '' }}>{{ $activityType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lead_id" class="form-label">Lead</label>
                        <select class="form-control" id="lead_id" name="lead_id" required>
                            <option value="">Select a Lead</option>
                            @foreach ($leads as $lead)
                                <option value="{{ $lead->id }}"{{ $activity->lead_id == $lead->id ? ' selected' : '' }}>{{ $lead->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-control" id="customer_id" name="customer_id">
                            <option value="">Select a Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"{{ $activity->customer_id == $customer->id ? ' selected' : '' }}>{{ $customer->lead->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project</label>
                        <select class="form-control" id="project_id" name="project_id">
                            <option value="">Select a Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"{{ $activity->project_id == $project->id ? ' selected' : '' }}>{{ $project->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contact_method_id" class="form-label">Contact Method</label>
                        <select class="form-control" id="contact_method_id" name="contact_method_id" required>
                            <option value="">Select a Contact Method</option>
                            @foreach ($contactMethods as $contactMethod)
                                <option value="{{ $contactMethod->id }}"{{ $activity->contact_method_id == $contactMethod->id ? ' selected' : '' }}>{{ $contactMethod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $activity->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $activity->description) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Activity</button>
                    <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
