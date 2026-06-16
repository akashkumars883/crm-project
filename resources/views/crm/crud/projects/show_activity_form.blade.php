<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-12 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('activities.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="activity_type_id" class="form-label">Activity Type</label>
                            <select class="form-control" id="activity_type_id" name="activity_type_id" required>
                                <option value="">Select Activity Type</option>
                                @foreach ($activityTypes as $activityType)
                                    <option value="{{ $activityType->id }}"{{ old('activity_type-Id') == $activityType->id ? ' selected' : '' }}>{{ $activityType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- The lead_id field will be automatically selected since we are on the Project show page -->
                        <input type="hidden" name="lead_id" value="{{ $project->customer->lead->id }}">
                        
                        <!-- The customer_id field will be automatically selected since we are on the Project show page -->
                        <input type="hidden" name="customer_id" value="{{ $project->customer->id }}">
                        
                        <!-- The project_id field will be automatically selected since we are on the Project show page -->
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        
                        <div class="mb-3">
                            <label for="contact_method_id" class="form-label">Contact Method</label>
                            <select class="form-control" id="contact_method_id" name="contact_method_id" required>
                                <option value="">Select a Contact Method</option>
                                @foreach ($contactMethods as $contactMethod)
                                    <option value="{{ $contactMethod->id }}"{{ old('contact_method_id') == $contactMethod->id ? ' selected' : '' }}>{{ $contactMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Activity</button>
                        {{-- <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>.
</div>
