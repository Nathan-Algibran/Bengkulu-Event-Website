@extends('layouts.admin')
@section('title', 'Statistik Event')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('admin.recommendations.index') }}"
                class="text-gray-400 hover:text-gray-600 transition">
                <i class="ph ph-arrow-left text-base"></i>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Statistik Event</h2>
        </div>
        <p class="text-sm text-gray-400 ml-6">Ringkasan performa dan data event</p>
    </div>
    <a href="{{ route('admin.recommendations.index') }}" class="btn-admin-secondary">
        <i class="ph ph-star text-base"></i>
        Manajemen Rekomendasi
    </a>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="admin-card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                style="background: var(--red-50)">
                <i class="ph ph-ticket text-lg" style="color: var(--red-600)"></i>
            </div>
            <p class="text-xs text-gray-400 font-medium">Total Event</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $summary['total_events'] }}</p>
        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
            <span class="badge badge-green" style="font-size:10px; padding: 1px 6px">
                {{ $summary['active_events'] }} aktif
            </span>
        </p>
    </div>

    <div class="admin-card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                style="background: #FFFBEB">
                <i class="ph ph-star-fill text-lg" style="color: var(--gold-400)"></i>
            </div>
            <p class="text-xs text-gray-400 font-medium">Rekomendasi</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $summary['total_recommended'] }}</p>
        <p class="text-xs text-gray-400 mt-1">event ditandai ⭐</p>
    </div>

    <div class="admin-card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                style="background: #FFF7ED">
                <i class="ph ph-fire text-lg" style="color: #EA580C"></i>
            </div>
            <p class="text-xs text-gray-400 font-medium">Populer</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $summary['total_popular'] }}</p>
        <p class="text-xs text-gray-400 mt-1">event ditandai 🔥</p>
    </div>

    <div class="admin-card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                style="background: #F3E8FF">
                <i class="ph ph-heart text-lg" style="color: #7C3AED"></i>
            </div>
            <p class="text-xs text-gray-400 font-medium">Total Favorit</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $summary['total_favorites'] }}</p>
        <p class="text-xs text-gray-400 mt-1">dari semua pengguna</p>
    </div>
</div>

{{-- Gratis vs Berbayar --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="admin-card p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
            style="background: #F0FDF4">
            <i class="ph ph-ticket text-2xl" style="color: #16A34A"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 mb-0.5">Event Gratis</p>
            <p class="text-3xl font-bold text-gray-800">{{ $summary['free_events'] }}</p>
        </div>
    </div>
    <div class="admin-card p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
            style="background: #EFF6FF">
            <i class="ph ph-currency-circle-dollar text-2xl" style="color: #2563EB"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 mb-0.5">Event Berbayar</p>
            <p class="text-3xl font-bold text-gray-800">{{ $summary['paid_events'] }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Paling Banyak Difavoritkan --}}
    <div class="admin-card overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                style="background: #F3E8FF">
                <i class="ph ph-heart text-sm" style="color: #7C3AED"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Paling Banyak Difavoritkan</h3>
                <p class="text-xs text-gray-400">Top 10 event</p>
            </div>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($mostFavorited as $i => $event)
            <div class="flex items-center gap-3 px-6 py-3">
                <span class="text-sm font-bold w-5 flex-shrink-0
                    {{ $i < 3 ? '' : 'text-gray-300' }}"
                    style="{{ $i === 0 ? 'color: var(--gold-400)' : ($i === 1 ? 'color:#94A3B8' : ($i === 2 ? 'color:#CD7F32' : '')) }}">
                    {{ $i + 1 }}
                </span>
                <img src="{{ $event->image
                        ? asset('storage/' . $event->image)
                        : 'https://placehold.co/48x36/C0392B/FDF8F0?text=E' }}"
                    class="w-12 h-9 object-cover rounded-lg flex-shrink-0"
                    alt="{{ $event->title }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $event->title }}</p>
                    <span class="badge badge-blue" style="font-size:10px; padding:1px 6px">
                        {{ $event->category->name }}
                    </span>
                </div>
                <div class="flex-shrink-0 text-right">
                    <span class="text-sm font-bold" style="color: #7C3AED">
                        {{ $event->favorites_count }}
                    </span>
                    <p class="text-xs text-gray-400">favorit</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-10 text-center">
                <i class="ph ph-heart text-3xl block mb-2" style="color: #E2E8F0"></i>
                <p class="text-sm text-gray-400">Belum ada data favorit.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Paling Banyak Dilihat --}}
    <div class="admin-card overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                style="background: #EFF6FF">
                <i class="ph ph-eye text-sm" style="color: #2563EB"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Paling Banyak Dilihat</h3>
                <p class="text-xs text-gray-400">Top 10 event</p>
            </div>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($mostViewed as $i => $event)
            <div class="flex items-center gap-3 px-6 py-3">
                <span class="text-sm font-bold w-5 flex-shrink-0"
                    style="{{ $i === 0 ? 'color: var(--gold-400)' : ($i === 1 ? 'color:#94A3B8' : ($i === 2 ? 'color:#CD7F32' : 'color:#D1D5DB')) }}">
                    {{ $i + 1 }}
                </span>
                <img src="{{ $event->image
                        ? asset('storage/' . $event->image)
                        : 'https://placehold.co/48x36/C0392B/FDF8F0?text=E' }}"
                    class="w-12 h-9 object-cover rounded-lg flex-shrink-0"
                    alt="{{ $event->title }}">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $event->title }}</p>
                    <span class="badge badge-blue" style="font-size:10px; padding:1px 6px">
                        {{ $event->category->name }}
                    </span>
                </div>
                <div class="flex-shrink-0 text-right">
                    <span class="text-sm font-bold text-blue-600">
                        {{ number_format($event->view_count) }}
                    </span>
                    <p class="text-xs text-gray-400">views</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-10 text-center">
                <i class="ph ph-eye text-3xl block mb-2" style="color: #E2E8F0"></i>
                <p class="text-sm text-gray-400">Belum ada data views.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Event per Kategori --}}
<div class="admin-card overflow-hidden">
    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
            style="background: var(--red-50)">
            <i class="ph ph-chart-bar text-sm" style="color: var(--red-600)"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-sm">Event per Kategori</h3>
            <p class="text-xs text-gray-400">Distribusi event berdasarkan kategori</p>
        </div>
    </div>

    <div class="px-6 py-5 space-y-4">
        @php $maxCount = $categoryStats->max('events_count') ?: 1; @endphp
        @forelse($categoryStats as $cat)
        <div class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                style="background: var(--red-50)">
                <i class="ph ph-tag text-xs" style="color: var(--red-600)"></i>
            </div>
            <span class="text-sm font-medium text-gray-600 w-28 flex-shrink-0 truncate">
                {{ $cat->name }}
            </span>
            <div class="flex-1 rounded-full overflow-hidden" style="height: 8px; background: #F1F5F9">
                <div class="h-full rounded-full transition-all duration-700"
                    style="width: {{ ($cat->events_count / $maxCount) * 100 }}%;
                           background: linear-gradient(90deg, var(--red-600), var(--gold-400))">
                </div>
            </div>
            <span class="text-sm font-bold text-gray-700 w-20 text-right flex-shrink-0">
                {{ $cat->events_count }}
                <span class="font-normal text-gray-400">event</span>
            </span>
        </div>
        @empty
        <div class="py-8 text-center">
            <i class="ph ph-tag text-3xl block mb-2" style="color: #E2E8F0"></i>
            <p class="text-sm text-gray-400">Belum ada kategori.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection