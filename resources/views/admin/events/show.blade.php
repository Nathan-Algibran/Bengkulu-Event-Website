@extends('layouts.admin')
@section('title', 'Detail Event')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.events.index') }}"
        class="text-sm text-blue-600 hover:underline mb-4 inline-block">
        ← Kembali ke Daftar Event
    </a>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        {{-- Gambar --}}
        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/800x300?text=No+Image' }}"
            class="w-full h-56 object-cover" alt="{{ $event->title }}">

        <div class="p-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $event->category->name }}
                    </span>
                    <h2 class="text-2xl font-bold text-gray-800 mt-2">{{ $event->title }}</h2>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <a href="{{ route('admin.events.edit', $event) }}"
                        class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg text-sm hover:bg-yellow-200">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus event ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm hover:bg-red-200">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-400 text-xs mb-1">Lokasi</p>
                    <p class="text-gray-700 font-medium">📍 {{ $event->location }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-400 text-xs mb-1">Harga</p>
                    <p class="text-gray-700 font-medium">
                        {{ $event->price == 0 ? '🎟️ Gratis' : '💰 Rp ' . number_format($event->price, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-400 text-xs mb-1">Tanggal</p>
                    <p class="text-gray-700 font-medium">
                        📅 {{ $event->start_date->format('d M Y H:i') }}<br>
                        <span class="text-gray-400">s/d</span> {{ $event->end_date->format('d M Y H:i') }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-400 text-xs mb-1">Kuota</p>
                    <p class="text-gray-700 font-medium">
                        👥 {{ $event->quota ? $event->quota . ' orang' : 'Tidak Terbatas' }}
                    </p>
                </div>
            </div>

            <div>
                <p class="text-gray-400 text-xs mb-2">Deskripsi</p>
                <p class="text-gray-700 text-sm leading-relaxed">{{ $event->description }}</p>
            </div>

            <div class="flex gap-3 flex-wrap text-xs">
                <span class="px-3 py-1 rounded-full font-medium
                    {{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                    {{ $event->is_active ? '✅ Aktif' : '❌ Nonaktif' }}
                </span>
                @if($event->is_recommended)
                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">⭐ Rekomendasi</span>
                @endif
                @if($event->is_popular)
                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 font-medium">🔥 Populer</span>
                @endif
            </div>

            <div class="text-xs text-gray-400 border-t pt-4">
                Dibuat oleh: <span class="font-medium text-gray-600">{{ $event->user->name }}</span> •
                {{ $event->created_at->format('d M Y H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection