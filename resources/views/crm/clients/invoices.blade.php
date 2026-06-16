@extends('layouts.app')
@section('title', 'My Invoices')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.inv-page { background: transparent; min-height: 100vh; padding: 24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }
.inv-card { 
    background: #ffffff; 
    border-radius: 4px !important; 
    border: 1px solid #e9ecef !important; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
    overflow: hidden; 
}
.inv-card-header { 
    padding: 18px 24px; 
    border-bottom: 1px solid #f1f3f5 !important; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
}
.inv-card-header h4 { margin: 0; color: #212529; font-weight: 700; font-size: 16px; display: flex; align-items: center; gap: 8px;}
.inv-card-header h4 i { color: #0d6efd; font-size: 18px; }

.inv-table { width: 100%; border-collapse: collapse; }
.inv-table th { 
    background: #f8f9fa; 
    color: #495057; 
    font-weight: 600; 
    font-size: 12px; 
    text-transform: uppercase; 
    letter-spacing: 0.5px;
    padding: 16px 24px; 
    text-align: left; 
    border-bottom: 1px solid #e9ecef !important; 
}
.inv-table td { padding: 16px 24px; font-size: 14px; color: #212529; border-bottom: 1px solid #f1f3f5 !important; vertical-align: middle;}
.inv-table tbody tr:hover { background: #f8f9fa; }

.inv-num { font-weight: 700; color: #0d6efd; text-decoration: none; font-size: 14px;}
.inv-num:hover { color: #0a58ca; text-decoration: underline; }

.inv-list-item { 
    background: #ffffff; 
    border: 1px solid #e9ecef !important;
    border-radius: 4px !important; 
    padding: 16px; 
    margin-bottom: 12px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
}
.inv-row1 { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.inv-amt { font-weight: 700; color: #198754; font-size: 16px; }
.inv-meta { font-size: 12px; color: #6c757d; margin-top: 4px; font-weight: 500;}

.inv-actions { display: flex; gap: 8px; margin-top: 12px; }
.inv-actions a { 
    flex: 1; text-align: center; padding: 8px 12px; 
    border-radius: 4px !important; 
    font-size: 13px; font-weight: 600; text-decoration: none; 
    transition: all 0.2s ease;
}
.act-view { background: #e8f4fd; color: #0d6efd; border: 1px solid #cfe2ff !important; }
.act-view:hover { background: #cfe2ff; }
.act-print { background: #eefaf3; color: #198754; border: 1px solid #d1e7dd !important; }
.act-print:hover { background: #d1e7dd; }

@media (max-width: 768px) {
  .desktop-table { display: none; }
  .mobile-list { display: block !important; }
}
@media (min-width: 769px) {
  .mobile-list { display: none !important; }
}
</style>

<div class="inv-page">
  <div class="inv-card">
    <div class="inv-card-header">
      <h4><i class="ti ti-file-invoice"></i> My Invoices</h4>
      <small class="text-muted">{{ $invoices->total() }} invoices</small>
    </div>

    <div class="card-body p-0">
      <div class="desktop-table">
        <table class="inv-table">
          <thead>
            <tr>
              <th>Invoice #</th>
              <th>Date</th>
              <th>Status</th>
              <th>Items</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($invoices as $invoice)
              <tr>
                <td><a href="{{ route('myInvoiceShow', $invoice->id) }}" class="inv-num">{{ $invoice->invoice_number ?? 'INV-'.$invoice->id }}</a></td>
                <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d-M-Y') : 'N/A' }}</td>
                <td><span class="badge bg-warning text-dark">{{ $invoice->invoiceStatus->name ?? 'Pending' }}</span></td>
                <td>{{ $invoice->items_count ?? '' }}</td>
                <td class="fw-bold text-success">₹ {{ number_format($invoice->balance_due, 0) }}</td>
                <td>
                  <a href="{{ route('myInvoiceShow', $invoice->id) }}" class="btn btn-sm btn-primary" style="border-radius: 4px !important;">View</a>
                  <a href="{{ route('myInvoicePrint', $invoice->id) }}" target="_blank" class="btn btn-sm btn-success" style="border-radius: 4px !important;">Print</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center py-5 text-muted">No invoices yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mobile-list" style="display:none;padding:12px;">
        @forelse($invoices as $invoice)
          <div class="inv-list-item">
            <div class="inv-row1">
              <div>
                <a href="{{ route('myInvoiceShow', $invoice->id) }}" class="inv-num">{{ $invoice->invoice_number ?? 'INV-'.$invoice->id }}</a>
                <div class="inv-meta"><i class="ti ti-calendar"></i> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : 'N/A' }}</div>
              </div>
              <div class="inv-amt">₹ {{ number_format($invoice->balance_due, 0) }}</div>
            </div>
            <div class="inv-actions">
              <a href="{{ route('myInvoiceShow', $invoice->id) }}" class="act-view">View</a>
              <a href="{{ route('myInvoicePrint', $invoice->id) }}" target="_blank" class="act-print">Print</a>
            </div>
          </div>
        @empty
          <div class="text-center py-5 text-muted">No invoices yet</div>
        @endforelse
      </div>
    </div>

    <div class="p-3">{{ $invoices->links('pagination::bootstrap-5') }}</div>
  </div>
</div>
@endsection
