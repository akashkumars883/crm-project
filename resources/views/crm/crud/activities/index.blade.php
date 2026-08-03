@extends('layouts.app')
@section('title', 'All Activities')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-activity fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Activities Logs</h5>
                    <small class="text-black-50 font-12 text-capitalize">Track customer touches, meetings, calls, and follow-up activities</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('activities.create') }}" class="bg-blue text-white text-capitalize btn btn-light btn-sm px-3 py-2 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" style="width: auto !important;">
                    <i class="ti ti-plus me-2"></i> Add a New Activity
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- Search & Filter Bar -->
            <form action="{{ route('activities.index') }}" method="GET" class="card bg-light border-0 rounded-0 p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="position-relative">
                            <i class="ti ti-search position-absolute top-50 translate-middle-y text-muted" style="left: 12px; font-size: 16px; z-index: 5;"></i>
                            <input type="text" name="search" class="form-control rounded-0 font-13" placeholder="Search activities..." value="{{ request('search') }}" style="padding-left: 36px;">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 px-2 py-2 font-13 text-nowrap" style="width: auto !important;"><i class="ti ti-search me-1"></i> Search</button>
                        @if(request('search'))
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary btn-sm rounded-0 px-2 py-2 font-13 text-nowrap" style="width: auto !important;">Clear</a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0 table-sm">
                    <thead class="table-light text-uppercase font-10">
                        <tr>
                            <th class="ps-2" style="width: 70px;">ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Contact Method</th>
                            <th>Linked Entity</th>
                            <th class="pe-2 text-center" style="width: 90px; width: 90px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-12">
                        @forelse($activities as $activity)
                            <tr>
                                <td class="ps-2 text-muted">#{{ $activity->id }}</td>
                                <td class="fw-semibold text-dark">{{ $activity->title }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border font-12">
                                        {{ $activity->activityType->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-0 font-12 fw-semibold">
                                        {{ $activity->contactMethod->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($activity->project_id)
                                        <div class="fw-semibold"><i class="ti ti-subtask text-muted me-1"></i>Proj #{{ $activity->project_id }}</div>
                                    @elseif($activity->lead_id)
                                        <div class="fw-semibold"><i class="ti ti-user-check text-muted me-1"></i>{{ $activity->lead->name }} (Lead)</div>
                                    @elseif($activity->customer_id)
                                        <div class="fw-semibold"><i class="ti ti-users text-muted me-1"></i>{{ $activity->customer->name }} (Client)</div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="pe-2 text-center text-nowrap">
                                    <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                        <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $activity->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No activities logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activities->hasPages())
                <div class="pt-3 border-top bg-white rounded-bottom">
                    {{ $activities->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

@foreach($activities as $activity)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmDeleteModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Activity</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                <p class="mb-1 font-14">Are you sure you want to delete activity: <strong>{{ $activity->title }}</strong>?</p>
                <small class="text-muted font-12">This log record will be permanently deleted from CRM history.</small>
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap"><i class="ti ti-trash me-1"></i> Confirm Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection