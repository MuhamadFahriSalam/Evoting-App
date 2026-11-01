<div class="py-10" x-data="{ q: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 print:hidden">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">QR Hak Pilih</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Cetak dan bagikan satu QR untuk setiap pemilih
                    <span class="text-slate-400">&middot; {{ $credentials->count() }} QR</span>
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                        </svg>
                    </span>
                    <input type="text" x-model="q" placeholder="Cari nama pemilih"
                           class="w-full sm:w-64 rounded-xl border-0 bg-white py-2.5 pl-11 pr-4 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition">
                </div>

                <button type="button" onclick="window.print()"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all duration-200">
                    <svg class="w-5 h-5 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v7H6v-7z"/>
                    </svg>
                    Cetak Semua
                </button>
            </div>
        </div>

        {{-- Grid kartu QR --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 print:grid-cols-3 print:gap-4">
            @forelse ($credentials as $credential)
                @php $name = $credential->voter->name ?? '-'; @endphp

                <div wire:key="qr-{{ $credential->id }}"
                     x-show="'{{ strtolower(addslashes($name)) }}'.includes(q.toLowerCase())"
                     class="group bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 p-4 text-center hover:-translate-y-1 hover:shadow-xl hover:ring-emerald-200 transition-all duration-200 print:shadow-none print:ring-slate-300 print:break-inside-avoid">

                    <div class="relative aspect-square rounded-2xl bg-slate-50 ring-1 ring-slate-100 p-3 flex items-center justify-center overflow-hidden">
                        <img src="/storage/qrcodes/voter-{{ $credential->voter_id }}.png"
                             alt="QR {{ $name }}"
                             loading="lazy"
                             class="w-full h-full object-contain"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div style="display:none" class="absolute inset-0 flex-col items-center justify-center text-slate-400 text-xs gap-1">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            QR belum tersedia
                        </div>
                    </div>

                    <p class="mt-4 font-bold text-slate-900 truncate" title="{{ $name }}">{{ $name }}</p>

                    <div class="mt-2">
                        @if ($credential->status === 'used')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-slate-100 text-slate-500 ring-1 ring-inset ring-slate-300/50 font-semibold text-xs rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Terpakai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-semibold text-xs rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        @endif
                    </div>

                    @php
                        $slug = \Illuminate\Support\Str::slug($name) ?: 'pemilih';
                    @endphp

                    <div class="mt-4 grid grid-cols-2 gap-2 print:hidden">
                        <a href="/storage/qrcodes/voter-{{ $credential->voter_id }}.png" target="_blank" rel="noopener"
                        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat
                        </a>

                        <a href="/storage/qrcodes/voter-{{ $credential->voter_id }}.png"
                        download="qr-{{ $slug }}.png"
                        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm shadow-emerald-600/25 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                            </svg>
                            Unduh
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 py-16 px-6 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl">🔳</div>
                    <p class="mt-4 text-base font-semibold text-slate-700">Belum ada QR pemilih</p>
                    <p class="mt-1 text-sm text-slate-400">Tambahkan pemilih terlebih dahulu agar QR hak pilih dibuat.</p>
                    <a href="{{ route('voters.create') }}"
                       class="mt-4 inline-flex items-center px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                        + Tambah Pemilih
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>