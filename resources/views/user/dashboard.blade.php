@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ============================================ --}}
{{-- HERO GREETING                               --}}
{{-- ============================================ --}}
<div id="heroGreeting" class="relative rounded-3xl overflow-hidden mb-8"
    style="background: linear-gradient(135deg, #6B1A1A 0%, var(--red-600) 45%, #7A2200 80%, #3D1500 100%); opacity: 0;">

    {{-- Batik pattern overlay --}}
    <div class="absolute inset-0 pointer-events-none"
        style="background-image: url(\"data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D4A843' fill-opacity='0.12'%3E%3Cpath d='M26 26c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S16 41.523 16 36s4.477-10 10-10zM6 6c0-5.523 4.477-10 10-10s10 4.477 10 10S21.523 16 16 16c0 5.523-4.477 10-10 10S-4 21.523-4 16 .477 6 6 6z'/%3E%3C/g%3E%3C/svg%3E\");
               background-size: 52px 52px;">
    </div>

    {{-- Blobs --}}
    <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full pointer-events-none"
        style="background: radial-gradient(circle, rgba(212,168,67,0.18), transparent 70%)"></div>
    <div class="absolute -left-12 -bottom-12 w-48 h-48 rounded-full pointer-events-none"
        style="background: radial-gradient(circle, rgba(26,92,56,0.20), transparent 70%)"></div>

    {{-- Content --}}
    <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-3"
                style="background: rgba(212,168,67,0.2); border: 1px solid rgba(212,168,67,0.35); color: var(--gold-300)">
                <i class="ph ph-sun text-sm"></i>
                Selamat datang kembali
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-1 leading-tight">
                {{ Auth::user()->name }}
            </h1>
            <p class="text-sm" style="color: rgba(255,255,255,0.65)">
                Temukan event seru di Bumi Raflesia hari ini
            </p>
        </div>

        <div class="flex gap-3 flex-wrap flex-shrink-0">
            <a href="{{ route('user.events.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:-translate-y-0.5"
                style="background: rgba(255,255,255,0.12); color: white; border: 1px solid rgba(255,255,255,0.22); backdrop-filter: blur(8px)">
                <i class="ph ph-magnifying-glass text-base"></i>
                Jelajahi Event
            </a>
            <a href="{{ route('user.recommendations.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:-translate-y-0.5"
                style="background: var(--gold-400); color: #3D1500;">
                <i class="ph ph-sparkle text-base"></i>
                Rekomendasi
            </a>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0 h-8 pointer-events-none"
        style="background: linear-gradient(to top, rgba(253,248,240,0.08), transparent)">
    </div>
</div>

{{-- ============================================ --}}
{{-- QUICK STATS                                 --}}
{{-- ============================================ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
    @php
        $stats = [
            [
                'icon'    => 'ph-heart',
                'value'   => Auth::user()->favorites()->count(),
                'label'   => 'Event Favorit',
                'bg'      => 'var(--red-50)',
                'color'   => 'var(--red-600)',
                'barColor'=> 'var(--red-600)',
                'iconBg'  => 'var(--red-100)',
            ],
            [
                'icon'    => 'ph-sparkle',
                'value'   => $recommendedEvents->count(),
                'label'   => 'Rekomendasi',
                'bg'      => '#FFFBEB',
                'color'   => 'var(--gold-400)',
                'barColor'=> 'var(--gold-400)',
                'iconBg'  => '#FEF9C3',
            ],
            [
                'icon'    => 'ph-fire',
                'value'   => $popularEvents->count(),
                'label'   => 'Event Populer',
                'bg'      => '#FFF7ED',
                'color'   => '#EA580C',
                'barColor'=> '#EA580C',
                'iconBg'  => '#FFEDD5',
            ],
            [
                'icon'    => 'ph-calendar-blank',
                'value'   => \App\Models\Event::where('is_active', true)->count(),
                'label'   => 'Total Event',
                'bg'      => '#F0FDF4',
                'color'   => 'var(--green-700)',
                'barColor'=> 'var(--green-700)',
                'iconBg'  => '#DCFCE7',
            ],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="stat-card gs-stat"
        style="background: {{ $stat['bg'] }}; --bar: {{ $stat['barColor'] }}">
        <style>
            .stat-card:nth-child({{ $loop->index + 1 }})::before {
                background: {{ $stat['barColor'] }};
            }
        </style>

        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                style="background: {{ $stat['iconBg'] }}">
                <i class="ph {{ $stat['icon'] }} text-xl" style="color: {{ $stat['color'] }}"></i>
            </div>
            <span class="text-2xl font-bold stat-number" style="color: {{ $stat['color'] }}"
                data-target="{{ $stat['value'] }}">
                0
            </span>
        </div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
            {{ $stat['label'] }}
        </p>
    </div>
    @endforeach
</div>

{{-- ============================================ --}}
{{-- EVENT REKOMENDASI                           --}}
{{-- ============================================ --}}
@if($recommendedEvents->count() > 0)
<section class="mb-12">
    <div class="flex items-center justify-between mb-6 gs-fade-up">
        <div class="section-label">
            <div class="accent-bar" style="background: linear-gradient(180deg, var(--red-600), var(--gold-400))"></div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="ph ph-star text-xl" style="color: var(--gold-400)"></i>
                    Event Rekomendasi
                </h2>
                <p class="text-xs text-gray-400 mt-0.5">Dipilih tim Event Bengkulu untukmu</p>
            </div>
        </div>
        <a href="{{ route('user.recommendations.index') }}"
            class="inline-flex items-center gap-1.5 text-sm font-semibold transition-all hover:gap-2.5"
            style="color: var(--red-600)">
            Lihat Semua
            <i class="ph ph-arrow-right text-base"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($recommendedEvents as $event)
        <div class="gs-fade-up">
            @include('user._partials.event-card', ['event' => $event])
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- EVENT POPULER                               --}}
{{-- ============================================ --}}
@if($popularEvents->count() > 0)
<section class="mb-6">
    <div class="flex items-center justify-between mb-6 gs-fade-up">
        <div class="section-label">
            <div class="accent-bar" style="background: linear-gradient(180deg, #EA580C, var(--gold-400))"></div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="ph ph-fire text-xl" style="color: #EA580C"></i>
                    Event Populer
                </h2>
                <p class="text-xs text-gray-400 mt-0.5">Paling banyak diminati di Bengkulu</p>
            </div>
        </div>
        <a href="{{ route('user.recommendations.index') }}"
            class="inline-flex items-center gap-1.5 text-sm font-semibold transition-all hover:gap-2.5"
            style="color: var(--red-600)">
            Lihat Semua
            <i class="ph ph-arrow-right text-base"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($popularEvents as $event)
        <div class="gs-fade-up">
            @include('user._partials.event-card', ['event' => $event])
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- EMPTY STATE                                 --}}
{{-- ============================================ --}}
@if($recommendedEvents->isEmpty() && $popularEvents->isEmpty())
<div class="card p-16 text-center gs-fade-up">
    <div class="w-20 h-20 rounded-2xl overflow-hidden flex items-center justify-center mx-auto mb-5 shadow-lg"
        style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
        <img src="{{ asset('images/logo-raflesia.png') }}" class="w-14 h-14 object-contain" alt="">
    </div>
    <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Event</h3>
    <p class="text-sm text-gray-400 mb-6 max-w-xs mx-auto leading-relaxed">
        Admin belum menambahkan event. Cek kembali nanti ya!
    </p>
    <a href="{{ route('user.events.index') }}" class="btn-primary mx-auto">
        <i class="ph ph-magnifying-glass text-base"></i>
        Jelajahi Event
    </a>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap === 'undefined') return;

    // =============================================
    // HERO GREETING ANIMATE IN
    // =============================================
    gsap.to('#heroGreeting', {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: 'power3.out',
        delay: 0.2
    });

    gsap.from('#heroGreeting', {
        y: 30,
        duration: 0.8,
        ease: 'power3.out',
        delay: 0.2
    });

    // =============================================
    // STAT COUNTER ANIMATION
    // =============================================
    gsap.utils.toArray('.stat-number').forEach((el) => {
        const target = parseInt(el.getAttribute('data-target')) || 0;
        ScrollTrigger.create({
            trigger: el,
            start: 'top 90%',
            once: true,
            onEnter: () => {
                gsap.to({ val: 0 }, {
                    val: target,
                    duration: 1.2,
                    ease: 'power2.out',
                    onUpdate: function() {
                        el.textContent = Math.round(this.targets()[0].val);
                    }
                });
            }
        });
    });
});
</script>
@endpush