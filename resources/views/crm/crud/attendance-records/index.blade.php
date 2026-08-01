@extends('layouts.app')
@section('title', 'Employee Attendance History & Live Reports')
@section('content')

@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Profile Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-history fs-2"></i>
                <div>
                    <h5 class="fw-bold text-white mb-0">Attendance History & Live Reports</h5>
                    <small class="text-white-50 font-12">Search, filter, manage and track previous months attendance logs</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('attendance-records.sheet') }}" class="btn btn-success btn-sm px-3 py-1.5 font-13 fw-semibold rounded-0 text-nowrap">
                    <i class="ti ti-calendar-check me-1"></i> Mark Today's Attendance
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- 4-Card KPI Live Report Metrics -->
            <div class="row g-3 text-center mb-4">
                <div class="col-6 col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold font-11">Total Filtered Logs</small>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total'] }}</h3>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold font-11 text-success"><i class="ti ti-circle-check me-1"></i>Present Logs</small>
                    <h3 class="fw-bold text-success mb-0 mt-1">{{ $stats['present'] }}</h3>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <small class="text-muted text-uppercase fw-bold font-11 text-warning"><i class="ti ti-clock me-1"></i>Half Day Logs</small>
                    <h3 class="fw-bold text-warning mb-0 mt-1">{{ $stats['half_day'] }}</h3>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted text-uppercase fw-bold font-11 text-danger"><i class="ti ti-circle-x me-1"></i>Absent Logs</small>
                    <h3 class="fw-bold text-danger mb-0 mt-1">{{ $stats['absent'] }}</h3>
                </div>
            </div>

            <!-- Multi-Filter Search Bar -->
            <form action="{{ route('attendance-records.index') }}" method="GET" class="card bg-light border-0 rounded-0 p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-3">
                        <label for="search" class="font-12 fw-bold text-muted mb-1">Search Employee / Site</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text rounded-0 bg-white"><i class="ti ti-search"></i></span>
                            <input type="text" id="search" name="search" class="form-control rounded-0 font-13" placeholder="Search name, ID, phone..." value="{{ $search }}">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2">
                        <label for="employee_id" class="font-12 fw-bold text-muted mb-1">Filter Employee</label>
                        <select name="employee_id" id="employee_id" class="form-select form-select-sm rounded-0 font-13">
                            <option value="">All Employees</option>
                            @foreach($employees as $e)
                                <option value="{{ $e->id }}" {{ $employeeId == $e->id ? 'selected' : '' }}>
                                    {{ $e->name }} ({{ $e->emp_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2">
                        <label for="month" class="font-12 fw-bold text-muted mb-1">Filter Month</label>
                        <input type="month" name="month" id="month" class="form-control form-control-sm rounded-0 font-13 fw-semibold" value="{{ $selectedMonth }}">
                    </div>

                    <div class="col-12 col-sm-6 col-md-2">
                        <label for="date" class="font-12 fw-bold text-muted mb-1">Filter Specific Date</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm rounded-0 font-13" value="{{ $selectedDate }}">
                    </div>

                    <div class="col-12 col-sm-6 col-md-2">
                        <label for="attendance_status_id" class="font-12 fw-bold text-muted mb-1">Status</label>
                        <select name="attendance_status_id" id="attendance_status_id" class="form-select form-select-sm rounded-0 font-13">
                            <option value="">All Statuses</option>
                            @foreach($attendanceStatuses as $st)
                                <option value="{{ $st->id }}" {{ $statusId == $st->id ? 'selected' : '' }}>
                                    {{ $st->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-1 d-flex align-items-end gap-1 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 px-3 py-1.5 w-100 font-13 fw-semibold text-nowrap"><i class="ti ti-filter me-1"></i> Filter</button>
                        <a href="{{ route('attendance-records.index') }}" class="btn btn-secondary btn-sm rounded-0 px-2 py-1.5 font-13 text-nowrap" title="Reset Filters"><i class="ti ti-refresh"></i></a>
                    </div>
                </div>
            </form>

            <!-- Main Attendance History Logs Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 text-nowrap">Employee</th>
                            <th class="text-nowrap">Date</th>
                            <th class="text-nowrap">Location / Project Site</th>
                            <th class="text-nowrap">Check In / Out</th>
                            <th class="text-nowrap">GPS & Notes</th>
                            <th class="text-nowrap">Status</th>
                            <th class="pe-3 text-end text-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceRecords as $record)
                            @php
                                $emp = $record->employee;
                                $stName = strtolower(optional($record->attendanceStatus)->name ?? '');
                                $badgeClass = 'bg-secondary';
                                if (str_contains($stName, 'present')) {
                                    $badgeClass = 'bg-success';
                                } elseif (str_contains($stName, 'half')) {
                                    $badgeClass = 'bg-warning';
                                } elseif (str_contains($stName, 'absent') || str_contains($stName, 'leave')) {
                                    $badgeClass = 'bg-danger';
                                }
                            @endphp
                            <tr>
                                <td class="ps-3 text-nowrap">
                                    @if($emp)
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($emp->photograph)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($emp->photograph, 'http') ? $emp->photograph : asset('storage/' . $emp->photograph)) }}" alt="{{ $emp->name }}" class="rounded-circle border" style="width: 38px; height: 38px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary-subtle text-primary border d-flex align-items-center justify-content-center fw-bold font-12" style="width: 38px; height: 38px;">
                                                    {{ strtoupper(substr($emp->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('employees.show', $emp->id) }}" class="fw-bold text-dark font-13 text-decoration-none hover-primary">{{ $emp->name }}</a>
                                                <span class="badge bg-light text-muted border rounded-0 font-11 d-block px-1 py-0" style="width: fit-content;">ID: {{ $emp->emp_id }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted font-12">Employee Deleted</span>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    <span class="fw-semibold text-dark font-13">{{ $record->date ? Carbon::parse($record->date)->format('D, d M Y') : 'N/A' }}</span>
                                </td>

                                <td class="text-nowrap">
                                    @if($record->project)
                                        <span class="badge bg-light text-dark border rounded-0 font-12 fw-semibold">
                                            <i class="ti ti-building me-1 text-primary"></i>{{ $record->project->name ?? ('Project #' . $record->project_id) }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border rounded-0 font-12 fw-normal">
                                            <i class="ti ti-building-community me-1"></i>Main Office / Internal
                                        </span>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    <small class="d-block font-12 text-muted"><i class="ti ti-login text-success me-1"></i>{{ Carbon::parse($record->created_at)->format('h:i A') }}</small>
                                    @if($record->checkout_time)
                                        <small class="d-block font-12 text-muted"><i class="ti ti-logout text-danger me-1"></i>{{ Carbon::parse($record->checkout_time)->format('h:i A') }}</small>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    @if($record->latitude && $record->longitude)
                                        <a href="https://maps.google.com/?q={{ $record->latitude }},{{ $record->longitude }}" target="_blank" class="badge bg-info-subtle text-info border border-info-subtle rounded-0 font-11 text-decoration-none me-1">
                                            <i class="ti ti-map-pin me-1"></i>GPS Map
                                        </a>
                                    @endif
                                    @if($record->photo)
                                        <a href="{{ asset('storage/' . $record->photo) }}" target="_blank" class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-0 font-11 text-decoration-none">
                                            <i class="ti ti-photo me-1"></i>Selfie
                                        </a>
                                    @endif
                                    @if(!$record->latitude && !$record->photo)
                                        <span class="text-muted font-12">Manual Entry</span>
                                    @endif
                                </td>

                                <td class="text-nowrap">
                                    <span class="badge {{ $badgeClass }} rounded-0 px-3 py-1.5 font-12 text-uppercase fw-bold">
                                        {{ optional($record->attendanceStatus)->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="pe-3 text-end text-nowrap">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <a href="{{ route('attendance-records.edit', $record->id) }}" class="btn btn-sm btn-outline-primary rounded-0 py-1 px-2 font-12 text-nowrap" title="Edit Record">
                                            <i class="ti ti-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-0 py-1 px-2 font-12 text-nowrap" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $record->id }}" title="Delete Record">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No attendance logs found matching selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendanceRecords->hasPages())
                <div class="pt-3 border-top">
                    {{ $attendanceRecords->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
@foreach($attendanceRecords as $record)
    <div class="modal fade" id="deleteModal{{ $record->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-0">
                <div class="modal-header bg-danger text-white rounded-0">
                    <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Attendance Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 rounded-0">
                    <p class="mb-1 font-14">Are you sure you want to delete attendance record for <strong>{{ optional($record->employee)->name }}</strong> on <strong>{{ $record->date ? Carbon::parse($record->date)->format('d M Y') : '' }}</strong>?</p>
                    <small class="text-muted font-12">This action will remove this attendance log permanently.</small>
                </div>
                <div class="modal-footer border-top rounded-0">
                    <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('attendance-records.destroy', $record->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap"><i class="ti ti-trash me-1"></i> Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
