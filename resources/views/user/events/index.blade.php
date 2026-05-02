@extends('layouts.app')
@section('title', 'Jelajahi Event')

@section('content')

{{-- ============================================ --}}
{{-- PAGE HEADER                                 --}}
{{-- ============================================ --}}
<div id="pageHeader" class="mb-8" style="opacity:0">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
                    <i class="ph ph-magnifying-glass text-lg text-white"></i>
                </div>
                Jelajahi Event
            </h1>
            <p class="text-gray-400 text-sm mt-1 ml-[52px]">
                Temukan event seru di Bengkulu sesuai minatmu
            </p>
        </div>

        {{-- Active Filter Count --}}
        @if(request()->hasAny(['search','category','price','date']))
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold"
            style="background: var(--red-50); color: var(--red-600); border: 1px solid var(--red-100)">
            <i class="ph ph-funnel text-base"></i>
            Filter Aktif
            <a href="{{ route('user.events.index') }}"
                class="ml-1 w-5 h-5 rounded-full flex items-center justify-center text-xs hover:opacity-70 transition"
                style="background: var(--red-600); color: white">
                <i class="ph ph-x text-xs"></i>
            </a>
        </div>
        @endif
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6">

    {{-- ============================================ --}}
    {{-- SIDEBAR FILTER                              --}}
    {{-- ============================================ --}}
    <aside id="filterSidebar" class="w-full lg:w-72 flex-shrink-0" style="opacity:0">
        <div class="card p-5 sticky top-20">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm">
                    <i class="ph ph-sliders-horizontal text-base" style="color: var(--red-600)"></i>
                    Filter Event
                </h3>
                @if(request()->hasAny(['search','category','price','date','sort']))
                <a href="{{ route('user.events.index') }}"
                    class="text-xs font-semibold transition hover:opacity-70"
                    style="color: var(--red-600)">
                    Reset Semua
                </a>
                @endif
            </div>

            <form method="GET" action="{{ route('user.events.index') }}" id="filterForm">

                {{-- Search --}}
                <div class="mb-5">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">
                        Kata Kunci
                    </label>
                    <div class="relative">
                        <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul event..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border text-sm transition-all
                                focus:outline-none focus:ring-2 focus:border-transparent"
                            style="border-color: var(--cream-300); background: var(--cream);
                                   --tw-ring-color: rgba(192,57,43,0.25)">
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t mb-5" style="border-color: var(--cream-200)"></div>

                {{-- Kategori --}}
                <div class="mb-5">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 block">
                        Kategori
                    </label>
                    <div class="space-y-1.5">
                        <label class="filter-radio-label {{ !request('category') ? 'active' : '' }}">
                            <input type="radio" name="category" value=""
                                {{ !request('category') ? 'checked' : '' }}
                                class="hidden" onchange="this.form.submit()">
                            <i class="ph ph-squares-four text-base"></i>
                            <span>Semua Kategori</span>
                            <i class="ph ph-check text-xs ml-auto check-icon"></i>
                        </label>
                        @foreach($categories as $cat)
                        <label class="filter-radio-label {{ request('category') == $cat->id ? 'active' : '' }}">
                            <input type="radio" name="category" value="{{ $cat->id }}"
                                {{ request('category') == $cat->id ? 'checked' : '' }}
                                class="hidden" onchange="this.form.submit()">
                            <i class="ph ph-tag text-base"></i>
                            <span>{{ $cat->name }}</span>
                            <span class="ml-auto text-xs px-1.5 py-0.5 rounded-md font-medium"
                                style="background: var(--cream-200); color: #6B7280">
                                {{ $cat->events_count ?? '' }}
                            </span>
                            <i class="ph ph-check text-xs check-icon"></i>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="border-t mb-5" style="border-color: var(--cream-200)"></div>

                {{-- Harga --}}
                <div class="mb-5">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 block">
                        Harga
                    </label>
                    <div class="space-y-1.5">
                        @foreach([
                            [''     , 'ph-currency-dollar', 'Semua Harga'],
                            ['free' , 'ph-gift'           , 'Gratis'],
                            ['paid' , 'ph-credit-card'    , 'Berbayar'],
                        ] as [$val, $icon, $label])
                        <label class="filter-radio-label {{ request('price','') === $val ? 'active' : '' }}">
                            <input type="radio" name="price" value="{{ $val }}"
                                {{ request('price','') === $val ? 'checked' : '' }}
                                class="hidden" onchange="this.form.submit()">
                            <i class="ph {{ $icon }} text-base"></i>
                            <span>{{ $label }}</span>
                            <i class="ph ph-check text-xs ml-auto check-icon"></i>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="border-t mb-5" style="border-color: var(--cream-200)"></div>

                {{-- Waktu --}}
                <div class="mb-5">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 block">
                        Waktu
                    </label>
                    <div class="space-y-1.5">
                        @foreach([
                            [''         , 'ph-clock'         , 'Semua Waktu'],
                            ['today'    , 'ph-calendar-check', 'Hari Ini'],
                            ['week'     , 'ph-calendar-blank', 'Minggu Ini'],
                            ['month'    , 'ph-calendar'      , 'Bulan Ini'],
                            ['upcoming' , 'ph-rocket-launch' , 'Akan Datang'],
                        ] as [$val, $icon, $label])
                        <label class="filter-radio-label {{ request('date','') === $val ? 'active' : '' }}">
                            <input type="radio" name="date" value="{{ $val }}"
                                {{ request('date','') === $val ? 'checked' : '' }}
                                class="hidden" onchange="this.form.submit()">
                            <i class="ph {{ $icon }} text-base"></i>
                            <span>{{ $label }}</span>
                            <i class="ph ph-check text-xs ml-auto check-icon"></i>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Apply Button (mobile) --}}
                <button type="submit"
                    class="btn-primary w-full justify-center lg:hidden">
                    <i class="ph ph-funnel text-base"></i>
                    Terapkan Filter
                </button>

            </form>
        </div>
    </aside>

    {{-- ============================================ --}}
    {{-- MAIN CONTENT                                --}}
    {{-- ============================================ --}}
    <div class="flex-1 min-w-0" id="eventContent" style="opacity:0">

        {{-- Toolbar: Info + Sort --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div class="text-sm text-gray-500">
                Menampilkan
                <span class="font-bold text-gray-800">{{ $events->total() }}</span>
                event
                @if(request('search'))
                    untuk
                    <span class="font-semibold px-2 py-0.5 rounded-lg text-xs"
                        style="background: var(--red-50); color: var(--red-600)">
                        "{{ request('search') }}"
                    </span>
                @endif
            </div>

            {{-- Sort --}}
            <div class="relative">
                <i class="ph ph-sort-ascending absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none"></i>
                <select name="sort" form="filterForm"
                    onchange="document.getElementById('filterForm').submit()"
                    class="pl-9 pr-8 py-2 rounded-xl border text-sm font-medium appearance-none cursor-pointer
                        focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                    style="border-color: var(--cream-300); background: white;
                           --tw-ring-color: rgba(192,57,43,0.25)">
                    <option value="latest"   {{ request('sort','latest') === 'latest'   ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest"   {{ request('sort') === 'oldest'   ? 'selected' : '' }}>Terlama</option>
                    <option value="popular"  {{ request('sort') === 'popular'  ? 'selected' : '' }}>Terpopuler</option>
                    <option value="cheapest" {{ request('sort') === 'cheapest' ? 'selected' : '' }}>Harga Terendah</option>
                </select>
                <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>
        </div>

        {{-- Skeleton Grid --}}
        <div id="skeletonGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            @for($i = 0; $i < 6; $i++)
            <div class="bg-white rounded-2xl overflow-hidden border border-amber-50">
                <div class="skeleton h-44 w-full"></div>
                <div class="p-4 space-y-3">
                    <div class="skeleton h-3 w-20 rounded-full"></div>
                    <div class="skeleton h-4 w-full rounded-lg"></div>
                    <div class="skeleton h-4 w-3/4 rounded-lg"></div>
                    <div class="space-y-2 pt-1">
                        <div class="skeleton h-3 w-2/3 rounded"></div>
                        <div class="skeleton h-3 w-1/2 rounded"></div>
                    </div>
                    <div class="flex justify-between pt-2">
                        <div class="skeleton h-6 w-16 rounded-full"></div>
                        <div class="skeleton h-6 w-24 rounded-lg"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        {{-- Real Grid --}}
        <div id="realGrid" class="hidden">
            @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($events as $event)
                <div class="event-item">
                    @include('user._partials.event-card', ['event' => $event])
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($events->hasPages())
            <div class="mt-8 flex justify-center" id="pagination">
                {{ $events->links() }}
            </div>
            @endif

            @else
            {{-- Empty State --}}
            <div class="card p-16 text-center" id="emptyState">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                    style="background: var(--red-50)">
                    <i class="ph ph-magnifying-glass text-3xl" style="color: var(--red-600)"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Event Tidak Ditemukan</h3>
                <p class="text-sm text-gray-400 mb-6 max-w-xs mx-auto leading-relaxed">
                    Coba ubah filter atau kata kunci pencarianmu.
                </p>
                <a href="{{ route('user.events.index') }}" class="btn-primary mx-auto">
                    <i class="ph ph-arrow-counter-clockwise text-base"></i>
                    Reset Filter
                </a>
            </div>
            @endif
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
    /* Filter Radio Label */
    .filter-radio-label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        border-radius: 10px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.18s ease;
        border: 1.5px solid transparent;
        user-select: none;
    }

    .filter-radio-label:hover {
        background: var(--cream);
        color: var(--red-600);
    }

    .filter-radio-label.active {
        background: var(--red-50);
        color: var(--red-600);
        border-color: var(--red-100);
        font-weight: 600;
    }

    .filter-radio-label .check-icon {
        display: none;
        color: var(--red-600);
    }

    .filter-radio-label.active .check-icon {
        display: block;
    }

    /* Skeleton */
    .skeleton {
        background: linear-gradient(90deg,
            var(--cream-200) 25%,
            var(--cream-300) 50%,
            var(--cream-200) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.6s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap === 'undefined') return;

    // =============================================
    // PAGE ELEMENTS ANIMATE IN
    // =============================================
    const tl = gsap.timeline({ delay: 0.05 });

    tl.to('#pageHeader', {
        opacity: 1, y: 0,
        duration: 0.5, ease: 'power3.out'
    })
    .to('#filterSidebar', {
        opacity: 1, x: 0,
        duration: 0.5, ease: 'power3.out'
    }, '-=0.3')
    .to('#eventContent', {
        opacity: 1, y: 0,
        duration: 0.5, ease: 'power3.out'
    }, '-=0.3');

    gsap.set('#pageHeader', { y: -20 });
    gsap.set('#filterSidebar', { x: -20 });
    gsap.set('#eventContent', { y: 20 });

    // =============================================
    // SKELETON → REAL CARDS
    // =============================================
    const skeleton = document.getElementById('skeletonGrid');
    const real     = document.getElementById('realGrid');

    setTimeout(() => {
        gsap.to(skeleton, {
            opacity: 0, duration: 0.3, ease: 'power2.in',
            onComplete: () => {
                skeleton.classList.add('hidden');
                real.classList.remove('hidden');

                // Stagger animate cards
                gsap.from('.event-item', {
                    opacity: 0,
                    y: 24,
                    scale: 0.97,
                    duration: 0.5,
                    ease: 'power3.out',
                    stagger: 0.08
                });

                // Animate pagination
                gsap.from('#pagination', {
                    opacity: 0, y: 16,
                    duration: 0.5, ease: 'power3.out',
                    delay: 0.4
                });

                // Empty state
                const empty = document.getElementById('emptyState');
                if (empty) {
                    gsap.from(empty, {
                        opacity: 0, scale: 0.95,
                        duration: 0.5, ease: 'back.out(1.4)'
                    });
                }
            }
        });
    }, 800);

    // =============================================
    // FILTER SIDEBAR HOVER EFFECT
    // =============================================
    document.querySelectorAll('.filter-radio-label').forEach(label => {
        label.addEventListener('mouseenter', () => {
            gsap.to(label, { x: 3, duration: 0.2, ease: 'power2.out' });
        });
        label.addEventListener('mouseleave', () => {
            gsap.to(label, { x: 0, duration: 0.2, ease: 'power2.out' });
        });
    });
});
</script>
@endpush