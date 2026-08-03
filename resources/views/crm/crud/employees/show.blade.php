@extends('layouts.app')
@section('title', $employee->name . ' - Employee Profile')
@section('content')
@php
    use Carbon\Carbon;
    $empUser = $employee->employeeUser;
    $user = $empUser ? $empUser->user : \App\Models\User::where('email', $employee->email)->first();
    $userRole = $user ? $user->roles->first() : null;
    $displayPassword = $employee->user_password ?: ($employee->phone ?: '12345678');
@endphp

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Profile Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('employees.index') }}" class="text-black text-decoration-none me-1" title="Back to Employee List"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-id-badge fs-2"></i>
                <span class="fw-bold fs-5 text-black text-nowrap text-capitalize">Employee Profile & Management</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-white text-primary px-3 py-2 fw-bold font-12 rounded-0 text-nowrap">
                    ID: {{ $employee->emp_id }}
                </span>
                <span class="badge bg-success px-3 py-2 fw-semibold font-12 rounded-1 text-nowrap text-capitalize">
                    <i class="ti ti-point-filled me-1"></i>Active Staff
                </span>
            </div>
        </div>
        <div class="card-body p-4 bg-white rounded-0">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <!-- Left Photo & Title Block -->
                <div class="d-flex align-items-center gap-3">
                    <div class="flex-shrink-0">
                        @if ($employee->photograph)
                            <img src="{{ (\Illuminate\Support\Str::startsWith($employee->photograph, 'http') ? $employee->photograph : asset('storage/' . $employee->photograph)) }}" alt="{{ $employee->name }}" class="rounded-circle border border-2 border-primary shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary-subtle text-primary border border-2 border-primary d-flex align-items-center justify-content-center fw-bold fs-2 shadow-sm" style="width: 80px; height: 80px;">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-1">{{ $employee->name }}</h3>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="badge bg-light text-dark border rounded-0 px-2 py-1 font-12 fw-semibold text-nowrap">
                                <i class="ti ti-briefcase text-primary me-1"></i>{{ optional($employee->designation)->name ?? 'General Staff' }}
                            </span>
                            <span class="badge bg-light text-dark border rounded-0 px-2 py-1 font-12 fw-semibold text-nowrap">
                                <i class="ti ti-building text-info me-1"></i>{{ optional($employee->department)->name ?? 'Operations' }}
                            </span>
                            <span class="badge bg-light text-dark border rounded-0 px-2 py-1 font-12 fw-semibold text-nowrap">
                                <i class="ti ti-user-check text-success me-1"></i>{{ optional($employee->employeeType)->name ?? 'Full Time' }}
                            </span>
                        </div>
                        <div class="text-muted font-12 d-flex flex-wrap align-items-center gap-3">
                            <span class="text-nowrap"><i class="ti ti-mail me-1 text-secondary"></i>{{ $employee->email }}</span>
                            <span class="text-nowrap"><i class="ti ti-phone me-1 text-secondary"></i>{{ $employee->phone ?: 'N/A' }}</span>
                            @if($employee->address)
                                <span><i class="ti ti-map-pin me-1 text-secondary"></i>{{ \Illuminate\Support\Str::limit($employee->address, 35) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Button Toolbar -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important; display: inline-flex !important; align-items: center;">
                        <i class="ti ti-pencil me-1"></i> Edit Profile
                    </a>
                    <a href="{{ route('attendance-records.sheet') }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important; display: inline-flex !important; align-items: center;">
                        <i class="ti ti-calendar-plus me-1"></i> Attendance Sheet
                    </a>
                    <button type="button" class="btn btn-success btn-sm px-3 py-2 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important; display: inline-flex !important; align-items: center;" data-bs-toggle="modal" data-bs-target="#payoutModal">
                        <i class="ti ti-cash me-1"></i> Record Payout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Full Width 4-Card Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. System Login & Credentials Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                        <i class="ti ti-shield-lock text-primary fs-4"></i> Login Credentials
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0">
                    <div class="mb-3">
                        <small class="text-muted d-block fw-semibold font-12 text-capitalize">Username / Email ID</small>
                        <span class="fw-bold text-dark font-12 text-break">{{ $employee->email }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block fw-semibold font-12 text-capitalize mb-1">System Access Role</small>
                        <span class="badge bg-primary-subtle text-primary rounded-0 font-12 fw-bold text-nowrap">
                            {{ ucfirst(optional($userRole)->display_name ?? optional($userRole)->name ?? 'Employee') }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block fw-semibold font-12 text-capitalize">Login Password</small>
                        <div class="position-relative mt-1">
                            <input type="password" id="empPasswordInput" class="form-control form-control-sm font-12 fw-bold bg-light rounded-0" value="{{ $displayPassword }}" readonly style="padding-right: 36px;">
                            <i class="ti ti-eye position-absolute top-50 translate-middle-y text-muted" id="togglePasswordIcon" onclick="togglePasswordVisibility()" style="right: 10px; font-size: 16px; cursor: pointer; z-index: 5;"></i>
                        </div>
                    </div>
                    <div class="pt-2 border-top">
                        <a href="{{ route('employees.edit', $employee->id) }}#user_password" class="btn btn-sm btn-outline-primary w-100 py-1.5 font-12 fw-semibold rounded-0 text-nowrap">
                            <i class="ti ti-key me-1"></i> Change / Reset Password
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Personal Information Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                        <i class="ti ti-user text-info fs-4"></i> Personal Details
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Gender:</span>
                        <span class="fw-semibold text-dark font-12 text-nowrap">{{ optional($employee->gender)->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Blood Group:</span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-0 fw-bold font-12 text-nowrap">{{ optional($employee->bloodGroup)->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Date of Birth:</span>
                        <span class="fw-semibold text-dark font-12 text-nowrap">{{ $employee->date_of_birth ? Carbon::parse($employee->date_of_birth)->format('d M Y') : 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Age:</span>
                        <span class="fw-semibold text-dark font-12 text-nowrap">{{ $employee->date_of_birth ? Carbon::parse($employee->date_of_birth)->age . ' Yrs' : 'N/A' }}</span>
                    </div>
                    <div class="pt-1">
                        <small class="text-muted d-block fw-semibold font-12 text-uppercase mb-1">Uploaded Documents</small>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($employee->pan)
                                <a href="{{ (\Illuminate\Support\Str::startsWith($employee->pan, 'http') ? $employee->pan : asset('storage/' . $employee->pan)) }}" target="_blank" class="badge bg-primary rounded-0 text-decoration-none px-2 py-1 text-nowrap"><i class="ti ti-file-text me-1"></i>PAN Card</a>
                            @endif
                            @if ($employee->aadhaar)
                                <a href="{{ (\Illuminate\Support\Str::startsWith($employee->aadhaar, 'http') ? $employee->aadhaar : asset('storage/' . $employee->aadhaar)) }}" target="_blank" class="badge bg-primary rounded-0 text-decoration-none px-2 py-1 text-nowrap"><i class="ti ti-file-text me-1"></i>Aadhaar Card</a>
                            @endif
                            @if (!$employee->pan && !$employee->aadhaar)
                                <span class="text-muted font-12">No documents</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Job & Skill Details Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                        <i class="ti ti-briefcase text-warning fs-4"></i> Employment Details
                    </h6>
                </div>
                <div class="card-body p-3 rounded-0">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Employee Type:</span>
                        <span class="fw-semibold text-dark font-12 text-nowrap">{{ optional($employee->employeeType)->name ?? 'Full Time' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Joining Date:</span>
                        <span class="fw-semibold text-dark font-12 text-nowrap">{{ $employee->joining_date ? Carbon::parse($employee->joining_date)->format('d M Y') : 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Salary Rate:</span>
                        <span class="fw-bold text-success font-12 text-nowrap">₹{{ number_format($employee->salary ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                        <span class="text-muted font-12">Skill Paint:</span>
                        <span class="badge bg-secondary-subtle text-dark border rounded-0 font-12 text-nowrap">{{ optional($employee->skillPaint)->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted font-12">Skill Polish:</span>
                        <span class="badge bg-secondary-subtle text-dark border rounded-0 font-12 text-nowrap">{{ optional($employee->skillPolish)->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Bank Account Details Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-0 h-100">
                <div class="card-header bg-light py-3 border-bottom rounded-0 d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                        <i class="ti ti-building-bank text-success fs-4"></i> Bank Account Info
                    </h6>
                    @if(!$employee->employeeBankAccount)
                        <button type="button" class="btn btn-sm btn-primary rounded-0 font-12 px-2 py-1 text-nowrap" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#bankModal">+ Add</button>
                    @endif
                </div>
                <div class="card-body p-3 rounded-0">
                    @if($employee->employeeBankAccount)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                            <span class="text-muted font-12">Bank:</span>
                            <span class="fw-bold text-dark font-12 text-nowrap">{{ $employee->employeeBankAccount->bank_name }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                            <span class="text-muted font-12">Account No:</span>
                            <span class="fw-semibold text-dark font-12 text-nowrap">{{ $employee->employeeBankAccount->account_number }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                            <span class="text-muted font-12">IFSC Code:</span>
                            <span class="fw-semibold text-dark font-12 text-nowrap text-uppercase">{{ $employee->employeeBankAccount->ifsc }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted font-12">Branch / UPI:</span>
                            <span class="fw-semibold text-dark font-12 text-nowrap">{{ $employee->employeeBankAccount->upi ?: ($employee->employeeBankAccount->branch ?: 'N/A') }}</span>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="ti ti-credit-card-off fs-1 d-block mb-1 opacity-50"></i>
                            <small class="d-block text-muted font-12 mb-2">No bank details added yet</small>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-0 py-1.5 px-3 font-12 text-nowrap" style="width: auto !important; display: inline-block !important;" data-bs-toggle="modal" data-bs-target="#bankModal">+ Add Bank Details</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Attendance & Payroll Calculation Summary Banner -->
    @php
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $monthName = now()->format('F Y');

        $thisMonthAttendance = \App\Models\AttendanceRecord::where('employee_id', $employee->id)
            ->whereBetween('date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
            ->get();

        $presentCount = 0;
        $halfDayCount = 0;
        $absentCount = 0;

        foreach($thisMonthAttendance as $att) {
            $st = strtolower(optional($att->attendanceStatus)->name ?? '');
            if (str_contains($st, 'present')) {
                $presentCount++;
            } elseif (str_contains($st, 'half')) {
                $halfDayCount++;
            } elseif (str_contains($st, 'absent') || str_contains($st, 'leave')) {
                $absentCount++;
            }
        }

        $empType = strtolower(optional($employee->employeeType)->name ?? '');
        $isDailyWager = str_contains($empType, 'daily') || str_contains($empType, 'contract') || str_contains(strtolower(optional($employee->designation)->name ?? ''), 'labor') || str_contains(strtolower(optional($employee->designation)->name ?? ''), 'worker');
        
        $rate = (float) ($employee->salary ?? 0);
        $daysInMonth = 30; // Standard payroll base: 30 days per month

        if ($isDailyWager) {
            // Daily wage: present days × per-day rate
            $earnedWages = ($presentCount * $rate) + ($halfDayCount * ($rate / 2));
        } else {
            // Monthly fixed salary: (Salary ÷ 30) × effective days worked
            $effectiveDays = $presentCount + ($halfDayCount * 0.5);
            $earnedWages = round(($rate / $daysInMonth) * $effectiveDays, 2);
        }

        $totalPaid = \App\Models\Bill::where('employee_id', $employee->id)
            ->whereBetween('bill_date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
            ->sum('amount');

        $netBalance = $earnedWages - $totalPaid;
    @endphp

    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom rounded-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                <i class="ti ti-calculator text-primary fs-3"></i> Monthly Attendance & Payroll Summary ({{ $monthName }})
            </h5>
            <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                <a href="{{ route('attendance-records.sheet') }}" class="btn btn-sm btn-outline-primary py-2 px-3 font-12 fw-semibold rounded-0 text-nowrap text-capitalize" style="width: auto !important; display: inline-flex !important; align-items: center;">
                    <i class="ti ti-calendar-plus me-1"></i> Attendance Sheet
                </a>
                <button type="button" class="btn btn-sm btn-success py-2 px-3 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important; display: inline-flex !important; align-items: center;" data-bs-toggle="modal" data-bs-target="#payoutModal">
                    <i class="ti ti-cash me-1"></i> Record Payout
                </button>
            </div>
        </div>
        <div class="card-body p-4 rounded-0">
            <div class="row g-3 text-center">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-light rounded-0 border h-100">
                        <small class="text-muted text-uppercase fw-bold font-12">Present Days</small>
                        <h2 class="fw-bold text-success mb-1 mt-2">{{ $presentCount }} <span class="fs-6 text-muted">Days</span></h2>
                        <small class="text-warning fw-semibold font-12">Half Days: {{ $halfDayCount }} | Absents: {{ $absentCount }}</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-light rounded-0 border h-100">
                        <small class="text-muted text-uppercase fw-bold font-12">Salary / Wage Rate</small>
                        <h2 class="fw-bold text-primary mb-1 mt-2">₹{{ number_format($rate, 0) }}</h2>
                        <small class="text-muted fw-semibold font-12">{{ $isDailyWager ? 'Per Day Rate' : 'Base Monthly Salary' }}</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-light rounded-0 border h-100">
                        <small class="text-muted text-uppercase fw-bold font-12">Earned Wage (This Month)</small>
                        <h2 class="fw-bold text-dark mb-1 mt-2">₹{{ number_format($earnedWages, 2) }}</h2>
                        <small class="text-muted fw-semibold font-12">{{ $isDailyWager ? 'Calculated from attendance' : 'Base salary minus absents' }}</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="p-3 bg-light rounded-0 border h-100">
                        <small class="text-muted text-uppercase fw-bold font-12">Paid & Settlement Status</small>
                        @if($netBalance > 0)
                            <h2 class="fw-bold text-danger mb-1 mt-2">₹{{ number_format($netBalance, 2) }}</h2>
                            <small class="text-danger fw-semibold font-12">Balance Due (To Pay)</small>
                        @elseif($netBalance < 0)
                            <h2 class="fw-bold text-success mb-1 mt-2">₹{{ number_format(abs($netBalance), 2) }}</h2>
                            <small class="text-success fw-semibold font-12"><i class="ti ti-circle-check me-1"></i>Advance Paid / Overpaid</small>
                        @else
                            <h2 class="fw-bold text-success mb-1 mt-2">₹0.00</h2>
                            <small class="text-success fw-semibold font-12"><i class="ti ti-circle-check me-1"></i>Fully Settled</small>
                        @endif
                        <div class="text-muted font-12 mt-1">Total Paid: ₹{{ number_format($totalPaid, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Records Table -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom rounded-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                <i class="ti ti-calendar me-1 text-primary fs-4"></i> Attendance Log History
            </h5>
            <div class="ms-auto" style="width: auto !important;">
                <a href="{{ route('attendance-records.sheet') }}" class="btn btn-sm btn-primary px-3 py-1.5 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important; display: inline-block !important;">+ 1-Click Attendance Sheet</a>
            </div>
        </div>
        <div class="card-body p-0 rounded-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-nowrap">Date</th>
                            <th class="text-nowrap">Project / Site</th>
                            <th class="text-nowrap">Attendance Type</th>
                            <th class="pe-4 text-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceRecords as $attendanceRecord)
                        <tr>
                            <td class="ps-4 fw-semibold text-nowrap">{{ $attendanceRecord->date ? \Carbon\Carbon::parse($attendanceRecord->date)->format('D, d M Y') : 'N/A' }}</td>
                            <td class="text-nowrap">{{ $attendanceRecord->project_id ? ('Project #' . $attendanceRecord->project_id) : 'General Site' }}</td>
                            <td class="text-nowrap">{{ optional($attendanceRecord->attendanceType)->name ?? 'Regular' }}</td>
                            <td class="pe-4 text-nowrap">
                                <span class="badge {{ str_contains(strtolower(optional($attendanceRecord->attendanceStatus)->name ?? ''), 'present') ? 'bg-success' : 'bg-warning' }} rounded-0 px-3 py-1">
                                    {{ optional($attendanceRecord->attendanceStatus)->name ?? 'Present' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No attendance records logged for this employee.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendanceRecords->hasPages())
                <div class="p-3 border-top">
                    {{ $attendanceRecords->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Bills / Payouts Table -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header bg-white py-3 border-bottom rounded-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2 text-nowrap">
                <i class="ti ti-receipt me-1 text-primary fs-4"></i> Payout & Expense Bills History
            </h5>
            <div class="ms-auto" style="width: auto !important;">
                <button type="button" class="btn btn-sm btn-success px-3 py-1.5 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important; display: inline-block !important;" data-bs-toggle="modal" data-bs-target="#payoutModal">
                    + Record Payout
                </button>
            </div>
        </div>
        <div class="card-body p-0 rounded-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-nowrap">Reference #</th>
                            <th class="text-nowrap">Bill Date</th>
                            <th class="text-nowrap">Type</th>
                            <th class="text-nowrap">Amount</th>
                            <th class="pe-4 text-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $bill)
                        <tr>
                            <td class="ps-4 fw-bold text-primary text-nowrap">{{ $bill->reference }}</td>
                            <td class="text-nowrap">{{ \Carbon\Carbon::parse($bill->bill_date)->format('D, d M Y') }}</td>
                            <td class="text-nowrap">{{ $bill->billType ? $bill->billType->name : 'Salary / Advance' }}</td>
                            <td class="fw-bold text-dark text-nowrap">₹{{ number_format($bill->amount, 2) }}</td>
                            <td class="pe-4 text-nowrap">
                                <span class="badge bg-success rounded-0 px-3 py-1">
                                    {{ $bill->billStatus ? $bill->billStatus->name : 'Paid' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No payout / bill records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bills->hasPages())
                <div class="p-3 border-top">
                    {{ $bills->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Password Visibility Script -->
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('empPasswordInput');
        const toggleIcon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('ti-eye');
            toggleIcon.classList.add('ti-eye-off');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('ti-eye-off');
            toggleIcon.classList.add('ti-eye');
        }
    }
</script>

<!-- Modal for Bank Account -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-primary text-white rounded-0">
                <h5 class="modal-title fw-bold" id="bankModalLabel"><i class="ti ti-building-bank me-2"></i>Add Bank Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                @include('crm.crud.employees.create_bank_account_form')
            </div>
        </div>
    </div>
</div>

<!-- Instant Inline Record Employee Payout Modal -->
<div class="modal fade" id="payoutModal" tabindex="-1" aria-labelledby="payoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-0">
            <div class="modal-header bg-success text-white rounded-0">
                <h5 class="modal-title fw-bold" id="payoutModalLabel">
                    <i class="ti ti-cash me-2"></i>Record Employee Payout - {{ $employee->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 rounded-0">
                <form action="{{ route('bills.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <input type="hidden" name="reference" value="PAY-{{ $employee->id }}-{{ time() }}">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label font-12 fw-semibold">Payout Amount (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text rounded-0">₹</span>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control rounded-0 fw-bold fs-5 text-success @error('amount') is-invalid @enderror" value="{{ max(0, round($netBalance, 2)) }}" required>
                            </div>
                            <small class="text-muted font-12">Current Balance Due: ₹{{ number_format(max(0, $netBalance), 2) }}</small>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="bill_type_id" class="form-label font-12 fw-semibold">Payout Type <span class="text-danger">*</span></label>
                            <select name="bill_type_id" id="bill_type_id" class="form-select rounded-0 @error('bill_type_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Payout Type</option>
                                @foreach($billTypes as $bt)
                                    <option value="{{ $bt->id }}" {{ str_contains(strtolower($bt->name), 'salary') || str_contains(strtolower($bt->name), 'payout') ? 'selected' : '' }}>
                                        {{ $bt->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bill_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="payment_method_id" class="form-label font-12 fw-semibold">Payment Mode</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-select rounded-0 @error('payment_method_id') is-invalid @enderror">
                                <option value="">Select Mode (Cash / Bank / UPI)</option>
                                @foreach($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="bill_status_id" class="form-label font-12 fw-semibold">Payment Status <span class="text-danger">*</span></label>
                            <select name="bill_status_id" id="bill_status_id" class="form-select rounded-0 @error('bill_status_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Payment Status</option>
                                @foreach($billStatuses as $bs)
                                    <option value="{{ $bs->id }}" {{ str_contains(strtolower($bs->name), 'paid') ? 'selected' : '' }}>
                                        {{ $bs->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bill_status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="bill_date" class="form-label font-12 fw-semibold">Payout Date <span class="text-danger">*</span></label>
                            <input type="date" name="bill_date" id="bill_date" class="form-control rounded-0 @error('bill_date') is-invalid @enderror" value="{{ now()->toDateString() }}" required>
                            @error('bill_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="due_date" class="form-label font-12 fw-semibold">Settlement / Due Date <span class="text-danger">*</span></label>
                            <input type="date" name="due_date" id="due_date" class="form-control rounded-0 @error('due_date') is-invalid @enderror" value="{{ now()->toDateString() }}" required>
                            @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="notes" class="form-label font-12 fw-semibold">Payout Remarks / Notes</label>
                            <input type="text" name="notes" id="notes" class="form-control rounded-0 @error('notes') is-invalid @enderror" placeholder="e.g. Salary payout for {{ $employee->name }} - {{ $monthName }}" value="Salary / Wage payout for {{ $employee->name }} ({{ $monthName }})">
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 pt-3 border-top mt-3">
                            <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important;" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success btn-sm px-4 py-1.5 font-12 fw-semibold rounded-0 text-nowrap" style="width: auto !important;"><i class="ti ti-check me-1"></i> Confirm & Record Payout</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
