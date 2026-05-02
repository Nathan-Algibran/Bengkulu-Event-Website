@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Pengguna</h2>
    <span class="text-sm text-gray-400">Total: {{ $users->total() }} pengguna</span>
</div>

{{-- Search & Filter --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari nama atau email..."
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-64">

    <select name="status"
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Status</option>
        <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>

    <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        Cari
    </button>

    @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('admin.users.index') }}"
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
                <th class="px-5 py-3">Pengguna</th>
                <th class="px-5 py-3">Email</th>
                <th class="px-5 py-3">No. HP</th>
                <th class="px-5 py-3">Favorit</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Bergabung</th>
                <th class="px-5 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $index => $user)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4 text-gray-400">
                    {{ $users->firstItem() + $index }}
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=40' }}"
                            class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $user->name }}">
                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-500">{{ $user->email }}</td>
                <td class="px-5 py-4 text-gray-500">{{ $user->phone ?? '-' }}</td>
                <td class="px-5 py-4">
                    <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">
                        {{ $user->favorites_count }} event
                    </span>
                </td>
                <td class="px-5 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $user->is_active ? '✅ Aktif' : '❌ Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-4 text-gray-400 text-xs">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-5 py-4">
                    <div class="flex flex-col gap-1">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs hover:bg-blue-100 text-center">
                            👁️ Detail
                        </a>
                        <form action="{{ route('admin.users.toggleActive', $user) }}"
                            method="POST"
                            onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ $user->name }}?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full px-3 py-1 rounded-lg text-xs text-center transition
                                {{ $user->is_active
                                    ? 'bg-red-50 text-red-600 hover:bg-red-100'
                                    : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                                {{ $user->is_active ? '🚫 Nonaktifkan' : '✅ Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                    Tidak ada pengguna ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection