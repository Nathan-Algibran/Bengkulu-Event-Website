@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">👤 Profil Saya</h2>

    <div class="space-y-6">

        {{-- CARD: Info Profil --}}
        <div class="bg-white rounded-xl shadow p-6">

            {{-- Avatar Section --}}
            <div class="flex items-center gap-5 mb-6 pb-6 border-b">
                <div class="relative">
                    <img id="avatarPreview"
                        src="{{ $user->avatar
                            ? asset('storage/' . $user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=80&background=3b82f6&color=fff' }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-blue-100"
                        alt="Avatar">
                    <label for="avatarInput"
                        class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer hover:bg-blue-700 text-xs">
                        ✏️
                    </label>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Bergabung sejak {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Form Update Profil --}}
            <form action="{{ route('user.profile.update') }}" method="POST"
                enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                {{-- Avatar (hidden input) --}}
                <input type="file" id="avatarInput" name="avatar" accept="image/*"
                    class="hidden" onchange="previewAvatar(event)">
                @error('avatar')
                    <p class="text-red-500 text-xs -mt-3">{{ $message }}</p>
                @enderror

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor HP
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="Contoh: 08123456789"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('phone') border-red-400 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    💾 Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- CARD: Ganti Password --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-1">🔑 Ganti Password</h3>
            <p class="text-xs text-gray-400 mb-5">
                Kosongkan jika tidak ingin mengganti password.
            </p>

            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                {{-- Field tersembunyi agar validasi profil tidak terganggu --}}
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password Saat Ini
                    </label>
                    <input type="password" name="current_password"
                        placeholder="Masukkan password saat ini"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('current_password') border-red-400 @enderror">
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password Baru
                    </label>
                    <input type="password" name="password"
                        placeholder="Minimal 8 karakter"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-400 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" name="password_confirmation"
                        placeholder="Ulangi password baru"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit"
                    class="w-full bg-gray-700 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                    🔒 Perbarui Password
                </button>
            </form>
        </div>

        {{-- CARD: Hapus Akun --}}
        <div class="bg-white rounded-xl shadow p-6 border border-red-100">
            <h3 class="text-base font-semibold text-red-600 mb-1">🗑️ Hapus Akun</h3>
            <p class="text-xs text-gray-500 mb-5">
                Setelah akun dihapus, semua data termasuk favorit akan hilang permanen
                dan tidak dapat dipulihkan.
            </p>

            {{-- Tombol buka modal --}}
            <button onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                class="w-full bg-red-50 text-red-600 border border-red-200 py-2.5 rounded-lg text-sm font-medium hover:bg-red-100 transition">
                ⚠️ Hapus Akun Saya
            </button>
        </div>

    </div>
</div>

{{-- Modal Konfirmasi Hapus Akun --}}
<div id="deleteModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
        <h3 class="text-lg font-bold text-red-600 mb-2">⚠️ Konfirmasi Hapus Akun</h3>
        <p class="text-sm text-gray-500 mb-5">
            Tindakan ini <strong>tidak dapat dibatalkan</strong>.
            Masukkan password Anda untuk konfirmasi penghapusan akun.
        </p>

        <form action="{{ route('user.profile.destroy') }}" method="POST" class="space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password"
                    placeholder="Masukkan password Anda"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-red-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition">
                    Ya, Hapus Akun
                </button>
                <button type="button"
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Preview Avatar --}}
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('avatarPreview').src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// Otomatis buka modal jika ada error password hapus akun
@if($errors->has('password'))
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('deleteModal').classList.remove('hidden');
    });
@endif
</script>
@endsection