<div class="min-h-screen bg-gradient-to-b from-emerald-50 via-white to-white flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md bg-white rounded-3xl ring-1 ring-slate-100 shadow-2xl shadow-slate-200/70 p-8 text-center">
        @if ($valid)
            <div class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-xl shadow-emerald-600/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="mt-6 text-2xl font-extrabold text-slate-900 tracking-tight">Bukti Valid</h1>
            <p class="mt-2 text-sm text-slate-500">Pemilih ini telah menggunakan hak pilihnya.</p>

            <dl class="mt-6 text-left divide-y divide-slate-100 rounded-2xl bg-slate-50 ring-1 ring-slate-100">
                <div class="flex justify-between gap-4 px-4 py-3">
                    <dt class="text-sm text-slate-500">Nama</dt>
                    <dd class="text-sm font-semibold text-slate-900">{{ $maskedName }}</dd>
                </div>
                <div class="flex justify-between gap-4 px-4 py-3">
                    <dt class="text-sm text-slate-500">Waktu</dt>
                    <dd class="text-sm font-semibold text-slate-900">{{ $votedAt }}</dd>
                </div>
            </dl>
            <p class="mt-4 text-xs text-slate-400">Pilihan kandidat bersifat rahasia dan tidak ditampilkan.</p>
        @else
            <div class="mx-auto w-20 h-20 rounded-full bg-rose-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h1 class="mt-6 text-2xl font-extrabold text-slate-900 tracking-tight">Bukti Tidak Valid</h1>
            <p class="mt-2 text-sm text-slate-500">Kode tidak ditemukan atau pemilih belum memilih.</p>
        @endif

        <a href="{{ route('home') }}" class="mt-8 inline-flex px-5 py-3 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 rounded-xl ring-1 ring-slate-200 transition">Ke Beranda</a>
    </div>
</div>