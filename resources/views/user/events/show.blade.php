@extends('layouts.app')
@section('title', $event->title)

@section('content')

{{-- ============================================ --}}
{{-- BREADCRUMB                                  --}}
{{-- ============================================ --}}
<nav id="breadcrumb" class="flex items-center gap-2 text-sm text-gray-400 mb-6" style="opacity:0">
    <a href="{{ route('user.events.index') }}"
        class="flex items-center gap-1.5 hover:text-red-600 transition-colors font-medium">
        <i class="ph ph-magnifying-glass text-base"></i>
        Jelajahi Event
    </a>
    <i class="ph ph-caret-right text-xs"></i>
    <span class="text-gray-600 font-medium truncate max-w-xs">{{ $event->title }}</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ============================================ --}}
    {{-- LEFT — MAIN CONTENT                         --}}
    {{-- ============================================ --}}
    <div class="lg:col-span-2 space-y-5" id="mainCol" style="opacity:0">

        {{-- Hero Image --}}
        <div class="card overflow-hidden p-0 relative">
            <div class="relative overflow-hidden" style="height: 340px">
                <img src="{{ $event->image
                        ? asset('storage/' . $event->image)
                        : 'https://placehold.co/800x400/C0392B/FDF8F0?text=' . urlencode($event->title) }}"
                    id="heroImage"
                    class="w-full h-full object-cover"
                    alt="{{ $event->title }}">

                {{-- Gradient --}}
                <div class="absolute inset-0"
                    style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 55%)">
                </div>

                {{-- Bottom Info Overlay --}}
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-full font-semibold"
                            style="background: rgba(255,255,255,0.18); color: white; backdrop-filter: blur(8px);
                                   border: 1px solid rgba(255,255,255,0.25)">
                            <i class="ph ph-tag text-xs"></i>
                            {{ $event->category->name }}
                        </span>
                        @if($event->is_recommended)
                        <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-full font-semibold"
                            style="background: rgba(212,168,67,0.88); color: #3D1500; backdrop-filter: blur(4px)">
                            <i class="ph ph-star-fill text-xs"></i>
                            Rekomendasi
                        </span>
                        @endif
                        @if($event->is_popular)
                        <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-full font-semibold"
                            style="background: rgba(234,88,12,0.88); color: white; backdrop-filter: blur(4px)">
                            <i class="ph ph-fire text-xs"></i>
                            Populer
                        </span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold text-white leading-tight drop-shadow-sm">
                        {{ $event->title }}
                    </h1>
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="card p-4">
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <i class="ph ph-eye text-base" style="color: var(--red-600)"></i>
                    <span><strong class="text-gray-800">{{ number_format($event->view_count) }}</strong> kali dilihat</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ph ph-heart text-base" style="color: var(--red-600)"></i>
                    <span><strong class="text-gray-800">{{ $event->favorites()->count() }}</strong> difavoritkan</span>
                </div>
                <div class="flex items-center gap-2 ml-auto">
                    <button onclick="copyLink(this)"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg transition-all hover:-translate-y-0.5"
                        style="background: var(--cream); color: #6B7280; border: 1px solid var(--cream-300)">
                        <i class="ph ph-link text-sm"></i>
                        Salin Link
                    </button>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="card p-6">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2 mb-4">
                <i class="ph ph-article text-lg" style="color: var(--red-600)"></i>
                Tentang Event
            </h2>
            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>

        {{-- Location Map Placeholder --}}
        <div class="card p-6">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2 mb-4">
                <i class="ph ph-map-pin text-lg" style="color: var(--red-600)"></i>
                Lokasi
            </h2>
            <div class="flex items-center gap-3 p-4 rounded-xl"
                style="background: var(--cream); border: 1px solid var(--cream-300)">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: var(--red-50)">
                    <i class="ph ph-map-pin text-xl" style="color: var(--red-600)"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $event->location }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Bengkulu, Indonesia</p>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================ --}}
    {{-- RIGHT — SIDEBAR INFO                        --}}
    {{-- ============================================ --}}
    <div class="space-y-4" id="sideCol" style="opacity:0">

        {{-- Sticky Wrapper --}}
        <div class="sticky top-20 space-y-4">

            {{-- Price & CTA Card --}}
            <div class="card overflow-hidden">
                {{-- Batik Header --}}
                <div class="h-2 batik-line"></div>

                <div class="p-5">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                        Harga Tiket
                    </p>
                    <p class="text-3xl font-bold mb-1
                        {{ $event->price == 0 ? '' : '' }}"
                        style="color: {{ $event->price == 0 ? 'var(--green-700)' : 'var(--red-600)' }}">
                        {{ $event->price == 0 ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                    </p>
                    @if($event->price == 0)
                    <p class="text-xs text-gray-400 flex items-center gap-1 mb-4">
                        <i class="ph ph-ticket text-sm"></i>
                        Tidak perlu membayar
                    </p>
                    @else
                    <p class="text-xs text-gray-400 flex items-center gap-1 mb-4">
                        <i class="ph ph-ticket text-sm"></i>
                        per orang
                    </p>
                    @endif

                    {{-- Fav Button --}}
                    <form id="favForm"
                        action="{{ $isFavorited
                            ? route('user.favorites.destroy', $event)
                            : route('user.favorites.store', $event) }}"
                        method="POST">
                        @csrf
                        @if($isFavorited) @method('DELETE') @endif
                        <button type="submit" id="favBtn"
                            class="w-full flex items-center justify-center gap-2.5 py-3 rounded-xl font-semibold text-sm
                                transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0"
                            style="{{ $isFavorited
                                ? 'background: var(--red-50); color: var(--red-600); border: 2px solid var(--red-200);'
                                : 'background: linear-gradient(135deg, var(--red-600), var(--red-500)); color: white; box-shadow: 0 4px 14px rgba(192,57,43,0.3);' }}">
                            <i id="favIcon"
                                class="{{ $isFavorited ? 'ph-fill ph-heart' : 'ph ph-heart' }} text-lg"></i>
                            <span id="favText">
                                {{ $isFavorited ? 'Tersimpan di Favorit' : 'Simpan ke Favorit' }}
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Event Details Card --}}
            <div class="card p-5 space-y-4">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                    <i class="ph ph-info text-base" style="color: var(--red-600)"></i>
                    Detail Event
                </h3>

                @foreach([
                    ['ph-calendar-blank', 'var(--red-50)', 'var(--red-600)', 'Tanggal Mulai',
                        $event->start_date->format('d M Y'), $event->start_date->format('H:i') . ' WIB'],
                    ['ph-calendar-check', '#F0FDF4', 'var(--green-700)', 'Tanggal Selesai',
                        $event->end_date->format('d M Y'), $event->end_date->format('H:i') . ' WIB'],
                    ['ph-map-pin', '#FFF7ED', '#EA580C', 'Lokasi',
                        $event->location, 'Bengkulu, Indonesia'],
                    ['ph-users', '#FFFBEB', 'var(--gold-600)', 'Kuota',
                        $event->quota ? number_format($event->quota) . ' orang' : 'Tidak Terbatas', ''],
                ] as [$icon, $iconBg, $iconColor, $label, $val, $sub])
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                        style="background: {{ $iconBg }}">
                        <i class="ph {{ $icon }} text-base" style="color: {{ $iconColor }}"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400 font-medium">{{ $label }}</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $val }}</p>
                        @if($sub)
                        <p class="text-xs text-gray-400">{{ $sub }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Penyelenggara --}}
            <div class="card p-5">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                    <i class="ph ph-user-circle text-base" style="color: var(--red-600)"></i>
                    Penyelenggara
                </h3>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($event->user->name) }}&background=C0392B&color=fff&size=48&bold=true"
                        class="w-11 h-11 rounded-xl object-cover flex-shrink-0"
                        alt="{{ $event->user->name }}">
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $event->user->name }}</p>
                        <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                            <i class="ph ph-shield-check text-xs" style="color: var(--green-700)"></i>
                            Admin Event Bengkulu
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- RELATED EVENTS                              --}}
{{-- ============================================ --}}
@if($relatedEvents->count() > 0)
<section class="mt-12" id="relatedSection" style="opacity:0">
    <div class="flex items-center justify-between mb-6">
        <div class="section-label">
            <div class="accent-bar"
                style="background: linear-gradient(180deg, var(--red-600), var(--gold-400))">
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="ph ph-circles-four text-xl" style="color: var(--red-600)"></i>
                    Event Terkait
                </h2>
                <p class="text-xs text-gray-400 mt-0.5">
                    Event lain dalam kategori {{ $event->category->name }}
                </p>
            </div>
        </div>
        <a href="{{ route('user.events.index', ['category' => $event->category_id]) }}"
            class="inline-flex items-center gap-1.5 text-sm font-semibold transition-all hover:gap-2.5"
            style="color: var(--red-600)">
            Lihat Semua
            <i class="ph ph-arrow-right text-base"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($relatedEvents as $related)
        <div class="related-item">
            @include('user._partials.event-card', ['event' => $related])
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap === 'undefined') return;

    // =============================================
    // PAGE ANIMATE IN
    // =============================================
    gsap.set(['#breadcrumb','#mainCol','#sideCol'], { opacity: 0 });
    gsap.set('#breadcrumb', { y: -12 });
    gsap.set('#mainCol', { y: 24 });
    gsap.set('#sideCol', { y: 24, x: 16 });

    const tl = gsap.timeline({ delay: 0.1 });
    tl.to('#breadcrumb', { opacity: 1, y: 0, duration: 0.4, ease: 'power3.out' })
      .to('#mainCol',    { opacity: 1, y: 0, duration: 0.5, ease: 'power3.out' }, '-=0.2')
      .to('#sideCol',    { opacity: 1, y: 0, x: 0, duration: 0.5, ease: 'power3.out' }, '-=0.35');

    // =============================================
    // HERO IMAGE PARALLAX
    // =============================================
    const heroImg = document.getElementById('heroImage');
    if (heroImg) {
        window.addEventListener('scroll', () => {
            const offset = window.scrollY * 0.25;
            heroImg.style.transform = `translateY(${offset}px) scale(1.08)`;
        }, { passive: true });
    }

    // =============================================
    // FAV BUTTON ANIMATION
    // =============================================
    const favBtn  = document.getElementById('favBtn');
    const favIcon = document.getElementById('favIcon');
    const favText = document.getElementById('favText');

    if (favBtn) {
        favBtn.addEventListener('click', (e) => {
            // Pulse animation
            gsap.timeline()
                .to(favBtn, { scale: 0.94, duration: 0.1, ease: 'power2.in' })
                .to(favBtn, { scale: 1,    duration: 0.4, ease: 'elastic.out(1.4, 0.5)' });

            // Icon bounce
            gsap.from(favIcon, {
                scale: 0, rotation: -20,
                duration: 0.4, ease: 'back.out(2)',
                delay: 0.05
            });
        });
    }

    // =============================================
    // RELATED EVENTS SCROLL TRIGGER
    // =============================================
    if (document.getElementById('relatedSection')) {
        ScrollTrigger.create({
            trigger: '#relatedSection',
            start: 'top 85%',
            onEnter: () => {
                gsap.to('#relatedSection', {
                    opacity: 1, duration: 0.4, ease: 'power2.out'
                });
                gsap.from('.related-item', {
                    opacity: 0, y: 30, scale: 0.97,
                    duration: 0.5, ease: 'power3.out',
                    stagger: 0.1
                });
            }
        });
    }

    // =============================================
    // STICKY SIDEBAR SUBTLE FLOAT
    // =============================================
    gsap.to('#sideCol .sticky', {
        y: -4,
        duration: 2.5,
        ease: 'sine.inOut',
        yoyo: true,
        repeat: -1,
        delay: 1
    });
});

// =============================================
// COPY LINK
// =============================================
function copyLink(btn) {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const icon = btn.querySelector('i');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="ph ph-check text-sm"></i> Tersalin!';
        btn.style.color = 'var(--green-700)';
        btn.style.borderColor = 'var(--green-700)';
        setTimeout(() => {
            btn.innerHTML = original;
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 2000);
    });
}
</script>
@endpush