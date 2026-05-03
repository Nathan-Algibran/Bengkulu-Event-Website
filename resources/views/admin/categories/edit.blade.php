@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ route('admin.categories.index') }}"
                class="text-gray-400 hover:text-gray-600 transition">
                <i class="ph ph-arrow-left text-base"></i>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Edit Kategori</h2>
        </div>
        <p class="text-sm text-gray-400 ml-6">Perbarui informasi kategori</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn-admin-secondary">
        <i class="ph ph-list text-base"></i>
        Semua Kategori
    </a>
</div>

<div class="max-w-2xl">
    <div class="admin-card p-6">

        {{-- Card Header --}}
        <div class="flex items-center justify-between mb-6 pb-5 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: var(--red-50)">
                    <i class="ph ph-tag text-lg" style="color: var(--red-600)"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Edit informasi kategori</p>
                </div>
            </div>
            <span class="badge badge-blue">
                <i class="ph ph-ticket text-xs"></i>
                {{ $category->events_count ?? $category->events()->count() }} Event
            </span>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- Nama Kategori --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                    Nama Kategori <span style="color: var(--red-500)">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                    placeholder="Nama kategori..."
                    class="admin-input @error('name') border-red-400 @enderror"
                    id="nameInput">
                @error('name')
                    <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--red-500)">
                        <i class="ph ph-warning-circle text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 mb-1.5 block uppercase tracking-wider">
                    Slug Saat Ini
                </label>
                <div class="admin-input flex items-center gap-2"
                    style="background: #F8FAFC; border-color: #E2E8F0; cursor: not-allowed">
                    <i class="ph ph-link text-gray-400 text-sm flex-shrink-0"></i>
                    <code id="slugPreview" class="text-xs text-gray-400 font-mono">
                        {{ $category->slug }}
                    </code>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">
                    Slug akan otomatis diperbarui saat nama diubah.
                </p>
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
                    style="height: auto">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--red-500)">
                        <i class="ph ph-warning-circle text-xs"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-400 mt-1.5">Maksimal 500 karakter.</p>
            </div>

            {{-- Info Event Terkait --}}
            @if(($category->events_count ?? $category->events()->count()) > 0)
            <div class="rounded-xl p-4 flex items-start gap-3"
                style="background: #FFFBEB; border: 1px solid #FDE68A">
                <i class="ph ph-info text-lg mt-0.5 flex-shrink-0" style="color: #D97706"></i>
                <div>
                    <p class="text-sm font-semibold" style="color: #92400E">Perhatian</p>
                    <p class="text-xs mt-0.5" style="color: #A16207">
                        Kategori ini memiliki
                        <strong>{{ $category->events_count ?? $category->events()->count() }} event</strong>
                        terkait. Perubahan nama akan memperbarui slug dan dapat mempengaruhi URL event.
                    </p>
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-admin-primary flex-1 justify-center" id="submitBtn">
                    <i class="ph ph-floppy-disk text-base"></i>
                    Perbarui Kategori
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
// Live slug preview dari nama yang diketik
const nameInput = document.getElementById('nameInput');
const slugPreview = document.getElementById('slugPreview');

if (nameInput && slugPreview) {
    nameInput.addEventListener('input', function () {
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugPreview.textContent = slug || '...';
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