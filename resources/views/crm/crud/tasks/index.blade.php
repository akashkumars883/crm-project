@extends('layouts.app')
@section('title', 'Tasks Management')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-checklist fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Tasks Directory</h5>
                    <small class="text-black-50 font-12 text-capitalize">Manage operations scheduling, priorities, and project assignments</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('tasks.create') }}" class="bg-blue text-white text-capitalize btn btn-light btn-sm px-3 py-2 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" style="width: auto !important;">
                    <i class="ti ti-plus me-2"></i> Create Task
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- Tasks Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0 table-sm">
                    <thead class="table-light text-uppercase font-10">
                        <tr>
                            <th class="ps-2">Title / Description</th>
                            <th style="width: 130px;">Status</th>
                            <th style="width: 110px;">Priority</th>
                            <th style="width: 120px;">Due Date</th>
                            <th style="width: 160px;">Assigned To</th>
                            <th class="pe-2 text-center" style="width: 90px; width: 90px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-12">
                        @forelse($tasks as $task)
                            <tr>
                                <td class="ps-2 fw-semibold text-dark">{{ $task->title }}</td>
                                <td>
                                    @php
                                        $status = strtolower($task->status);
                                        $statusClass = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                                        if (str_contains($status, 'complete')) {
                                            $statusClass = 'bg-success-subtle text-success border-success-subtle';
                                        } elseif (str_contains($status, 'progress') || str_contains($status, 'work')) {
                                            $statusClass = 'bg-warning-subtle text-warning border-warning-subtle';
                                        }
                                    @endphp
                                    <span class="badge border rounded-0 font-12 fw-semibold px-2 py-1 {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $task->status) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $priority = strtolower($task->priority);
                                        $prioClass = 'bg-info-subtle text-info border-info-subtle';
                                        if ($priority === 'high' || $priority === 'critical') {
                                            $prioClass = 'bg-danger-subtle text-danger border-danger-subtle';
                                        } elseif ($priority === 'medium') {
                                            $prioClass = 'bg-warning-subtle text-warning border-warning-subtle';
                                        }
                                    @endphp
                                    <span class="badge border rounded-0 font-12 fw-semibold px-2 py-1 {{ $prioClass }}">
                                        {{ $task->priority }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($task->assignedTo)
                                            <div class="rounded-circle bg-primary-subtle text-primary border border-primary-subtle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 26px; height: 26px; font-size: 11px;">
                                                {{ strtoupper(substr($task->assignedTo->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $task->assignedTo->name }}</span>
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="pe-2 text-center text-nowrap">
                                    <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" title="Delete"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tasks->hasPages())
                <div class="pt-3 border-top bg-white rounded-bottom">
                    {{ $tasks->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
