@extends('layouts.app')
@section('title', 'GST Reports & Dashboard')
@section('content')

<div class="row pt-3 mb-4">
    <div class="col-sm-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title"><i class="ti ti-receipt-tax"></i> GST Dashboard (GSTR-3B Estimate)</h4>
            
            <form method="GET" action="{{ route('gst.dashboard') }}" class="d-flex align-items-center gap-2">
                <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $month == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for($y=date('Y'); $y>=date('Y')-2; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <!-- Output Tax -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4" style="border-top: 4px solid #dc3545 !important;">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-bold mb-1">Output Tax (Sales)</h6>
                <h3 class="text-danger mb-0">{{ get_setting('currency', '₹') }}{{ number_format($outputTax, 2) }}</h3>
                <small class="text-muted">Total Sales: {{ get_setting('currency', '₹') }}{{ number_format($totalSales, 2) }}</small>
            </div>
        </div>
    </div>
    
    <!-- Input Tax -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4" style="border-top: 4px solid #198754 !important;">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-bold mb-1">Input Tax Credit (ITC)</h6>
                <h3 class="text-success mb-0">{{ get_setting('currency', '₹') }}{{ number_format($totalInputTax, 2) }}</h3>
                <small class="text-muted">Exp: {{ number_format($inputTaxExpenses, 2) }} | Bills: {{ number_format($inputTaxBills, 2) }}</small>
            </div>
        </div>
    </div>

    <!-- Net Liability -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4" style="border-top: 4px solid #0d6efd !important; background: #f8faff;">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-bold mb-1">Net Tax Payable</h6>
                <h3 class="text-primary mb-0">{{ get_setting('currency', '₹') }}{{ number_format($netLiability, 2) }}</h3>
                <small class="text-muted">Output - Input</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h5 class="mb-0 fw-bold"><i class="ti ti-file-export text-primary"></i> GSTR-1 (Outward Supplies)</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Download the B2B and B2C sales register for the selected month. This format is compatible with the GST Offline Tool.</p>
                <a href="{{ route('gst.export.gstr1', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">
                    <i class="ti ti-download"></i> Download GSTR-1 Excel/CSV
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h5 class="mb-0 fw-bold"><i class="ti ti-file-import text-success"></i> GSTR-2 Tracking (Input Tax)</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Download your ITC register based on logged Expenses and Purchases. Use this to reconcile with GSTR-2B.</p>
                <a href="{{ route('gst.export.gstr2', ['month' => $month, 'year' => $year]) }}" class="btn btn-success text-white">
                    <i class="ti ti-download"></i> Download GSTR-2 Excel/CSV
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
