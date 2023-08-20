@extends('layouts.app')
@section('title', 'Edit Lead')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Edit Lead</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="lead_source_id" class="form-label">Lead Source</label>
                            <select class="form-select" name="lead_source_id" id="lead_source_id" required>
                                <option value="">Select</option>
                                @foreach($leadSources as $leadSource)
                                <option value="{{ $leadSource->id }}" {{ $lead->lead_source_id == $leadSource->id ? 'selected' : '' }}>{{ $leadSource->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lead_status_id" class="form-label">Lead Status</label>
                            <select class="form-select" name="lead_status_id" id="lead_status_id" required>
                                <option value="">Select</option>
                                @foreach($leadStatuses as $leadStatus)
                                <option value="{{ $leadStatus->id }}" {{ $lead->lead_status_id == $leadStatus->id ? 'selected' : '' }}>{{ $leadStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $lead->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $lead->phone }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $lead->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $lead->address }}" >
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="{{ $lead->city }}" >
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" name="state" id="state" value="{{ $lead->state }}" >
                        </div>

                        <div class="mb-3">
                            <label for="zip" class="form-label">Full Zip Code</label>
                            <input type="text" class="form-control" name="zip" id="zip" value="{{ $lead->zip }}" >
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3">{{ $lead->notes }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="assignee_id" class="form-label">Assigned To</label>
                            <select class="form-select" name="assignee_id" id="assignee_id" >
                                <option value="">Select Supervisor</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $lead->assignee_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="contact_methode_id" class="form-label">Contact Method</label>
                            <select class="form-select" name="contact_methode_id" id="contact_methode_id" >
                                <option value="">Select</option>
                                @foreach($contactMethods as $contactMethod)
                                <option value="{{ $contactMethod->id }}" {{ $lead->contact_methode_id == $contactMethod->id ? 'selected' : '' }}>{{ $contactMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="contact_language_id" class="form-label">Contact Language</label>
                            <select class="form-select" name="contact_language_id" id="contact_language_id">
                                <option value="">Select</option>
                                @foreach($contactLanguages as $contactLanguage)
                                <option value="{{ $contactLanguage->id }}" {{ $lead->contact_language_id == $contactLanguage->id ? 'selected' : '' }}>{{ $contactLanguage->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="">
                            <a href="{{ route('leads.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Lead</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
