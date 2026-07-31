@extends('layouts.app')
@section('title', 'Log Expense')
@section('content')

<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('expenses.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Log New Expense</h5>
                </div>
                <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Amount ({{ get_setting('currency', '₹') }}) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="Travel">Travel / Fuel</option>
                                    <option value="Food">Meals / Food</option>
                                    <option value="Materials">Raw Materials</option>
                                    <option value="Logistics">Shipping / Logistics</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Receipt Image</label>
                                <input type="file" name="receipt" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12 mt-4">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold mb-3 text-primary"><i class="ti ti-receipt-tax"></i> GST / Tax Details (Optional)</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Vendor GSTIN</label>
                                            <input type="text" name="vendor_gstin" class="form-control" placeholder="15 digits GSTIN">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Tax Rate (%)</label>
                                            <select name="tax_percent" id="tax_percent" class="form-select" onchange="calculateTax()">
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
                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Description / Remarks</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Briefly describe this expense"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end p-3">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Submit Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function calculateTax() {
        const amount = parseFloat(document.querySelector('input[name="amount"]').value) || 0;
        const percent = parseFloat(document.getElementById('tax_percent').value) || 0;
        const taxAmount = (amount * percent) / 100;
        document.getElementById('tax_amount').value = taxAmount.toFixed(2);
    }
    
    document.querySelector('input[name="amount"]').addEventListener('input', calculateTax);
</script>
@endsection
