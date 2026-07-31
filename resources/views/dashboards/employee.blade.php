@extends('layouts.app')
@section('title', 'My Workspace')

@section('content')
<div class="p-3 bg-light">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center">
                <h4 class="page-title">Welcome, {{ Auth::user()->name }}</h4>
                <div class="text-muted">{{ date('l, d M Y') }}</div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    @php
        $user = Auth::user();
        $employeeRecord = null;
        if ($user->employeeUser && $user->employeeUser->employee) {
            $employeeRecord = $user->employeeUser->employee;
        } else {
            $employeeRecord = \App\Models\Employee::where('email', $user->email)->orWhere('phone', $user->phone)->first();
        }
    @endphp

    @if($employeeRecord)
    @php
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $monthName = now()->format('F Y');

        $thisMonthAttendance = \App\Models\AttendanceRecord::where('employee_id', $employeeRecord->id)
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

        $empType = strtolower(optional($employeeRecord->employeeType)->name ?? '');
        $isDailyWager = str_contains($empType, 'daily') || str_contains($empType, 'contract') || str_contains(strtolower(optional($employeeRecord->designation)->name ?? ''), 'labor') || str_contains(strtolower(optional($employeeRecord->designation)->name ?? ''), 'worker');
        
        $rate = (float) ($employeeRecord->salary ?? 0);
        if ($isDailyWager) {
            $earnedWages = ($presentCount * $rate) + ($halfDayCount * ($rate / 2));
        } else {
            $daysInMonth = now()->daysInMonth;
            $effectiveDays = $presentCount + ($halfDayCount * 0.5);
            $earnedWages = $daysInMonth > 0 ? round(($rate / $daysInMonth) * $effectiveDays, 2) : 0;
        }

        $totalPaid = \App\Models\Bill::where('employee_id', $employeeRecord->id)
            ->whereBetween('bill_date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
            ->sum('amount');

        $balanceDue = $earnedWages - $totalPaid;
    @endphp

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="ti ti-wallet text-primary me-2 fs-4"></i> My Attendance & Earnings Summary ({{ $monthName }})
                    </h5>
                    <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                        Rate: <strong>₹{{ number_format($rate, 0) }} {{ $isDailyWager ? '/ day' : '/ month' }}</strong>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded border">
                                <small class="text-muted text-uppercase fw-bold">Present Days</small>
                                <h3 class="fw-bold text-success mb-1 mt-2">{{ $presentCount }} <span class="fs-6 text-muted">Days</span></h3>
                                <small class="text-warning fw-semibold">Half Days: {{ $halfDayCount }}</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded border">
                                <small class="text-muted text-uppercase fw-bold">Wage Rate</small>
                                <h3 class="fw-bold text-primary mb-1 mt-2">₹{{ number_format($rate, 0) }}</h3>
                                <small class="text-muted fw-semibold">{{ $isDailyWager ? 'Per Day Rate' : 'Per Month Salary' }}</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded border">
                                <small class="text-muted text-uppercase fw-bold">Earned Wage</small>
                                <h3 class="fw-bold text-dark mb-1 mt-2">₹{{ number_format($earnedWages, 2) }}</h3>
                                <small class="text-muted fw-semibold">Auto-calculated</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded border">
                                <small class="text-muted text-uppercase fw-bold">Paid & Balance Due</small>
                                <h3 class="fw-bold {{ $balanceDue > 0 ? 'text-danger' : 'text-success' }} mb-1 mt-2">₹{{ number_format($balanceDue, 2) }}</h3>
                                <small class="text-muted fw-semibold">Paid: ₹{{ number_format($totalPaid, 2) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Today's Attendance</h5>
                </div>
                <div class="card-body text-center">
                    @if(!$todayRecord)
                        <p class="mb-3 text-muted">You haven't checked in yet. Please mark your attendance at the site.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkInModal">
                            <i class="fas fa-camera me-1"></i> Check-In Now
                        </button>
                    @elseif(!$todayRecord->checkout_time)
                        <p class="mb-3">
                            <span class="text-muted">Checked in at:</span> <strong>{{ $todayRecord->created_at->format('h:i A') }}</strong><br>
                            <span class="text-muted">Site:</span> <strong>{{ $todayRecord->project ? $todayRecord->project->customer->lead->name : 'N/A' }}</strong>
                        </p>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#checkOutModal">
                            <i class="fas fa-sign-out-alt me-1"></i> Check-Out Now
                        </button>
                    @else
                        <div class="text-success mb-2">
                            <i class="fas fa-check-circle fa-3x"></i>
                        </div>
                        <h5 class="mb-1 text-success">Day Completed!</h5>
                        <p class="text-muted mb-0">You checked out successfully at {{ \Carbon\Carbon::parse($todayRecord->checkout_time)->format('h:i A') }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h5 class="page-title">My Assigned Sites</h5>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($assignedProjects as $proj)
            <div class="col-12 col-md-4 mb-3">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">{{ $proj->customer->lead->name }}</h6>
                        <p class="mb-1 text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $proj->location_name ?? 'Location not provided' }}</p>
                        <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-1"></i> Start: {{ \Carbon\Carbon::parse($proj->start_date)->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info border-0">
                    No active sites assigned right now.
                </div>
            </div>
        @endforelse
    </div>

</div>


<!-- Check-In Modal -->
<div class="modal fade" id="checkInModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Check In to Site</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employee.check-in') }}" method="POST" enctype="multipart/form-data" id="checkInForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Select Project/Site</label>
                        <select class="form-select" name="project_id" required>
                            <option value="">-- Select Site --</option>
                            @foreach($assignedProjects as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->customer->lead->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Live Selfie Verification</label>
                        <input type="file" name="photo" accept="image/*" capture="user" class="form-control" required>
                        <small class="text-muted">Take a photo of yourself at the site.</small>
                    </div>
                    
                    <input type="hidden" name="latitude" id="latInput">
                    <input type="hidden" name="longitude" id="lngInput">
                    <div id="geoStatus" class="text-warning mb-2"><i class="fas fa-spinner fa-spin"></i> Fetching your location...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="checkInBtn" disabled>Mark Attendance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latInput').value = position.coords.latitude;
            document.getElementById('lngInput').value = position.coords.longitude;
            document.getElementById('geoStatus').innerHTML = '<i class="fas fa-check-circle text-success"></i> Location captured securely.';
            document.getElementById('geoStatus').className = 'text-success mb-2';
            document.getElementById('checkInBtn').disabled = false;
        }, function(error) {
            document.getElementById('geoStatus').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i> Please enable location services to check in.';
            document.getElementById('geoStatus').className = 'text-danger mb-2';
        });
    } else {
        document.getElementById('geoStatus').innerHTML = 'Geolocation is not supported by this browser.';
    }
});
</script>

<!-- Check-Out Modal -->
<div class="modal fade" id="checkOutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Check Out (Submit DWR)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employee.check-out') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Daily Work Report (DWR)</label>
                        <textarea class="form-control" name="daily_report" rows="3" placeholder="What did you complete today?" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit & Check Out</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
