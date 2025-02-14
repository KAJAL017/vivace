<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <span class="logo-dark">
            <h2 class="mt-2"><img src="{{ url('public') }}/vivaceLogo (1).png" alt=""
                    class="w-100"></h2>
        </span>

        <span class="logo-light">
            <h2 class="mt-2"><img src="{{ url('public') }}/vivaceLogo (1).png"
                    alt="" class="w-100"></h2>
        </span>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">General</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarProducts">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Product Section</span>
                </a>
                <div class="collapse" id="sidebarProducts">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('product.create') }}">Upload Product</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('product.bulk.form') }}">Bulk Upload</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('product.index') }}">Product List</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('collections.index') }}">Product Collections</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('brand.index') }}">Brands</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('size.index') }}">Size</a>
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
                            <a class="sub-nav-link" href="{{ route('category.index') }}">Categories</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('category.create') }}">Add Main Category</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('subcategories.index') }}">Sub Categories</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('subcategories.create') }}">Add Sub Category</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#OrdersSection" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="OrdersSection">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Orders Section</span>
                </a>
                <div class="collapse" id="OrdersSection">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('latestOrder') }}">Latest Order</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('OngoingOrder') }}">Ongoing Order</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('CancelOrder') }}">Cancelled Order</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('DeliveredOrder') }}">Delivered Order</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('ManualOrder') }}">Manual Order</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link menu-arrow" href="#InvoiceSection" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="InvoiceSection">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:clipboard-text-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Invoice Section</span>
                </a>
                <div class="collapse" id="InvoiceSection">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('invoice.create') }}">Create</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="#">List</a>
                        </li>
                    </ul>
                </div>
            </li> --}}

            <li class="menu-title mt-2">Customer Base</li>


            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#Coupons" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="Coupons">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:leaf-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Coupon Section</span>
                </a>
                <div class="collapse" id="Coupons">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('coupon.index') }}">Our Coupons</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('coupon.create') }}">Add Coupons</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="mdi:user"></iconify-icon> </span>
                    <span class="nav-text">Customers</span>
                </a>
            </li>


            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">My Profile</span>
                </a>
            </li> --}}

            <li class="menu-title mt-2">Website Section</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.contact') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-round-call-outline"></iconify-icon>
                    </span>
                    <span class="nav-text">Contact Us Query</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#BannerSection" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="BannerSection">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:video-frame-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Banner Section</span>
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

        </ul>
    </div>
</div>
