@extends('layouts.admin')
@section('title', 'Detail Event')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <a href="{{ route('admin.events.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition mb-3">
            <i class="ph ph-arrow-left text-base"></i>
            Kembali ke Daftar Event
        </a>
        <h2 class="text-xl font-bold text-gray-800">Detail Event</h2>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn-admin-warning">
            <i class="ph ph-pencil-simple text-base"></i>
            Edit
        </a>
        <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
            onsubmit="return confirm('Yakin hapus event ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-admin-danger" style="padding: 9px 14px; border-radius: 10px">
                <i class="ph ph-trash text-base"></i>
                Hapus
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Left --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Hero Image --}}
        <div class="admin-card overflow-hidden">
            <img src="{{ $event->image
                    ? asset('storage/' . $event->image)
                    : 'https://placehold.co/800x350/C0392B/FDF8F0?text=' . urlencode($event->title) }}"
                class="w-full object-cover" style="height: 280px" alt="{{ $event->title }}">

            <div class="p-6">
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="badge badge-blue">{{ $event->category->name }}</span>
                    @if($event->is_recommended)
                    <span class="badge badge-yellow">
                        <i class="ph ph-star-fill text-xs"></i> Rekomendasi
                    </span>
                    @endif
                    @if($event->is_popular)
                    <span class="badge" style="background: #FFEDD5; color: #EA580C">
                        <i class="ph ph-fire text-xs"></i> Populer
                    </span>
                    @endif
                    <span class="badge {{ $event->is_active ? 'badge-green' : 'badge-red' }} ml-auto">
                        <i class="ph {{ $event->is_active ? 'ph-check-circle' : 'ph-x-circle' }} text-xs"></i>
                        {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-4">{{ $event->title }}</h1>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                    {{ $event->description }}
                </p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            @foreach([
                ['ph-eye', number_format($event->view_count), 'Total Views', '#EFF6FF', '#3B82F6'],
                ['ph-heart', $event->favorites()->count(), 'Difavoritkan', '#FFF1F0', '#C0392B'],
                ['ph-clock', $event->created_at->diffForHumans(), 'Dibuat', '#F0FDF4', '#1A5C38'],
            ] as [$icon, $val, $label, $bg, $color])
            <div class="admin-card p-4 text-center" style="background: {{ $bg }}">
                <i class="ph {{ $icon }} text-xl mb-2 block" style="color: {{ $color }}"></i>
                <p class="font-bold text-gray-800 text-sm">{{ $val }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right --}}
    <div class="space-y-4">
        <div class="admin-card p-5">
            <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-4">
                <i class="ph ph-info text-base" style="color: var(--red-600)"></i>
                Info Event
            </h3>
            <div class="space-y-4">
                @foreach([
                    ['ph-map-pin',       'var(--red-50)',  'var(--red-600)',  'Lokasi',         $event->location],
                    ['ph-calendar',      '#FFFBEB',        'var(--gold-600)', 'Mulai',          $event->start_date->format('d M Y, H:i') . ' WIB'],
                    ['ph-calendar-check','#F0FDF4',        'var(--green-700)','Selesai',        $event->end_date->format('d M Y, H:i') . ' WIB'],
                    ['ph-ticket',        '#EFF6FF',        '#3B82F6',         'Harga',          $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.')],
                    ['ph-users',         '#FFF7ED',        '#EA580C',         'Kuota',          $event->quota ? number_format($event->quota) . ' orang' : 'Tidak Terbatas'],
                ] as [$icon, $bg, $color, $label, $val])
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                        style="background: {{ $bg }}">
                        <i class="ph {{ $icon }} text-sm" style="color: {{ $color }}"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">{{ $label }}</p>
                        <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $val }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="admin-card p-5">
            <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-4">
                <i class="ph ph-user-circle text-base" style="color: var(--red-600)"></i>
                Dibuat Oleh
            </h3>
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($event->user->name) }}&background=C0392B&color=fff&size=48&bold=true"
                    class="w-11 h-11 rounded-xl object-cover" alt="{{ $event->user->name }}">
                <div>
                    <p class="font-bold text-gray-800 text-sm">{{ $event->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $event->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection