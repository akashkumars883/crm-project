@auth
<div class="sidebar-wrapper" id="sidebar-wrapper">
    <div id="navigation">
        <!-- LOGO -->
        <div class="brand border-bottom">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('assets/images/logo.webp') }}" alt="logo-large" class="logo-lg">
            </a>
        </div>
        
        <!-- Mobile Close Button and Header -->
        <div class="mobile-menu-header d-flex d-lg-none justify-content-between align-items-center border-bottom">
            <h6 class="fw-bold mb-0 text-dark"><i class="ti ti-menu-2 me-2 text-primary"></i>Menu</h6>
            <button type="button" class="btn-close" onclick="customToggleMenu()" style="background-color: transparent; border: none; font-size: 1.25rem; font-weight: bold; color: #495057;">✕</button>
        </div>

        <!-- Navigation Menu-->
        <div class="menu-content">
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
        </div>
    </div> <!-- end navigation -->
</div>
@endauth
