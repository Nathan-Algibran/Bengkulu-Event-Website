@extends('layouts.admin')
@section('title', 'Statistik Event')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.recommendations.index') }}"
        class="text-sm text-blue-600 hover:underline">
        ← Kembali ke Manajemen Rekomendasi
    </a>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-400 mb-1">Total Event</p>
        <p class="text-2xl font-bold text-blue-600">{{ $summary['total_events'] }}</p>
        <p class="text-xs text-gray-400 mt-1">
            {{ $summary['active_events'] }} aktif
        </p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-400 mb-1">Rekomendasi</p>
        <p class="text-2xl font-bold text-yellow-500">{{ $summary['total_recommended'] }}</p>
        <p class="text-xs text-gray-400 mt-1">event ditandai ⭐</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-400 mb-1">Populer</p>
        <p class="text-2xl font-bold text-orange-500">{{ $summary['total_popular'] }}</p>
        <p class="text-xs text-gray-400 mt-1">event ditandai 🔥</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-400 mb-1">Total Favorit</p>
        <p class="text-2xl font-bold text-purple-600">{{ $summary['total_favorites'] }}</p>
        <p class="text-xs text-gray-400 mt-1">dari semua user</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Event Terbanyak Difavoritkan --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">
            ❤️ Paling Banyak Difavoritkan
        </h3>
        <div class="space-y-3">
            @forelse($mostFavorited as $i => $event)
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-300 w-5 flex-shrink-0">
                    {{ $i + 1 }}
                </span>
                <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/50x35?text=No' }}"
                    class="w-12 h-9 object-cover rounded flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $event->title }}</p>
                    <p class="text-xs text-gray-400">{{ $event->category->name }}</p>
                </div>
                <div class="flex-shrink-0 text-right">
                    <span class="text-sm font-bold text-purple-600">
                        {{ $event->favorites_count }}
                    </span>
                    <p class="text-xs text-gray-400">favorit</p>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">Belum ada data favorit.</p>
            @endforelse
        </div>
    </div>

    {{-- Event Paling Banyak Dilihat --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-700 mb-4">
            👁️ Paling Banyak Dilihat
        </h3>
        <div class="space-y-3">
            @forelse($mostViewed as $i => $event)
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-300 w-5 flex-shrink-0">
                    {{ $i + 1 }}
                </span>
                <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/50x35?text=No' }}"
                    class="w-12 h-9 object-cover rounded flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $event->title }}</p>
                    <p class="text-xs text-gray-400">{{ $event->category->name }}</p>
                </div>
                <div class="flex-shrink-0 text-right">
                    <span class="text-sm font-bold text-blue-600">
                        {{ number_format($event->view_count) }}
                    </span>
                    <p class="text-xs text-gray-400">views</p>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">Belum ada data views.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Statistik Per Kategori --}}
<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-base font-semibold text-gray-700 mb-4">
        🗂️ Event per Kategori
    </h3>
    <div class="space-y-3">
        @php
            $maxCount = $categoryStats->max('events_count') ?: 1;
        @endphp
        @forelse($categoryStats as $cat)
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600 w-28 flex-shrink-0 truncate">
                {{ $cat->name }}
            </span>
            <div class="flex-1 bg-gray-100 rounded-full h-4 overflow-hidden">
                <div class="bg-blue-500 h-4 rounded-full transition-all duration-500"
                    style="width: {{ ($cat->events_count / $maxCount) * 100 }}%">
                </div>
            </div>
            <span class="text-sm font-bold text-gray-700 w-16 text-right flex-shrink-0">
                {{ $cat->events_count }} event
            </span>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-4">Belum ada kategori.</p>
        @endforelse
    </div>
</div>

{{-- Event Gratis vs Berbayar --}}
<div class="grid grid-cols-2 gap-4 mt-6">
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-4xl font-bold text-green-500 mb-1">{{ $summary['free_events'] }}</p>
        <p class="text-sm text-gray-500">🎟️ Event Gratis</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-4xl font-bold text-blue-500 mb-1">{{ $summary['paid_events'] }}</p>
        <p class="text-sm text-gray-500">💰 Event Berbayar</p>
    </div>
</div>
@endsection