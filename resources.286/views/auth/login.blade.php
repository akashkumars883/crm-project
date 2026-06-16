@extends('layouts.auth')
@section('content')
<!-- Log In page -->
<div class="container-md">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 auth-header-box">
                                <div class="text-center p-3">
                                    <a href="index.html" class="logo logo-admin">
                                        <img src="{{ asset('assets/images/logo.webp') }}" height="50" alt="logo" class="auth-logo">
                                    </a>
                                    <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Home Glazer CRM</h4>
                                    <p class="text-muted  mb-0">Please sign in to continue.</p>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form class="my-4" method="POST" action="{{ route('login') }}">
                                    @csrf <!-- Add CSRF token -->

                                    <div class="form-group mb-2">
                                        <label class="form-label text-dark" for="email">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div><!--end form-group-->

                                    <div class="form-group">
                                        <label class="form-label text-dark" for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div><!--end form-group-->

                                    <div class="form-group row mt-3">
                                        <div class="col-sm-6">
                                            <div class="form-check form-switch form-switch-success">
                                                <input class="form-check-input" type="checkbox" name="remember" id="customSwitchSuccess" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="customSwitchSuccess">Remember me</label>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-sm-6 text-end">
                                            @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-muted font-13"><i class="dripicons-lock"></i> Forgot password?</a>
                                            @endif
                                        </div><!--end col-->
                                    </div><!--end form-group-->

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid mt-3">
                                                <button type="submit" class="btn btn-primary">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div>
                                        </div><!--end col-->
                                    </div> <!--end form-group-->
                                </form><!--end form-->
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end card-body-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->
@endsection
