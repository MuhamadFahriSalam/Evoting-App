<x-app-layout>
    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Panitia</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola kandidat, data pemilih, dan pantau hasil pemilihan.</p>
            </div>

            @php
                $menus = [
                    ['Kandidat', 'Tambah, verifikasi, dan kelola calon kepala desa.', route('candidates.index'), 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 100-8 4 4 0 000 8z'],
                    ['Data Pemilih', 'Kelola daftar pemilih terdaftar.', route('voters.index'), 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                    ['QR Hak Pilih', 'Lihat dan cetak QR Code untuk pemilih.', route('voters.qr'), 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01'],
                    ['Hasil Voting', 'Pantau perolehan suara.', route('results'), 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ];
            @endphp

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($menus as [$title, $desc, $url, $icon])
                    <a href="{{ $url }}"
                       class="group bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 p-6 hover:-translate-y-1 hover:shadow-xl hover:ring-emerald-200 transition-all duration-200">
                        <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/>
                            </svg>
                        </span>
                        <h2 class="mt-4 font-bold text-slate-900">{{ $title }}</h2>
                        <p class="mt-1 text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>