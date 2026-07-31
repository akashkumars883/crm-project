@extends('layouts.app')
@section('title', 'Add Employee Bank Account')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('employee-bank-accounts.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Add Employee Bank Account</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('employee-bank-accounts.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="emp_id" class="form-label fw-semibold">Employee <span class="text-danger">*</span></label>
                                <select name="emp_id" id="emp_id" class="form-select @error('emp_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select an employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->emp_id }} - {{ $employee->full_name ?? $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="account_name" class="form-label fw-semibold">Account Holder Name</label>
                                <input type="text" name="account_name" id="account_name" class="form-control" value="{{ old('account_name') }}" placeholder="Enter account holder name">
                            </div>

                            <div class="col-md-4">
                                <label for="account_number" class="form-label fw-semibold">Account Number</label>
                                <input type="text" name="account_number" id="account_number" class="form-control" value="{{ old('account_number') }}" placeholder="Enter account number">
                            </div>

                            <div class="col-md-4">
                                <label for="bank_name" class="form-label fw-semibold">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ old('bank_name') }}" placeholder="Enter bank name">
                            </div>

                            <div class="col-md-4">
                                <label for="branch" class="form-label fw-semibold">Branch</label>
                                <input type="text" name="branch" id="branch" class="form-control" value="{{ old('branch') }}" placeholder="Enter branch location">
                            </div>

                            <div class="col-md-4">
                                <label for="ifsc" class="form-label fw-semibold">IFSC Code</label>
                                <input type="text" name="ifsc" id="ifsc" class="form-control" value="{{ old('ifsc') }}" placeholder="e.g. SBIN0001234">
                            </div>

                            <!-- UPI / Digital Wallets Section -->
                            <div class="col-12 mt-4">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold mb-3 text-primary"><i class="ti ti-wallet"></i> Digital Payments / UPI (Optional)</h6>
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label for="upi" class="form-label fw-semibold">UPI ID</label>
                                            <input type="text" name="upi" id="upi" class="form-control" value="{{ old('upi') }}" placeholder="name@upi">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="phonepe" class="form-label fw-semibold">PhonePe Number</label>
                                            <input type="text" name="phonepe" id="phonepe" class="form-control" value="{{ old('phonepe') }}" placeholder="10-digit number">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="googlepay" class="form-label fw-semibold">Google Pay Number</label>
                                            <input type="text" name="googlepay" id="googlepay" class="form-control" value="{{ old('googlepay') }}" placeholder="10-digit number">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="paytm" class="form-label fw-semibold">Paytm Number</label>
                                            <input type="text" name="paytm" id="paytm" class="form-control" value="{{ old('paytm') }}" placeholder="10-digit number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('employee-bank-accounts.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Save Bank Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
