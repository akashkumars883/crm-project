@extends('layouts.app')
@section('title', 'Edit Ticket')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Edit Ticket</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-md-6 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('my-tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Use the PUT method for updates -->

                        <div class="mb-3">
                            <label for="ticket_category_id" class="form-label">Ticket Category</label>
                            <select class="form-control" id="ticket_category_id" name="ticket_category_id" required>
                                <option value="">Select Ticket Category</option>
                                @foreach ($ticketCategories as $ticketCategory)
                                    <option value="{{ $ticketCategory->id }}"{{ $ticket->ticket_category_id == $ticketCategory->id ? ' selected' : '' }}>{{ $ticketCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="">Select Priority</option>
                                <option value="low"{{ $ticket->priority == 'low' ? ' selected' : '' }}>Low</option>
                                <option value="medium"{{ $ticket->priority == 'medium' ? ' selected' : '' }}>Medium</option>
                                <option value="high"{{ $ticket->priority == 'high' ? ' selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ $ticket->subject }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4">{{ $ticket->message }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="Answered"{{ $ticket->status == 'Answered' ? ' selected' : '' }}>Answered</option>
                                <option value="Pending"{{ $ticket->status == 'Pending' ? ' selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="client_id" class="form-label">Client</label>
                            <select class="form-control" id="client_id" name="client_id" required>
                                <option value="">Select a Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"{{ $ticket->client_id == $client->id ? ' selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Ticket</button>
                        <a href="{{ route('my-tickets.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
