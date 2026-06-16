<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Create a new Project</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="project_type_id" class="form-label">Project Type</label>
                            <select name="project_type_id" id="project_type_id" class="form-control">
                                <option value="">Select Project Type</option>
                                @foreach($projectTypes as $projectType)
                                    <option value="{{ $projectType->id }}">{{ $projectType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project_status_id" class="form-label">Project Status</label>
                            <select name="project_status_id" id="project_status_id" class="form-control">
                                <option value="">Select Project Status</option>
                                @foreach($projectStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- The customer_id field will be automatically selected since we are on the lead show page -->
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
