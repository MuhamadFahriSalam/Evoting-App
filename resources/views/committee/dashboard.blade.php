<x-app-layout>
    @php
        $totalVoters      = \Illuminate\Support\Facades\DB::table('voters')->count();
        $totalCredentials = \Illuminate\Support\Facades\DB::table('voter_credentials')->count();
        $usedCredentials  = \Illuminate\Support\Facades\DB::table('voter_credentials')->whereNotNull('used_at')->count();
        $verified         = \Illuminate\Support\Facades\DB::table('candidates')->where('verification_status', 'verified')->count();
        $pending          = \Illuminate\Support\Facades\DB::table('candidates')->where('verification_status', 'pending')->count();
        $participation    = $totalCredentials > 0 ? round($usedCredentials / $totalCredentials * 100) : 0;

        $stats = [
            ['Total Pemilih',       $totalVoters,      'text-slate-900'],
            ['Sudah Memilih',       $usedCredentials,  'text-emerald-600'],
            ['Kandidat Terverifikasi', $verified,      'text-emerald-600'],
            ['Menunggu Verifikasi', $pending,          'text-amber-600'],
        ];

        $menus = [
            ['Kandidat',      'Tambah, verifikasi, dan kelola calon kepala desa.', route('candidates.index'),
                'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
            ['Data Pemilih',  'Kelola daftar pemilih terdaftar.', route('voters.index'),
                'M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z'],
            ['QR Hak Pilih',  'Lihat dan cetak QR Code untuk pemilih.', route('voters.qr'),
                'M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z'],
            ['Hasil Voting',  'Pantau perolehan suara secara langsung.', route('results'),
                'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
        ];
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Banner sapaan --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-teal-700 px-6 sm:px-10 py-8 shadow-xl shadow-emerald-900/15">
                <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute -bottom-20 left-1/3 w-56 h-56 rounded-full bg-teal-300/20 blur-3xl"></div>

                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <p class="text-sm font-medium text-emerald-100">Selamat datang kembali,</p>
                        <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-white tracking-tight">{{ auth()->user()->name }}</h1>
                        <p class="mt-2 text-sm text-emerald-50/90 max-w-md">Kelola kandidat, data pemilih, dan pantau hasil pemilihan dari satu tempat.</p>
                    </div>

                    <div class="w-full lg:w-72 rounded-2xl bg-white/10 ring-1 ring-white/20 backdrop-blur p-4">
                        <div class="flex items-end justify-between">
                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-100">Partisipasi</p>
                            <p class="text-2xl font-extrabold text-white">{{ $participation }}%</p>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-white/20 overflow-hidden">
                            <div class="h-full rounded-full bg-white transition-all duration-500" style="width: {{ $participation }}%"></div>
                        </div>
                        <p class="mt-2 text-xs text-emerald-100">{{ $usedCredentials }} dari {{ $totalCredentials }} hak pilih telah digunakan</p>
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($stats as [$label, $value, $color])
                    <div class="bg-white rounded-2xl ring-1 ring-slate-100 shadow-sm p-5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-extrabold {{ $color }}">{{ number_format($value) }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Menu --}}
            <div>
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Menu Utama</h2>

                <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($menus as [$title, $desc, $url, $icon])
                        <a href="{{ $url }}"
                           class="group relative bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 p-6 hover:-translate-y-1 hover:shadow-xl hover:ring-emerald-200 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 transition-all duration-200">
                            <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-600/30 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
                                </svg>
                            </span>

                            <h3 class="mt-5 font-bold text-slate-900">{{ $title }}</h3>
                            <p class="mt-1 text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>

                            <span class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-emerald-600">
                                Buka
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>