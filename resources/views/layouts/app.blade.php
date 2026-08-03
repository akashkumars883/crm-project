<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title') @yield('title') - @endif{{ get_setting('company_name', 'CRM') }}</title>

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

        /* =========================================================
           GLOBAL ENTERPRISE UI SYSTEM (Flat & Professional)
           ========================================================= */
        
        /* 1. Typography & Colors */
        body, .page-wrapper { 
            background-color: #ffffff !important; 
            font-family: 'Inter', system-ui, sans-serif;
            color: #334155;
        }
        
        h1, h2, h3, h4, h5, h6, .card-title {
            color: #0f172a !important;
            font-weight: 700 !important;
            letter-spacing: -0.3px;
        }

        /* 2. Cards & Panels */
        .card { 
            border-radius: 6px !important; 
            box-shadow: none !important; 
            border: 1px solid #e2e8f0 !important; 
            background-color: #ffffff !important;
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 16px 20px !important;
            font-size: 12px;
            font-weight: 700;
            color: #64748b !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-body {
            padding: 20px !important;
        }

        /* 3. Inputs & Buttons */
        .btn { 
            border-radius: 4px !important; 
            box-shadow: none !important; 
            font-weight: 600; 
            width: auto !important;
            flex: 0 0 auto !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
        }
        .btn:not(.btn-sm) {
            padding: 8px 16px !important; /* py-2 equivalent */
        }
        .btn-sm {
            padding: 6px 12px !important; /* py-2 equivalent for small button types */
            font-size: 12px;
        }
        .form-control, .form-select { 
            border-radius: 4px !important; 
            box-shadow: none !important; 
            border: 1px solid #cbd5e1 !important; 
            padding: 10px 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        /* 4. Tables Clean UI */
        .table {
            color: #334155;
            margin-bottom: 0;
        }
        .table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0 !important;
            font-weight: 600;
            padding: 14px 20px !important;
            background: transparent !important;
            border-top: none !important;
        }
        .table td {
            padding: 14px 20px !important;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
            font-size: 13.5px;
            font-weight: 500;
        }
        .table tbody tr:hover {
            background-color: #f8fafc !important;
        }
        
        /* 5. Status Dots for Badges in Tables (Transforms bulky badges to elegant dots) */
        .table .badge {
            background: transparent !important;
            font-weight: 600;
            padding: 0;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #475569 !important;
            text-transform: capitalize;
            box-shadow: none !important;
        }
        .table .badge.bg-success::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #22c55e; }
        .table .badge.bg-danger::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #ef4444; }
        .table .badge.bg-warning::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #f59e0b; }
        .table .badge.bg-info::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #0ea5e9; }
        .table .badge.bg-primary::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #3b82f6; }
        .table .badge.bg-secondary::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #94a3b8; }
        .table .badge.bg-dark::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background-color: #0f172a; }
    </style>
    <!-- ... other meta tags, CSS links, etc. ... -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Load jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script> --}}

    <style>
        /* =========================================================
           GLOBAL LAYOUT CSS (Sidebar + Topbar)
           ========================================================= */
        :root {
            --sidebar-width: 230px;
            --topbar-height: 65px;
            --primary-bg: #f8f9fa;
            --sidebar-bg: #ffffff;
            --topbar-bg: #ffffff;
        }

        body, html {
            overflow-x: hidden;
            background-color: var(--primary-bg) !important;
        }

        /* Sidebar Wrapper */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid #e2e8f0; /* Added explicit border to separate from content */
            z-index: 1001;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        #navigation {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Logo Area */
        .brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align left */
            padding-left: 20px; /* Match sidebar menu visual alignment */
            flex-shrink: 0;
            border-bottom: none; /* Remove duplicate border */
        }
        
        .brand .logo-lg {
            height: 50px; /* Larger logo */
            max-width: 100%;
            object-fit: contain;
        }

        /* Menu Scroll Area */
        .menu-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px 12px;
            display: flex;
            flex-direction: column;
        }

        /* Scrollbar styling for sidebar */
        .menu-content::-webkit-scrollbar {
            width: 5px;
        }
        .menu-content::-webkit-scrollbar-track {
            background: transparent;
        }
        .menu-content::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }
        .menu-content:hover::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }

        /* Sidebar Navigation Items */
        .navigation-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex !important;
            flex-direction: column !important;
            width: 100%;
        }

        .navigation-menu > li.nav-item {
            width: 100%;
            margin-bottom: 4px;
        }

        .navigation-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            color: #4b5563;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .navigation-menu .nav-link:hover,
        .navigation-menu .nav-link[aria-expanded="true"] {
            background-color: #f1f5f9;
            color: #0d6efd;
        }

        .navigation-menu .nav-link .menu-icon {
            font-size: 18px;
            margin-right: 10px;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .navigation-menu .nav-link:hover .menu-icon,
        .navigation-menu .nav-link[aria-expanded="true"] .menu-icon {
            color: #0d6efd;
        }

        /* Sidebar Dropdown Override for Accordion */
        .navigation-menu .dropdown-menu {
            position: static !important;
            float: none !important;
            display: none; 
            box-shadow: none !important;
            background: transparent !important;
            padding: 4px 0 4px 26px !important;
            border: none !important;
            width: 100% !important;
            margin: 0 !important;
            transform: none !important;
        }
        .navigation-menu .dropdown-menu.show {
            display: block;
        }
        
        .navigation-menu .dropdown-menu .dropdown-item {
            padding: 6px 10px;
            color: #64748b;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .navigation-menu .dropdown-menu .dropdown-item:hover {
            color: #0d6efd;
            background-color: #f8fafc;
            padding-left: 14px; /* slight indent on hover */
        }

        /* Dropend submenus in sidebar */
        .navigation-menu .dropdown-submenu .dropdown-menu {
            padding-left: 15px !important;
        }

        /* Topbar fixed */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--topbar-bg);
            border-bottom: 1px solid #e2e8f0;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        /* Page wrapper */
        .page-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width)) !important;
            max-width: 100% !important;
            padding-top: var(--topbar-height);
            min-height: 100vh;
            background-color: var(--primary-bg);
            transition: all 0.3s ease;
        }
        
        .page-content-tab {
            padding: 16px 24px 24px 24px;
            margin-top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Drawer Backdrop */
        .menu-backdrop-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(2px);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        .menu-backdrop-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Layout */
        @media (max-width: 991.98px) {
            .sidebar-wrapper {
                left: calc(-1 * var(--sidebar-width)) !important;
                visibility: hidden !important;
                box-shadow: none !important;
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: calc(-1 * var(--sidebar-width)) !important;
                height: 100vh !important; 
                width: var(--sidebar-width) !important;
                visibility: hidden !important;
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                border-radius: 0 !important;
                justify-content: flex-start !important;
                z-index: 10000 !important;
                transform: none !important;
            }
            .sidebar-wrapper.drawer-open {
                left: 0 !important;
                visibility: visible !important;
                box-shadow: 4px 0 24px rgba(0,0,0,0.2) !important;
            }
            #navigation {
                margin: 0 !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
                border-radius: 0 !important;
                background: #ffffff !important;
                box-shadow: none !important;
            }
            .topbar {
                left: 0;
                padding: 0 16px;
            }
            .page-wrapper {
                margin-left: 0;
                width: 100% !important;
            }
            .page-content-tab {
                padding: 16px;
            }
            .custom-navbar-toggle {
                display: block;
                width: 32px;
                height: 32px;
                position: relative;
                cursor: pointer;
            }
            .custom-navbar-toggle .lines {
                position: absolute;
                top: 50%; left: 50%; transform: translate(-50%, -50%);
                width: 20px; height: 14px;
            }
            .custom-navbar-toggle .lines span {
                display: block; width: 100%; height: 2px;
                background-color: #334155; margin-bottom: 4px;
                transition: all 0.3s ease;
            }
            .custom-navbar-toggle .lines span:last-child { margin-bottom: 0; }
            
            .custom-navbar-toggle.open .lines span:nth-child(1) { transform: rotate(45deg) translate(4px, 4px); }
            .custom-navbar-toggle.open .lines span:nth-child(2) { opacity: 0; }
            .custom-navbar-toggle.open .lines span:nth-child(3) { transform: rotate(-45deg) translate(4px, -4px); }
        }

        /* Comprehensive Mobile Responsiveness Enhancements (< 768px) */
        @media (max-width: 767.98px) {
            .page-content-tab {
                padding: 12px 10px !important;
            }
            .card-body {
                padding: 14px !important;
            }
            .card-header {
                padding: 12px 14px !important;
            }
            /* Action toolbars & filters auto-wrap on mobile */
            .d-flex.justify-content-between:not(.no-mobile-stack) {
                flex-wrap: wrap;
                gap: 10px;
            }
            .card-header.d-flex {
                flex-wrap: wrap;
                gap: 8px;
            }
            /* Table mobile horizontal scrolling & min-width */
            .table-responsive {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                margin-bottom: 1rem;
            }
            .table-responsive table {
                min-width: 600px;
            }
            /* Touch-friendly inputs & buttons on mobile */
            .form-control, .form-select, .btn:not(.btn-sm) {
                min-height: 40px;
            }
            .btn-group {
                flex-wrap: wrap;
            }
            /* Dashboard stat cards font scaling */
            .card h3, .card .h3 {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>
<body id="body">
    <!-- Sidebar Start -->
    @include('layouts.partials.sidebar')
    <!-- Sidebar End -->

    <!-- Top Bar Start -->
    <div class="topbar">
        @include('layouts.partials.top-bar')
    </div>
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
                </script> CRM. All rights reserved.
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
