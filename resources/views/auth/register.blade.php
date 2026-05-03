<x-guest-layout>
@section('title', 'Daftar')

{{-- Header --}}
<div class="mb-7">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold mb-3"
        style="background: var(--red-50); border: 1px solid rgba(192,57,43,0.15); color: var(--red-600)">
        <i class="ph ph-user-plus text-sm"></i>
        Buat Akun Baru
    </div>
    <h2 class="text-2xl font-bold text-gray-800 leading-tight">Bergabung Sekarang</h2>
    <p class="text-sm text-gray-400 mt-1">Daftar gratis dan temukan event seru di Bengkulu</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name --}}
    <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <div class="input-wrapper">
            <i class="ph ph-user input-icon"></i>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-input @error('name') border-red-500 @enderror"
                placeholder="Masukkan nama lengkap"
                required
                autofocus
                autocomplete="name"
            >
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
        <label class="form-label" for="password">Password</label>
        <div class="input-wrapper">
            <i class="ph ph-lock input-icon"></i>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input has-toggle @error('password') border-red-500 @enderror"
                placeholder="Min. 8 karakter"
                required
                autocomplete="new-password"
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

        {{-- Password strength indicator --}}
        <div class="mt-2 flex gap-1.5" id="strengthBar" style="display:none!important">
            <div class="h-1 flex-1 rounded-full bg-gray-200" id="s1"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200" id="s2"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200" id="s3"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200" id="s4"></div>
        </div>
        <p class="text-xs text-gray-400 mt-1.5" id="strengthLabel" style="display:none"></p>
    </div>

    {{-- Confirm Password --}}
    <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrapper">
            <i class="ph ph-lock-key input-icon"></i>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-input has-toggle @error('password_confirmation') border-red-500 @enderror"
                placeholder="Ulangi password"
                required
                autocomplete="new-password"
            >
            <button type="button" class="input-toggle" id="toggleConfirm" aria-label="Toggle confirm password">
                <i class="ph ph-eye" id="eyeIconConfirm"></i>
            </button>
        </div>
        @error('password_confirmation')
            <p class="form-error">
                <i class="ph ph-warning-circle text-xs"></i>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Submit --}}
    <div class="mt-6">
        <button type="submit" class="btn-primary">
            <i class="ph ph-user-plus text-base"></i>
            Buat Akun
        </button>
    </div>

    {{-- Divider --}}
    <div class="auth-divider">
        <span>Sudah punya akun?</span>
    </div>

    {{-- Login link --}}
    <a href="{{ route('login') }}"
        class="w-full flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold transition-all"
        style="background: var(--red-50); color: var(--red-600); border: 1.5px solid rgba(192,57,43,0.18)"
        onmouseover="this.style.background='var(--red-100)'"
        onmouseout="this.style.background='var(--red-50)'">
        <i class="ph ph-sign-in text-base"></i>
        Masuk ke Akun
    </a>
</form>

<script>
(function() {
    // Password toggle — main
    const toggle1 = document.getElementById('togglePassword');
    const input1  = document.getElementById('password');
    const icon1   = document.getElementById('eyeIcon');
    if (toggle1) {
        toggle1.addEventListener('click', () => {
            const show = input1.type === 'password';
            input1.type  = show ? 'text' : 'password';
            icon1.className = show ? 'ph ph-eye-slash' : 'ph ph-eye';
        });
    }

    // Password toggle — confirm
    const toggle2 = document.getElementById('toggleConfirm');
    const input2  = document.getElementById('password_confirmation');
    const icon2   = document.getElementById('eyeIconConfirm');
    if (toggle2) {
        toggle2.addEventListener('click', () => {
            const show = input2.type === 'password';
            input2.type  = show ? 'text' : 'password';
            icon2.className = show ? 'ph ph-eye-slash' : 'ph ph-eye';
        });
    }

    // Password strength
    const strengthBar   = document.getElementById('strengthBar');
    const strengthLabel = document.getElementById('strengthLabel');
    const bars = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    const levels = [
        { color: '#EF4444', label: 'Sangat lemah' },
        { color: '#F97316', label: 'Lemah' },
        { color: '#EAB308', label: 'Cukup' },
        { color: 'var(--green-500)', label: 'Kuat' },
    ];

    function calcStrength(pw) {
        let score = 0;
        if (pw.length >= 8)  score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;
        return score;
    }

    if (input1) {
        input1.addEventListener('input', () => {
            const pw = input1.value;
            if (!pw) {
                strengthBar.style.display   = 'none';
                strengthLabel.style.display = 'none';
                bars.forEach(b => b.style.background = '#E5E7EB');
                return;
            }
            strengthBar.style.display   = 'flex';
            strengthLabel.style.display = 'block';
            const s = Math.max(1, calcStrength(pw));
            bars.forEach((b, i) => {
                b.style.background = i < s ? levels[s - 1].color : '#E5E7EB';
            });
            strengthLabel.textContent = levels[s - 1].label;
            strengthLabel.style.color = levels[s - 1].color;
        });
    }
})();
</script>
</x-guest-layout>