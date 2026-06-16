<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employee-users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <!-- User Creation Form -->
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Choose Password</label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required>
                        </div>
                        <!-- End User Creation Form -->
                        <button type="submit" class="btn btn-primary">Create Employee User Account</button>
                        {{-- <a href="{{ route('employee-users.index') }}" class="btn btn-secondary">Cancel</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
