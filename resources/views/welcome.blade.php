<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Bengkulu — Temukan Event Seru di Bengkulu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =============================================
           PALET WARNA RAFLESIA + BATIK BASUREK
        ============================================= */
        :root {
            --raflesia-red:    #C0392B;
            --raflesia-light:  #E74C3C;
            --batik-gold:      #D4A843;
            --batik-dark:      #8B6914;
            --hutan-green:     #1A5C38;
            --hutan-light:     #27AE60;
            --cream:           #FDF8F0;
            --cream-dark:      #F5EDD8;
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--cream);
            font-family: 'Inter', sans-serif;
        }

        /* =============================================
           BATIK PATTERN — SVG Background
        ============================================= */
        .batik-pattern {
            background-color: var(--raflesia-red);
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4A843' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .batik-border {
            background: linear-gradient(90deg,
                var(--raflesia-red) 0%,
                var(--batik-gold) 25%,
                var(--hutan-green) 50%,
                var(--batik-gold) 75%,
                var(--raflesia-red) 100%
            );
            height: 4px;
        }

        /* =============================================
           RAFLESIA GRADIENT
        ============================================= */
        .hero-gradient {
            background: linear-gradient(135deg,
                #7B1E1E 0%,
                var(--raflesia-red) 40%,
                #8B2500 70%,
                #3D1A00 100%
            );
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4A843' fill-opacity='0.08'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* =============================================
           RAFLESIA DECORATIVE CIRCLE
        ============================================= */
        .raflesia-blob {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
            background: var(--batik-gold);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-20px) scale(1.05); }
        }

        /* =============================================
           CARD HOVER
        ============================================= */
        .event-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(192, 57, 43, 0.15);
        }

        .event-card img {
            transition: transform 0.5s ease;
        }

        .event-card:hover img {
            transform: scale(1.08);
        }

        /* =============================================
           SKELETON LOADING
        ============================================= */
        .skeleton {
            background: linear-gradient(90deg, #f0e8d8 25%, #e8dcc8 50%, #f0e8d8 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* =============================================
           PAGE TRANSITION
        ============================================= */
        .page-transition {
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* =============================================
           NAVBAR
        ============================================= */
        .navbar-scroll {
            transition: all 0.3s ease;
        }

        .navbar-scroll.scrolled {
            box-shadow: 0 4px 20px rgba(192, 57, 43, 0.15);
            backdrop-filter: blur(10px);
            background: rgba(253, 248, 240, 0.95);
        }

        /* =============================================
           BUTTON STYLES
        ============================================= */
        .btn-raflesia {
            background: linear-gradient(135deg, var(--raflesia-red), var(--raflesia-light));
            color: white;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(192, 57, 43, 0.3);
        }

        .btn-raflesia:hover {
            background: linear-gradient(135deg, #A93226, var(--raflesia-red));
            box-shadow: 0 6px 20px rgba(192, 57, 43, 0.45);
            transform: translateY(-1px);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--batik-dark), var(--batik-gold));
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 168, 67, 0.3);
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(212, 168, 67, 0.45);
        }

        .btn-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: white;
            color: var(--raflesia-red);
        }

        /* =============================================
           SECTION TITLE
        ============================================= */
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--raflesia-red), var(--batik-gold));
            margin: 12px auto 0;
            border-radius: 2px;
        }

        /* =============================================
           STAT COUNTER
        ============================================= */
        .stat-card {
            border-top: 3px solid var(--raflesia-red);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-top-color: var(--batik-gold);
            transform: translateY(-4px);
        }

        /* =============================================
           CATEGORY CHIP
        ============================================= */
        .category-chip {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .category-chip:hover {
            background: var(--raflesia-red);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(192, 57, 43, 0.3);
        }

        /* =============================================
           SCROLLBAR
        ============================================= */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb {
            background: var(--raflesia-red);
            border-radius: 3px;
        }
    </style>
</head>

<body class="page-transition">

    {{-- ============================================ --}}
    {{-- BATIK BORDER TOP                            --}}
    {{-- ============================================ --}}
    <div class="batik-border w-full"></div>

    {{-- ============================================ --}}
    {{-- NAVBAR                                      --}}
    {{-- ============================================ --}}
    <nav id="navbar" class="navbar-scroll bg-cream sticky top-0 z-50 border-b border-amber-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg shadow-sm"
                        style="background: linear-gradient(135deg, var(--raflesia-red), var(--raflesia-light))">
                        <img src="{{ asset('images/logo-raflesia.png') }}"
                        alt="Logo"
                        class="w-7 h-7 object-contain">
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-base leading-tight block">
                            Event Bengkulu
                        </span>
                        <span class="text-xs leading-tight block" style="color: var(--batik-dark)">
                            Discover Local Events
                        </span>
                    </div>
                </a>

                {{-- Nav Links (Desktop) --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="#features"
                        class="text-sm text-gray-600 hover:text-red-700 transition font-medium">
                        Fitur
                    </a>
                    <a href="#categories"
                        class="text-sm text-gray-600 hover:text-red-700 transition font-medium">
                        Kategori
                    </a>
                    <a href="#about"
                        class="text-sm text-gray-600 hover:text-red-700 transition font-medium">
                        Tentang
                    </a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn-raflesia px-5 py-2 rounded-xl text-sm font-semibold">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}"
                                class="btn-raflesia px-5 py-2 rounded-xl text-sm font-semibold">
                                Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-red-700 transition px-3 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="btn-raflesia px-5 py-2 rounded-xl text-sm font-semibold">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================ --}}
    {{-- HERO SECTION                                --}}
    {{-- ============================================ --}}
    <section class="hero-gradient text-white relative py-24 md:py-32 px-4 overflow-hidden">

        {{-- Decorative Blobs --}}
        <div class="raflesia-blob w-96 h-96 -top-20 -right-20"></div>
        <div class="raflesia-blob w-64 h-64 bottom-0 -left-16"
            style="animation-delay: 2s; background: var(--hutan-green)"></div>
        <div class="raflesia-blob w-32 h-32 top-1/2 right-1/4"
            style="animation-delay: 4s;"></div>

        <div class="max-w-5xl mx-auto text-center relative z-10">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-6"
                style="background: rgba(212,168,67,0.2); border: 1px solid rgba(212,168,67,0.4); color: var(--batik-gold)">
                <img src="{{ asset('images/logo-raflesia.png') }}" class="w-4 h-4 object-contain" alt="">
                Platform Event #1 di Bengkulu
            </div>

            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Temukan Event Seru<br>
                di <span style="color: var(--batik-gold)">Bumi Raflesia</span> 🌺
            </h1>

            <p class="text-red-100 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform terlengkap untuk menemukan berbagai event menarik
                di Kota Bengkulu. Dari festival budaya hingga konser musik!
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                @auth
                    <a href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('user.events.index') }}"
                        class="btn-gold px-8 py-3.5 rounded-xl text-sm font-bold inline-block">
                        🔍 Jelajahi Event Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="btn-gold px-8 py-3.5 rounded-xl text-sm font-bold inline-block">
                        🚀 Daftar Gratis Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                        class="btn-outline px-8 py-3.5 rounded-xl text-sm font-bold inline-block">
                        Sudah Punya Akun? Masuk
                    </a>
                @endauth
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 max-w-lg mx-auto">
                @foreach([
                    ['100+', 'Event Tersedia'],
                    ['6', 'Kategori Event'],
                    ['500+', 'Pengguna Aktif'],
                ] as [$num, $label])
                <div class="text-center">
                    <p class="text-2xl md:text-3xl font-bold" style="color: var(--batik-gold)">
                        {{ $num }}
                    </p>
                    <p class="text-xs text-red-200 mt-0.5">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Wave Bottom --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 60L1440 60L1440 0C1440 0 1080 60 720 60C360 60 0 0 0 0L0 60Z"
                    fill="#FDF8F0"/>
            </svg>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- SKELETON DEMO / EVENT PREVIEW               --}}
    {{-- ============================================ --}}
    <section class="py-16 px-4" id="events">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 section-title">
                    Event Pilihan Minggu Ini
                </h2>
                <p class="text-gray-500 text-sm mt-4">
                    Jangan sampai ketinggalan event seru di Bengkulu!
                </p>
            </div>

            {{-- Skeleton Cards (Loading State Demo) --}}
            <div id="skeletonGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                @for($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm">
                    <div class="skeleton h-48 w-full"></div>
                    <div class="p-5 space-y-3">
                        <div class="skeleton h-3 w-20 rounded"></div>
                        <div class="skeleton h-5 w-full rounded"></div>
                        <div class="skeleton h-4 w-3/4 rounded"></div>
                        <div class="skeleton h-4 w-1/2 rounded"></div>
                        <div class="flex justify-between mt-4">
                            <div class="skeleton h-8 w-20 rounded-lg"></div>
                            <div class="skeleton h-8 w-24 rounded-lg"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- Real Cards (muncul setelah skeleton) --}}
            <div id="realGrid"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                @php
                    $demoEvents = [
                        [
                            'title'    => 'Festival Tabot Bengkulu 2025',
                            'category' => 'Budaya',
                            'location' => 'Pantai Tapak Paderi',
                            'date'     => '15 Jan 2025',
                            'price'    => 'Gratis',
                            'badge'    => '⭐ Rekomendasi',
                            'badgeColor' => 'bg-yellow-400 text-yellow-900',
                            'img'      => 'https://placehold.co/600x400/C0392B/FDF8F0?text=Festival+Tabot',
                            'views'    => '1.2K',
                        ],
                        [
                            'title'    => 'Konser Musik Raflesia Night',
                            'category' => 'Musik',
                            'location' => 'GOR Semarak Bengkulu',
                            'date'     => '22 Jan 2025',
                            'price'    => 'Rp 75.000',
                            'badge'    => '🔥 Populer',
                            'badgeColor' => 'bg-orange-400 text-white',
                            'img'      => 'https://placehold.co/600x400/8B6914/FDF8F0?text=Konser+Musik',
                            'views'    => '3.5K',
                        ],
                        [
                            'title'    => 'Workshop Batik Basurek Bengkulu',
                            'category' => 'Budaya',
                            'location' => 'Museum Negeri Bengkulu',
                            'date'     => '28 Jan 2025',
                            'price'    => 'Rp 50.000',
                            'badge'    => '⭐ Rekomendasi',
                            'badgeColor' => 'bg-yellow-400 text-yellow-900',
                            'img'      => 'https://placehold.co/600x400/1A5C38/FDF8F0?text=Batik+Basurek',
                            'views'    => '980',
                        ],
                    ];
                @endphp

                @foreach($demoEvents as $ev)
                <div class="event-card bg-white rounded-2xl overflow-hidden shadow-sm border border-amber-50">
                    <div class="relative overflow-hidden">
                        <img src="{{ $ev['img'] }}"
                            class="w-full h-48 object-cover"
                            alt="{{ $ev['title'] }}">

                        {{-- Badge --}}
                        <span class="absolute top-3 left-3 text-xs px-2.5 py-1 rounded-full font-semibold {{ $ev['badgeColor'] }}">
                            {{ $ev['badge'] }}
                        </span>

                        {{-- Harga --}}
                        <span class="absolute bottom-3 left-3 text-xs px-2.5 py-1 rounded-full font-semibold text-white"
                            style="background: rgba(192,57,43,0.9)">
                            {{ $ev['price'] }}
                        </span>

                        {{-- Favorit --}}
                        <button class="absolute top-3 right-3 bg-white bg-opacity-90 rounded-full w-8 h-8 flex items-center justify-center shadow text-sm hover:scale-110 transition">
                            🤍
                        </button>
                    </div>

                    <div class="p-5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                            style="background: rgba(192,57,43,0.1); color: var(--raflesia-red)">
                            {{ $ev['category'] }}
                        </span>
                        <h3 class="font-bold text-gray-800 mt-2 mb-3 text-sm leading-snug">
                            {{ $ev['title'] }}
                        </h3>
                        <div class="space-y-1 text-xs text-gray-500 mb-4">
                            <p>📍 {{ $ev['location'] }}</p>
                            <p>📅 {{ $ev['date'] }}</p>
                            <p>👁️ {{ $ev['views'] }} views</p>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-amber-50">
                            @guest
                            <a href="{{ route('login') }}"
                                class="btn-raflesia px-4 py-1.5 rounded-lg text-xs font-semibold">
                                Lihat Detail
                            </a>
                            @else
                            <a href="{{ route('user.events.index') }}"
                                class="btn-raflesia px-4 py-1.5 rounded-lg text-xs font-semibold">
                                Lihat Detail
                            </a>
                            @endguest
                            <span class="text-xs text-gray-400">{{ $ev['date'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- CTA Lihat Semua --}}
            <div class="text-center mt-8">
                @auth
                    <a href="{{ route('user.events.index') }}"
                        class="btn-raflesia px-8 py-3 rounded-xl text-sm font-semibold inline-block">
                        Lihat Semua Event →
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="btn-raflesia px-8 py-3 rounded-xl text-sm font-semibold inline-block">
                        Daftar untuk Lihat Semua Event →
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- KATEGORI                                    --}}
    {{-- ============================================ --}}
    <section class="py-16 px-4" id="categories"
        style="background: var(--cream-dark)">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 section-title">
                    Jelajahi Berdasarkan Kategori
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach([
                    ['🎵', 'Musik',      '#C0392B'],
                    ['⚽', 'Olahraga',   '#1A5C38'],
                    ['🍜', 'Kuliner',    '#D4A843'],
                    ['🎨', 'Budaya',     '#8B6914'],
                    ['📚', 'Pendidikan', '#2980B9'],
                    ['🏔️', 'Pariwisata', '#16A085'],
                ] as [$icon, $name, $color])
                <div class="category-chip bg-white rounded-2xl p-5 text-center shadow-sm border border-amber-50 group">
                    <div class="text-3xl mb-2">{{ $icon }}</div>
                    <p class="text-sm font-semibold text-gray-700 group-hover:text-white transition">
                        {{ $name }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- FITUR                                       --}}
    {{-- ============================================ --}}
    <section class="py-16 px-4" id="features">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 section-title">
                    Kenapa Pilih Event Bengkulu?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['🎯', 'Rekomendasi Personal',  'Event dipilih sesuai minat dan kategori favoritmu secara otomatis.', 'var(--raflesia-red)'],
                    ['🔍', 'Filter Canggih',         'Cari event berdasarkan kategori, harga, waktu, dan lokasi dengan mudah.', 'var(--batik-dark)'],
                    ['❤️', 'Simpan Favorit',         'Tandai event favoritmu dan simpan untuk ditemukan kembali kapan saja.', 'var(--hutan-green)'],
                    ['🌺', 'Event Lokal Bengkulu',   'Fokus pada event lokal autentik yang mencerminkan kekayaan budaya Bengkulu.', 'var(--batik-gold)'],
                ] as [$icon, $title, $desc, $color])
                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm"
                    style="border-top-color: {{ $color }}">
                    <div class="text-4xl mb-4">{{ $icon }}</div>
                    <h3 class="font-bold text-gray-800 mb-2 text-base">{{ $title }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- TENTANG BENGKULU                            --}}
    {{-- ============================================ --}}
    <section class="py-16 px-4" id="about" style="background: var(--cream-dark)">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full mb-4 inline-block"
                        style="background: rgba(192,57,43,0.1); color: var(--raflesia-red)">
                        🌺 Tentang Kami
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 leading-snug">
                        Merayakan Keindahan<br>
                        <span style="color: var(--raflesia-red)">Budaya Bengkulu</span>
                    </h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Event Bengkulu hadir sebagai platform digital yang menghubungkan
                        masyarakat dengan berbagai kegiatan seru di Kota Bengkulu.
                        Terinspirasi dari keindahan bunga Raflesia dan motif Batik Basurek
                        yang kaya makna.
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Dari festival budaya tahunan hingga workshop seni, kami hadir
                        untuk memastikan kamu tidak melewatkan satu pun momen berharga
                        di Bumi Raflesia.
                    </p>
                    @guest
                    <a href="{{ route('register') }}"
                        class="btn-raflesia px-6 py-3 rounded-xl text-sm font-semibold inline-block">
                        Bergabung Sekarang 🌺
                    </a>
                    @endguest
                </div>

                {{-- Decorative Card --}}
                <div class="relative">
                    <div class="batik-pattern rounded-3xl p-8 text-white text-center relative overflow-hidden">
                        <div class="text-7xl mb-4">🌺</div>
                        <h3 class="text-xl font-bold mb-2">Bunga Raflesia</h3>
                        <p class="text-red-100 text-sm">
                            Simbol kebanggaan Bengkulu yang menginspirasi platform ini.
                            Langka, indah, dan bermakna — seperti setiap event di Bengkulu.
                        </p>
                        <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                            @foreach(['Musik', 'Budaya', 'Kuliner'] as $tag)
                            <span class="bg-white bg-opacity-20 rounded-xl py-2 text-xs font-medium">
                                {{ $tag }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Floating badge --}}
                    <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-lg p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                            style="background: linear-gradient(135deg, var(--batik-dark), var(--batik-gold))">
                            🏆
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Platform #1</p>
                            <p class="text-xs text-gray-400">Event di Bengkulu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- CTA SECTION                                 --}}
    {{-- ============================================ --}}
    @guest
    <section class="py-20 px-4 hero-gradient text-white relative overflow-hidden">
        <div class="raflesia-blob w-72 h-72 -top-10 -right-10"></div>
        <div class="raflesia-blob w-48 h-48 bottom-0 left-10"
            style="animation-delay: 3s; background: var(--batik-gold)"></div>

        <div class="max-w-3xl mx-auto text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Siap Menjelajahi<br>
                <span style="color: var(--batik-gold)">Bumi Raflesia? 🌺</span>
            </h2>
            <p class="text-red-100 text-base mb-8 max-w-xl mx-auto">
                Bergabung dengan ribuan pengguna yang sudah menemukan
                event terbaik di Bengkulu.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="btn-gold px-10 py-3.5 rounded-xl text-sm font-bold inline-block">
                    Daftar Gratis Sekarang 🚀
                </a>
                <a href="{{ route('login') }}"
                    class="btn-outline px-10 py-3.5 rounded-xl text-sm font-bold inline-block">
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>
    @endguest

    {{-- ============================================ --}}
    {{-- FOOTER                                      --}}
    {{-- ============================================ --}}
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg"
                            style="background: linear-gradient(135deg, var(--raflesia-red), var(--raflesia-light))">
                            🌺
                        </div>
                        <span class="font-bold text-lg">Event Bengkulu</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Platform event terbaik di Bengkulu. Terinspirasi dari
                        keindahan Raflesia dan Batik Basurek khas Bengkulu.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="font-semibold mb-4 text-sm" style="color: var(--batik-gold)">
                        Navigasi
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#categories" class="hover:text-white transition">Kategori</a></li>
                        <li><a href="#about" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="font-semibold mb-4 text-sm" style="color: var(--batik-gold)">
                        Kontak
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📍 Kota Bengkulu, Bengkulu</li>
                        <li>📧 info@eventbengkulu.com</li>
                        <li>📱 +62 736 XXXXXX</li>
                    </ul>
                </div>
            </div>

            <div class="batik-border w-full mb-6 opacity-30"></div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-500">
                <p>© {{ date('Y') }} Event Bengkulu. All rights reserved.</p>
                <p>Dibuat dengan ❤️ untuk Bumi Raflesia 🌺</p>
            </div>
        </div>
    </footer>

    {{-- ============================================ --}}
    {{-- JAVASCRIPT                                  --}}
    {{-- ============================================ --}}
    <script>
        // =============================================
        // NAVBAR SCROLL EFFECT
        // =============================================
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // =============================================
        // SKELETON → REAL CARDS
        // =============================================
        window.addEventListener('load', () => {
            setTimeout(() => {
                const skeleton = document.getElementById('skeletonGrid');
                const real     = document.getElementById('realGrid');
                if (skeleton && real) {
                    skeleton.style.opacity = '0';
                    skeleton.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        skeleton.classList.add('hidden');
                        real.classList.remove('hidden');
                        real.style.opacity = '0';
                        real.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => { real.style.opacity = '1'; }, 50);
                    }, 300);
                }
            }, 1500); // simulasi loading 1.5 detik
        });

        // =============================================
        // SMOOTH SCROLL
        // =============================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // =============================================
        // PAGE TRANSITION — link ke halaman lain
        // =============================================
        document.querySelectorAll('a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.body.style.opacity = '0';
                    document.body.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => { window.location = href; }, 300);
                });
            }
        });

        // =============================================
        // COUNTER ANIMATION
        // =============================================
        const animateCounter = (el, target, suffix = '') => {
            let count = 0;
            const step = Math.ceil(target / 60);
            const timer = setInterval(() => {
                count += step;
                if (count >= target) {
                    count = target;
                    clearInterval(timer);
                }
                el.textContent = count + suffix;
            }, 30);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('[data-count]');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-count'));
                        const suffix = counter.getAttribute('data-suffix') || '';
                        animateCounter(counter, target, suffix);
                    });
                    observer.unobserve(entry.target);
                }
            });
        });

        document.querySelectorAll('.stat-section').forEach(el => observer.observe(el));
    </script>

</body>
</html>