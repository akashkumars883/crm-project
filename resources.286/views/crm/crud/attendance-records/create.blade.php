@extends('layouts.app')
@section('title', 'Add Employee Attendance')
@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="page-title text-center">Add Employee Attendance</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('attendance-records.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Choose Attendance Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}">
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employees</label>
                            <select class="form-control select2 @error('employee_id') is-invalid @enderror" name="employee_id[]" multiple>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="project_id" class="form-label">Projects (Optional)</label>
                            <select class="form-control select2 @error('project_id') is-invalid @enderror" name="project_id[]" multiple>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->id }} - {{ $project->customer->lead->name }}</option>
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
                                    <option value="{{ $attendanceType->id }}">{{ $attendanceType->name }}</option>
                                @endforeach
                            </select>
                            @error('attendance_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="attendance_status_id" class="form-label">Attendance Status</label>
                            <select class="form-control @error('attendance_status_id') is-invalid @enderror" name="attendance_status_id">
                                <option value="">Select Attendance Status</option>
                                @foreach ($attendanceStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('attendance_status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Save Attendance</button>
                            <a href="{{ route('attendance-records.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
