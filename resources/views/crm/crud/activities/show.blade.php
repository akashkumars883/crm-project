@extends('layouts.app')
@section('title', 'Activity Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Activity Details for {{ $activity->lead->name }}</h5>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-square btn-primary">Update</a>
                        <a href="{{ route('activities.index') }}" class="btn btn-square btn-secondary">Back to Activity List</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Activity ID</th>
                                <td>{{ $activity->id }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $activity->title }}</td>
                            </tr>
                            <tr>
                                <th>Lead</th>
                                <td>{{ $activity->activityType->name }}</td>
                            </tr>
                            <tr>
                                <th>Lead</th>
                                <td>{{ $activity->lead->name }}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>{{ $activity->customer ? $activity->customer->lead->ame : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Project</th>
                                <td>{{ $activity->project ? $activity->project->id : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Contact Method</th>
                                <td>{{ $activity->contactMethod->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $activity->description }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $activity->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $activity->creator->name }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $activity->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{ $activity->creator->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div>
</div>
@endsection
