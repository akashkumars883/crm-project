@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-lg-10">
        <h4 class="mb-4 fw-bold">My Profile</h4>

        @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                        <!-- Left Column: Avatar & Basic Info -->
                        <div class="col-md-4 col-lg-3 border-end bg-light text-center p-4">
                            <div class="position-relative d-inline-block mb-3">
                                @if($user->avatar)
                                    <img src="{{ (\Illuminate\Support\Str::startsWith($user->avatar, 'http') ? $user->avatar : asset('storage/' . $user->avatar)) }}" alt="Profile" class="rounded-circle img-thumbnail bg-white" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle img-thumbnail bg-white text-primary d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px; font-size: 40px; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer shadow" style="cursor: pointer; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" title="Upload Photo">
                                    <i class="ti ti-camera"></i>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">{{ $user->roles->first() ? ucfirst($user->roles->first()->name) : 'User' }}</p>
                            
                            <hr class="my-4 text-muted">
                            <div class="text-start">
                                <small class="text-muted fw-semibold">Email:</small>
                                <p class="mb-3 text-dark text-break" style="font-size: 14px;">{{ $user->email }}</p>
                                <small class="text-muted fw-semibold">Phone:</small>
                                <p class="mb-0 text-dark" style="font-size: 14px;">{{ $user->phone ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Right Column: Tabs -->
                        <div class="col-md-8 col-lg-9 p-0">
                            <div class="border-bottom px-4 pt-3 bg-white">
                                <ul class="nav nav-tabs nav-tabs-custom border-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active fw-semibold pb-3" data-bs-toggle="tab" href="#personalInfo" role="tab">Personal Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link fw-semibold pb-3" data-bs-toggle="tab" href="#bankDetails" role="tab">Bank Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link fw-semibold pb-3" data-bs-toggle="tab" href="#security" role="tab">Security</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="p-4 bg-white">
                                <div class="tab-content">
                                    
                                    <!-- Personal Info Tab -->
                                    <div class="tab-pane active" id="personalInfo" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="dob" value="{{ $user->dob }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" name="address" rows="3">{{ $user->address }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Details Tab -->
                                    <div class="tab-pane" id="bankDetails" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" name="bank_name" value="{{ $user->bank_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Branch</label>
                                                <input type="text" class="form-control" name="bank_branch" value="{{ $user->bank_branch }}">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Account Holder Name</label>
                                                <input type="text" class="form-control" name="bank_account_name" value="{{ $user->bank_account_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Account Number</label>
                                                <input type="text" class="form-control" name="bank_account_number" value="{{ $user->bank_account_number }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">IFSC Code</label>
                                                <input type="text" class="form-control" name="bank_ifsc" value="{{ $user->bank_ifsc }}">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">UPI ID / VPA</label>
                                                <input type="text" class="form-control" name="upi_id" value="{{ $user->upi_id }}" placeholder="e.g. username@okicici">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Security Tab -->
                                    <div class="tab-pane" id="security" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Confirm New Password</label>
                                                <input type="password" class="form-control" name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-top p-3 text-end rounded-bottom">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Find the image or create it if replacing the initials placeholder
                let container = input.previousElementSibling.previousElementSibling;
                if(container.tagName === 'IMG') {
                    container.src = e.target.result;
                } else {
                    let newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'rounded-circle img-thumbnail';
                    newImg.style.cssText = 'width: 120px; height: 120px; object-fit: cover;';
                    container.parentNode.replaceChild(newImg, container);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection