@extends('layouts.admin')
@section('title', 'Manajemen Event')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Event</h2>
    <a href="{{ route('admin.events.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        + Tambah Event
    </a>
</div>

{{-- Filter & Search --}}
<form method="GET" action="{{ route('admin.events.index') }}" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari judul event..."
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-56">

    <select name="category"
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>

    <select name="status"
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Status</option>
        <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>

    <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        Filter
    </button>

    @if(request()->hasAny(['search', 'category', 'status']))
        <a href="{{ route('admin.events.index') }}"
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
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Gambar</th>
                <th class="px-4 py-3">Judul Event</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($events as $index => $event)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500">
                    {{ $events->firstItem() + $index }}
                </td>
                <td class="px-4 py-3">
                    <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/80x50?text=No+Img' }}"
                        class="w-20 h-12 object-cover rounded-lg" alt="{{ $event->title }}">
                </td>
                <td class="px-4 py-3 font-medium text-gray-800 max-w-xs">
                    <p class="truncate">{{ $event->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">📍 {{ $event->location }}</p>
                </td>
                <td class="px-4 py-3">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                        {{ $event->category->name }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs">
                    <p>{{ $event->start_date->format('d M Y') }}</p>
                    <p class="text-gray-400">s/d {{ $event->end_date->format('d M Y') }}</p>
                </td>
                <td class="px-4 py-3 text-gray-700">
                    {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex flex-col gap-1">
                        <a href="{{ route('admin.events.show', $event) }}"
                            class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs hover:bg-blue-100 text-center">
                            👁️ Detail
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}"
                            class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-lg text-xs hover:bg-yellow-100 text-center">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-50 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-100">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                    Belum ada event.
                    <a href="{{ route('admin.events.create') }}" class="text-blue-500 underline">Tambah sekarang</a>
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