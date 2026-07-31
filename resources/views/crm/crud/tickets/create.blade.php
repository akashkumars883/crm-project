@extends('layouts.app')
@section('title', 'Create Ticket')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('tickets.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Create Support Ticket</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Brief title of the issue" required>
                            </div>
                            <div class="col-md-3">
                                <label for="ticket_category_id" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="ticket_category_id" name="ticket_category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($ticketCategories as $ticketCategory)
                                        <option value="{{ $ticketCategory->id }}"{{ old('ticket_category_id') == $ticketCategory->id ? ' selected' : '' }}>{{ $ticketCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="priority" class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="low"{{ old('priority') == 'low' ? ' selected' : '' }}>Low</option>
                                    <option value="medium"{{ old('priority') == 'medium' ? ' selected' : '' }}>Medium</option>
                                    <option value="high"{{ old('priority') == 'high' ? ' selected' : '' }}>High</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="client_id" class="form-label fw-semibold">Client <span class="text-danger">*</span></label>
                                <select class="form-select" id="client_id" name="client_id" required>
                                    <option value="">Select a Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"{{ old('client_id') == $client->id ? ' selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="assigned_to" class="form-label fw-semibold">Assigned To</label>
                                <select class="form-select" id="assigned_to" name="assigned_to">
                                    <option value="">Select Assignee</option>
                                    @foreach ($assignedUsers as $assignedUser)
                                        <option value="{{ $assignedUser->id }}"{{ old('assigned_to') == $assignedUser->id ? ' selected' : '' }}>{{ $assignedUser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Pending"{{ old('status') == 'Pending' ? ' selected' : '' }}>Pending</option>
                                    <option value="Answered"{{ old('status') == 'Answered' ? ' selected' : '' }}>Answered</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label fw-semibold">Message / Issue Details</label>
                                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Describe the issue in detail...">{{ old('message') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Create Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
