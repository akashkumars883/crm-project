@extends('layouts.app')
@section('title', 'My Dashboard')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.cd-page { background:#f8f9fa; min-height:100vh; padding:24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }

/* Welcome Banner */
.cd-welcome { 
    background: #ffffff; 
    border-radius: 4px !important; 
    padding: 24px 30px; 
    margin-bottom: 24px; 
    border: 1px solid #e9ecef !important;
    position: relative; 
    overflow: hidden;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
}
.cd-welcome::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #0d6efd;
}
.cd-welcome-content {
    position: relative;
    z-index: 2;
}
.cd-welcome h3 { margin: 0 0 6px 0; font-weight: 700; font-size: 22px; color: #212529; letter-spacing: -0.3px; }
.cd-welcome p { margin: 0; color: #6c757d; font-size: 14px; font-weight: 400; }

/* Stats Grid */
.cd-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; }
.cd-stat { 
    background: #ffffff; 
    border-radius: 4px !important; 
    padding: 20px; 
    display: flex; 
    align-items: center; 
    border: 1px solid #e9ecef !important; 
    transition: all 0.2s ease; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
}
.cd-stat:hover { border-color: #0d6efd !important; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(13,110,253,0.08) !important; }
.cd-stat-icon { 
    width: 48px; height: 48px; 
    border-radius: 4px !important; 
    display: flex; align-items: center; justify-content: center; 
    margin-right: 16px; 
    font-size: 22px; 
    flex-shrink: 0;
}
/* Stat Colors - Subtle backgrounds with distinct icon colors */
.stat-inv .cd-stat-icon { background: #f0f4ff; color: #0d6efd; }
.stat-proj .cd-stat-icon { background: #eefaf3; color: #198754; }
.stat-pay .cd-stat-icon { background: #fff8e6; color: #ffc107; }
.stat-tic .cd-stat-icon { background: #feeff0; color: #dc3545; }

.cd-stat-info { flex-grow: 1; }
.cd-stat-label { font-size: 12px; color: #6c757d; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.cd-stat-num { font-size: 24px; font-weight: 800; color: #212529; line-height: 1; }

/* Standard Cards */
.cd-card { 
    background: #ffffff; 
    border-radius: 4px !important; 
    border: 1px solid #e9ecef !important; 
    margin-bottom: 24px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
}
.cd-card-header { 
    padding: 18px 24px; 
    border-bottom: 1px solid #f1f3f5 !important; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
}
.cd-card-header h5 { margin: 0; color: #212529; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;}
.cd-card-header h5 i { color: #0d6efd; font-size: 18px; }
.cd-card-header a { color: #0d6efd; text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.2s;}
.cd-card-header a:hover { color: #0a58ca; text-decoration: underline; }
.cd-card-body { padding: 24px; }

/* Quick Actions */
.cd-action-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px; }
.cd-action { 
    background: #ffffff; 
    border: 1px solid #e9ecef !important; 
    border-radius: 4px !important; 
    padding: 20px 12px; 
    text-align: center; 
    text-decoration: none; 
    color: #495057; 
    transition: all 0.2s ease; 
    display: flex; flex-direction: column; align-items: center; justify-content: center;
}
.cd-action:hover { background: #f8f9fa; border-color: #ced4da !important; color: #0d6efd; box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important; }
.cd-action i { font-size: 26px; margin-bottom: 12px; color: #adb5bd; transition: color 0.2s;}
.cd-action:hover i { color: #0d6efd; }
.cd-action span { font-size: 13px; font-weight: 600; }

/* Project Items */
.cd-proj { 
    padding: 16px 0; 
    border-bottom: 1px solid #f1f3f5 !important;
}
.cd-proj:last-child { border-bottom: none !important; padding-bottom: 0; }
.cd-proj:first-child { padding-top: 0; }
.cd-proj-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.cd-proj-name { font-weight: 700; color: #212529; font-size: 15px; }
.cd-proj-status { font-size: 11px; padding: 4px 10px; border-radius: 4px !important; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;}
.cd-proj-status.active { background: #e8f4fd; color: #0d6efd; border: 1px solid #cfe2ff !important; }
.cd-proj-status.pending { background: #fff8e6; color: #fd7e14; border: 1px solid #ffe69c !important; }
.cd-proj-status.completed { background: #eefaf3; color: #198754; border: 1px solid #d1e7dd !important; }
.cd-proj-bar { height: 6px; background: #f1f3f5; border-radius: 4px !important; overflow: hidden; margin-bottom: 8px;}
.cd-proj-bar-fill { height: 100%; background: #0d6efd; border-radius: 4px !important; transition: width 0.5s ease; }
.cd-proj-meta { font-size: 12px; color: #6c757d; font-weight: 500;}

/* Invoice Items */
.cd-inv-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #f1f3f5 !important; }
.cd-inv-row:last-child { border-bottom: none !important; padding-bottom: 0; }
.cd-inv-row:first-child { padding-top: 0; }
.cd-inv-info { flex: 1; }
.cd-inv-no { font-weight: 700; color: #212529; font-size: 14px; margin-bottom: 4px;}
.cd-inv-meta { font-size: 12px; color: #6c757d; font-weight: 500;}
.cd-inv-amt { font-weight: 700; color: #198754; font-size: 16px; }

/* Responsive adjustments */
@media (max-width: 1200px) {
  .cd-action-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 991px) {
  .cd-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 576px) {
  .cd-page { padding: 16px 12px 90px; }
  .cd-stats { grid-template-columns: 1fr; }
  .cd-stat { padding: 16px; }
  .cd-action-grid { grid-template-columns: repeat(2, 1fr); }
  .cd-welcome { padding: 20px; }
  .cd-welcome h3 { font-size: 18px; }
  .cd-card-header, .cd-card-body { padding: 16px; }
}
</style>

<div class="cd-page">
  {{-- Welcome --}}
  <div class="cd-welcome">
    <div class="cd-welcome-content">
        <h3>Welcome back, {{ Auth::user()->name }}</h3>
        <p>Manage your tasks, view invoices and check project status effortlessly.</p>
    </div>
  </div>

  {{-- Quick Stats --}}
  <div class="cd-stats">
    <div class="cd-stat stat-inv">
      <div class="cd-stat-icon"><i class="ti ti-file-invoice"></i></div>
      <div class="cd-stat-info">
        <div class="cd-stat-label">Total Invoices</div>
        <div class="cd-stat-num">{{ $invoicesCount ?? 0 }}</div>
      </div>
    </div>
    <div class="cd-stat stat-proj">
      <div class="cd-stat-icon"><i class="ti ti-building-skyscraper"></i></div>
      <div class="cd-stat-info">
        <div class="cd-stat-label">Active Projects</div>
        <div class="cd-stat-num">{{ $projectsCount ?? 0 }}</div>
      </div>
    </div>
    <div class="cd-stat stat-pay">
      <div class="cd-stat-icon"><i class="ti ti-cash"></i></div>
      <div class="cd-stat-info">
        <div class="cd-stat-label">Payments Made</div>
        <div class="cd-stat-num">{{ $paymentsCount ?? 0 }}</div>
      </div>
    </div>
    <div class="cd-stat stat-tic">
      <div class="cd-stat-icon"><i class="ti ti-ticket"></i></div>
      <div class="cd-stat-info">
        <div class="cd-stat-label">Support Tickets</div>
        <div class="cd-stat-num">{{ $ticketsCount ?? 0 }}</div>
      </div>
    </div>
  </div>

  {{-- Quick Actions --}}
  <div class="cd-card">
    <div class="cd-card-header">
      <h5><i class="ti ti-layout-grid text-primary"></i> Quick Access</h5>
    </div>
    <div class="cd-card-body">
      <div class="cd-action-grid">
        <a href="{{ route('myInvoices') }}" class="cd-action"><i class="ti ti-file-invoice"></i><span>Invoices</span></a>
        <a href="{{ route('myProjects') }}" class="cd-action"><i class="ti ti-building-skyscraper"></i><span>Projects</span></a>
        <a href="{{ route('myPayments') }}" class="cd-action"><i class="ti ti-cash"></i><span>Payments</span></a>
        <a href="{{ route('createTicket') }}" class="cd-action"><i class="ti ti-ticket"></i><span>New Ticket</span></a>
        <a href="{{ route('myTickets') }}" class="cd-action"><i class="ti ti-message-circle"></i><span>Support</span></a>
        <a href="{{ route('myProfile') }}" class="cd-action"><i class="ti ti-user"></i><span>Profile</span></a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      {{-- Recent Projects --}}
      @if(isset($recentProjects) && $recentProjects->count() > 0)
      <div class="cd-card">
        <div class="cd-card-header">
          <h5><i class="ti ti-briefcase text-primary"></i> Ongoing Projects</h5>
          <a href="{{ route('myProjects') }}">View All</a>
        </div>
        <div class="cd-card-body">
          @foreach($recentProjects as $project)
            @php
              $statusName = strtolower($project->projectStatus->name ?? 'active');
              $statusCls = 'active';
              if(str_contains($statusName,'complete') || str_contains($statusName,'done')) $statusCls='completed';
              elseif(str_contains($statusName,'hold') || str_contains($statusName,'pending')) $statusCls='pending';
              $progress = $project->progress_percent ?? 0;
            @endphp
            <div class="cd-proj">
              <div class="cd-proj-row">
                <div class="cd-proj-name">{{ $project->name ?? 'Project #'.$project->id }}</div>
                <span class="cd-proj-status {{ $statusCls }}">{{ $project->projectStatus->name ?? 'Active' }}</span>
              </div>
              <div class="cd-proj-bar"><div class="cd-proj-bar-fill" style="width:{{ $progress }}%"></div></div>
              <div class="cd-proj-meta">{{ $progress }}% Completed • Type: {{ $project->projectType->name ?? 'N/A' }}</div>
            </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>
    
    <div class="col-lg-6">
      {{-- Recent Invoices --}}
      @if(isset($recentInvoices) && $recentInvoices->count() > 0)
      <div class="cd-card">
        <div class="cd-card-header">
          <h5><i class="ti ti-file-invoice text-primary"></i> Recent Invoices</h5>
          <a href="{{ route('myInvoices') }}">View All</a>
        </div>
        <div class="cd-card-body">
          @foreach($recentInvoices as $invoice)
            <div class="cd-inv-row">
              <div class="cd-inv-info">
                <div class="cd-inv-no">{{ $invoice->invoice_number ?? 'INV-'.$invoice->id }}</div>
                <div class="cd-inv-meta">Issued: {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : 'N/A' }}</div>
              </div>
              <div class="cd-inv-amt">₹ {{ number_format($invoice->balance_due, 0) }}</div>
            </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
