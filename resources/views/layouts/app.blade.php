<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Bengkulu') }} — @yield('title', 'Home')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-raflesia.png') }}">

    {{-- Phosphor Icons --}}
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    {{-- GSAP + ScrollTrigger --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =============================================
           CSS VARIABLES — RAFLESIA + BATIK BASUREK
        ============================================= */
        :root {
            --red-50:    #FFF1F0;
            --red-100:   #FFE0DD;
            --red-500:   #E74C3C;
            --red-600:   #C0392B;
            --red-700:   #A93226;
            --gold-300:  #F0C96A;
            --gold-400:  #D4A843;
            --gold-600:  #8B6914;
            --green-700: #1A5C38;
            --green-500: #27AE60;
            --cream:     #FDF8F0;
            --cream-200: #F5EDD8;
            --cream-300: #EDE0C4;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--cream);
            color: #1F2937;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* =============================================
           BATIK GRADIENT BORDER
        ============================================= */
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
           NAVBAR
        ============================================= */
        #navbar {
            background: rgba(253, 248, 240, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 168, 67, 0.15);
            transition: box-shadow 0.3s ease, background 0.3s ease;
        }

        #navbar.scrolled {
            background: rgba(253, 248, 240, 0.98);
            box-shadow: 0 4px 32px rgba(192, 57, 43, 0.08),
                        0 1px 0 rgba(212, 168, 67, 0.2);
        }

        /* Nav Links */
        .nav-link {
            position: relative;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6B7280;
            padding: 6px 2px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--red-600), var(--gold-400));
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link:hover,
        .nav-link.active { color: var(--red-600); }

        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }

        /* =============================================
           DROPDOWN
        ============================================= */
        .dropdown-panel {
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px) scale(0.98);
            transform-origin: top right;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-trigger:focus-within .dropdown-panel,
        .dropdown-trigger:hover .dropdown-panel {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 0.875rem;
            color: #374151;
            transition: background 0.15s, color 0.15s;
            border-radius: 8px;
            margin: 2px 6px;
        }

        .dropdown-item:hover {
            background: var(--red-50);
            color: var(--red-600);
        }

        .dropdown-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* =============================================
           MOBILE MENU
        ============================================= */
        #mobileMenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.45s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #mobileMenu.open { max-height: 600px; }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            transition: all 0.2s;
        }

        .mobile-nav-item:hover,
        .mobile-nav-item.active {
            background: var(--red-50);
            color: var(--red-600);
        }

        /* =============================================
           BUTTONS
        ============================================= */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--red-600), var(--red-500));
            color: white;
            box-shadow: 0 4px 14px rgba(192, 57, 43, 0.3);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(192, 57, 43, 0.4);
        }

        .btn-primary:active { transform: translateY(0); }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            background: transparent;
            color: #374151;
            border: 1.5px solid var(--cream-300);
            transition: all 0.25s;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: var(--red-50);
            border-color: var(--red-100);
            color: var(--red-600);
        }

        /* =============================================
           FLASH / TOAST
        ============================================= */
        .toast {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 0.875rem;
            border: 1px solid;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .toast-success {
            background: rgba(240, 253, 244, 0.95);
            border-color: #BBF7D0;
            color: #166534;
        }

        .toast-error {
            background: rgba(255, 241, 240, 0.95);
            border-color: #FCA5A5;
            color: #991B1B;
        }

        .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* =============================================
           PAGE CONTENT ANIMATION
        ============================================= */
        .page-content {
            opacity: 0;
            transform: translateY(16px);
        }

        /* =============================================
           CARD BASE
        ============================================= */
        .card {
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(212, 168, 67, 0.12);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04),
                        0 4px 12px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            box-shadow: 0 8px 32px rgba(192, 57, 43, 0.10),
                        0 2px 8px rgba(0,0,0,0.06);
            transform: translateY(-4px);
        }

        /* =============================================
           EVENT CARD
        ============================================= */
        .event-card .card-image {
            overflow: hidden;
            border-radius: 16px 16px 0 0;
        }

        .event-card .card-image img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            height: 176px;
            object-fit: cover;
        }

        .event-card:hover .card-image img {
            transform: scale(1.08);
        }

        .event-card .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.35) 0%,
                transparent 60%
            );
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 16px 16px 0 0;
        }

        .event-card:hover .card-overlay { opacity: 1; }

        /* Fav button */
        .fav-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,0.95);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .fav-btn:hover { transform: scale(1.15); }
        .fav-btn:active { transform: scale(0.92); }
        .fav-btn.active i { color: var(--red-600) !important; }

        /* Category pill */
        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 99px;
            background: rgba(192, 57, 43, 0.08);
            color: var(--red-600);
            letter-spacing: 0.02em;
        }

        /* Price badge */
        .price-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            background: rgba(192, 57, 43, 0.82);
            color: white;
            backdrop-filter: blur(4px);
        }

        /* =============================================
           STAT CARD
        ============================================= */
        .stat-card {
            border-radius: 20px;
            padding: 20px;
            border: 1px solid rgba(212, 168, 67, 0.12);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
            transition: height 0.3s ease;
        }

        .stat-card:hover { transform: translateY(-4px); }
        .stat-card:hover::before { height: 5px; }

        /* =============================================
           SECTION HEADER
        ============================================= */
        .section-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label .accent-bar {
            width: 4px;
            height: 24px;
            border-radius: 99px;
            flex-shrink: 0;
        }

        /* =============================================
           SCROLLBAR
        ============================================= */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb {
            background: var(--red-600);
            border-radius: 99px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--red-700); }
    </style>
</head>

<body>

    {{-- Batik Top Border --}}
    <div class="batik-line fixed top-0 left-0 right-0 z-[60]"></div>

    {{-- ============================================ --}}
    {{-- NAVBAR                                       --}}
    {{-- ============================================ --}}
    <nav id="navbar" class="fixed top-[3px] left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0 shadow-sm
                        transition-transform duration-300 group-hover:scale-105"
                        style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
                        <img src="{{ asset('images/logo-raflesia.png') }}"
                            class="w-7 h-7 object-contain" alt="Logo">
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="font-bold text-gray-800 text-sm">Event Bengkulu</p>
                        <p class="text-xs" style="color: var(--gold-600)">Discover Local Events</p>
                    </div>
                </a>

                {{-- Nav Links Desktop --}}
                <div class="hidden md:flex items-center gap-7">
                    <a href="{{ route('user.dashboard') }}"
                        class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="ph ph-house text-base"></i> Beranda
                    </a>
                    <a href="{{ route('user.events.index') }}"
                        class="nav-link {{ request()->routeIs('user.events.*') ? 'active' : '' }}">
                        <i class="ph ph-magnifying-glass text-base"></i> Jelajahi
                    </a>
                    <a href="{{ route('user.recommendations.index') }}"
                        class="nav-link {{ request()->routeIs('user.recommendations.*') ? 'active' : '' }}">
                        <i class="ph ph-sparkle text-base"></i> Rekomendasi
                    </a>
                    <a href="{{ route('user.favorites.index') }}"
                        class="nav-link {{ request()->routeIs('user.favorites.*') ? 'active' : '' }}">
                        <i class="ph ph-heart text-base"></i> Favorit
                    </a>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-2">

                    {{-- Favorit Icon --}}
                    <a href="{{ route('user.favorites.index') }}"
                        class="hidden md:flex w-9 h-9 rounded-xl items-center justify-center transition-all hover:bg-red-50 hover:text-red-600 text-gray-500"
                        title="Favorit Saya">
                        <i class="ph ph-heart text-xl"></i>
                    </a>

                    {{-- Profile Dropdown --}}
                    <div class="dropdown-trigger relative">
                        <button class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl
                            hover:bg-amber-50 transition-all group">
                            <img src="{{ Auth::user()->avatar
                                    ? asset('storage/' . Auth::user()->avatar)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=C0392B&color=fff&size=80&bold=true' }}"
                                class="w-8 h-8 rounded-lg object-cover flex-shrink-0 ring-2 ring-transparent group-hover:ring-red-200 transition-all"
                                alt="Avatar">
                            <span class="hidden sm:block text-sm font-semibold text-gray-700 max-w-[100px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            <i class="ph ph-caret-down text-sm text-gray-400 transition-transform duration-300 group-hover:rotate-180"></i>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div class="dropdown-panel absolute right-0 mt-2 w-60 bg-white rounded-2xl
                            shadow-xl border border-amber-50 overflow-hidden z-50">

                            {{-- User Info Header --}}
                            <div class="px-4 py-4 border-b border-gray-50"
                                style="background: linear-gradient(135deg, var(--red-50), var(--cream))">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Auth::user()->avatar
                                            ? asset('storage/' . Auth::user()->avatar)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=C0392B&color=fff&size=80&bold=true' }}"
                                        class="w-10 h-10 rounded-xl object-cover flex-shrink-0"
                                        alt="Avatar">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-800 truncate">
                                            {{ Auth::user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-400 truncate">
                                            {{ Auth::user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-2">
                                <a href="{{ route('user.profile.edit') }}" class="dropdown-item">
                                    <span class="dropdown-icon" style="background: #EFF6FF">
                                        <i class="ph ph-user text-base" style="color: #3B82F6"></i>
                                    </span>
                                    Profil Saya
                                </a>
                                <a href="{{ route('user.favorites.index') }}" class="dropdown-item">
                                    <span class="dropdown-icon" style="background: var(--red-50)">
                                        <i class="ph ph-heart text-base" style="color: var(--red-600)"></i>
                                    </span>
                                    Favorit Saya
                                </a>
                                <a href="{{ route('user.recommendations.index') }}" class="dropdown-item">
                                    <span class="dropdown-icon" style="background: #FFFBEB">
                                        <i class="ph ph-sparkle text-base" style="color: var(--gold-400)"></i>
                                    </span>
                                    Rekomendasi
                                </a>
                            </div>

                            <div class="border-t border-gray-50 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left text-red-600 hover:bg-red-50">
                                        <span class="dropdown-icon" style="background: var(--red-50)">
                                            <i class="ph ph-sign-out text-base" style="color: var(--red-600)"></i>
                                        </span>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Toggle --}}
                    <button id="mobileToggle"
                        class="md:hidden w-9 h-9 rounded-xl flex items-center justify-center hover:bg-amber-50 transition text-gray-600">
                        <i id="iconHamburger" class="ph ph-list text-xl"></i>
                        <i id="iconClose" class="ph ph-x text-xl hidden"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="md:hidden border-t border-amber-50 bg-white/95 backdrop-blur-lg">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('user.dashboard') }}"
                    class="mobile-nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-house text-lg"></i> Beranda
                </a>
                <a href="{{ route('user.events.index') }}"
                    class="mobile-nav-item {{ request()->routeIs('user.events.*') ? 'active' : '' }}">
                    <i class="ph ph-magnifying-glass text-lg"></i> Jelajahi Event
                </a>
                <a href="{{ route('user.recommendations.index') }}"
                    class="mobile-nav-item {{ request()->routeIs('user.recommendations.*') ? 'active' : '' }}">
                    <i class="ph ph-sparkle text-lg"></i> Rekomendasi
                </a>
                <a href="{{ route('user.favorites.index') }}"
                    class="mobile-nav-item {{ request()->routeIs('user.favorites.*') ? 'active' : '' }}">
                    <i class="ph ph-heart text-lg"></i> Favorit Saya
                </a>
                <a href="{{ route('user.profile.edit') }}"
                    class="mobile-nav-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                    <i class="ph ph-user text-lg"></i> Profil Saya
                </a>
                <div class="pt-2 mt-2 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-item w-full text-left text-red-600 hover:bg-red-50">
                            <i class="ph ph-sign-out text-lg"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Spacer --}}
    <div class="h-[67px]"></div>

    {{-- ============================================ --}}
    {{-- FLASH TOAST                                 --}}
    {{-- ============================================ --}}
    @if(session('success') || session('error'))
    <div class="fixed top-20 right-4 z-50 space-y-2 w-80" id="toastContainer">
        @if(session('success'))
        <div class="toast toast-success" id="toastSuccess">
            <div class="toast-icon" style="background: #DCFCE7">
                <i class="ph ph-check-circle text-xl" style="color: #16A34A"></i>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-sm mb-0.5">Berhasil</p>
                <p class="text-xs opacity-80">{{ session('success') }}</p>
            </div>
            <button onclick="dismissToast('toastSuccess')"
                class="text-gray-400 hover:text-gray-600 mt-0.5 flex-shrink-0">
                <i class="ph ph-x text-base"></i>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div class="toast toast-error" id="toastError">
            <div class="toast-icon" style="background: var(--red-100)">
                <i class="ph ph-warning-circle text-xl" style="color: var(--red-600)"></i>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-sm mb-0.5">Gagal</p>
                <p class="text-xs opacity-80">{{ session('error') }}</p>
            </div>
            <button onclick="dismissToast('toastError')"
                class="text-gray-400 hover:text-gray-600 mt-0.5 flex-shrink-0">
                <i class="ph ph-x text-base"></i>
            </button>
        </div>
        @endif
    </div>
    @endif

    {{-- ============================================ --}}
    {{-- MAIN CONTENT                                --}}
    {{-- ============================================ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 page-content" id="mainContent">
        @yield('content')
    </main>

    {{-- ============================================ --}}
    {{-- FOOTER                                      --}}
    {{-- ============================================ --}}
    <footer class="mt-20 border-t border-amber-100" style="background: var(--cream-200)">
        <div class="batik-line"></div>
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg overflow-hidden flex items-center justify-center flex-shrink-0"
                    style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
                    <img src="{{ asset('images/logo-raflesia.png') }}"
                        class="w-5 h-5 object-contain" alt="Logo">
                </div>
                <span class="text-sm font-bold text-gray-700">Event Bengkulu</span>
            </div>
            <p class="text-xs text-gray-400 flex items-center gap-1.5">
                <i class="ph ph-copyright text-sm"></i>
                {{ date('Y') }} Event Bengkulu — Dibuat dengan
                <i class="ph ph-heart-fill text-sm" style="color: var(--red-600)"></i>
                untuk Bumi Raflesia
            </p>
        </div>
    </footer>

    {{-- ============================================ --}}
    {{-- JAVASCRIPT                                  --}}
    {{-- ============================================ --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // =============================================
        // NAVBAR SCROLL
        // =============================================
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 24);
        }, { passive: true });

        // =============================================
        // MOBILE MENU
        // =============================================
        const toggle   = document.getElementById('mobileToggle');
        const menu     = document.getElementById('mobileMenu');
        const iconHam  = document.getElementById('iconHamburger');
        const iconX    = document.getElementById('iconClose');

        toggle?.addEventListener('click', () => {
            const open = menu.classList.toggle('open');
            iconHam.classList.toggle('hidden', open);
            iconX.classList.toggle('hidden', !open);
        });

        // =============================================
        // GSAP PAGE ENTER
        // =============================================
        if (typeof gsap !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            // Page content fade in
            gsap.to('#mainContent', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power3.out',
                delay: 0.1
            });

            // Toast animate in
            gsap.from('#toastContainer .toast', {
                opacity: 0,
                x: 40,
                duration: 0.5,
                ease: 'back.out(1.5)',
                stagger: 0.1,
                delay: 0.3
            });

            // Scroll-triggered animations for cards
            gsap.utils.toArray('.gs-fade-up').forEach((el, i) => {
                gsap.from(el, {
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 88%',
                        toggleActions: 'play none none none'
                    },
                    opacity: 0,
                    y: 30,
                    duration: 0.6,
                    ease: 'power3.out',
                    delay: i * 0.08
                });
            });

            // Stat cards stagger
            gsap.utils.toArray('.gs-stat').forEach((el, i) => {
                gsap.from(el, {
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 90%',
                        toggleActions: 'play none none none'
                    },
                    opacity: 0,
                    y: 20,
                    scale: 0.95,
                    duration: 0.5,
                    ease: 'back.out(1.4)',
                    delay: i * 0.1
                });
            });
        }

        // =============================================
        // PAGE TRANSITION
        // =============================================
        document.querySelectorAll('a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') ||
                href.startsWith('javascript') ||
                href.startsWith('mailto') ||
                link.target === '_blank') return;

            link.addEventListener('click', (e) => {
                e.preventDefault();
                if (typeof gsap !== 'undefined') {
                    gsap.to('#mainContent', {
                        opacity: 0,
                        y: -10,
                        duration: 0.25,
                        ease: 'power2.in',
                        onComplete: () => { window.location = href; }
                    });
                } else {
                    window.location = href;
                }
            });
        });

        // =============================================
        // TOAST AUTO DISMISS
        // =============================================
        setTimeout(() => {
            ['toastSuccess', 'toastError'].forEach(id => {
                const el = document.getElementById(id);
                if (el) dismissToast(id);
            });
        }, 5000);
    });

    // Toast dismiss function
    function dismissToast(id) {
        const el = document.getElementById(id);
        if (!el) return;
        if (typeof gsap !== 'undefined') {
            gsap.to(el, {
                opacity: 0,
                x: 30,
                height: 0,
                marginTop: 0,
                padding: 0,
                duration: 0.3,
                ease: 'power2.in',
                onComplete: () => el.remove()
            });
        } else {
            el.remove();
        }
    }
    </script>

</body>
@stack('scripts')
</html>