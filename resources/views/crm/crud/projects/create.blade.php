@extends('layouts.app')
@section('title', 'Create Project')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Create a new Project</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="project_type_id" class="form-label">Project Type</label>
                            <select name="project_type_id" id="project_type_id" class="form-control">
                                <option value="">Select Project Type</option>
                                @foreach($projectTypes as $projectType)
                                    <option value="{{ $projectType->id }}">{{ $projectType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project_status_id" class="form-label">Project Status</label>
                            <select name="project_status_id" id="project_status_id" class="form-control">
                                <option value="">Select Project Status</option>
                                @foreach($projectStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer Name</label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->lead->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="labor_cost" class="form-label">Labor Cost</label>
                            <input type="text" name="labor_cost" id="labor_cost" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="invoiceValue" class="form-label">Invoice Value</label>
                            <input type="text" name="invoiceValue" id="invoiceValue" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="previousLeftoverMaterialCost" class="form-label">Previous LefrOver Material Cost</label>
                            <input type="text" name="previousLeftoverMaterialCost" id="previousLeftoverMaterialCost" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="administrativeCost" class="form-label">Administrative Cost</label>
                            <input type="text" name="administrativeCost" id="administrativeCost" class="form-control">
                        </div> --}}
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign Supervisor</label>
                            <select name="assigned_to" id="assigned_to" class="form-control">
                                <option value="">Select Supervisor</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <hr class="my-4">
                        <h6 class="mb-3 text-secondary fw-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px;">Project Location</h6>
                        
                        <div class="mb-3">
                            <label for="location_name" class="form-label">Location Address / Name</label>
                            <div class="input-group">
                                <input type="text" name="location_name" id="location_name" class="form-control" placeholder="e.g. 123 Main St, New York">
                                <button class="btn btn-outline-secondary" type="button" id="search_location_btn">Search on Map</button>
                            </div>
                            <small class="text-muted">Type an address and click Search, or just click anywhere on the map to drop a pin.</small>
                        </div>
                        
                        <div class="mb-3">
                            <div id="project_map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid #e2e8f0; z-index: 1;"></div>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Default center (e.g. India/New Delhi or just generic)
    var initialLat = 28.6139;
    var initialLng = 77.2090;
    
    var map = L.map('project_map').setView([initialLat, initialLng], 5);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

    function updateInputs(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    }

    // Set initial values (empty until user interacts, but we can leave them empty so backend validation passes as nullable)
    
    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        updateInputs(position.lat, position.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
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
