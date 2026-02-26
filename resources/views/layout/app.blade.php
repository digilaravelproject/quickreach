<!DOCTYPE html>
<html lang="en" id="html">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Page load hote hi check karo localStorage
        if (localStorage.getItem('dark-mode') === 'true' ||
            (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        /* ═══════════════════════════════════════════
   VARIABLES
═══════════════════════════════════════════ */
        :root {
            --font: 'Plus Jakarta Sans', sans-serif;
            --bg: #f3f5fb;
            --card: #ffffff;
            --card2: #f7f8fc;
            --border: #e8eaf2;
            --text: #0c0e16;
            --text2: #64748b;
            --text3: #94a3b8;
            --accent: #0c0e16;
            --green: #16a34a;
            --green-bg: #dcfce7;
            --red: #dc2626;
            --red-bg: #fee2e2;
            --amber: #d97706;
            --amber-bg: #fef3c7;
            --blue: #2563eb;
            --sidebar-width: 248px;
            --sidebar-collapsed: 68px;
            --topbar-h: 60px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .05), 0 2px 8px rgba(0, 0, 0, .05);
            --shadow: 0 1px 3px rgba(0, 0, 0, .06), 0 6px 20px rgba(0, 0, 0, .07);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, .15);
            --radius: 16px;
            --radius-sm: 10px;
        }

        html.dark {
            --bg: #0a0d17;
            --card: #111827;
            --card2: #1a2235;
            --border: #1e293b;
            --text: #f0f4ff;
            --text2: #94a3b8;
            --text3: #64748b;
            --accent: #f0f4ff;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .3), 0 2px 8px rgba(0, 0, 0, .3);
            --shadow: 0 1px 3px rgba(0, 0, 0, .35), 0 6px 20px rgba(0, 0, 0, .35);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, .6);
        }

        /* ═══════════════════════════════════════════
   BASE RESET
═══════════════════════════════════════════ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: var(--font);
            cursor: pointer;
            border: none;
            background: none;
        }

        input {
            font-family: var(--font);
        }

        canvas {
            display: block !important;
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        /* ═══════════════════════════════════════════
   APP SHELL
═══════════════════════════════════════════ */
        .app {
            display: flex;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* ═══════════════════════════════════════════
   MOBILE OVERLAY
═══════════════════════════════════════════ */
        .mob-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 998;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }

        .mob-overlay.show {
            display: block;
        }

        /* ═══════════════════════════════════════════
   SIDEBAR — smooth & proper
═══════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
            height: 100vh;
            background: var(--card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            z-index: 100;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: width;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        /* Text labels — fade + slide on collapse */
        .nav-label,
        .nav-section,
        .brand-name {
            opacity: 1;
            transform: translateX(0);
            transition: opacity 0.2s ease, transform 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
            flex-shrink: 1;
            min-width: 0;
        }

        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .nav-section,
        .sidebar.collapsed .brand-name {
            opacity: 0;
            transform: translateX(-6px);
            pointer-events: none;
        }

        /* collapsed: center icons */
        .sidebar.collapsed .brand-wrap {
            justify-content: center;
            padding: 0;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 10px 0;
        }

        /* Mobile sidebar — slide from left */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: var(--sidebar-width) !important;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                z-index: 999;
                box-shadow: var(--shadow-lg);
            }

            .sidebar.mob-open {
                transform: translateX(0);
            }

            .collapse-toggle {
                display: none !important;
            }
        }

        /* brand / logo area */
        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 11px;
            height: var(--topbar-h);
            padding: 0 16px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            overflow: hidden;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--text);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon svg {
            width: 18px;
            height: 18px;
            color: #fff;
        }

        html.dark .brand-icon svg {
            color: var(--bg);
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.4px;
        }

        /* collapse toggle button */
        .collapse-toggle {
            position: absolute;
            right: -13px;
            top: 76px;
            width: 26px;
            height: 26px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 101;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            transition: background 0.2s;
            cursor: pointer;
        }

        .collapse-toggle:hover {
            background: var(--card2);
        }

        .collapse-toggle svg {
            width: 12px;
            height: 12px;
            color: var(--text2);
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed .collapse-toggle svg {
            transform: rotate(180deg);
        }

        /* nav scroll container */
        .nav-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px 8px 16px;
        }

        /* nav section heading */
        .nav-section {
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text3);
            padding: 12px 10px 4px;
        }

        /* nav link */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            user-select: none;
            position: relative;
            transition: background 0.18s, color 0.18s;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-link:hover {
            background: var(--card2);
            color: var(--text);
        }

        .nav-link.active {
            background: var(--text);
            color: #fff;
        }

        html.dark .nav-link.active {
            background: var(--text);
            color: var(--bg);
        }

        .nav-link .nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-link .nav-icon svg {
            width: 17px;
            height: 17px;
        }

        /* Tooltip on collapsed (desktop only) */
        @media (min-width: 769px) {
            .sidebar.collapsed .nav-link:hover::after {
                content: attr(data-tip);
                position: absolute;
                left: calc(100% + 12px);
                top: 50%;
                transform: translateY(-50%);
                background: var(--text);
                color: #fff;
                font-size: 12px;
                font-weight: 500;
                padding: 5px 10px;
                border-radius: 7px;
                white-space: nowrap;
                z-index: 400;
                box-shadow: var(--shadow);
            }
        }

        /* ═══════════════════════════════════════════
   MAIN CONTENT AREA
═══════════════════════════════════════════ */
        .main-area {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        /* ═══════════════════════════════════════════
   TOPBAR
═══════════════════════════════════════════ */
        .topbar {
            height: var(--topbar-h);
            flex-shrink: 0;
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: relative;
            z-index: 50;
        }

        html.dark .topbar {
            background: rgba(17, 24, 39, .92);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hamburger {
            display: none;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            align-items: center;
            justify-content: center;
            color: var(--text2);
            transition: background 0.18s;
        }

        .hamburger:hover {
            background: var(--card2);
        }

        .hamburger svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .top-nav {
                display: none !important;
            }
        }

        .top-nav {
            display: flex;
            gap: 22px;
        }

        .top-nav a {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text2);
            transition: color 0.15s;
        }

        .top-nav a:hover,
        .top-nav a.active {
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 4px;
            position: relative;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text2);
            position: relative;
            transition: background 0.18s;
        }

        .icon-btn:hover {
            background: var(--card2);
        }

        .icon-btn svg {
            width: 17px;
            height: 17px;
        }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid var(--card);
        }

        .avatar-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid var(--border);
            overflow: hidden;
            cursor: pointer;
            padding: 0;
            transition: border-color 0.18s;
        }

        .avatar-btn:hover {
            border-color: var(--blue);
        }

        .avatar-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            background: #fef3c7;
        }

        /* ═══════════════════════════════════════════
   PROFILE DROPDOWN
═══════════════════════════════════════════ */
        .profile-drop {
            display: none;
            position: absolute;
            right: 0;
            top: calc(var(--topbar-h) + 2px);
            width: 280px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            overflow: hidden;
            animation: dropIn 0.16s ease;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: translateY(-8px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .drop-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        .drop-user img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fef3c7;
            flex-shrink: 0;
        }

        .drop-username {
            font-size: 14px;
            font-weight: 700;
        }

        .drop-email {
            font-size: 12px;
            color: var(--text3);
            margin-top: 1px;
        }

        .pro-tag {
            font-size: 10px;
            font-weight: 700;
            background: var(--text);
            color: #fff;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 6px;
            vertical-align: middle;
        }

        html.dark .pro-tag {
            background: #f1f5f9;
            color: #0a0d17;
        }

        .drop-body {
            padding: 6px;
        }

        .drop-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            transition: background 0.15s;
        }

        .drop-item:hover {
            background: var(--card2);
            color: var(--text);
        }

        .drop-item-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .drop-item-left svg {
            width: 15px;
            height: 15px;
            color: var(--text3);
        }

        .drop-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
        }

        .drop-toggle-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text2);
        }

        .drop-toggle-label svg {
            width: 15px;
            height: 15px;
            color: var(--text3);
        }

        .drop-footer {
            border-top: 1px solid var(--border);
            padding: 6px;
        }

        .drop-footer button {
            width: 100%;
            padding: 9px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: var(--text2);
            transition: background 0.15s;
        }

        .drop-footer button:hover {
            background: var(--card2);
        }

        /* toggle pill */
        .toggle-pill {
            width: 38px;
            height: 21px;
            border-radius: 20px;
            background: var(--border);
            position: relative;
            cursor: pointer;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .toggle-pill.on {
            background: #3b82f6;
        }

        .toggle-pill .knob {
            width: 17px;
            height: 17px;
            background: #fff;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: left 0.2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
        }

        .toggle-pill.on .knob {
            left: 19px;
        }

        /* ═══════════════════════════════════════════
   SCROLLABLE PAGE
═══════════════════════════════════════════ */
        .page-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 22px 22px 32px;
        }

        @media (max-width: 600px) {
            .page-scroll {
                padding: 14px 14px 24px;
            }
        }

        /* ═══════════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════════ */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 20px;
        }

        .page-title-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        h1.title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        @media (max-width: 500px) {
            h1.title {
                font-size: 20px;
            }
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            background: var(--green-bg);
            color: var(--green);
            padding: 3px 10px;
            border-radius: 20px;
        }

        .live-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--green);
            border-radius: 50%;
            animation: livePulse 1.6s infinite;
        }

        @keyframes livePulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .35;
            }
        }

        .page-subtitle {
            font-size: 12.5px;
            color: var(--text3);
            margin-top: 2px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--card);
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text2);
            transition: background 0.18s;
        }

        .btn-outline:hover {
            background: var(--card2);
        }

        .btn-outline svg {
            width: 14px;
            height: 14px;
        }

        .btn-solid {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: var(--text);
            color: #fff;
            font-size: 12.5px;
            font-weight: 700;
            transition: opacity 0.18s;
        }

        .btn-solid:hover {
            opacity: .82;
        }

        .btn-solid svg {
            width: 14px;
            height: 14px;
        }

        html.dark .btn-solid {
            background: #f1f5f9;
            color: #0a0d17;
        }

        /* ═══════════════════════════════════════════
   CARD
═══════════════════════════════════════════ */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }

        .card-title {
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: -0.2px;
        }

        .card-sub {
            font-size: 12px;
            color: var(--text3);
            margin-top: 1px;
        }

        /* ═══════════════════════════════════════════
   GRID SYSTEM
═══════════════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 16px;
        }

        @media (max-width: 1100px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 310px;
            gap: 14px;
            margin-bottom: 16px;
        }

        @media (max-width: 1060px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 290px;
            gap: 14px;
            margin-bottom: 16px;
        }

        @media (max-width: 1060px) {
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .grid-4 {
            display: grid;
            grid-template-columns: 1fr 290px;
            gap: 14px;
        }

        @media (max-width: 1060px) {
            .grid-4 {
                grid-template-columns: 1fr;
            }
        }

        /* ═══════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════ */
        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text3);
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: var(--card2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 15px;
            height: 15px;
            color: var(--text2);
        }

        .stat-val {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 700;
        }

        .stat-change.up {
            color: var(--green);
        }

        .stat-change.dn {
            color: var(--red);
        }

        .stat-period {
            font-size: 12px;
            color: var(--text3);
            font-weight: 400;
        }

        .sparkline {
            height: 46px;
            margin-top: 10px;
            position: relative;
        }

        .sparkline canvas {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
        }

        /* ═══════════════════════════════════════════
   CHART CONTAINERS — key for mobile
═══════════════════════════════════════════ */
        .chart-wrap {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .chart-wrap canvas {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
        }

        .ch-240 {
            height: 240px;
        }

        .ch-190 {
            height: 190px;
        }

        .ch-180 {
            height: 180px;
        }

        @media (max-width: 600px) {
            .ch-240 {
                height: 195px;
            }

            .ch-190 {
                height: 175px;
            }

            .ch-180 {
                height: 165px;
            }
        }

        /* ═══════════════════════════════════════════
   TABS
═══════════════════════════════════════════ */
        .tab-group {
            display: flex;
            gap: 2px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 5px 11px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text3);
            background: transparent;
            transition: background 0.15s, color 0.15s;
        }

        .tab-btn:hover {
            color: var(--text);
        }

        .tab-btn.active {
            background: var(--text);
            color: #fff;
        }

        html.dark .tab-btn.active {
            background: #f1f5f9;
            color: #0a0d17;
        }

        /* ═══════════════════════════════════════════
   CARD HEADER ROW
═══════════════════════════════════════════ */
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .card-header-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        /* ═══════════════════════════════════════════
   PROGRESS BARS
═══════════════════════════════════════════ */
        .prog-item {
            margin-bottom: 14px;
        }

        .prog-item:last-child {
            margin-bottom: 0;
        }

        .prog-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .prog-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .prog-code {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text3);
            font-family: monospace;
            min-width: 18px;
        }

        .prog-name {
            font-size: 13px;
            font-weight: 500;
        }

        .prog-pct {
            font-size: 13px;
            font-weight: 700;
        }

        .prog-track {
            height: 5px;
            background: var(--card2);
            border-radius: 4px;
            overflow: hidden;
        }

        .prog-fill {
            height: 100%;
            border-radius: 4px;
            background: var(--text);
            transition: width 1.3s cubic-bezier(.4, 0, .2, 1);
        }

        html.dark .prog-fill {
            background: #e2e8f0;
        }

        .prog-fill.green {
            background: #22c55e !important;
        }

        /* ═══════════════════════════════════════════
   BADGES
═══════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-paid {
            background: var(--green-bg);
            color: var(--green);
        }

        .badge-pending {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .badge-failed {
            background: var(--red-bg);
            color: var(--red);
        }

        /* ═══════════════════════════════════════════
   TABLE — FIXED for mobile
═══════════════════════════════════════════ */
        .table-scroll {
            overflow-x: auto;
            margin-top: 16px;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text3);
            padding: 0 8px 10px 0;
            border-bottom: 1px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }

        .data-table thead th:last-child {
            text-align: right;
            padding-right: 0;
        }

        .data-table tbody tr {
            transition: background 0.12s;
        }

        .data-table tbody tr:hover {
            background: var(--card2);
        }

        .data-table tbody td {
            padding: 10px 8px 10px 0;
            border-bottom: 1px solid var(--card2);
            font-size: 13px;
            vertical-align: middle;
        }

        html.dark .data-table tbody td {
            border-bottom-color: var(--border);
        }

        .data-table tbody td:last-child {
            text-align: right;
            font-weight: 700;
            padding-right: 0;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* customer cell */
        .customer-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .customer-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .customer-name {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.3;
        }

        .customer-email {
            font-size: 11.5px;
            color: var(--text3);
        }

        /* hide email on very small screens */
        @media (max-width: 420px) {
            .customer-email {
                display: none;
            }

            .customer-avatar {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }
        }

        /* ═══════════════════════════════════════════
   SEARCH BOX
═══════════════════════════════════════════ */
        .search-wrap {
            position: relative;
        }

        .search-wrap svg {
            position: absolute;
            left: 9px;
            top: 50%;
            transform: translateY(-50%);
            width: 13px;
            height: 13px;
            color: var(--text3);
            pointer-events: none;
        }

        .search-wrap input {
            padding: 7px 10px 7px 28px;
            font-size: 12.5px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--card2);
            outline: none;
            color: var(--text);
            width: 160px;
            transition: border-color 0.15s;
        }

        .search-wrap input::placeholder {
            color: var(--text3);
        }

        .search-wrap input:focus {
            border-color: var(--blue);
        }

        @media (max-width: 440px) {
            .search-wrap input {
                width: 120px;
            }
        }

        /* ═══════════════════════════════════════════
   MONTHLY TARGET — FIXED LAYOUT
═══════════════════════════════════════════ */
        .target-card {
            display: flex;
            flex-direction: column;
        }

        .donut-outer {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 6px auto 16px;
            flex-shrink: 0;
        }

        .donut-outer canvas {
            display: block !important;
            width: 160px !important;
            height: 160px !important;
        }

        .donut-inner {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .donut-pct {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.6px;
        }

        .donut-lbl {
            font-size: 11px;
            color: var(--text3);
            margin-top: 2px;
        }

        .target-stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 12px;
        }

        .target-stat-item {
            text-align: center;
        }

        .target-stat-val {
            font-size: 15px;
            font-weight: 800;
        }

        .target-stat-lbl {
            font-size: 11px;
            color: var(--text3);
            margin-top: 2px;
        }

        .target-progress-track {
            height: 6px;
            background: var(--card2);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .target-progress-fill {
            height: 100%;
            width: 83%;
            border-radius: 4px;
            background: var(--text);
            transition: width 1.3s cubic-bezier(.4, 0, .2, 1);
        }

        html.dark .target-progress-fill {
            background: #e2e8f0;
        }

        .target-note {
            font-size: 11.5px;
            color: var(--text3);
            text-align: center;
            margin-bottom: 16px;
        }

        /* ═══════════════════════════════════════════
   LEGEND
═══════════════════════════════════════════ */
        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 14px;
            justify-content: center;
            margin-top: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            color: var(--text2);
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════ */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim {
            animation: fadeUp 0.38s ease both;
        }

        .delay-1 {
            animation-delay: .06s;
        }

        .delay-2 {
            animation-delay: .12s;
        }

        .delay-3 {
            animation-delay: .18s;
        }

        .delay-4 {
            animation-delay: .24s;
        }
    </style>
</head>

<body>
    <div class="app">

        <!-- MOBILE OVERLAY -->
        <div class="mob-overlay" id="mobOverlay" onclick="closeMobileSidebar()"></div>

        <!-- ═══════════════════════ SIDEBAR ═══════════════════════ -->
        @include('layout.sidebar')

        <!-- ═══════════════════════ MAIN ═══════════════════════ -->
        <div class="main-area">

            <!-- TOPBAR -->
            @include('layout.hearder')

            <!-- PAGE CONTENT -->
            @yield('content')
        </div><!-- end main-area -->
    </div><!-- end app -->

    <script>
        /* ─────────────────────────────────────
                                               SIDEBAR
                                            ───────────────────────────────────── */
        function toggleCollapse() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function openMobileSidebar() {
            document.getElementById('sidebar').classList.add('mob-open');
            document.getElementById('mobOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileSidebar() {
            document.getElementById('sidebar').classList.remove('mob-open');
            document.getElementById('mobOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }

        function setActiveNav(el) {
            document.querySelectorAll('.nav-link').forEach(n => n.classList.remove('active'));
            el.classList.add('active');
            if (window.innerWidth <= 768) closeMobileSidebar();
        }

        /* ─────────────────────────────────────
           PROFILE DROPDOWN
        ───────────────────────────────────── */
        var dropOpen = false;

        function toggleDrop() {
            dropOpen = !dropOpen;
            document.getElementById('profileDrop').style.display = dropOpen ? 'block' : 'none';
        }
        $(document).on('click', function(e) {
            if (dropOpen && !$(e.target).closest('#avatarBtn, #profileDrop').length) {
                dropOpen = false;
                $('#profileDrop').hide();
            }
        });

        /* ─────────────────────────────────────
           DARK MODE
        ───────────────────────────────────── */
        var isDark = false;

        function toggleDark() {
            const isDark = document.documentElement.classList.toggle('dark');
            // State ko save karo localStorage mein
            localStorage.setItem('dark-mode', isDark);

            // Toggle button ka UI update karne ke liye (Optional)
            const btn = document.getElementById('darkToggle');
            if (isDark) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }

        /* ─────────────────────────────────────
           TABS
        ───────────────────────────────────── */
        function switchTab(btn, groupId) {
            document.querySelectorAll('#' + groupId + ' .tab-btn').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }

        /* ─────────────────────────────────────
           SEARCH FILTER
        ───────────────────────────────────── */
        $('#txSearch').on('input', function() {
            var q = $(this).val().toLowerCase();
            $('#txBody tr').each(function() {
                $(this).toggle($(this).text().toLowerCase().includes(q));
            });
        });

        /* ─────────────────────────────────────
           CHARTS
        ───────────────────────────────────── */
        var chartInstances = {};

        function getTheme() {
            return {
                bar: isDark ? '#e2e8f0' : '#111827',
                grid: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                tick: isDark ? '#64748b' : '#94a3b8',
                donutBg: isDark ? '#1e293b' : '#f1f5f9'
            };
        }

        function makeSparkline(canvasId, data, color) {
            return new Chart(document.getElementById(canvasId), {
                type: 'line',
                data: {
                    labels: data.map((_, i) => i),
                    datasets: [{
                        data,
                        borderColor: color,
                        borderWidth: 1.5,
                        tension: 0.4,
                        pointRadius: 0,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 700
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });
        }

        function buildCharts() {
            var T = getTheme();
            var isMobile = window.innerWidth < 500;

            // Sparklines
            chartInstances.sp0 = makeSparkline('sp0', [28, 32, 30, 38, 42, 45, 48, 52, 50, 58], T.bar);
            chartInstances.sp1 = makeSparkline('sp1', [50, 120, 180, 150, 220, 280, 310, 290, 330, 350], T.bar);
            chartInstances.sp2 = makeSparkline('sp2', [22, 20, 24, 21, 18, 17, 16, 14, 13, 12.5], '#ef4444');
            chartInstances.sp3 = makeSparkline('sp3', [320, 350, 370, 360, 390, 400, 410, 405, 420, 573], T.bar);

            // Revenue Bar
            chartInstances.rev = new Chart(document.getElementById('revChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        data: [18000, 14000, 13500, 20000, 22000, 19000, 25000, 31000, 36000, 41000, 49000,
                            52000
                        ],
                        backgroundColor: T.bar,
                        borderRadius: 5,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 900
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: c => ' Revenue: $' + c.raw.toLocaleString()
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: T.tick,
                                font: {
                                    size: isMobile ? 9 : 11,
                                    family: 'Plus Jakarta Sans'
                                },
                                maxTicksLimit: isMobile ? 6 : 12,
                                maxRotation: 0
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                color: T.grid
                            },
                            ticks: {
                                color: T.tick,
                                font: {
                                    size: isMobile ? 9 : 11,
                                    family: 'Plus Jakarta Sans'
                                },
                                callback: v => '$' + (v / 1000).toFixed(0) + 'k',
                                maxTicksLimit: 5
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Donut — Monthly Target
            chartInstances.donut = new Chart(document.getElementById('donutChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [75, 25],
                        backgroundColor: [T.bar, T.donutBg],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    animation: {
                        duration: 1100
                    }
                }
            });

            // Traffic Line
            chartInstances.traffic = new Chart(document.getElementById('trafficChart'), {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                            label: 'Visitors',
                            data: [4200, 5000, 4600, 6200, 5400, 7000, 4800],
                            borderColor: T.bar,
                            borderWidth: 2,
                            tension: 0.4,
                            pointRadius: isMobile ? 2 : 4,
                            pointBackgroundColor: T.bar,
                            fill: false
                        },
                        {
                            label: 'Page Views',
                            data: [7200, 8500, 9200, 10500, 10800, 11200, 9800],
                            borderColor: '#60a5fa',
                            borderDash: [6, 4],
                            borderWidth: 2,
                            tension: 0.4,
                            pointRadius: isMobile ? 2 : 3,
                            pointBackgroundColor: '#60a5fa',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 900
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: T.tick,
                                font: {
                                    size: isMobile ? 9 : 11,
                                    family: 'Plus Jakarta Sans'
                                },
                                maxRotation: 0
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                color: T.grid
                            },
                            ticks: {
                                color: T.tick,
                                font: {
                                    size: isMobile ? 9 : 11,
                                    family: 'Plus Jakarta Sans'
                                },
                                callback: v => v >= 1000 ? (v / 1000).toFixed(0) + 'k' : v,
                                maxTicksLimit: 5
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Pie
            chartInstances.pie = new Chart(document.getElementById('pieChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Direct', 'Organic', 'Referral', 'Social'],
                    datasets: [{
                        data: [40, 30, 20, 10],
                        backgroundColor: ['#1d4ed8', '#60a5fa', '#93c5fd', '#d1d5db'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '55%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: c => ' ' + c.label + ': ' + c.raw + '%'
                            }
                        }
                    },
                    animation: {
                        duration: 1100
                    }
                }
            });
        }

        function rebuildCharts() {
            Object.values(chartInstances).forEach(c => {
                try {
                    c.destroy();
                } catch (e) {}
            });
            chartInstances = {};
            buildCharts();
        }

        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(rebuildCharts, 280);
        });

        $(function() {
            buildCharts();
        });
    </script>
</body>

</html>
