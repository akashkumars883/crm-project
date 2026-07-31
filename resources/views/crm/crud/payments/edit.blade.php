@extends('layouts.app')

@section('title', 'Edit Payment')

@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('payments.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Edit Payment #{{ $payment->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="reference" class="form-label fw-semibold">Reference #</label>
                                <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference', $payment->reference) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="amount" class="form-label fw-semibold">Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_method_id" class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_method_id" name="payment_method_id" required>
                                    <option value="">Select Payment Method</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}"{{ $payment->payment_method_id == $paymentMethod->id ? ' selected' : '' }}>{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="payment_status_id" class="form-label fw-semibold">Payment Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_status_id" name="payment_status_id" required>
                                    <option value="">Select Payment Status</option>
                                    @foreach ($paymentStatuses as $paymentStatus)
                                        <option value="{{ $paymentStatus->id }}"{{ $payment->payment_status_id == $paymentStatus->id ? ' selected' : '' }}>{{ $paymentStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="customer_id" class="form-label fw-semibold">Customer</label>
                                <select class="form-select" id="customer_id" name="customer_id">
                                    <option value="">Select a Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"{{ $payment->customer_id == $customer->id ? ' selected' : '' }}>{{ $customer->lead->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="project_id" class="form-label fw-semibold">Project</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Select a Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"{{ $payment->project_id == $project->id ? ' selected' : '' }}>Project #{{ $project->id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold">Notes / Description</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $payment->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Update Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
