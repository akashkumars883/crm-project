@extends('layouts.app')
@section('title', 'All Payments')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-currency-rupee fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Payments Ledger</h5>
                    <small class="text-black-50 font-12 text-capitalize">Track customer inward transactions, reference IDs, and payment methods</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('payments.create') }}" class="bg-blue text-white text-capitalize btn btn-light btn-sm px-3 py-2 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" style="width: auto !important;">
                    <i class="ti ti-plus me-2"></i> Add a New Payment
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- Search & Filter Bar -->
            <form action="{{ route('payments.index') }}" method="GET" class="card bg-light border-0 rounded-0 p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="position-relative">
                            <i class="ti ti-search position-absolute top-50 translate-middle-y text-muted" style="left: 12px; font-size: 16px; z-index: 5;"></i>
                            <input type="text" name="search" class="form-control rounded-0 font-13" placeholder="Search by reference, customer..." value="{{ request('search') }}" style="padding-left: 36px;">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 px-2 py-2 font-13 text-nowrap" style="width: auto !important;"><i class="ti ti-search me-1"></i> Search</button>
                        @if(request('search'))
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm rounded-0 px-2 py-2 font-13 text-nowrap" style="width: auto !important;">Clear</a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0 table-sm">
                    <thead class="table-light text-uppercase font-10">
                        <tr>
                            <th class="ps-2">Reference ID</th>
                            <th>Customer</th>
                            <th>Project ID</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="pe-2 text-center" style="width: 90px; width: 90px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="font-12">
                        @forelse($payments as $payment)
                            <tr>
                                <td class="ps-2 fw-semibold text-dark">{{ $payment->reference }}</td>
                                <td class="fw-semibold text-dark">{{ $payment->customer->name ?? 'Not Assigned' }}</td>
                                <td>
                                    @if($payment->project_id)
                                        <span class="badge bg-light text-secondary border font-12">#{{ $payment->project_id }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $payment->paymentMethod->name ?? 'N/A' }}</td>
                                <td class="fw-bold text-success">₹{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @php
                                        $status = strtolower($payment->paymentStatus->name ?? 'pending');
                                        $badgeClass = 'bg-warning-subtle text-warning border-warning-subtle';
                                        if (str_contains($status, 'success') || str_contains($status, 'paid') || str_contains($status, 'complete')) {
                                            $badgeClass = 'bg-success-subtle text-success border-success-subtle';
                                        } elseif (str_contains($status, 'fail') || str_contains($status, 'refund')) {
                                            $badgeClass = 'bg-danger-subtle text-danger border-danger-subtle';
                                        }
                                    @endphp
                                    <span class="badge border rounded-0 font-12 fw-semibold px-2 py-1 {{ $badgeClass }}">
                                        {{ $payment->paymentStatus->name ?? 'Pending' }}
                                    </span>
                                </td>
                                <td class="pe-2 text-center text-nowrap">
                                    <div class="d-inline-flex align-items-center gap-1 justify-content-center">
                                        <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-info rounded-0 px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-outline-primary rounded-0 px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $payment->id }}" title="Delete"><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No payments history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="pt-3 border-top bg-white rounded-bottom">
                    {{ $payments->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

@foreach($payments as $payment)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmDeleteModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-danger text-white rounded-0">
                <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Payment Log</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                <p class="mb-1 font-14">Are you sure you want to delete payment log: <strong>{{ $payment->reference }}</strong>?</p>
                <small class="text-muted font-12">This action is permanent and will delete transaction ledger entry.</small>
            </div>
            <div class="modal-footer border-top rounded-0">
                <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
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