@extends('layouts.app')
@section('title', 'All Users')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row px-4">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Users</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    {{-- Analytics --}}
    <div class="p-3 row bg-white">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart1->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart1->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart2->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart2->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart3->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart3->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row border border-top pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Add a New User</a>
                        {{-- <a href="{{ route('users.export') }}" class="btn btn-dark">Export Users</a> --}}
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search leads">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->roles->count() > 0)
                                            {{ $user->roles->first()->name }}
                                        @else
                                            No Role Assigned
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-success">View</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination links -->
                    <div class="pt-3">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                    <!-- End Pagination Links -->
                </div>
            </div>
        </div>
    </div>

    @foreach($users as $user)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
@endsection