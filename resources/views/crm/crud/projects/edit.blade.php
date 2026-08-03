@extends('layouts.app')
@section('title', 'Edit Project')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('projects.show', $project->id) }}" class="text-black text-decoration-none me-1" title="Back to Project"><i class="ti ti-arrow-left fs-4"></i></a>
                <i class="ti ti-pencil fs-2"></i>
                <div>
                    <h5 class="fw-semibold text-black mb-0 text-capitalize">Edit Project Settings</h5>
                    <small class="text-black-50 font-12 text-capitalize">Update operations parameters, cost metrics, and location pin</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Horizontal Form Grid -->
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="project_type_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Project Type</label>
                        <select name="project_type_id" id="project_type_id" class="form-select rounded-0">
                            <option value="">Select Project Type</option>
                            @foreach($projectTypes as $projectType)
                                <option value="{{ $projectType->id }}" @if($project->project_type_id == $projectType->id) selected @endif>{{ $projectType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="project_status_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Project Status</label>
                        <select name="project_status_id" id="project_status_id" class="form-select rounded-0">
                            <option value="">Select Status</option>
                            @foreach($projectStatuses as $status)
                                <option value="{{ $status->id }}" @if($project->project_status_id == $status->id) selected @endif>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="customer_id" class="form-label font-12 fw-semibold text-muted text-uppercase">Customer Name</label>
                        <select name="customer_id" id="customer_id" class="form-select rounded-0">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" @if($project->customer_id == $customer->id) selected @endif>{{ $customer->lead->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="start_date" class="form-label font-12 fw-semibold text-muted text-uppercase">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control rounded-0" value="{{ $project->start_date }}">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="end_date" class="form-label font-12 fw-semibold text-muted text-uppercase">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control rounded-0" value="{{ $project->end_date }}">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="assigned_to" class="form-label font-12 fw-semibold text-muted text-uppercase">Assign Supervisor</label>
                        <select name="assigned_to" id="assigned_to" class="form-select rounded-0">
                            <option value="">Select Supervisor</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if($project->assigned_to == $user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="labor_cost" class="form-label font-12 fw-semibold text-muted text-uppercase">Labor Cost</label>
                        <input type="text" name="labor_cost" id="labor_cost" class="form-control rounded-0" value="{{ $project->labor_cost }}">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="invoiceValue" class="form-label font-12 fw-semibold text-muted text-uppercase">Invoice Value</label>
                        <input type="text" name="invoiceValue" id="invoiceValue" class="form-control rounded-0" value="{{ $project->invoiceValue }}">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="previousLeftoverMaterialCost" class="form-label font-12 fw-semibold text-muted text-uppercase">Leftover Mat. Cost</label>
                        <input type="text" name="previousLeftoverMaterialCost" id="previousLeftoverMaterialCost" class="form-control rounded-0" value="{{ $project->previousLeftoverMaterialCost }}">
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="administrativeCost" class="form-label font-12 fw-semibold text-muted text-uppercase">Administrative Cost</label>
                        <input type="text" name="administrativeCost" id="administrativeCost" class="form-control rounded-0" value="{{ $project->administrativeCost }}">
                    </div>

                    <!-- Geolocation Section -->
                    <div class="col-12">
                        <hr class="my-3">
                        <h6 class="mb-3 text-secondary fw-bold text-uppercase font-12" style="letter-spacing: 0.5px;"><i class="ti ti-map-pin me-1"></i>Project Location Map</h6>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="location_name" class="form-label font-12 fw-semibold text-muted text-uppercase">Location Address / Name</label>
                        <div class="input-group rounded-0">
                            <input type="text" name="location_name" id="location_name" class="form-control rounded-0" value="{{ $project->location_name }}" placeholder="e.g. Sangam Vihar, New Delhi">
                            <button class="btn btn-primary btn-sm px-3 rounded-0" type="button" id="search_location_btn" style="width: auto !important;"><i class="ti ti-search me-1"></i> Search Map</button>
                        </div>
                        <small class="text-muted font-11 mt-1 d-block">Type address and click Search, or drag pin on map.</small>
                    </div>

                    <div class="col-12">
                        <div id="project_map" style="height: 300px; width: 100%; border-radius: 4px; border: 1px solid #cbd5e1; z-index: 1;"></div>
                    </div>
                </div>

                <input type="hidden" name="latitude" id="latitude" value="{{ $project->latitude }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ $project->longitude }}">

                <div class="mt-4 border-top pt-3 text-end">
                    <button type="submit" class="btn btn-primary btn-sm px-4 py-2 font-13 rounded-0 text-nowrap" style="width: auto !important;"><i class="ti ti-device-floppy me-1"></i> Save Changes</button>
                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary btn-sm px-3 py-2 font-13 rounded-0 text-nowrap ms-2" style="width: auto !important;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var initialLat = {{ $project->latitude ?? '28.6139' }};
    var initialLng = {{ $project->longitude ?? '77.2090' }};
    var hasLocation = {{ $project->latitude ? 'true' : 'false' }};
    
    var zoomLevel = hasLocation ? 14 : 5;
    var map = L.map('project_map').setView([initialLat, initialLng], zoomLevel);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);
    
    if(!hasLocation) {
        // If no location was saved, don't show the marker yet until user clicks
        map.removeLayer(marker);
    }

    function updateInputs(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    }

    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        updateInputs(position.lat, position.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        if(!map.hasLayer(marker)) {
            marker.addTo(map);
        }
        updateInputs(e.latlng.lat, e.latlng.lng);
    });

    // Search functionality using Nominatim API
    document.getElementById('search_location_btn').addEventListener('click', function() {
        var query = document.getElementById('location_name').value;
        if(!query) return;
        
        fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                if(data && data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    map.setView([lat, lon], 14);
                    marker.setLatLng([lat, lon]);
                    if(!map.hasLayer(marker)) {
                        marker.addTo(map);
                    }
                    updateInputs(lat, lon);
                } else {
                    alert('Location not found. Try dragging the map or being more specific.');
                }
            })
            .catch(error => console.error('Error searching location:', error));
    });
});
</script>
@endsection
