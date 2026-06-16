@extends('layouts.app')
@section('title', 'Edit Work Report')
@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="page-title text-center">Edit Attachments</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('attachments.update', $attachment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Attachment Type</label>
                            <select name="attachment_type_id" class="form-select">
                                <option value="">Select Attachment Type</option>
                                @foreach ($attachmentTypes as $attachmentType)
                                    <option value="{{ $attachmentType->id }}" {{ $attachment->attachment_type_id == $attachmentType->id ? 'selected' : '' }}>
                                        {{ $attachmentType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" {{ $attachment->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->id }} - {{ $project->customer->lead->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*, application/pdf">
                        </div>
                        <div class="mb-3">
                            @foreach ($attachment->images as $image)
                                <a href="{{ asset('storage/' . $image) }}" target="_blank"><span class="badge bg-primary">{{ basename($image) }}</span></a><br>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Attachments</button>
                            <a href="{{ route('attachments.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
