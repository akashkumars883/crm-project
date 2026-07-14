@extends('layouts.app')
@section('title', 'Attendance Details')

@section('content')
<div class="row pt-3 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white">Attendance Details</h4>
                <a href="{{ route('attendance-records.index') }}" class="btn btn-sm btn-light">Back</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="border-bottom pb-2">Employee Information</h5>
                        <p><strong>Name:</strong> {{ $attendanceRecord->employee->name }}</p>
                        <p><strong>Emp ID:</strong> {{ $attendanceRecord->employee->emp_id }}</p>
                        <p><strong>Phone:</strong> {{ $attendanceRecord->employee->phone }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h5 class="border-bottom pb-2">Project Information</h5>
                        <p><strong>Project ID:</strong> {{ $attendanceRecord->project_id }}</p>
                        <p><strong>Site / Client:</strong> {{ $attendanceRecord->project->customer->lead->name ?? 'N/A' }}</p>
                        <p><strong>Location:</strong> {{ $attendanceRecord->project->location_name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="border-bottom pb-2">Attendance Summary</h5>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($attendanceRecord->date)->format('D d, M Y') }}</p>
                        <p><strong>Check In:</strong> {{ $attendanceRecord->created_at ? \Carbon\Carbon::parse($attendanceRecord->created_at)->format('h:i A') : 'N/A' }}</p>
                        <p><strong>Check Out:</strong> {{ $attendanceRecord->checkout_time ? \Carbon\Carbon::parse($attendanceRecord->checkout_time)->format('h:i A') : 'Pending / Not Checked Out' }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-info">{{ $attendanceRecord->attendanceStatus ? $attendanceRecord->attendanceStatus->name : 'N/A' }}</span></p>
                        <p><strong>Type:</strong> <span class="badge bg-secondary">{{ $attendanceRecord->attendanceType ? $attendanceRecord->attendanceType->name : 'N/A' }}</span></p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h5 class="border-bottom pb-2">Advanced Tracking</h5>
                        <p><strong>Daily Work Report (DWR):</strong></p>
                        <div class="p-3 bg-light border rounded mb-3">
                            {{ $attendanceRecord->daily_report ?? 'No Daily Work Report submitted.' }}
                        </div>

                        <p><strong>GPS Location:</strong></p>
                        @if($attendanceRecord->latitude && $attendanceRecord->longitude)
                            <a href="https://maps.google.com/?q={{ $attendanceRecord->latitude }},{{ $attendanceRecord->longitude }}" target="_blank" class="btn btn-sm btn-success mb-3"><i class="fas fa-map-marker-alt"></i> View on Google Maps</a>
                            <br>
                            <small>Lat: {{ $attendanceRecord->latitude }}, Lng: {{ $attendanceRecord->longitude }}</small>
                        @else
                            <span class="text-muted">No GPS coordinates available.</span>
                        @endif
                    </div>
                </div>
                
                @if($attendanceRecord->photo)
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <h5 class="border-bottom pb-2 text-start">Live Selfie Verification</h5>
                        <img src="{{ asset('storage/' . $attendanceRecord->photo) }}" alt="Check-in Photo" class="img-fluid img-thumbnail mt-3" style="max-height: 400px; border-radius: 8px;">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
