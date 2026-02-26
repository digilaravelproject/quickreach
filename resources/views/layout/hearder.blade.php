<header class="topbar">
    <div class="topbar-left">
        <button class="hamburger" onclick="openMobileSidebar()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <nav class="top-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ route('admin.analytics') }}"
                class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">Analytics</a>
            <a href="{{ route('admin.qr-codes.index') }}"
                class="{{ request()->routeIs('admin.qr-codes.*') ? 'active' : '' }}">Inventory</a>
        </nav>
    </div>

    <div class="topbar-right">
        <button class="icon-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke-width="2" />
                <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
            </svg>
        </button>

        <button class="icon-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="notif-dot"></span>
        </button>

        <button class="icon-btn hidden md:flex">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
            </svg>
        </button>

        <div style="height: 25px; width: 1px; background: var(--border); margin: 0 5px;"></div>

        <button class="avatar-btn" id="avatarBtn" onclick="toggleDrop()">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=000&color=fff&bold=true"
                alt="Avatar" />
        </button>

        <div class="profile-drop" id="profileDrop" style="display: none;">
            <div class="drop-user">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=000&color=fff&bold=true"
                    alt="" />
                <div>
                    <div>
                        <span class="drop-username">{{ auth()->user()->name }}</span>
                        <span class="pro-tag">PRO</span>
                    </div>
                    <div class="drop-email">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="drop-body">
                <a href="#" class="drop-item">
                    <div class="drop-item-left">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>Public Profile
                    </div>
                </a>

                <div class="drop-toggle-row">
                    <span class="drop-toggle-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>Dark Mode
                    </span>
                    <button class="toggle-pill" id="darkToggle" onclick="toggleDark()">
                        <span class="knob"></span>
                    </button>
                </div>
            </div>

            <div class="drop-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; border: none; background: transparent; text-align: left; color: var(--red); font-weight: 800; cursor: pointer; padding: 0;">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
