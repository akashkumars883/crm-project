@extends('layouts.app')
@section('title', 'Assigned Tickets')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Assigned Tickets</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        @if (Auth::user()->hasPermission('create-my-tickets'))
                            <a href="{{ route('my-tickets.create') }}" class="btn btn-primary">Add a New Ticket</a>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('my-tickets.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search tickets">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
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
                                    <th>Client</th>
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
                                    <td>{{ $ticket->client ? $ticket->client->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $ticket->assignedUser ? $ticket->assignedUser->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>
                                        @if (Auth::user()->hasPermission('read-my-tickets'))
                                            <a href="{{ route('my-tickets.show', $ticket->id) }}" class="btn btn-sm btn-success">View</a>
                                        @endif
                                        @if (Auth::user()->hasPermission('update-my-tickets'))
                                            <a href="{{ route('my-tickets.edit', $ticket->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @endif
                                        @if (Auth::user()->hasPermission('delete-my-tickets'))
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $ticket->id }}">Delete</button>
                                        @endif
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
                    <form action="{{ route('my-tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
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
@endsection
