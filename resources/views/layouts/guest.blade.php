<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Event Bengkulu') }} — @yield('title', 'Auth')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-raflesia.png') }}">

    {{-- Phosphor Icons --}}
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    {{-- GSAP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

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
            min-height: 100vh;
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
           AUTH LAYOUT
        ============================================= */
        .auth-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
        }

        @media (min-width: 1024px) {
            .auth-wrapper {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Left panel — decorative */
        .auth-panel-left {
            display: none;
            position: relative;
            background: linear-gradient(135deg, #6B1A1A 0%, var(--red-600) 45%, #7A2200 80%, #3D1500 100%);
            overflow: hidden;
        }

        @media (min-width: 1024px) {
            .auth-panel-left { display: flex; flex-direction: column; justify-content: center; padding: 3rem; }
        }

        /* Batik pattern overlay */
        .batik-pattern {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D4A843' fill-opacity='0.12'%3E%3Cpath d='M26 26c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S16 41.523 16 36s4.477-10 10-10zM6 6c0-5.523 4.477-10 10-10s10 4.477 10 10S21.523 16 16 16c0 5.523-4.477 10-10 10S-4 21.523-4 16 .477 6 6 6z'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 52px 52px;
        }

        .auth-blob-1 {
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212,168,67,0.18), transparent 70%);
            pointer-events: none;
        }

        .auth-blob-2 {
            position: absolute;
            bottom: -80px; left: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(26,92,56,0.22), transparent 70%);
            pointer-events: none;
        }

        /* Right panel — form */
        .auth-panel-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            background: var(--cream);
        }

        @media (min-width: 640px) {
            .auth-panel-right { padding: 3rem 2rem; }
        }

        /* =============================================
           AUTH CARD
        ============================================= */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(212, 168, 67, 0.15);
            box-shadow: 0 4px 24px rgba(192, 57, 43, 0.06),
                        0 1px 4px rgba(0,0,0,0.04);
            padding: 2rem;
            opacity: 0;
            transform: translateY(20px);
        }

        @media (min-width: 480px) {
            .auth-card { padding: 2.5rem; }
        }

        /* =============================================
           FORM ELEMENTS
        ============================================= */
        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.375rem;
            letter-spacing: 0.01em;
        }

        .form-input {
            width: 100%;
            padding: 0.65rem 0.875rem 0.65rem 2.75rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 12px;
            font-size: 0.875rem;
            color: #111827;
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            border-color: var(--red-600);
            box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.08);
        }

        .form-input::placeholder { color: #9CA3AF; }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--red-600);
        }

        .input-toggle {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #9CA3AF;
            font-size: 1rem;
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .input-toggle:hover { color: var(--red-600); }

        .form-input.has-toggle { padding-right: 2.75rem; }

        /* Error */
        .form-error {
            margin-top: 0.375rem;
            font-size: 0.75rem;
            color: var(--red-600);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* =============================================
           BUTTONS
        ============================================= */
        .btn-primary {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--red-600), var(--red-500));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.01em;
            box-shadow: 0 4px 14px rgba(192, 57, 43, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(192, 57, 43, 0.38);
            background: linear-gradient(135deg, var(--red-700), var(--red-600));
        }

        .btn-primary:active { transform: translateY(0); }

        /* =============================================
           DIVIDER
        ============================================= */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.5rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(212, 168, 67, 0.25);
        }

        .auth-divider span {
            font-size: 0.75rem;
            color: #9CA3AF;
            font-weight: 500;
        }

        /* =============================================
           CHECKBOX
        ============================================= */
        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .custom-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 1.5px solid #D1D5DB;
            border-radius: 5px;
            accent-color: var(--red-600);
            cursor: pointer;
        }

        .custom-checkbox span {
            font-size: 0.8125rem;
            color: #6B7280;
        }

        /* =============================================
           SESSION STATUS
        ============================================= */
        .alert-success {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            background: #F0FDF4;
            border: 1px solid rgba(26, 92, 56, 0.2);
            color: var(--green-700);
            font-size: 0.8125rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* =============================================
           SCROLLBAR
        ============================================= */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--red-600); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--red-700); }
    </style>
</head>

<body>

    {{-- Batik Top Border --}}
    <div class="batik-line fixed top-0 left-0 right-0 z-50"></div>

    <div class="auth-wrapper pt-[3px]">

        {{-- ============================================ --}}
        {{-- LEFT PANEL — Decorative                      --}}
        {{-- ============================================ --}}
        <div class="auth-panel-left" id="authPanelLeft">
            <div class="batik-pattern"></div>
            <div class="auth-blob-1"></div>
            <div class="auth-blob-2"></div>

            {{-- Content --}}
            <div class="relative z-10">
                {{-- Logo --}}
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-11 h-11 rounded-2xl overflow-hidden flex items-center justify-center shadow-md flex-shrink-0"
                        style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2)">
                        <img src="{{ asset('images/logo-raflesia.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                    </div>
                    <div class="leading-tight">
                        <p class="font-bold text-white text-base">Event Bengkulu</p>
                        <p class="text-xs" style="color: var(--gold-300)">Discover Local Events</p>
                    </div>
                </div>

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold mb-6"
                    style="background: rgba(212,168,67,0.18); border: 1px solid rgba(212,168,67,0.35); color: var(--gold-300)">
                    <i class="ph ph-map-pin text-sm"></i>
                    Bumi Raflesia, Bengkulu
                </div>

                <h1 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                    Temukan Event<br>
                    <span style="color: var(--gold-300)">Terbaik</span> di<br>Bengkulu
                </h1>

                <p class="text-sm leading-relaxed mb-10" style="color: rgba(255,255,255,0.65)">
                    Platform event lokal terpercaya. Jelajahi, favorit, dan dapatkan rekomendasi event seru sesuai minatmu.
                </p>

                {{-- Feature list --}}
                <div class="flex flex-col gap-4">
                    @foreach([
                        ['ph-magnifying-glass', 'Jelajahi ratusan event lokal'],
                        ['ph-sparkle',          'Rekomendasi personal untukmu'],
                        ['ph-heart',            'Simpan event favoritmu'],
                    ] as [$icon, $text])
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.15)">
                            <i class="ph {{ $icon }} text-base" style="color: var(--gold-300)"></i>
                        </div>
                        <span class="text-sm font-medium" style="color: rgba(255,255,255,0.85)">{{ $text }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Bottom decoration --}}
                <div class="mt-16 pt-8" style="border-top: 1px solid rgba(255,255,255,0.1)">
                    <p class="text-xs" style="color: rgba(255,255,255,0.4)">
                        &copy; {{ date('Y') }} Event Bengkulu. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- RIGHT PANEL — Form                           --}}
        {{-- ============================================ --}}
        <div class="auth-panel-right">
            <div class="auth-card" id="authCard">

                {{-- Mobile logo (only visible on small screens) --}}
                <div class="flex items-center gap-3 mb-6 lg:hidden">
                    <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
                        <img src="{{ asset('images/logo-raflesia.png') }}" class="w-7 h-7 object-contain" alt="Logo">
                    </div>
                    <div class="leading-tight">
                        <p class="font-bold text-gray-800 text-sm">Event Bengkulu</p>
                        <p class="text-xs" style="color: var(--gold-600)">Discover Local Events</p>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </div>

    </div>{{-- end auth-wrapper --}}

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof gsap === 'undefined') return;

        // Card animate in
        gsap.to('#authCard', {
            opacity: 1,
            y: 0,
            duration: 0.7,
            ease: 'power3.out',
            delay: 0.15
        });

        // Left panel slide in
        gsap.from('#authPanelLeft', {
            x: -40,
            opacity: 0,
            duration: 0.9,
            ease: 'power3.out',
            delay: 0.05
        });
    });
    </script>

</body>
</html>