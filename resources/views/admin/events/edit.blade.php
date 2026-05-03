@extends('layouts.admin')
@section('title', 'Edit Event')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.events.index') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 transition mb-4">
        <i class="ph ph-arrow-left text-base"></i>
        Kembali ke Daftar Event
    </a>
    <h2 class="text-xl font-bold text-gray-800">Edit Event</h2>
    <p class="text-sm text-gray-400 mt-0.5">Perbarui informasi event</p>
</div>

<form action="{{ route('admin.events.update', $event) }}" method="POST"
    enctype="multipart/form-data" id="eventForm">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-5">

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
                        <input type="text" name="title" value="{{ old('title', $event->title) }}"
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
                        <select name="category_id" class="admin-input admin-select">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
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
                            class="admin-input {{ $errors->has('description') ? 'border-red-400 bg-red-50' : '' }}">{{ old('description', $event->description) }}</textarea>
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
                            <input type="text" name="location" value="{{ old('location', $event->location) }}"
                                class="admin-input pl-9 {{ $errors->has('location') ? 'border-red-400' : '' }}">
                        </div>
                        @error('location')
                        <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                            <i class="ph ph-warning-circle text-xs"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

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
                        <input type="datetime-local" name="start_date"
                            value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}"
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
                        <input type="datetime-local" name="end_date"
                            value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}"
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
                            <input type="number" name="price" value="{{ old('price', $event->price) }}" min="0"
                                class="admin-input pl-9 {{ $errors->has('price') ? 'border-red-400' : '' }}">
                        </div>
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
                            <input type="number" name="quota" value="{{ old('quota', $event->quota) }}" min="1"
                                placeholder="Kosongkan jika tidak terbatas"
                                class="admin-input pl-9">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="space-y-5">

            {{-- Gambar --}}
            <div class="admin-card p-6">
                <h3 class="font-bold text-gray-700 text-sm flex items-center gap-2 mb-5">
                    <i class="ph ph-image text-base" style="color: var(--red-600)"></i>
                    Gambar Event
                </h3>

                {{-- Current Image --}}
                @if($event->image)
                <div class="mb-3 relative">
                    <img id="imagePreview" src="{{ asset('storage/' . $event->image) }}"
                        class="w-full rounded-xl object-cover" style="height: 160px" alt="Gambar saat ini">
                    <div class="absolute top-2 right-2">
                        <span class="text-xs px-2 py-1 rounded-full font-semibold"
                            style="background: rgba(0,0,0,0.5); color: white">
                            Gambar saat ini
                        </span>
                    </div>
                </div>
                @else
                <img id="imagePreview" src="" class="w-full rounded-xl object-cover mb-3 hidden"
                    style="height: 160px" alt="Preview">
                @endif

                <div class="border-2 border-dashed rounded-xl p-4 text-center cursor-pointer transition-all hover:border-red-400 hover:bg-red-50"
                    style="border-color: #E2E8F0"
                    onclick="document.getElementById('imageInput').click()">
                    <i class="ph ph-upload-simple text-xl text-gray-400 mb-1 block"></i>
                    <p class="text-xs font-semibold text-gray-500">Klik untuk ganti gambar</p>
                    <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengganti</p>
                </div>

                <input type="file" id="imageInput" name="image" accept="image/*"
                    class="hidden" onchange="previewImage(event)">

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
                        ['is_active',      '1', old('is_active', $event->is_active),           'Aktifkan Event',        'Event terlihat oleh pengguna',         'ph-eye',  '#F0FDF4', '#1A5C38'],
                        ['is_recommended', '1', old('is_recommended', $event->is_recommended),  'Tandai Rekomendasi',    'Tampil di halaman rekomendasi',        'ph-star', '#FFFBEB', '#8B6914'],
                        ['is_popular',     '1', old('is_popular', $event->is_popular),          'Tandai Populer',        'Tampil di bagian event populer',       'ph-fire', '#FFF7ED', '#EA580C'],
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
                        <div>
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
                    Perbarui Event
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
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview = document.getElementById('imagePreview');
        gsap.to(preview, {
            opacity: 0, scale: 0.95, duration: 0.2, ease: 'power2.in',
            onComplete: () => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                gsap.to(preview, { opacity: 1, scale: 1, duration: 0.3, ease: 'back.out(1.4)' });
            }
        });
    };
    reader.readAsDataURL(file);
}

document.getElementById('eventForm')?.addEventListener('submit', () => {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="ph ph-circle-notch text-base animate-spin"></i> Menyimpan...';
    btn.disabled = true;
    btn.style.opacity = '0.8';
});
</script>
@endpush