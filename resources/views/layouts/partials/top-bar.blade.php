<!-- Navbar -->
<nav class="navbar-custom">
    <ul class="list-unstyled topbar-nav float-end mb-0 ms-auto"> 
        @auth
        @if(!Auth::user()->hasRole('client'))
        <li class="d-none d-md-inline-block align-self-center me-3">
            <a class="btn btn-sm btn-outline-primary fw-semibold px-3 py-1.5" href="javascript:void(0);" onclick="startQuickTour()" style="font-size: 13px; border-radius: 20px; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.1);">
                <i class="ti ti-help font-15 me-1 align-text-bottom"></i> Quick Tour
            </a>
        </li>
        @endif
        <li class="dropdown">
            <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center">
                    @if(Auth::user()->avatar)
                        <img src="{{ (\Illuminate\Support\Str::startsWith(Auth::user(, 'http') ? Auth::user( : asset('storage/' . Auth::user())->avatar) }}" alt="{{ Auth::user()->name }}" class="rounded-circle me-2 thumb-sm" style="width: 32px; height: 32px; object-fit: cover;" />
                    @else
                        <div class="rounded-circle me-2 thumb-sm bg-soft-primary text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <span class="d-none d-md-block fw-semibold font-12">{{ Auth::user()->name }} <i
                                class="mdi mdi-chevron-down"></i></span>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                 <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile</a>
                 <a class="dropdown-item" href="{{ route('profile.settings') }}"><i class="ti ti-settings font-16 me-1 align-text-bottom"></i> Settings</a>
                <div class="dropdown-divider mb-0"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti ti-power font-16 me-1 align-text-bottom"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li><!--end topbar-profile-->
        @else
        <li>
            <a href="{{ route('login') }}">Login</a>
        </li>
        @endauth<!--end menu item-->
        @auth
        <li class="d-inline-block d-lg-none">
            <a class="custom-navbar-toggle" id="customMobileToggle" onclick="customToggleMenu(event)">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        </li>
        @endauth
    </ul><!--end topbar-nav-->

    @auth
    <div class="navbar-custom-menu">
        <div id="navigation">
            <!-- LOGO -->
            <div class="brand border-bottom" style="height: 60px; display: flex; justify-content: flex-start; align-items: center; padding-left: 20px;">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="logo-large" class="logo-lg" style="height: 52px; object-fit: contain;">
                </a>
            </div>
            <!-- Mobile Close Button and Header -->
            <div class="d-flex d-lg-none justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa fa-bars me-2 text-primary"></i>Menu</h6>
                <button type="button" class="btn-close" onclick="customToggleMenu()" style="background-color: transparent; border: none; font-size: 1.25rem; font-weight: bold; color: #495057;">✕</button>
            </div>
            <!-- Navigation Menu-->
            @if (Auth::user()->hasRole('super-admin'))
                @include('layouts.partials.super-admin-menu')
            @endif

            @if (Auth::user()->hasRole('admin'))
                @include('layouts.partials.admin-menu')
            @endif

            @if (Auth::user()->hasRole('manager'))
                @include('layouts.partials.manager-menu')
            @endif

            @if (Auth::user()->hasRole('supervisor'))
                @include('layouts.partials.supervisor-menu')
            @endif

            @if (Auth::user()->hasRole('accounts'))
                @include('layouts.partials.accounts-menu')
            @endif

            @if (Auth::user()->hasRole('hr'))
                @include('layouts.partials.hr-menu')
            @endif

            @if (Auth::user()->hasRole('employee'))
                @include('layouts.partials.employee-menu')
            @endif

            @if (Auth::user()->hasRole('vendor'))
                @include('layouts.partials.vendor-menu')
            @endif
            @if (Auth::user()->hasRole('client'))
                @include('layouts.partials.client-menu')
            @endif
        </div> <!-- end navigation -->
    </div>
    @endauth
    <!-- Navbar -->
</nav>
<!-- end navbar-->
@include('notify::components.notify')

@auth
<!-- Drawer Menu Backdrop Overlay -->
<div id="menuBackdrop" class="menu-backdrop-overlay" onclick="customToggleMenu(event)"></div>
@endauth
<style>
/* Prevent horizontal scrolling on mobile viewports */
html, body, .page-wrapper {
    overflow-x: hidden !important;
}

/* Drawer Backdrop */
.menu-backdrop-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.4);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease-in-out;
}
.menu-backdrop-overlay.show {
    opacity: 1;
    visibility: visible;
}

/* =========================================================
   SIDEBAR LAYOUT (Desktop Default)
   ========================================================= */
body {
    background-color: #f8f9fa !important;
}

/* Topbar Fixed */
.topbar {
    position: fixed !important;
    top: 0 !important;
    left: 260px !important;
    right: 0 !important;
    width : calc(100% - 260px) !important;
    height: 60px !important;
    z-index: 1000 !important;
    background: #fff !important;
    border-bottom: 1px solid #eceff5 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 0 15px !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important;
    transition :  all 0.3s ease !important
}

.topbar .brand {
    display: flex !important;
    align-items: center !important;
    height: 60px !important;
}

.navbar-custom {
    flex-grow: 1 !important;
    display: flex !important;
    justify-content: flex-end !important;
    align-items: center !important;
    height: 60px !important;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
}

/* Left Sidebar Fixed */
#navigation {
    position: fixed !important;
    top: 0 !important; /* Below topbar */
    left: 0 !important;
    width: 260px !important;
    height: 100vh !important;
    background: #ffffff !important;
    border-right: none !important;
    box-shadow: 4px 0 24px rgba(0,0,0,0.04) !important;
    z-index: 1001 !important;
    display: flex !important;
    flex-direction: column !important;
    visibility: visible !important;
    pointer-events: auto !important;
    padding: 15px 12px !important;
    overflow-y: auto !important;
    transition: all 0.3s ease !important;
}

/* Page Wrapper Margin for Sidebar */
.page-wrapper {
    margin-left: 260px !important;
    width: calc(100% - 260px) !important;
    padding-top: 60px !important;
    transition: all 0.3s ease !important;
}
.page-wrapper .page-content-tab {
    padding: 12px 16px !important;
}

/* Sidebar Navigation Items */
#navigation .navigation-menu {
    display: block !important;
    float: none !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
    width: 100% !important;
}

#navigation .navigation-menu > li {
    display: block !important;
    float: none !important;
    width: 100% !important;
    margin: 0 0 2px 0 !important;
    padding: 0 !important;
}

#navigation .navigation-menu > li > a {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    height: 30px !important; /* Vertically height kam ki gayi hai */
    padding: 0 15px !important; /* Horizontal padding pehle jaisi (15px) wapas kar di gayi hai */
    border-radius: 8px !important;
    color: #4b5563 !important;
    background: transparent !important;
    font-weight: 500 !important;
    font-size: 14px !important;
    transition: all 0.2s ease !important;
    text-decoration: none !important;
    text-align: left !important;
}

#navigation .navigation-menu > li > a:hover,
#navigation .navigation-menu > li > a[aria-expanded="true"] {
    background: #f1f5f9 !important;
    color: #0d6efd !important;
}

#navigation .navigation-menu > li > a .menu-icon {
    font-size: 18px !important;
    margin-right: 10px !important;
    color: #6c757d !important;
}

#navigation .navigation-menu > li > a:hover .menu-icon,
#navigation .navigation-menu > li > a[aria-expanded="true"] .menu-icon {
    color: #0d6efd !important;
}

/* Sidebar Submenus (Restored Dropdowns) */
#navigation .navigation-menu .dropdown-menu,
#navigation .navigation-menu .submenu {
    position: static !important;
    float: none !important;
    display: none !important; 
    box-shadow: none !important;
    background: transparent !important;
    padding: 2px 0 2px 28px !important;
    border: none !important;
    width: 100% !important;
    margin: 0 !important;
    transform: none !important;
}

#navigation .navigation-menu .dropdown-menu.show,
#navigation .navigation-menu .nav-item.show > .dropdown-menu {
    display: block !important;
}

#navigation .navigation-menu .dropdown-menu li a {
    padding: 3px 10px !important; /* Top/Bottom padding kam (3px), Left/Right pehle jaisi (10px) */
    margin-bottom: 1px !important;
    color: #6b7280 !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    border-radius: 6px !important;
    display: block !important;
    transition: all 0.2s ease !important;
}

#navigation .navigation-menu .dropdown-menu li a:hover {
    color: #0d6efd !important;
    background: #f8f9fa !important;
}

/* Toggle Hamburger */
.custom-navbar-toggle {
    display: block !important;
    width: 44px !important;
    height: 44px !important;
    padding: 0 !important;
    position: relative !important;
    margin-left: 10px !important;
    cursor: pointer !important;
}
.custom-navbar-toggle .lines {
    width: 20px !important;
    height: 15px !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    display: block !important;
}
.custom-navbar-toggle .lines span {
    height: 2px !important;
    width: 20px !important;
    background-color: #303e67 !important;
    display: block !important;
    margin-bottom: 4px !important;
    transition: all 0.3s ease !important;
}
.custom-navbar-toggle .lines span:last-child {
    margin-bottom: 0 !important;
}
/* Removed sidebar-collapsed CSS */

/* =========================================================
   MOBILE OVERRIDES (Slide-in Drawer)
   ========================================================= */
@media (max-width: 991.98px) {
    #navigation {
        top: 0 !important;
        left: -280px !important;
        width: 280px !important;
        height: 100vh !important;
        z-index: 9999 !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }
    
    #navigation.drawer-open {
        left: 0 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }
    
    .page-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .custom-navbar-toggle.open .lines span:nth-child(1) {
        transform: rotate(45deg) translate(4px, 4px) !important;
    }
    .custom-navbar-toggle.open .lines span:nth-child(2) {
        opacity: 0 !important;
    }
    .custom-navbar-toggle.open .lines span:nth-child(3) {
        transform: rotate(-45deg) translate(4px, -4px) !important;
    }
}
</style>

<script>
function customToggleMenu(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    var nav = document.getElementById("navigation");
    var backdrop = document.getElementById("menuBackdrop");
    var toggleBtn = document.getElementById("customMobileToggle");
    
    if (nav.classList.contains("drawer-open")) {
        nav.classList.remove("drawer-open");
        backdrop.classList.remove("show");
        toggleBtn?.classList.remove("open");
    } else {
        nav.classList.add("drawer-open");
        backdrop.classList.add("show");
        toggleBtn?.classList.add("open");
    }
}


</script>