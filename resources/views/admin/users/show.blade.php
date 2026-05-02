@extends('layouts.admin')
@section('title', 'Detail Pengguna')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.users.index') }}"
        class="text-sm text-blue-600 hover:underline mb-4 inline-block">
        ← Kembali ke Daftar Pengguna
    </a>

    <div class="grid grid-cols-1 gap-6">

        {{-- Profil Card --}}
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center gap-5">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=80' }}"
                    class="w-20 h-20 rounded-full object-cover border-4 border-blue-100" alt="{{ $user->name }}">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    <p class="text-gray-400 text-sm mt-0.5">
                        📱 {{ $user->phone ?? 'Belum diisi' }}
                    </p>
                    <div class="mt-2 flex gap-2 flex-wrap">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $user->is_active ? '✅ Aktif' : '❌ Nonaktif' }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                            Bergabung {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                {{-- Tombol Toggle --}}
                <form action="{{ route('admin.users.toggleActive', $user) }}"
                    method="POST"
                    onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition
                        {{ $user->is_active
                            ? 'bg-red-100 text-red-600 hover:bg-red-200'
                            : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        {{ $user->is_active ? '🚫 Nonaktifkan' : '✅ Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                <div class="text-3xl">❤️</div>
                <div>
                    <p class="text-xs text-gray-400">Event Difavoritkan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $user->favorites_count }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                <div class="text-3xl">📅</div>
                <div>
                    <p class="text-xs text-gray-400">Bergabung Sejak</p>
                    <p class="text-base font-bold text-blue-600">{{ $user->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Event Favorit Terakhir --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-base font-semibold text-gray-700 mb-4">
                ❤️ Event Favorit Terakhir
            </h3>
            @forelse($favorites as $event)
            <div class="flex items-center gap-4 py-3 border-b last:border-0">
                <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/60x40?text=No+Img' }}"
                    class="w-16 h-12 object-cover rounded-lg flex-shrink-0" alt="{{ $event->title }}">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $event->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $event->category->name }} • 📍 {{ $event->location }}
                    </p>
                    <p class="text-xs text-gray-400">
                        📅 {{ $event->start_date->format('d M Y') }}
                    </p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs flex-shrink-0
                    {{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                    {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            @empty
            <p class="text-gray-400 text-sm py-4 text-center">
                Pengguna ini belum memfavoritkan event apapun.
            </p>
            @endforelse
        </div>

    </div>
</div>
@endsection