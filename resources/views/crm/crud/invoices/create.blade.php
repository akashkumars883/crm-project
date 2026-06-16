@extends('layouts.app')
@section('title', 'Create Tax Invoice')
@section('content')
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title"><i class="ti ti-file-plus"></i> Create New Tax Invoice</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
<style>
  /* Premium Invoice Form Styling */
  .inv-section {
    padding-bottom: 24px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
  }
  .inv-section:last-of-type {
    border-bottom: none;
  }
  .inv-section-title {
    font-size: 15px;
    font-weight: 700;
    color: #303e67;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px dashed #e5e7eb;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
  }
  .inv-section-title i {
    margin-right: 8px;
    color: #3b82f6;
    font-size: 18px;
  }
  .form-label {
    font-weight: 600;
    color: #4b5563;
    font-size: 12px;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }
  .form-control {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    padding: 10px 14px;
    font-size: 14px;
    transition: all 0.2s;
    background: #f9fafb;
  }
  .form-control:focus {
    background: #ffffff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }
  .items-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }
  .items-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    padding: 12px;
    border-bottom: 2px solid #e2e8f0;
  }
  .items-table th:first-child { border-top-left-radius: 8px; }
  .items-table th:last-child { border-top-right-radius: 8px; }
  .items-table td {
    padding: 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }
  .items-table input, .items-table select {
    width: 100%;
    border: 1px solid transparent;
    background: #f8fafc;
    border-radius: 6px;
    padding: 10px 12px;
    transition: all 0.2s;
    font-size: 13px;
  }
  .items-table input:focus, .items-table select:focus {
    background: #ffffff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
  }
  .rowTotal {
    font-weight: 600;
    color: #0f172a;
    font-size: 14px;
  }
  .btn-add-row {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .btn-add-row:hover {
    background: #3b82f6;
    color: #ffffff;
  }
  .btn-del-row {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.2s;
    cursor: pointer;
  }
  .btn-del-row:hover {
    background: #ef4444;
    color: #ffffff;
  }
  .totals-panel {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    width: 340px;
    margin-left: auto;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
  }
  .totals-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    color: #64748b;
    font-size: 14px;
  }
  .totals-row span:last-child {
    font-weight: 600;
    color: #334155;
  }
  .totals-row.grand {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 2px dashed #cbd5e1;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
  }
  .totals-row.grand span:last-child {
    color: #2563eb;
    font-size: 22px;
  }
  .btn-submit {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
  }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
  }
  .btn-cancel {
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.2s;
    display: flex;
    align-items: center;
  }
  .btn-cancel:hover {
    background: #f8fafc;
    color: #0f172a;
  }
  .main-card {
    /* Removed transparent styles so it defaults back to normal template card */
  }
</style>

                <div class="card-body" style="max-width:1100px;margin:0 auto;">
  <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
    @csrf

    <div class="inv-section">
      <div class="inv-section-title"><i class="ti ti-file-info"></i> Invoice Details</div>
      <div class="form-row-2" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;">
        <div>
          <label class="form-label">Invoice Date *</label>
          <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div>
          <label class="form-label">Select Customer (Lead) *</label>
          <select name="lead_id" class="form-control" required>
            <option value="">-- Select Lead --</option>
            @foreach($leads as $lead)
              <option value="{{ $lead->id }}" {{ (isset($presetLeadId) && $presetLeadId == $lead->id) ? 'selected' : '' }}>{{ $lead->name }} ({{ $lead->email }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label">Invoice Type</label>
          <select name="invoice_type_id" id="invoice_type_select" class="form-control" onchange="handleInvoiceTypeChange()" required>
            @foreach($invoiceTypes as $type)
              <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
          </select>
        </div>
        <div id="invoice-status-container">
          <label class="form-label">Invoice Status</label>
          <select name="invoice_status_id" class="form-control">
            @foreach($invoiceStatuses as $status)
              <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
          </select>
        </div>
        <div style="grid-column: 1 / -1; display:flex; align-items: center; gap: 16px; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e5e7eb;">
            <div class="form-check form-switch" style="display: flex; align-items: center; gap: 8px;">
                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1" onchange="toggleRecurringOptions()">
                <label class="form-check-label form-label mb-0" for="is_recurring" style="cursor: pointer;">Enable Recurring Invoice</label>
            </div>
            <div id="recurring_options" style="display: none; align-items: center; gap: 12px;">
                <label class="form-label mb-0">Interval:</label>
                <select name="recurring_interval" class="form-control" style="width: auto;">
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
        </div>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title"><i class="ti ti-building"></i> Bill To</div>
      <div class="form-row-2" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <label class="form-label">Bill To Name *</label>
          <input type="text" name="bill_to_name" class="form-control" required>
        </div>
        <div id="gstin-container">
          <label class="form-label">GSTIN</label>
          <input type="text" name="bill_to_gstin" class="form-control" placeholder="e.g. 09AAATH7073G1ZJ">
        </div>
        <div style="grid-column:1/-1;">
          <label class="form-label">Address</label>
          <input type="text" name="bill_to_address" class="form-control">
        </div>
        <div>
          <label class="form-label">City</label>
          <input type="text" name="bill_to_city" class="form-control">
        </div>
        <div>
          <label class="form-label">State</label>
          <input type="text" name="bill_to_state" class="form-control">
        </div>
        <div>
          <label class="form-label">Pincode</label>
          <input type="text" name="bill_to_pincode" class="form-control">
        </div>
        <div style="grid-column:span 2;">
          <label class="form-label">Work Address (Project Site)</label>
          <input type="text" name="work_address" class="form-control" placeholder="Vrindavan Chandrodaya Mandir, MATHURA, UTTAR PRADESH - 281121">
        </div>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title d-flex justify-content-between" style="display:flex;justify-content:space-between;align-items:center;border-bottom:none;margin-bottom:0;">
        <div><i class="ti ti-list-details"></i> Invoice Items</div>
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
          <tr>
            <td>1</td>
            <td><input type="text" name="items[0][description]" required></td>
            <td><input type="text" name="items[0][hsn_sac]" value="995472"></td>
            <td>
              <select name="items[0][quantity_type]" onchange="toggleQty(this)">
                <option value="number">Number</option>
                <option value="lumpsum">Lumpsum</option>
              </select>
            </td>
            <td><input type="number" step="0.01" name="items[0][quantity]" class="qty" onchange="calcRow(this)" onkeyup="calcRow(this)"></td>
            <td><input type="number" step="0.01" name="items[0][price]" class="price" onchange="calcRow(this)" onkeyup="calcRow(this)"></td>
            <td><span class="rowTotal">0.00</span></td>
            <td><button type="button" class="btn-del-row" onclick="delRow(this)">×</button></td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title"><i class="ti ti-receipt-tax"></i> Tax & Adjustments</div>
      <div class="form-row-2" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div>
          <label class="form-label">Discount (₹)</label>
          <input type="number" step="0.01" name="discount" id="discount" value="0" class="form-control" onchange="calcTotals()" onkeyup="calcTotals()">
        </div>
        <div id="igst-container">
          <label class="form-label">IGST (%)</label>
          <input type="number" step="0.01" name="igst_percent" id="igstPercent" value="18" class="form-control" onchange="calcTotals()" onkeyup="calcTotals()">
        </div>
        <div>
          <label class="form-label">Shipping/Handling (₹)</label>
          <input type="number" step="0.01" name="shipping" id="shipping" value="0" class="form-control" onchange="calcTotals()" onkeyup="calcTotals()">
        </div>
      </div>
    </div>

    <div class="inv-section" id="bank-details-section">
      <div class="inv-section-title"><i class="ti ti-building-bank"></i> Bank Details <span style="font-size:12px;color:#94a3b8;margin-left:8px;font-weight:500;text-transform:none;">(Optional - Defaults applied)</span></div>
      <div class="form-row-2" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
          <label class="form-label">Account Name</label>
          <input type="text" name="bank_account_name" class="form-control" value="Home Glazer Solutions Private Limited">
        </div>
        <div>
          <label class="form-label">Bank Name</label>
          <input type="text" name="bank_name" class="form-control" value="IDFC Bank">
        </div>
        <div>
          <label class="form-label">Account No</label>
          <input type="text" name="bank_account_no" class="form-control" value="10183062134">
        </div>
        <div>
          <label class="form-label">Branch</label>
          <input type="text" name="bank_branch" class="form-control" value="Udyog Vihar, Gurgaon">
        </div>
        <div>
          <label class="form-label">IFSC</label>
          <input type="text" name="bank_ifsc" class="form-control" value="IDFB0021014">
        </div>
      </div>
    </div>

    <div class="inv-section">
      <div class="inv-section-title"><i class="ti ti-message-circle"></i> Remarks / Payment Instructions</div>
      <textarea name="remarks" class="form-control" rows="2" style="background:#f9fafb;">As per terms mentioned in work order</textarea>
    </div>

    <div class="totals-panel">
      <div class="totals-row"><span>Subtotal:</span><span id="subTotal">₹ 0.00</span></div>
      <div class="totals-row"><span>Discount:</span><span id="discTotal">₹ 0.00</span></div>
      <div class="totals-row"><span>Subtotal Less Discount:</span><span id="afterDisc">₹ 0.00</span></div>
      <div class="totals-row"><span>IGST:</span><span id="igstTotal">₹ 0.00</span></div>
      <div class="totals-row"><span>Shipping:</span><span id="shipTotal">₹ 0.00</span></div>
      <div class="totals-row grand"><span>Balance Due:</span><span id="grandTotal">₹ 0.00</span></div>
    </div>

    <div class="text-end mt-3" style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;">
      <a href="{{ route('invoices.index') }}" class="btn-cancel">Cancel</a>
      <button type="submit" class="btn-submit"><i class="ti ti-device-floppy"></i> Save Invoice</button>
    </div>
  </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div>

<script>
let itemCount = 1;
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
  const tot = qty * price;
  tr.querySelector('.rowTotal').innerText = tot.toFixed(2);
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
  const igstContainer = document.getElementById('igst-container');
  const igstP = (igstContainer && igstContainer.style.display !== 'none') ? (parseFloat(document.getElementById('igstPercent').value) || 0) : 0;
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

// Dynamic Field Toggling based on Invoice Type
function handleInvoiceTypeChange() {
  const select = document.getElementById('invoice_type_select');
  const selectedText = select.options[select.selectedIndex].text.toLowerCase();
  
  const statusContainer = document.getElementById('invoice-status-container');
  const gstinContainer = document.getElementById('gstin-container');
  const igstContainer = document.getElementById('igst-container');
  const bankSection = document.getElementById('bank-details-section');

  // Reset to default (show all)
  if(statusContainer) statusContainer.style.display = 'block';
  if(gstinContainer) gstinContainer.style.display = 'block';
  if(igstContainer) igstContainer.style.display = 'block';
  if(bankSection) bankSection.style.display = 'block';

  // Logic for Proforma Invoice
  if (selectedText.includes('proforma')) {
      if(statusContainer) statusContainer.style.display = 'none';
      if(bankSection) bankSection.style.display = 'none'; // Optional: hide bank details for proforma
  }
  
  // Logic for Retail Invoice
  if (selectedText.includes('retail')) {
      if(gstinContainer) gstinContainer.style.display = 'none'; // Retail usually doesn't need GSTIN
  }
  
  calcTotals(); // Recalculate just in case IGST is hidden
}

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
    handleInvoiceTypeChange();
});

function toggleRecurringOptions() {
    const isChecked = document.getElementById('is_recurring').checked;
    document.getElementById('recurring_options').style.display = isChecked ? 'flex' : 'none';
}
</script>
@endsection
