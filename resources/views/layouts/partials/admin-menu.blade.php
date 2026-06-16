<ul class="navigation-menu flex-grow-1 mb-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="ti ti-dashboard menu-icon me-2"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if(Auth::user()->hasRole('super-admin'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.companies.index') }}">
            <i class="ti ti-building menu-icon me-2"></i>
            <span>Registered Companies</span>
        </a>
    </li>
    @endif

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="authMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-users menu-icon me-2"></i>
            <span>Authentication</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="authMenu">
            <li><a href="{{ route('users.index') }}" class="dropdown-item">Users</a></li>
            <li><a href="{{ route('customers.index') }}" class="dropdown-item">Customers</a></li>
            <li><a href="{{ route('employee-users.index') }}" class="dropdown-item">Employee</a></li>
            <li><a href="{{ route('vendor-users.index') }}" class="dropdown-item">Vendors</a></li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="salesMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-currency-dollar menu-icon me-2"></i>
            <span>Sales</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="salesMenu">
            <li><a href="{{ route('leads.index') }}" class="dropdown-item">Leads</a></li>
            <li><a href="{{ route('invoices.index') }}" class="dropdown-item">Invoices</a></li>
            <li><a href="{{ route('projects.index') }}" class="dropdown-item">Projects</a></li>
            <li><a href="{{ route('activities.index') }}" class="dropdown-item">Activities</a></li>
            <li><a href="{{ route('attachments.index') }}" class="dropdown-item">Attachments</a></li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="hrMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-user menu-icon me-2"></i>
            <span>Human Resource</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="hrMenu">
            <li><a href="{{ route('employees.index') }}" class="dropdown-item">Employees</a></li>
            <li><a href="{{ route('attendance-records.index') }}" class="dropdown-item">Attendance Records</a></li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="accountsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-receipt menu-icon me-2"></i>
            <span>Accounts</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="accountsMenu">
            {{-- <li><a href="{{ route('employee-bank-accounts.index') }}" class="dropdown-item">Employee Bank Accounts</a></li> --}}
            <li><a href="{{ route('payments.index') }}" class="dropdown-item">Payments</a></li>
            <li><a href="{{ route('bills.index') }}" class="dropdown-item">Bills</a></li>
            <li><a href="{{ route('expenses.index') }}" class="dropdown-item">Daily Expenses</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="{{ route('gst.dashboard') }}" class="dropdown-item">GST Reports</a></li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="vendorsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-truck menu-icon me-2"></i>
            <span>Vendors & Inventory</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="vendorsMenu">
            <li><a href="{{ route('vendors.index') }}" class="dropdown-item">Vendors</a></li>
            <li><a href="{{ route('inventories.index') }}" class="dropdown-item">Inventories</a></li>
        </ul>
    </li>

    {{-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ticketsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-ticket menu-icon me-2"></i>
            <span>Tickets</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="ticketsMenu">
            <li><a href="{{ route('tickets.index') }}" class="dropdown-item">Tickets</a></li>
        </ul>
    </li> --}}

    </ul>
    
    <ul class="navigation-menu mt-auto mb-0 pt-3 border-top">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="fieldsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-settings menu-icon me-2"></i>
            <span>Settings & Fields</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="fieldsMenu">
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Leads Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('lead-sources.index') }}" class="dropdown-item">Lead Source</a></li>
                    <li><a href="{{ route('lead-statuses.index') }}" class="dropdown-item">Lead Status</a></li>
                    <li><a href="{{ route('contact-methods.index') }}" class="dropdown-item">Contact Method</a></li>
                    <li><a href="{{ route('contact-languages.index') }}" class="dropdown-item">Contact Language</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Invoices Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('invoice-types.index') }}" class="dropdown-item">Invoice Type</a></li>
                    <li><a href="{{ route('invoice-statuses.index') }}" class="dropdown-item">Invoice Status</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Payments Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('bill-types.index') }}" class="dropdown-item">Bill Type</a></li>
                    <li><a href="{{ route('bill-statuses.index') }}" class="dropdown-item">Bill Status</a></li>
                    <li><a href="{{ route('payment-methods.index') }}" class="dropdown-item">Payment Method</a></li>
                    <li><a href="{{ route('payment-statuses.index') }}" class="dropdown-item">Payment Status</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Projects Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('project-types.index') }}" class="dropdown-item">Project Type</a></li>
                    <li><a href="{{ route('project-statuses.index') }}" class="dropdown-item">Project Status</a></li>
                    <li><a href="{{ route('attachment-types.index') }}" class="dropdown-item">Attachment Types</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Inventory Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('inventory-types.index') }}" class="dropdown-item">Inventory Type</a></li>
                    <li><a href="{{ route('inventory-statuses.index') }}" class="dropdown-item">Inventory Status</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Employee Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('attendance-types.index') }}" class="dropdown-item">Attendance Type</a></li>
                    <li><a href="{{ route('attendance-statuses.index') }}" class="dropdown-item">Attendance Status</a></li>
                    <li><a href="{{ route('employee-types.index') }}" class="dropdown-item">Employee Type</a></li>
                    {{-- <li><a href="{{ route('blood-groups.index') }}" class="dropdown-item">Blood Group</a></li>
                    <li><a href="{{ route('genders.index') }}" class="dropdown-item">Gender</a></li> --}}
                    <li><a href="{{ route('designations.index') }}" class="dropdown-item">Designation</a></li>
                    <li><a href="{{ route('departments.index') }}" class="dropdown-item">Department</a></li>
                    {{-- <li><a href="{{ route('skills.index') }}" class="dropdown-item">Skills</a></li> --}}
                </ul>
            </li>
            <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Vendor Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('vendor-types.index') }}" class="dropdown-item">Vendor Type</a></li>
                    <li><a href="{{ route('vendor-statuses.index') }}" class="dropdown-item">Vendor Status</a></li>
                </ul>
            </li>
            {{-- <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Ticket/Activity Fields</a>
                <ul class="dropdown-menu animate slideIn">
                    <li><a href="{{ route('activity-types.index') }}" class="dropdown-item">Activity Type</a></li>
                    <li><a href="{{ route('ticket-categories.index') }}" class="dropdown-item">Ticket Category</a></li>
                </ul>
            </li> --}}
        </ul>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="/laratrust">Roles/Permissions</a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
            <i class="ti ti-power menu-icon me-2 text-danger"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>