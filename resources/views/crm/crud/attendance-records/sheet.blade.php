@extends('layouts.app')
@section('title', 'Attendance Management')
@section('content')

@php
    use Carbon\Carbon;
    $formattedDate = Carbon::parse($date)->format('l, d F Y');
@endphp

<div class="container-fluid p-3 p-md-4">
    <!-- Master Header Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-calendar-check fs-2"></i>
                <div>
                    <h5 class="fw-bold text-white mb-0">Attendance Management</h5>
                    <small class="text-white-50 font-12">{{ $formattedDate }}</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Date Selector Form -->
                <form action="{{ route('attendance-records.sheet') }}" method="GET" class="d-flex align-items-center gap-2">
                    @if($search)<input type="hidden" name="search" value="{{ $search }}">@endif
                    @if($employeeId)<input type="hidden" name="employee_id" value="{{ $employeeId }}">@endif
                    @if($statusId)<input type="hidden" name="attendance_status_id" value="{{ $statusId }}">@endif
                    
                    <input type="date" name="date" class="form-control form-control-sm rounded-0 font-13 fw-bold bg-white text-dark py-1.5" value="{{ $date }}" onchange="this.form.submit()" style="width: auto !important;">
                </form>

                <!-- Bulk Present Action Button -->
                <form action="{{ route('attendance-records.bulk-present') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    <button type="submit" class="btn btn-success btn-sm px-3 py-1.5 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" onclick="return confirm('Mark all unmarked employees as Present for {{ $date }}?')">
                        <i class="ti ti-check-all me-1.5"></i> Mark All Present
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- 5-Card KPI Summary Metric Row -->
            <div class="row g-3 text-center mb-4">
                <div class="col-6 col-md-2.4 col-lg border-end">
                    <small class="text-muted text-uppercase fw-bold font-11">Total Staff</small>
                    <h3 class="fw-bold text-dark mb-0 mt-1" id="kpiTotal">{{ $stats['total'] }}</h3>
                </div>
                <div class="col-6 col-md-2.4 col-lg border-end">
                    <small class="text-muted text-uppercase fw-bold font-11 text-success"><i class="ti ti-circle-check me-1"></i>Present</small>
                    <h3 class="fw-bold text-success mb-0 mt-1" id="kpiPresent">{{ $stats['present'] }}</h3>
                </div>
                <div class="col-6 col-md-2.4 col-lg border-end">
                    <small class="text-muted text-uppercase fw-bold font-11 text-warning"><i class="ti ti-clock me-1"></i>Half Day</small>
                    <h3 class="fw-bold text-warning mb-0 mt-1" id="kpiHalf">{{ $stats['half_day'] }}</h3>
                </div>
                <div class="col-6 col-md-2.4 col-lg border-end">
                    <small class="text-muted text-uppercase fw-bold font-11 text-danger"><i class="ti ti-circle-x me-1"></i>Absent</small>
                    <h3 class="fw-bold text-danger mb-0 mt-1" id="kpiAbsent">{{ $stats['absent'] }}</h3>
                </div>
                <div class="col-6 col-md-2.4 col-lg">
                    <small class="text-muted text-uppercase fw-bold font-11 text-secondary"><i class="ti ti-minus me-1"></i>Unmarked</small>
                    <h3 class="fw-bold text-secondary mb-0 mt-1" id="kpiUnmarked">{{ $stats['unmarked'] }}</h3>
                </div>
            </div>

            <!-- Single Merged Filter Bar -->
            <form action="{{ route('attendance-records.sheet') }}" method="GET" class="card bg-light border-0 rounded-0 p-3 mb-4">
                <input type="hidden" name="date" value="{{ $date }}">
                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-4">
                        <label for="search" class="font-12 fw-bold text-muted mb-1 d-block">Search Employee</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text rounded-0 bg-white py-1.5"><i class="ti ti-search"></i></span>
                            <input type="text" id="search" name="search" class="form-control form-control-sm rounded-0 font-13 py-1.5" placeholder="Search by name, ID, phone..." value="{{ $search }}">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="employee_id" class="font-12 fw-bold text-muted mb-1 d-block">Filter Employee</label>
                        <select name="employee_id" id="employee_id" class="form-select form-select-sm rounded-0 font-13 py-1.5">
                            <option value="">All Employees</option>
                            @foreach($employees as $e)
                                <option value="{{ $e->id }}" {{ $employeeId == $e->id ? 'selected' : '' }}>
                                    {{ $e->name }} ({{ $e->emp_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="attendance_status_id" class="font-12 fw-bold text-muted mb-1 d-block">Filter Status</label>
                        <select name="attendance_status_id" id="attendance_status_id" class="form-select form-select-sm rounded-0 font-13 py-1.5">
                            <option value="">All Statuses</option>
                            @foreach($attendanceStatuses as $st)
                                <option value="{{ $st->id }}" {{ $statusId == $st->id ? 'selected' : '' }}>
                                    {{ $st->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-2 d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 px-3 py-1.5 font-13 text-nowrap w-100 d-inline-flex align-items-center justify-content-center"><i class="ti ti-filter me-1"></i> Filter</button>
                        <a href="{{ route('attendance-records.sheet', ['date' => $date]) }}" class="btn btn-secondary btn-sm rounded-0 px-3 py-1.5 font-13 text-nowrap d-inline-flex align-items-center justify-content-center" title="Reset Filters"><i class="ti ti-refresh"></i></a>
                    </div>
                </div>
            </form>

            <!-- Master Attendance Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 text-nowrap" style="min-width: 250px;">Employee</th>
                            <th class="text-nowrap" style="min-width: 160px;">Designation & Department</th>
                            <th class="text-nowrap" style="min-width: 130px;">Current Status</th>
                            <th class="text-nowrap" style="min-width: 180px;">Project / Site (Optional)</th>
                            <th class="pe-3 text-end text-nowrap" style="min-width: 440px; width: 440px;">1-Click Attendance Toggle Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                            @php
                                $record = $existingRecords->get($emp->id);
                                $statusObj = ($record && $record->attendanceStatus) ? $record->attendanceStatus : null;
                                $statusName = strtolower($statusObj ? $statusObj->name : 'unmarked');
                                
                                $badgeClass = 'bg-secondary';
                                if (str_contains($statusName, 'present')) {
                                    $badgeClass = 'bg-success';
                                } elseif (str_contains($statusName, 'half')) {
                                    $badgeClass = 'bg-warning';
                                } elseif (str_contains($statusName, 'absent') || str_contains($statusName, 'leave')) {
                                    $badgeClass = 'bg-danger';
                                }
                            @endphp
                            <tr id="empRow-{{ $emp->id }}">
                                <td class="ps-3 text-nowrap">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($emp->photograph)
                                            <img src="{{ (\Illuminate\Support\Str::startsWith($emp->photograph, 'http') ? $emp->photograph : asset('storage/' . $emp->photograph)) }}" alt="{{ $emp->name }}" class="rounded-circle border flex-shrink-0" style="width: 42px; height: 42px; min-width: 42px; min-height: 42px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle text-primary border flex-shrink-0 d-flex align-items-center justify-content-center fw-bold font-13" style="width: 42px; height: 42px; min-width: 42px; min-height: 42px;">
                                                {{ strtoupper(substr($emp->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('employees.show', $emp->id) }}" class="fw-bold text-dark font-14 text-decoration-none d-block hover-primary">{{ $emp->name }}</a>
                                            <span class="badge bg-light text-dark border rounded-0 font-11 px-2 py-0.5">ID: {{ $emp->emp_id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    <small class="d-block text-dark fw-semibold font-12">{{ optional($emp->designation)->name ?? 'Staff' }}</small>
                                    <small class="text-muted font-11">{{ optional($emp->department)->name ?? 'General' }}</small>
                                </td>

                                <td class="text-nowrap">
                                    <span id="badge-{{ $emp->id }}" class="badge {{ $badgeClass }} rounded-0 px-3 py-2 font-12 text-uppercase">
                                        {{ $statusObj ? $statusObj->name : 'Unmarked' }}
                                    </span>
                                </td>

                                <td class="text-nowrap">
                                    <select id="project-{{ $emp->id }}" class="form-select form-select-sm rounded-0 font-12 py-1.5" style="max-width: 180px;">
                                        <option value="">Main Office / Internal</option>
                                        @foreach($projects as $p)
                                            <option value="{{ $p->id }}" {{ ($record && $record->project_id == $p->id) ? 'selected' : '' }}>
                                                {{ $p->name ?? ('Project #' . $p->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="pe-3 text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center gap-2 justify-content-end">
                                        <button type="button" 
                                                class="btn btn-outline-success btn-sm font-12 fw-bold px-3 py-1.5 rounded-0 text-nowrap d-inline-flex align-items-center {{ str_contains($statusName, 'present') ? 'active bg-success text-white' : '' }}" 
                                                id="btn-present-{{ $emp->id }}"
                                                onclick="toggleAttendance({{ $emp->id }}, 'present')">
                                            <i class="ti ti-check me-1"></i> Present
                                        </button>

                                        <button type="button" 
                                                class="btn btn-outline-warning btn-sm font-12 fw-bold px-3 py-1.5 rounded-0 text-nowrap d-inline-flex align-items-center {{ str_contains($statusName, 'half') ? 'active bg-warning text-dark' : '' }}" 
                                                id="btn-half-{{ $emp->id }}"
                                                onclick="toggleAttendance({{ $emp->id }}, 'half_day')">
                                            <i class="ti ti-clock me-1"></i> Half Day
                                        </button>

                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm font-12 fw-bold px-3 py-1.5 rounded-0 text-nowrap d-inline-flex align-items-center {{ str_contains($statusName, 'absent') ? 'active bg-danger text-white' : '' }}" 
                                                id="btn-absent-{{ $emp->id }}"
                                                onclick="toggleAttendance({{ $emp->id }}, 'absent')">
                                            <i class="ti ti-x me-1"></i> Absent
                                        </button>

                                        <button type="button" 
                                                class="btn btn-outline-secondary btn-sm font-12 px-3 py-1.5 rounded-0 text-nowrap d-inline-flex align-items-center" 
                                                id="btn-unmark-{{ $emp->id }}"
                                                title="Unmark / Clear Attendance"
                                                onclick="toggleAttendance({{ $emp->id }}, 'unmark')">
                                            <i class="ti ti-eraser me-1"></i> Clear
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No employees found matching filter criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- AJAX Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
    <div id="attendanceToast" class="toast align-items-center text-white bg-dark border-0 rounded-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body font-13 fw-semibold" id="toastMessage">
                Attendance updated!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    function toggleAttendance(empId, statusKey) {
        const dateVal = "{{ $date }}";
        const projSelect = document.getElementById('project-' + empId);
        const projId = projSelect ? projSelect.value : null;

        fetch("{{ route('attendance-records.toggle') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                employee_id: empId,
                date: dateVal,
                status: statusKey,
                project_id: projId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update badge
                const badge = document.getElementById('badge-' + empId);
                if (badge) {
                    badge.className = 'badge ' + data.badge_class + ' rounded-0 px-3 py-2 font-12 text-uppercase';
                    badge.innerText = data.status_name || 'UNMARKED';
                }

                // Update active state on buttons
                const btnPresent = document.getElementById('btn-present-' + empId);
                const btnHalf = document.getElementById('btn-half-' + empId);
                const btnAbsent = document.getElementById('btn-absent-' + empId);

                if (btnPresent) btnPresent.classList.remove('active', 'bg-success', 'text-white');
                if (btnHalf) btnHalf.classList.remove('active', 'bg-warning', 'text-dark');
                if (btnAbsent) btnAbsent.classList.remove('active', 'bg-danger', 'text-white');

                if (data.status === 'present' && btnPresent) {
                    btnPresent.classList.add('active', 'bg-success', 'text-white');
                } else if (data.status === 'half day' && btnHalf) {
                    btnHalf.classList.add('active', 'bg-warning', 'text-dark');
                } else if (data.status === 'absent' && btnAbsent) {
                    btnAbsent.classList.add('active', 'bg-danger', 'text-white');
                }

                // Trigger toast notification
                const toastMsg = document.getElementById('toastMessage');
                if (toastMsg) {
                    toastMsg.innerText = data.message;
                    const toastEl = document.getElementById('attendanceToast');
                    if (toastEl) {
                        const bsToast = new bootstrap.Toast(toastEl, { delay: 2000 });
                        bsToast.show();
                    }
                }
            }
        })
        .catch(err => {
            console.error(err);
        });
    }
</script>

@endsection
