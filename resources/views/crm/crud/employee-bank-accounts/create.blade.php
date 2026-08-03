@extends('layouts.app')
@section('title', 'Add Employee Bank Account')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('employee-bank-accounts.index') }}" class="text-black text-decoration-none me-1" title="Back"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-building-bank fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Add Employee Bank Account</h5>
                    <small class="text-black-50 font-12 text-capitalize">Configure and assign banking details to registered employee profile</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <form action="{{ route('employee-bank-accounts.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="emp_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Employee <span class="text-danger">*</span></label>
                        <select name="emp_id" id="emp_id" class="form-select rounded-0 @error('emp_id') is-invalid @enderror" required>
                            <option value="" selected disabled>Select an employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->emp_id }} - {{ $employee->full_name ?? $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="account_name" class="form-label font-12 fw-semibold text-muted text-uppercase">Account Holder Name</label>
                        <input type="text" name="account_name" id="account_name" class="form-control rounded-0" value="{{ old('account_name') }}" placeholder="Enter account holder name">
                    </div>

                    <div class="col-md-4">
                        <label for="account_number" class="form-label font-12 fw-semibold text-muted text-uppercase">Account Number</label>
                        <input type="text" name="account_number" id="account_number" class="form-control rounded-0" value="{{ old('account_number') }}" placeholder="Enter account number">
                    </div>

                    <div class="col-md-4">
                        <label for="bank_name" class="form-label font-12 fw-semibold text-muted text-uppercase">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" class="form-control rounded-0" value="{{ old('bank_name') }}" placeholder="Enter bank name">
                    </div>

                    <div class="col-md-4">
                        <label for="branch" class="form-label font-12 fw-semibold text-muted text-uppercase">Branch</label>
                        <input type="text" name="branch" id="branch" class="form-control rounded-0" value="{{ old('branch') }}" placeholder="Enter branch location">
                    </div>

                    <div class="col-md-4">
                        <label for="ifsc" class="form-label font-12 fw-semibold text-muted text-uppercase">IFSC Code</label>
                        <input type="text" name="ifsc" id="ifsc" class="form-control rounded-0" value="{{ old('ifsc') }}" placeholder="e.g. SBIN0001234">
                    </div>

                    <!-- UPI / Digital Wallets Section -->
                    <div class="col-12 mt-4">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold mb-3 text-primary"><i class="ti ti-wallet"></i> Digital Payments / UPI (Optional)</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="upi" class="form-label font-12 fw-semibold text-muted text-uppercase">UPI ID</label>
                                    <input type="text" name="upi" id="upi" class="form-control rounded-0" value="{{ old('upi') }}" placeholder="name@upi">
                                </div>
                                <div class="col-md-3">
                                    <label for="phonepe" class="form-label font-12 fw-semibold text-muted text-uppercase">PhonePe Number</label>
                                    <input type="text" name="phonepe" id="phonepe" class="form-control rounded-0" value="{{ old('phonepe') }}" placeholder="10-digit number">
                                </div>
                                <div class="col-md-3">
                                    <label for="googlepay" class="form-label font-12 fw-semibold text-muted text-uppercase">Google Pay Number</label>
                                    <input type="text" name="googlepay" id="googlepay" class="form-control rounded-0" value="{{ old('googlepay') }}" placeholder="10-digit number">
                                </div>
                                <div class="col-md-3">
                                    <label for="paytm" class="form-label font-12 fw-semibold text-muted text-uppercase">Paytm Number</label>
                                    <input type="text" name="paytm" id="paytm" class="form-control rounded-0" value="{{ old('paytm') }}" placeholder="10-digit number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top text-end">
                    <button type="submit" class="btn btn-primary btn-sm px-4 py-2 font-13 rounded-0 text-nowrap" style="width: auto !important;"><i class="ti ti-check me-1"></i> Save Bank Account</button>
                    <a href="{{ route('employee-bank-accounts.index') }}" class="btn btn-secondary btn-sm px-3 py-2 font-13 rounded-0 text-nowrap ms-2" style="width: auto !important;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
