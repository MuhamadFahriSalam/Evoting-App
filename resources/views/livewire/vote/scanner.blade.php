<div class="min-h-screen bg-gradient-to-b from-emerald-50 via-white to-white py-10 px-4">
    <div class="max-w-lg mx-auto">

        {{-- Header --}}
        <div class="text-center mb-8">
            <span class="mx-auto flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/30">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </span>
            <h1 class="mt-5 text-3xl font-extrabold text-slate-900 tracking-tight">Scan QR Pemilih</h1>
            <p class="mt-2 text-sm text-slate-500">Arahkan kamera ke QR Code hak pilih untuk membuka surat suara.</p>
        </div>

        {{-- Area kamera --}}
        <div class="bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 p-4 sm:p-6"
            wire:ignore
            x-data="cameraScanner({ baseUrl: @js(url('/vote')) })">

            <div class="relative min-h-64 overflow-hidden rounded-2xl bg-slate-900 ring-1 ring-slate-200"
                :class="mirror ? '[&_video]:-scale-x-100' : ''">

                <div id="reader" class="scanner-reader w-full"></div>

                {{-- Label kamera aktif --}}
                <span x-show="running && label" x-cloak x-text="label" role="status"
                    class="absolute left-3 top-3 z-10 rounded-full bg-black/60 px-3 py-1 text-xs font-medium text-white backdrop-blur"></span>

                {{-- Tombol putar kamera --}}
                <button type="button" x-show="running && cameras.length > 1" x-cloak @click="flip()" :disabled="busy"
                        aria-label="Putar kamera depan atau belakang"
                        class="absolute bottom-3 right-3 z-10 inline-flex items-center gap-2 rounded-full bg-white/95 px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-lg ring-1 ring-slate-200 transition hover:bg-white focus:outline-none focus-visible:ring-4 focus-visible:ring-emerald-500/40 disabled:opacity-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M5.6 15a8 8 0 0013.9 2M18.4 9A8 8 0 004.5 7"/>
                    </svg>
                    Putar kamera
                </button>

                {{-- Sedang membuka kamera --}}
                <div x-show="busy" x-cloak role="status"
                    class="absolute inset-0 z-10 flex items-center justify-center bg-slate-900/80 text-sm font-medium text-white">
                    Membuka kamera…
                </div>

                {{-- Pemberitahuan setelah kembali ke kamera semula --}}
                <p x-show="notice" x-cloak x-text="notice" role="status"
                    class="absolute inset-x-3 bottom-16 z-10 rounded-lg bg-amber-100 px-3 py-2 text-center text-xs font-medium text-amber-900">
                </p>
            </div>

            <ul class="mt-5 space-y-2.5 text-sm text-slate-500">
                <li class="flex items-start gap-2.5">
                    <span class="mt-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Izinkan akses kamera saat diminta browser.
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="mt-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Posisikan QR di tengah bingkai dengan pencahayaan cukup.
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="mt-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Setiap QR hanya dapat dipakai satu kali.
                </li>
            </ul>
        </div>

        {{-- Cadangan: input manual --}}
        <div class="mt-6 bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/50 p-5"
             x-data="{
                 value: '',
                 go() {
                     const token = this.value.trim().split('/').filter(Boolean).pop();
                     if (token) window.location.href = '{{ url('/vote') }}/' + encodeURIComponent(token);
                 }
             }">
            <p class="text-sm font-semibold text-slate-700">Kamera tidak bisa dipakai?</p>
            <p class="text-xs text-slate-400 mt-0.5">Tempel link atau kode dari QR di sini.</p>
            <form x-on:submit.prevent="go" class="mt-3 flex gap-2">
                <input type="text" x-model="value" placeholder="Tempel link atau kode"
                       class="flex-1 min-w-0 rounded-xl border-0 bg-slate-50 py-2.5 px-3.5 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition">
                <button type="submit"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-600/25 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition">
                    Buka
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600">&larr; Kembali ke beranda</a>
        </p>
    </div>
</div>