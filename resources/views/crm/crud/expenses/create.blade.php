@extends('layouts.app')
@section('title', 'Log Expense')
@section('content')

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Log New Expense</h4>
            <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary"><i class="ti ti-arrow-left"></i> Back</a>
        </div>

        <div class="card shadow-sm border-0">
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount ({{ get_setting('currency', '₹') }}) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="Travel">Travel / Fuel</option>
                                <option value="Food">Meals / Food</option>
                                <option value="Materials">Raw Materials</option>
                                <option value="Logistics">Shipping / Logistics</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Receipt Image</label>
                            <input type="file" name="receipt" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12 mt-4 mb-2">
                            <h6 class="fw-bold border-bottom pb-2 text-primary"><i class="ti ti-receipt-tax"></i> GST / Tax Details (Optional)</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vendor GSTIN</label>
                            <input type="text" name="vendor_gstin" class="form-control" placeholder="15 digits GSTIN">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tax Rate (%)</label>
                            <select name="tax_percent" id="tax_percent" class="form-select" onchange="calculateTax()">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="12">12%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tax Amount (₹)</label>
                            <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control" placeholder="0.00" readonly>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label">Description / Remarks</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Briefly describe this expense"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-end p-3">
                    <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Submit Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function calculateTax() {
        const amount = parseFloat(document.querySelector('input[name="amount"]').value) || 0;
        const percent = parseFloat(document.getElementById('tax_percent').value) || 0;
        // Total amount = Base + Tax. Let's assume amount entered is the base, or it's inclusive.
        // For expenses, typically the user enters the total bill amount including GST, 
        // but let's assume they enter Base Amount in 'amount', and tax is added. 
        // Actually, typical expenses: they enter total amount, we need to extract tax?
        // Let's assume 'amount' is Taxable Amount (Base), and we calculate tax on top of it.
        // The total bill will be amount + tax_amount.
        const taxAmount = (amount * percent) / 100;
        document.getElementById('tax_amount').value = taxAmount.toFixed(2);
    }
    
    document.querySelector('input[name="amount"]').addEventListener('input', calculateTax);
</script>
@endsection
