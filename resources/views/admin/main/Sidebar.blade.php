<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <span class="logo-dark">
            <h2 class="mt-2">
                <img src="{{ url('public') }}/vivaceLogo (1).png" alt="Vivace Logo" class="w-100">
            </h2>
        </span>
        <span class="logo-light">
            <h2 class="mt-2">
                <img src="{{ url('public') }}/vivaceLogo (1).png" alt="Vivace Logo" class="w-100">
            </h2>
        </span>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- PRODUCT MANAGEMENT SECTION -->
            <li class="menu-title">PRODUCT MANAGEMENT</li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarProducts">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Products</span>
                </a>
                <div class="collapse" id="sidebarProducts">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('product.index') }}">Product List</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('collections.index') }}">Collections</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('brand.index') }}">Brands</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('size.index') }}">Sizes</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('color.index') }}">Colors</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('tag.index') }}">Tags</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#Categories" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="Categories">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Categories</span>
                </a>
                <div class="collapse" id="Categories">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('category.index') }}">All Categories</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('subcategories.index') }}">Sub Categories</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- ORDER MANAGEMENT SECTION -->
            <li class="menu-title">ORDER MANAGEMENT</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Website Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('manual.orders.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:document-add-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Manual Orders</span>
                </a>
            </li>

            <!-- CUSTOMER MANAGEMENT SECTION -->
            <li class="menu-title">CUSTOMER MANAGEMENT</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:user-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Customers</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#Coupons" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="Coupons">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:ticket-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Coupons</span>
                </a>
                <div class="collapse" id="Coupons">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('coupon.index') }}">All Coupons</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('coupon.create') }}">Add Coupon</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- WEBSITE MANAGEMENT SECTION -->
            <li class="menu-title">WEBSITE MANAGEMENT</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.contact') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-round-call-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Contact Queries</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#BannerSection" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="BannerSection">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:gallery-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Banners</span>
                </a>
                <div class="collapse" id="BannerSection">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('banner.create') }}">Add Hero Banner</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('banner.index') }}">Live Hero Banners</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('extra-banner.create') }}">Add Banners</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</div>
