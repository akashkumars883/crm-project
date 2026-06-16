@extends('layouts.app')
@section('title', 'Project Details')
@section('content')
<div class="p-3 bg-transparent" style="font-family: 'Inter', system-ui, sans-serif;">
    <!-- Page Header & Back Button -->
    <div class="row mb-3">
        <div class="col-sm-12 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center align-items-start gap-2 px-3">
            <div>
                <a href="{{ route('myProjects') }}" class="btn btn-sm btn-outline-secondary me-2">
                    <i class="fa fa-arrow-left"></i> Back to Projects
                </a>
                <h4 class="page-title d-inline-block">Project Details: #{{ $project->id }}</h4>
            </div>
            <div>
                @php
                    $statusName = $project->projectStatus->name ?? 'N/A';
                    $badgeClass = 'bg-secondary';
                    if (in_array($statusName, ['In Progress', 'Scheduled'])) {
                        $badgeClass = 'bg-primary';
                    } elseif ($statusName == 'Completed') {
                        $badgeClass = 'bg-success';
                    } elseif ($statusName == 'On Hold') {
                        $badgeClass = 'bg-danger';
                    } elseif (in_array($statusName, ['Touch-Up', 'Client Approval'])) {
                        $badgeClass = 'bg-warning text-dark';
                    }
                @endphp
                <span class="badge {{ $badgeClass }} fs-6 px-3 py-2">{{ $statusName }}</span>
            </div>
        </div>
    </div>

    <!-- Project Summary Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 responsive-border mb-3 mb-md-0 pb-3 pb-md-0">
                            <span class="text-muted d-block small text-nowrap">PROJECT TYPE</span>
                            <h5 class="mt-1 fw-bold text-dark mb-0">{{ $project->projectType->name ?? 'N/A' }}</h5>
                        </div>
                        <div class="col-md-3 responsive-border ps-md-4 mb-3 mb-md-0 pb-3 pb-md-0">
                            <span class="text-muted d-block small text-nowrap">SUPERVISOR ASSIGNED</span>
                            <h5 class="mt-1 fw-bold text-dark mb-0">{{ $project->assignedTo->name ?? 'Not Assigned' }}</h5>
                            @if($project->assignedTo && $project->assignedTo->phone)
                                <small class="text-muted"><i class="fa fa-phone"></i> {{ $project->assignedTo->phone }}</small>
                            @endif
                        </div>
                        <div class="col-md-3 responsive-border ps-md-4 mb-3 mb-md-0 pb-3 pb-md-0">
                            <span class="text-muted d-block small text-nowrap">START DATE</span>
                            <h5 class="mt-1 fw-bold text-dark mb-0">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : 'N/A' }}</h5>
                        </div>
                        <div class="col-md-3 ps-md-4">
                            <span class="text-muted d-block small text-nowrap">ESTIMATED COMPLETION</span>
                            <h5 class="mt-1 fw-bold text-dark mb-0">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : 'Ongoing' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Tab Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-0">
                    <div class="tabs-scrollable-container">
                        <ul class="nav nav-tabs border-bottom-0 flex-nowrap w-100" id="projectDetailsTab" role="tablist">
                            <li class="nav-item flex-grow-1 flex-md-grow-0 text-center" role="presentation">
                                <button class="nav-link active py-3 fw-bold w-100 text-nowrap" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab" aria-controls="timeline" aria-selected="true">
                                    <i class="fa fa-tasks me-2"></i>Daily Work Log
                                </button>
                            </li>
                            <li class="nav-item flex-grow-1 flex-md-grow-0 text-center" role="presentation">
                                <button class="nav-link py-3 fw-bold w-100 text-nowrap" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">
                                    <i class="fa fa-users me-2"></i>Team on Site
                                </button>
                            </li>
                            <li class="nav-item flex-grow-1 flex-md-grow-0 text-center" role="presentation">
                                <button class="nav-link py-3 fw-bold w-100 text-nowrap" id="materials-tab" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="false">
                                    <i class="fa fa-paint-roller me-2"></i>Materials Used
                                </button>
                            </li>
                            <li class="nav-item flex-grow-1 flex-md-grow-0 text-center" role="presentation">
                                <button class="nav-link py-3 fw-bold w-100 text-nowrap" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing" type="button" role="tab" aria-controls="billing" aria-selected="false">
                                    <i class="fa fa-file-invoice-dollar me-2"></i>Billing & Payments
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="projectDetailsTabContent">
                        
                        <!-- TAB 1: Work Log (Timeline) -->
                        <div class="tab-pane fade show active" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <div class="timeline">
                                @forelse($activities as $activity)
                                    <div class="timeline-item">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="text-primary fw-bold mb-0">{{ $activity->title }}</h6>
                                            <span class="badge bg-light text-muted border">{{ \Carbon\Carbon::parse($activity->created_at)->format('d M Y, h:i A') }}</span>
                                        </div>
                                        <p class="text-muted small mb-2"><strong>Category:</strong> {{ $activity->activityType->name ?? 'General' }}</p>
                                        <p class="mb-0 text-dark">{{ $activity->description }}</p>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <p class="text-muted mb-0"><i class="fa fa-info-circle fa-2x mb-3 text-secondary d-block"></i>No daily work logs have been posted for this project yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- TAB 2: Team on Site (Attendance) -->
                        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                            @php
                                $groupedAttendance = $attendance->groupBy('date');
                            @endphp
                            @forelse($groupedAttendance as $date => $records)
                                <div class="card mb-3 border border-light-subtle">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <span class="fw-bold text-dark"><i class="fa fa-calendar-alt me-2 text-primary"></i>{{ \Carbon\Carbon::parse($date)->format('D d, M Y') }}</span>
                                        <span class="badge bg-primary">{{ $records->count() }} Present</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped mb-0 align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Staff Name</th>
                                                        <th>Role / Designation</th>
                                                        <th>Contact Phone</th>
                                                        <th class="text-end">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($records as $record)
                                                        <tr>
                                                            <td>
                                                                <span class="fw-semibold">{{ $record->employee->name ?? 'N/A' }}</span>
                                                            </td>
                                                            <td>{{ $record->employee->designation->name ?? 'Painter' }}</td>
                                                            <td>{{ $record->employee->phone ?? 'N/A' }}</td>
                                                            <td class="text-end">
                                                                @php
                                                                    $status = $record->attendanceStatus->name ?? 'Present';
                                                                    $statusClass = 'bg-success';
                                                                    if ($status != 'Present') {
                                                                        $statusClass = 'bg-warning text-dark';
                                                                    }
                                                                @endphp
                                                                <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <p class="text-muted mb-0"><i class="fa fa-user-clock fa-2x mb-3 text-secondary d-block"></i>No staff attendance records exist for this project yet.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- TAB 3: Materials & Inventory -->
                        <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Material / Item Title</th>
                                            <th>Category Type</th>
                                            <th>Supplier / Vendor</th>
                                            <th>Status</th>
                                            <th class="text-end">Allocated Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inventories as $inventory)
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold text-dark">{{ $inventory->title }}</span>
                                                    @if($inventory->description)
                                                        <small class="text-muted d-block">{{ $inventory->description }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $inventory->inventoryType->name ?? 'General' }}</td>
                                                <td>{{ $inventory->vendor->name ?? 'Local Vendor' }}</td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                        {{ $inventory->inventoryStatus->name ?? 'Allocated' }}
                                                    </span>
                                                </td>
                                                <td class="text-end fw-bold text-dark">
                                                    @if($inventory->cost)
                                                        ₹{{ number_format(floatval($inventory->cost), 2) }}
                                                    @else
                                                        ₹0.00
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-5">
                                                    <i class="fa fa-boxes fa-2x mb-3 text-secondary d-block"></i>No materials or inventory have been logged to this project yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- TAB 4: Billing & Payments -->
                        <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                            @php
                                $totalContract = floatval($project->invoiceValue);
                                $totalPaid = floatval($project->payments->sum('amount'));
                                $balance = $totalContract - $totalPaid;
                            @endphp

                            <!-- Financial Summary Counters -->
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="card bg-primary-subtle border-0 text-primary p-3 shadow-sm rounded">
                                        <span class="small uppercase font-12 fw-bold d-block mb-1">TOTAL CONTRACT VALUE</span>
                                        <h3 class="fw-bold mb-0">₹{{ number_format($totalContract, 2) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="card bg-success-subtle border-0 text-success p-3 shadow-sm rounded">
                                        <span class="small uppercase font-12 fw-bold d-block mb-1">TOTAL PAID AMOUNT</span>
                                        <h3 class="fw-bold mb-0">₹{{ number_format($totalPaid, 2) }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning-subtle border-0 text-warning-emphasis p-3 shadow-sm rounded">
                                        <span class="small uppercase font-12 fw-bold d-block mb-1">OUTSTANDING BALANCE</span>
                                        <h3 class="fw-bold mb-0">₹{{ number_format($balance, 2) }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa fa-history me-2 text-primary"></i>Payment History</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Payment ID</th>
                                                <th>Received Date</th>
                                                <th>Payment Method</th>
                                                <th>Payment Status</th>
                                                <th class="text-end">Amount Received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($payments as $payment)
                                                <tr>
                                                    <td>#{{ $payment->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                                    <td>{{ $payment->paymentMethod->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @php
                                                            $pStatus = $payment->paymentStatus->name ?? 'Pending';
                                                            $pStatusClass = 'bg-warning text-dark';
                                                            if ($pStatus == 'Paid' || $pStatus == 'Success' || $pStatus == 'Completed') {
                                                                $pStatusClass = 'bg-success';
                                                            }
                                                        @endphp
                                                        <span class="badge {{ $pStatusClass }}">{{ $pStatus }}</span>
                                                    </td>
                                                    <td class="text-end fw-bold text-dark">₹{{ number_format(floatval($payment->amount), 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No payments have been received yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Embedded Premium Styling for Timeline & Mobile Responsiveness -->
<style>
.card {
    border-radius: 4px !important;
    border: 1px solid #e9ecef !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
}
.badge {
    border-radius: 4px !important;
}
.timeline {
    position: relative;
    padding-left: 35px;
    margin-top: 15px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 5px;
    bottom: 5px;
    width: 2px;
    background: #dee2e6;
}
.timeline-item {
    position: relative;
    padding-bottom: 25px;
}
.timeline-item:last-child {
    padding-bottom: 5px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 3px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #0d6efd;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
    z-index: 2;
}
.nav-tabs .nav-link {
    color: #495057;
    border-bottom: 3px solid transparent;
    transition: all 0.2s ease-in-out;
}
.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 3px solid #0d6efd;
}
.nav-tabs .nav-link:hover:not(.active) {
    border-color: transparent transparent #e9ecef transparent;
    color: #0d6efd;
}

/* Horizontal scrolling tabs for mobile screens */
.tabs-scrollable-container {
    overflow-x: auto;
    overflow-y: hidden;
    display: flex;
    flex-wrap: nowrap;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    border-bottom: 1px solid #dee2e6;
}
.tabs-scrollable-container::-webkit-scrollbar {
    display: none;
}
.tabs-scrollable-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Custom responsive borders for cards on small screens */
@media (max-width: 767.98px) {
    .responsive-border {
        border-right: none !important;
        border-bottom: 1px solid #eef2f5 !important;
    }
}
@media (min-width: 768px) {
    .responsive-border {
        border-right: 1px solid #dee2e6 !important;
    }
}
</style>
@endsection
