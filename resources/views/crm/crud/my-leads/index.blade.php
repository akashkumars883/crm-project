@extends('layouts.app')
@section('title', 'My Leads')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">My Leads</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="mb-4">
        <h6 class="mb-3 text-secondary fw-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px;">Leads By Status</h6>
        <div class="row g-3">
            @php
                $importantKeywords = ['new', 'contact', 'qualif', 'convert', 'progress', 'follow', 'won', 'active'];
            @endphp
            @foreach($leadStatusAnalytics as $status)
                @php
                    $isImportant = false;
                    foreach($importantKeywords as $keyword) {
                        if(str_contains(strtolower($status->name), $keyword)) {
                            $isImportant = true;
                            break;
                        }
                    }
                @endphp
                @if($isImportant)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center p-3">
                            <p class="text-muted mb-1 fw-semibold" style="font-size: 14px;">{{ $status->name }}</p>
                            <h3 class="mb-0 text-dark fw-bold">{{ $status->leads_count }}</h3>
                        </div>
                    </div>
                </div> 
                @endif
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        @if (Auth::user()->hasPermission('create-my-lead'))
                        <a href="{{ route('leads.create') }}" class="btn btn-primary">Add a New Lead</a>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('my-leads.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search leads">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
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
                                    <td><span class="badge bg-soft-primary text-primary">{{ optional($lead->leadStatus)->name ?? '-' }}</span></td>
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
                                        @if (Auth::user()->hasPermission('read-my-lead'))
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-outline-info" title="View"><i class="ti ti-eye"></i></a>
                                        @endif
                                        @if (Auth::user()->hasPermission('update-my-lead'))
                                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ti ti-edit"></i></a>
                                        @endif
                                        @if (Auth::user()->hasPermission('delete-my-lead'))
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $lead->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                        @endif
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
            <div class="pt-3">
                {{ $leads->links('pagination::bootstrap-5') }}
            </div>>
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
