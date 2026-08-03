@extends('layouts.app')
@section('title', 'Payment Details')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('payments.index') }}" class="text-black text-decoration-none me-1" title="Back"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-currency-rupee fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Payment Voucher Details</h5>
                    <small class="text-black-50 font-12 text-capitalize">Transaction audit, method details, and linked entity references</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-light btn-sm px-3 py-2 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" style="width: auto !important;">
                    <i class="ti ti-pencil me-1.5 text-warning"></i> Edit Payment
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-sm border rounded-0">
                        <div class="card-header bg-light py-2.5 px-3 border-bottom rounded-0 fw-bold font-12 text-muted">
                            <i class="ti ti-receipt me-1 text-primary"></i> TRANSACTION PARTICULARS
                        </div>
                        <div class="card-body p-3 font-13">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Reference #:</span>
                                <span class="fw-bold text-dark">{{ $payment->reference }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Payment Method:</span>
                                <span class="fw-semibold text-dark">{{ $payment->paymentMethod->name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Payment Status:</span>
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
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Customer Name:</span>
                                <span class="fw-semibold text-dark">{{ $payment->customer ? $payment->customer->lead->name : 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Project ID:</span>
                                @if($payment->project_id)
                                    <span class="badge bg-light text-secondary border font-12">#{{ $payment->project_id }}</span>
                                @else
                                    <span class="text-muted">Not Linked</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Transaction Amount:</span>
                                <span class="fw-bold text-success font-15">₹{{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="text-muted">Notes/Remarks:</span>
                                <span class="fw-semibold text-dark text-end" style="max-width: 70%;">{{ $payment->notes ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-top pt-3 text-end">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm px-3 py-2 font-13 rounded-0 text-nowrap" style="width: auto !important;">Back to List</a>
            </div>
        </div>
    </div>
</div>

@endsection
