@extends('layouts.app')
@section('title', $lead->name . ' - Lead Details')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Lead Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('leads.index') }}" class="text-black text-decoration-none me-1" title="Back to Leads"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-user-check fs-2"></i>
                <span class="fw-bold fs-5 text-black text-nowrap text-capitalize">Lead Profile & Management</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-white text-primary px-3 py-2 fw-bold font-12 rounded-0 text-nowrap">
                    Lead ID: #{{ $lead->id }}
                </span>
                <span class="badge bg-success px-3 py-2 fw-semibold font-12 rounded-1 text-nowrap text-capitalize">
                    <i class="ti ti-point-filled me-1"></i>{{ optional($lead->leadStatus)->name ?? 'Active' }}
                </span>
            </div>
        </div>
        <div class="card-body p-4 bg-white rounded-0">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle text-primary border border-2 border-primary d-flex align-items-center justify-content-center fw-bold fs-2 shadow-sm" style="width: 70px; height: 70px;">
                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ $lead->name }}</h4>
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted font-12">
                            <span><i class="ti ti-phone me-1 text-secondary"></i>{{ $lead->phone ?: 'N/A' }}</span>
                            <span><i class="ti ti-mail me-1 text-secondary"></i>{{ $lead->email }}</span>
                            @if($lead->address)
                                <span><i class="ti ti-map-pin me-1 text-secondary"></i>{{ $lead->address }}, {{ $lead->city }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Button Toolbar -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-primary btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center">
                        <i class="ti ti-pencil me-1"></i> Edit Lead
                    </a>
                    @if ($lead->customer && $lead->customer->lead_id)
                        <a href="{{ route('customers.show', $lead->customer->id) }}" class="btn btn-success btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center">
                            <i class="ti ti-user me-1"></i> Show Customer Record
                        </a>
                    @else
                        <button type="button" class="btn btn-outline-success btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#customerModal">
                            <i class="ti ti-user-plus me-1"></i> Convert to Customer
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 3-Column Info Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. Lead Source & Metadata Card -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-info-circle text-primary fs-4"></i> Lead Information
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Source:</span>
                        <span class="fw-semibold text-dark font-12">{{ optional($lead->leadSource)->name ?: 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Contact Method:</span>
                        <span class="fw-semibold text-dark font-12">{{ optional($lead->contactMethod)->name ?: 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Contact Language:</span>
                        <span class="fw-semibold text-dark font-12">{{ optional($lead->contactLanguage)->name ?: 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted font-12">Assigned To:</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-0 font-12 fw-bold">{{ $lead->assignedTo->name ?? 'Not Assigned' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Lead Notes Card -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-notes text-info fs-4"></i> Lead Notes
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0">
                    <p class="text-muted font-12 mb-0" style="white-space: pre-line;">{{ $lead->notes ?: 'No notes available for this lead.' }}</p>
                </div>
            </div>
        </div>

        <!-- 3. History & Meta Info Card -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-history text-secondary fs-4"></i> System Details
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Lead Age:</span>
                        <span class="fw-semibold text-dark font-12">{{ $lead->created_at->diffInDays(now()) }} days</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Lead Since:</span>
                        <span class="fw-semibold text-dark font-12">{{ $lead->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Created By:</span>
                        <span class="fw-semibold text-dark font-12">{{ optional($lead->creator)->name ?? 'System' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted font-12">Last Updated:</span>
                        <span class="fw-semibold text-dark font-12">{{ $lead->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices & Activities Side by Side -->
    <div class="row g-3">
        <!-- Related Invoices Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-file-invoice text-primary fs-4"></i> Invoices
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-2 font-12 fw-semibold" style="width: auto !important; flex: 0 0 auto !important;" data-bs-toggle="modal" data-bs-target="#invoiceModal">
                        <i class="ti ti-plus me-1"></i> Add Invoice
                    </button>
                </div>
                <div class="card-body p-0 rounded-0 d-flex flex-column justify-content-between">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="min-width: 60px;">ID</th>
                                    <th style="min-width: 100px;">Value</th>
                                    <th style="min-width: 90px;">Status</th>
                                    <th class="pe-3 text-center" style="min-width: 80px; width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td class="ps-3 fw-bold">#{{ $invoice->id }}</td>
                                        <td class="fw-bold text-success">₹{{ number_format($invoice->value, 2) }}</td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary rounded-0 font-12 fw-semibold">
                                                {{ $invoice->invoiceStatus->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="pe-3 text-center">
                                            <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmInvoiceDeleteModal{{ $invoice->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No invoices found for this lead.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($invoices->hasPages())
                        <div class="p-2 border-top">
                            {{ $invoices->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Activities Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-activity text-info fs-4"></i> Activities
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-2 font-12 fw-semibold" style="width: auto !important; flex: 0 0 auto !important;" data-bs-toggle="modal" data-bs-target="#activityModal">
                        <i class="ti ti-plus me-1"></i> Add Activity
                    </button>
                </div>
                <div class="card-body p-0 rounded-0 d-flex flex-column justify-content-between">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="min-width: 60px;">ID</th>
                                    <th style="min-width: 100px;">Method</th>
                                    <th>Title</th>
                                    <th class="pe-3 text-center" style="min-width: 80px; width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                    <tr>
                                        <td class="ps-3">#{{ $activity->id }}</td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-0 font-12">
                                                {{ $activity->contactMethod->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="fw-semibold font-12">{{ $activity->title }}</td>
                                        <td class="pe-3 text-center">
                                            <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                                <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmActivityDeleteModal{{ $activity->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No Activities found for this lead.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($activities->hasPages())
                        <div class="p-2 border-top">
                            {{ $activities->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-primary text-white rounded-0">
                <h5 class="modal-title fw-bold font-15" id="invoiceModalLabel"><i class="ti ti-file-invoice me-2"></i>Create Invoice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                @include('crm.crud.leads.show_invoice_form')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-success text-white rounded-0">
                <h5 class="modal-title fw-bold font-15" id="customerModalLabel"><i class="ti ti-user-plus me-2"></i>Convert Lead to Customer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                @include('crm.crud.leads.create_customer_form')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-info text-white rounded-0">
                <h5 class="modal-title fw-bold font-15" id="activityModalLabel"><i class="ti ti-activity me-2"></i>Create Activity</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                @include('crm.crud.leads.show_activity_form')
            </div>
        </div>
    </div>
</div>

@foreach($invoices as $invoice)
<div class="modal fade" id="confirmInvoiceDeleteModal{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                Are you sure you want to delete invoice <strong>#{{ $invoice->id }}</strong>?
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($activities as $activity)
<div class="modal fade" id="confirmActivityDeleteModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                Are you sure you want to delete activity <strong>#{{ $activity->id }}</strong>?
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
