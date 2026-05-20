<header class="vv-topbar" id="vvTopbar">
    <div class="vv-topbar-left">
        {{-- Mobile hamburger --}}
        <button class="button-toggle-menu vv-hamburger" title="Menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        {{-- Page title --}}
        <div class="vv-topbar-title">
            @yield('topbar-text')
        </div>
    </div>

    <div class="vv-topbar-right">

        {{-- View site --}}
        <a href="{{ route('website.home') }}" target="_blank" class="vv-tb-btn" title="View Website">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
        </a>

        {{-- Settings --}}
        <a href="{{ route('admin.settings') }}" class="vv-tb-btn" title="Settings">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
        </a>

        {{-- Admin dropdown --}}
        <div class="vv-tb-user" id="vvUserMenu">
            <button class="vv-tb-avatar" id="vvUserBtn">
                <span class="vv-avatar-initials">A</span>
                <span class="vv-avatar-name">Admin</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="vv-user-dropdown" id="vvUserDropdown">
                <div class="vv-dropdown-header">
                    <div class="vv-dh-avatar">A</div>
                    <div>
                        <div class="vv-dh-name">Administrator</div>
                        <div class="vv-dh-role">Super Admin</div>
                    </div>
                </div>
                <div class="vv-dropdown-divider"></div>
                <a href="{{ route('admin.settings') }}" class="vv-dropdown-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    Settings
                </a>
                <div class="vv-dropdown-divider"></div>
                <a href="{{ route('admin.logout') }}" class="vv-dropdown-item vv-dropdown-danger">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </a>
            </div>
        </div>

    </div>
</header>

<style>
/* ===== VIVACE TOPBAR ===== */
.vv-topbar {
    position: fixed;
    top: 0;
    left: var(--sb-width, 240px);
    right: 0;
    height: 60px;
    background: #ffffff;
    border-bottom: 1px solid #e8ecf0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    z-index: 1030;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    transition: left 0.25s ease;
}

.vv-topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.vv-hamburger {
    display: none;
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    transition: background 0.2s;
}
.vv-hamburger:hover { background: #f1f5f9; color: #1e293b; }

.vv-topbar-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.vv-topbar-right {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Icon buttons */
.vv-tb-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px; height: 36px;
    border-radius: 8px;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s;
    background: none;
    border: none;
    cursor: pointer;
}
.vv-tb-btn:hover { background: #f1f5f9; color: #1e293b; }

/* User button */
.vv-tb-user { position: relative; margin-left: 8px; }
.vv-tb-avatar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 5px 10px;
    cursor: pointer;
    transition: all 0.2s;
    color: #374151;
}
.vv-tb-avatar:hover { background: #f8fafc; border-color: #cbd5e1; }

.vv-avatar-initials {
    width: 28px; height: 28px;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: white;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
}
.vv-avatar-name { font-size: 0.82rem; font-weight: 600; color: #374151; }

/* Dropdown */
.vv-user-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 220px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    z-index: 9999;
    overflow: hidden;
}
.vv-user-dropdown.show { display: block; }

.vv-dropdown-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    background: #f8fafc;
}
.vv-dh-avatar {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    color: white;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.875rem;
    font-weight: 700;
    flex-shrink: 0;
}
.vv-dh-name { font-size: 0.875rem; font-weight: 700; color: #1e293b; }
.vv-dh-role { font-size: 0.75rem; color: #94a3b8; }

.vv-dropdown-divider { height: 1px; background: #f1f5f9; margin: 4px 0; }

.vv-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 16px;
    font-size: 0.85rem;
    color: #374151;
    text-decoration: none;
    transition: background 0.15s;
}
.vv-dropdown-item:hover { background: #f8fafc; color: #1e293b; }
.vv-dropdown-danger { color: #ef4444; }
.vv-dropdown-danger:hover { background: #fef2f2; color: #ef4444; }

/* Mobile */
@media (max-width: 991px) {
    .vv-topbar { left: 0; }
    .vv-hamburger { display: flex; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn      = document.getElementById('vvUserBtn');
    var dropdown = document.getElementById('vvUserDropdown');

    if (btn && dropdown) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });
        document.addEventListener('click', function() {
            dropdown.classList.remove('show');
        });
    }
});
</script>
