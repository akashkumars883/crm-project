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
