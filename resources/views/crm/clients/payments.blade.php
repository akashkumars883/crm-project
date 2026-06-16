@extends('layouts.app')
@section('title', 'My Payments')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.pay-page { background: transparent; min-height: 100vh; padding: 24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }
.pay-list-item { 
    background: #ffffff; 
    border: 1px solid #e9ecef !important;
    border-radius: 4px !important; 
    padding: 16px; 
    margin-bottom: 12px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
}
.pay-row1 { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.pay-ref { font-weight: 700; color: #212529; font-size: 15px; margin-bottom: 4px; }
.pay-amt { font-weight: 700; color: #198754; font-size: 16px; margin-bottom: 4px; }
.pay-meta { font-size: 13px; color: #6c757d; margin-bottom: 4px; font-weight: 500;}
.pay-status { display: inline-block; padding: 4px 10px; border-radius: 4px !important; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;}
.pay-status.paid { background: #e8f4fd; color: #0d6efd; border: 1px solid #cfe2ff !important; }
.pay-status.pending { background: #fff8e6; color: #fd7e14; border: 1px solid #ffe69c !important; }
.pay-status.failed { background: #feeff0; color: #dc3545; border: 1px solid #f8d7da !important; }
.empty-state { text-align: center; padding: 60px 20px; color: #6c757d; }
</style>

<div class="pay-page">
  <h4 class="mb-4" style="color:#212529;font-weight:700;"><i class="ti ti-cash text-primary"></i> My Payments</h4>
  @forelse($payments as $payment)
    @php
      $statusName = strtolower($payment->paymentStatus->name ?? 'pending');
      $cls = 'pending';
      if(str_contains($statusName,'paid') || str_contains($statusName,'success')) $cls='paid';
      elseif(str_contains($statusName,'fail')) $cls='failed';
    @endphp
    <div class="pay-list-item">
      <div class="pay-row1">
        <div>
          <div class="pay-ref">Ref: {{ $payment->reference ?? 'N/A' }}</div>
          <div class="pay-meta"><i class="ti ti-calendar"></i> {{ $payment->created_at->format('d M Y, h:i A') }}</div>
          <div class="pay-meta"><i class="ti ti-credit-card"></i> {{ $payment->paymentMethod->name ?? 'N/A' }}</div>
        </div>
        <div class="text-end">
          <div class="pay-amt">₹ {{ number_format($payment->amount, 0) }}</div>
          <span class="pay-status {{ $cls }}">{{ $payment->paymentStatus->name ?? 'Pending' }}</span>
        </div>
      </div>
    </div>
  @empty
    <div class="pay-list-item empty-state">
      <i class="ti ti-cash" style="font-size:60px;opacity:.3;margin-bottom:16px;"></i>
      <h5 class="mt-3 text-dark fw-bold">No payments yet</h5>
    </div>
  @endforelse
  <div class="mt-4">{{ $payments->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
