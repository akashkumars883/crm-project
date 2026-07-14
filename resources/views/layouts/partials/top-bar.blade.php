<!-- Navbar -->
<nav class="navbar-custom w-100 m-0 p-0" style="border: none !important; box-shadow: none !important;">
    <div class="d-flex justify-content-between align-items-center w-100 m-0 p-0">
        <!-- Optional: Left Side Topbar Content (Search, etc.) -->
        <div class="topbar-left d-flex align-items-center">
            @auth
            <div class="d-inline-block d-lg-none me-3">
                <a class="custom-navbar-toggle" id="customMobileToggle" onclick="customToggleMenu(event)">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </div>
            <div class="app-search d-none d-md-block ms-2">
                <form action="{{ route('global.search') }}" method="get" class="position-relative">
                    <input type="text" name="q" class="form-control shadow-sm border-0" placeholder="Search leads, projects, tasks..." style="border-radius: 20px; padding-left: 35px; width: 300px; background-color: #f8fafc; font-size: 13px;">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y text-muted" style="left: 12px; font-size: 16px;"></i>
                </form>
            </div>
            @endauth
        </div>

        <ul class="list-unstyled topbar-nav mb-0 d-flex align-items-center m-0 p-0"> 
            @auth
            <li class="dropdown notification-list me-3">
                <a class="nav-link dropdown-toggle arrow-none text-dark" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-bell font-20"></i>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger rounded-pill noti-icon-badge position-absolute top-0 start-50 mt-1" style="font-size: 9px; padding: 2px 4px;">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg shadow-sm border-0 mt-2" style="border-radius: 8px; width: 320px;">
                    <div class="d-flex justify-content-between align-items-center m-0 py-2 px-3 border-bottom bg-light">
                        <h6 class="m-0">Notifications</h6>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-primary" style="font-size: 12px; text-decoration: none;">Mark all read</button>
                            </form>
                        @endif
                    </div>
                    <div class="notification-menu p-2" style="max-height: 250px; overflow-y: auto;">
                        @forelse(Auth::user()->unreadNotifications as $notification)
                            <a href="#" class="dropdown-item py-2 d-flex align-items-start">
                                <div class="avatar-md bg-soft-{{ $notification->data['iconColor'] ?? 'primary' }} text-{{ $notification->data['iconColor'] ?? 'primary' }} rounded-circle me-2 d-flex align-items-center justify-content-center"><i class="ti ti-{{ $notification->data['icon'] ?? 'bell' }} font-16"></i></div>
                                <div>
                                    <h6 class="m-0 font-13 fw-semibold">{{ $notification->data['title'] }}</h6>
                                    <p class="m-0 font-12 text-muted text-wrap" style="white-space: normal;">{{ $notification->data['message'] }}</p>
                                    <small class="text-muted" style="font-size: 10px;">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="ti ti-bell-off font-24 mb-2 d-block"></i>
                                <span style="font-size: 13px;">No new notifications</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </li>
            @if(!Auth::user()->hasRole('client'))
            <li class="d-none d-md-inline-block align-self-center me-3">
                <a class="btn btn-sm btn-outline-primary fw-semibold px-3 py-1.5" href="javascript:void(0);" onclick="startQuickTour()" style="font-size: 13px; border-radius: 20px; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.1);">
                    <i class="ti ti-help font-15 me-1 align-text-bottom"></i> Quick Tour
                </a>
            </li>
            @endif
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user d-flex align-items-center text-decoration-none m-0 p-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="border: none;">
                    @if(Auth::user()->avatar)
                        <img src="{{ \Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}" alt="Profile Avatar" class="rounded-circle thumb-sm" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid #e2e8f0;" />
                    @else
                        <div class="rounded-circle thumb-sm bg-soft-primary text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: bold; font-size: 16px; border: 2px solid #e2e8f0;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius: 8px;">
                     <a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="ti ti-user font-16 me-2 align-text-bottom text-muted"></i> My Account</a>
                     @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                     <a class="dropdown-item py-2" href="{{ route('profile.settings') }}"><i class="ti ti-building-skyscraper font-16 me-2 align-text-bottom text-muted"></i> Company Profile</a>
                     @endif
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti ti-power font-16 me-2 align-text-bottom"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @else
            <li>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            </li>
            @endauth
        </ul>
    </div>
</nav>
<!-- end navbar-->

@include('notify::components.notify')

@auth
<!-- Drawer Menu Backdrop Overlay -->
<div id="menuBackdrop" class="menu-backdrop-overlay" onclick="customToggleMenu(event)"></div>
@endauth

<script>
function customToggleMenu(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    var nav = document.getElementById("sidebar-wrapper");
    var backdrop = document.getElementById("menuBackdrop");
    var toggleBtn = document.getElementById("customMobileToggle");
    
    if (nav && nav.classList.contains("drawer-open")) {
        nav.classList.remove("drawer-open");
        if(backdrop) backdrop.classList.remove("show");
        if(toggleBtn) toggleBtn.classList.remove("open");
        document.body.classList.remove("sidebar-open");
    } else if (nav) {
        nav.classList.add("drawer-open");
        if(backdrop) backdrop.classList.add("show");
        if(toggleBtn) toggleBtn.classList.add("open");
        document.body.classList.add("sidebar-open");
    }
}
</script>