@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    /* Premium Dashboard Design System */
    .dashboard-container {
        font-family: 'Inter', 'Outfit', sans-serif;
    }

    /* Welcome Banner Flat */
    .welcome-banner {
        background: #ffffff;
        border-radius: 6px;
        padding: 16px 24px;
        color: #1e293b;
        box-shadow: none;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::after {
        display: none;
    }

    .welcome-banner h5 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
        color: #1e293b;
    }

    .welcome-banner p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 0;
    }

    /* Flat Badge */
    .glass-badge {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 18px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
        box-shadow: none;
    }

    /* Quick Actions panel */
    .quick-actions-card {
        background: transparent !important;
        border-radius: 8px;
        border: none;
        box-shadow: none !important;
        margin-bottom: 16px;
    }

    .quick-actions-title {
        font-size: 15px;
        font-weight: 700;
        color: #303e67;
        margin-bottom: 16px;
    }

    .action-btn-card {
        border-radius: 8px !important;
        border: 1px solid #b8b8b8ff !important;
        background: #ffffffff;
        padding: 16px 12px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        text-decoration: none !important;
        display: block;
        height: 100%;
    }

    .action-btn-card:hover {
        transform: none;
        background: #ffffff;
        box-shadow: none;
    }

    .action-btn-card.lead-card { border-color: rgba(13, 110, 253, 0.25) !important; }
    .action-btn-card.lead-card:hover { border-color: #0d6efd !important; }
    .action-btn-card.invoice-card { border-color: rgba(25, 135, 84, 0.25) !important; }
    .action-btn-card.invoice-card:hover { border-color: #198754 !important; }
    .action-btn-card.project-card { border-color: rgba(13, 202, 240, 0.25) !important; }
    .action-btn-card.project-card:hover { border-color: #0dcaf0 !important; }
    .action-btn-card.ticket-card { border-color: rgba(255, 193, 7, 0.25) !important; }
    .action-btn-card.ticket-card:hover { border-color: #ffc107 !important; }

    .action-icon {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
        font-size: 20px;
    }

    .bg-soft-blue { background: rgba(13, 110, 253, 0.08); color: #0d6efd; }
    .bg-soft-green { background: rgba(25, 135, 84, 0.08); color: #198754; }
    .bg-soft-cyan { background: rgba(13, 202, 240, 0.08); color: #0dcaf0; }
    .bg-soft-amber { background: rgba(255, 193, 7, 0.08); color: #ffc107; }

    /* Stat Cards */
    .stat-card {
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: none !important;
        background: #ffffff !important;
        transition: none;
        overflow: hidden;
        position: relative;
        margin-bottom: 6px;
    }
    
    .stat-card:hover {
        transform: none;
        box-shadow: none !important;
    }
    
    .stat-card .card-body {
        padding: 12px 16px !important;
    }

    .stat-card .card-body p {
        font-size: 11px;
        color: #000000ff;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 500;
    }

    .stat-card .card-body h3 {
        font-size: 22px;
        font-weight: 700;
        color: #303e67;
        margin-bottom: 0;
    }

    /* Small Counter Cards (Admins, Managers, etc.) */
    .counter-card {
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        border-left: 3px solid #3b82f6 !important; /* Premium left accent */
        box-shadow: none !important;
        background: #ffffff !important;
        transition: none;
        margin-bottom: 6px;
        text-align: center;
    }
    
    .counter-card:hover {
        transform: none;
        box-shadow: none !important;
        border-color: #cbd5e1 !important;
    }

    .counter-card .card-body {
        padding: 10px 8px !important;
    }

    .counter-card .card-body p {
        font-size: 10px;
        color: #64748b;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .counter-card .card-body h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0;
    }

    /* Custom 8-Column Grid for Counters */
    .counters-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.5rem;
    }
    
    @media (max-width: 1200px) {
        .counters-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .counters-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Charts & General Cards */
    .chart-card {
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: none !important;
        background: #ffffff !important;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .chart-card .card-body {
        padding: 12px 16px !important;
    }
</style>

<div class="dashboard-container">
    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h5>
            <p class="mb-0">Here is the active operational health of your Home Glazer CRM.</p>
        </div>
        <div class="glass-badge">
            <i class="ti ti-calendar me-1"></i> {{ date('d-M-Y h:i A') }}
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger rounded-3">
            {{ session('Customers') }}
        </div>
    @endif

    {{-- Quick Actions Section --}}
    <div class="mb-4 d-flex align-items-center flex-wrap gap-2">
        <span class="text-muted fw-bold text-uppercase me-2" style="font-size: 11px; letter-spacing: 1px;">Quick Actions:</span>
        <a href="{{ route('leads.create') }}" class="btn btn-sm btn-outline-primary"><i class="ti ti-plus me-1"></i>New Lead</a>
        <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-outline-success"><i class="ti ti-file-invoice me-1"></i>Create Invoice</a>
        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-info"><i class="ti ti-subtask me-1"></i>Projects</a>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-warning"><i class="ti ti-users me-1"></i>Manage Team</a>
    </div>

    {{-- Key Analytics --}}
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2 mb-4">
        <div class="col">
            <div class="card stat-card">
                <div class="card-body">
                    <p>Total Revenue</p>
                    <h3>{{ get_setting('currency', '₹') }}{{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="stat-accent" style="background: #198754;"></div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card">
                <div class="card-body">
                    <p>Total Expenses</p>
                    <h3>{{ get_setting('currency', '₹') }}{{ number_format($totalExpenses, 2) }}</h3>
                </div>
                <div class="stat-accent" style="background: #dc3545;"></div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card">
                <div class="card-body">
                    <p>Lead Conversion</p>
                    <h3>{{ $leadConversionRate }}%</h3>
                </div>
                <div class="stat-accent" style="background: #0dcaf0;"></div>
            </div>
        </div>
    </div>

    {{-- Directory Overview (Grouped Counters) --}}
    <div class="card mb-5">
        <div class="card-header border-bottom">
            Directory & Users
        </div>
        <div class="card-body p-0">
            <div class="row g-0 text-center">
                <div class="col-6 col-sm-3 border-end border-bottom p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Admins</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $adminsCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 border-end border-bottom p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Managers</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $managersCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 border-end border-bottom p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Supervisors</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $supervisorsCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 border-bottom p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Accounts</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $accountsCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 border-end p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">HR Staff</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $hrCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 border-end p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Employees</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $employeesCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 border-end p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Customers</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $customersCount }}</h4>
                </div>
                <div class="col-6 col-sm-3 p-3">
                    <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Vendors</p>
                    <h4 class="mb-0 text-dark fw-bold">{{ $vendorsCount }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $leadsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $leadsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $invoicesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $invoicesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $projectsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $projectsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $inventoriesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $inventoriesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $paymentsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $paymentsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $billsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $billsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Live Projects Map --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card chart-card mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="m-0 fw-bold"><i class="ti ti-map-pin me-1 text-danger"></i> Live Project Sites</span>
                    <a href="{{ route('projects.index') }}" class="badge bg-primary text-white px-2 py-1" style="text-decoration: none;">View All</a>
                </div>
                <div class="card-body p-0">
                    <div id="dashboard_live_map" style="height: 400px; width: 100%; z-index: 1;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actionable Lists --}}
    <div class="row g-2">
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="m-0">Today's Follow-ups (Recent Leads)</span>
                    <a href="{{ route('leads.index') }}" class="badge bg-primary text-white px-2 py-1" style="text-decoration: none; font-weight: 500;">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLeads as $lead)
                                <tr>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->phone ?? 'N/A' }}</td>
                                    <td>{{ $lead->created_at->format('d M, Y') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">No recent leads found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="m-0">Active Sites (Projects)</span>
                    <a href="{{ route('projects.index') }}" class="badge bg-primary text-white px-2 py-1" style="text-decoration: none; font-weight: 500;">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeProjects as $project)
                                <tr>
                                    <td>{{ $project->customer->lead->name ?? 'Unknown' }}</td>
                                    <td>
                                        <span class="badge bg-soft-blue">{{ $project->projectStatus->name ?? 'Active' }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($project->start_date)->format('d M, Y') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">No active projects found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Activity Timeline --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="m-0 fw-bold"><i class="ti ti-activity me-1 text-primary"></i> Recent Activity Timeline</span>
                    <a href="{{ route('activities.index') }}" class="badge bg-primary text-white px-2 py-1" style="text-decoration: none; font-weight: 500;">View Full Timeline</a>
                </div>
                <div class="card-body p-4">
                    <div class="activity-timeline">
                        @forelse($recentActivities as $activity)
                            <div class="d-flex mb-4 position-relative">
                                <div class="timeline-line position-absolute top-0 bottom-0 start-0 ms-3" style="width: 2px; background: #e2e8f0; z-index: 0; margin-left: 14px;"></div>
                                <div class="timeline-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center position-relative shadow-sm" style="width: 32px; height: 32px; z-index: 1;">
                                    <i class="ti ti-{{ str_contains(strtolower($activity->title), 'mail') ? 'mail' : (str_contains(strtolower($activity->title), 'call') ? 'phone' : 'check') }} font-16"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="m-0 mb-1 fw-bold text-dark">{{ $activity->title }}</h6>
                                    <p class="m-0 text-muted" style="font-size: 13px;">{{ $activity->description ?? 'No details provided.' }}</p>
                                    <span class="text-secondary d-block mt-1" style="font-size: 11px; font-weight: 500;">
                                        <i class="ti ti-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted m-0">No recent activities to show.</p>
                        @endforelse
                    </div>
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
    var mapProjects = @json($mapProjects ?? []);
    
    // Default Delhi NCR center
    var defaultLat = 28.6139;
    var defaultLng = 77.2090;
    
    var map = L.map('dashboard_live_map').setView([defaultLat, defaultLng], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    if(mapProjects && mapProjects.length > 0) {
        var bounds = [];
        var regionalOffsets = [
            [28.6139, 77.2090], // New Delhi
            [28.4595, 77.0266], // Gurgaon
            [28.5355, 77.3910], // Noida
            [28.4089, 77.3178], // Faridabad
            [28.6692, 77.4538]  // Ghaziabad
        ];

        mapProjects.forEach(function(project, index) {
            var lat = parseFloat(project.latitude);
            var lng = parseFloat(project.longitude);

            if(isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) {
                var base = regionalOffsets[index % regionalOffsets.length];
                lat = base[0] + ((index * 0.015) % 0.06);
                lng = base[1] + ((index * 0.018) % 0.07);
            }

            var marker = L.marker([lat, lng]).addTo(map);
            var customerName = (project.customer && project.customer.lead) ? project.customer.lead.name : (project.name || 'Project #' + project.id);
            var statusName = project.project_status ? project.project_status.name : 'Active';
            var projTitle = project.name ? '<b>' + project.name + '</b><br>' : '';
            var locName = project.location_name ? '<br>📍 ' + project.location_name : '';
            
            var badgeBg = 'bg-primary';
            if(statusName.toLowerCase().indexOf('complete') !== -1 || statusName.toLowerCase().indexOf('done') !== -1) {
                badgeBg = 'bg-success';
            } else if(statusName.toLowerCase().indexOf('hold') !== -1 || statusName.toLowerCase().indexOf('pending') !== -1) {
                badgeBg = 'bg-warning text-dark';
            }

            marker.bindPopup(
                '<div style="font-family:Inter; font-size:13px; min-width:180px; padding:2px;">' +
                projTitle +
                '<b>Customer:</b> ' + customerName + '<br>' +
                '<b>Status:</b> <span class="badge ' + badgeBg + ' ms-1">' + statusName + '</span>' +
                locName +
                '</div>'
            );
            bounds.push([lat, lng]);
        });

        if(bounds.length > 0) {
            map.fitBounds(bounds, {padding: [40, 40], maxZoom: 13});
        }
    }
});
</script>

{!! $leadsByMonth->renderChartJsLibrary() !!}
{!! $leadsByMonth->renderJs() !!}
{!! $invoicesByMonth->renderJs() !!}
{!! $projectsByMonth->renderJs() !!}
{!! $inventoriesByMonth->renderJs() !!}
{!! $paymentsByMonth->renderJs() !!}
{!! $billsByMonth->renderJs() !!}
{!! $rolesChart->renderJs() !!}
@endsection