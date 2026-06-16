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
    <!-- Intro.js CSS & Custom Styling -->
    <link href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/introjs.min.css" rel="stylesheet" />
    <!-- Google Fonts for Intro.js -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Ultra Premium Quick Tour (Intro.js) Styling */
        .introjs-tooltip {
            border-radius: 16px !important;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25) !important;
            border: 1px solid rgba(255,255,255,0.8) !important;
            font-family: 'Inter', system-ui, sans-serif !important;
            padding: 24px !important;
            width: 90vw !important;
            max-width: 500px !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px) !important;
        }
        .introjs-tooltip-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 12px !important;
            letter-spacing: -0.5px !important;
        }
        .introjs-tooltiptext {
            font-size: 15px !important;
            color: #475569 !important;
            line-height: 1.6 !important;
            margin-bottom: 25px !important;
            font-weight: 400 !important;
        }
        .introjs-button {
            border-radius: 10px !important;
            text-shadow: none !important;
            box-shadow: none !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
            font-size: 14px !important;
            transition: all 0.2s ease !important;
            border: none !important;
            letter-spacing: 0.2px !important;
        }
        .introjs-nextbutton, .introjs-donebutton {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
        }
        .introjs-nextbutton:hover, .introjs-donebutton:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4) !important;
        }
        .introjs-prevbutton {
            background: #f1f5f9 !important;
            color: #334155 !important;
            margin-right: 12px !important;
        }
        .introjs-prevbutton:hover {
            background: #e2e8f0 !important;
            transform: translateY(-1px);
        }
        .introjs-skipbutton {
            color: #94a3b8 !important;
            font-weight: 500 !important;
            padding-left: 0 !important;
            background: transparent !important;
        }
        .introjs-skipbutton:hover {
            color: #64748b !important;
        }
        .introjs-bullets ul li a {
            background: #cbd5e1 !important;
            width: 8px !important;
            height: 8px !important;
            border-radius: 50% !important;
            transition: all 0.3s ease !important;
        }
        .introjs-bullets ul li a.active {
            background: #2563eb !important;
            width: 24px !important;
            border-radius: 4px !important;
        }
        .introjs-helperLayer {
            border-radius: 12px !important;
            background: rgba(255,255,255,0.05) !important;
            box-shadow: 0 0 0 0 transparent, 0 0 0 5000px rgba(15, 23, 42, 0.7) !important;
            backdrop-filter: blur(2px) !important;
        }
        .introjs-progress {
            background-color: #e2e8f0 !important;
            height: 6px !important;
            border-radius: 3px !important;
            margin-top: 10px !important;
        }
        .introjs-progressbar {
            background-color: #2563eb !important;
        }
    </style>
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
            <div class="container-fluid" style="padding-bottom: 50px;">
                @if(session('generated_password'))
                <div class="alert custom-alert custom-alert-success icon-custom-alert shadow-sm fade show d-flex align-items-center mt-3" role="alert">
                    <i class="ti ti-check-up alert-icon text-success align-self-center font-30 me-3"></i>
                    <div class="alert-text me-auto">
                        <h5 class="mb-1 fw-bold mt-0">Customer Created Successfully!</h5>
                        <span>The auto-generated password for this customer is: <strong class="fs-5 bg-white px-2 py-1 border rounded mx-1 text-dark">{{ session('generated_password') }}</strong></span>
                        <p class="mb-0 mt-2 text-muted">Please copy this password and share it with the customer now. For security reasons, it will not be shown again.</p>
                    </div>
                    <div class="alert-close">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
                @yield('content')
            </div><!-- container -->
            <!--Start Footer-->
            <!-- Footer Start -->
            <footer class="footer text-center text-sm-start" style="padding-top: 20px; margin-top: 30px; border-top: 1px solid #e1e1e1;">
                &copy; <script>
                    document.write(new Date().getFullYear())
                </script> Homeglazer. All rights reserved.
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
    <!-- Intro.js Script & Tour Runner -->
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
    <script>
        function startQuickTour() {
            var intro = introJs();
            intro.setOptions({
                steps: [
                    {
                        title: 'Welcome to CRM ✨',
                        intro: 'Let\'s take a quick tour of your new workspace.'
                    },
                    {
                        element: document.querySelector('#navigation'),
                        title: 'Main Menu 🧭',
                        intro: 'Access Sales, HR, Accounts, and Settings here.',
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.card') || document.querySelector('.row'),
                        title: 'Quick Insights 📈',
                        intro: 'Instantly view your key metrics, performance, and recent activities.',
                        position: 'bottom'
                    },
                    {
                        element: document.querySelector('.page-content-tab'),
                        title: 'Workspace 🖥️',
                        intro: 'Your central area for managing records, charts, and daily tasks.',
                        position: 'top'
                    },
                    {
                        element: document.querySelector('.nav-user'),
                        title: 'Profile ⚙️',
                        intro: 'Manage settings or log out from here.',
                        position: 'left'
                    }
                ],
                showBullets: true,
                showProgress: true,
                disableInteraction: true,
                scrollToElement: true,
                doneLabel: 'Get Started',
                nextLabel: 'Next &rarr;',
                prevLabel: '&larr; Back',
                skipLabel: 'Skip',
                tooltipClass: 'custom-introjs-theme'
            });
            intro.start();
        }
    </script>
    @yield('scripts')
    @include('layouts.partials.client-bottom-nav')
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>
<!--end body-->
</html>
