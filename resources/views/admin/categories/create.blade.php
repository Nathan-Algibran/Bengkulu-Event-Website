@extends('layouts.admin')
@section('title', 'Tambah Kategori')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('admin.categories.index') }}"
                class="text-gray-400 hover:text-gray-600 transition">
                <i class="ph ph-arrow-left text-base"></i>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Tambah Kategori</h2>
        </div>
        <p class="text-sm text-gray-400 ml-6">Buat kategori event baru</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn-admin-secondary">
        <i class="ph ph-list text-base"></i>
        Semua Kategori
    </a>
</div>

<div class="max-w-2xl">
    <div class="admin-card p-6">

        {{-- Card Header --}}
        <div class="flex items-center gap-3 mb-6 pb-5 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                style="background: var(--red-50)">
                <i class="ph ph-tag text-lg" style="color: var(--red-600)"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Informasi Kategori</h3>
                <p class="text-xs text-gray-400 mt-0.5">Isi detail kategori baru</p>
            </div>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Kategori --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                    Nama Kategori <span style="color: var(--red-500)">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Contoh: Musik, Olahraga, Kuliner..."
                    class="admin-input @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--red-500)">
                        <i class="ph ph-warning-circle text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-400 mt-1.5">
                    Slug akan dibuat otomatis dari nama kategori.
                </p>
            </div>

            {{-- Preview Slug --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                    Preview Slug
                </label>
                <div class="admin-input flex items-center gap-2 cursor-not-allowed"
                    style="background: #F8FAFC; border-color: #E2E8F0;">
                    <i class="ph ph-link text-gray-400 text-sm flex-shrink-0"></i>
                    <code id="slugPreview" class="text-xs text-gray-400 font-mono">
                        {{ old('name') ? \Illuminate\Support\Str::slug(old('name')) : 'nama-kategori' }}
                    </code>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">Otomatis dibuat saat menyimpan.</p>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                    Deskripsi
                    <span class="text-gray-300 font-normal normal-case tracking-normal ml-1">(opsional)</span>
                </label>
                <textarea name="description" rows="4"
                    placeholder="Deskripsi singkat tentang kategori ini..."
                    class="admin-input resize-none @error('description') border-red-400 @enderror"
                    style="height: auto">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--red-500)">
                        <i class="ph ph-warning-circle text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-400 mt-1.5">Maksimal 500 karakter.</p>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-admin-primary flex-1 justify-center" id="submitBtn">
                    <i class="ph ph-floppy-disk text-base"></i>
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-admin-secondary">
                    <i class="ph ph-x text-base"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Live slug preview
const nameInput = document.querySelector('input[name="name"]');
const slugPreview = document.getElementById('slugPreview');

if (nameInput && slugPreview) {
    nameInput.addEventListener('input', function () {
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugPreview.textContent = slug || 'nama-kategori';
    });
}

// Submit loading state
document.querySelector('form').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="ph ph-spinner-gap animate-spin text-base"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endpush