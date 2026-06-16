<ul class="navigation-menu flex-grow-1 mb-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="ti ti-dashboard menu-icon me-2"></i>
            <span>Dashboard</span>
        </a>
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
            <li><a href="{{ route('employee-bank-accounts.index') }}" class="dropdown-item">Employee Bank Accounts</a></li>
            <li><a href="{{ route('payments.index') }}" class="dropdown-item">Payments</a></li>
            <li><a href="{{ route('bills.index') }}" class="dropdown-item">Bills</a></li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="vendorsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-truck menu-icon me-2"></i>
            <span>Vendors</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="vendorsMenu">
            <li><a href="{{ route('vendors.index') }}" class="dropdown-item">Vendors</a></li>
            <li><a href="{{ route('inventories.index') }}" class="dropdown-item">Inventories</a></li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ticketsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-ticket menu-icon me-2"></i>
            <span>Tickets</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="ticketsMenu">
            <li><a href="{{ route('tickets.index') }}" class="dropdown-item">Tickets</a></li>
        </ul>
    </li>
</ul>

<ul class="navigation-menu mt-auto mb-0 pt-3 border-top">
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