@extends('layouts.app')
@section('title', 'My Projects')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box px-3">
                <h4 class="page-title">My Projects</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->projectType ? $project->projectType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->projectStatus ? $project->projectStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('D d, M Y') ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('D d, M Y') ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>
</div>
@endsection
