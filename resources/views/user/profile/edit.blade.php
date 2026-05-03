@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- ============================================ --}}
    {{-- PAGE HEADER                                 --}}
    {{-- ============================================ --}}
    <div id="pageHeader" class="mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                style="background: linear-gradient(135deg, var(--red-600), var(--red-500));
                       box-shadow: 0 4px 14px rgba(192,57,43,0.3)">
                <i class="ph ph-user text-2xl text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Profil Saya</h1>
                <p class="text-gray-400 text-sm mt-0.5">
                    Kelola informasi akun dan keamananmu
                </p>
            </div>
        </div>
    </div>

    <div class="space-y-5">

        {{-- ============================================ --}}
        {{-- CARD 1: AVATAR + INFO SINGKAT              --}}
        {{-- ============================================ --}}
        <div class="card overflow-hidden" id="avatarCard">

        {{-- Batik Header --}}
        <div class="relative"
            style="background: linear-gradient(135deg, #4A0E0E 0%, var(--red-600) 50%, #7A2200 100%);
                height: 110px">
            <div class="absolute inset-0 opacity-10"
                style="background-image: url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23D4A843' fill-opacity='1'%3E%3Cpath d='M20 20c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S10 35.523 10 30s4.477-10 10-10zM0 0c0-5.523 4.477-10 10-10s10 4.477 10 10S15.523 10 10 10c0 5.523-4.477 10-10 10S-10 15.523-10 10 -5.523 0 0 0z'/%3E%3C/g%3E%3C/svg%3E\");
                    background-size: 40px 40px">
            </div>
        </div>

        <div class="px-6 pb-6">
            {{-- Avatar Row --}}
            <div class="flex items-end gap-4 mb-5" style="margin-top: -50px">

                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-lg"
                        style="border: 4px solid white">
                        <img id="avatarPreview"
                            src="{{ $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=C0392B&color=fff&size=200&bold=true' }}"
                            class="w-full h-full object-cover"
                            alt="Avatar">
                    </div>
                    <label for="avatarInput"
                        class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-xl flex items-center
                            justify-center cursor-pointer transition-all hover:scale-110 shadow-md"
                        style="background: linear-gradient(135deg, var(--red-600), var(--red-500))">
                        <i class="ph ph-camera text-sm text-white"></i>
                    </label>
                </div>

                {{-- Info — muncul di bawah banner (background putih) --}}
                <div class="min-w-0" style="padding-bottom: 4px">
                    <h2 class="text-lg font-bold text-gray-800 truncate">
                        {{ $user->name }}
                    </h2>
                    <p class="text-xs text-gray-400 flex items-center gap-1.5 mt-0.5">
                        <i class="ph ph-envelope text-xs" style="color: var(--red-600)"></i>
                        <span class="truncate">{{ $user->email }}</span>
                    </p>
                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-0.5 rounded-full"
                            style="background: #F0FDF4; color: var(--green-700)">
                            <i class="ph ph-shield-check text-xs"></i>
                            Akun Aktif
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="ph ph-calendar-blank text-xs"></i>
                            Bergabung {{ $user->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-3 gap-3">
                @foreach([
                    ['ph-heart-fill', $user->favorites()->count(),        'Favorit',   'var(--red-50)',  'var(--red-600)'],
                    ['ph-star-fill',  $user->favorites()->count(),        'Aktivitas', '#FFFBEB',        'var(--gold-400)'],
                    ['ph-clock',      $user->created_at->diffForHumans(), 'Bergabung', '#EFF6FF',        '#3B82F6'],
                ] as [$icon, $val, $label, $bg, $color])
                <div class="rounded-xl p-3 text-center" style="background: {{ $bg }}">
                    <i class="ph {{ $icon }} text-base mb-1 block" style="color: {{ $color }}"></i>
                    <p class="font-bold text-gray-800 text-sm leading-tight">{{ $val }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- CARD 2: EDIT PROFIL                        --}}
        {{-- ============================================ --}}
        <div class="card p-6" id="editCard">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                    style="background: var(--red-50)">
                    <i class="ph ph-pencil-simple text-lg" style="color: var(--red-600)"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Edit Informasi</h3>
                    <p class="text-xs text-gray-400">Perbarui nama, email, dan nomor HP</p>
                </div>
            </div>

            <form action="{{ route('user.profile.update') }}" method="POST"
                enctype="multipart/form-data" class="space-y-4" id="profileForm">
                @csrf
                @method('PATCH')

                {{-- Hidden avatar input --}}
                <input type="file" id="avatarInput" name="avatar" accept="image/*"
                    class="hidden" onchange="previewAvatar(event)">

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label">
                        Nama Lengkap <span style="color: var(--red-600)">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="ph ph-user input-icon"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            placeholder="Masukkan nama lengkap"
                            class="form-input {{ $errors->has('name') ? 'input-error' : '' }}">
                    </div>
                    @error('name')
                        <p class="form-error">
                            <i class="ph ph-warning-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">
                        Email <span style="color: var(--red-600)">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="ph ph-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="Masukkan email"
                            class="form-input {{ $errors->has('email') ? 'input-error' : '' }}">
                    </div>
                    @error('email')
                        <p class="form-error">
                            <i class="ph ph-warning-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- No HP --}}
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <div class="input-wrapper">
                        <i class="ph ph-phone input-icon"></i>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            placeholder="Contoh: 08123456789"
                            class="form-input {{ $errors->has('phone') ? 'input-error' : '' }}">
                    </div>
                    @error('phone')
                        <p class="form-error">
                            <i class="ph ph-warning-circle text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Avatar Upload Area --}}
                <div class="form-group">
                    <label class="form-label">Foto Profil</label>
                    <label for="avatarInput"
                        class="flex items-center gap-4 p-4 rounded-xl border-2 border-dashed
                            cursor-pointer transition-all hover:border-red-300 hover:bg-red-50 group"
                        style="border-color: var(--cream-300)">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-all
                            group-hover:scale-110"
                            style="background: var(--red-50)">
                            <i class="ph ph-upload-simple text-lg" style="color: var(--red-600)"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700 group-hover:text-red-700 transition">
                                Klik untuk upload foto
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                JPG, PNG, WEBP — Maks 1MB
                            </p>
                        </div>
                        <i class="ph ph-camera text-xl text-gray-300 ml-auto group-hover:text-red-400 transition"></i>
                    </label>
                    <p id="avatarFileName" class="text-xs text-gray-400 mt-1.5 hidden flex items-center gap-1">
                        <i class="ph ph-check-circle text-sm" style="color: var(--green-700)"></i>
                        <span></span>
                    </p>
                </div>

                <button type="submit" class="btn-primary w-full justify-center" id="saveProfileBtn">
                    <i class="ph ph-floppy-disk text-base"></i>
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- ============================================ --}}
        {{-- CARD 3: GANTI PASSWORD                     --}}
        {{-- ============================================ --}}
        <div class="card p-6" id="passwordCard">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                        style="background: #FFFBEB">
                        <i class="ph ph-lock text-lg" style="color: var(--gold-600)"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Ganti Password</h3>
                        <p class="text-xs text-gray-400">Perbarui kata sandi akunmu</p>
                    </div>
                </div>

                {{-- Toggle --}}
                <button id="togglePassword"
                    onclick="togglePasswordForm()"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg transition-all"
                    style="background: #FFFBEB; color: var(--gold-600); border: 1.5px solid #FEF9C3">
                    <i class="ph ph-caret-down text-sm" id="toggleIcon"></i>
                    Ubah
                </button>
            </div>

            {{-- Password Form (collapsed by default) --}}
            <div id="passwordForm" style="display:none; overflow:hidden">
                <form action="{{ route('user.profile.update') }}" method="POST"
                    class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="name"  value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    {{-- Password Lama --}}
                    <div class="form-group">
                        <label class="form-label">Password Saat Ini</label>
                        <div class="input-wrapper">
                            <i class="ph ph-lock input-icon"></i>
                            <input type="password" name="current_password"
                                id="currentPassword"
                                placeholder="Masukkan password saat ini"
                                class="form-input pr-10 {{ $errors->has('current_password') ? 'input-error' : '' }}">
                            <button type="button" onclick="toggleEye('currentPassword', 'eyeCurrent')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="ph ph-eye text-base" id="eyeCurrent"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="form-error">
                                <i class="ph ph-warning-circle text-xs"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="input-wrapper">
                            <i class="ph ph-lock-key input-icon"></i>
                            <input type="password" name="password"
                                id="newPassword"
                                placeholder="Minimal 8 karakter"
                                class="form-input pr-10 {{ $errors->has('password') ? 'input-error' : '' }}"
                                oninput="checkPasswordStrength(this.value)">
                            <button type="button" onclick="toggleEye('newPassword', 'eyeNew')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="ph ph-eye text-base" id="eyeNew"></i>
                            </button>
                        </div>
                        {{-- Password Strength --}}
                        <div class="mt-2 space-y-1.5" id="strengthIndicator" style="display:none">
                            <div class="flex gap-1">
                                <div class="strength-bar h-1.5 flex-1 rounded-full bg-gray-100" id="bar1"></div>
                                <div class="strength-bar h-1.5 flex-1 rounded-full bg-gray-100" id="bar2"></div>
                                <div class="strength-bar h-1.5 flex-1 rounded-full bg-gray-100" id="bar3"></div>
                                <div class="strength-bar h-1.5 flex-1 rounded-full bg-gray-100" id="bar4"></div>
                            </div>
                            <p class="text-xs font-medium" id="strengthText"></p>
                        </div>
                        @error('password')
                            <p class="form-error">
                                <i class="ph ph-warning-circle text-xs"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Konfirmasi --}}
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-wrapper">
                            <i class="ph ph-lock-key input-icon"></i>
                            <input type="password" name="password_confirmation"
                                id="confirmPassword"
                                placeholder="Ulangi password baru"
                                class="form-input pr-10">
                            <button type="button" onclick="toggleEye('confirmPassword', 'eyeConfirm')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="ph ph-eye text-base" id="eyeConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl
                            font-semibold text-sm transition-all hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, var(--gold-600), var(--gold-400));
                               color: white; box-shadow: 0 4px 12px rgba(212,168,67,0.3)">
                        <i class="ph ph-lock text-base"></i>
                        Perbarui Password
                    </button>
                </form>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- CARD 4: HAPUS AKUN                         --}}
        {{-- ============================================ --}}
        <div class="card p-6 border-red-100" id="deleteCard"
            style="border-color: rgba(192,57,43,0.15)">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                        style="background: var(--red-50)">
                        <i class="ph ph-trash text-lg" style="color: var(--red-600)"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Hapus Akun</h3>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed max-w-sm">
                            Setelah dihapus, semua data termasuk favorit akan hilang
                            secara permanen dan tidak dapat dipulihkan.
                        </p>
                    </div>
                </div>
                <button onclick="openDeleteModal()"
                    class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm
                        font-semibold transition-all hover:-translate-y-0.5 hover:shadow-md"
                    style="background: var(--red-50); color: var(--red-600);
                           border: 1.5px solid var(--red-100)">
                    <i class="ph ph-warning text-base"></i>
                    Hapus Akun
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ============================================ --}}
{{-- DELETE ACCOUNT MODAL                        --}}
{{-- ============================================ --}}
<div id="deleteModal" style="display:none; position:fixed; inset:0; z-index:999;
    align-items:center; justify-content:center; padding:16px">

    <div id="deleteOverlay" onclick="closeDeleteModal()"
        style="position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(4px)">
    </div>

    <div id="deleteBox"
        style="position:relative; background:white; border-radius:24px; padding:28px;
               width:100%; max-width:400px; box-shadow:0 24px 64px rgba(0,0,0,0.15); z-index:1">

        {{-- Warning Icon --}}
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5"
            style="background: linear-gradient(135deg, var(--red-50), var(--red-100))">
            <i class="ph ph-warning-octagon text-4xl" style="color: var(--red-600)"></i>
        </div>

        <h3 class="text-xl font-bold text-gray-800 text-center mb-1">Hapus Akun?</h3>
        <p class="text-sm text-gray-400 text-center mb-6 leading-relaxed">
            Tindakan ini <strong class="text-gray-600">tidak dapat dibatalkan</strong>.
            Masukkan password untuk konfirmasi.
        </p>

        <form action="{{ route('user.profile.destroy') }}" method="POST" class="space-y-4">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label class="form-label">Password Akun</label>
                <div class="input-wrapper">
                    <i class="ph ph-lock input-icon"></i>
                    <input type="password" name="password"
                        placeholder="Masukkan password kamu"
                        class="form-input {{ $errors->has('password') ? 'input-error' : '' }}">
                </div>
                @error('password')
                    <p class="form-error">
                        <i class="ph ph-warning-circle text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="btn-ghost flex-1 justify-center">
                    <i class="ph ph-x text-base"></i>
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl
                        font-semibold text-sm transition-all hover:-translate-y-0.5"
                    style="background: linear-gradient(135deg, var(--red-700), var(--red-600));
                           color: white; box-shadow: 0 4px 12px rgba(192,57,43,0.3)">
                    <i class="ph ph-trash text-base"></i>
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<style>
    /* Form Styles */
    .form-group { display: flex; flex-direction: column; gap: 6px; }

    .form-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #374151;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        font-size: 1rem;
        color: #9CA3AF;
        pointer-events: none;
        z-index: 1;
    }

    .form-input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 12px;
        border: 1.5px solid var(--cream-300);
        background: var(--cream);
        font-size: 0.875rem;
        color: #1F2937;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-input:focus {
        border-color: var(--red-600);
        background: white;
        box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.1);
    }

    .form-input.input-error {
        border-color: var(--red-500);
        background: var(--red-50);
    }

    .form-error {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        color: var(--red-600);
        font-weight: 500;
    }

    /* Strength bars */
    .strength-bar {
        transition: background 0.3s ease;
    }
</style>

<script>
// =============================================
// AVATAR PREVIEW
// =============================================
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
        const preview = document.getElementById('avatarPreview');

        gsap.to(preview, {
            scale: 0.85, opacity: 0,
            duration: 0.2, ease: 'power2.in',
            onComplete: () => {
                preview.src = e.target.result;
                gsap.to(preview, {
                    scale: 1, opacity: 1,
                    duration: 0.4, ease: 'back.out(1.6)'
                });
            }
        });
    };
    reader.readAsDataURL(file);

    // Show filename
    const nameEl = document.getElementById('avatarFileName');
    nameEl.classList.remove('hidden');
    nameEl.querySelector('span').textContent = file.name;
}

// =============================================
// TOGGLE PASSWORD FORM
// =============================================
let passwordOpen = false;

function togglePasswordForm() {
    const form = document.getElementById('passwordForm');
    const icon = document.getElementById('toggleIcon');
    passwordOpen = !passwordOpen;

    if (passwordOpen) {
        form.style.display = 'block';
        gsap.from(form, {
            opacity: 0, height: 0, y: -10,
            duration: 0.4, ease: 'power3.out'
        });
        gsap.to(icon, { rotation: 180, duration: 0.3, ease: 'power2.out' });
    } else {
        gsap.to(form, {
            opacity: 0, height: 0,
            duration: 0.3, ease: 'power2.in',
            onComplete: () => { form.style.display = 'none'; }
        });
        gsap.to(icon, { rotation: 0, duration: 0.3, ease: 'power2.out' });
    }
}

// Auto open jika ada error password
@if($errors->has('current_password') || $errors->has('password'))
    document.addEventListener('DOMContentLoaded', () => {
        togglePasswordForm();
    });
@endif

// =============================================
// TOGGLE EYE (SHOW/HIDE PASSWORD)
// =============================================
function toggleEye(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    icon.className = isPass ? 'ph ph-eye-slash text-base' : 'ph ph-eye text-base';
}

// =============================================
// PASSWORD STRENGTH CHECKER
// =============================================
function checkPasswordStrength(val) {
    const indicator = document.getElementById('strengthIndicator');
    const text      = document.getElementById('strengthText');
    const bars      = ['bar1','bar2','bar3','bar4'];

    if (!val) {
        indicator.style.display = 'none';
        return;
    }
    indicator.style.display = 'block';

    let score = 0;
    if (val.length >= 8)             score++;
    if (/[A-Z]/.test(val))           score++;
    if (/[0-9]/.test(val))           score++;
    if (/[^A-Za-z0-9]/.test(val))   score++;

    const colors = ['#EF4444','#F97316','#EAB308','#22C55E'];
    const labels = ['Sangat Lemah','Lemah','Sedang','Kuat'];
    const textColors = ['#DC2626','#EA580C','#CA8A04','#16A34A'];

    bars.forEach((id, i) => {
        const bar = document.getElementById(id);
        bar.style.background = i < score ? colors[score - 1] : '#E5E7EB';
        gsap.from(bar, { scaleX: 0, duration: 0.3, ease: 'power2.out', transformOrigin: 'left' });
    });

    text.textContent = labels[score - 1] || '';
    text.style.color = textColors[score - 1] || '';
}

// =============================================
// DELETE MODAL
// =============================================
function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';

    gsap.set('#deleteBox',     { opacity: 0, scale: 0.85, y: 20 });
    gsap.set('#deleteOverlay', { opacity: 0 });

    gsap.to('#deleteOverlay', { opacity: 1, duration: 0.3, ease: 'power2.out' });
    gsap.to('#deleteBox', {
        opacity: 1, scale: 1, y: 0,
        duration: 0.4, ease: 'back.out(1.6)'
    });
}

function closeDeleteModal() {
    gsap.to('#deleteBox', {
        opacity: 0, scale: 0.9, y: 10,
        duration: 0.25, ease: 'power2.in'
    });
    gsap.to('#deleteOverlay', {
        opacity: 0, duration: 0.25, ease: 'power2.in',
        onComplete: () => {
            document.getElementById('deleteModal').style.display = 'none';
        }
    });
}

// Auto open delete modal jika ada error dari hapus akun
@if($errors->has('password') && !$errors->has('current_password'))
    document.addEventListener('DOMContentLoaded', () => openDeleteModal());
@endif

// =============================================
// PAGE ANIMATE IN
// =============================================
window.addEventListener('load', () => {
    gsap.registerPlugin(ScrollTrigger);

    const cards = ['#pageHeader', '#avatarCard', '#editCard', '#passwordCard', '#deleteCard'];
    gsap.set(cards, { opacity: 0, y: 30 });

    gsap.to(cards, {
        opacity: 1, y: 0,
        duration: 0.6,
        ease: 'power3.out',
        stagger: 0.1,
        delay: 0.1
    });

    // =============================================
    // INPUT FOCUS ANIMATION
    // =============================================
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', () => {
            gsap.to(input.closest('.input-wrapper').querySelector('.input-icon'), {
                color: 'var(--red-600)',
                scale: 1.1,
                duration: 0.2,
                ease: 'power2.out'
            });
        });
        input.addEventListener('blur', () => {
            gsap.to(input.closest('.input-wrapper').querySelector('.input-icon'), {
                color: '#9CA3AF',
                scale: 1,
                duration: 0.2,
                ease: 'power2.out'
            });
        });
    });

    // =============================================
    // SAVE BUTTON LOADING STATE
    // =============================================
    document.getElementById('profileForm')?.addEventListener('submit', () => {
        const btn = document.getElementById('saveProfileBtn');
        btn.innerHTML = '<i class="ph ph-circle-notch text-base animate-spin"></i> Menyimpan...';
        btn.style.opacity = '0.8';
        btn.disabled = true;
    });
});
</script>
@endpush