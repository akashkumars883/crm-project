@extends('layouts.app')
@section('title', 'My Attendance')
@section('content')
<div class="p-3 bg-light">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box px-3">
                <h4 class="page-title">My Attendance</h4>
            </div>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceRecords as $attendanceRecord)
                                <tr>
                                    <td>{{ $attendanceRecord->employee->emp_id }}</td>
                                    <td>{{ $attendanceRecord->employee->name }}</td>
                                    <td>{{ $attendanceRecord->project_id }} - {{ $attendanceRecord->project->customer->lead->full_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendanceRecord->date)->format('D d, M Y') }}</td>
                                    <td>{{ $attendanceRecord->attendanceType->name }}</td>
                                    <td>{{ $attendanceRecord->attendanceStatus->name }}</td>
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
</div>
@endsection
