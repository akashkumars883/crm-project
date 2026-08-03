@extends('layouts.app')
@section('title', $project->customer->lead->name . ' - Project Details')
@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Project Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('projects.index') }}" class="text-black text-decoration-none me-1" title="Back to Projects"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-subtask fs-2"></i>
                <span class="fw-bold fs-5 text-black text-nowrap text-capitalize">Project Profile & Tracking</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-white text-primary px-3 py-2 fw-bold font-12 rounded-0 text-nowrap">
                    Project ID: #{{ $project->id }}
                </span>
                <span class="badge bg-success px-3 py-2 fw-semibold font-12 rounded-1 text-nowrap text-capitalize">
                    <i class="ti ti-point-filled me-1"></i>{{ $project->projectStatus ? $project->projectStatus->name : 'Active' }}
                </span>
            </div>
        </div>
        <div class="card-body p-4 bg-white rounded-0">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle text-primary border border-2 border-primary d-flex align-items-center justify-content-center fw-bold fs-2 shadow-sm" style="width: 70px; height: 70px;">
                        {{ strtoupper(substr($project->customer->lead->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ $project->customer->lead->name }}</h4>
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted font-12">
                            <span><i class="ti ti-phone me-1 text-secondary"></i>{{ $project->customer->lead->phone ?: 'N/A' }}</span>
                            <span><i class="ti ti-mail me-1 text-secondary"></i>{{ $project->customer->lead->email }}</span>
                            @if($project->customer->lead->address)
                                <span><i class="ti ti-map-pin me-1 text-secondary"></i>{{ $project->customer->lead->address }}, {{ $project->customer->lead->city }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Button Toolbar -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if (Auth::user()->hasPermission('update-project'))
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center">
                            <i class="ti ti-pencil me-1"></i> Edit Project
                        </a>
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
                        <i class="ti ti-info-circle text-primary fs-4"></i> Client details
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0 font-12">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted">Source:</span>
                        <span class="fw-semibold text-dark">{{ $project->customer->lead->leadSource->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted">Project Type:</span>
                        <span class="fw-semibold text-dark">{{ $project->projectType->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Assigned To:</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-0 font-12 fw-bold">{{ $project->assignedTo->name ?? 'Unassigned' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Project Details Card -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-calendar text-info fs-4"></i> Date Parameters
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0 font-12">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted">Start Date:</span>
                        <span class="fw-semibold text-dark">{{ Carbon::parse($project->start_date)->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted">End Date:</span>
                        <span class="fw-semibold text-dark">{{ $project->end_date ? Carbon::parse($project->end_date)->format('d M Y') : 'Active' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Created By:</span>
                        <span class="fw-semibold text-dark">{{ optional($project->creator)->name ?? 'System' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Financial Info Card -->
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-currency-rupee text-success fs-4"></i> Financial Summary
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0 font-12">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted">Invoice Value:</span>
                        <span class="fw-semibold text-dark">₹{{ number_format($project->invoiceValue, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted">Administrative Cost:</span>
                        <span class="fw-semibold text-dark">₹{{ number_format($administrativeCost, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Profit/Loss Result:</span>
                        @if ($result['profitLossValue'] > 0)
                            <span class="fw-bold text-success">Profit (₹{{ number_format($result['profitLossValue'], 2) }})</span>
                        @elseif ($result['profitLossValue'] < 0)
                            <span class="fw-bold text-danger">Loss (₹{{ number_format(abs($result['profitLossValue']), 2) }})</span>
                        @else
                            <span class="fw-semibold text-muted">No Profit/Loss</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi Stat widgets row -->
    <div class="row g-3 mb-4">
        <!-- Labor widget -->
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-primary-subtle text-primary p-2 mb-2"><i class="ti ti-users font-20"></i></div>
                    <small class="text-muted text-uppercase font-10 fw-semibold">Team Size</small>
                    <h5 class="fw-bold text-dark mb-0">{{ $totalLabor }}</h5>
                </div>
            </div>
        </div>
        <!-- Material Cost -->
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-info-subtle text-info p-2 mb-2"><i class="ti ti-layout-list font-20"></i></div>
                    <small class="text-muted text-uppercase font-10 fw-semibold">Material Cost</small>
                    <h5 class="fw-bold text-dark mb-0">₹{{ number_format($totalMaterialCost, 0) }}</h5>
                </div>
            </div>
        </div>
        <!-- Total Cost -->
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-secondary-subtle text-secondary p-2 mb-2"><i class="ti ti-receipt-2 font-20"></i></div>
                    <small class="text-muted text-uppercase font-10 fw-semibold">Total Cost</small>
                    <h5 class="fw-bold text-dark mb-0">₹{{ number_format($totalCostIncurred, 0) }}</h5>
                </div>
            </div>
        </div>
        <!-- Project Result -->
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-warning-subtle text-warning p-2 mb-2">
                        <i class="ti ti-{{ $result['profitLossValue'] >= 0 ? 'thumb-up' : 'thumb-down' }} font-20"></i>
                    </div>
                    <small class="text-muted text-uppercase font-10 fw-semibold">Profit Status</small>
                    <h5 class="fw-bold mb-0 text-{{ $result['profitLossValue'] >= 0 ? 'success' : 'danger' }}">{{ $result['profitLossValue'] >= 0 ? 'Profit' : 'Loss' }}</h5>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-success-subtle text-success p-2 mb-2"><i class="ti ti-currency-rupee font-20"></i></div>
                    <small class="text-muted text-uppercase font-10 fw-semibold">Net Gain</small>
                    <h5 class="fw-bold mb-0 text-{{ $result['profitLossValue'] >= 0 ? 'success' : 'danger' }}">₹{{ number_format(abs($result['profitLossValue']), 0) }}</h5>
                </div>
            </div>
        </div>
        <!-- Profit Percentage -->
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-danger-subtle text-danger p-2 mb-2"><i class="ti ti-percentage font-20"></i></div>
                    <small class="text-muted text-uppercase font-10 fw-semibold">Gain Pct</small>
                    <h5 class="fw-bold mb-0 text-{{ $result['profitLossPercentage'] >= 0 ? 'success' : 'danger' }}">{{ number_format(abs($result['profitLossPercentage']), 2) }}%</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Team section -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="ti ti-users text-primary fs-4"></i> Assigned Team / Labors
            </h6>
            <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-1.5 font-12 fw-semibold" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#assignTeamModal">
                <i class="ti ti-plus me-1"></i> Assign Team
            </button>
        </div>
        <div class="card-body p-0 rounded-0 bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-sm">
                    <thead class="table-light text-uppercase font-10">
                        <tr>
                            <th class="ps-3" style="width: 120px;">Emp ID</th>
                            <th>Name</th>
                            <th style="width: 160px;">Phone</th>
                            <th style="width: 160px;">Designation</th>
                        </tr>
                    </thead>
                    <tbody class="font-12">
                        @forelse ($project->employees as $emp)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">#{{ $emp->emp_id }}</td>
                                <td class="fw-semibold">{{ $emp->name }}</td>
                                <td class="text-muted">{{ $emp->phone }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border font-12">
                                        {{ $emp->designation ? $emp->designation->name : 'N/A' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No employees assigned to this project yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include the Kanban Board for Tasks -->
    <div class="mb-4">
        @include('crm.crud.projects.kanban')
    </div>

    <!-- Payments and Bills grid side by side -->
    <div class="row g-3 mb-4">
        <!-- Payments Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-currency-rupee text-success fs-4"></i> Payments
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-2 font-12 fw-semibold" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="ti ti-plus me-1"></i> Add Payment
                    </button>
                </div>
                <div class="card-body p-0 rounded-0 d-flex flex-column justify-content-between bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-sm">
                            <thead class="table-light text-uppercase font-10">
                                <tr>
                                    <th class="ps-3">Reference</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th class="pe-3 text-center" style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="font-12">
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td class="ps-3 fw-semibold text-dark">{{ $payment->reference }}</td>
                                        <td>{{ $payment->paymentMethod ? $payment->paymentMethod->name : 'N/A' }}</td>
                                        <td class="fw-bold text-success">₹{{ number_format($payment->amount, 2) }}</td>
                                        <td class="pe-3 text-center text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                                <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmPaymentDeleteModal{{ $payment->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($payments->hasPages())
                        <div class="p-2 border-top">
                            {{ $payments->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bills Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-file-invoice text-warning fs-4"></i> Bills
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-2 font-12 fw-semibold" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#billModal">
                        <i class="ti ti-plus me-1"></i> Add Bill
                    </button>
                </div>
                <div class="card-body p-0 rounded-0 d-flex flex-column justify-content-between bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-sm">
                            <thead class="table-light text-uppercase font-10">
                                <tr>
                                    <th class="ps-3">Ref #</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th class="pe-3 text-center" style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="font-12">
                                @forelse ($bills as $bill)
                                    <tr>
                                        <td class="ps-3 fw-semibold text-dark">{{ $bill->reference }}</td>
                                        <td>{{ $bill->billType ? $bill->billType->name : 'N/A' }}</td>
                                        <td class="fw-bold text-danger">₹{{ number_format($bill->amount, 2) }}</td>
                                        <td class="pe-3 text-center text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                                <a href="{{ route('bills.edit', $bill->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmBillDeleteModal{{ $bill->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No bills found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($bills->hasPages())
                        <div class="p-2 border-top">
                            {{ $bills->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Activities & Attachments Side by Side -->
    <div class="row g-3">
        <!-- Activities -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-activity text-info fs-4"></i> Activities
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-2 font-12 fw-semibold" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#activityModal">
                        <i class="ti ti-plus me-1"></i> Add Activity
                    </button>
                </div>
                <div class="card-body p-0 rounded-0 d-flex flex-column justify-content-between bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-sm">
                            <thead class="table-light text-uppercase font-10">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>Title</th>
                                    <th>Method</th>
                                    <th class="pe-3 text-center" style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="font-12">
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td class="ps-3 text-muted">#{{ $activity->id }}</td>
                                        <td class="fw-semibold">{{ $activity->title }}</td>
                                        <td>
                                            <span class="badge bg-light text-secondary border font-12">
                                                {{ $activity->contactMethod ? $activity->contactMethod->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="pe-3 text-center text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                                <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmActivityDeleteModal{{ $activity->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No activities found.</td>
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

        <!-- Attachments -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-0 h-100 mb-0">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-photo text-danger fs-4"></i> Work Reports & Images
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 px-3 py-2 font-12 fw-semibold" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#attachmentModal">
                        <i class="ti ti-plus me-1"></i> Add Images
                    </button>
                </div>
                <div class="card-body p-0 rounded-0 d-flex flex-column justify-content-between bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-sm">
                            <thead class="table-light text-uppercase font-10">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>Type</th>
                                    <th>Files</th>
                                    <th class="pe-3 text-center" style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="font-12">
                                @forelse ($attachments as $attachment)
                                    <tr>
                                        <td class="ps-3 text-muted">#{{ $attachment->id }}</td>
                                        <td>{{ $attachment->attachmentType->name }}</td>
                                        <td>
                                            @foreach ($attachment->images as $image)
                                                <a href="{{ (\Illuminate\Support\Str::startsWith($image, 'http') ? $image : asset('storage/' . $image)) }}" target="_blank" class="badge bg-light text-primary border font-11 text-decoration-none d-inline-block me-1">{{ basename($image) }}</a>
                                            @endforeach
                                        </td>
                                        <td class="pe-3 text-center text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                <a href="{{ route('attachments.edit', $attachment->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmAttachmentDeleteModal{{ $attachment->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No attachments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($attachments->hasPages())
                        <div class="p-2 border-top">
                            {{ $attachments->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="billModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-primary text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-file-invoice me-2"></i>Add Bill</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0 bg-white">
                @include('crm.crud.projects.show_bill_form')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="activityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-info text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-activity me-2"></i>Add Activity</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0 bg-white">
                @include('crm.crud.projects.show_activity_form')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attachmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-photo me-2"></i>Add Attachment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0 bg-white">
                @include('crm.crud.projects.show_attachment_form')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-success text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-currency-rupee me-2"></i>Add Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0 bg-white">
                @include('crm.crud.projects.show_payment_form')
            </div>
        </div>
    </div>
</div>

@foreach($payments as $payment)
<div class="modal fade" id="confirmPaymentDeleteModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                Are you sure you want to delete payment reference <strong>{{ $payment->reference }}</strong>?
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($activities as $activity)
<div class="modal fade" id="confirmActivityDeleteModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Activity</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                Are you sure you want to delete activity <strong>#{{ $activity->id }}</strong>?
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($bills as $bill)
<div class="modal fade" id="confirmBillDeleteModal{{ $bill->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Bill</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                Are you sure you want to delete bill <strong>{{ $bill->reference }}</strong>?
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($attachments as $attachment)
<div class="modal fade" id="confirmAttachmentDeleteModal{{ $attachment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Attachment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                Are you sure you want to delete work report attachment <strong>#{{ $attachment->id }}</strong>?
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Add the Assign Team Modal Markup -->
<div class="modal fade" id="assignTeamModal" tabindex="-1" aria-labelledby="assignTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-primary text-white rounded-0">
                <h5 class="modal-title fw-bold font-15" id="assignTeamModalLabel"><i class="ti ti-users me-2"></i>Assign Team / Labors</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('projects.assign-team', $project->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-white rounded-0">
                    <div class="mb-3">
                        <label class="form-label font-12 fw-semibold text-muted text-uppercase">Select Employees</label>
                        <select class="form-select rounded-0" name="employee_ids[]" multiple style="height: 200px;">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $project->employees->contains($employee->id) ? 'selected' : '' }}>
                                    {{ $employee->name }} - {{ $employee->designation ? $employee->designation->name : 'Labor' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted font-11">Hold Ctrl (Windows) or Command (Mac) to select multiple.</small>
                    </div>
                </div>
                <div class="modal-footer border-top rounded-0">
                    <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 py-1.5 rounded-0 text-nowrap">Save Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
