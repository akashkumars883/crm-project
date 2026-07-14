@extends('layouts.app')
@section('title', 'Tasks Management')
@section('content')

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Tasks</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary shadow-sm"><i class="ti ti-plus me-1"></i> Create Task</a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Title</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Assigned To</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $task->title }}</td>
                                    <td>
                                        <span class="badge {{ $task->status == 'completed' ? 'bg-soft-success text-success' : ($task->status == 'in_progress' ? 'bg-soft-warning text-warning' : 'bg-soft-secondary text-secondary') }} text-uppercase">
                                            {{ str_replace('_', ' ', $task->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $task->priority == 'high' ? 'bg-danger' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-info') }} text-white text-uppercase">
                                            {{ $task->priority }}
                                        </span>
                                    </td>
                                    <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($task->assignedTo)
                                            <div class="avatar-sm bg-soft-info text-info rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 24px; height: 24px; font-size: 11px;">
                                                {{ strtoupper(substr($task->assignedTo->name, 0, 1)) }}
                                            </div>
                                            <span style="font-size: 13px;">{{ $task->assignedTo->name }}</span>
                                            @else
                                            <span class="text-muted" style="font-size: 13px;">Unassigned</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ti ti-edit"></i></a>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="ti ti-trash"></i></button>
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
                </div>
            </div>
            <!-- Pagination links -->
            <div class="p-3 border-top bg-white rounded-bottom">
                {{ $tasks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
