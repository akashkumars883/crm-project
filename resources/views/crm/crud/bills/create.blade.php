@extends('layouts.app')
@section('title', 'Create Bill')

@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('bills.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Create New Bill</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('bills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Basic Bill Details -->
                            <div class="col-md-4">
                                <label for="bill_type_id" class="form-label fw-semibold">Bill Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="bill_type_id" name="bill_type_id" required>
                                    <option value="">Select Bill Type</option>
                                    @foreach ($billTypes as $billType)
                                        <option value="{{ $billType->id }}">{{ $billType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="reference" class="form-label fw-semibold">Reference #</label>
                                <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}" placeholder="e.g. REF-1002">
                            </div>

                            <div class="col-md-4">
                                <label for="amount" class="form-label fw-semibold">Base Amount (Taxable) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $presetAmount ?? '') }}" required placeholder="0.00" oninput="calcBillTax()">
                            </div>

                            <!-- GST / Tax Details -->
                            <div class="col-12 mt-4">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold mb-3 text-primary"><i class="ti ti-receipt-tax"></i> GST / Tax Details (Optional)</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Vendor GSTIN</label>
                                            <input type="text" name="vendor_gstin" class="form-control" placeholder="15 digits GSTIN" value="{{ old('vendor_gstin') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Tax Rate (%)</label>
                                            <select name="tax_percent" id="tax_percent" class="form-select" onchange="calcBillTax()">
                                                <option value="0">0%</option>
                                                <option value="5">5%</option>
                                                <option value="12">12%</option>
                                                <option value="18">18%</option>
                                                <option value="28">28%</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Tax Amount (₹)</label>
                                            <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control" placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates & Status -->
                            <div class="col-md-4">
                                <label for="bill_date" class="form-label fw-semibold">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="bill_date" name="bill_date" value="{{ old('bill_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="due_date" class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="bill_status_id" class="form-label fw-semibold">Bill Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="bill_status_id" name="bill_status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach ($billStatuses as $billStatus)
                                        <option value="{{ $billStatus->id }}">{{ $billStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Associations & Payment -->
                            <div class="col-md-3">
                                <label for="payment_method_id" class="form-label fw-semibold">Payment Method</label>
                                <select class="form-select" id="payment_method_id" name="payment_method_id">
                                    <option value="">Select Method</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="project_id" class="form-label fw-semibold">Project</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->id }} - {{ $project->customer->lead->name ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="inventory_id" class="form-label fw-semibold">Inventory</label>
                                <select class="form-select" id="inventory_id" name="inventory_id">
                                    <option value="">Select Inventory</option>
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}">{{ $inventory->id }} - {{ $inventory->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="employee_id" class="form-label fw-semibold">Employee</label>
                                <select class="form-select" id="employee_id" name="employee_id">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ (old('employee_id', $presetEmployeeId ?? '') == $employee->id) ? 'selected' : '' }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Notes & Attachments -->
                            <div class="col-md-8">
                                <label for="notes" class="form-label fw-semibold">Notes / Description</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Additional details about this bill"></textarea>
                            </div>

                            <div class="col-md-4">
                                <label for="attachments" class="form-label fw-semibold">Attachments</label>
                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('bills.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Create Bill</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function calcBillTax() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const percent = parseFloat(document.getElementById('tax_percent').value) || 0;
        const taxAmount = (amount * percent) / 100;
        document.getElementById('tax_amount').value = taxAmount.toFixed(2);
    }
</script>
@endsection
