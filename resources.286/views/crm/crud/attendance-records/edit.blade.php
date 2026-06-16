@extends('layouts.app')
@section('title', 'Edit Employee Attendance')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Employee Attendance</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance-records.update', $attendanceRecord->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="date" class="form-label">Choose Attendance Date</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $attendanceRecord->date }}">
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-control select2 @error('employee_id') is-invalid @enderror" name="employee_id">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $attendanceRecord->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project (Optional)</label>
                        <select class="form-control select2 @error('project_id') is-invalid @enderror" name="project_id">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ $attendanceRecord->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->id }} - {{ $project->customer->lead->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-control select2 @error('employee_id') is-invalid @enderror" name="employee_id">
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
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project</label>
                        <select class="form-control select2 @error('project_id') is-invalid @enderror" name="project_id">
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ $attendanceRecord->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->id }} - {{ $project->customer->lead->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="attendance_type_id" class="form-label">Attendance Type</label>
                        <select class="form-control @error('attendance_type_id') is-invalid @enderror" name="attendance_type_id">
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
                    <div class="mb-3">
                        <label for="attendance_status_id" class="form-label">Attendance Status</label>
                        <select class="form-control @error('attendance_status_id') is-invalid @enderror" name="attendance_status_id">
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
                    <div class="">
                        <button type="submit" class="btn btn-primary">Update Attendance</button>
                        <a href="{{ route('attendance-records.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
