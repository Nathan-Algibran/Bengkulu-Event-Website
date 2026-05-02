@extends('layouts.app')
@section('title', 'Jelajahi Event')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">🔍 Jelajahi Event</h2>
    <p class="text-gray-500 text-sm mt-1">
        Temukan event seru di Bengkulu sesuai minatmu.
    </p>
</div>

<div class="flex flex-col lg:flex-row gap-6">

    {{-- SIDEBAR FILTER --}}
    <aside class="w-full lg:w-64 flex-shrink-0">
        <div class="bg-white rounded-xl shadow p-5 sticky top-20">
            <h3 class="font-semibold text-gray-700 mb-4">🎛️ Filter Event</h3>

            <form method="GET" action="{{ route('user.events.index') }}" id="filterForm">

                {{-- Search --}}
                <div class="mb-4">
                    <label class="text-xs font-medium text-gray-500 uppercase mb-1 block">
                        Cari Event
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Ketik judul event..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                {{-- Kategori --}}
                <div class="mb-4">
                    <label class="text-xs font-medium text-gray-500 uppercase mb-2 block">
                        Kategori
                    </label>
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value=""
                                {{ !request('category') ? 'checked' : '' }}
                                class="text-blue-600" onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">Semua Kategori</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="{{ $cat->id }}"
                                {{ request('category') == $cat->id ? 'checked' : '' }}
                                class="text-blue-600" onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="text-xs font-medium text-gray-500 uppercase mb-2 block">
                        Harga
                    </label>
                    <div class="space-y-1.5">
                        @foreach([''=>'Semua', 'free'=>'Gratis', 'paid'=>'Berbayar'] as $val => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="price" value="{{ $val }}"
                                {{ request('price', '') === $val ? 'checked' : '' }}
                                class="text-blue-600" onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Waktu --}}
                <div class="mb-4">
                    <label class="text-xs font-medium text-gray-500 uppercase mb-2 block">
                        Waktu
                    </label>
                    <div class="space-y-1.5">
                        @foreach([
                            ''         => 'Semua Waktu',
                            'today'    => 'Hari Ini',
                            'week'     => 'Minggu Ini',
                            'month'    => 'Bulan Ini',
                            'upcoming' => 'Akan Datang',
                        ] as $val => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="date" value="{{ $val }}"
                                {{ request('date', '') === $val ? 'checked' : '' }}
                                class="text-blue-600" onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Search & Reset --}}
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition mb-2">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search','category','price','date','sort']))
                    <a href="{{ route('user.events.index') }}"
                        class="block w-full text-center bg-gray-100 text-gray-600 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <div class="flex-1">

        {{-- Sort & Info --}}
        <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-semibold text-gray-700">{{ $events->total() }}</span> event
                @if(request('search'))
                    untuk "<span class="font-semibold text-blue-600">{{ request('search') }}</span>"
                @endif
            </p>
            <select name="sort" form="filterForm"
                onchange="document.getElementById('filterForm').submit()"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="latest"   {{ request('sort','latest') === 'latest'   ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest"   {{ request('sort') === 'oldest'   ? 'selected' : '' }}>Terlama</option>
                <option value="popular"  {{ request('sort') === 'popular'  ? 'selected' : '' }}>Terpopuler</option>
                <option value="cheapest" {{ request('sort') === 'cheapest' ? 'selected' : '' }}>Harga Terendah</option>
            </select>
        </div>

        {{-- Grid Event --}}
        @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($events as $event)
            <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden group">

                {{-- Gambar --}}
                <div class="relative overflow-hidden">
                    <a href="{{ route('user.events.show', $event->slug) }}">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/400x220?text=No+Image' }}"
                            class="w-full h-44 object-cover group-hover:scale-105 transition duration-300"
                            alt="{{ $event->title }}">
                    </a>

                    {{-- Badge --}}
                    <div class="absolute top-2 left-2 flex gap-1">
                        @if($event->is_recommended)
                            <span class="bg-yellow-400 text-yellow-900 text-xs px-2 py-0.5 rounded-full font-medium">
                                ⭐ Rekomendasi
                            </span>
                        @endif
                        @if($event->is_popular)
                            <span class="bg-orange-400 text-white text-xs px-2 py-0.5 rounded-full font-medium">
                                🔥 Populer
                            </span>
                        @endif
                    </div>

                    {{-- Tombol Favorit --}}
                    <form action="{{ in_array($event->id, $favoriteIds)
                            ? route('user.favorites.destroy', $event)
                            : route('user.favorites.store', $event) }}"
                        method="POST" class="absolute top-2 right-2">
                        @csrf
                        @if(in_array($event->id, $favoriteIds))
                            @method('DELETE')
                        @endif
                        <button type="submit"
                            class="bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full w-8 h-8 flex items-center justify-center shadow text-sm transition"
                            title="{{ in_array($event->id, $favoriteIds) ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                            {{ in_array($event->id, $favoriteIds) ? '❤️' : '🤍' }}
                        </button>
                    </form>

                    {{-- Harga --}}
                    <div class="absolute bottom-2 left-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <span class="text-xs text-blue-500 font-medium">{{ $event->category->name }}</span>
                    <a href="{{ route('user.events.show', $event->slug) }}">
                        <h4 class="font-semibold text-gray-800 mt-1 mb-2 line-clamp-2 hover:text-blue-600 transition">
                            {{ $event->title }}
                        </h4>
                    </a>
                    <div class="space-y-1 text-xs text-gray-500">
                        <p>📍 {{ $event->location }}</p>
                        <p>📅 {{ $event->start_date->format('d M Y, H:i') }}</p>
                        @if($event->quota)
                            <p>👥 Kuota: {{ $event->quota }} orang</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t">
                        <span class="text-xs text-gray-400">
                            👁️ {{ number_format($event->view_count) }} views
                        </span>
                        <a href="{{ route('user.events.show', $event->slug) }}"
                            class="text-xs text-blue-600 font-medium hover:underline">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
        <div class="mt-8">
            {{ $events->links() }}
        </div>
        @endif

        @else
        {{-- Empty State --}}
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <p class="text-5xl mb-4">🔍</p>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Event tidak ditemukan</h3>
            <p class="text-sm text-gray-400 mb-6">
                Coba ubah filter atau kata kunci pencarian Anda.
            </p>
            <a href="{{ route('user.events.index') }}"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                Reset Filter
            </a>
        </div>
        @endif

    </div>
</div>
@endsection