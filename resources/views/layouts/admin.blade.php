<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') | Event Bengkulu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-blue-800 text-white flex flex-col flex-shrink-0">
        <div class="px-6 py-5 text-xl font-bold border-b border-blue-700">
            🎉 Event Bengkulu
            <p class="text-xs font-normal text-blue-300 mt-1">Admin Panel</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm hover:bg-blue-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                📊 Dashboard
            </a>
            <p class="text-xs text-blue-400 uppercase px-4 pt-4 pb-1">Manajemen</p>
            <a href="{{ route('admin.events.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm hover:bg-blue-700 {{ request()->routeIs('admin.events.*') ? 'bg-blue-700' : '' }}">
                🎟️ Event
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm hover:bg-blue-700 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-700' : '' }}">
                🗂️ Kategori
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm hover:bg-blue-700 {{ request()->routeIs('admin.users.*') ? 'bg-blue-700' : '' }}">
                👥 Pengguna
            </a>
            <a href="{{ route('admin.recommendations.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm hover:bg-blue-700 {{ request()->routeIs('admin.recommendations.*') ? 'bg-blue-700' : '' }}">
                ⭐ Rekomendasi
            </a>
        </nav>
        <div class="px-4 py-4 border-t border-blue-700">
            <p class="text-sm text-blue-200 mb-2">{{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left text-sm text-red-300 hover:text-red-100 px-2 py-1 rounded hover:bg-blue-700">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Topbar --}}
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <span class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</span>
        </header>

        {{-- Flash Message --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-6 py-4">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>