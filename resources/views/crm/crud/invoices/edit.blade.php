@extends('layouts.app')
@section('title', 'Edit Invoice')
@section('content')
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title"><i class="ti ti-file-pencil"></i> Edit Invoice {{ $invoice->invoice_number }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="max-width:1100px;margin:0 auto;">

  <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoiceForm">
    @csrf @method('PUT')

    <div class="inv-section">
      <div class="inv-section-title">Invoice Details</div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div>
          <label class="form-label">Invoice Date *</label>
          <input type="date" name="invoice_date" class="form-control" value="{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '' }}" required>
        </div>
        <div>
          <label class="form-label">Select Customer (Lead) *</label>
          <select name="lead_id" class="form-control" required>
            <option value="">-- Select Lead --</option>
            @foreach($leads as $lead)
              <option value="{{ $lead->id }}" {{ $invoice->lead_id == $lead->id ? 'selected' : '' }}>{{ $lead->name }} ({{ $lead->email }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label">Invoice Status</label>
          <select name="invoice_status_id" class="form-control">
            @foreach($invoiceStatuses as $status)
              <option value="{{ $status->id }}" {{ $invoice->invoice_status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title">Bill To</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <label class="form-label">Bill To Name *</label>
          <input type="text" name="bill_to_name" class="form-control" value="{{ $invoice->bill_to_name }}" required>
        </div>
        <div>
          <label class="form-label">GSTIN</label>
          <input type="text" name="bill_to_gstin" class="form-control" value="{{ $invoice->bill_to_gstin }}">
        </div>
        <div style="grid-column:1/-1;">
          <label class="form-label">Address</label>
          <input type="text" name="bill_to_address" class="form-control" value="{{ $invoice->bill_to_address }}">
        </div>
        <div><label class="form-label">City</label><input type="text" name="bill_to_city" class="form-control" value="{{ $invoice->bill_to_city }}"></div>
        <div><label class="form-label">State</label><input type="text" name="bill_to_state" class="form-control" value="{{ $invoice->bill_to_state }}"></div>
        <div><label class="form-label">Pincode</label><input type="text" name="bill_to_pincode" class="form-control" value="{{ $invoice->bill_to_pincode }}"></div>
        <div style="grid-column:span 2;">
          <label class="form-label">Work Address</label>
          <input type="text" name="work_address" class="form-control" value="{{ $invoice->work_address }}">
        </div>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Invoice Items</span>
        <button type="button" class="btn-add-row" onclick="addRow()"><i class="ti ti-plus"></i> Add Item</button>
      </div>
      <div style="overflow-x:auto;">
      <table class="items-table" id="itemsTable">
        <thead>
          <tr>
            <th style="width:50px;">#</th>
            <th>Description *</th>
            <th style="width:100px;">HSN/SAC</th>
            <th style="width:80px;">Qty Type</th>
            <th style="width:100px;">Quantity</th>
            <th style="width:110px;">Price (₹)</th>
            <th style="width:120px;">Total</th>
            <th style="width:50px;"></th>
          </tr>
        </thead>
        <tbody id="itemsBody">
          @foreach($invoice->items as $idx => $item)
            <tr>
              <td>{{ $idx+1 }}</td>
              <td><input type="text" name="items[{{ $idx }}][description]" value="{{ $item->description }}" required></td>
              <td><input type="text" name="items[{{ $idx }}][hsn_sac]" value="{{ $item->hsn_sac }}"></td>
              <td>
                <select name="items[{{ $idx }}][quantity_type]" onchange="toggleQty(this)">
                  <option value="number" {{ $item->quantity_type=='number'?'selected':'' }}>Number</option>
                  <option value="lumpsum" {{ $item->quantity_type=='lumpsum'?'selected':'' }}>Lumpsum</option>
                </select>
              </td>
              <td><input type="number" step="0.01" name="items[{{ $idx }}][quantity]" class="qty" value="{{ $item->quantity }}" onchange="calcRow(this)" onkeyup="calcRow(this)"></td>
              <td><input type="number" step="0.01" name="items[{{ $idx }}][price]" class="price" value="{{ $item->price }}" onchange="calcRow(this)" onkeyup="calcRow(this)"></td>
              <td><span class="rowTotal">{{ number_format($item->total,2) }}</span></td>
              <td><button type="button" class="btn-del-row" onclick="delRow(this)">×</button></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title">Tax & Adjustments</div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div><label class="form-label">Discount (₹)</label><input type="number" step="0.01" name="discount" id="discount" value="{{ $invoice->discount }}" class="form-control" onchange="calcTotals()" onkeyup="calcTotals()"></div>
        <div><label class="form-label">IGST (%)</label><input type="number" step="0.01" name="igst_percent" id="igstPercent" value="{{ $invoice->igst_percent }}" class="form-control" onchange="calcTotals()" onkeyup="calcTotals()"></div>
        <div><label class="form-label">Shipping/Handling (₹)</label><input type="number" step="0.01" name="shipping" id="shipping" value="{{ $invoice->shipping }}" class="form-control" onchange="calcTotals()" onkeyup="calcTotals()"></div>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title">Bank Details</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div><label class="form-label">Account Name</label><input type="text" name="bank_account_name" class="form-control" value="{{ $invoice->bank_account_name }}"></div>
        <div><label class="form-label">Bank Name</label><input type="text" name="bank_name" class="form-control" value="{{ $invoice->bank_name }}"></div>
        <div><label class="form-label">Account No</label><input type="text" name="bank_account_no" class="form-control" value="{{ $invoice->bank_account_no }}"></div>
        <div><label class="form-label">Branch</label><input type="text" name="bank_branch" class="form-control" value="{{ $invoice->bank_branch }}"></div>
        <div><label class="form-label">IFSC</label><input type="text" name="bank_ifsc" class="form-control" value="{{ $invoice->bank_ifsc }}"></div>
      </div>
    </div>

    <div class="inv-section">
      <label class="form-label">Remarks</label>
      <textarea name="remarks" class="form-control" rows="2">{{ $invoice->remarks }}</textarea>
    </div>

    <div class="totals-panel">
      <div class="totals-row"><span>Subtotal:</span><span id="subTotal">₹ {{ number_format($invoice->subtotal,2) }}</span></div>
      <div class="totals-row"><span>Discount:</span><span id="discTotal">₹ {{ number_format($invoice->discount,2) }}</span></div>
      <div class="totals-row"><span>Subtotal Less Discount:</span><span id="afterDisc">₹ {{ number_format($invoice->subtotal - $invoice->discount,2) }}</span></div>
      <div class="totals-row"><span>IGST:</span><span id="igstTotal">₹ {{ number_format($invoice->igst_amount,2) }}</span></div>
      <div class="totals-row"><span>Shipping:</span><span id="shipTotal">₹ {{ number_format($invoice->shipping,2) }}</span></div>
      <div class="totals-row grand"><span>Balance Due:</span><span id="grandTotal">₹ {{ number_format($invoice->balance_due,2) }}</span></div>
    </div>

    <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;margin-top:14px;">
      <a href="{{ route('invoices.show', $invoice->id) }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-submit"><i class="ti ti-device-floppy"></i> Update Invoice</button>
    </div>
  </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div>

<script>
let itemCount = {{ $invoice->items->count() }};
function addRow() {
  itemCount++;
  const tbody = document.getElementById('itemsBody');
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td>${itemCount}</td>
    <td><input type="text" name="items[${itemCount-1}][description]" required></td>
    <td><input type="text" name="items[${itemCount-1}][hsn_sac]" value="995472"></td>
    <td>
      <select name="items[${itemCount-1}][quantity_type]" onchange="toggleQty(this)">
        <option value="number">Number</option>
        <option value="lumpsum">Lumpsum</option>
      </select>
    </td>
    <td><input type="number" step="0.01" name="items[${itemCount-1}][quantity]" class="qty" onchange="calcRow(this)" onkeyup="calcRow(this)"></td>
    <td><input type="number" step="0.01" name="items[${itemCount-1}][price]" class="price" onchange="calcRow(this)" onkeyup="calcRow(this)"></td>
    <td><span class="rowTotal">0.00</span></td>
    <td><button type="button" class="btn-del-row" onclick="delRow(this)">×</button></td>
  `;
  tbody.appendChild(tr);
}
function delRow(btn) {
  if(document.querySelectorAll('#itemsBody tr').length <= 1) { alert('At least one item is required'); return; }
  btn.closest('tr').remove();
  calcTotals();
}
function toggleQty(sel) {
  const tr = sel.closest('tr');
  const isLump = sel.value === 'lumpsum';
  tr.querySelector('.qty').disabled = isLump;
  tr.querySelector('.price').disabled = isLump;
  if(isLump) { tr.querySelector('.qty').value=''; tr.querySelector('.price').value=''; tr.querySelector('.rowTotal').innerText='Lumpsum'; }
  calcTotals();
}
function calcRow(input) {
  const tr = input.closest('tr');
  const qty = parseFloat(tr.querySelector('.qty').value) || 0;
  const price = parseFloat(tr.querySelector('.price').value) || 0;
  tr.querySelector('.rowTotal').innerText = (qty * price).toFixed(2);
  calcTotals();
}
function calcTotals() {
  let sub = 0;
  document.querySelectorAll('#itemsBody tr').forEach(tr => {
    const qty = parseFloat(tr.querySelector('.qty').value) || 0;
    const price = parseFloat(tr.querySelector('.price').value) || 0;
    sub += qty * price;
  });
  const disc = parseFloat(document.getElementById('discount').value) || 0;
  const igstP = parseFloat(document.getElementById('igstPercent').value) || 0;
  const ship = parseFloat(document.getElementById('shipping').value) || 0;
  const after = sub - disc;
  const igst = after * igstP / 100;
  const total = after + igst + ship;
  document.getElementById('subTotal').innerText = '₹ ' + sub.toFixed(2);
  document.getElementById('discTotal').innerText = '₹ ' + disc.toFixed(2);
  document.getElementById('afterDisc').innerText = '₹ ' + after.toFixed(2);
  document.getElementById('igstTotal').innerText = '₹ ' + igst.toFixed(2);
  document.getElementById('shipTotal').innerText = '₹ ' + ship.toFixed(2);
  document.getElementById('grandTotal').innerText = '₹ ' + total.toFixed(2);
}
calcTotals();
</script>
@endsection
