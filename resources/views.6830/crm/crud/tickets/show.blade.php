@extends('layouts.app')
@section('title', 'Ticket Details')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Ticket Details</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-8 border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <tbody>
                            <tr>
                                <td>Ticket ID</td>
                                <td>{{ $ticket->id }}</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>{{ $ticket->ticketCategory->name }}</td>
                            </tr>
                            <tr>
                                <td>Priority</td>
                                <td>{{ ucfirst($ticket->priority) }}</td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td>{{ $ticket->subject }}</td>
                            </tr>
                            <tr>
                                <td>Message</td>
                                <td>{{ $ticket->message }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ ucfirst($ticket->status) }}</td>
                            </tr>
                            <tr>
                                <td>Client</td>
                                <td>{{ $ticket->client->name }}</td>
                            </tr>
                            <tr>
                                <td>Assigned To</td>
                                <td>{{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Not Assigned' }}</td>
                            </tr>
                            <tr>
                                <td>Created</td>
                                <td>{{ $ticket->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Last Updated</td>
                                <td>{{ $ticket->updated_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /tableresponsive-->
                    <div class="mt-3">
                        @if (Auth::user()->hasPermission('update-ticket'))
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary">Edit</a>    
                        @endif
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
                    </div>
                </div><!--end card-body-->
            </div>
        </div>
    </div>
</div>
@endsection
