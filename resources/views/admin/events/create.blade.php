@extends('layouts.admin')
@section('title', 'Tambah Event')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.events.index') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition mb-4">
        <i class="ph ph-arrow-left text-base"></i>
        Kembali ke Daftar Event
    </a>
    <h2 class="text-xl font-bold text-gray-800">Tambah Event Baru</h2>
    <p class="text-sm text-gray-400 mt-0.5">Isi semua informasi event dengan lengkap</p>
</div>

<form action="{{ route('admin.events.store') }}" method="POST"
    enctype="multipart/form-data" id="eventForm">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- LEFT: Main Info --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Info Dasar --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-5">
                    <i class="ph ph-info text-base" style="color: var(--red-600)"></i>
                    Informasi Dasar
                </h3>
                <div class="space-y-4">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Judul Event <span style="color: var(--red-600)">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Masukkan judul event yang menarik..."
                            class="admin-input {{ $errors->has('title') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('title')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Kategori <span style="color: var(--red-600)">*</span>
                        </label>
                        <select name="category_id"
                            class="admin-input admin-select {{ $errors->has('category_id') ? 'border-red-400' : '' }}">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Deskripsi <span style="color: var(--red-600)">*</span>
                        </label>
                        <textarea name="description" rows="6"
                            placeholder="Jelaskan detail event ini..."
                            class="admin-input {{ $errors->has('description') ? 'border-red-400 bg-red-50' : '' }}">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Lokasi <span style="color: var(--red-600)">*</span>
                        </label>
                        <div class="relative">
                            <i class="ph ph-map-pin absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="location" value="{{ old('location') }}"
                                placeholder="Contoh: Pantai Panjang, Bengkulu"
                                class="admin-input pl-9 {{ $errors->has('location') ? 'border-red-400 bg-red-50' : '' }}">
                        </div>
                        @error('location')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Tanggal & Harga --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-5">
                    <i class="ph ph-calendar text-base" style="color: var(--red-600)"></i>
                    Tanggal & Harga
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Tanggal Mulai <span style="color: var(--red-600)">*</span>
                        </label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                            class="admin-input {{ $errors->has('start_date') ? 'border-red-400' : '' }}">
                        @error('start_date')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Tanggal Selesai <span style="color: var(--red-600)">*</span>
                        </label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                            class="admin-input {{ $errors->has('end_date') ? 'border-red-400' : '' }}">
                        @error('end_date')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Harga (Rp) <span style="color: var(--red-600)">*</span>
                        </label>
                        <div class="relative">
                            <i class="ph ph-currency-dollar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="price" value="{{ old('price', 0) }}" min="0"
                                class="admin-input pl-9 {{ $errors->has('price') ? 'border-red-400' : '' }}">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Isi 0 jika gratis</p>
                        @error('price')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Kuota Peserta
                        </label>
                        <div class="relative">
                            <i class="ph ph-users absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="quota" value="{{ old('quota') }}" min="1"
                                placeholder="Kosongkan jika tidak terbatas"
                                class="admin-input pl-9 {{ $errors->has('quota') ? 'border-red-400' : '' }}">
                        </div>
                        @error('quota')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Image & Settings --}}
        <div class="space-y-5">

            {{-- Gambar --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-5">
                    <i class="ph ph-image text-base" style="color: var(--red-600)"></i>
                    Gambar Event
                </h3>

                <div id="imageDropzone"
                    class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-all hover:border-red-400 hover:bg-red-50"
                    style="border-color: #E2E8F0"
                    onclick="document.getElementById('imageInput').click()"
                    ondragover="handleDragOver(event)"
                    ondrop="handleDrop(event)">

                    <div id="dropzoneContent">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3"
                            style="background: var(--red-50)">
                            <i class="ph ph-upload-simple text-2xl" style="color: var(--red-600)"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">
                            Klik atau drag & drop gambar
                        </p>
                        <p class="text-xs text-gray-400">JPG, PNG, WEBP — Maks 2MB</p>
                    </div>

                    <img id="imagePreview" src="" alt="Preview"
                        class="w-full rounded-lg object-cover hidden mt-3" style="max-height: 200px">
                </div>

                <input type="file" id="imageInput" name="image" accept="image/*"
                    class="hidden" onchange="previewImage(event)">

                <p id="imageFileName" class="text-xs text-gray-400 mt-2 hidden flex items-center gap-1">
                    <i class="ph ph-check-circle text-sm" style="color: var(--green-700)"></i>
                    <span></span>
                </p>

                @error('image')
                <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                    <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Settings --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-5">
                    <i class="ph ph-gear text-base" style="color: var(--red-600)"></i>
                    Pengaturan
                </h3>
                <div class="space-y-3">
                    @foreach([
                        ['is_active',      '1', old('is_active', true),      'Aktifkan Event',        'Event akan terlihat oleh pengguna',    'ph-eye',       '#F0FDF4', '#1A5C38'],
                        ['is_recommended', '1', old('is_recommended', false), 'Tandai Rekomendasi',    'Tampil di halaman rekomendasi',        'ph-star',      '#FFFBEB', '#8B6914'],
                        ['is_popular',     '1', old('is_popular', false),     'Tandai Populer',        'Tampil di bagian event populer',       'ph-fire',      '#FFF7ED', '#EA580C'],
                    ] as [$name, $val, $checked, $label, $desc, $icon, $bg, $color])
                    <label class="flex items-start gap-3 p-3 rounded-xl cursor-pointer transition-all hover:shadow-sm"
                        style="background: {{ $bg }}">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="hidden" name="{{ $name }}" value="0">
                            <input type="checkbox" name="{{ $name }}" value="{{ $val }}"
                                {{ $checked ? 'checked' : '' }}
                                class="w-4 h-4 rounded cursor-pointer"
                                style="accent-color: var(--red-600)">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <i class="ph {{ $icon }} text-sm" style="color: {{ $color }}"></i>
                                <p class="text-sm font-semibold text-gray-700">{{ $label }}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $desc }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit" class="btn-admin-primary flex-1 justify-center" id="submitBtn">
                    <i class="ph ph-floppy-disk text-base"></i>
                    Simpan Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn-admin-secondary">
                    <i class="ph ph-x text-base"></i>
                </a>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    showPreview(file);
}

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview  = document.getElementById('imagePreview');
        const content  = document.getElementById('dropzoneContent');
        const fileName = document.getElementById('imageFileName');

        content.classList.add('hidden');
        preview.src = e.target.result;
        preview.classList.remove('hidden');

        gsap.from(preview, { opacity: 0, scale: 0.95, duration: 0.3, ease: 'back.out(1.4)' });

        fileName.classList.remove('hidden');
        fileName.querySelector('span').textContent = file.name;

        document.getElementById('imageDropzone').style.borderColor = 'var(--green-700)';
        document.getElementById('imageDropzone').style.background = '#F0FDF4';
    };
    reader.readAsDataURL(file);
}

function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('imageDropzone').style.borderColor = 'var(--red-600)';
    document.getElementById('imageDropzone').style.background = '#FFF1F0';
}

function handleDrop(e) {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('imageInput').files = dt.files;
        showPreview(file);
    }
}

document.getElementById('eventForm')?.addEventListener('submit', () => {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="ph ph-circle-notch text-base animate-spin"></i> Menyimpan...';
    btn.disabled = true;
    btn.style.opacity = '0.8';
});
</script>
@endpush