@extends('layouts.app')
@section('title', 'Rekomendasi Event')

@section('content')

{{-- ============================================ --}}
{{-- PAGE HEADER                                 --}}
{{-- ============================================ --}}

<div id="pageHeader">
    <div class="relative rounded-3xl overflow-hidden mb-8 p-8 md:p-10"
        style="background: linear-gradient(135deg, #4A0E0E 0%, var(--red-600) 40%, #7A2200 75%, #3D1500 100%)">

        {{-- Batik pattern --}}
        <div class="absolute inset-0 pointer-events-none opacity-10"
            style="background-image: url(\"data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D4A843' fill-opacity='1'%3E%3Cpath d='M26 26c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S16 41.523 16 36s4.477-10 10-10zM6 6c0-5.523 4.477-10 10-10s10 4.477 10 10S21.523 16 16 16c0 5.523-4.477 10-10 10S-4 21.523-4 16 .477 6 6 6z'/%3E%3C/g%3E%3C/svg%3E\");
                   background-size: 52px 52px">
        </div>

        {{-- Decorative blobs --}}
        <div class="absolute -right-20 -top-20 w-72 h-72 rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(212,168,67,0.15), transparent 65%)"></div>
        <div class="absolute -left-16 -bottom-16 w-56 h-56 rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(26,92,56,0.18), transparent 65%)"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold mb-4"
                    style="background: rgba(212,168,67,0.18); border: 1px solid rgba(212,168,67,0.35); color: var(--gold-300)">
                    <i class="ph ph-sparkle text-sm"></i>
                    Dikurasi untuk kamu
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2 leading-tight">
                    Rekomendasi Event
                </h1>
                <p class="text-sm" style="color: rgba(255,255,255,0.6)">
                    Event pilihan berdasarkan minat dan aktivitasmu di Bengkulu
                </p>
            </div>

            {{-- Quick Stats --}}
            <div class="flex gap-3 flex-shrink-0 flex-wrap">
                @foreach([
                    ['ph-star', $recommendedEvents->count(), 'Rekomendasi', 'rgba(212,168,67,0.2)', 'var(--gold-300)'],
                    ['ph-fire', $popularEvents->count(),     'Populer',      'rgba(234,88,12,0.2)',  '#FB923C'],
                    ['ph-sparkle', $personalEvents->count(), 'Untukmu',     'rgba(26,92,56,0.2)',   '#4ADE80'],
                ] as [$icon, $count, $label, $bg, $color])
                <div class="flex flex-col items-center px-5 py-3 rounded-2xl"
                    style="background: {{ $bg }}; border: 1px solid rgba(255,255,255,0.1);
                           backdrop-filter: blur(8px)">
                    <i class="ph {{ $icon }} text-xl mb-1" style="color: {{ $color }}"></i>
                    <span class="text-xl font-bold text-white">{{ $count }}</span>
                    <span class="text-xs mt-0.5" style="color: rgba(255,255,255,0.6)">{{ $label }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- TAB NAVIGATION                              --}}
{{-- ============================================ --}}
<div id="tabNav" class="flex gap-2 mb-8 overflow-x-auto pb-1 scrollbar-none">
    @php
        $tabs = [
            ['personal',     'ph-user-circle',  'Untukmu',       $personalEvents->count()],
            ['recommended',  'ph-star',          'Rekomendasi',   $recommendedEvents->count()],
            ['popular',      'ph-fire',          'Populer',       $popularEvents->count()],
            ['latest',       'ph-clock',         'Terbaru',       $latestEvents->count()],
        ];
    @endphp

    @foreach($tabs as $i => [$id, $icon, $label, $count])
    <button onclick="switchTab('{{ $id }}')" id="tab-{{ $id }}"
        class="tab-btn flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
            whitespace-nowrap transition-all flex-shrink-0
            {{ $i === 0 ? 'tab-active' : 'tab-inactive' }}">
        <i class="ph {{ $icon }} text-base"></i>
        {{ $label }}
        @if($count > 0)
        <span class="tab-count px-2 py-0.5 rounded-full text-xs font-bold">
            {{ $count }}
        </span>
        @endif
    </button>
    @endforeach
</div>

{{-- ============================================ --}}
{{-- TAB PANELS                                  --}}
{{-- ============================================ --}}

{{-- Panel: Untukmu (Personal) --}}
<div id="panel-personal" class="tab-panel">
    @if($personalEvents->count() > 0)
        <div class="mb-5">
            <div class="card p-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: var(--red-50)">
                    <i class="ph ph-user-circle text-xl" style="color: var(--red-600)"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Dipilih Berdasarkan Minatmu</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Event dari kategori yang sering kamu favoritkan
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($personalEvents as $event)
            <div class="panel-item">
                @include('user._partials.event-card', ['event' => $event])
            </div>
            @endforeach
        </div>
    @else
        @include('user.recommendations._empty', [
            'icon'    => 'ph-user-circle',
            'title'   => 'Belum Ada Rekomendasi Personal',
            'message' => 'Mulai favoritkan event untuk mendapatkan rekomendasi yang dipersonalisasi untukmu.',
            'btnText' => 'Jelajahi Event',
            'btnRoute'=> route('user.events.index'),
        ])
    @endif
</div>

{{-- Panel: Rekomendasi Admin --}}
<div id="panel-recommended" class="tab-panel" style="display:none">
    @if($recommendedEvents->count() > 0)
        <div class="mb-5">
            <div class="card p-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: #FFFBEB">
                    <i class="ph ph-star text-xl" style="color: var(--gold-400)"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Pilihan Tim Event Bengkulu</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Event terbaik yang dikurasi langsung oleh tim kami
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($recommendedEvents as $event)
            <div class="panel-item">
                @include('user._partials.event-card', ['event' => $event])
            </div>
            @endforeach
        </div>
    @else
        @include('user.recommendations._empty', [
            'icon'    => 'ph-star',
            'title'   => 'Belum Ada Rekomendasi',
            'message' => 'Tim kami belum menambahkan event rekomendasi. Cek lagi nanti!',
            'btnText' => 'Lihat Semua Event',
            'btnRoute'=> route('user.events.index'),
        ])
    @endif
</div>

{{-- Panel: Populer --}}
<div id="panel-popular" class="tab-panel" style="display:none">
    @if($popularEvents->count() > 0)
        <div class="mb-5">
            <div class="card p-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: #FFF7ED">
                    <i class="ph ph-fire text-xl" style="color: #EA580C"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Sedang Trending di Bengkulu</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Event paling banyak dilihat dan diminati saat ini
                    </p>
                </div>
            </div>
        </div>

        {{-- Leaderboard Style --}}
        <div class="space-y-3 mb-6">
            @foreach($popularEvents->take(3) as $i => $event)
            <div class="panel-item card overflow-hidden hover:-translate-y-1">
                <div class="flex items-center gap-0">

                    {{-- Rank --}}
                    <div class="w-16 flex-shrink-0 flex flex-col items-center justify-center py-5
                        border-r"
                        style="border-color: var(--cream-200);
                               background: {{ $i === 0 ? '#FFFBEB' : ($i === 1 ? '#F9FAFB' : 'white') }}">
                        @if($i === 0)
                            <i class="ph ph-medal text-2xl" style="color: var(--gold-400)"></i>
                            <span class="text-xs font-bold mt-1" style="color: var(--gold-600)">#1</span>
                        @elseif($i === 1)
                            <i class="ph ph-medal text-2xl text-gray-400"></i>
                            <span class="text-xs font-bold mt-1 text-gray-500">#2</span>
                        @else
                            <i class="ph ph-medal text-2xl" style="color: #CD7F32"></i>
                            <span class="text-xs font-bold mt-1" style="color: #92400E">#3</span>
                        @endif
                    </div>

                    {{-- Image --}}
                    <div class="w-28 h-20 flex-shrink-0 overflow-hidden">
                        <img src="{{ $event->image
                                ? asset('storage/' . $event->image)
                                : 'https://placehold.co/200x120/C0392B/FDF8F0?text=Event' }}"
                            class="w-full h-full object-cover" alt="{{ $event->title }}">
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 px-4 py-3 min-w-0">
                        <span class="category-pill mb-1.5 inline-flex">
                            <i class="ph ph-tag text-xs"></i>
                            {{ $event->category->name }}
                        </span>
                        <a href="{{ route('user.events.show', $event->slug) }}">
                            <h4 class="font-bold text-gray-800 text-sm truncate hover:text-red-700 transition">
                                {{ $event->title }}
                            </h4>
                        </a>
                        <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <i class="ph ph-map-pin text-xs" style="color: var(--red-600)"></i>
                                {{ Str::limit($event->location, 20) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="ph ph-eye text-xs"></i>
                                {{ number_format($event->view_count) }}
                            </span>
                        </div>
                    </div>

                    {{-- Price + Fav --}}
                    <div class="flex-shrink-0 flex flex-col items-end gap-2 pr-4">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                            style="background: {{ $event->price == 0 ? '#F0FDF4' : 'var(--red-50)' }};
                                   color: {{ $event->price == 0 ? 'var(--green-700)' : 'var(--red-600)' }}">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                        <form action="{{ in_array($event->id, $favoriteIds)
                                ? route('user.favorites.destroy', $event)
                                : route('user.favorites.store', $event) }}"
                            method="POST">
                            @csrf
                            @if(in_array($event->id, $favoriteIds)) @method('DELETE') @endif
                            <button type="submit" class="fav-btn {{ in_array($event->id, $favoriteIds) ? 'active' : '' }}">
                                <i class="{{ in_array($event->id, $favoriteIds) ? 'ph-fill ph-heart' : 'ph ph-heart' }} text-base"
                                    style="color: {{ in_array($event->id, $favoriteIds) ? 'var(--red-600)' : '#9CA3AF' }}"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Rest as Grid --}}
        @if($popularEvents->count() > 3)
        <div class="flex items-center gap-3 mb-5">
            <div class="h-px flex-1" style="background: var(--cream-300)"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Event Populer Lainnya
            </span>
            <div class="h-px flex-1" style="background: var(--cream-300)"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($popularEvents->skip(3) as $event)
            <div class="panel-item">
                @include('user._partials.event-card', ['event' => $event])
            </div>
            @endforeach
        </div>
        @endif

    @else
        @include('user.recommendations._empty', [
            'icon'    => 'ph-fire',
            'title'   => 'Belum Ada Event Populer',
            'message' => 'Belum ada event yang ditandai populer saat ini.',
            'btnText' => 'Lihat Semua Event',
            'btnRoute'=> route('user.events.index'),
        ])
    @endif
</div>

{{-- Panel: Terbaru --}}
<div id="panel-latest" class="tab-panel" style="display:none">
    @if($latestEvents->count() > 0)
        <div class="mb-5">
            <div class="card p-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background: #EFF6FF">
                    <i class="ph ph-clock text-xl" style="color: #3B82F6"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Baru Ditambahkan</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Event terbaru yang baru saja hadir di Bengkulu
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($latestEvents as $event)
            <div class="panel-item">
                @include('user._partials.event-card', ['event' => $event])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('user.events.index', ['sort' => 'latest']) }}"
                class="btn-primary mx-auto">
                <i class="ph ph-arrow-right text-base"></i>
                Lihat Semua Event Terbaru
            </a>
        </div>
    @else
        @include('user.recommendations._empty', [
            'icon'    => 'ph-clock',
            'title'   => 'Belum Ada Event Terbaru',
            'message' => 'Belum ada event baru yang ditambahkan. Cek kembali nanti!',
            'btnText' => 'Lihat Semua Event',
            'btnRoute'=> route('user.events.index'),
        ])
    @endif
</div>

{{-- ============================================ --}}
{{-- GLOBAL EMPTY STATE                          --}}
{{-- ============================================ --}}
@if(
    $recommendedEvents->isEmpty() &&
    $popularEvents->isEmpty() &&
    $latestEvents->isEmpty() &&
    $personalEvents->isEmpty()
)
<div class="card p-16 text-center mt-4">
    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
        style="background: var(--red-50)">
        <i class="ph ph-sparkle text-3xl" style="color: var(--red-600)"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Rekomendasi</h3>
    <p class="text-sm text-gray-400 mb-6 max-w-xs mx-auto leading-relaxed">
        Jelajahi dan favoritkan event untuk mendapatkan rekomendasi personalmu.
    </p>
    <a href="{{ route('user.events.index') }}" class="btn-primary mx-auto">
        <i class="ph ph-magnifying-glass text-base"></i>
        Jelajahi Event
    </a>
</div>
@endif

@endsection

@push('scripts')
<style>
    .tab-btn {
        border: 1.5px solid transparent;
        cursor: pointer;
    }
    .tab-active {
        background: linear-gradient(135deg, var(--red-600), var(--red-500));
        color: white;
        box-shadow: 0 4px 14px rgba(192, 57, 43, 0.28);
        border-color: transparent;
    }
    .tab-inactive {
        background: white;
        color: #6B7280;
        border-color: var(--cream-300);
    }
    .tab-inactive:hover {
        background: var(--red-50);
        color: var(--red-600);
        border-color: var(--red-100);
    }
    .tab-active .tab-count {
        background: rgba(255,255,255,0.25);
        color: white;
    }
    .tab-inactive .tab-count {
        background: var(--cream-200);
        color: #6B7280;
    }
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
let activeTab = 'personal';

function switchTab(id) {
    if (id === activeTab) return;

    const prevPanel = document.getElementById('panel-' + activeTab);
    const nextPanel = document.getElementById('panel-' + id);
    const prevBtn   = document.getElementById('tab-' + activeTab);
    const nextBtn   = document.getElementById('tab-' + id);

    if (!nextPanel) return;

    prevBtn.className = prevBtn.className.replace('tab-active', 'tab-inactive');
    nextBtn.className = nextBtn.className.replace('tab-inactive', 'tab-active');

    gsap.to(prevPanel, {
        opacity: 0, y: -12,
        duration: 0.22, ease: 'power2.in',
        onComplete: () => {
            prevPanel.style.display = 'none';
            nextPanel.style.display = 'block';

            // ← Set dulu sebelum animate
            gsap.set(nextPanel, { opacity: 0, y: 16 });
            gsap.set(nextPanel.querySelectorAll('.panel-item'), {
                opacity: 0, y: 20, scale: 0.97
            });

            gsap.to(nextPanel, {
                opacity: 1, y: 0,
                duration: 0.35, ease: 'power3.out'
            });

            gsap.to(nextPanel.querySelectorAll('.panel-item'), {
                opacity: 1, y: 0, scale: 1,
                duration: 0.4, ease: 'power3.out',
                stagger: 0.07,
                delay: 0.1
            });
        }
    });

    activeTab = id;
}

// Jalankan setelah semua script siap
window.addEventListener('load', () => {
    gsap.registerPlugin(ScrollTrigger);

    // =============================================
    // SET INITIAL STATE DULU sebelum animate
    // =============================================
    gsap.set('#pageHeader', { opacity: 0, y: 30 });
    gsap.set('#tabNav', { opacity: 0 });
    gsap.set('.tab-btn', { opacity: 0, x: -16 });
    gsap.set('#panel-personal .panel-item', { opacity: 0, y: 24, scale: 0.97 });

    // =============================================
    // ANIMATE
    // =============================================
    const tl = gsap.timeline({ delay: 0.1 });

    tl.to('#pageHeader', {
        opacity: 1, y: 0,
        duration: 0.6, ease: 'power3.out'
    })
    .to('#tabNav', {
        opacity: 1,
        duration: 0.4, ease: 'power3.out'
    }, '-=0.3')
    .to('.tab-btn', {
        opacity: 1, x: 0,
        duration: 0.4, ease: 'power3.out',
        stagger: 0.06
    }, '-=0.2');

    // Auto switch atau animate panel
    @if($personalEvents->isEmpty() && $recommendedEvents->count() > 0)
        tl.add(() => {
            activeTab = 'personal';
            switchTab('recommended');
        }, '+=0.1');
    @elseif($personalEvents->isEmpty() && $popularEvents->count() > 0)
        tl.add(() => {
            activeTab = 'personal';
            switchTab('popular');
        }, '+=0.1');
    @elseif($personalEvents->isEmpty() && $latestEvents->count() > 0)
        tl.add(() => {
            activeTab = 'personal';
            switchTab('latest');
        }, '+=0.1');
    @else
        tl.to('#panel-personal .panel-item', {
            opacity: 1, y: 0, scale: 1,
            duration: 0.5, ease: 'power3.out',
            stagger: 0.08
        }, '-=0.1');
    @endif
});
</script>
@endpush