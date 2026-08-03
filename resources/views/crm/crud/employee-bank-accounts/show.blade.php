@extends('layouts.app')
@section('title', 'Employee Bank Account Details')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('employee-bank-accounts.index') }}" class="text-black text-decoration-none me-1" title="Back"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-building-bank fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Employee Bank Details</h5>
                    <small class="text-black-50 font-12 text-capitalize">Detailed banking profile and digital wallet setups for {{ optional($employeeBankAccount->employee)->name }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('employee-bank-accounts.edit', $employeeBankAccount->id) }}" class="btn btn-light btn-sm px-3 py-2 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" style="width: auto !important;">
                    <i class="ti ti-pencil me-1.5 text-warning"></i> Edit Details
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- 2-Column Info Grid -->
            <div class="row g-4">
                <!-- Left: Bank Account Credentials -->
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm border rounded-0 h-100 mb-0">
                        <div class="card-header bg-light py-2.5 px-3 border-bottom rounded-0 fw-bold font-12 text-muted">
                            <i class="ti ti-building-bank me-1 text-primary"></i> BANKING CREDENTIALS
                        </div>
                        <div class="card-body p-3 font-13">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Employee ID:</span>
                                <span class="fw-bold text-dark">#{{ optional($employeeBankAccount->employee)->emp_id ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Employee Name:</span>
                                <span class="fw-semibold text-dark">{{ optional($employeeBankAccount->employee)->name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Bank Name:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->bank_name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Branch Location:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->branch ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">IFSC Code:</span>
                                <span class="badge bg-light text-secondary border font-12">{{ $employeeBankAccount->ifsc ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted">Account Holder:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->account_name ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Account Number:</span>
                                <span class="fw-bold text-primary font-14">{{ $employeeBankAccount->account_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Digital Wallet credentials -->
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm border rounded-0 h-100 mb-0">
                        <div class="card-header bg-light py-2.5 px-3 border-bottom rounded-0 fw-bold font-12 text-muted">
                            <i class="ti ti-wallet me-1 text-primary"></i> DIGITAL WALLETS & UPI
                        </div>
                        <div class="card-body p-3 font-13">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted"><i class="ti ti-device-mobile me-1 text-primary"></i>UPI ID:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->upi ?: 'Not Registered' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted"><i class="ti ti-brand-google me-1 text-danger"></i>Google Pay No:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->googlepay ?: 'Not Registered' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                <span class="text-muted"><i class="ti ti-brand-paypal me-1 text-info"></i>PhonePe No:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->phonepe ?: 'Not Registered' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted"><i class="ti ti-wallet me-1 text-warning"></i>Paytm No:</span>
                                <span class="fw-semibold text-dark">{{ $employeeBankAccount->paytm ?: 'Not Registered' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-top pt-3 text-end">
                <a href="{{ route('employee-bank-accounts.index') }}" class="btn btn-secondary btn-sm px-3 py-2 font-13 rounded-0 text-nowrap" style="width: auto !important;">Back to List</a>
            </div>
        </div>
    </div>
</div>

@endsection
