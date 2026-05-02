@extends('layouts.admin')
@section('title', 'Manajemen Rekomendasi')

@section('content')

{{-- Summary Card --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="text-3xl">⭐</div>
        <div>
            <p class="text-xs text-gray-400">Event Rekomendasi</p>
            <p class="text-2xl font-bold text-yellow-500">{{ $totalRecommended }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="text-3xl">🔥</div>
        <div>
            <p class="text-xs text-gray-400">Event Populer</p>
            <p class="text-2xl font-bold text-orange-500">{{ $totalPopular }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="text-3xl">📊</div>
        <div>
            <p class="text-xs text-gray-400">Lihat Statistik Lengkap</p>
            <a href="{{ route('admin.recommendations.statistics') }}"
                class="text-sm text-blue-600 font-medium hover:underline">
                Buka Statistik →
            </a>
        </div>
    </div>
</div>

{{-- Filter & Search --}}
<form method="GET" action="{{ route('admin.recommendations.index') }}"
    class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari judul event..."
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-56">

    <select name="filter"
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Event</option>
        <option value="recommended" {{ request('filter') === 'recommended' ? 'selected' : '' }}>
            ⭐ Rekomendasi
        </option>
        <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>
            🔥 Populer
        </option>
        <option value="none" {{ request('filter') === 'none' ? 'selected' : '' }}>
            Belum Ditandai
        </option>
    </select>

    <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        Filter
    </button>

    @if(request()->hasAny(['search', 'filter']))
        <a href="{{ route('admin.recommendations.index') }}"
            class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">
            Reset
        </a>
    @endif
</form>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-left">
            <tr>
                <th class="px-5 py-3">No</th>
                <th class="px-5 py-3">Event</th>
                <th class="px-5 py-3">Kategori</th>
                <th class="px-5 py-3">Tanggal</th>
                <th class="px-5 py-3 text-center">⭐ Rekomendasi</th>
                <th class="px-5 py-3 text-center">🔥 Populer</th>
                <th class="px-5 py-3 text-center">👁️ Views</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($events as $index => $event)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4 text-gray-400">
                    {{ $events->firstItem() + $index }}
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/60x40?text=No' }}"
                            class="w-14 h-10 object-cover rounded-lg flex-shrink-0">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-800 truncate max-w-xs">{{ $event->title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">📍 {{ $event->location }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $event->category->name }}
                    </span>
                </td>
                <td class="px-5 py-4 text-gray-400 text-xs">
                    {{ $event->start_date->format('d M Y') }}
                </td>

                {{-- Toggle Rekomendasi --}}
                <td class="px-5 py-4 text-center">
                    <form action="{{ route('admin.recommendations.toggleRecommended', $event) }}"
                        method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                            title="{{ $event->is_recommended ? 'Hapus dari Rekomendasi' : 'Tandai sebagai Rekomendasi' }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium transition
                            {{ $event->is_recommended
                                ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
                                : 'bg-gray-100 text-gray-400 hover:bg-yellow-50 hover:text-yellow-600' }}">
                            {{ $event->is_recommended ? '⭐ Ya' : '☆ Tidak' }}
                        </button>
                    </form>
                </td>

                {{-- Toggle Populer --}}
                <td class="px-5 py-4 text-center">
                    <form action="{{ route('admin.recommendations.togglePopular', $event) }}"
                        method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                            title="{{ $event->is_popular ? 'Hapus dari Populer' : 'Tandai sebagai Populer' }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium transition
                            {{ $event->is_popular
                                ? 'bg-orange-100 text-orange-700 hover:bg-orange-200'
                                : 'bg-gray-100 text-gray-400 hover:bg-orange-50 hover:text-orange-600' }}">
                            {{ $event->is_popular ? '🔥 Ya' : '○ Tidak' }}
                        </button>
                    </form>
                </td>

                {{-- View Count --}}
                <td class="px-5 py-4 text-center">
                    <span class="text-gray-600 font-medium">
                        {{ number_format($event->view_count) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                    Tidak ada event ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($events->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection