@php
    $currentRoute = request()->route()->getName();
    function isActive($routes) {
        $current = request()->route()->getName();
        foreach ((array)$routes as $r) {
            if (str_starts_with($current, $r)) return true;
        }
        return false;
    }
@endphp

<aside class="vv-sidebar" id="vvSidebar">

    {{-- Logo --}}
    <div class="vv-sidebar-logo">
        <a href="{{ route('admin.dashboard') }}" class="vv-logo-link">
            <img src="{{ url('public') }}/admin-logo.png" alt="Vivace" class="vv-logo-img">
        </a>
        <button class="vv-sidebar-close" id="vvSidebarClose" title="Close">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Nav --}}
    <nav class="vv-nav" id="vvNav">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="vv-nav-item {{ isActive('admin.dashboard') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </span>
            <span class="vv-nav-text">Dashboard</span>
        </a>

        {{-- PRODUCTS --}}
        <div class="vv-nav-section">PRODUCTS</div>

        <div class="vv-nav-group {{ isActive(['product.','collections.','brand.','size.','color.','tag.']) ? 'open' : '' }}">
            <button class="vv-nav-item vv-nav-toggle {{ isActive(['product.','collections.','brand.','size.','color.','tag.']) ? 'active' : '' }}" data-target="grpProducts">
                <span class="vv-nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                </span>
                <span class="vv-nav-text">Products</span>
                <svg class="vv-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="vv-nav-sub" id="grpProducts">
                <a href="{{ route('product.index') }}"      class="vv-sub-item {{ isActive('product.index') ? 'active' : '' }}">Product List</a>
                <a href="{{ route('product.create') }}"     class="vv-sub-item {{ isActive('product.create') ? 'active' : '' }}">Add Product</a>
                <a href="{{ route('collections.index') }}"  class="vv-sub-item {{ isActive('collections.') ? 'active' : '' }}">Collections</a>
                <a href="{{ route('brand.index') }}"        class="vv-sub-item {{ isActive('brand.') ? 'active' : '' }}">Brands</a>
                <a href="{{ route('size.index') }}"         class="vv-sub-item {{ isActive('size.') ? 'active' : '' }}">Sizes</a>
                <a href="{{ route('color.index') }}"        class="vv-sub-item {{ isActive('color.') ? 'active' : '' }}">Colors</a>
                <a href="{{ route('tag.index') }}"          class="vv-sub-item {{ isActive('tag.') ? 'active' : '' }}">Tags</a>
            </div>
        </div>

        <div class="vv-nav-group {{ isActive(['category.','subcategories.']) ? 'open' : '' }}">
            <button class="vv-nav-item vv-nav-toggle {{ isActive(['category.','subcategories.']) ? 'active' : '' }}" data-target="grpCategories">
                <span class="vv-nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h8m-8 6h16"/></svg>
                </span>
                <span class="vv-nav-text">Categories</span>
                <svg class="vv-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="vv-nav-sub" id="grpCategories">
                <a href="{{ route('category.index') }}"      class="vv-sub-item {{ isActive('category.') ? 'active' : '' }}">All Categories</a>
                <a href="{{ route('subcategories.index') }}" class="vv-sub-item {{ isActive('subcategories.') ? 'active' : '' }}">Sub Categories</a>
            </div>
        </div>

        {{-- ORDERS --}}
        <div class="vv-nav-section">ORDERS</div>

        <a href="{{ route('orders.index') }}" class="vv-nav-item {{ isActive('orders.') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
            </span>
            <span class="vv-nav-text">Website Orders</span>
        </a>

        <a href="{{ route('manual.orders.index') }}" class="vv-nav-item {{ isActive('manual.orders') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
            </span>
            <span class="vv-nav-text">Manual Orders</span>
        </a>

        {{-- CUSTOMERS --}}
        <div class="vv-nav-section">CUSTOMERS</div>

        <a href="{{ route('user.index') }}" class="vv-nav-item {{ isActive('user.') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </span>
            <span class="vv-nav-text">Customers</span>
        </a>

        <a href="{{ route('coupon.index') }}" class="vv-nav-item {{ isActive('coupon.') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            </span>
            <span class="vv-nav-text">Coupons</span>
        </a>

        {{-- WEBSITE --}}
        <div class="vv-nav-section">WEBSITE</div>

        <a href="{{ route('reels.index') }}" class="vv-nav-item {{ isActive('reels.') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
            </span>
            <span class="vv-nav-text">Reels</span>
        </a>

        <div class="vv-nav-group {{ isActive(['banner.','extra-banner.']) ? 'open' : '' }}">
            <button class="vv-nav-item vv-nav-toggle {{ isActive(['banner.','extra-banner.']) ? 'active' : '' }}" data-target="grpBanners">
                <span class="vv-nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </span>
                <span class="vv-nav-text">Banners</span>
                <svg class="vv-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="vv-nav-sub" id="grpBanners">
                <a href="{{ route('banner.index') }}"        class="vv-sub-item {{ isActive('banner.index') ? 'active' : '' }}">Hero Banners</a>
                <a href="{{ route('banner.create') }}"       class="vv-sub-item {{ isActive('banner.create') ? 'active' : '' }}">Add Hero Banner</a>
                <a href="{{ route('extra-banner.create') }}" class="vv-sub-item {{ isActive('extra-banner.') ? 'active' : '' }}">Extra Banners</a>
            </div>
        </div>

        <a href="{{ route('admin.contact') }}" class="vv-nav-item {{ isActive('admin.contact') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </span>
            <span class="vv-nav-text">Contact Queries</span>
        </a>

        <a href="{{ route('admin.settings') }}" class="vv-nav-item {{ isActive('admin.settings') ? 'active' : '' }}">
            <span class="vv-nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            </span>
            <span class="vv-nav-text">Settings</span>
        </a>

    </nav>

    {{-- Bottom logout --}}
    <div class="vv-sidebar-footer">
        <a href="{{ route('admin.logout') }}" class="vv-logout">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Logout</span>
        </a>
    </div>

</aside>

{{-- Overlay for mobile --}}
<div class="vv-overlay" id="vvOverlay"></div>

@push('styles')
<style>
/* ===== VIVACE ADMIN SIDEBAR ===== */
:root {
    --sb-bg:       #0f1117;
    --sb-border:   #1e2130;
    --sb-accent:   #6366f1;
    --sb-accent2:  #818cf8;
    --sb-text:     #94a3b8;
    --sb-text-h:   #f1f5f9;
    --sb-section:  #475569;
    --sb-sub-bg:   #161922;
    --sb-width:    240px;
    --sb-radius:   8px;
}

/* Sidebar */
.vv-sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--sb-width);
    height: 100vh;
    background: var(--sb-bg);
    border-right: 1px solid var(--sb-border);
    display: flex;
    flex-direction: column;
    z-index: 1050;
    transition: transform 0.25s ease;
    overflow: hidden;
}

/* Logo */
.vv-sidebar-logo {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    height: 64px;
    border-bottom: 1px solid var(--sb-border);
    flex-shrink: 0;
}
.vv-logo-link { display: flex; align-items: center; }
.vv-logo-img  { height: 36px; width: auto; object-fit: contain; }
.vv-sidebar-close {
    display: none;
    background: none; border: none;
    color: var(--sb-text); cursor: pointer; padding: 4px;
    border-radius: 4px; transition: color 0.2s;
}
.vv-sidebar-close:hover { color: var(--sb-text-h); }

/* Nav scroll area */
.vv-nav {
    flex: 1; overflow-y: auto; overflow-x: hidden;
    padding: 12px 0 8px;
    scrollbar-width: thin;
    scrollbar-color: var(--sb-border) transparent;
}
.vv-nav::-webkit-scrollbar { width: 4px; }
.vv-nav::-webkit-scrollbar-track { background: transparent; }
.vv-nav::-webkit-scrollbar-thumb { background: var(--sb-border); border-radius: 4px; }

/* Section label */
.vv-nav-section {
    font-size: 0.65rem; font-weight: 700; letter-spacing: 1.2px;
    color: var(--sb-section);
    padding: 16px 20px 6px;
    text-transform: uppercase;
}

/* Nav item */
.vv-nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 20px;
    color: var(--sb-text);
    text-decoration: none;
    font-size: 0.875rem; font-weight: 500;
    transition: all 0.18s;
    cursor: pointer; background: none; border: none;
    width: 100%; text-align: left; position: relative;
}
.vv-nav-item:hover { color: var(--sb-text-h); background: rgba(99,102,241,0.08); }
.vv-nav-item.active { color: var(--sb-accent2); background: rgba(99,102,241,0.12); }
.vv-nav-item.active::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--sb-accent);
    border-radius: 0 2px 2px 0;
}

/* Icon */
.vv-nav-icon {
    width: 20px; height: 20px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; opacity: 0.75;
}
.vv-nav-item:hover .vv-nav-icon,
.vv-nav-item.active .vv-nav-icon { opacity: 1; }

/* Chevron */
.vv-chevron { margin-left: auto; transition: transform 0.2s; opacity: 0.5; flex-shrink: 0; }
.vv-nav-group.open > .vv-nav-toggle .vv-chevron { transform: rotate(180deg); }

/* Sub menu */
.vv-nav-sub {
    display: none;
    background: var(--sb-sub-bg);
    border-left: 2px solid var(--sb-border);
    margin: 0 0 4px 30px;
    border-radius: 0 0 var(--sb-radius) var(--sb-radius);
}
.vv-nav-group.open .vv-nav-sub { display: block; }

.vv-sub-item {
    display: block; padding: 7px 16px;
    color: var(--sb-text); font-size: 0.82rem;
    text-decoration: none; transition: all 0.15s;
    border-radius: 4px; margin: 2px 4px;
}
.vv-sub-item:hover { color: var(--sb-text-h); background: rgba(99,102,241,0.08); }
.vv-sub-item.active { color: var(--sb-accent2); font-weight: 600; }

/* Footer */
.vv-sidebar-footer {
    padding: 12px 16px;
    border-top: 1px solid var(--sb-border);
    flex-shrink: 0;
}
.vv-logout {
    display: flex; align-items: center; gap: 8px;
    color: #ef4444; font-size: 0.875rem; font-weight: 500;
    text-decoration: none; padding: 8px 12px;
    border-radius: var(--sb-radius); transition: background 0.2s;
}
.vv-logout:hover { background: rgba(239,68,68,0.1); color: #ef4444; }

/* Overlay */
.vv-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.5); z-index: 1040;
}

/* Mobile */
@media (max-width: 991px) {
    .vv-sidebar { transform: translateX(-100%); }
    .vv-sidebar.open { transform: translateX(0); }
    .vv-sidebar-close { display: flex; }
    .vv-overlay.show { display: block; }
}
</style>
@endpush


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle groups
    document.querySelectorAll('.vv-nav-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var group = this.closest('.vv-nav-group');
            group.classList.toggle('open');
        });
    });

    // Mobile open
    var toggleBtn = document.querySelector('.button-toggle-menu');
    var sidebar   = document.getElementById('vvSidebar');
    var overlay   = document.getElementById('vvOverlay');
    var closeBtn  = document.getElementById('vvSidebarClose');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
        });
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    }
    if (closeBtn)  closeBtn.addEventListener('click', closeSidebar);
    if (overlay)   overlay.addEventListener('click', closeSidebar);
});
</script>
