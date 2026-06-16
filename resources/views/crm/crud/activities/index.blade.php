@extends('layouts.app')
@section('title', 'All Activities')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Activities</h4>
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('activities.create') }}" class="btn btn-primary">Add a New Activity</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('activities.index') }}" method="GET" class="d-flex">
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
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Lead</th>
                                    <th>Customer</th>
                                    <th>Project</th>
                                    <th>Contact Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($activity->date)->format('D d, M Y') }}</td> --}}
                                    <td>{{ $activity->activityType ? $activity->activityType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->lead ? $activity->lead->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $activity->customer ? $activity->customer->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $activity->project ? $activity->project->id ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $activity->contactMethod ? $activity->contactMethod->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>
                                        <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $activity->id }}">Delete</button>
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
                {{ $activities->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>

    @foreach($activities as $activity)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $activity->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Activity?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
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
@section('scripts')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
@endsection