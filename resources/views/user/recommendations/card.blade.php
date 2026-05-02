<div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden group">

    {{-- Gambar --}}
    <div class="relative overflow-hidden">
        <a href="{{ route('user.events.show', $event->slug) }}">
            <img src="{{ $event->image
                    ? asset('storage/' . $event->image)
                    : 'https://placehold.co/400x220?text=No+Image' }}"
                class="w-full h-40 object-cover group-hover:scale-105 transition duration-300"
                alt="{{ $event->title }}">
        </a>

        {{-- Badge --}}
        <div class="absolute top-2 left-2 flex gap-1 flex-wrap">
            @if($event->is_recommended)
                <span class="bg-yellow-400 text-yellow-900 text-xs px-2 py-0.5 rounded-full font-medium">
                    ⭐ Rekomendasi
                </span>
            @endif
            @if($event->is_popular)
                <span class="bg-orange-400 text-white text-xs px-2 py-0.5 rounded-full font-medium">
                    🔥 Populer
                </span>
            @endif
        </div>

        {{-- Tombol Favorit --}}
        <form action="{{ in_array($event->id, $favoriteIds)
                ? route('user.favorites.destroy', $event)
                : route('user.favorites.store', $event) }}"
            method="POST"
            class="absolute top-2 right-2">
            @csrf
            @if(in_array($event->id, $favoriteIds)) @method('DELETE') @endif
            <button type="submit"
                class="bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full w-8 h-8 flex items-center justify-center shadow text-sm transition hover:scale-110"
                title="{{ in_array($event->id, $favoriteIds) ? 'Hapus dari favorit' : 'Simpan ke favorit' }}">
                {{ in_array($event->id, $favoriteIds) ? '❤️' : '🤍' }}
            </button>
        </form>

        {{-- Harga --}}
        <div class="absolute bottom-2 left-2">
            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                {{ $event->price == 0
                    ? 'Gratis'
                    : 'Rp ' . number_format($event->price, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-4">
        <span class="text-xs text-blue-500 font-medium">
            {{ $event->category->name }}
        </span>
        <a href="{{ route('user.events.show', $event->slug) }}">
            <h4 class="font-semibold text-gray-800 mt-1 mb-2 line-clamp-2 text-sm hover:text-blue-600 transition">
                {{ $event->title }}
            </h4>
        </a>
        <div class="space-y-1 text-xs text-gray-500">
            <p>📍 {{ $event->location }}</p>
            <p>📅 {{ $event->start_date->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex items-center justify-between mt-3 pt-3 border-t">
            <span class="text-xs text-gray-400">
                👁️ {{ number_format($event->view_count) }} views
            </span>
            <a href="{{ route('user.events.show', $event->slug) }}"
                class="text-xs text-blue-600 font-medium hover:underline">
                Lihat →
            </a>
        </div>
    </div>
</div>