@extends('layouts.auth') <!-- Use your layout file here if you have one -->

@section('content')
<div class="row justify-content-center">
    <div class="col-12 align-self-center">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="ex-page-content text-center">
                                <div class="image-container">
                                    <img class="" src="{{ asset('assets/images/error.png') }}" alt="0">
                                </div>
                                <h1 class="mt-5 mb-4">@yield('code')!</h1>
                                {{-- <h5 class="font-16 text-muted mb-3">Forbidden</h5> --}}
                                <p class="text-muted">@yield('message')</p>
                            </div>
                            <a class="btn btn-primary w-100" href="{{ route('dashboard') }}">Back to Dashboard <i class="fas fa-redo ml-1"></i></a>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end card-body-->
    </div><!--end col-->
</div>

<style>
    /* Add custom CSS for image centering */
    .image-container {
        display: flex;
        justify-content: center;
    }

    .image-container img {
        max-width: 100%;
    }
</style>
@endsection
