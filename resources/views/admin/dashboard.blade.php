@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="text-4xl">🎟️</div>
        <div>
            <p class="text-sm text-gray-500">Total Event</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalEvents }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="text-4xl">👥</div>
        <div>
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-2xl font-bold text-green-600">{{ $totalUsers }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="text-4xl">🗂️</div>
        <div>
            <p class="text-sm text-gray-500">Total Kategori</p>
            <p class="text-2xl font-bold text-purple-600">{{ $totalCategories }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Event Terbaru</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500 border-b">
                <th class="pb-2">Judul</th>
                <th class="pb-2">Kategori</th>
                <th class="pb-2">Tanggal</th>
                <th class="pb-2">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($recentEvents as $event)
            <tr>
                <td class="py-3">{{ $event->title }}</td>
                <td class="py-3">{{ $event->category->name }}</td>
                <td class="py-3">{{ $event->start_date->format('d M Y') }}</td>
                <td class="py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-400">Belum ada event</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection