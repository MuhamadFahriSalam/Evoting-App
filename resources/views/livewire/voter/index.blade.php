<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Data Pemilih</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola daftar pemilih terdaftar
                    <span class="text-slate-400">&middot;
                        {{ $voters instanceof \Illuminate\Pagination\LengthAwarePaginator ? $voters->total() : $voters->count() }} pemilih
                    </span>
                </p>
            </div>

            <a href="{{ route('voters.create') }}"
               class="group inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all duration-200">
                <svg class="w-5 h-5 mr-2 -ml-1 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pemilih
            </a>
        </div>

        {{-- Flash message --}}
        @if (session('message'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms
                 x-init="setTimeout(() => show = false, 5000)"
                 class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-medium flex items-center justify-between shadow-sm">
                <div class="flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-full bg-emerald-100 text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    {{ session('message') }}
                </div>
                <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition-colors" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                            <th class="py-4 px-6">Nama</th>
                            <th class="py-4 px-6">ID Pemilih</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">QR</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($voters as $voter)
                            <tr wire:key="voter-{{ $voter->id }}" class="hover:bg-emerald-50/40 transition-colors duration-150">

                                {{-- Nama + avatar --}}
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-bold shadow-sm shrink-0">
                                            {{ strtoupper(mb_substr($voter->name, 0, 1)) }}
                                        </span>
                                        <span class="font-semibold text-slate-900">{{ $voter->name }}</span>
                                    </div>
                                </td>

                                {{-- ID --}}
                                <td class="py-4 px-6">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-mono text-xs">
                                        {{ $voter->voter_identifier }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-6">
                                    @if ($voter->credential?->status === 'used')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-semibold text-xs rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sudah Memilih
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 font-semibold text-xs rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Belum Memilih
                                        </span>
                                    @endif
                                </td>

                                {{-- QR --}}
                                <td class="py-4 px-6">
                                    <a href="/storage/qrcodes/voter-{{ $voter->id }}.png" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 font-semibold text-xs transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01"/>
                                        </svg>
                                        Lihat QR
                                    </a>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-6 text-center">
                                    <button type="button"
                                            wire:click="delete({{ $voter->id }})"
                                            wire:confirm="Hapus pemilih {{ $voter->name }}? Tindakan ini tidak dapat dibatalkan."
                                            wire:loading.attr="disabled"
                                            wire:target="delete({{ $voter->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-rose-600 text-rose-600 hover:text-white font-medium text-xs rounded-lg border border-rose-200 hover:border-rose-600 shadow-sm focus:outline-none focus:ring-4 focus:ring-rose-500/20 disabled:opacity-50 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.87 12.14A2 2 0 0116.14 21H7.86a2 2 0 01-1.99-1.86L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 px-6 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl">👥</div>
                                        <p class="text-base font-semibold text-slate-700">Belum ada data pemilih</p>
                                        <p class="text-sm text-slate-400 max-w-xs">Tambahkan pemilih terlebih dahulu agar QR hak pilih dapat dibuat.</p>
                                        <a href="{{ route('voters.create') }}"
                                           class="mt-2 inline-flex items-center px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                                            + Tambah Pemilih
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginasi (hanya tampil jika $voters memakai paginate()) --}}
        @if ($voters instanceof \Illuminate\Contracts\Pagination\Paginator && $voters->hasPages())
            <div class="mt-6">
                {{ $voters->links() }}
            </div>
        @endif
    </div>
</div>