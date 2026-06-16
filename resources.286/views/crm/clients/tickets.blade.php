@extends('layouts.app')
@section('title', 'My Tickets')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box px-3">
                <h4 class="page-title">My Tickets</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="mt-2 mb-2">
                        {{-- <a href="{{ route('tickets.create') }}" class="btn btn-primary">Add a New Ticket</a> --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ticketModal">Create Ticket</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Subject</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->ticketCategory ? $ticket->ticketCategory->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $ticket->priority }}</td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->assignedUser ? $ticket->assignedUser->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>
                                        {{-- <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-success">View</a> --}}
                                        {{-- <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $ticket->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $tickets->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>

    @foreach($tickets as $ticket)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $ticket->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Ticket?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Add the Create Ticket  Modal Markup -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="ticketModalLabel">Create Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'form content here -->
                @include('crm.clients.create-ticket')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create  popup -->
<script>
    function openTicketPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('TicketPopup');
        popup.style.display = 'block';
    }
</script>
@endsection
