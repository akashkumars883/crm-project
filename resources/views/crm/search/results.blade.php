@extends('layouts.app')
@section('title', 'Search Results')
@section('content')

    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Search Results for "{{ $query }}"</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Leads -->
        @if($leads->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom p-3">
                    <h5 class="m-0 fw-bold"><i class="ti ti-users me-2 text-primary"></i>Leads ({{ $leads->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($leads as $lead)
                        <a href="{{ route('leads.show', $lead->id) }}" class="list-group-item list-group-item-action p-3">
                            <h6 class="m-0 fw-semibold text-dark">{{ $lead->name }}</h6>
                            <small class="text-muted">{{ $lead->email }} | {{ $lead->phone }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Projects -->
        @if($projects->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom p-3">
                    <h5 class="m-0 fw-bold"><i class="ti ti-briefcase me-2 text-success"></i>Projects ({{ $projects->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($projects as $project)
                        <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-action p-3">
                            <h6 class="m-0 fw-semibold text-dark">{{ $project->name }}</h6>
                            <small class="text-muted">Status: {{ $project->projectStatus->name ?? 'N/A' }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tasks -->
        @if($tasks->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom p-3">
                    <h5 class="m-0 fw-bold"><i class="ti ti-clipboard-list me-2 text-info"></i>Tasks ({{ $tasks->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($tasks as $task)
                        <a href="{{ route('tasks.edit', $task->id) }}" class="list-group-item list-group-item-action p-3">
                            <h6 class="m-0 fw-semibold text-dark">{{ $task->title }}</h6>
                            <small class="text-muted">Status: {{ str_replace('_', ' ', $task->status) }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Customers -->
        @if($customers->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom p-3">
                    <h5 class="m-0 fw-bold"><i class="ti ti-user-check me-2 text-warning"></i>Customers ({{ $customers->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($customers as $customer)
                        <a href="#" class="list-group-item list-group-item-action p-3">
                            <h6 class="m-0 fw-semibold text-dark">{{ $customer->lead->name ?? 'Unknown' }}</h6>
                            <small class="text-muted">Customer ID: {{ $customer->id }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($leads->count() == 0 && $projects->count() == 0 && $tasks->count() == 0 && $customers->count() == 0)
        <div class="col-12 text-center py-5">
            <i class="ti ti-search text-muted" style="font-size: 48px;"></i>
            <h4 class="mt-3 text-muted">No results found for "{{ $query }}"</h4>
            <p class="text-muted">Try searching with different keywords.</p>
        </div>
        @endif

    </div>
@endsection
