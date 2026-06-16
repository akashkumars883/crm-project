<div class="bg-light">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('attachments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Attachment Type</label>
                            <select name="attachment_type_id" class="form-select">
                                <option value="">Select Attachment Type</option>
                                @foreach ($attachmentTypes as $attachmentType)
                                    <option value="{{ $attachmentType->id }}">{{ $attachmentType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- The project_id field will be automatically selected since we are on the Project show page -->
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*, application/pdf">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Attachments</button>
                            {{-- <a href="{{ route('attachments.index') }}" class="btn btn-secondary">Cancel</a> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
