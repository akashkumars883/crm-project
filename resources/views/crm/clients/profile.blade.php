@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.profile-page { background: transparent; min-height: 100vh; padding: 24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }
.profile-card { 
    background: #ffffff; 
    border-radius: 4px !important; 
    border: 1px solid #e9ecef !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
    padding: 30px; 
    max-width: 800px; 
    margin: 0 auto; 
}
.profile-card h3 { color: #212529; font-weight: 700; margin-bottom: 24px; }
.profile-section { 
    background: #ffffff; 
    border: 1px solid #e9ecef !important; 
    border-radius: 4px !important; 
    padding: 20px; 
    margin-bottom: 20px; 
}
.profile-section-title { font-size: 13px; font-weight: 700; color: #495057; text-transform: uppercase; margin-bottom: 16px; letter-spacing: 0.5px; border-bottom: 1px solid #f1f3f5; padding-bottom: 8px;}
.form-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 6px; display: block; }
.form-control { 
    width: 100%; 
    padding: 10px 14px; 
    border: 1px solid #ced4da; 
    border-radius: 4px !important; 
    font-size: 14px; 
    transition: all 0.2s ease;
}
.form-control:focus { border-color: #0d6efd; outline: none; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
.btn-save { 
    background: #0d6efd; 
    color: #fff; 
    border: none; 
    padding: 10px 24px; 
    border-radius: 4px !important; 
    font-weight: 600; 
    cursor: pointer; 
    transition: background 0.2s ease;
}
.btn-save:hover { background: #0b5ed7; }
</style>

<div class="profile-page">
  <div class="profile-card">
    <h3><i class="ti ti-user-circle"></i> My Profile</h3>
    <form action="{{ route('myProfile.update') }}" method="POST">
      @csrf
      <div class="profile-section">
        <div class="profile-section-title">Account Information</div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $customer->user->name ?? '' }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Email (cannot change)</label>
            <input type="email" class="form-control" value="{{ $customer->user->email ?? '' }}" disabled>
          </div>
        </div>
      </div>
      <div class="profile-section">
        <div class="profile-section-title">Contact Information</div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $customer->phone ?? $customer->lead->phone ?? '' }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Alternate Phone</label>
            <input type="text" name="alternate_phone" class="form-control" value="{{ $customer->alternate_phone }}">
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="2">{{ $customer->address ?? $customer->lead->address ?? '' }}</textarea>
          </div>
          <div class="col-md-5 mb-3">
            <label class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="{{ $customer->city ?? $customer->lead->city ?? '' }}">
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">State</label>
            <input type="text" name="state" class="form-control" value="{{ $customer->state ?? $customer->lead->state ?? '' }}">
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label">Pincode</label>
            <input type="text" name="zip" class="form-control" value="{{ $customer->zip ?? $customer->lead->zip ?? '' }}">
          </div>
        </div>
      </div>
      <div class="profile-section">
        <div class="profile-section-title">Company Details (for Invoices)</div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ $customer->company_name }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">GSTIN</label>
            <input type="text" name="gstin" class="form-control" value="{{ $customer->gstin }}">
          </div>
        </div>
      </div>
      <div class="text-end">
        <button type="submit" class="btn-save"><i class="ti ti-device-floppy"></i> Save Profile</button>
      </div>
    </form>
  </div>
</div>
@endsection
