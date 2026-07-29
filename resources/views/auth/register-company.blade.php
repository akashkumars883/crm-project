@extends('layouts.auth')

@section('content')
<div class="container-md">
    <div class="row min-vh-100 py-4 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 col-md-7 mx-auto">
                        <div class="card border-0 shadow-none">
                            <div class="card-body p-0 auth-header-box">
                                <div class="text-center p-3">
                                    <a href="/" class="logo logo-admin">
                                        <img src="{{ asset('assets/images/logo.webp') }}" height="50" alt="logo" class="auth-logo">
                                    </a>
                                    <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Register Your Business</h4>
                                    <p class="text-muted mb-0">Start managing your painting projects & clients efficiently.</p>
                                </div>
                            </div>
                            <div class="card-body pt-3">
                                @if(session('error'))
                                    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                                @endif

                                <form method="POST" action="{{ route('company.register.submit') }}">
                                    @csrf
                                    
                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark fw-semibold">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required placeholder="e.g. Aman Painting Services">
                                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Admin Name">
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark fw-semibold">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@company.com">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark fw-semibold">Phone Number (Optional)</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+91 9876543210">
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label text-dark fw-semibold">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" name="password" id="regPassword" class="form-control pe-5 @error('password') is-invalid @enderror" required placeholder="Minimum 8 characters">
                                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" id="toggleRegPasswordBtn" style="cursor: pointer; z-index: 10;">
                                                <i class="fas fa-eye" id="toggleRegPasswordIcon"></i>
                                            </span>
                                        </div>
                                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label text-dark fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" name="password_confirmation" id="regConfirmPassword" class="form-control pe-5" required placeholder="Type password again">
                                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" id="toggleRegConfirmPasswordBtn" style="cursor: pointer; z-index: 10;">
                                                <i class="fas fa-eye" id="toggleRegConfirmPasswordIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="d-grid mt-3">
                                        <button type="submit" class="btn btn-primary py-2 fw-bold">Create My Account <i class="fas fa-arrow-right ms-1"></i></button>
                                    </div>

                                    <div class="mt-4 text-center text-muted">
                                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupToggle(btnId, inputId, iconId) {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (btn && input && icon) {
            btn.addEventListener('click', function () {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
            });
        }
    }
    setupToggle('toggleRegPasswordBtn', 'regPassword', 'toggleRegPasswordIcon');
    setupToggle('toggleRegConfirmPasswordBtn', 'regConfirmPassword', 'toggleRegConfirmPasswordIcon');
});
</script>
@endsection
