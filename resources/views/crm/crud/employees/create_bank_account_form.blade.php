<form action="{{ route('employee-bank-accounts.store') }}" method="POST">
    @csrf
    <input type="hidden" name="emp_id" value="{{ $employee->id }}">
    
    <div class="row g-3">
        <!-- Section 1: Core Bank Account Info -->
        <div class="col-12 border-bottom pb-2 mb-1">
            <h6 class="text-uppercase text-muted font-11 fw-bold mb-0"><i class="ti ti-building-bank me-1"></i>Bank Account Information</h6>
        </div>

        <div class="col-md-6">
            <label for="bank_name" class="form-label font-13 fw-semibold">Bank Name <span class="text-danger">*</span></label>
            <input type="text" name="bank_name" id="bank_name" class="form-control rounded-0 @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" placeholder="e.g. State Bank of India" required>
            @error('bank_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="account_name" class="form-label font-13 fw-semibold">Account Holder Name</label>
            <input type="text" name="account_name" id="account_name" class="form-control rounded-0 @error('account_name') is-invalid @enderror" value="{{ old('account_name', $employee->name) }}" placeholder="e.g. Rahul Sharma">
            @error('account_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="account_number" class="form-label font-13 fw-semibold">Account Number <span class="text-danger">*</span></label>
            <input type="text" name="account_number" id="account_number" class="form-control rounded-0 @error('account_number') is-invalid @enderror" value="{{ old('account_number') }}" placeholder="e.g. 30918239012" required>
            @error('account_number')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="ifsc" class="form-label font-13 fw-semibold">IFSC Code <span class="text-danger">*</span></label>
            <input type="text" name="ifsc" id="ifsc" class="form-control rounded-0 text-uppercase @error('ifsc') is-invalid @enderror" value="{{ old('ifsc') }}" placeholder="e.g. SBIN0001234" required>
            @error('ifsc')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="branch" class="form-label font-13 fw-semibold">Branch Name / City</label>
            <input type="text" name="branch" id="branch" class="form-control rounded-0 @error('branch') is-invalid @enderror" value="{{ old('branch') }}" placeholder="e.g. Main Branch, Sector 18">
            @error('branch')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Section 2: Digital Payment & UPI Details -->
        <div class="col-12 border-bottom pb-2 mb-1 mt-3">
            <h6 class="text-uppercase text-muted font-11 fw-bold mb-0"><i class="ti ti-qrcode me-1"></i>UPI & Digital Payment Apps</h6>
        </div>

        <div class="col-md-6">
            <label for="upi" class="form-label font-13 fw-semibold">UPI ID</label>
            <input type="text" name="upi" id="upi" class="form-control rounded-0 @error('upi') is-invalid @enderror" value="{{ old('upi') }}" placeholder="name@upi">
            @error('upi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="phonepe" class="form-label font-13 fw-semibold">PhonePe Mobile / ID</label>
            <input type="text" name="phonepe" id="phonepe" class="form-control rounded-0 @error('phonepe') is-invalid @enderror" value="{{ old('phonepe', $employee->phone) }}" placeholder="Mobile number or PhonePe ID">
            @error('phonepe')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="googlepay" class="form-label font-13 fw-semibold">Google Pay Mobile / ID</label>
            <input type="text" name="googlepay" id="googlepay" class="form-control rounded-0 @error('googlepay') is-invalid @enderror" value="{{ old('googlepay', $employee->phone) }}" placeholder="Mobile number or GPay ID">
            @error('googlepay')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="paytm" class="form-label font-13 fw-semibold">Paytm Mobile / ID</label>
            <input type="text" name="paytm" id="paytm" class="form-control rounded-0 @error('paytm') is-invalid @enderror" value="{{ old('paytm', $employee->phone) }}" placeholder="Mobile number or Paytm ID">
            @error('paytm')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 d-flex justify-content-end gap-2 pt-3 border-top mt-3">
            <button type="button" class="btn btn-secondary btn-sm px-4 py-2 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm px-4 py-2 rounded-0 text-nowrap"><i class="ti ti-check me-1"></i> Save Bank Account</button>
        </div>
    </div>
</form>
