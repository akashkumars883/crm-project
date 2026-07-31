@extends('layouts.app')
@section('title', 'Edit Bill')

@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('bills.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Edit Bill #{{ $bill->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('bills.update', $bill->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="bill_type_id" class="form-label fw-semibold">Bill Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="bill_type_id" name="bill_type_id" required>
                                    <option value="">Select Bill Type</option>
                                    @foreach ($billTypes as $billType)
                                        <option value="{{ $billType->id }}"{{ $bill->bill_type_id == $billType->id ? ' selected' : '' }}>{{ $billType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="reference" class="form-label fw-semibold">Reference #</label>
                                <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference', $bill->reference) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="amount" class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $bill->amount) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="bill_date" class="form-label fw-semibold">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="bill_date" name="bill_date" value="{{ old('bill_date', $bill->bill_date) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="due_date" class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $bill->due_date) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="bill_status_id" class="form-label fw-semibold">Bill Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="bill_status_id" name="bill_status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach ($billStatuses as $billStatus)
                                        <option value="{{ $billStatus->id }}"{{ $bill->bill_status_id == $billStatus->id ? ' selected' : '' }}>{{ $billStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="payment_method_id" class="form-label fw-semibold">Payment Method</label>
                                <select class="form-select" id="payment_method_id" name="payment_method_id">
                                    <option value="">Select Method</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}"{{ $bill->payment_method_id == $paymentMethod->id ? ' selected' : '' }}>{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="project_id" class="form-label fw-semibold">Project</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"{{ $bill->project_id == $project->id ? ' selected' : '' }}>{{ $project->id }} - {{ $project->customer->lead->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="inventory_id" class="form-label fw-semibold">Inventory</label>
                                <select class="form-select" id="inventory_id" name="inventory_id">
                                    <option value="">Select Inventory</option>
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}"{{ $bill->inventory_id == $inventory->id ? ' selected' : '' }}>{{ $inventory->id }} - {{ $inventory->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="employee_id" class="form-label fw-semibold">Employee</label>
                                <select class="form-select" id="employee_id" name="employee_id">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"{{ $bill->employee_id == $employee->id ? ' selected' : '' }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label for="notes" class="form-label fw-semibold">Notes / Description</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $bill->notes) }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label for="attachments" class="form-label fw-semibold">New Attachments</label>
                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('bills.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Update Bill</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
