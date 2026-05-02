@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Kategori</h2>
    <a href="{{ route('admin.categories.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        + Tambah Kategori
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.categories.index') }}" class="mb-4">
    <div class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari kategori..."
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}"
                class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm hover:bg-red-200">
                Reset
            </a>
        @endif
    </div>
</form>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-left">
            <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Nama Kategori</th>
                <th class="px-6 py-3">Slug</th>
                <th class="px-6 py-3">Deskripsi</th>
                <th class="px-6 py-3">Jumlah Event</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $index => $category)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-gray-500">
                    {{ $categories->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $category->name }}
                </td>
                <td class="px-6 py-4 text-gray-500">
                    <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $category->slug }}</code>
                </td>
                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                    {{ $category->description ?? '-' }}
                </td>
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">
                        {{ $category->events_count }} Event
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                            class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-xs hover:bg-yellow-200 transition">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                    Belum ada kategori. <a href="{{ route('admin.categories.create') }}" class="text-blue-500 underline">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($categories->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection