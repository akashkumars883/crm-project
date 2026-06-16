@extends('layouts.app')
@section('title', 'Attachments')
@section('content')
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Attachments</h4>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('attachments.create') }}" class="btn btn-square btn-primary">Add New Attachment</a>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form action="{{ route('attachments.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-control" name="type_filter">
                        <option value="">Select Type</option>
                        @foreach ($attachmentTypes as $attachmentType)
                            <option value="{{ $attachmentType->id }}" {{ request('type_filter') == $attachmentType->id ? 'selected' : '' }}>
                                {{ $attachmentType->id }} - {{ $attachmentType->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-square btn-primary" type="submit">Filter by Type</button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form action="{{ route('attachments.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-control" name="project_filter">
                        <option value="">Select Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_filter') == $project->id ? 'selected' : '' }}>
                                {{ $project->id }} - {{ $project->customer->lead->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-square btn-primary" type="submit">Filter by Project</button>
                </div>
            </form>
        </div>
    </div>

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
                                    <th>Project</th>
                                    <th>Images</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attachments as $attachment)
                                    <tr>
                                        <td>{{ $attachment->id }}</td>
                                        <td>{{ $attachment->attachmentType->name }}</td>
                                        <td>{{ $attachment->project->id }} - {{ $attachment->project->customer->lead->name }}</td>
                                        <td>
                                            @foreach ($attachment->images as $image)
                                                <a href="{{ asset('storage/' . $image) }}" target="_blank"><span class="badge bg-secondary">{{ basename($image) }}</span></a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('attachments.edit', $attachment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $attachment->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-3">
                        {{ $attachments->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($attachments as $attachment)
    <div class="modal fade" id="deleteModal{{ $attachment->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Attachment?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" class="d-inline">
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
