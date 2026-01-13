<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Aplikasi Mobil') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- HEADER / NAVBAR --}}
    <nav class="bg-white shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <a href="/" class="font-bold text-xl text-blue-600">
                {{ config('app.name', 'Aplikasi Mobil') }}
            </a>

            <div>
                @if (auth()->check())
                    {{-- User SUDAH Login --}}
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Halo, {{ auth()->user()->name }}</span>

                        {{-- Tombol ke Dashboard Filament --}}
                        <a href="{{ url('/admin') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition" target="_blank">
                            Halaman Admin
                        </a>

                        {{-- Tombol Logout Filament --}}
                        <form method="POST" action="{{ filament()->getLogoutUrl() }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:underline">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    {{-- User BELUM Login --}}
                    <a href="{{ filament()->getLoginUrl() }}"
                        class="text-gray-700 hover:text-blue-600 font-medium text-sm">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>
