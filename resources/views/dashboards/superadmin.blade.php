@extends('layouts.app')
@section('title', 'Super Admin Dashboard')
@section('content')

<style>
    /* Premium Dashboard Design System */
    .dashboard-container {
        font-family: 'Inter', 'Outfit', sans-serif;
    }

    /* Welcome Banner with deep premium gradient */
    .welcome-banner {
        background: linear-gradient(135deg, #1e1e2f 0%, #2a2a4a 100%);
        border-radius: 8px;
        padding: 20px 24px;
        color: #ffffff;
        box-shadow: 0 10px 25px rgba(30, 30, 47, 0.2);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        top: -100px;
        right: -50px;
        pointer-events: none;
    }

    .welcome-banner h5 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .welcome-banner p {
        font-size: 14px;
        opacity: 0.85;
        margin-bottom: 0;
    }

    /* Glassmorphism Badge */
    .glass-badge {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Stat Cards */
    .stat-card {
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important;
        background: #ffffff !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        margin-bottom: 16px;
        padding: 20px;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }

    .stat-card .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }

    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .stat-card .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    /* specific card themes */
    .theme-companies .icon-wrapper { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .theme-active .icon-wrapper { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .theme-users .icon-wrapper { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

    /* Tables */
    .premium-table {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
    }
    
    .premium-table thead {
        background: #f8fafc;
    }
    
    .premium-table th {
        font-weight: 600;
        color: #475569;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .premium-table td {
        padding: 16px;
        vertical-align: middle;
        color: #1e293b;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-active { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .status-inactive { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    /* Charts */
    .chart-card {
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02) !important;
        background: #ffffff !important;
        overflow: hidden;
    }

    .chart-card .card-header {
        background: transparent !important;
        border-bottom: 1px solid #f1f5f9 !important;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 20px !important;
    }
</style>

<div class="dashboard-container">
    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="text-white mb-1">Global SaaS Overview</h5>
            <p class="text-white-50">Welcome, {{ Auth::user()->name }}. Monitoring platform-wide metrics.</p>
        </div>
        <div class="glass-badge">
            <i class="ti ti-calendar me-1"></i> {{ date('d-M-Y h:i A') }}
        </div>
    </div>

    {{-- Key Stats Row --}}
    <div class="row mb-2">
        <div class="col-md-4">
            <div class="stat-card theme-companies">
                <div class="icon-wrapper">
                    <i class="ti ti-building"></i>
                </div>
                <div class="stat-value">{{ $totalCompanies }}</div>
                <p class="stat-label">Total Companies</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card theme-active">
                <div class="icon-wrapper">
                    <i class="ti ti-circle-check"></i>
                </div>
                <div class="stat-value">{{ $activeCompanies }}</div>
                <p class="stat-label">Active Companies</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card theme-users">
                <div class="icon-wrapper">
                    <i class="ti ti-users"></i>
                </div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <p class="stat-label">Global Users</p>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Chart Section --}}
        <div class="col-lg-7 mb-4">
            <div class="card chart-card h-100">
                <div class="card-header">
                    {{ $companiesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body p-4">
                    {!! $companiesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>

        {{-- Recent Companies Table --}}
        <div class="col-lg-5 mb-4">
            <div class="card chart-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Registrations</span>
                    <a href="{{ route('superadmin.companies.index') }}" class="badge bg-primary text-white text-decoration-none">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive premium-table border-0 shadow-none">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCompanies as $company)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $company->name }}</div>
                                        <div class="text-muted small">{{ $company->email }}</div>
                                    </td>
                                    <td>
                                        @if($company->status === 'active')
                                            <span class="status-badge status-active">Active</span>
                                        @else
                                            <span class="status-badge status-inactive">{{ ucfirst($company->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $company->created_at->format('d M, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No companies registered yet.</td>
                                </tr>
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
{!! $companiesByMonth->renderChartJsLibrary() !!}
{!! $companiesByMonth->renderJs() !!}
@endsection
