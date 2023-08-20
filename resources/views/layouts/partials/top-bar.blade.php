<!-- LOGO -->
<div class="brand">
    <a href="index.html" class="logo">
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

    <div class="navbar-custom-menu active">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu active">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>CRM Management</span>
                    </a>
                    <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
                        <li>
                            <a href="{{ route('users.index') }}" class="dropdown-item">
                                Users
                            </a>
                        </li> 
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Sales
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('leads.index') }}" class="dropdown-item ">Leads</a>
                                </li>
                                <li>
                                    <a href="{{ route('lead-statuses.index') }}" class="dropdown-item ">Invoices</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-methods.index') }}" class="dropdown-item ">Projects</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-languages.index') }}" class="dropdown-item ">Contact Language</a>
                                </li>
                            </ul>
                        </li>                    
                    </ul><!--end submenu-->
                </li><!--end nav-item-->
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Fields Management</span>
                    </a>
                    <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Leads
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('lead-sources.index') }}" class="dropdown-item ">Lead Source</a>
                                </li>
                                <li>
                                    <a href="{{ route('lead-statuses.index') }}" class="dropdown-item ">Lead Status</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-methods.index') }}" class="dropdown-item ">Contact Method</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-languages.index') }}" class="dropdown-item ">Contact Language</a>
                                </li>
                            </ul>
                        </li> 
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Invoices
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('invoice-types.index') }}" class="dropdown-item ">Invoice Type</a>
                                </li>
                                <li>
                                    <a href="{{ route('invoice-statuses.index') }}" class="dropdown-item ">Invoice Status</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Payments
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('bill-types.index') }}" class="dropdown-item ">Bill Type</a>
                                </li>
                                <li>
                                    <a href="{{ route('bill-statuses.index') }}" class="dropdown-item ">Bill Status</a>
                                </li>
                                <li>
                                    <a href="{{ route('payment-methods.index') }}" class="dropdown-item ">Payment Method</a>
                                </li>
                                <li>
                                    <a href="{{ route('payment-statuses.index') }}" class="dropdown-item ">Payment Status</a>
                                </li>
                            </ul>
                        </li> 
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Projects
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('project-types.index') }}" class="dropdown-item ">Project Type</a>
                                </li>
                                <li>
                                    <a href="{{ route('project-statuses.index') }}" class="dropdown-item ">Project Status</a>
                                </li>
                            </ul>
                        </li> 
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Inventory
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('inventory-types.index') }}" class="dropdown-item ">Inventory Type</a>
                                </li>
                                <li>
                                    <a href="{{ route('inventory-statuses.index') }}" class="dropdown-item ">Inventory Status</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Employee
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('employee-types.index') }}" class="dropdown-item ">Employee Type</a>
                                </li>
                                <li>
                                    <a href="{{ route('blood-groups.index') }}" class="dropdown-item ">Blood Group</a>
                                </li>
                                <li>
                                    <a href="{{ route('genders.index') }}" class="dropdown-item ">Gender</a>
                                </li>
                                <li>
                                    <a href="{{ route('designations.index') }}" class="dropdown-item ">Designation</a>
                                </li>
                                <li>
                                    <a href="{{ route('departments.index') }}" class="dropdown-item ">Department</a>
                                </li>
                                <li>
                                    <a href="{{ route('skills.index') }}" class="dropdown-item ">Skills</a>
                                </li>
                            </ul>
                        </li> 
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                Vendor
                            </a>
                            <ul class="dropdown-menu animate slideIn">
                                <li>
                                    <a href="{{ route('vendor-types.index') }}" class="dropdown-item ">Vendor Type</a>
                                </li>
                                <li>
                                    <a href="{{ route('vendor-statuses.index') }}" class="dropdown-item ">Vendor Status</a>
                                </li>
                            </ul>
                        </li> 
                        <li>
                            <a href="apps-chat.html" class="dropdown-item">
                                Example
                            </a>
                        </li>                    
                    </ul><!--end submenu-->
                </li><!--end nav-item-->
                
                @if (Auth::user()->hasPermission('admin-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Admin Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('manager-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Manager Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('supervisor-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Supervisor Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('accounts-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Accounts Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('hr-menu'))
                <li class="nav-item">
                    <a href="" nav-link>HR Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('employee-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Employee Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('vendor-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Vendor Menu</a>
                </li>
                @endif

                @if (Auth::user()->hasPermission('client-menu'))
                <li class="nav-item">
                    <a href="" nav-link>Client Menu</a>
                </li>
                @endif
            </ul><!-- End navigation menu -->
        </div> <!-- end navigation -->
    </div>
    <!-- Navbar -->
</nav>
<!-- end navbar-->
@include('notify::components.notify')