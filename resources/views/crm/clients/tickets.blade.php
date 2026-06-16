@extends('layouts.app')
@section('title', 'My Tickets')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.tk-page { background: transparent; min-height: 100vh; padding: 24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }
.tk-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
.tk-header h4 { color: #212529; font-weight: 700; margin: 0; }
.tk-new { 
    background: #0d6efd; 
    color: #fff; 
    padding: 10px 20px; 
    border-radius: 4px !important; 
    text-decoration: none; 
    font-weight: 600; 
    font-size: 14px; 
    transition: background 0.2s ease;
}
.tk-new:hover { background: #0b5ed7; color: #fff; }
.tk-list-item { 
    background: #ffffff; 
    border: 1px solid #e9ecef !important;
    border-radius: 4px !important; 
    padding: 20px; 
    margin-bottom: 16px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
}
.tk-title { font-weight: 700; color: #212529; font-size: 16px; margin-bottom: 6px; }
.tk-meta { font-size: 13px; color: #6c757d; margin-bottom: 8px; font-weight: 500;}
.tk-desc { font-size: 14px; color: #495057; margin-bottom: 0; line-height: 1.5;}
.tk-status { display: inline-block; padding: 4px 10px; border-radius: 4px !important; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;}
.tk-status.open { background: #fff8e6; color: #fd7e14; border: 1px solid #ffe69c !important; }
.tk-status.closed { background: #e8f4fd; color: #0d6efd; border: 1px solid #cfe2ff !important; }
.tk-status.resolved { background: #eefaf3; color: #198754; border: 1px solid #d1e7dd !important; }
.empty-state { text-align: center; padding: 60px 20px; color: #6c757d; }
</style>

<div class="tk-page">
  <div class="tk-header">
    <h4><i class="ti ti-ticket text-primary"></i> My Support Tickets</h4>
    <a href="{{ route('createTicket') }}" class="tk-new"><i class="ti ti-plus"></i> New Ticket</a>
  </div>

  @forelse($tickets as $ticket)
    @php
      $statusName = strtolower($ticket->status ?? 'open');
      $cls = 'open';
      if(str_contains($statusName,'close')) $cls='closed';
      elseif(str_contains($statusName,'resolv')) $cls='resolved';
    @endphp
    <div class="tk-list-item">
      <div class="d-flex justify-content-between align-items-start w-100" style="display:flex;justify-content:space-between;align-items:start;gap:16px;">
        <div style="flex:1;">
          <div class="tk-title">#{{ $ticket->id }} - {{ $ticket->title }}</div>
          <div class="tk-meta"><i class="ti ti-tag text-muted"></i> {{ $ticket->ticketCategory->name ?? 'N/A' }} <span class="mx-2">•</span> <i class="ti ti-calendar text-muted"></i> {{ $ticket->created_at->format('d M Y') }}</div>
          <div class="tk-desc">{{ Str::limit($ticket->description, 150) }}</div>
        </div>
        <span class="tk-status {{ $cls }}">{{ ucfirst($ticket->status ?? 'Open') }}</span>
      </div>
    </div>
  @empty
    <div class="tk-list-item empty-state">
      <i class="ti ti-ticket" style="font-size:60px;opacity:.3;margin-bottom:16px;"></i>
      <h5 class="mt-3 text-dark fw-bold">No tickets yet</h5>
      <p>Click "New Ticket" to create a support request.</p>
    </div>
  @endforelse

  <div class="mt-4">{{ $tickets->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
