@php
    $favoriteIds = $favoriteIds ?? Auth::user()->favoriteEvents()->pluck('events.id')->toArray();
    $isFav = in_array($event->id, $favoriteIds);
@endphp

<div class="card event-card overflow-hidden">

    {{-- Image --}}
    <div class="card-image relative">
        <a href="{{ route('user.events.show', $event->slug) }}">
            <img src="{{ $event->image
                    ? asset('storage/' . $event->image)
                    : 'https://placehold.co/600x400/' . ltrim(str_replace('#','','C0392B'), '') . '/FDF8F0?text=' . urlencode($event->title) }}"
                alt="{{ $event->title }}"
                loading="lazy">
            <div class="card-overlay"></div>
        </a>

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 z-10">
            @if($event->is_recommended)
            <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-semibold"
                style="background: rgba(212,168,67,0.92); color: #3D1500; backdrop-filter: blur(4px)">
                <i class="ph ph-star-fill text-xs"></i> Rekomendasi
            </span>
            @endif
            @if($event->is_popular)
            <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full font-semibold"
                style="background: rgba(234,88,12,0.88); color: white; backdrop-filter: blur(4px)">
                <i class="ph ph-fire text-xs"></i> Populer
            </span>
            @endif
        </div>

        {{-- Fav Button --}}
        <form action="{{ $isFav
                ? route('user.favorites.destroy', $event)
                : route('user.favorites.store', $event) }}"
            method="POST" class="absolute top-3 right-3 z-10">
            @csrf
            @if($isFav) @method('DELETE') @endif
            <button type="submit" class="fav-btn {{ $isFav ? 'active' : '' }}">
                <i class="{{ $isFav ? 'ph-fill ph-heart' : 'ph ph-heart' }} text-lg"
                    style="color: {{ $isFav ? 'var(--red-600)' : '#9CA3AF' }}"></i>
            </button>
        </form>

        {{-- Price --}}
        <div class="absolute bottom-3 left-3 z-10">
            <span class="price-badge">
                <i class="ph ph-ticket text-xs"></i>
                {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-4">
        <span class="category-pill">
            <i class="ph ph-tag text-xs"></i>
            {{ $event->category->name }}
        </span>

        <a href="{{ route('user.events.show', $event->slug) }}">
            <h4 class="font-bold text-gray-800 mt-2 mb-3 text-sm leading-snug line-clamp-2
                transition-colors hover:text-red-700">
                {{ $event->title }}
            </h4>
        </a>

        <div class="space-y-1.5 mb-3">
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <i class="ph ph-map-pin text-sm flex-shrink-0" style="color: var(--red-600)"></i>
                <span class="truncate">{{ $event->location }}</span>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <i class="ph ph-calendar text-sm flex-shrink-0" style="color: var(--gold-600)"></i>
                <span>{{ $event->start_date->format('d M Y, H:i') }}</span>
            </div>
            @if($event->quota)
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <i class="ph ph-users text-sm flex-shrink-0" style="color: var(--green-700)"></i>
                <span>Kuota {{ number_format($event->quota) }} orang</span>
            </div>
            @endif
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-amber-50">
            <div class="flex items-center gap-1 text-xs text-gray-400">
                <i class="ph ph-eye text-sm"></i>
                {{ number_format($event->view_count) }} views
            </div>
            <a href="{{ route('user.events.show', $event->slug) }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg
                transition-all hover:gap-2.5 hover:-translate-y-0.5"
                style="color: var(--red-600); background: var(--red-50)">
                Lihat Detail
                <i class="ph ph-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</div>