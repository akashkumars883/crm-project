@extends('layouts.app')
@section('title', 'My Attendance History')

@section('content')
<div class="p-3 bg-light min-vh-100">

    {{-- Page Header --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">
                        <i class="ti ti-calendar-stats text-primary me-2"></i> My Attendance History
                    </h4>
                    <small class="text-muted">View your monthly attendance records and earnings</small>
                </div>
                {{-- Month Selector --}}
                <form method="GET" action="{{ route('myAttendance') }}" class="d-flex align-items-center gap-2">
                    <label class="fw-semibold text-muted font-13 mb-0 text-nowrap">Select Month:</label>
                    <input type="month"
                           name="month"
                           id="monthPicker"
                           class="form-control form-control-sm rounded-0 fw-semibold"
                           style="width: 170px;"
                           value="{{ $selectedMonth }}"
                           max="{{ now()->format('Y-m') }}"
                           onchange="this.form.submit()">
                </form>
            </div>
        </div>
    </div>

    {{-- Monthly Summary Cards --}}
    <div class="row g-3 mb-4">
        {{-- Present --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-0 h-100">
                <div class="card-body text-center py-3">
                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" style="width:48px;height:48px;">
                            <i class="ti ti-circle-check text-success fs-3"></i>
                        </span>
                    </div>
                    <h2 class="fw-bold text-success mb-0">{{ $presentCount }}</h2>
                    <small class="text-muted text-uppercase fw-bold font-11">Present Days</small>
                </div>
            </div>
        </div>
        {{-- Half Day --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-0 h-100">
                <div class="card-body text-center py-3">
                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10" style="width:48px;height:48px;">
                            <i class="ti ti-clock-half-2 text-warning fs-3"></i>
                        </span>
                    </div>
                    <h2 class="fw-bold text-warning mb-0">{{ $halfDayCount }}</h2>
                    <small class="text-muted text-uppercase fw-bold font-11">Half Days</small>
                </div>
            </div>
        </div>
        {{-- Absent --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-0 h-100">
                <div class="card-body text-center py-3">
                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" style="width:48px;height:48px;">
                            <i class="ti ti-circle-x text-danger fs-3"></i>
                        </span>
                    </div>
                    <h2 class="fw-bold text-danger mb-0">{{ $absentCount }}</h2>
                    <small class="text-muted text-uppercase fw-bold font-11">Absent / Leave</small>
                </div>
            </div>
        </div>
        {{-- Earned Wage --}}
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-0 h-100">
                <div class="card-body text-center py-3">
                    <div class="mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10" style="width:48px;height:48px;">
                            <i class="ti ti-cash text-primary fs-3"></i>
                        </span>
                    </div>
                    <h2 class="fw-bold text-dark mb-0">₹{{ number_format($earnedWages, 0) }}</h2>
                    <small class="text-muted text-uppercase fw-bold font-11">Earned Wage</small>
                    @if($netBalance > 0)
                        <div class="text-danger font-11 mt-1 fw-semibold">Balance Due: ₹{{ number_format($netBalance, 2) }}</div>
                    @elseif($netBalance < 0)
                        <div class="text-success font-11 mt-1 fw-semibold"><i class="ti ti-check me-1"></i>Settled</div>
                    @else
                        <div class="text-success font-11 mt-1 fw-semibold"><i class="ti ti-check me-1"></i>Fully Settled</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance Detail Table --}}
    <div class="card border-0 shadow-sm rounded-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="ti ti-table text-primary me-2"></i>
                Day-wise Attendance — {{ $monthName }}
            </h5>
            <span class="badge bg-primary-subtle text-primary px-3 py-2 fw-semibold rounded-0">
                {{ $attendanceRecords->count() }} Records
            </span>
        </div>
        <div class="card-body p-0">
            @if($attendanceRecords->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 font-12 text-uppercase text-muted fw-bold py-3">#</th>
                            <th class="font-12 text-uppercase text-muted fw-bold py-3">Date</th>
                            <th class="font-12 text-uppercase text-muted fw-bold py-3">Day</th>
                            <th class="font-12 text-uppercase text-muted fw-bold py-3">Status</th>
                            <th class="font-12 text-uppercase text-muted fw-bold py-3">Type</th>
                            <th class="font-12 text-uppercase text-muted fw-bold py-3">Site / Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceRecords as $i => $att)
                        @php
                            $st = strtolower(optional($att->attendanceStatus)->name ?? '');
                            $statusColor = str_contains($st, 'present') ? 'success'
                                        : (str_contains($st, 'half') ? 'warning'
                                        : (str_contains($st, 'absent') || str_contains($st, 'leave') ? 'danger' : 'secondary'));
                        @endphp
                        <tr>
                            <td class="ps-3 text-muted font-13">{{ $i + 1 }}</td>
                            <td class="fw-semibold font-13">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                            <td class="text-muted font-13">{{ \Carbon\Carbon::parse($att->date)->format('l') }}</td>
                            <td>
                                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} px-3 py-2 fw-semibold rounded-0 font-12">
                                    {{ optional($att->attendanceStatus)->name ?? 'Unmarked' }}
                                </span>
                            </td>
                            <td class="text-muted font-13">{{ optional($att->attendanceType)->name ?? '-' }}</td>
                            <td class="text-muted font-13">
                                @if($att->project_id && $att->project && $att->project->customer)
                                    {{ optional(optional($att->project->customer)->lead)->name ?? 'N/A' }}
                                @else
                                    <span class="text-muted">Main Office / Internal</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="ti ti-calendar-off fs-1 d-block mb-3 opacity-40"></i>
                <h6 class="fw-semibold">No attendance records found</h6>
                <p class="mb-0 font-13">No records marked for <strong>{{ $monthName }}</strong></p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
