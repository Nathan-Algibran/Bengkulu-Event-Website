<div class="card p-16 text-center">
    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
        style="background: var(--red-50)">
        <i class="ph {{ $icon }} text-2xl" style="color: var(--red-600)"></i>
    </div>
    <h3 class="text-base font-bold text-gray-700 mb-2">{{ $title }}</h3>
    <p class="text-sm text-gray-400 mb-6 max-w-xs mx-auto leading-relaxed">
        {{ $message }}
    </p>
    <a href="{{ $btnRoute }}" class="btn-primary mx-auto">
        <i class="ph ph-arrow-right text-base"></i>
        {{ $btnText }}
    </a>
</div>