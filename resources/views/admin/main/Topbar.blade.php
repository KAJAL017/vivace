<header class="topbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="d-flex align-items-center">
                <!-- Menu Toggle Button -->
                <div class="topbar-item">
                    <button type="button" class="button-toggle-menu me-2">
                        <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

                <!-- Page Title -->
                <div class="topbar-item">
                    <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0">
                        <iconify-icon icon="solar:widget-5-bold-duotone" class="me-2"></iconify-icon>
                        @yield('topbar-text')
                    </h4>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- Settings -->
                <div class="topbar-item">
                    <a href="{{ route('admin.settings') }}" class="topbar-button" title="Settings">
                        <iconify-icon icon="solar:settings-bold-duotone" class="fs-22 align-middle"></iconify-icon>
                    </a>
                </div>

                <!-- User Profile -->
                <div class="dropdown topbar-item">
                    <a type="button" class="topbar-button" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle" width="32"
                                src="{{ admin_assets() }}/assets/images/users/avatar-1.jpg" alt="Admin Avatar">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Header -->
                        <h6 class="dropdown-header">
                            <iconify-icon icon="solar:user-bold-duotone" class="me-1"></iconify-icon>
                            Welcome Admin
                        </h6>
                        
                        <!-- Profile Link -->
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-user-circle text-muted fs-18 align-middle me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>

                        <!-- Settings Link -->
                        <a class="dropdown-item" href="{{ route('admin.settings') }}">
                            <i class="bx bx-cog text-muted fs-18 align-middle me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>

                        <div class="dropdown-divider my-1"></div>

                        <!-- Logout -->
                        <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                            <i class="bx bx-log-out fs-18 align-middle me-2"></i>
                            <span class="align-middle">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.badge-notification {
    position: absolute;
    top: -5px;
    right: -5px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.625rem;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-weight: 700;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}
</style>
