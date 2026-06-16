@extends('layouts.app')
@section('title', 'Employee Attendance')

@section('content')
<div class="p-3 bg-light">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Employee Attendance</h4>
            </div>
        </div>
    </div>

    {{-- Analytics --}}
    <div class="p-3 row bg-white">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart1->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart1->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart2->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart2->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart3->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart3->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('attendance-records.create') }}" class="btn btn-square btn-primary">Mark Attendance</a>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('attendance-records.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by Employee, Project, Status" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-square btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <form action="{{ route('attendance-records.index') }}" method="GET">
                <div class="input-group">
                    <input type="date" class="form-control" name="date_filter" value="{{ request('date_filter') }}">
                    <button class="btn btn-sm btn-square btn-primary" type="submit">Filter by Date</button>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <form action="{{ route('attendance-records.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-control" name="employee_filter">
                        <option value="">Select Employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_filter') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-square btn-primary" type="submit">Filter by Employee</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee</th>
                                    <th>Project ID</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceRecords as $attendanceRecord)
                                <tr>
                                    <td>{{ $attendanceRecord->employee->emp_id }}</td>
                                    <td>{{ $attendanceRecord->employee->name }}</td>
                                    <td>{{ $attendanceRecord->project_id }} - {{ $attendanceRecord->project->customer->lead->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendanceRecord->date)->format('D d, M Y') }}</td>
                                    <td>{{ $attendanceRecord->attendanceType->name }}</td>
                                    <td>{{ $attendanceRecord->attendanceStatus->name }}</td>
                                    <td>
                                        <a href="{{ route('attendance-records.edit', $attendanceRecord->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $attendanceRecord->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-3">
                        {{ $attendanceRecords->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($attendanceRecords as $attendanceRecord)
    <div class="modal fade" id="deleteModal{{ $attendanceRecord->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this attendance record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('attendance-records.destroy', $attendanceRecord->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
@endsection
