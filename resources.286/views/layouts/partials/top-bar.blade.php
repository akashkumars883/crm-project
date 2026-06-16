<!-- LOGO -->
<div class="brand">
    <a href="{{ route('dashboard') }}" class="logo">
        {{-- <span>
            <img src="{{ asset('assets/images/logo.webp') }}" alt="logo-small" class="logo-sm">
        </span> --}}
        <span>
            {{-- <img src="{{ asset('assets/images/logo.webp') }}" alt="logo-large" class="logo-lg logo-light"> --}}
            <img src="{{ asset('assets/images/logo.webp') }}" alt="logo-large" class="logo-lg logo-dark" style="height: 50px;">
        </span> 
    </a>
</div>
<!--end logo-->  
<!-- Navbar -->
<nav class="navbar-custom">    
    <ul class="list-unstyled topbar-nav float-end mb-0"> 
        @auth
        <li class="dropdown">
            <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="{{ Auth::user()->name }}"  class="me-3"/>
                    {{-- <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="profile-user" class="rounded-circle me-2 thumb-sm" /> --}}
                    <div>
                        <small class="d-none d-md-block font-11">{{ Auth::user()->email }}</small>
                        <span class="d-none d-md-block fw-semibold font-12">{{ Auth::user()->name }} <i
                                class="mdi mdi-chevron-down"></i></span>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                {{-- <a class="dropdown-item" href="#"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile</a> --}}
                {{-- <a class="dropdown-item" href="#"><i class="ti ti-settings font-16 me-1 align-text-bottom"></i> Settings</a> --}}
                {{-- <div class="dropdown-divider mb-0"></div> --}}
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
    </ul><!--end topbar-nav-->

    <div class="navbar-custom-menu">
        <div id="navigation">
            <!-- Navigation Menu-->
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
    <!-- Navbar -->
</nav>
<!-- end navbar-->
@include('notify::components.notify')