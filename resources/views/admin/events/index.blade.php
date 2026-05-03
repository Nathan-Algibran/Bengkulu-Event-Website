@extends('layouts.admin')
@section('title', 'Manajemen Event')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Manajemen Event</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola semua event di Bengkulu</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn-admin-primary">
        <i class="ph ph-plus text-base"></i>
        Tambah Event
    </a>
</div>

{{-- Filter --}}
<div class="admin-card p-4 mb-5">
    <form method="GET" action="{{ route('admin.events.index') }}"
        class="flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[180px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Cari Event
            </label>
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul event..."
                    class="admin-input pl-9">
            </div>
        </div>

        <div class="min-w-[160px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Kategori
            </label>
            <select name="category" class="admin-input admin-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="min-w-[140px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Status
            </label>
            <select name="status" class="admin-input admin-select">
                <option value="">Semua Status</option>
                <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn-admin-primary">
                <i class="ph ph-funnel text-base"></i>
                Filter
            </button>
            @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('admin.events.index') }}" class="btn-admin-secondary">
                <i class="ph ph-arrow-counter-clockwise text-base"></i>
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="admin-card overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
        <p class="text-sm text-gray-500">
            Total
            <span class="font-bold text-gray-800">{{ $events->total() }}</span>
            event ditemukan
        </p>
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <i class="ph ph-info text-sm"></i>
            Halaman {{ $events->currentPage() }} dari {{ $events->lastPage() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Event</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $index => $event)
                <tr class="event-row">
                    <td class="text-gray-400 text-xs font-medium">
                        {{ $events->firstItem() + $index }}
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $event->image
                                        ? asset('storage/' . $event->image)
                                        : 'https://placehold.co/56x40/C0392B/FDF8F0?text=E' }}"
                                    class="w-14 h-10 rounded-lg object-cover"
                                    alt="{{ $event->title }}">
                                @if($event->is_recommended)
                                <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full flex items-center justify-center"
                                    style="background: var(--gold-400)">
                                    <i class="ph ph-star-fill" style="font-size: 8px; color: white"></i>
                                </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate max-w-[200px]">
                                    {{ $event->title }}
                                </p>
                                <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                    <i class="ph ph-map-pin text-xs"></i>
                                    {{ Str::limit($event->location, 25) }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-blue">{{ $event->category->name }}</span>
                    </td>
                    <td>
                        <p class="text-xs font-medium text-gray-700">
                            {{ $event->start_date->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $event->start_date->format('H:i') }} WIB
                        </p>
                    </td>
                    <td>
                        <span class="text-sm font-semibold
                            {{ $event->price == 0 ? 'text-green-600' : 'text-gray-800' }}">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $event->is_active ? 'badge-green' : 'badge-red' }}">
                            <i class="ph {{ $event->is_active ? 'ph-check-circle' : 'ph-x-circle' }} text-xs"></i>
                            {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.events.show', $event) }}"
                                class="btn-admin-info" title="Detail">
                                <i class="ph ph-eye text-xs"></i>
                            </a>
                            <a href="{{ route('admin.events.edit', $event) }}"
                                class="btn-admin-warning" title="Edit">
                                <i class="ph ph-pencil-simple text-xs"></i>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event) }}"
                                method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button"
                                    onclick="confirmDelete(this)"
                                    class="btn-admin-danger" title="Hapus">
                                    <i class="ph ph-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <i class="ph ph-ticket text-5xl block mb-3" style="color: #E2E8F0"></i>
                        <p class="font-semibold text-gray-400 mb-1">Belum ada event</p>
                        <p class="text-sm text-gray-300 mb-4">Mulai tambahkan event pertamamu</p>
                        <a href="{{ route('admin.events.create') }}" class="btn-admin-primary mx-auto">
                            <i class="ph ph-plus text-base"></i>
                            Tambah Event
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($events->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $events->links() }}
    </div>
    @endif
</div>

{{-- Delete Confirm Modal --}}
<div id="deleteModal" style="display:none; position:fixed; inset:0; z-index:999;
    align-items:center; justify-content:center; padding:16px">
    <div id="deleteOverlay" onclick="cancelDelete()"
        style="position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(4px)">
    </div>
    <div id="deleteBox"
        style="position:relative; background:white; border-radius:20px; padding:28px;
               width:100%; max-width:380px; box-shadow:0 24px 64px rgba(0,0,0,0.15); z-index:1">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
            style="background: #FEE2E2">
            <i class="ph ph-trash text-3xl" style="color: #DC2626"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 text-center mb-1">Hapus Event?</h3>
        <p class="text-sm text-gray-400 text-center mb-6 leading-relaxed">
            Event ini akan dihapus permanen beserta gambarnya dan tidak dapat dikembalikan.
        </p>
        <div class="flex gap-3">
            <button onclick="cancelDelete()" class="btn-admin-secondary flex-1 justify-center">
                <i class="ph ph-x text-base"></i> Batal
            </button>
            <button onclick="executeDelete()" class="btn-admin-danger flex-1 justify-center"
                style="padding: 9px 18px; border-radius: 10px; font-size: 0.875rem">
                <i class="ph ph-trash text-base"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let pendingDeleteForm = null;

function confirmDelete(btn) {
    pendingDeleteForm = btn.closest('form');
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';
    gsap.set('#deleteBox',     { opacity: 0, scale: 0.85, y: 20 });
    gsap.set('#deleteOverlay', { opacity: 0 });
    gsap.to('#deleteOverlay',  { opacity: 1, duration: 0.3 });
    gsap.to('#deleteBox', { opacity: 1, scale: 1, y: 0, duration: 0.4, ease: 'back.out(1.6)' });
}

function cancelDelete() {
    gsap.to('#deleteBox',     { opacity: 0, scale: 0.9, y: 10, duration: 0.25, ease: 'power2.in' });
    gsap.to('#deleteOverlay', {
        opacity: 0, duration: 0.25, ease: 'power2.in',
        onComplete: () => {
            document.getElementById('deleteModal').style.display = 'none';
            pendingDeleteForm = null;
        }
    });
}

function executeDelete() {
    if (pendingDeleteForm) pendingDeleteForm.submit();
}

window.addEventListener('load', () => {
    gsap.registerPlugin(ScrollTrigger);

    gsap.set('.event-row', { opacity: 0, y: 16 });
    gsap.to('.event-row', {
        opacity: 1, y: 0,
        duration: 0.4, ease: 'power3.out',
        stagger: 0.05,
        delay: 0.2
    });
});
</script>
@endpush