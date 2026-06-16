@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    /* Premium Dashboard Design System */
    .dashboard-container {
        font-family: 'Inter', 'Outfit', sans-serif;
    }

    /* Welcome Banner with deep premium gradient */
    .welcome-banner {
        background: linear-gradient(135deg, #303e67 0%, #1a233d 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #ffffff;
        box-shadow: 0 10px 25px rgba(48, 62, 103, 0.15);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::after {
        content: '';
        position: absolute;
        width: 280px;
        height: 280px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
        top: -90px;
        right: -40px;
        pointer-events: none;
    }

    .welcome-banner h5 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .welcome-banner p {
        font-size: 13px;
        opacity: 0.85;
        margin-bottom: 0;
    }

    /* Glassmorphism Badge */
    .glass-badge {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Quick Actions panel */
    .quick-actions-card {
        background: #ffffff;
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        padding: 24px;
        margin-bottom: 24px;
    }

    .quick-actions-title {
        font-size: 15px;
        font-weight: 700;
        color: #303e67;
        margin-bottom: 16px;
    }

    .action-btn-card {
        border-radius: 16px !important;
        border: 1px dashed #dee2e6 !important;
        background: #fafafa;
        padding: 22px 16px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        text-decoration: none !important;
        display: block;
        height: 100%;
    }

    .action-btn-card:hover {
        transform: translateY(-4px);
        background: #ffffff;
        box-shadow: 0 12px 24px rgba(0,0,0,0.05);
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
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 20px;
    }

    .bg-soft-blue { background: rgba(13, 110, 253, 0.08); color: #0d6efd; }
    .bg-soft-green { background: rgba(25, 135, 84, 0.08); color: #198754; }
    .bg-soft-cyan { background: rgba(13, 202, 240, 0.08); color: #0dcaf0; }
    .bg-soft-amber { background: rgba(255, 193, 7, 0.08); color: #ffc107; }

    /* Stat Cards */
    .stat-card {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        background: #ffffff !important;
        transition: all 0.25s ease;
        overflow: hidden;
        position: relative;
        margin-bottom: 20px;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.05) !important;
    }
    
    .stat-accent {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }
    
    .stat-card.admins-card .stat-accent { background: #6f42c1; }
    .stat-card.managers-card .stat-accent { background: #0d6efd; }
    .stat-card.supervisors-card .stat-accent { background: #0dcaf0; }
    .stat-card.accounts-card .stat-accent { background: #fd7e14; }
    .stat-card.hr-card .stat-accent { background: #d63384; }
    .stat-card.employees-card .stat-accent { background: #20c997; }
    .stat-card.customers-card .stat-accent { background: #198754; }
    .stat-card.vendors-card .stat-accent { background: #ffc107; }

    .stat-card .card-body {
        padding: 22px !important;
    }

    .stat-card .card-body p {
        font-size: 11px;
        color: #8494b7;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .stat-card .card-body h3 {
        font-size: 22px;
        font-weight: 700;
        color: #303e67;
        margin-bottom: 0;
    }

    /* Charts & General Cards */
    .chart-card {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        background: #ffffff !important;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .chart-card .card-header {
        background: transparent !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 18px 24px !important;
        font-size: 12px;
        font-weight: 700;
        color: #303e67;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .chart-card .card-body {
        padding: 24px !important;
    }
</style>

<div class="dashboard-container">
    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="text-white mb-1">Welcome back, {{ Auth::user()->name }}!</h5>
            <p class="text-white-50">Here is the active operational health of your Home Glazer CRM.</p>
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
    <div id="quick-actions-panel" class="quick-actions-card">
        <div class="quick-actions-title d-flex align-items-center">
            <div class="avatar-sm bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px;">
                <i class="ti ti-bolt font-16"></i>
            </div>
            <span>Quick Actions & Shortcuts</span>
        </div>
        <div class="row g-3">
            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('leads.create') }}" class="action-btn-card lead-card">
                    <div class="action-icon bg-soft-blue">
                        <i class="ti ti-user-plus"></i>
                    </div>
                    <span class="fw-bold text-dark font-13 d-block">Add New Lead</span>
                    <small class="text-muted d-block font-11 mt-1">Capture and register a new business lead</small>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('invoices.create') }}" class="action-btn-card invoice-card">
                    <div class="action-icon bg-soft-green">
                        <i class="ti ti-file-invoice"></i>
                    </div>
                    <span class="fw-bold text-dark font-13 d-block">Create Invoice</span>
                    <small class="text-muted d-block font-11 mt-1">Generate a new tax invoice for clients</small>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('projects.index') }}" class="action-btn-card project-card">
                    <div class="action-icon bg-soft-cyan">
                        <i class="ti ti-subtask"></i>
                    </div>
                    <span class="fw-bold text-dark font-13 d-block">Manage Projects</span>
                    <small class="text-muted d-block font-11 mt-1">View and track active painting projects</small>
                </a>
            </div>
            {{-- Add Manage Team to fill the gap --}}
            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ route('employees.index') }}" class="action-btn-card" style="border-color: rgba(32, 201, 151, 0.25);">
                    <div class="action-icon" style="background: rgba(32, 201, 151, 0.08); color: #20c997;">
                        <i class="ti ti-users"></i>
                    </div>
                    <span class="fw-bold text-dark font-13 d-block">Manage Team</span>
                    <small class="text-muted d-block font-11 mt-1">Track painters and their attendance</small>
                </a>
            </div>
        </div>
    </div>

    {{-- Counters --}}
    <div id="dashboard-counters" class="mb-4">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
            <div class="col">
                <div class="card stat-card admins-card">
                    <div class="card-body">
                        <p>Admins</p>
                        <h3>{{ $adminsCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card managers-card">
                    <div class="card-body">
                        <p>Managers</p>
                        <h3>{{ $managersCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card supervisors-card">
                    <div class="card-body">
                        <p>Supervisors</p>
                        <h3>{{ $supervisorsCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card accounts-card">
                    <div class="card-body">
                        <p>Accounts</p>
                        <h3>{{ $accountsCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card hr-card">
                    <div class="card-body">
                        <p>HR Staff</p>
                        <h3>{{ $hrCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card employees-card">
                    <div class="card-body">
                        <p>Employees</p>
                        <h3>{{ $employeesCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card customers-card">
                    <div class="card-body">
                        <p>Customers</p>
                        <h3>{{ $customersCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card vendors-card">
                    <div class="card-body">
                        <p>Vendors</p>
                        <h3>{{ $vendorsCount }}</h3>
                    </div>
                    <div class="stat-accent"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section 1 --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card chart-card">
                <div class="card-header">
                    {{ $leadsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $leadsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card chart-card">
                <div class="card-header">
                    {{ $invoicesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $invoicesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card chart-card">
                <div class="card-header">
                    {{ $projectsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $projectsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section 2 --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card chart-card">
                <div class="card-header">
                    {{ $inventoriesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $inventoriesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card chart-card">
                <div class="card-header">
                    {{ $paymentsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $paymentsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card chart-card">
                <div class="card-header">
                    {{ $billsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $billsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Actionable Lists --}}
    <div class="row">
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
</div>

@endsection

@section('scripts')
{!! $leadsByMonth->renderChartJsLibrary() !!}
{!! $leadsByMonth->renderJs() !!}
{!! $invoicesByMonth->renderJs() !!}
{!! $projectsByMonth->renderJs() !!}
{!! $inventoriesByMonth->renderJs() !!}
{!! $paymentsByMonth->renderJs() !!}
{!! $billsByMonth->renderJs() !!}
{{-- {!! $ticketsByMonth->renderJs() !!} --}}
{{-- {!! $activitiesByMonth->renderJs() !!} --}}
@endsection