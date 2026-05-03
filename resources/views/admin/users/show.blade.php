@extends('layouts.admin')
@section('title', 'Detail Pengguna')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('admin.users.index') }}"
                class="text-gray-400 hover:text-gray-600 transition">
                <i class="ph ph-arrow-left text-base"></i>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Detail Pengguna</h2>
        </div>
        <p class="text-sm text-gray-400 ml-6">Informasi lengkap akun pengguna</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-admin-secondary">
        <i class="ph ph-users text-base"></i>
        Semua Pengguna
    </a>
</div>

<div class="max-w-3xl space-y-5">

    {{-- Profil Card --}}
    <div class="admin-card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">

            {{-- Avatar --}}
            <div class="relative flex-shrink-0 self-start">
                <img src="{{ $user->avatar
                        ? asset('storage/' . $user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=96&background=C0392B&color=fff&bold=true' }}"
                    class="w-24 h-24 rounded-2xl object-cover"
                    style="box-shadow: 0 4px 20px rgba(192,57,43,0.2)"
                    alt="{{ $user->name }}">
                <span class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center
                    {{ $user->is_active ? 'bg-green-400' : 'bg-gray-300' }}">
                </span>
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-400 mt-0.5">ID #{{ $user->id }}</p>
                    </div>
                    <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                        <i class="ph {{ $user->is_active ? 'ph-check-circle' : 'ph-x-circle' }} text-xs"></i>
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                            style="background: #EFF6FF">
                            <i class="ph ph-envelope text-sm" style="color: #2563EB"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400">Email</p>
                            <p class="text-sm font-medium text-gray-700 truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                            style="background: #F0FDF4">
                            <i class="ph ph-phone text-sm" style="color: #16A34A"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">No. HP</p>
                            <p class="text-sm font-medium text-gray-700">{{ $user->phone ?? 'Belum diisi' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                            style="background: #FFF7ED">
                            <i class="ph ph-calendar-blank text-sm" style="color: #EA580C"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Bergabung</p>
                            <p class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                            style="background: #F5F3FF">
                            <i class="ph ph-clock text-sm" style="color: #7C3AED"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Terakhir Update</p>
                            <p class="text-sm font-medium text-gray-700">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toggle Status --}}
        <div class="mt-5 pt-5 border-t border-gray-50 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-gray-700">Status Akun</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $user->is_active
                        ? 'Pengguna dapat login dan menggunakan aplikasi.'
                        : 'Akun dinonaktifkan. Pengguna tidak dapat login.' }}
                </p>
            </div>
            <form action="{{ route('admin.users.toggleActive', $user) }}"
                method="POST" class="toggle-form flex-shrink-0">
                @csrf @method('PATCH')
                <button type="button"
                    onclick="confirmToggle(this, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                    class="{{ $user->is_active ? 'btn-admin-danger' : 'btn-admin-warning' }}">
                    <i class="ph {{ $user->is_active ? 'ph-prohibit' : 'ph-check-circle' }} text-base"></i>
                    {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="admin-card p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                    style="background: #F3E8FF">
                    <i class="ph ph-heart text-2xl" style="color: #7C3AED"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Event Difavoritkan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $user->favorites_count }}</p>
                </div>
            </div>
        </div>
        <div class="admin-card p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                    style="background: var(--red-50)">
                    <i class="ph ph-calendar-check text-2xl" style="color: var(--red-600)"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Bergabung Sejak</p>
                    <p class="text-lg font-bold text-gray-800">{{ $user->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Event Favorit Terakhir --}}
    <div class="admin-card overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                style="background: #F3E8FF">
                <i class="ph ph-heart text-sm" style="color: #7C3AED"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Event Favorit Terakhir</h3>
                <p class="text-xs text-gray-400">5 favorit terbaru</p>
            </div>
        </div>

        <div class="divide-y divide-gray-50">
            @forelse($favorites as $event)
            <div class="flex items-center gap-4 px-6 py-4">
                <img src="{{ $event->image
                        ? asset('storage/' . $event->image)
                        : 'https://placehold.co/64x48/C0392B/FDF8F0?text=E' }}"
                    class="w-16 h-12 object-cover rounded-xl flex-shrink-0"
                    alt="{{ $event->title }}">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm truncate">{{ $event->title }}</p>
                    <div class="flex items-center flex-wrap gap-x-3 gap-y-0.5 mt-1">
                        <span class="badge badge-blue text-xs">{{ $event->category->name }}</span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="ph ph-map-pin text-xs"></i>
                            {{ Str::limit($event->location, 20) }}
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="ph ph-calendar text-xs"></i>
                            {{ $event->start_date->format('d M Y') }}
                        </span>
                    </div>
                </div>
                <span class="badge {{ $event->is_active ? 'badge-green' : 'badge-red' }} flex-shrink-0">
                    {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <i class="ph ph-heart text-4xl block mb-3" style="color: #E2E8F0"></i>
                <p class="font-semibold text-gray-400 text-sm">Belum ada favorit</p>
                <p class="text-xs text-gray-300 mt-1">Pengguna ini belum memfavoritkan event apapun.</p>
            </div>
            @endforelse
        </div>
    </div>

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