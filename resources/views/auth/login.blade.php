<x-guest-layout>
@section('title', 'Masuk')

{{-- Session Status --}}
@if (session('status'))
    <div class="alert-success">
        <i class="ph ph-check-circle text-base"></i>
        {{ session('status') }}
    </div>
@endif

{{-- Header --}}
<div class="mb-7">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-3"
        style="background: var(--red-50); border: 1px solid rgba(192,57,43,0.15); color: var(--red-600)">
        <i class="ph ph-sign-in text-sm"></i>
        Masuk Akun
    </div>
    <h2 class="text-2xl font-bold text-gray-800 leading-tight">Selamat Datang</h2>
    <p class="text-sm text-gray-400 mt-1">Masuk untuk menjelajahi event di Bengkulu</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email --}}
    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrapper">
            <i class="ph ph-envelope input-icon"></i>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-input @error('email') border-red-500 @enderror"
                placeholder="nama@email.com"
                required
                autofocus
                autocomplete="username"
            >
        </div>
        @error('email')
            <p class="form-error">
                <i class="ph ph-warning-circle text-xs"></i>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Password --}}
    <div class="form-group">
        <div class="flex items-center justify-between mb-1.5">
            <label class="form-label" style="margin-bottom:0" for="password">Password</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-xs font-semibold transition-colors"
                    style="color: var(--red-600)"
                    onmouseover="this.style.color='var(--red-700)'"
                    onmouseout="this.style.color='var(--red-600)'">
                    Lupa password?
                </a>
            @endif
        </div>
        <div class="input-wrapper">
            <i class="ph ph-lock input-icon"></i>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input has-toggle @error('password') border-red-500 @enderror"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            >
            <button type="button" class="input-toggle" id="togglePassword" aria-label="Toggle password">
                <i class="ph ph-eye" id="eyeIcon"></i>
            </button>
        </div>
        @error('password')
            <p class="form-error">
                <i class="ph ph-warning-circle text-xs"></i>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Remember me --}}
    <div class="form-group" style="margin-bottom: 1.5rem">
        <label class="custom-checkbox">
            <input type="checkbox" name="remember" id="remember_me">
            <span>Ingat saya di perangkat ini</span>
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-primary">
        <i class="ph ph-sign-in text-base"></i>
        Masuk Sekarang
    </button>

    {{-- Divider --}}
    <div class="auth-divider">
        <span>Belum punya akun?</span>
    </div>

    {{-- Register link --}}
    <a href="{{ route('register') }}"
        class="w-full flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold transition-all"
        style="background: var(--red-50); color: var(--red-600); border: 1.5px solid rgba(192,57,43,0.18)"
        onmouseover="this.style.background='var(--red-100)'"
        onmouseout="this.style.background='var(--red-50)'">
        <i class="ph ph-user-plus text-base"></i>
        Daftar Akun Baru
    </a>
</form>

<script>
(function() {
    const toggle = document.getElementById('togglePassword');
    const input  = document.getElementById('password');
    const icon   = document.getElementById('eyeIcon');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.className = show ? 'ph ph-eye-slash' : 'ph ph-eye';
    });
})();
</script>
</x-guest-layout>