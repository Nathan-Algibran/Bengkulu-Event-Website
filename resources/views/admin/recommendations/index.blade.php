@extends('layouts.admin')
@section('title', 'Manajemen Rekomendasi')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Manajemen Rekomendasi</h2>
        <p class="text-sm text-gray-400 mt-0.5">Tandai event sebagai rekomendasi atau populer</p>
    </div>
    <a href="{{ route('admin.recommendations.statistics') }}" class="btn-admin-secondary">
        <i class="ph ph-chart-bar text-base"></i>
        Lihat Statistik
    </a>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">

    {{-- Rekomendasi --}}
    <div class="admin-card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                style="background: #FFFBEB">
                <i class="ph ph-star-fill text-2xl" style="color: var(--gold-400)"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Event Rekomendasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalRecommended }}</p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-50">
            <a href="{{ route('admin.recommendations.index', ['filter' => 'recommended']) }}"
                class="text-xs font-semibold flex items-center gap-1"
                style="color: var(--gold-600)">
                Lihat semua <i class="ph ph-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    {{-- Populer --}}
    <div class="admin-card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                style="background: #FFF7ED">
                <i class="ph ph-fire text-2xl" style="color: #EA580C"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Event Populer</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalPopular }}</p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-50">
            <a href="{{ route('admin.recommendations.index', ['filter' => 'popular']) }}"
                class="text-xs font-semibold flex items-center gap-1 text-orange-600">
                Lihat semua <i class="ph ph-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    {{-- Belum Ditandai --}}
    <div class="admin-card p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                style="background: #F1F5F9">
                <i class="ph ph-tag text-2xl text-gray-400"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Belum Ditandai</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUntagged }}</p>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-50">
            <a href="{{ route('admin.recommendations.index', ['filter' => 'none']) }}"
                class="text-xs font-semibold flex items-center gap-1 text-gray-500">
                Lihat semua <i class="ph ph-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="admin-card p-4 mb-5">
    <form method="GET" action="{{ route('admin.recommendations.index') }}"
        class="flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Cari Event
            </label>
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul event..."
                    class="admin-input pl-9">
            </div>
        </div>

        <div class="min-w-[170px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Tampilkan
            </label>
            <select name="filter" class="admin-input admin-select">
                <option value="">Semua Event Aktif</option>
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
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn-admin-primary">
                <i class="ph ph-funnel text-base"></i>
                Filter
            </button>
            @if(request()->hasAny(['search', 'filter']))
            <a href="{{ route('admin.recommendations.index') }}" class="btn-admin-secondary">
                <i class="ph ph-arrow-counter-clockwise text-base"></i>
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="admin-card overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
        <p class="text-sm text-gray-500">
            Total
            <span class="font-bold text-gray-800">{{ $events->total() }}</span>
            event ditemukan
        </p>
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <i class="ph ph-info text-sm"></i>
            Halaman {{ $events->currentPage() }} dari {{ $events->lastPage() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Event</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <i class="ph ph-star-fill text-xs" style="color: var(--gold-400)"></i>
                            Rekomendasi
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <i class="ph ph-fire text-xs text-orange-500"></i>
                            Populer
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <i class="ph ph-eye text-xs text-blue-400"></i>
                            Views
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $index => $event)
                <tr>
                    <td class="text-gray-400 text-xs font-medium">
                        {{ $events->firstItem() + $index }}
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $event->image
                                        ? asset('storage/' . $event->image)
                                        : 'https://placehold.co/56x40/C0392B/FDF8F0?text=E' }}"
                                    class="w-14 h-10 rounded-lg object-cover"
                                    alt="{{ $event->title }}">
                                @if($event->is_recommended)
                                <div class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full flex items-center justify-center"
                                    style="background: var(--gold-400)">
                                    <i class="ph ph-star-fill" style="font-size: 9px; color: white"></i>
                                </div>
                                @elseif($event->is_popular)
                                <div class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full flex items-center justify-center"
                                    style="background: #EA580C">
                                    <i class="ph ph-fire" style="font-size: 9px; color: white"></i>
                                </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate max-w-[200px]">
                                    {{ $event->title }}
                                </p>
                                <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                    <i class="ph ph-map-pin text-xs"></i>
                                    {{ Str::limit($event->location, 25) }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-blue">{{ $event->category->name }}</span>
                    </td>
                    <td>
                        <p class="text-xs font-medium text-gray-700">
                            {{ $event->start_date->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $event->start_date->format('H:i') }} WIB
                        </p>
                    </td>

                    {{-- Toggle Rekomendasi --}}
                    <td class="text-center">
                        <form action="{{ route('admin.recommendations.toggleRecommended', $event) }}"
                            method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                title="{{ $event->is_recommended ? 'Hapus dari Rekomendasi' : 'Tandai sebagai Rekomendasi' }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition"
                                style="{{ $event->is_recommended
                                    ? 'background:#FFFBEB; color:' . '#92400E' . '; border: 1.5px solid #FDE68A'
                                    : 'background:#F8FAFC; color:#94A3B8; border: 1.5px solid #E2E8F0' }}">
                                <i class="ph {{ $event->is_recommended ? 'ph-star-fill' : 'ph-star' }} text-sm"
                                    style="{{ $event->is_recommended ? 'color: var(--gold-400)' : '' }}"></i>
                                {{ $event->is_recommended ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>

                    {{-- Toggle Populer --}}
                    <td class="text-center">
                        <form action="{{ route('admin.recommendations.togglePopular', $event) }}"
                            method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                title="{{ $event->is_popular ? 'Hapus dari Populer' : 'Tandai sebagai Populer' }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition"
                                style="{{ $event->is_popular
                                    ? 'background:#FFF7ED; color:#9A3412; border: 1.5px solid #FED7AA'
                                    : 'background:#F8FAFC; color:#94A3B8; border: 1.5px solid #E2E8F0' }}">
                                <i class="ph {{ $event->is_popular ? 'ph-fire' : 'ph-fire' }} text-sm"
                                    style="{{ $event->is_popular ? 'color:#EA580C' : '' }}"></i>
                                {{ $event->is_popular ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>

                    {{-- View Count --}}
                    <td class="text-center">
                        <span class="text-sm font-bold text-gray-700">
                            {{ number_format($event->view_count) }}
                        </span>
                        <p class="text-xs text-gray-400">views</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <i class="ph ph-star text-5xl block mb-3" style="color: #E2E8F0"></i>
                        <p class="font-semibold text-gray-400 mb-1">Tidak ada event ditemukan</p>
                        <p class="text-sm text-gray-300">Coba ubah filter pencarian</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($events->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $events->links() }}
    </div>
    @endif
</div>

@endsection