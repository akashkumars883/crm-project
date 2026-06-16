<ul class="navigation-menu">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">Home</a>
    </li>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>Sales</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li>
                <a href="{{ route('leads.index') }}" class="dropdown-item ">Leads</a>
            </li>
            <li>
                <a href="{{ route('my-leads.index') }}" class="dropdown-item ">My Leads</a>
            </li>
            <li>
                <a href="{{ route('invoices.index') }}" class="dropdown-item ">Invoices</a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" class="dropdown-item ">Projects</a>
            </li>
            <li>
                <a href="{{ route('my-projects.index') }}" class="dropdown-item ">My Projects</a>
            </li>
            <li>
                <a href="{{ route('activities.index') }}" class="dropdown-item ">Activities</a>
            </li>
            <li>
                <a href="{{ route('attachments.index') }}" class="dropdown-item ">Attachments</a>
            </li>
        </ul><!--end submenu-->
    </li><!--end nav-item-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>Human Resource</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li>
                <a href="{{ route('employees.index') }}" class="dropdown-item ">Employees</a>
            </li>
            <li>
                <a href="{{ route('attendance-records.index') }}" class="dropdown-item ">Attendance Records</a>
            </li>
        </ul><!--end submenu-->
    </li><!--end nav-item-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>Accounts</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li>
                <a href="{{ route('employee-bank-accounts.index') }}" class="dropdown-item ">Employee Bank Accounts</a>
            </li>
            <li>
                <a href="{{ route('payments.index') }}" class="dropdown-item ">Payments</a>
            </li>
            <li>
                <a href="{{ route('bills.index') }}" class="dropdown-item ">Bills</a>
            </li>
        </ul><!--end submenu-->
    </li><!--end nav-item-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>Vendors</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li>
                <a href="{{ route('vendors.index') }}" class="dropdown-item ">Vendors</a>
            </li>
            <li>
                <a href="{{ route('inventories.index') }}" class="dropdown-item ">Inventories</a>
            </li>
        </ul><!--end submenu-->
    </li><!--end nav-item-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarApps" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span>Tickets</span>
        </a>
        <ul class="dropdown-menu animate slideIn" aria-labelledby="navbarApps"> 
            <li>
                <a href="{{ route('tickets.index') }}" class="dropdown-item ">Tickets</a>
            </li>
            <li>
                <a href="{{ route('my-tickets.index') }}" class="dropdown-item ">My Tickets</a>
            </li>
        </ul><!--end submenu-->
    </li><!--end nav-item-->
</ul><!-- End navigation menu -->