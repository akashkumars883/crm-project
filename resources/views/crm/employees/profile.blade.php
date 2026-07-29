@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Profile</h4>
            </div>
        </div>
    </div>

    @if ($employee)
        <div class="row">
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <div class="media mb-3 text-center">
                            <div class="media-body align-self-center">
                                @if ($employee->photograph)
                                    <img src="{{ (\Illuminate\Support\Str::startsWith($employee->photograph, 'http') ? $employee->photograph : asset('storage/' . $employee->photograph)) }}" alt="Employee Photograph" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; border-radius: 50%;">
                                        <i class="fas fa-user fa-4x text-muted"></i>
                                    </div>
                                    <p class="text-muted mt-2">No Photograph Uploaded</p>
                                @endif
                            </div>
                        </div>
                        <hr class="hr-dashed">
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <h4 class="text-primary mt-0 font-24 mb-3">{{ $employee->name }}</h4>
                        <p class="mb-2 font-14"><i class="fas fa-phone text-muted me-2"></i> {{ $employee->phone }} </p>
                        <p class="mb-2 font-14"><i class="fas fa-envelope text-muted me-2"></i> {{ $employee->email }} </p>
                        <p class="mb-3 font-14"><i class="fas fa-map-marker-alt text-muted me-2"></i> {{ $employee->address }}, {{ $employee->city }}, {{ $employee->state }} - {{ $employee->zip_code }} </p>

                        <p class="mb-1 font-14"><strong>Gender:</strong> {{ optional($employee->gender)->name ?? 'N/A' }} </p>
                        <p class="mb-1 font-14"><strong>Blood Group:</strong> {{ optional($employee->bloodGroup)->name ?? 'N/A' }} </p>
                        <p class="mb-1 font-14"><strong>Date of Birth:</strong> {{ $employee->date_of_birth ? Carbon::parse($employee->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                        <p class="mb-3 font-14"><strong>Age:</strong> {{ $employee->date_of_birth ? Carbon::parse($employee->date_of_birth)->age . ' years' : 'N/A' }}</p>
                        
                        <hr class="hr-dashed">
                        <p class="mb-2 font-14 fw-bold">Documents</p>
                        @if ($employee->pan)
                            <a href="{{ (\Illuminate\Support\Str::startsWith($employee->pan, 'http') ? $employee->pan : asset('storage/' . $employee->pan)) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">PAN Card</a>
                        @else
                            <span class="text-muted small">No PAN</span>
                        @endif
                        @if ($employee->aadhaar)
                            <a href="{{ (\Illuminate\Support\Str::startsWith($employee->aadhaar, 'http') ? $employee->aadhaar : asset('storage/' . $employee->aadhaar)) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">Aadhaar Card</a>
                        @else
                            <span class="text-muted small">No Aadhaar</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <p class="mb-2 font-14"><strong>Employee ID:</strong> {{ $employee->emp_id }} </p>
                        <p class="mb-2 font-14"><strong>Employee Type:</strong> {{ optional($employee->employeeType)->name ?? 'N/A' }} </p>
                        <p class="mb-2 font-14"><strong>Joining Date:</strong> {{ $employee->joining_date ? Carbon::parse($employee->joining_date)->format('M d, Y') : 'N/A' }}</p>
                        <p class="mb-2 font-14"><strong>Salary:</strong> ₹{{ $employee->salary ?? '0' }} </p>
                        <p class="mb-2 font-14"><strong>Department:</strong> {{ optional($employee->department)->name ?? 'N/A' }} </p>
                        <p class="mb-2 font-14"><strong>Designation:</strong> {{ optional($employee->designation)->name ?? 'N/A' }} </p>
                        <p class="mb-2 font-14"><strong>Skill Paint:</strong> {{ optional($employee->skillPaint)->name ?? 'N/A' }} </p>
                        <p class="mb-2 font-14"><strong>Skill Polish:</strong> {{ optional($employee->skillPolish)->name ?? 'N/A' }} </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <h4 class="mt-0 mb-3 font-16 fw-bold">Banking Information</h4>
                        @if($employee->employeeBankAccount)
                            <p class="mb-2 font-14"><strong>Bank Name:</strong> {{ $employee->employeeBankAccount->bank_name }}</p>
                            <p class="mb-2 font-14"><strong>Branch:</strong> {{ $employee->employeeBankAccount->branch }}</p>
                            <p class="mb-2 font-14"><strong>IFSC:</strong> {{ $employee->employeeBankAccount->ifsc }}</p>
                            <p class="mb-2 font-14"><strong>Account Name:</strong> {{ $employee->employeeBankAccount->account_name }}</p>
                            <p class="mb-2 font-14"><strong>Account Number:</strong> {{ $employee->employeeBankAccount->account_number }}</p>
                            <hr class="hr-dashed">
                            <p class="mb-2 font-14"><strong>UPI:</strong> {{ $employee->employeeBankAccount->upi }}</p>
                            <p class="mb-2 font-14"><strong>PhonePe:</strong> {{ $employee->employeeBankAccount->phonepe }}</p>
                            <p class="mb-2 font-14"><strong>GooglePay:</strong> {{ $employee->employeeBankAccount->googlepay }}</p>
                            <p class="mb-2 font-14"><strong>Paytm:</strong> {{ $employee->employeeBankAccount->paytm }}</p>
                        @else
                            <div class="text-center text-muted mt-4">
                                <i class="fas fa-university fa-3x mb-2"></i>
                                <p class="mb-0 font-14">No bank details added.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center py-4">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm p-4">
                    <div class="card-body">
                        <i class="ti ti-user-x text-warning display-4 mb-3"></i>
                        <h5 class="fw-bold mb-2">Employee Profile Not Linked</h5>
                        <p class="text-muted mb-0">Your login account is not linked to an employee profile yet. Please ask an admin to link your account under <strong>Authentication &gt; Employee</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
