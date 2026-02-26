<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QwickReach</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --brand-navy: #1A1A3E;
            --brand-purple: #5B5BDB;
            --brand-lavender: #F0F0FA;
            --brand-card: #FFFFFF;
            --brand-border: #E5E7EB;
            --brand-muted: #6B7280;
            --ink: #111827;
            --surface: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F3F4F6;
            color: var(--ink);
            -webkit-tap-highlight-color: transparent;
            overscroll-behavior: none;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .app-shell {
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
            background: var(--surface);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        /* ── TOP HEADER ── */
        .top-header {
            position: sticky;
            top: 0;
            z-index: 50;
            width: 100%;
            max-width: 430px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--brand-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
        }

        .header-menu-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid var(--brand-border);
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--brand-navy);
            flex-shrink: 0;
        }

        .header-menu-btn:active {
            transform: scale(0.92);
            background: var(--brand-lavender);
        }

        /* LOGO FIX: Removed stretched Syne font, added nowrap so it doesn't squish */
        .header-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 21px;
            font-weight: 800;
            color: var(--brand-navy);
            letter-spacing: -0.5px;
            white-space: nowrap;
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        .header-brand span {
            color: var(--brand-purple);
        }

        .header-bell-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid var(--brand-border);
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--brand-navy);
            flex-shrink: 0;
            position: relative;
        }

        .header-bell-btn:active {
            transform: scale(0.92);
            background: var(--brand-lavender);
        }

        .bell-count {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            background: var(--brand-purple);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* ── ANNOUNCEMENT PANEL ── */
        .announcement-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 400;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            backdrop-filter: blur(3px);
        }

        .announcement-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .announcement-panel {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 430px;
            background: #ffffff;
            z-index: 500;
            border-radius: 0 0 24px 24px;
            transform: translateY(-100%);
            transition: transform 0.38s cubic-bezier(0.34, 1.1, 0.64, 1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 80vh;
        }

        .announcement-panel.open {
            transform: translateY(0);
        }

        @media (min-width: 431px) {
            .announcement-panel {
                left: 50%;
                transform: translateX(-50%) translateY(-100%);
                right: auto;
            }

            .announcement-panel.open {
                transform: translateX(-50%) translateY(0);
            }
        }

        .announcement-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--brand-border);
            flex-shrink: 0;
        }

        .announcement-close-btn {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F3F4F6;
            border: none;
            cursor: pointer;
            color: var(--brand-navy);
            transition: all 0.2s ease;
        }

        /* ── BOTTOM NAV ── */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 430px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-top: 1px solid var(--brand-border);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 8px 0 14px;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.03);
            height: 70px;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 4px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            background: none;
            border: none;
            outline: none;
            flex: 1;
        }

        .nav-item:active {
            transform: scale(0.92);
        }

        .nav-item.active .nav-icon {
            color: var(--brand-navy);
            transform: translateY(-2px);
        }

        .nav-item.active .nav-label {
            color: var(--brand-navy);
            font-weight: 800;
        }

        .nav-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #9CA3AF;
        }

        .nav-icon svg {
            width: 22px;
            height: 22px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            color: #9CA3AF;
            transition: all 0.3s ease;
        }

        /* ── MENU DRAWER ── */
        .menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .menu-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .menu-drawer {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100dvh;
            background: #ffffff;
            z-index: 300;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.34, 1.1, 0.64, 1);
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .menu-drawer.open {
            transform: translateX(0);
        }

        @media (min-width: 431px) {
            .menu-drawer {
                left: 50%;
                transform: translateX(-215px) translateX(-100%);
            }

            .menu-drawer.open {
                transform: translateX(-215px) translateX(0);
            }
        }

        .drawer-scroll-area {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding-top: 10px;
        }

        .drawer-footer {
            flex-shrink: 0;
            padding: 16px 20px;
            border-top: 1px solid var(--brand-border);
            background: #ffffff;
        }

        .drawer-header {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--brand-border);
        }

        .drawer-close-btn {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F3F4F6;
            border: none;
            cursor: pointer;
            color: var(--brand-navy);
            transition: all 0.2s ease;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            color: var(--brand-navy);
            border-radius: 10px;
            margin: 0 12px 4px;
            transition: all 0.2s ease;
        }

        .menu-item:active,
        .menu-item:hover {
            background: var(--brand-lavender);
            color: var(--brand-purple);
        }

        .menu-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-navy);
            flex-shrink: 0;
        }

        .menu-item:hover .menu-icon,
        .menu-item:active .menu-icon {
            background: #ffffff;
            color: var(--brand-purple);
            box-shadow: 0 2px 8px rgba(91, 91, 219, 0.15);
        }

        .menu-icon svg {
            width: 16px;
            height: 16px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body>

    <div class="announcement-overlay" id="announcementOverlay" onclick="closeAnnouncement()"></div>

    <div class="announcement-panel" id="announcementPanel">
        <div class="announcement-header">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                    style="background: var(--brand-lavender);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" style="color: var(--brand-purple);">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke-linecap="round" />
                    </svg>
                </div>
                <span style="font-size: 15px; font-weight: 700; color: var(--brand-navy);">Notifications</span>
            </div>
            <button class="announcement-close-btn" onclick="closeAnnouncement()">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="drawer-scroll-area no-scrollbar">
            @forelse ($announcements ?? [] as $ann)
                <div class="px-4 py-2">
                    <div class="p-4 rounded-2xl bg-white border shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600">
                                📢 Announcement
                            </span>
                            <span
                                class="text-[10px] font-bold text-gray-400">{{ $ann->created_at->diffForHumans() }}</span>
                        </div>
                        @if ($ann->title)
                            <h4
                                style="font-size: 15px; font-weight: 700; color: var(--brand-navy); margin-bottom: 6px;">
                                {{ $ann->title }}</h4>
                        @endif
                        <p class="text-sm leading-relaxed text-gray-600">
                            {{ $ann->message }}</p>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="font-bold text-sm text-gray-400">No notifications yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="menu-overlay" id="menuOverlay" onclick="closeMenu()"></div>
    <div class="menu-drawer" id="menuDrawer">
        <div class="drawer-header">
            <span class="header-brand" style="font-size: 18px;">
                Qwick<span>Reach</span>
            </span>
            <button class="drawer-close-btn" onclick="closeMenu()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" />
                </svg>
            </button>
        </div>
        <div class="drawer-scroll-area">
            <div class="px-4 pb-2">
                <div class="flex items-center gap-3 p-3.5 rounded-xl border border-gray-100 shadow-sm bg-white">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-white text-base flex-shrink-0"
                        style="background: var(--brand-navy);">
                        {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'G', 0, 1)) }}</div>
                    <div>
                        <p class="font-bold text-sm" style="color: var(--brand-navy);">
                            {{ Auth::check() ? Auth::user()->name : 'Guest User' }}</p>
                        <p class="text-[11px] mt-0.5 text-gray-500">
                            {{ Auth::check() ? Auth::user()->email : 'Login to sync data' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <a href="{{ route('user.products') }}" class="menu-item">
                    <div class="menu-icon"><svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg></div>
                    Home
                </a>
                <a href="{{ route('user.new.orders.index') }}" class="menu-item">
                    <div class="menu-icon"><svg fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <rect width="7" height="7" x="3" y="3" rx="1.5" />
                            <rect width="7" height="7" x="14" y="3" rx="1.5" />
                            <rect width="7" height="7" x="3" y="14" rx="1.5" />
                            <path d="M14 14h7v7h-7z" stroke-linejoin="round" />
                        </svg></div>
                    My QRs
                </a>
                <a href="{{ route('user.checkout') }}" class="menu-item">
                    <div class="menu-icon"><svg fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                            <path d="M16 10a4 4 0 0 1-8 0" />
                        </svg></div>
                    Cart
                </a>
                <a href="{{ route('user.about.index') }}" class="menu-item">
                    <div class="menu-icon"><svg fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" stroke-linecap="round" />
                        </svg></div>
                    About Us
                </a>
                <a href="{{ route('user.privacy.index') }}" class="menu-item">
                    <div class="menu-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    Privacy Policy
                </a>

                {{-- <a href="{{ route('user.new.orders.index') }}" class="menu-item">
                    <div class="menu-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    My Orders & Payments
                </a> --}}

            </div>
        </div>
        <div class="drawer-footer">
            @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"
                        class="w-full py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95 border border-red-100"
                        style="background: #FEF2F2; color: #DC2626;"><svg width="16" height="16"
                            fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>Logout</button></form>
            @else
                <a href="/login"
                    class="w-full py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-95 shadow-md"
                    style="background: var(--brand-navy); color: #ffffff;">
                    Login
                </a>
            @endif
            <p class="text-center text-[10px] mt-4 font-bold text-gray-400">QwickReach v2.0 · © 2026</p>
        </div>
    </div>

    <div class="app-shell pb-22"> <!-- Adjusted bottom padding -->
        <header class="top-header">
            <button class="header-menu-btn" onclick="openMenu()"><svg width="20" height="20" fill="none"
                    stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" />
                </svg></button>
            <span class="header-brand">Qwick<span>Reach</span></span>
            <button class="header-bell-btn" onclick="openAnnouncement()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke-linecap="round" />
                </svg>
                @if (isset($announcements) && $announcements->count() > 0)
                    <span class="bell-count">{{ $announcements->count() }}</span>
                @endif
            </button>
        </header>

        @yield('content')

        <nav class="bottom-nav">
            <a href="{{ route('user.products') }}"
                class="nav-item {{ request()->routeIs('user.products') ? 'active' : '' }}">
                <div class="nav-icon"><svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg></div><span class="nav-label">Home</span>
            </a>
            <a href="{{ route('user.new.orders.index') }}"
                class="nav-item {{ request()->routeIs('user.new.orders.index') ? 'active' : '' }}">
                <div class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <rect width="7" height="7" x="3" y="3" rx="1.5" />
                        <rect width="7" height="7" x="14" y="3" rx="1.5" />
                        <rect width="7" height="7" x="3" y="14" rx="1.5" />
                        <path d="M14 14h7v7h-7z" stroke-linejoin="round" />
                    </svg></div><span class="nav-label">My QRs</span>
            </a>
            <a href="{{ route('user.checkout') }}"
                class="nav-item {{ request()->routeIs('user.checkout') ? 'active' : '' }}">
                <div class="nav-icon"><svg fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg></div><span class="nav-label">Cart</span>
            </a>
        </nav>
    </div>

    <!-- Alpine is needed for checkout -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        function openMenu() {
            document.getElementById('menuDrawer').classList.add('open');
            document.getElementById('menuOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            document.getElementById('menuDrawer').classList.remove('open');
            document.getElementById('menuOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function openAnnouncement() {
            document.getElementById('announcementPanel').classList.add('open');
            document.getElementById('announcementOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeAnnouncement() {
            document.getElementById('announcementPanel').classList.remove('open');
            document.getElementById('announcementOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeMenu();
                closeAnnouncement();
            }
        });
        let startX = 0;
        const drawer = document.getElementById('menuDrawer');
        drawer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        drawer.addEventListener('touchend', (e) => {
            if (startX - e.changedTouches[0].clientX > 80) closeMenu();
        });
        let startY = 0;
        const annPanel = document.getElementById('announcementPanel');
        annPanel.addEventListener('touchstart', (e) => {
            startY = e.touches[0].clientY;
        });
        annPanel.addEventListener('touchend', (e) => {
            if (startY - e.changedTouches[0].clientY < -80) closeAnnouncement();
        });
    </script>
</body>

</html>
