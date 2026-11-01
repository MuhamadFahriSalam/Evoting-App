@php
    $user = auth()->user();

    if ($user->isSuperAdmin()) {
        $home = route('admin.dashboard');
        $roleLabel = 'Super Admin';
    } elseif ($user->isCommittee()) {
        $home = route('committee.dashboard');
        $roleLabel = 'Panitia';
    } else {
        $home = route('officer.dashboard');
        $roleLabel = 'Petugas';
    }

    $links = [];

    if ($user->isSuperAdmin() || $user->isCommittee()) {
        $links = [
            ['Dashboard',   $home,                        request()->routeIs('admin.dashboard', 'committee.dashboard')],
            ['Kandidat',    route('candidates.index'),    request()->routeIs('candidates.*')],
            ['Pemilih',     route('voters.index'),        request()->routeIs('voters.index', 'voters.create')],
            ['QR Hak Pilih', route('voters.qr'),          request()->routeIs('voters.qr')],
            ['Hasil',       route('results'),             request()->routeIs('results')],
        ];
    } else {
        $links = [
            ['Scan QR', route('vote.scan'), request()->routeIs('vote.scan')],
        ];
    }
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Kiri: logo + menu --}}
            <div class="flex items-center gap-8">
                <a href="{{ $home }}" class="flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.6-2.4A9 9 0 1112 3a9 9 0 018.6 4.6z"/>
                        </svg>
                    </span>
                    <span class="hidden sm:block font-extrabold text-slate-900 tracking-tight">{{ config('app.name', 'Pilkades') }}</span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    @foreach ($links as [$label, $url, $active])
                        <a href="{{ $url }}"
                           class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-colors
                                  {{ $active ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Kanan: akun --}}
            <div class="hidden md:block relative" x-data="{ menu: false }" x-on:click.outside="menu = false" x-on:keydown.escape.window="menu = false">
                <button type="button" x-on:click="menu = !menu"
                        class="flex items-center gap-3 pl-2 pr-3 py-1.5 rounded-2xl hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 transition">
                    <span class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-bold shadow-sm">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </span>
                    <span class="text-left leading-tight">
                        <span class="block text-sm font-semibold text-slate-900">{{ $user->name }}</span>
                        <span class="block text-xs text-slate-500">{{ $roleLabel }}</span>
                    </span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform" x-bind:class="menu && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="menu" x-cloak x-transition.origin.top.right.duration.150ms
                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl ring-1 ring-slate-100 shadow-xl shadow-slate-300/40 p-1.5">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium text-slate-700 rounded-xl hover:bg-slate-50">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium text-rose-600 rounded-xl hover:bg-rose-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tombol menu (mobile) --}}
            <button type="button" x-on:click="open = !open"
                    class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-emerald-500/20"
                    aria-label="Buka menu">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Panel mobile --}}
    <div x-show="open" x-cloak x-transition.opacity class="md:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            @foreach ($links as [$label, $url, $active])
                <a href="{{ $url }}"
                   class="block px-3.5 py-2.5 text-sm font-semibold rounded-xl
                          {{ $active ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="px-4 py-4 border-t border-slate-100">
            <div class="flex items-center gap-3 px-1">
                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-bold">
                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                </span>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $roleLabel }}</p>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3.5 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-100">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3.5 py-2.5 text-sm font-medium text-rose-600 rounded-xl hover:bg-rose-50">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>