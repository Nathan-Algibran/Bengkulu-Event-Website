@extends('layouts.app')
@section('title', 'Favorit Saya')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">❤️ Favorit Saya</h2>
        <p class="text-gray-500 text-sm mt-1">
            Event yang telah kamu simpan.
        </p>
    </div>
    <span class="bg-red-100 text-red-600 text-sm font-semibold px-4 py-1.5 rounded-full">
        {{ $favorites->total() }} Event
    </span>
</div>

@if($favorites->count() > 0)

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($favorites as $event)
        <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden group">

            {{-- Gambar --}}
            <div class="relative overflow-hidden">
                <a href="{{ route('user.events.show', $event->slug) }}">
                    <img src="{{ $event->image
                            ? asset('storage/' . $event->image)
                            : 'https://placehold.co/400x220?text=No+Image' }}"
                        class="w-full h-40 object-cover group-hover:scale-105 transition duration-300"
                        alt="{{ $event->title }}">
                </a>

                {{-- Badge --}}
                <div class="absolute top-2 left-2 flex gap-1 flex-wrap">
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

                {{-- Tombol Hapus Favorit --}}
                <form action="{{ route('user.favorites.destroy', $event) }}"
                    method="POST"
                    class="absolute top-2 right-2"
                    onsubmit="return confirm('Hapus dari favorit?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-white bg-opacity-90 hover:bg-red-50 rounded-full w-8 h-8 flex items-center justify-center shadow text-sm transition"
                        title="Hapus dari favorit">
                        ❤️
                    </button>
                </form>

                {{-- Harga --}}
                <div class="absolute bottom-2 left-2">
                    <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                        {{ $event->price == 0
                            ? 'Gratis'
                            : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-4">
                <span class="text-xs text-blue-500 font-medium">
                    {{ $event->category->name }}
                </span>
                <a href="{{ route('user.events.show', $event->slug) }}">
                    <h4 class="font-semibold text-gray-800 mt-1 mb-2 line-clamp-2 hover:text-blue-600 transition text-sm">
                        {{ $event->title }}
                    </h4>
                </a>
                <div class="space-y-1 text-xs text-gray-500">
                    <p>📍 {{ $event->location }}</p>
                    <p>📅 {{ $event->start_date->format('d M Y, H:i') }}</p>
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
    @if($favorites->hasPages())
    <div class="mt-8">
        {{ $favorites->links() }}
    </div>
    @endif

@else
    {{-- Empty State --}}
    <div class="bg-white rounded-xl shadow p-16 text-center max-w-lg mx-auto">
        <p class="text-6xl mb-4">💔</p>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">
            Belum Ada Favorit
        </h3>
        <p class="text-sm text-gray-400 mb-6">
            Kamu belum menyimpan event apapun ke favorit.
            Jelajahi event seru dan simpan yang kamu suka!
        </p>
        <a href="{{ route('user.events.index') }}"
            class="inline-block bg-blue-600 text-white px-8 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            🔍 Jelajahi Event
        </a>
    </div>
@endif

@endsection