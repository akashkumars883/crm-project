@extends('layouts.app')
@section('title', 'All Leads')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Leads</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart1->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart1->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart2->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart2->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart3->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart3->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Cards -->

    <div class="mb-4">
        <h6 class="mb-3 text-secondary fw-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px;">Leads By Status</h6>
        <div class="row g-3">
            @foreach($leadStatusAnalytics as $status)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center p-3">
                            <p class="text-muted mb-1 fw-semibold" style="font-size: 14px;">{{ $status->name }}</p>
                            <h3 class="mb-0 text-dark fw-bold">{{ $status->leads_count }}</h3>
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>

    <div class="mb-4">
        <h6 class="mb-3 text-secondary fw-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px;">Leads By Source</h6>
        <div class="row g-3">
            @foreach($leadSourceAnalytics as $status)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center p-3">
                            <p class="text-muted mb-1 fw-semibold" style="font-size: 14px;">{{ $status->name }}</p>
                            <h3 class="mb-0 text-dark fw-bold">{{ $status->leads_count }}</h3>
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <a href="{{ route('leads.create') }}" class="btn btn-primary shadow-sm"><i class="ti ti-plus me-1"></i> Add New Lead</a>
                    </div>
                    <div>
                        <form action="{{ route('leads.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search leads..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $lead)
                                <tr>
                                    <td class="ps-3 fw-medium text-dark">{{ $lead->name }}</td>
                                    <td>{{ $lead->phone ?? '-' }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td><span class="badge bg-soft-secondary text-secondary">{{ optional($lead->leadSource)->name ?? '-' }}</span></td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">{{ optional($lead->leadStatus)->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-soft-info text-info rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 24px; height: 24px; font-size: 11px;">
                                                {{ strtoupper(substr($lead->assignedTo->name ?? 'N', 0, 1)) }}
                                            </div>
                                            <span style="font-size: 13px;">{{ $lead->assignedTo ? $lead->assignedTo->name : 'Unassigned' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-outline-info" title="View"><i class="ti ti-eye"></i></a>
                                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ti ti-edit"></i></a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $lead->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No leads found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="p-3 border-top bg-white rounded-bottom">
                {{ $leads->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    @foreach($leads as $lead)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $lead->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this lead?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('scripts')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
@endsection