<ul class="navigation-menu flex-grow-1 mb-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="ti ti-dashboard menu-icon me-2"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('vBills') }}">
            <i class="ti ti-receipt menu-icon me-2"></i>
            <span>Bills</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('vInventories') }}">
            <i class="ti ti-truck menu-icon me-2"></i>
            <span>Inventories</span>
        </a>
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