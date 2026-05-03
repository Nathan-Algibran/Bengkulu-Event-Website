@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- ============================================ --}}
{{-- WELCOME BANNER                              --}}
{{-- ============================================ --}}
<div class="rounded-2xl overflow-hidden mb-7 gs-fade-up"
    style="background: linear-gradient(135deg, #1A0A0A 0%, var(--red-700) 45%, #6B2000 80%, #2D1000 100%)">

    <div class="relative p-7 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">

        <div class="absolute inset-0 opacity-10 pointer-events-none"
            style="background-image: url(\"data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D4A843' fill-opacity='0.12'%3E%3Cpath d='M26 26c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S16 41.523 16 36s4.477-10 10-10zM6 6c0-5.523 4.477-10 10-10s10 4.477 10 10S21.523 16 16 16c0 5.523-4.477 10-10 10S-4 21.523-4 16 .477 6 6 6z'/%3E%3C/g%3E%3C/svg%3E\")">
        </div>

        <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full pointer-events-none"
            style="background: radial-gradient(circle, rgba(212,168,67,0.12), transparent 65%)"></div>

        <div class="relative z-10">
            <p class="text-xs font-semibold mb-1" style="color: var(--gold-300)">
                Selamat datang kembali
            </p>
            <h1 class="text-xl md:text-2xl font-bold text-white mb-1">
                {{ Auth::user()->name }}
            </h1>
            <p class="text-sm" style="color: rgba(255,255,255,0.55)">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <div class="relative z-10 flex gap-2 flex-wrap">
            <a href="{{ route('admin.events.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition hover:-translate-y-0.5"
                style="background: var(--gold-400); color: #1A0A0A">
                <i class="ph ph-plus text-base"></i>
                Tambah Event
            </a>
            <a href="{{ route('admin.recommendations.statistics') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition hover:-translate-y-0.5"
                style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2)">
                <i class="ph ph-chart-bar text-base"></i>
                Statistik
            </a>
        </div>
    </div>

    <div class="batik-line"></div>
</div>

{{-- ============================================ --}}
{{-- STAT CARDS                                  --}}
{{-- ✅ Fix: semua query sudah di controller     --}}
{{-- ============================================ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-7">
    @foreach($stats as $stat)
    <a href="{{ $stat['route'] }}" class="stat-card gs-stat group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110"
                style="background: {{ $stat['iconBg'] }}">
                <i class="ph {{ $stat['icon'] }} text-xl" style="color: {{ $stat['color'] }}"></i>
            </div>
            <i class="ph ph-arrow-up-right text-sm text-gray-300 group-hover:text-gray-500 transition"></i>
        </div>
        <p class="text-2xl font-bold text-gray-800 stat-number mb-1"
            data-target="{{ $stat['value'] }}">0</p>
        <p class="text-sm font-semibold text-gray-600">{{ $stat['label'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">{{ $stat['sub'] }}</p>
        <div class="stat-bg-icon">
            <i class="ph {{ $stat['icon'] }}" style="color: {{ $stat['color'] }}"></i>
        </div>
    </a>
    @endforeach
</div>

{{-- ============================================ --}}
{{-- RECENT EVENTS + SIDE PANEL                  --}}
{{-- ============================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Table --}}
    <div class="lg:col-span-2 admin-card gs-fade-up">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background: var(--red-50)">
                    <i class="ph ph-clock-countdown text-base" style="color: var(--red-600)"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Event Terbaru</h3>
                    <p class="text-xs text-gray-400">5 event terakhir ditambahkan</p>
                </div>
            </div>
            <a href="{{ route('admin.events.index') }}" class="btn-admin-secondary text-xs py-1.5 px-3">
                <i class="ph ph-arrow-right text-sm"></i>
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEvents as $event)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $event->image
                                        ? asset('storage/' . $event->image)
                                        : 'https://placehold.co/48x36/C0392B/FDF8F0?text=E' }}"
                                    class="w-12 h-9 rounded-lg object-cover flex-shrink-0"
                                    alt="{{ $event->title }}">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 text-sm truncate max-w-[180px]">
                                        {{ $event->title }}
                                    </p>
                                    <p class="text-xs text-gray-400 truncate max-w-[180px]">
                                        {{ $event->location }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-blue">{{ $event->category->name }}</span>
                        </td>
                        <td class="text-xs text-gray-500 whitespace-nowrap">
                            {{ $event->start_date->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge {{ $event->is_active ? 'badge-green' : 'badge-red' }}">
                                <i class="ph {{ $event->is_active ? 'ph-check-circle' : 'ph-x-circle' }} text-xs"></i>
                                {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn-admin-warning">
                                    <i class="ph ph-pencil-simple text-xs"></i>
                                </a>
                                <a href="{{ route('admin.events.show', $event) }}" class="btn-admin-info">
                                    <i class="ph ph-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-400 text-sm">
                            <i class="ph ph-ticket text-3xl block mb-2 text-gray-200"></i>
                            Belum ada event
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Side Panel --}}
    <div class="space-y-4">

        {{-- Status Event --}}
        <div class="admin-card p-5 gs-fade-up">
            <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                <i class="ph ph-chart-pie text-base" style="color: var(--red-600)"></i>
                Status Event
            </h3>
            <div class="space-y-3">
                @foreach($eventStatus as $status)
                <div>
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="font-medium text-gray-600 flex items-center gap-1">
                            <i class="ph {{ $status['icon'] }}" style="color: {{ $status['color'] }}"></i>
                            {{ $status['label'] }}
                        </span>
                        <span class="font-bold text-gray-800">{{ $status['count'] }}</span>
                    </div>
                    <div class="h-2 rounded-full overflow-hidden" style="background: #F1F5F9">
                        <div class="progress-bar h-full rounded-full"
                            style="background: {{ $status['color'] }}"
                            data-width="{{ $status['percent'] }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="admin-card p-5 gs-fade-up">
            <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                <i class="ph ph-lightning text-base" style="color: var(--gold-400)"></i>
                Aksi Cepat
            </h3>
            <div class="space-y-2">
                @foreach($quickLinks as $link)
                <a href="{{ $link['href'] }}"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all hover:-translate-x-0.5 hover:shadow-sm group"
                    style="background: {{ $link['bg'] }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="ph {{ $link['icon'] }} text-base" style="color: {{ $link['color'] }}"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition">
                        {{ $link['label'] }}
                    </span>
                    <i class="ph ph-caret-right text-xs text-gray-300 ml-auto group-hover:text-gray-500 transition"></i>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
window.addEventListener('load', () => {
    gsap.registerPlugin(ScrollTrigger);

    // Stat counter
    gsap.utils.toArray('.stat-number').forEach(el => {
        const target = parseInt(el.getAttribute('data-target')) || 0;
        gsap.set(el, { innerText: 0 });
        ScrollTrigger.create({
            trigger: el,
            start: 'top 90%',
            once: true,
            onEnter: () => {
                gsap.to({ val: 0 }, {
                    val: target,
                    duration: 1.4,
                    ease: 'power2.out',
                    onUpdate: function() {
                        el.textContent = Math.round(this.targets()[0].val);
                    }
                });
            }
        });
    });

    // Progress bars
    gsap.utils.toArray('.progress-bar').forEach(bar => {
        const target = bar.getAttribute('data-width') || 0;
        gsap.set(bar, { width: '0%' });
        ScrollTrigger.create({
            trigger: bar,
            start: 'top 90%',
            once: true,
            onEnter: () => {
                gsap.to(bar, {
                    width: target + '%',
                    duration: 1.2,
                    ease: 'power3.out',
                    delay: 0.2
                });
            }
        });
    });
});
</script>
@endpush