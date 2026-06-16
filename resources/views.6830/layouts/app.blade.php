<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- App css -->
    @notifyCss
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- ... other meta tags, CSS links, etc. ... -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Load jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script> --}}
</head>
<body id="body" data-layout="horizontal">
    <!-- Top Bar Start -->
    <div class="topbar">
        @include('layouts.partials.top-bar')
    </div>
    <!-- Top Bar End -->
    <!-- Top Bar End -->

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content-tab">
            <div class="container-fluid">
                @yield('content')
            </div><!-- container -->
            <!--Start Footer-->
            <!-- Footer Start -->
            <footer class="footer text-center text-sm-start">
                &copy; <script>
                    document.write(new Date().getFullYear())
                </script> {{ config('app.name', 'Laravel') }} <span class="text-muted d-none d-sm-inline-block float-end">Crafted with <i
                        class="mdi mdi-heart text-danger"></i> by <a href="https://www.codelli.in">Codelli</a> </span>
            </footer>
            <!-- end Footer -->
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Javascript  -->
    <!-- vendor js -->
    @notifyJs
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    {{-- <script     src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/analytics-index.init.js') }}"></script> --}}
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>
<!--end body-->
</html>
