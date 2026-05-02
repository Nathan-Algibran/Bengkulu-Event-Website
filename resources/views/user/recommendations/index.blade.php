@extends('layouts.app')
@section('title', 'Rekomendasi Event')

@section('content')

<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">🎯 Rekomendasi Event</h2>
    <p class="text-gray-500 text-sm mt-1">
        Event pilihan khusus untukmu berdasarkan minat dan aktivitasmu.
    </p>
</div>

{{-- ============================================ --}}
{{-- REKOMENDASI PERSONAL --}}
{{-- ============================================ --}}
@if($personalEvents->count() > 0)
<section class="mb-10">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                ✨ Untukmu
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">
                Berdasarkan kategori favorit kamu
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($personalEvents as $event)
            @include('user.recommendations._card', ['event' => $event])
        @endforeach
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- EVENT REKOMENDASI ADMIN --}}
{{-- ============================================ --}}
@if($recommendedEvents->count() > 0)
<section class="mb-10">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                ⭐ Event Rekomendasi
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">
                Dipilih langsung oleh tim Event Bengkulu
            </p>
        </div>
        <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-medium">
            {{ $recommendedEvents->count() }} Event
        </span>
    </div>

    {{-- Horizontal Scroll pada mobile, grid pada desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($recommendedEvents as $event)
            @include('user.recommendations._card', ['event' => $event])
        @endforeach
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- EVENT POPULER --}}
{{-- ============================================ --}}
@if($popularEvents->count() > 0)
<section class="mb-10">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                🔥 Event Populer
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">
                Paling banyak dilihat dan diminati
            </p>
        </div>
        <span class="text-xs bg-orange-100 text-orange-700 px-3 py-1 rounded-full font-medium">
            {{ $popularEvents->count() }} Event
        </span>
    </div>

    {{-- List Style untuk popular --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        @foreach($popularEvents as $i => $event)
        <div class="flex items-center gap-4 p-4 {{ !$loop->last ? 'border-b' : '' }} hover:bg-gray-50 transition">

            {{-- Ranking --}}
            <div class="flex-shrink-0 w-8 text-center">
                @if($i === 0)
                    <span class="text-2xl">🥇</span>
                @elseif($i === 1)
                    <span class="text-2xl">🥈</span>
                @elseif($i === 2)
                    <span class="text-2xl">🥉</span>
                @else
                    <span class="text-lg font-bold text-gray-300">{{ $i + 1 }}</span>
                @endif
            </div>

            {{-- Gambar --}}
            <img src="{{ $event->image
                    ? asset('storage/' . $event->image)
                    : 'https://placehold.co/80x56?text=No' }}"
                class="w-20 h-14 object-cover rounded-lg flex-shrink-0"
                alt="{{ $event->title }}">

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <span class="text-xs text-blue-500 font-medium">
                    {{ $event->category->name }}
                </span>
                <a href="{{ route('user.events.show', $event->slug) }}">
                    <h4 class="font-semibold text-gray-800 text-sm mt-0.5 truncate hover:text-blue-600 transition">
                        {{ $event->title }}
                    </h4>
                </a>
                <div class="flex items-center gap-3 text-xs text-gray-400 mt-1">
                    <span>📍 {{ $event->location }}</span>
                    <span>📅 {{ $event->start_date->format('d M Y') }}</span>
                </div>
            </div>

            {{-- Stats & Aksi --}}
            <div class="flex-shrink-0 text-right space-y-2">
                <div>
                    <p class="text-sm font-bold text-blue-600">
                        {{ number_format($event->view_count) }}
                    </p>
                    <p class="text-xs text-gray-400">views</p>
                </div>

                {{-- Tombol Favorit --}}
                <form action="{{ in_array($event->id, $favoriteIds)
                        ? route('user.favorites.destroy', $event)
                        : route('user.favorites.store', $event) }}"
                    method="POST">
                    @csrf
                    @if(in_array($event->id, $favoriteIds)) @method('DELETE') @endif
                    <button type="submit"
                        class="text-lg transition hover:scale-110"
                        title="{{ in_array($event->id, $favoriteIds) ? 'Hapus dari favorit' : 'Simpan ke favorit' }}">
                        {{ in_array($event->id, $favoriteIds) ? '❤️' : '🤍' }}
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- EVENT TERBARU --}}
{{-- ============================================ --}}
@if($latestEvents->count() > 0)
<section class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                🆕 Event Terbaru
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">
                Baru saja ditambahkan
            </p>
        </div>
        <a href="{{ route('user.events.index') }}"
            class="text-sm text-blue-600 hover:underline font-medium">
            Lihat Semua →
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($latestEvents as $event)
            @include('user.recommendations._card', ['event' => $event])
        @endforeach
    </div>
</section>
@endif

{{-- ============================================ --}}
{{-- EMPTY STATE --}}
{{-- ============================================ --}}
@if(
    $recommendedEvents->isEmpty() &&
    $popularEvents->isEmpty() &&
    $latestEvents->isEmpty()
)
<div class="bg-white rounded-xl shadow p-16 text-center max-w-lg mx-auto">
    <p class="text-6xl mb-4">🎯</p>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">
        Belum Ada Rekomendasi
    </h3>
    <p class="text-sm text-gray-400 mb-6">
        Admin belum menambahkan event rekomendasi.
        Jelajahi semua event yang tersedia!
    </p>
    <a href="{{ route('user.events.index') }}"
        class="inline-block bg-blue-600 text-white px-8 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
        🔍 Jelajahi Event
    </a>
</div>
@endif

@endsection