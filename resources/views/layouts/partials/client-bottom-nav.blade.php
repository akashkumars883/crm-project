{{-- Client Bottom Navigation Bar — only renders on mobile (<992px) --}}
@auth
@if(Auth::user()->hasRole('client'))
<nav class="client-bottom-nav d-lg-none">
    <a href="{{ route('dashboard') }}"
       class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="ti ti-home-2"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('myProjects') }}"
       class="bottom-nav-item {{ request()->routeIs('myProjects*') ? 'active' : '' }}">
        <i class="ti ti-building-skyscraper"></i>
        <span>Projects</span>
    </a>
    <a href="{{ route('myInvoices') }}"
       class="bottom-nav-item {{ request()->routeIs('myInvoice*') ? 'active' : '' }}">
        <i class="ti ti-file-invoice"></i>
        <span>Invoices</span>
    </a>
    <a href="{{ route('myPayments') }}"
       class="bottom-nav-item {{ request()->routeIs('myPayments') ? 'active' : '' }}">
        <i class="ti ti-cash"></i>
        <span>Payments</span>
    </a>
    <a href="{{ route('myTickets') }}"
       class="bottom-nav-item {{ request()->routeIs('myTickets') || request()->routeIs('createTicket') || request()->routeIs('storeTicket') ? 'active' : '' }}">
        <i class="ti ti-ticket"></i>
        <span>Support</span>
    </a>
</nav>

<style>
:root { --bottom-h: 68px; }
.client-bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: var(--bottom-h);
    background: #fff;
    border-top: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-around;
    z-index: 9990;
    box-shadow: 0 -4px 20px rgba(0,0,0,.08);
    padding: 0 8px;
    padding-bottom: env(safe-area-inset-bottom);
}
.bottom-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    text-decoration: none;
    color: #9ca3af;
    font-size: 10px;
    font-weight: 600;
    padding: 8px 10px;
    border-radius: 12px;
    transition: color .2s, background .2s;
    flex: 1;
    max-width: 72px;
}
.bottom-nav-item i { font-size: 22px; line-height: 1; }
.bottom-nav-item.active { color: #3b5bdb; background: rgba(59,91,219,.08); }
.bottom-nav-item:hover  { color: #3b5bdb; }

/* Add bottom padding to page content so content isn't hidden under nav */
@media (max-width: 991.98px) {
    .page-content-tab,
    .page-wrapper .page-content-tab,
    .cd-page,
    .inv-page,
    .profile-page,
    .ticket-page {
        padding-bottom: calc(var(--bottom-h) + 16px) !important;
    }
}
</style>
@endif
@endauth
