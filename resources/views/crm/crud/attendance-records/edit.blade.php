@extends('layouts.app')
@section('title', 'Edit Employee Attendance')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('attendance-records.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Edit Attendance Record #{{ $attendanceRecord->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('attendance-records.update', $attendanceRecord->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="date" class="form-label fw-semibold">Attendance Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $attendanceRecord->date }}" required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="employee_id" class="form-label fw-semibold">Employee <span class="text-danger">*</span></label>
                                <select class="form-select select2 @error('employee_id') is-invalid @enderror" name="employee_id" required>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ $attendanceRecord->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="attendance_type_id" class="form-label fw-semibold">Attendance Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('attendance_type_id') is-invalid @enderror" name="attendance_type_id" required>
                                    <option value="">Select Attendance Type</option>
                                    @foreach ($attendanceTypes as $attendanceType)
                                        <option value="{{ $attendanceType->id }}" {{ $attendanceRecord->attendance_type_id == $attendanceType->id ? 'selected' : '' }}>
                                            {{ $attendanceType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('attendance_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="attendance_status_id" class="form-label fw-semibold">Attendance Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('attendance_status_id') is-invalid @enderror" name="attendance_status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach ($attendanceStatuses as $status)
                                        <option value="{{ $status->id }}" {{ $attendanceRecord->attendance_status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('attendance_status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="project_id" class="form-label fw-semibold">Project (Optional)</label>
                                <select class="form-select select2 @error('project_id') is-invalid @enderror" name="project_id">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" {{ $attendanceRecord->project_id == $project->id ? 'selected' : '' }}>
                                            {{ $project->id }} - {{ $project->customer->lead->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('attendance-records.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Update Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
