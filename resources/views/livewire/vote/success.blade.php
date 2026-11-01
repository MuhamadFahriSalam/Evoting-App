<div class="min-h-screen bg-gradient-to-b from-emerald-50 via-white to-white flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">

        <div class="relative overflow-hidden bg-white rounded-3xl ring-1 ring-slate-100 shadow-2xl shadow-slate-200/70 p-8 sm:p-10 text-center">
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-emerald-100/60 blur-2xl"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-teal-100/60 blur-2xl"></div>

            <div class="relative">
                {{-- Ikon sukses --}}
                <div class="relative mx-auto w-24 h-24 mb-7">
                    <span class="absolute inset-0 rounded-full bg-emerald-200/70 animate-ping [animation-duration:2s]"></span>
                    <span class="relative flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 shadow-xl shadow-emerald-600/30">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Suara Anda Telah Tercatat</h1>
                <p class="mt-3 text-sm sm:text-base text-slate-500 leading-relaxed">
                    Terima kasih telah berpartisipasi dalam pemilihan.
                </p>

                {{-- Info --}}
                <ul class="mt-6 space-y-2.5 text-left">
                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 ring-1 ring-slate-100">
                        <span class="mt-0.5 flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm text-slate-600">Pilihan Anda bersifat <span class="font-semibold text-slate-800">rahasia</span>.</span>
                    </li>
                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 ring-1 ring-slate-100">
                        <span class="mt-0.5 flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm text-slate-600">QR Code Anda sudah <span class="font-semibold text-slate-800">tidak berlaku lagi</span>.</span>
                    </li>
                </ul>

                {{-- Tombol --}}
                <div class="mt-8 space-y-3">
                    <a href="{{ route('vote.scan') }}"
                       class="group w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all duration-200">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                        </svg>
                        Kembali ke Scan
                    </a>

                    <a href="{{ route('home') }}"
                       class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 rounded-xl ring-1 ring-slate-200 transition">
                        Ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">Anda dapat menutup halaman ini.</p>
    </div>
</div>