<ul class="navigation-menu" id="navigation-menu">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="ti ti-home-2 menu-icon"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('myProjects') }}">
            <i class="ti ti-building-skyscraper menu-icon"></i>
            <span>My Projects</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('myInvoices') }}">
            <i class="ti ti-file-invoice menu-icon"></i>
            <span>My Invoices</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('myPayments') }}">
            <i class="ti ti-cash menu-icon"></i>
            <span>My Payments</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('myTickets') }}">
            <i class="ti ti-ticket menu-icon"></i>
            <span>Support Tickets</span>
        </a>
    </li>
</ul>