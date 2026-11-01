<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Pilkades') }} - Pemilihan Kepala Desa Digital</title>
    <meta name="description" content="Sistem pemilihan kepala desa digital yang rahasia, transparan, dan mudah digunakan.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white text-slate-700">

    {{-- Navbar --}}
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.6-2.4A9 9 0 1112 3a9 9 0 018.6 4.6z"/>
                    </svg>
                </span>
                <span class="font-extrabold text-slate-900 tracking-tight">{{ config('app.name', 'Pilkades') }}</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="#alur" class="hover:text-emerald-600 transition-colors">Alur Memilih</a>
                <a href="#keunggulan" class="hover:text-emerald-600 transition-colors">Keunggulan</a>
                <a href="#faq" class="hover:text-emerald-600 transition-colors">FAQ</a>
            </nav>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-600/25 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-emerald-700 rounded-xl transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-emerald-50 via-white to-white">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-emerald-200/40 blur-3xl"></div>
        <div class="absolute top-40 -left-24 w-72 h-72 rounded-full bg-teal-200/30 blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full ring-1 ring-inset ring-emerald-600/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Pemilihan Kepala Desa Digital
                </span>

                <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.1]">
                    Satu suara, <span class="text-emerald-600">satu kali</span>,<br class="hidden sm:block"> sepenuhnya rahasia.
                </h1>

                <p class="mt-5 text-lg text-slate-600 leading-relaxed max-w-xl">
                    Gunakan hak pilih Anda dengan QR Code pribadi. Cepat, aman, dan tercatat dengan transparan untuk seluruh warga desa.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('vote.scan') }}"
                       class="group inline-flex items-center justify-center px-6 py-3.5 text-base font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg shadow-emerald-600/30 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        Mulai Memilih
                    </a>
                    <a href="#alur"
                       class="inline-flex items-center justify-center px-6 py-3.5 text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 rounded-xl ring-1 ring-slate-200 shadow-sm transition">
                        Lihat Alur Memilih
                    </a>
                </div>

                <dl class="mt-10 grid grid-cols-3 gap-6 max-w-md">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rahasia</dt>
                        <dd class="mt-1 text-sm font-bold text-slate-900">Tanpa identitas di surat suara</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sekali pakai</dt>
                        <dd class="mt-1 text-sm font-bold text-slate-900">QR hangus setelah memilih</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Cepat</dt>
                        <dd class="mt-1 text-sm font-bold text-slate-900">Hitungan detik</dd>
                    </div>
                </dl>
            </div>

            {{-- Ilustrasi kartu --}}
            <div class="relative hidden lg:block">
                <div class="relative mx-auto w-full max-w-sm">
                    <div class="absolute inset-0 translate-x-4 translate-y-4 rounded-3xl bg-emerald-600/10"></div>
                    <div class="relative bg-white rounded-3xl ring-1 ring-slate-100 shadow-2xl shadow-slate-300/50 p-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold text-slate-900">Hak Pilih Anda</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 ring-1 ring-inset ring-emerald-600/20 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        </div>

                        {{-- Pola QR dekoratif --}}
                        <div class="mt-5 mx-auto w-44 h-44 rounded-2xl bg-slate-900 p-3 grid grid-cols-7 gap-1">
                            @foreach ([1,1,1,0,1,1,1, 1,0,1,0,1,0,1, 1,1,1,0,1,1,1, 0,0,0,1,0,0,0, 1,1,0,1,1,0,1, 1,0,1,0,1,1,0, 1,1,1,0,0,1,1] as $cell)
                                <span class="rounded-[3px] {{ $cell ? 'bg-white' : 'bg-transparent' }}"></span>
                            @endforeach
                        </div>

                        <p class="mt-5 text-center text-xs text-slate-400">Tunjukkan QR ini kepada petugas</p>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="rounded-xl bg-slate-50 p-3 text-center">
                                <p class="text-2xl font-extrabold text-emerald-600">1</p>
                                <p class="text-[11px] text-slate-500">Pilihan</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-3 text-center">
                                <p class="text-2xl font-extrabold text-emerald-600">100%</p>
                                <p class="text-[11px] text-slate-500">Rahasia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alur memilih --}}
    <section id="alur" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-600">Alur Memilih</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">Tiga langkah mudah</h2>
                <p class="mt-3 text-slate-500">Tidak perlu aplikasi tambahan. Cukup QR Code dan kamera perangkat.</p>
            </div>

            <div class="mt-12 grid md:grid-cols-3 gap-6">
                @php
                    $steps = [
                        ['1', 'Terima QR Code', 'Datang ke lokasi pemilihan dan terima QR Code hak pilih pribadi dari petugas.', 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01'],
                        ['2', 'Pindai QR', 'Pindai QR Code Anda di perangkat yang tersedia untuk membuka surat suara digital.', 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['3', 'Pilih Kandidat', 'Lihat foto, nomor urut, dan visi kandidat, lalu tentukan pilihan Anda dan konfirmasi.', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                @endphp

                @foreach ($steps as [$no, $title, $desc, $icon])
                    <div class="relative bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 p-7 hover:-translate-y-1 hover:shadow-xl transition-all duration-200">
                        <span class="absolute -top-4 left-7 inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-600 text-white font-extrabold shadow-md shadow-emerald-600/30">{{ $no }}</span>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/>
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Keunggulan --}}
    <section id="keunggulan" class="py-20 bg-slate-50/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-600">Keunggulan</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">Dirancang agar adil dan aman</h2>
            </div>

            <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $features = [
                        ['Suara rahasia', 'Surat suara tidak menyimpan identitas pemilih sehingga pilihan tidak dapat ditelusuri.'],
                        ['Satu hak, satu suara', 'QR hangus otomatis setelah dipakai. Pemungutan ganda ditolak oleh sistem.'],
                        ['Kandidat terverifikasi', 'Hanya kandidat yang telah lolos verifikasi panitia yang tampil di surat suara.'],
                        ['Rekap transparan', 'Hasil dihitung langsung dari suara yang tercatat dan dapat dipantau panitia.'],
                    ];
                @endphp

                @foreach ($features as [$title, $desc])
                    <div class="bg-white rounded-2xl ring-1 ring-slate-100 shadow-sm p-6">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/25">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        <h3 class="mt-4 font-bold text-slate-900">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-wider text-emerald-600">FAQ</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">Pertanyaan yang sering diajukan</h2>
            </div>

            <div class="mt-10 space-y-3">
                @php
                    $faqs = [
                        ['Bagaimana cara mendapatkan QR Code?', 'QR Code dibagikan oleh panitia atau petugas di lokasi pemilihan kepada pemilih yang terdaftar.'],
                        ['Apakah pilihan saya bisa diketahui orang lain?', 'Tidak. Suara yang tercatat tidak terhubung dengan identitas pemilih.'],
                        ['Bagaimana jika QR sudah dipakai?', 'QR hanya berlaku satu kali. Jika muncul pesan bahwa hak pilih sudah digunakan, hubungi petugas atau panitia.'],
                        ['Apakah pilihan bisa diubah?', 'Tidak. Setelah dikonfirmasi, pilihan bersifat final.'],
                    ];
                @endphp

                @foreach ($faqs as [$q, $a])
                    <details class="group bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm open:shadow-md open:ring-emerald-200 transition">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer list-none px-5 py-4 font-semibold text-slate-900">
                            {{ $q }}
                            <svg class="w-5 h-5 text-slate-400 shrink-0 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <p class="px-5 pb-5 text-sm text-slate-500 leading-relaxed">{{ $a }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="px-4 sm:px-6 pb-20">
        <div class="max-w-6xl mx-auto rounded-3xl bg-gradient-to-br from-emerald-600 to-teal-700 px-6 py-14 text-center shadow-xl shadow-emerald-900/20">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Siap menggunakan hak pilih Anda?</h2>
            <p class="mt-3 text-emerald-50/90">Siapkan QR Code Anda lalu mulai memilih.</p>
            <a href="{{ route('vote.scan') }}"
               class="mt-8 inline-flex items-center px-6 py-3.5 text-base font-semibold text-emerald-700 bg-white hover:bg-emerald-50 rounded-xl shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                Pindai QR Code
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-slate-100 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Pilkades') }}. Seluruh hak dilindungi.</p>
            <p>Pemilihan Kepala Desa Digital</p>
        </div>
    </footer>

</body>
</html>