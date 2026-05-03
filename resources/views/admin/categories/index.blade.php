@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Manajemen Kategori</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola semua kategori event</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-admin-primary">
        <i class="ph ph-plus text-base"></i>
        Tambah Kategori
    </a>
</div>

{{-- Filter --}}
<div class="admin-card p-4 mb-5">
    <form method="GET" action="{{ route('admin.categories.index') }}"
        class="flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Cari Kategori
            </label>
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama kategori..."
                    class="admin-input pl-9">
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn-admin-primary">
                <i class="ph ph-funnel text-base"></i>
                Filter
            </button>
            @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="btn-admin-secondary">
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
            <span class="font-bold text-gray-800">{{ $categories->total() }}</span>
            kategori ditemukan
        </p>
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <i class="ph ph-info text-sm"></i>
            Halaman {{ $categories->currentPage() }} dari {{ $categories->lastPage() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Event</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr>
                    <td class="text-gray-400 text-xs font-medium">
                        {{ $categories->firstItem() + $index }}
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                                style="background: var(--red-50)">
                                <i class="ph ph-tag text-sm" style="color: var(--red-600)"></i>
                            </div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $category->name }}</p>
                        </div>
                    </td>
                    <td>
                        <code class="text-xs px-2.5 py-1 rounded-lg font-mono"
                            style="background: #F1F5F9; color: #475569">
                            {{ $category->slug }}
                        </code>
                    </td>
                    <td class="text-sm text-gray-500 max-w-xs">
                        <span class="line-clamp-1">{{ $category->description ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="badge badge-blue">
                            <i class="ph ph-ticket text-xs"></i>
                            {{ $category->events_count }} Event
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn-admin-warning" title="Edit">
                                <i class="ph ph-pencil-simple text-xs"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button"
                                    onclick="confirmDelete(this, '{{ $category->name }}', {{ $category->events_count }})"
                                    class="btn-admin-danger" title="Hapus">
                                    <i class="ph ph-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <i class="ph ph-tag text-5xl block mb-3" style="color: #E2E8F0"></i>
                        <p class="font-semibold text-gray-400 mb-1">Belum ada kategori</p>
                        <p class="text-sm text-gray-300 mb-4">Mulai tambahkan kategori pertama</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn-admin-primary mx-auto">
                            <i class="ph ph-plus text-base"></i>
                            Tambah Kategori
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $categories->links() }}
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
        <h3 class="text-lg font-bold text-gray-800 text-center mb-1">Hapus Kategori?</h3>
        <p id="deleteDesc" class="text-sm text-gray-400 text-center mb-6 leading-relaxed"></p>
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

function confirmDelete(btn, name, eventCount) {
    if (eventCount > 0) {
        // Tampilkan peringatan jika masih ada event
        pendingDeleteForm = null;
        document.getElementById('deleteDesc').innerHTML =
            `Kategori <strong class="text-gray-700">"${name}"</strong> tidak dapat dihapus karena masih memiliki <strong class="text-red-600">${eventCount} event</strong> terkait.`;
        document.querySelector('#deleteBox .btn-admin-danger').style.display = 'none';
        document.querySelector('#deleteBox h3').textContent = 'Tidak Dapat Dihapus';
        document.querySelector('#deleteBox .w-14').style.background = '#FEF9C3';
        document.querySelector('#deleteBox .ph-trash').style.color = '#D97706';
    } else {
        pendingDeleteForm = btn.closest('form');
        document.getElementById('deleteDesc').innerHTML =
            `Kategori <strong class="text-gray-700">"${name}"</strong> akan dihapus permanen dan tidak dapat dikembalikan.`;
        document.querySelector('#deleteBox .btn-admin-danger').style.display = 'flex';
        document.querySelector('#deleteBox h3').textContent = 'Hapus Kategori?';
        document.querySelector('#deleteBox .w-14').style.background = '#FEE2E2';
        document.querySelector('#deleteBox .ph-trash').style.color = '#DC2626';
    }

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
        opacity: 0, duration: 0.3,
        onComplete: () => {
            document.getElementById('deleteModal').style.display = 'none';
            pendingDeleteForm = null;
        }
    });
}

function executeDelete() {
    if (pendingDeleteForm) pendingDeleteForm.submit();
}
</script>
@endpush