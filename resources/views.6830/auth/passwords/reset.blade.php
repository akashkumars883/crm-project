@extends('layouts.auth')

@section('content')
<!-- Reset Password page -->
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
                                        <img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo" class="auth-logo">
                                    </a>
                                    <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Home Glazer CRM</h4>
                                    <p class="text-muted  mb-0">Reset your password.</p>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form class="my-4" method="POST" action="{{ route('password.update') }}">
                                    @csrf <!-- Add CSRF token -->

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group mb-2">
                                        <label class="form-label text-dark" for="email">Email Address</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div><!--end form-group-->

                                    <div class="form-group mb-2">
                                        <label class="form-label" for="password">Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div><!--end form-group-->

                                    <div class="form-group mb-2">
                                        <label class="form-label" for="password-confirm">Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div><!--end form-group-->

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid mt-3">
                                                <button type="submit" class="btn btn-primary">Reset Password <i class="fas fa-undo ms-1"></i></button>
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
