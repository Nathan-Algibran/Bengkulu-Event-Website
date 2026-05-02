@extends('layouts.app')
@section('title', 'Favorit Saya')

@section('content')

{{-- ============================================ --}}
{{-- PAGE HEADER                                 --}}
{{-- ============================================ --}}
<div id="pageHeader">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                style="background: linear-gradient(135deg, var(--red-600), var(--red-500));
                       box-shadow: 0 4px 14px rgba(192,57,43,0.3)">
                <i class="ph ph-heart text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Favorit Saya</h1>
                <p class="text-gray-400 text-sm mt-0.5">
                    Event yang telah kamu simpan
                </p>
            </div>
        </div>

        {{-- Count Badge --}}
        @if($favorites->total() > 0)
        <div class="flex items-center gap-2 px-5 py-2.5 rounded-2xl flex-shrink-0"
            style="background: var(--red-50); border: 1.5px solid var(--red-100)">
            <i class="ph ph-heart-fill text-lg" style="color: var(--red-600)"></i>
            <span class="font-bold text-gray-800">{{ $favorites->total() }}</span>
            <span class="text-sm text-gray-500">Event Tersimpan</span>
        </div>
        @endif
    </div>
</div>

{{-- ============================================ --}}
{{-- CONTENT                                     --}}
{{-- ============================================ --}}
@if($favorites->count() > 0)

    {{-- Sort & Filter Bar --}}
    <div id="toolbar" class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <p class="text-sm text-gray-500">
            Menampilkan
            <span class="font-bold text-gray-800">{{ $favorites->firstItem() }}–{{ $favorites->lastItem() }}</span>
            dari
            <span class="font-bold text-gray-800">{{ $favorites->total() }}</span>
            event
        </p>
        <a href="{{ route('user.events.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-xl transition-all hover:-translate-y-0.5"
            style="background: var(--red-50); color: var(--red-600); border: 1.5px solid var(--red-100)">
            <i class="ph ph-magnifying-glass text-base"></i>
            Tambah Favorit
        </a>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="favGrid">
        @foreach($favorites as $event)
        <div class="fav-item" id="fav-item-{{ $event->id }}">
            <div class="card event-card overflow-hidden h-full flex flex-col">

                {{-- Image --}}
                <div class="card-image relative flex-shrink-0">
                    <a href="{{ route('user.events.show', $event->slug) }}">
                        <img src="{{ $event->image
                                ? asset('storage/' . $event->image)
                                : 'https://placehold.co/600x400/C0392B/FDF8F0?text=' . urlencode($event->title) }}"
                            alt="{{ $event->title }}"
                            class="w-full object-cover"
                            style="height: 176px"
                            loading="lazy">
                        <div class="card-overlay"></div>
                    </a>

                    {{-- Badges --}}
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 z-10">
                        @if($event->is_recommended)
                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-semibold"
                            style="background: rgba(212,168,67,0.92); color: #3D1500; backdrop-filter: blur(4px)">
                            <i class="ph ph-star-fill text-xs"></i> Rekomendasi
                        </span>
                        @endif
                        @if($event->is_popular)
                        <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-semibold"
                            style="background: rgba(234,88,12,0.88); color: white; backdrop-filter: blur(4px)">
                            <i class="ph ph-fire text-xs"></i> Populer
                        </span>
                        @endif
                    </div>

                    {{-- Remove Favorite Button --}}
                    <form action="{{ route('user.favorites.destroy', $event) }}"
                        method="POST"
                        class="absolute top-3 right-3 z-10"
                        onsubmit="return removeFavorite(event, {{ $event->id }})">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="fav-btn active"
                            title="Hapus dari favorit">
                            <i class="ph-fill ph-heart text-lg" style="color: var(--red-600)"></i>
                        </button>
                    </form>

                    {{-- Price --}}
                    <div class="absolute bottom-3 left-3 z-10">
                        <span class="price-badge">
                            <i class="ph ph-ticket text-xs"></i>
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-4 flex flex-col flex-1">
                    <span class="category-pill mb-2">
                        <i class="ph ph-tag text-xs"></i>
                        {{ $event->category->name }}
                    </span>

                    <a href="{{ route('user.events.show', $event->slug) }}" class="flex-1">
                        <h4 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2
                            transition-colors hover:text-red-700 mb-3">
                            {{ $event->title }}
                        </h4>
                    </a>

                    <div class="space-y-1.5 mb-3">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="ph ph-map-pin text-sm flex-shrink-0" style="color: var(--red-600)"></i>
                            <span class="truncate">{{ $event->location }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="ph ph-calendar text-sm flex-shrink-0" style="color: var(--gold-600)"></i>
                            <span>{{ $event->start_date->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-amber-50 mt-auto">
                        <div class="flex items-center gap-1 text-xs text-gray-400">
                            <i class="ph ph-eye text-sm"></i>
                            {{ number_format($event->view_count) }} views
                        </div>
                        <a href="{{ route('user.events.show', $event->slug) }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg
                            transition-all hover:gap-2.5 hover:-translate-y-0.5"
                            style="color: var(--red-600); background: var(--red-50)">
                            Lihat Detail
                            <i class="ph ph-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($favorites->hasPages())
    <div class="mt-8 flex justify-center" id="pagination">
        {{ $favorites->links() }}
    </div>
    @endif

@else

    {{-- ============================================ --}}
    {{-- EMPTY STATE                                 --}}
    {{-- ============================================ --}}
    <div class="card p-16 text-center" id="emptyState">
        <div class="relative w-24 h-24 mx-auto mb-6">
            {{-- Outer ring --}}
            <div class="absolute inset-0 rounded-full animate-ping opacity-20"
                style="background: var(--red-600)"></div>
            <div class="relative w-24 h-24 rounded-full flex items-center justify-center"
                style="background: linear-gradient(135deg, var(--red-50), var(--cream-200))">
                <i class="ph ph-heart text-4xl" style="color: var(--red-600)"></i>
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Favorit</h3>
        <p class="text-sm text-gray-400 mb-8 max-w-sm mx-auto leading-relaxed">
            Kamu belum menyimpan event apapun. Jelajahi event seru dan
            tekan tombol hati untuk menyimpannya di sini!
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('user.events.index') }}" class="btn-primary">
                <i class="ph ph-magnifying-glass text-base"></i>
                Jelajahi Event
            </a>
            <a href="{{ route('user.recommendations.index') }}" class="btn-ghost">
                <i class="ph ph-sparkle text-base"></i>
                Lihat Rekomendasi
            </a>
        </div>
    </div>

@endif

@endsection

@push('scripts')
<style>
    /* Confirm Dialog */
    #confirmDialog {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    #confirmDialog.show { display: flex; }

    #confirmOverlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(4px);
    }

    #confirmBox {
        position: relative;
        background: white;
        border-radius: 24px;
        padding: 28px;
        width: 100%;
        max-width: 380px;
        box-shadow: 0 24px 64px rgba(0,0,0,0.15);
        z-index: 1;
    }
</style>

{{-- Custom Confirm Dialog --}}
<div id="confirmDialog">
    <div id="confirmOverlay" onclick="cancelRemove()"></div>
    <div id="confirmBox">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
            style="background: var(--red-50)">
            <i class="ph ph-heart-break text-3xl" style="color: var(--red-600)"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 text-center mb-1">
            Hapus dari Favorit?
        </h3>
        <p class="text-sm text-gray-400 text-center mb-6 leading-relaxed">
            Event ini akan dihapus dari daftar favoritmu. Kamu bisa menambahkannya lagi kapan saja.
        </p>
        <div class="flex gap-3">
            <button onclick="cancelRemove()"
                class="btn-ghost flex-1 justify-center">
                <i class="ph ph-x text-base"></i>
                Batal
            </button>
            <button onclick="confirmRemove()"
                class="btn-primary flex-1 justify-center"
                style="background: linear-gradient(135deg, var(--red-700), var(--red-600))">
                <i class="ph ph-trash text-base"></i>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let pendingForm   = null;
let pendingItemId = null;

// =============================================
// REMOVE FAVORITE — Custom Confirm
// =============================================
function removeFavorite(e, itemId) {
    e.preventDefault();
    pendingForm   = e.target;
    pendingItemId = itemId;

    const dialog = document.getElementById('confirmDialog');
    dialog.classList.add('show');

    // Animate dialog in
    gsap.set('#confirmBox', { opacity: 0, scale: 0.85, y: 20 });
    gsap.set('#confirmOverlay', { opacity: 0 });

    gsap.to('#confirmOverlay', { opacity: 1, duration: 0.3, ease: 'power2.out' });
    gsap.to('#confirmBox', {
        opacity: 1, scale: 1, y: 0,
        duration: 0.4, ease: 'back.out(1.6)'
    });

    return false;
}

function cancelRemove() {
    const dialog = document.getElementById('confirmDialog');

    gsap.to('#confirmBox', {
        opacity: 0, scale: 0.9, y: 10,
        duration: 0.25, ease: 'power2.in'
    });
    gsap.to('#confirmOverlay', {
        opacity: 0, duration: 0.25, ease: 'power2.in',
        onComplete: () => {
            dialog.classList.remove('show');
            pendingForm   = null;
            pendingItemId = null;
        }
    });
}

function confirmRemove() {
    if (!pendingForm || !pendingItemId) return;

    const item = document.getElementById('fav-item-' + pendingItemId);

    // Close dialog
    document.getElementById('confirmDialog').classList.remove('show');

    // Animate card out
    gsap.to(item, {
        opacity: 0,
        scale: 0.85,
        y: -20,
        duration: 0.4,
        ease: 'power3.in',
        onComplete: () => {
            // Submit form after animation
            pendingForm.submit();
        }
    });
}

// =============================================
// PAGE ANIMATE IN
// =============================================
window.addEventListener('load', () => {
    gsap.registerPlugin(ScrollTrigger);

    // Set initial
    gsap.set('#pageHeader', { opacity: 0, y: 24 });
    gsap.set('#toolbar',    { opacity: 0, y: 16 });
    gsap.set('.fav-item',   { opacity: 0, y: 30, scale: 0.96 });

    // Animate
    const tl = gsap.timeline({ delay: 0.1 });

    tl.to('#pageHeader', {
        opacity: 1, y: 0,
        duration: 0.6, ease: 'power3.out'
    })
    .to('#toolbar', {
        opacity: 1, y: 0,
        duration: 0.4, ease: 'power3.out'
    }, '-=0.3')
    .to('.fav-item', {
        opacity: 1, y: 0, scale: 1,
        duration: 0.5, ease: 'power3.out',
        stagger: 0.07
    }, '-=0.2');

    // Empty state
    const empty = document.getElementById('emptyState');
    if (empty) {
        gsap.set(empty, { opacity: 0, scale: 0.95 });
        gsap.to(empty, {
            opacity: 1, scale: 1,
            duration: 0.6, ease: 'back.out(1.4)',
            delay: 0.3
        });
    }

    // Pagination
    gsap.from('#pagination', {
        opacity: 0, y: 16,
        duration: 0.5, ease: 'power3.out',
        delay: 0.6,
        scrollTrigger: {
            trigger: '#pagination',
            start: 'top 90%'
        }
    });

    // =============================================
    // HOVER TILT EFFECT ON CARDS
    // =============================================
    document.querySelectorAll('.fav-item .card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect   = card.getBoundingClientRect();
            const x      = e.clientX - rect.left;
            const y      = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / centerY * -4;
            const rotateY = (x - centerX) / centerX * 4;

            gsap.to(card, {
                rotateX, rotateY,
                transformPerspective: 800,
                duration: 0.3,
                ease: 'power2.out'
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                rotateX: 0, rotateY: 0,
                duration: 0.5,
                ease: 'elastic.out(1, 0.5)'
            });
        });
    });
});
</script>
@endpush