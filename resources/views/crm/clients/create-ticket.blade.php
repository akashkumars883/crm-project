@extends('layouts.app')
@section('title', 'Create Ticket')
@section('content')
<style>
/* Premium Crisp Minimalist Design */
.ticket-page { background: transparent; min-height: 100vh; padding: 24px 16px 90px; font-family: 'Inter', system-ui, sans-serif; }
.ticket-card { 
    background: #ffffff; 
    border-radius: 4px !important; 
    border: 1px solid #e9ecef !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; 
    padding: 30px; 
    max-width: 700px; 
    margin: 0 auto; 
}
.ticket-card h3 { color: #212529; font-weight: 700; margin-bottom: 24px; }
.form-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 8px; display: block; letter-spacing: 0.3px;}
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
    font-size: 14px;
    cursor: pointer; 
    transition: background 0.2s ease;
}
.btn-save:hover { background: #0b5ed7; }
.btn-back { 
    background: #f8f9fa; 
    color: #495057; 
    padding: 10px 24px; 
    border: 1px solid #dee2e6;
    border-radius: 4px !important; 
    text-decoration: none; 
    font-weight: 600; 
    font-size: 14px;
    display: inline-block; 
    transition: all 0.2s ease;
}
.btn-back:hover { background: #e9ecef; color: #212529; }
</style>
<div class="ticket-page">
  <div class="ticket-card">
    <h3><i class="ti ti-ticket-plus text-primary"></i> Create Support Ticket</h3>
    <form action="{{ route('storeTicket') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" required placeholder="Brief description of the issue">
      </div>
      <div class="mb-3">
        <label class="form-label">Category <span class="text-danger">*</span></label>
        <select name="ticket_category_id" class="form-control" required>
          <option value="">-- Select Category --</option>
          @foreach($ticketCategories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label class="form-label">Description <span class="text-danger">*</span></label>
        <textarea name="description" class="form-control" rows="5" required placeholder="Please describe the issue in detail..."></textarea>
      </div>
      <div class="d-flex gap-2" style="display:flex;gap:12px;flex-wrap:wrap;justify-content:flex-end;">
        <a href="{{ route('myTickets') }}" class="btn-back">Cancel</a>
        <button type="submit" class="btn-save"><i class="ti ti-send"></i> Submit Ticket</button>
      </div>
    </form>
  </div>
</div>
@endsection
