<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name', 'Pilkades') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-700">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Panel kiri (hanya layar besar) --}}
        <div class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-700 p-12 text-white">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 -left-24 w-80 h-80 rounded-full bg-teal-300/20 blur-3xl"></div>

            <a href="{{ route('home') }}" class="relative flex items-center gap-2.5">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/15 ring-1 ring-white/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.6-2.4A9 9 0 1112 3a9 9 0 018.6 4.6z"/>
                    </svg>
                </span>
                <span class="text-lg font-extrabold tracking-tight">{{ config('app.name', 'Pilkades') }}</span>
            </a>

            <div class="relative max-w-md">
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight">
                    Kelola pemilihan desa dengan transparan dan aman.
                </h2>
                <p class="mt-4 text-emerald-50/90 leading-relaxed">
                    Masuk untuk mengelola kandidat, data pemilih, QR hak pilih, dan memantau hasil pemungutan suara.
                </p>
            </div>

            <p class="relative text-sm text-emerald-50/70">&copy; {{ date('Y') }} {{ config('app.name', 'Pilkades') }}</p>
        </div>

        {{-- Panel form --}}
        <div class="flex items-center justify-center px-4 sm:px-8 py-12">
            <div class="w-full max-w-md">

                {{-- Logo (layar kecil) --}}
                <a href="{{ route('home') }}" class="lg:hidden flex items-center justify-center gap-2.5 mb-8">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.6-2.4A9 9 0 1112 3a9 9 0 018.6 4.6z"/>
                        </svg>
                    </span>
                    <span class="text-lg font-extrabold text-slate-900 tracking-tight">{{ config('app.name', 'Pilkades') }}</span>
                </a>

                <div class="bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 p-8">
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat datang</h1>
                    <p class="mt-1 text-sm text-slate-500">Masuk sebagai panitia atau petugas.</p>

                    {{-- Status sesi (mis. setelah reset password) --}}
                    @if (session('status'))
                        <div class="mt-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                       required autofocus autocomplete="username" placeholder="nama@email.com"
                                       class="block w-full rounded-xl border-0 bg-slate-50 py-3 pl-11 pr-4 text-slate-900 ring-1 ring-inset {{ $errors->has('email') ? 'ring-rose-400' : 'ring-slate-200' }} placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition sm:text-sm">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div x-data="{ show: false }">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-sm font-medium text-emerald-600 hover:text-emerald-700 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            <div class="relative mt-1.5">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input id="password" name="password" type="password" x-bind:type="show ? 'text' : 'password'"
                                       required autocomplete="current-password" placeholder="••••••••"
                                       class="block w-full rounded-xl border-0 bg-slate-50 py-3 pl-11 pr-12 text-slate-900 ring-1 ring-inset {{ $errors->has('password') ? 'ring-rose-400' : 'ring-slate-200' }} placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition sm:text-sm">
                                <button type="button" x-on:click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition"
                                        aria-label="Tampilkan atau sembunyikan password">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z"/>
                                    </svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18M10.58 10.58a3 3 0 004.24 4.24M9.88 5.09A9.77 9.77 0 0112 5c4.48 0 8.27 2.94 9.54 7a9.97 9.97 0 01-2.16 3.5M6.6 6.6A9.96 9.96 0 002.46 12c1.27 4.06 5.06 7 9.54 7 1.7 0 3.3-.42 4.7-1.17"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ingat saya --}}
                        <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer">
                            <input id="remember_me" name="remember" type="checkbox"
                                   class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/40">
                            <span class="text-sm text-slate-600">Ingat saya</span>
                        </label>

                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all duration-200">
                            Masuk
                        </button>
                    </form>
                </div>
                <p class="mt-2 text-center text-sm">
                    <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600">&larr; Kembali ke beranda</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>