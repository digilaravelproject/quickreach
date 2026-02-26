<aside class="sidebar" id="sidebar" :class="sidebarOpen ? 'mob-open' : ''">

    <button class="collapse-toggle" id="collapseBtn" onclick="toggleCollapse()" title="Toggle sidebar">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <div class="brand-wrap">
        <div class="brand-icon" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
            <svg fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
        </div>
        <span class="brand-name">QwickReach</span>
    </div>

    <div class="nav-scroll">
        <span class="nav-section">Main Menu</span>

        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tip="Dashboard">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="{{ route('admin.payments.index') }}"
            class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" data-tip="Payments">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </span>
            <span class="nav-label">Orders & Payments</span>
        </a>

        <a href="{{ route('admin.qr-codes.index') }}"
            class="nav-link {{ request()->routeIs('admin.qr-codes.*') ? 'active' : '' }}" data-tip="QR Inventory">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">QR Inventory</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-tip="Categories">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
            </span>
            <span class="nav-label">QR Categories</span>
        </a>

        <div class="nav-group">
            <div
                style="padding: 15px 20px 5px 20px; font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.7;">
                User Management
            </div>

            <a href="{{ route('admin.registrations.index') }}"
                class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}"
                data-tip="Qr Registration">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </span>
                <span class="nav-label">Qr Registration</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                data-tip="User Registration">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </span>
                <span class="nav-label">User Registration</span>
            </a>
        </div>
        <span class="nav-section">System</span>

        <a href="{{ route('admin.analytics') }}"
            class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" data-tip="Analytics">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 012 2h2a2 2 0 012-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">Analytics</span>
        </a>

        <a href="{{ route('admin.sliders.index') }}"
            class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" data-tip="Sliders">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">Sliders</span>
        </a>
        <a href="{{ route('admin.announcements.index') }}"
            class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}"
            data-tip="Notifications">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">Notifications</span>
        </a>
        <a href="{{ route('admin.about.edit') }}"
            class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}" data-tip="About Us">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">About Us</span>
        </a>
        <a href="{{ route('admin.privacy.edit') }}"
            class="nav-link {{ request()->routeIs('admin.privacy.*') ? 'active' : '' }}" data-tip="Privacy Policy">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">Privacy Policy</span>
        </a>
        <a href="{{ route('admin.contacts.index') }}"
            class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"
            data-tip="Contact Inquiries">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </span>
            <span class="nav-label">Inquiries</span>
        </a>

        <a href="#" class="nav-link" data-tip="Settings">
            <span class="nav-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                </svg>
            </span>
            <span class="nav-label">Settings</span>
        </a>
    </div>
</aside>
