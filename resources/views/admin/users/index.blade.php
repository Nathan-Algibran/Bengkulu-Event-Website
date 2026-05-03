@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Manajemen Pengguna</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola semua akun pengguna terdaftar</p>
    </div>
</div>

{{-- Filter --}}
<div class="admin-card p-4 mb-5">
    <form method="GET" action="{{ route('admin.users.index') }}"
        class="flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                Cari Pengguna
            </label>
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau email..."
                    class="admin-input pl-9">
            </div>
        </div>

        <div class="min-w-[150px]">
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
            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.users.index') }}" class="btn-admin-secondary">
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
            <span class="font-bold text-gray-800">{{ $users->total() }}</span>
            pengguna ditemukan
        </p>
        <div class="flex items-center gap-2 text-xs text-gray-400">
            <i class="ph ph-info text-sm"></i>
            Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Favorit</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td class="text-gray-400 text-xs font-medium">
                        {{ $users->firstItem() + $index }}
                    </td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $user->avatar
                                        ? asset('storage/' . $user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=40&background=C0392B&color=fff&bold=true' }}"
                                    class="w-9 h-9 rounded-full object-cover"
                                    alt="{{ $user->name }}">
                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white
                                    {{ $user->is_active ? 'bg-green-400' : 'bg-gray-300' }}">
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">
                                    #{{ $user->id }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <i class="ph ph-envelope text-gray-300 text-xs"></i>
                            {{ $user->email }}
                        </div>
                    </td>
                    <td>
                        @if($user->phone)
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <i class="ph ph-phone text-gray-300 text-xs"></i>
                            {{ $user->phone }}
                        </div>
                        @else
                        <span class="text-gray-300 text-sm">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge" style="background:#F3E8FF; color:#6B21A8">
                            <i class="ph ph-heart text-xs"></i>
                            {{ $user->favorites_count }} event
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                            <i class="ph {{ $user->is_active ? 'ph-check-circle' : 'ph-x-circle' }} text-xs"></i>
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <p class="text-xs font-medium text-gray-700">
                            {{ $user->created_at->format('d M Y') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $user->created_at->diffForHumans() }}
                        </p>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.users.show', $user) }}"
                                class="btn-admin-info" title="Detail">
                                <i class="ph ph-eye text-xs"></i>
                            </a>
                            <form action="{{ route('admin.users.toggleActive', $user) }}"
                                method="POST" class="toggle-form">
                                @csrf @method('PATCH')
                                <button type="button"
                                    onclick="confirmToggle(this, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                                    class="{{ $user->is_active ? 'btn-admin-danger' : 'btn-admin-warning' }}"
                                    title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="ph {{ $user->is_active ? 'ph-prohibit' : 'ph-check-circle' }} text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-16 text-center">
                        <i class="ph ph-users text-5xl block mb-3" style="color: #E2E8F0"></i>
                        <p class="font-semibold text-gray-400 mb-1">Tidak ada pengguna</p>
                        <p class="text-sm text-gray-300">Coba ubah filter pencarian</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- Toggle Status Modal --}}
<div id="toggleModal" style="display:none; position:fixed; inset:0; z-index:999;
    align-items:center; justify-content:center; padding:16px">
    <div id="toggleOverlay" onclick="cancelToggle()"
        style="position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(4px)">
    </div>
    <div id="toggleBox"
        style="position:relative; background:white; border-radius:20px; padding:28px;
               width:100%; max-width:380px; box-shadow:0 24px 64px rgba(0,0,0,0.15); z-index:1">
        <div id="toggleIcon" class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i id="toggleIconInner" class="text-3xl"></i>
        </div>
        <h3 id="toggleTitle" class="text-lg font-bold text-gray-800 text-center mb-1"></h3>
        <p id="toggleDesc" class="text-sm text-gray-400 text-center mb-6 leading-relaxed"></p>
        <div class="flex gap-3">
            <button onclick="cancelToggle()" class="btn-admin-secondary flex-1 justify-center">
                <i class="ph ph-x text-base"></i> Batal
            </button>
            <button id="toggleConfirmBtn" onclick="executeToggle()"
                class="flex-1 justify-center font-semibold text-sm flex items-center gap-2 rounded-xl transition"
                style="padding: 9px 18px">
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let pendingToggleForm = null;

function confirmToggle(btn, name, isActive) {
    pendingToggleForm = btn.closest('form');

    const icon    = document.getElementById('toggleIcon');
    const iconEl  = document.getElementById('toggleIconInner');
    const title   = document.getElementById('toggleTitle');
    const desc    = document.getElementById('toggleDesc');
    const confirm = document.getElementById('toggleConfirmBtn');

    if (isActive) {
        icon.style.background = '#FEE2E2';
        iconEl.className = 'ph ph-prohibit text-3xl';
        iconEl.style.color = '#DC2626';
        title.textContent = 'Nonaktifkan Akun?';
        desc.innerHTML = `Akun <strong class="text-gray-700">"${name}"</strong> akan dinonaktifkan. Pengguna tidak dapat login hingga diaktifkan kembali.`;
        confirm.className = 'btn-admin-danger flex-1 justify-center';
        confirm.innerHTML = '<i class="ph ph-prohibit text-base"></i> Ya, Nonaktifkan';
    } else {
        icon.style.background = '#DCFCE7';
        iconEl.className = 'ph ph-check-circle text-3xl';
        iconEl.style.color = '#16A34A';
        title.textContent = 'Aktifkan Akun?';
        desc.innerHTML = `Akun <strong class="text-gray-700">"${name}"</strong> akan diaktifkan kembali. Pengguna dapat login seperti biasa.`;
        confirm.className = 'btn-admin-warning flex-1 justify-center';
        confirm.innerHTML = '<i class="ph ph-check-circle text-base"></i> Ya, Aktifkan';
    }

    const modal = document.getElementById('toggleModal');
    modal.style.display = 'flex';
    gsap.set('#toggleBox',     { opacity: 0, scale: 0.85, y: 20 });
    gsap.set('#toggleOverlay', { opacity: 0 });
    gsap.to('#toggleOverlay',  { opacity: 1, duration: 0.3 });
    gsap.to('#toggleBox', { opacity: 1, scale: 1, y: 0, duration: 0.4, ease: 'back.out(1.6)' });
}

function cancelToggle() {
    gsap.to('#toggleBox',     { opacity: 0, scale: 0.9, y: 10, duration: 0.25, ease: 'power2.in' });
    gsap.to('#toggleOverlay', {
        opacity: 0, duration: 0.3,
        onComplete: () => {
            document.getElementById('toggleModal').style.display = 'none';
            pendingToggleForm = null;
        }
    });
}

function executeToggle() {
    if (pendingToggleForm) pendingToggleForm.submit();
}
</script>
@endpush