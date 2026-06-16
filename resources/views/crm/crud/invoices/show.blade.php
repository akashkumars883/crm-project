@extends('layouts.app')
@section('title', 'Invoice ' . ($invoice->invoice_number ?? $invoice->id))
@section('content')
<style>
/* Scoped styles for the invoice box inside the show view */
#invoiceBox { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #000; font-size: 11px; margin: 0 auto; border: 2px solid #222; background: #fff; max-width: 800px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
#invoiceBox * { box-sizing: border-box; }

#invoiceBox .top-bar { display: flex; justify-content: space-between; border-bottom: 1px solid #888; padding: 5px 10px; font-weight: bold; font-size: 12px; }
#invoiceBox .top-bar-center { flex-grow: 1; text-align: center; }

#invoiceBox .company-header { display: flex; padding: 15px 10px; align-items: center; border-bottom: 1px solid #888; }
#invoiceBox .logo-container { width: 120px; text-align: center; }
#invoiceBox .logo-container img { max-width: 100px; max-height: 80px; }
#invoiceBox .company-details { padding-left: 20px; }
#invoiceBox .gstin-text { font-weight: bold; margin-bottom: 5px; font-size: 11px; }
#invoiceBox .company-title { font-size: 20px; font-weight: bold; margin-bottom: 2px; text-transform: uppercase; }
#invoiceBox .company-desc { font-size: 11px; margin-bottom: 2px; }
#invoiceBox .company-address { font-size: 11px; margin-bottom: 2px; }
#invoiceBox .company-contact { font-size: 11px; }

#invoiceBox .grid-section { display: flex; border-bottom: 1px solid #888; }
#invoiceBox .col-left { width: 50%; border-right: 1px solid #888; }
#invoiceBox .col-right { width: 50%; }

#invoiceBox .right-details-grid { display: flex; flex-wrap: wrap; }
#invoiceBox .right-item { width: 50%; padding: 5px 10px; font-size: 11px; }
#invoiceBox .right-item strong { font-weight: bold; }
#invoiceBox .right-item.full { width: 100%; }

#invoiceBox .address-block { padding: 5px 10px; font-size: 11px; line-height: 1.4; }
#invoiceBox .address-title { background: #e6f0fa; padding: 3px 10px; border-bottom: 1px solid #888; font-weight: bold; color: #233e66; }
#invoiceBox .address-content { padding: 5px 10px; }
#invoiceBox .address-content strong { display: inline-block; width: 60px; }

#invoiceBox .invoice-table { width: 100%; border-collapse: collapse; font-size: 10px; }
#invoiceBox .invoice-table th, #invoiceBox .invoice-table td { border-right: 1px solid #888; border-bottom: 1px solid #888; padding: 4px 6px; }
#invoiceBox .invoice-table th:last-child, #invoiceBox .invoice-table td:last-child { border-right: none; }
#invoiceBox .invoice-table thead th { background-color: #e6f0fa; text-align: center; font-weight: bold; vertical-align: middle; }
#invoiceBox .invoice-table tbody tr { min-height: 25px; }
#invoiceBox .invoice-table tbody td { vertical-align: top; }

#invoiceBox .col-sr { width: 4%; text-align: center; }
#invoiceBox .col-desc { width: 32%; }
#invoiceBox .col-hsn { width: 8%; text-align: center; }
#invoiceBox .col-qty { width: 8%; text-align: center; }
#invoiceBox .col-rate { width: 10%; text-align: right; }
#invoiceBox .col-taxable { width: 12%; text-align: right; }
#invoiceBox .col-gst-pct { width: 6%; text-align: center; }
#invoiceBox .col-gst-amt { width: 10%; text-align: right; }
#invoiceBox .col-total { width: 10%; text-align: right; }

#invoiceBox .table-footer { font-weight: bold; }
#invoiceBox .table-footer td { border-bottom: 1px solid #888; background-color: #f9f9f9; }

#invoiceBox .bottom-grid { display: flex; border-bottom: 1px solid #888; }
#invoiceBox .bank-details { width: 60%; border-right: 1px solid #888; padding: 5px 10px; font-size: 11px; line-height: 1.5; }
#invoiceBox .bank-details .bd-title { font-weight: bold; border-bottom: 1px solid #888; margin-bottom: 5px; padding-bottom: 2px; }
#invoiceBox .bank-row { display: flex; }
#invoiceBox .bank-label { width: 100px; }

#invoiceBox .summary-details { width: 40%; font-size: 11px; }
#invoiceBox .summary-table { width: 100%; border-collapse: collapse; }
#invoiceBox .summary-table td { padding: 3px 10px; border-bottom: 1px solid #888; }
#invoiceBox .summary-table tr:last-child td { border-bottom: none; }
#invoiceBox .summary-table .s-label { text-align: right; font-weight: bold; border-right: 1px solid #888; width: 60%; background-color: #e6f0fa; }
#invoiceBox .summary-table .s-value { text-align: right; width: 40%; }

#invoiceBox .total-words { padding: 8px 10px; font-size: 11px; border-bottom: 1px solid #888; background-color: #e6f0fa; font-weight: bold; }

#invoiceBox .footer-decl { display: flex; padding: 10px; justify-content: space-between; font-size: 10px; }
#invoiceBox .declaration { width: 60%; }
#invoiceBox .declaration-title { font-weight: bold; margin-bottom: 5px; }
#invoiceBox .declaration ol { margin: 0; padding-left: 15px; margin-bottom: 10px; }
#invoiceBox .qr-code { width: 15%; text-align: center; }
#invoiceBox .signature-box { width: 25%; text-align: center; display: flex; flex-direction: column; justify-content: space-between; align-items: center; }
#invoiceBox .signature-company { font-weight: bold; font-size: 10px; }
#invoiceBox .signature-text { border-top: 1px solid #000; padding-top: 5px; margin-top: 40px; width: 100%; font-size: 10px; }

#invoiceBox .thank-you { text-align: center; font-weight: bold; font-size: 11px; padding: 5px; border-top: 1px solid #888; }

.ti-actions { max-width: 800px; margin: 0 auto 20px; display: flex; gap: 8px; flex-wrap: wrap; }
.ti-btn { padding: 8px 18px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.ti-btn-primary { background: #0d6efd; color: #fff; }
.ti-btn-primary:hover { background: #0a58ca; color: #fff; }
.ti-btn-secondary { background: #e3e7ef; color: #1f2c4d; }
.ti-btn-secondary:hover { background: #c5cbd6; color: #1f2c4d; }
.ti-btn-success { background: #0a7c3b; color: #fff; }
.ti-btn-success:hover { background: #075e2c; color: #fff; }
.ti-btn-warning { background: #b76000; color: #fff; }
.ti-btn-warning:hover { background: #8d4a00; color: #fff; }
</style>

<div class="ti-actions">
  <a href="{{ route('invoices.index') }}" class="ti-btn ti-btn-secondary"><i class="ti ti-arrow-left"></i> Back</a>
  <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="ti-btn ti-btn-primary"><i class="ti ti-printer"></i> Print / PDF</a>
  <a href="{{ route('invoices.edit', $invoice->id) }}" class="ti-btn ti-btn-warning"><i class="ti ti-pencil"></i> Edit</a>
  <button onclick="shareInvoice()" class="ti-btn ti-btn-success"><i class="ti ti-share"></i> Share</button>
  @if($invoice->invoice_type_id == 2)
  <form action="{{ route('invoices.convert', $invoice->id) }}" method="POST" style="display:inline;">
      @csrf
      <button type="submit" class="ti-btn ti-btn-primary" onclick="return confirm('Are you sure you want to convert this Proforma to a Tax Invoice? This will generate a new Tax Invoice number.')"><i class="ti ti-receipt"></i> Convert to Tax Invoice</button>
  </form>
  @endif
</div>

<div id="invoiceBox" style="position: relative;">
  <!-- Watermark -->
  <div style="position: absolute; top: 25%; left: 15%; width: 70%; height: 50%; background-image: url('{{ get_setting('company_logo') ? (\Illuminate\Support\Str::startsWith(get_setting('company_logo', 'http') ? get_setting('company_logo' : asset('storage/' . get_setting('company_logo'))) : asset('assets/images/logo.webp') }}'); background-repeat: no-repeat; background-position: center; background-size: contain; opacity: 0.05; z-index: 0; pointer-events: none; transform: rotate(-45deg);"></div>
  
  <div style="position: relative; z-index: 1;">
  <div class="top-bar">
    <div style="width: 25%;"></div>
    <div class="top-bar-center">Tax Invoice</div>
    <div style="width: 25%; text-align: right;">Original / Duplicate Bill</div>
  </div>

  <div class="company-header">
    <div class="logo-container">
      @if(get_setting('company_logo'))
        <img src="{{ (\Illuminate\Support\Str::startsWith(get_setting('company_logo', 'http') ? get_setting('company_logo' : asset('storage/' . get_setting('company_logo'))) }}" alt="Company Logo">
      @else
        <img src="{{ asset('assets/images/logo.webp') }}" alt="Default Logo">
      @endif
    </div>
    <div class="company-details">
      <div class="gstin-text">GSTIN : {{ get_setting('company_gstin', '07AAHCH3198Q1ZS') }}</div>
      <div class="company-title">{{ get_setting('company_name', 'HOME GLAZER SOLUTIONS PRIVATE LIMITED') }}</div>
      <div class="company-desc">General Maintenance & Interior Work</div>
      <div class="company-address">{{ get_setting('company_address', 'H-16/137 Sangam Vihar, New Delhi - 110080') }}</div>
      <div class="company-contact">Contact No. : {{ get_setting('company_phone', '+91 9876543210') }}, Email: {{ get_setting('company_email', 'homeglazer@gmail.com') }}</div>
    </div>
  </div>

  <div class="grid-section">
    <div class="col-left">
      <div class="address-title">Bill To</div>
      <div class="address-content">
        <div><strong>Name :</strong> {{ $invoice->bill_to_name }}</div>
        <div><strong>Address :</strong> {{ $invoice->bill_to_address }}@if($invoice->bill_to_city), {{ $invoice->bill_to_city }}@endif</div>
        <div><strong>State :</strong> {{ $invoice->bill_to_state ?? 'Delhi' }} @if($invoice->bill_to_pincode) - {{ $invoice->bill_to_pincode }} @endif</div>
        <div><strong>GSTIN :</strong> {{ $invoice->bill_to_gstin ?? 'URP' }}</div>
      </div>
      
      <div class="address-title" style="border-top: 1px solid #888;">Site Address</div>
      <div class="address-content">
        <div><strong>Name :</strong> {{ $invoice->bill_to_name }}</div>
        <div><strong>Address :</strong> {{ $invoice->work_address ?: ($invoice->bill_to_address . ($invoice->bill_to_city ? ', '.$invoice->bill_to_city : '')) }}</div>
        <div><strong>State :</strong> {{ $invoice->bill_to_state ?? 'Delhi' }} @if($invoice->bill_to_pincode) - {{ $invoice->bill_to_pincode }} @endif</div>
        <div><strong>GSTIN :</strong> {{ $invoice->bill_to_gstin ?? 'URP' }}</div>
      </div>
    </div>
    <div class="col-right" style="display: flex; flex-direction: column;">
      <div class="right-details-grid" style="border-bottom: 1px solid #888; flex-grow: 1;">
        <div class="right-item"># Inv. No. : <br><strong>{{ $invoice->invoice_number }}</strong></div>
        <div class="right-item">Inv. Date : <br><strong>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : 'N/A' }}</strong></div>
        <div class="right-item">Payment Mode : <br><strong>Bank/Online</strong></div>
        <div class="right-item">Reverse Charge : <br><strong>NO</strong></div>
      </div>
      <div class="right-details-grid" style="flex-grow: 1;">
        <div class="right-item">Buyer's Order No : <br><strong>-</strong></div>
        <div class="right-item">Supplier's Ref. : <br><strong>{{ $invoice->lead_id ? 'L-'.$invoice->lead_id : '-' }}</strong></div>
        <div class="right-item">Vehicle Number : <br><strong>-</strong></div>
        <div class="right-item">Delivery Date : <br><strong>-</strong></div>
        <div class="right-item full">Terms Of Delivery : <br><strong>{{ $invoice->remarks ?: '-' }}</strong></div>
      </div>
    </div>
  </div>

  @php
    // Determine GST splitting based on state
    $isLocal = strtolower($invoice->bill_to_state) === 'delhi' || empty($invoice->bill_to_state);
    $totalQty = 0;
    $totalTaxable = 0;
    $totalTaxAmt = 0;
  @endphp

  <table class="invoice-table">
    <thead>
      <tr>
        <th rowspan="2" class="col-sr">Sr</th>
        <th rowspan="2" class="col-desc">Goods & Service Discription</th>
        <th rowspan="2" class="col-hsn">HSN</th>
        <th rowspan="2" class="col-qty">Quantity</th>
        <th rowspan="2" class="col-rate">Rate</th>
        <th rowspan="2" class="col-taxable">Taxable</th>
        <th colspan="2" style="border-bottom: 1px solid #888;">GST</th>
        <th rowspan="2" class="col-total">Total</th>
      </tr>
      <tr>
        <th class="col-gst-pct">%</th>
        <th class="col-gst-amt">Amt.</th>
      </tr>
    </thead>
    <tbody>
      @forelse($invoice->items as $item)
        @php
            $qty = $item->quantity_type === 'lumpsum' ? 1 : $item->quantity;
            $rate = $item->price;
            $taxable = $qty * $rate;
            $gstPct = $invoice->igst_percent ?? 18;
            $gstAmt = round($taxable * ($gstPct/100), 2);
            $total = $taxable + $gstAmt;
            
            $totalQty += $qty;
            $totalTaxable += $taxable;
            $totalTaxAmt += $gstAmt;
        @endphp
        <tr>
          <td class="col-sr">{{ $item->sr_no }}</td>
          <td class="col-desc">{{ $item->description }}</td>
          <td class="col-hsn">{{ $item->hsn_sac ?: '995472' }}</td>
          <td class="col-qty">{{ $item->quantity_type === 'lumpsum' ? 'Lumpsum' : number_format($qty, 2) . ' Sq.Ft' }}</td>
          <td class="col-rate">{{ number_format($rate, 2) }}</td>
          <td class="col-taxable">{{ number_format($taxable, 2) }}</td>
          <td class="col-gst-pct">{{ $gstPct }}%</td>
          <td class="col-gst-amt">{{ number_format($gstAmt, 2) }}</td>
          <td class="col-total">{{ number_format($total, 2) }}</td>
        </tr>
      @empty
        <tr><td colspan="9" style="text-align: center; padding: 20px;">No items found</td></tr>
      @endforelse
      
      <!-- Blank rows to fill space if needed -->
      @for($i=0; $i<max(0, 5 - count($invoice->items)); $i++)
        <tr>
          <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        </tr>
      @endfor
    </tbody>
    <tr class="table-footer">
      <td colspan="3" style="text-align: right;">Sub-Total:</td>
      <td class="col-qty">{{ $totalQty }}</td>
      <td class="col-rate"></td>
      <td class="col-taxable">{{ number_format($totalTaxable, 2) }}</td>
      <td class="col-gst-pct"></td>
      <td class="col-gst-amt">{{ number_format($totalTaxAmt, 2) }}</td>
      <td class="col-total">{{ number_format($totalTaxable + $totalTaxAmt, 2) }}</td>
    </tr>
  </table>

  @php
    $finalTotal = $totalTaxable + $totalTaxAmt + ($invoice->shipping ?? 0);
    $roundedTotal = round($finalTotal);
    $roundOff = $roundedTotal - $finalTotal;
    
    if ($isLocal) {
        $cgst = $totalTaxAmt / 2;
        $sgst = $totalTaxAmt / 2;
        $igst = 0;
    } else {
        $cgst = 0;
        $sgst = 0;
        $igst = $totalTaxAmt;
    }
  @endphp

  @php
    $superAdmin = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'super_admin'); })->first();
    $bName = $invoice->bank_name ?? $superAdmin->bank_name ?? 'IDFC Bank';
    $bBranch = $invoice->bank_branch ?? $superAdmin->bank_branch ?? 'Gurgaon';
    $bAccNo = $invoice->bank_account_no ?? $superAdmin->bank_account_number ?? '10183062134';
    $bIfsc = $invoice->bank_ifsc ?? $superAdmin->bank_ifsc ?? 'IDFB0021014';
    $bAccName = $invoice->bank_account_name ?? $superAdmin->bank_account_name ?? 'Home Glazer Solutions Pvt. Ltd.';
    $bUpi = $superAdmin->upi_id ?? 'homeglazer@okicici';
  @endphp

  <div class="bottom-grid">
    <div class="bank-details">
      <div class="bd-title">Our Bank Details</div>
      <div class="bank-row"><div class="bank-label">Bank Name</div>: {{ $bName }}</div>
      <div class="bank-row"><div class="bank-label">Branch</div>: {{ $bBranch }}</div>
      <div class="bank-row"><div class="bank-label">Account No</div>: {{ $bAccNo }}</div>
      <div class="bank-row"><div class="bank-label">IFSC Code</div>: {{ $bIfsc }}</div>
      <div class="bank-row"><div class="bank-label">Account Name</div>: {{ $bAccName }}</div>
    </div>
    
    <div class="summary-details">
      <table class="summary-table">
        <tr><td class="s-label">SUMMARY</td><td class="s-value" style="background-color:#e6f0fa; text-align:center; font-weight:bold;">AMOUNT</td></tr>
        <tr><td class="s-label">CGST Amt :</td><td class="s-value">{{ $cgst > 0 ? number_format($cgst, 2) : '-' }}</td></tr>
        <tr><td class="s-label">SGST Amt :</td><td class="s-value">{{ $sgst > 0 ? number_format($sgst, 2) : '-' }}</td></tr>
        <tr><td class="s-label">IGST Amt :</td><td class="s-value">{{ $igst > 0 ? number_format($igst, 2) : '-' }}</td></tr>
        <tr><td class="s-label">Freight/Shipping :</td><td class="s-value">{{ $invoice->shipping > 0 ? number_format($invoice->shipping, 2) : '-' }}</td></tr>
        <tr><td class="s-label">Round off :</td><td class="s-value">{{ number_format($roundOff, 2) }}</td></tr>
        <tr style="font-weight: bold;"><td class="s-label">Total Amount :</td><td class="s-value">{{ number_format($roundedTotal, 2) }}</td></tr>
      </table>
    </div>
  </div>

  <div class="total-words">
    <div>Invoice Total in Word</div>
    <div style="font-size: 13px; font-weight: normal; margin-top: 5px;">{{ numberToWord($roundedTotal) }}</div>
  </div>

  <div class="footer-decl">
    <div class="declaration">
      <div class="declaration-title">Terms & Conditions</div>
      <ol>
        <li>All disputes are subject to Delhi jurisdiction only.</li>
        <li>Terms & conditions are subject to our trade policy.</li>
        <li>Our risk & responsibility ceases after the delivery of goods/services.</li>
      </ol>
      <div style="font-weight: bold;">E. & O.E.</div>
    </div>
    <div class="qr-code">
      @php
        $upiUrl = "upi://pay?pa={$bUpi}&pn=" . urlencode($bAccName) . "&am={$roundedTotal}&cu=INR";
        $qrApi = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($upiUrl);
      @endphp
      <img src="{{ $qrApi }}" alt="Scan to Pay" style="width: 75px; height: 75px; margin-bottom: 3px;">
      <div style="font-size: 9px; font-weight: bold; color: #1f2c4d;">Scan & Pay</div>
    </div>
    <div class="signature-box">
      <div class="signature-company">For, {{ get_setting('company_name', 'HOME GLAZER SOLUTIONS PVT LTD') }}</div>
      <div class="signature-text">Authorised Signatory</div>
    </div>
  </div>

  <div style="text-align: center; font-size: 10px; margin-top: 10px; color: #555;">This is a computer generated invoice, no signature required.</div>
  <div class="thank-you">Thank You For Business With Us!</div>

  </div> <!-- End relative z-index wrapper -->
</div>

<script>
function shareInvoice() {
  const url = window.location.origin + '/invoices/{{ $invoice->id }}/print';
  if (navigator.share) {
    navigator.share({ title: 'Invoice {{ $invoice->invoice_number }}', url: window.location.href });
  } else {
    navigator.clipboard.writeText(window.location.href);
    alert('Invoice link copied to clipboard!');
  }
}
</script>
@endsection
