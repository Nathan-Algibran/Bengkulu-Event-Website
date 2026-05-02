@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 mb-4 flex items-center gap-2">
        <a href="{{ route('user.events.index') }}" class="hover:text-blue-600">Jelajahi Event</a>
        <span>/</span>
        <span class="text-gray-600 truncate max-w-xs">{{ $event->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- KONTEN UTAMA --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Gambar --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/800x400?text=No+Image' }}"
                    class="w-full h-64 md:h-80 object-cover" alt="{{ $event->title }}">

                <div class="p-6">
                    {{-- Badge --}}
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">
                            {{ $event->category->name }}
                        </span>
                        @if($event->is_recommended)
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-medium">
                                ⭐ Rekomendasi
                            </span>
                        @endif
                        @if($event->is_popular)
                            <span class="bg-orange-100 text-orange-700 text-xs px-3 py-1 rounded-full font-medium">
                                🔥 Populer
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $event->title }}</h1>

                    <p class="text-xs text-gray-400 mb-4">
                        👁️ {{ number_format($event->view_count) }} kali dilihat
                    </p>

                    <hr class="mb-4">

                    <h3 class="text-base font-semibold text-gray-700 mb-2">Tentang Event</h3>
                    <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $event->description }}
                    </div>
                </div>
            </div>

        </div>

        {{-- SIDEBAR KANAN --}}
        <div class="space-y-4">

            {{-- Info Card --}}
            <div class="bg-white rounded-xl shadow p-5 space-y-4">

                {{-- Harga --}}
                <div>
                    <p class="text-xs text-gray-400 mb-1">Harga Tiket</p>
                    <p class="text-2xl font-bold {{ $event->price == 0 ? 'text-green-600' : 'text-blue-600' }}">
                        {{ $event->price == 0 ? '🎟️ GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                    </p>
                </div>

                <hr>

                {{-- Detail --}}
                <div class="space-y-3 text-sm">
                    <div class="flex gap-3">
                        <span class="text-xl flex-shrink-0">📍</span>
                        <div>
                            <p class="text-xs text-gray-400">Lokasi</p>
                            <p class="text-gray-700 font-medium">{{ $event->location }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-xl flex-shrink-0">📅</span>
                        <div>
                            <p class="text-xs text-gray-400">Tanggal Mulai</p>
                            <p class="text-gray-700 font-medium">
                                {{ $event->start_date->format('d M Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $event->start_date->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-xl flex-shrink-0">🏁</span>
                        <div>
                            <p class="text-xs text-gray-400">Tanggal Selesai</p>
                            <p class="text-gray-700 font-medium">
                                {{ $event->end_date->format('d M Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $event->end_date->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-xl flex-shrink-0">👥</span>
                        <div>
                            <p class="text-xs text-gray-400">Kuota</p>
                            <p class="text-gray-700 font-medium">
                                {{ $event->quota ? $event->quota . ' orang' : 'Tidak Terbatas' }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Tombol Favorit --}}
                <form action="{{ $isFavorited
                        ? route('user.favorites.destroy', $event)
                        : route('user.favorites.store', $event) }}"
                    method="POST">
                    @csrf
                    @if($isFavorited) @method('DELETE') @endif
                    <button type="submit"
                        class="w-full py-2.5 rounded-lg text-sm font-medium transition
                        {{ $isFavorited
                            ? 'bg-red-50 text-red-600 border border-red-200 hover:bg-red-100'
                            : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                        {{ $isFavorited ? '❤️ Hapus dari Favorit' : '🤍 Simpan ke Favorit' }}
                    </button>
                </form>

                {{-- Share --}}
                <button onclick="copyLink()"
                    class="w-full py-2.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                    🔗 Salin Link Event
                </button>
            </div>

            {{-- Penyelenggara --}}
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-xs text-gray-400 mb-2">Diselenggarakan oleh</p>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($event->user->name) }}&size=40&background=3b82f6&color=fff"
                        class="w-10 h-10 rounded-full" alt="{{ $event->user->name }}">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $event->user->name }}</p>
                        <p class="text-xs text-gray-400">Admin Event Bengkulu</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Event Terkait --}}
    @if($relatedEvents->count() > 0)
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            🎯 Event Terkait
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($relatedEvents as $related)
            <a href="{{ route('user.events.show', $related->slug) }}"
                class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden group">
                <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://placehold.co/300x180?text=No+Image' }}"
                    class="w-full h-32 object-cover group-hover:scale-105 transition duration-300"
                    alt="{{ $related->title }}">
                <div class="p-3">
                    <span class="text-xs text-blue-500">{{ $related->category->name }}</span>
                    <h4 class="text-sm font-semibold text-gray-800 mt-1 line-clamp-2">
                        {{ $related->title }}
                    </h4>
                    <p class="text-xs text-gray-400 mt-1">
                        📅 {{ $related->start_date->format('d M Y') }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link event berhasil disalin!');
    });
}
</script>
@endsection