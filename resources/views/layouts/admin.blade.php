<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | Event Bengkulu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-raflesia.png') }}">

    {{-- GSAP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --red-50:     #FFF1F0;
            --red-100:    #FFE0DD;
            --red-500:    #E74C3C;
            --red-600:    #C0392B;
            --red-700:    #A93226;
            --gold-300:   #F0C96A;
            --gold-400:   #D4A843;
            --gold-600:   #8B6914;
            --green-700:  #1A5C38;
            --green-500:  #27AE60;
            --cream:      #FDF8F0;
            --cream-200:  #F5EDD8;
            --cream-300:  #EDE0C4;
            --sidebar-w:  260px;
            --sidebar-bg: #1A0A0A;
            --topbar-h:   64px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { font-family: 'Inter', sans-serif; }

        body {
            background: #F4F6F9;
            color: #1F2937;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        .batik-line {
            height: 3px;
            background: linear-gradient(
                90deg,
                var(--red-600)  0%,
                var(--gold-400) 30%,
                var(--green-700) 50%,
                var(--gold-400) 70%,
                var(--red-600)  100%
            );
        }

        /* =============================================
           SIDEBAR
        ============================================= */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        }

        #sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-w)));
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
            scrollbar-width: none;
        }
        .sidebar-nav::-webkit-scrollbar { display: none; }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 16px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255,255,255,0.55);
            transition: background 0.2s, color 0.2s;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 2px;
            position: relative;
            /* ✅ TIDAK ada opacity di sini — GSAP yang handle */
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.9);
        }

        .nav-item.active {
            background: linear-gradient(135deg,
                rgba(192,57,43,0.25),
                rgba(192,57,43,0.12));
            color: white;
            border: 1px solid rgba(192,57,43,0.3);
        }

        .nav-item.active .nav-icon { color: var(--red-500); }

        .nav-item .nav-icon {
            font-size: 1.125rem;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--red-500);
            border-radius: 0 3px 3px 0;
        }

        .nav-badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 99px;
            background: rgba(192,57,43,0.3);
            color: #FF8A80;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            margin-bottom: 8px;
        }

        /* =============================================
           TOPBAR
        ============================================= */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: rgba(244, 246, 249, 0.97);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            transition: left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #topbar.expanded { left: 0; }

        /* =============================================
           MAIN
        ============================================= */
        #mainWrapper {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #mainWrapper.expanded { margin-left: 0; }

        /* ✅ TIDAK ada opacity:0 di sini — GSAP yang handle */
        #mainContent {
            padding: 28px;
        }

        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
            z-index: 90;
        }

        /* =============================================
           CARDS & COMPONENTS
        ============================================= */
        .admin-card {
            background: white;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04),
                        0 4px 12px rgba(0,0,0,0.03);
            transition: box-shadow 0.3s ease;
        }

        .admin-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .stat-card .stat-bg-icon {
            position: absolute;
            bottom: -8px;
            right: -8px;
            font-size: 5rem;
            opacity: 0.04;
            line-height: 1;
        }

        /* =============================================
           TABLE
        ============================================= */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .admin-table thead tr {
            background: #F8FAFC;
            border-bottom: 2px solid #F1F5F9;
        }

        .admin-table thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .admin-table tbody tr {
            border-bottom: 1px solid #F1F5F9;
            transition: background 0.15s;
        }

        .admin-table tbody tr:hover { background: #FAFBFC; }
        .admin-table tbody tr:last-child { border-bottom: none; }

        .admin-table tbody td {
            padding: 14px 16px;
            color: #374151;
            vertical-align: middle;
        }

        /* =============================================
           BADGE
        ============================================= */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 99px;
        }

        .badge-green  { background: #DCFCE7; color: #166534; }
        .badge-red    { background: #FEE2E2; color: #991B1B; }
        .badge-yellow { background: #FEF9C3; color: #854D0E; }
        .badge-blue   { background: #DBEAFE; color: #1E40AF; }
        .badge-gray   { background: #F1F5F9; color: #475569; }

        /* =============================================
           BUTTONS
        ============================================= */
        .btn-admin-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--red-600), var(--red-500));
            color: white;
            box-shadow: 0 4px 12px rgba(192,57,43,0.25);
            transition: all 0.25s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-admin-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(192,57,43,0.35);
        }

        .btn-admin-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            background: white;
            color: #374151;
            border: 1.5px solid #E2E8F0;
            transition: all 0.25s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-admin-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        .btn-admin-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #FEE2E2;
            color: #991B1B;
            border: none;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-admin-danger:hover { background: #FECACA; }

        .btn-admin-warning {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #FEF9C3;
            color: #854D0E;
            border: none;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-admin-warning:hover { background: #FEF08A; }

        .btn-admin-info {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #DBEAFE;
            color: #1E40AF;
            border: none;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-admin-info:hover { background: #BFDBFE; }

        /* =============================================
           FORM
        ============================================= */
        .admin-input {
            width: 100%;
            padding: 9px 14px;
            border-radius: 10px;
            border: 1.5px solid #E2E8F0;
            background: white;
            font-size: 0.875rem;
            color: #1F2937;
            transition: all 0.2s;
            outline: none;
        }

        .admin-input:focus {
            border-color: var(--red-600);
            box-shadow: 0 0 0 3px rgba(192,57,43,0.1);
        }

        .admin-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 36px;
        }

        /* =============================================
           TOAST
        ============================================= */
        .admin-toast {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 200;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 0.875rem;
            min-width: 280px;
            max-width: 380px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border: 1px solid;
        }

        .admin-toast-success {
            background: #F0FDF4;
            border-color: #BBF7D0;
            color: #166534;
        }

        .admin-toast-error {
            background: #FFF1F0;
            border-color: #FECACA;
            color: #991B1B;
        }

        /* =============================================
           SCROLLBAR
        ============================================= */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #F4F6F9; }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 99px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--red-600); }

        /* =============================================
           RESPONSIVE
        ============================================= */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(calc(-1 * var(--sidebar-w))); }
            #sidebar.mobile-open { transform: translateX(0); }
            #topbar { left: 0 !important; }
            #mainWrapper { margin-left: 0 !important; }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <aside id="sidebar">
        <div class="sidebar-logo">
            <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0"
                style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
                <img src="{{ asset('images/logo-raflesia.png') }}"
                    class="w-7 h-7 object-contain" alt="Logo">
            </div>
            <div class="min-w-0">
                <p class="font-bold text-white text-sm leading-tight">Event Bengkulu</p>
                <p class="text-xs leading-tight" style="color: var(--gold-400)">Admin Panel</p>
            </div>
        </div>

        <div class="batik-line"></div>

        <nav class="sidebar-nav">
            <p class="nav-section-label">Main</p>

            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="ph ph-squares-four nav-icon"></i>
                <span>Dashboard</span>
            </a>

            <p class="nav-section-label">Manajemen</p>

            <a href="{{ route('admin.events.index') }}"
                class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="ph ph-ticket nav-icon"></i>
                <span>Event</span>
                @php $eventCount = \App\Models\Event::count(); @endphp
                @if($eventCount > 0)
                <span class="nav-badge">{{ $eventCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="ph ph-tag nav-icon"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="ph ph-users nav-icon"></i>
                <span>Pengguna</span>
                @php $userCount = \App\Models\User::role('user')->count(); @endphp
                @if($userCount > 0)
                <span class="nav-badge">{{ $userCount }}</span>
                @endif
            </a>

            <p class="nav-section-label">Kurasi</p>

            <a href="{{ route('admin.recommendations.index') }}"
                class="nav-item {{ request()->routeIs('admin.recommendations.index') ? 'active' : '' }}">
                <i class="ph ph-star nav-icon"></i>
                <span>Rekomendasi</span>
            </a>

            <a href="{{ route('admin.recommendations.statistics') }}"
                class="nav-item {{ request()->routeIs('admin.recommendations.statistics') ? 'active' : '' }}">
                <i class="ph ph-chart-bar nav-icon"></i>
                <span>Statistik</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=C0392B&color=fff&size=40&bold=true"
                    class="w-8 h-8 rounded-lg flex-shrink-0 object-cover" alt="Admin">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs truncate" style="color: rgba(255,255,255,0.4)">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item w-full text-left"
                    style="color: rgba(255,100,80,0.8)">
                    <i class="ph ph-sign-out nav-icon"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- TOPBAR --}}
    <header id="topbar">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()"
                class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                <i class="ph ph-list text-xl"></i>
            </button>
            <div class="hidden sm:flex items-center gap-2 text-sm">
                <span class="text-gray-400">Admin</span>
                <i class="ph ph-caret-right text-xs text-gray-300"></i>
                <span class="font-semibold text-gray-700">@yield('title', 'Dashboard')</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.create') }}"
                class="hidden sm:flex btn-admin-primary text-xs py-2 px-3">
                <i class="ph ph-plus text-sm"></i>
                Tambah Event
            </a>
            <a href="{{ route('home') }}" target="_blank"
                class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                <i class="ph ph-arrow-square-out text-lg"></i>
            </a>
            <div class="flex items-center gap-2 pl-3 border-l border-gray-100">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=C0392B&color=fff&size=40&bold=true"
                    class="w-8 h-8 rounded-lg object-cover" alt="Admin">
                <div class="hidden sm:block">
                    <p class="text-xs font-bold text-gray-700 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 leading-tight">Administrator</p>
                </div>
            </div>
        </div>
    </header>

    {{-- TOAST --}}
    @if(session('success') || session('error'))
    <div id="toastContainer">
        @if(session('success'))
        <div class="admin-toast admin-toast-success" id="toastSuccess">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background: #DCFCE7">
                <i class="ph ph-check-circle text-xl" style="color: #16A34A"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm">Berhasil</p>
                <p class="text-xs opacity-75 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="dismissToast('toastSuccess')"
                class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                <i class="ph ph-x text-base"></i>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div class="admin-toast admin-toast-error" id="toastError">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background: #FEE2E2">
                <i class="ph ph-warning-circle text-xl" style="color: #DC2626"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm">Gagal</p>
                <p class="text-xs opacity-75 mt-0.5">{{ session('error') }}</p>
            </div>
            <button onclick="dismissToast('toastError')"
                class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                <i class="ph ph-x text-base"></i>
            </button>
        </div>
        @endif
    </div>
    @endif

    {{-- MAIN --}}
    <div id="mainWrapper">
        <main id="mainContent">
            @yield('content')
        </main>
    </div>

    {{-- Phosphor Icons — load terakhir --}}
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    <script>
    let sidebarCollapsed = false;
    const isMobile = () => window.innerWidth < 768;

    function toggleSidebar() {
        if (isMobile()) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const isOpen  = sidebar.classList.contains('mobile-open');
            if (isOpen) {
                closeSidebar();
            } else {
                sidebar.classList.add('mobile-open');
                overlay.style.display = 'block';
                gsap.set(sidebar, { x: -260 });
                gsap.to(sidebar, { x: 0, duration: 0.35, ease: 'power3.out' });
                gsap.set(overlay, { opacity: 0 });
                gsap.to(overlay, { opacity: 1, duration: 0.3 });
            }
        } else {
            sidebarCollapsed = !sidebarCollapsed;
            document.getElementById('sidebar').classList.toggle('collapsed', sidebarCollapsed);
            document.getElementById('topbar').classList.toggle('expanded', sidebarCollapsed);
            document.getElementById('mainWrapper').classList.toggle('expanded', sidebarCollapsed);
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        gsap.to(sidebar, {
            x: -260, duration: 0.3, ease: 'power3.in',
            onComplete: () => {
                sidebar.classList.remove('mobile-open');
                sidebar.style.transform = '';
            }
        });
        gsap.to(overlay, {
            opacity: 0, duration: 0.25,
            onComplete: () => { overlay.style.display = 'none'; }
        });
    }

    function dismissToast(id) {
        const el = document.getElementById(id);
        if (!el) return;
        gsap.to(el, {
            opacity: 0, x: 30,
            duration: 0.3, ease: 'power2.in',
            onComplete: () => el.remove()
        });
    }

    // =============================================
    // ✅ FIXED: gsap.set SEBELUM gsap.to
    // =============================================
    window.addEventListener('load', () => {
        gsap.registerPlugin(ScrollTrigger);

        // 1. Set semua initial state PERTAMA
        gsap.set('#mainContent',  { opacity: 0, y: 16 });
        gsap.set('.nav-item',     { opacity: 0, x: -16 });
        gsap.set('.admin-toast',  { opacity: 0, x: 40 });

        // 2. Animate setelah set
        gsap.to('#mainContent', {
            opacity: 1, y: 0,
            duration: 0.5, ease: 'power3.out',
            delay: 0.1
        });

        gsap.to('.nav-item', {
            opacity: 1, x: 0,
            duration: 0.4, ease: 'power3.out',
            stagger: 0.05,
            delay: 0.15
        });

        // Toast
        const toasts = document.querySelectorAll('.admin-toast');
        if (toasts.length) {
            gsap.to(toasts, {
                opacity: 1, x: 0,
                duration: 0.5, ease: 'back.out(1.5)',
                stagger: 0.1,
                delay: 0.3
            });
            setTimeout(() => {
                ['toastSuccess', 'toastError'].forEach(id => dismissToast(id));
            }, 5000);
        }

        // gs-fade-up — ScrollTrigger dengan set+to
        gsap.utils.toArray('.gs-fade-up').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: el,
                start: 'top 88%',
                once: true,
                onEnter: () => {
                    gsap.to(el, {
                        opacity: 1, y: 0,
                        duration: 0.5, ease: 'power3.out',
                        delay: i * 0.06
                    });
                }
            });
        });

        // gs-stat — ScrollTrigger dengan set+to
        gsap.utils.toArray('.gs-stat').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 20, scale: 0.95 });
            ScrollTrigger.create({
                trigger: el,
                start: 'top 90%',
                once: true,
                onEnter: () => {
                    gsap.to(el, {
                        opacity: 1, y: 0, scale: 1,
                        duration: 0.5, ease: 'back.out(1.4)',
                        delay: i * 0.08
                    });
                }
            });
        });
    });

    // Page transition
    document.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript') ||
            href.startsWith('mailto') || link.target === '_blank') return;
        link.addEventListener('click', (e) => {
            e.preventDefault();
            gsap.to('#mainContent', {
                opacity: 0, y: -8,
                duration: 0.2, ease: 'power2.in',
                onComplete: () => { window.location = href; }
            });
        });
    });
    </script>

    @stack('scripts')
</body>
</html>