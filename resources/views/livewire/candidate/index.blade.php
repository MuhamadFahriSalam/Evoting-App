<div class="py-12 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Container utama -->
        <div class="bg-white shadow-xl shadow-slate-200/60 sm:rounded-3xl ring-1 ring-slate-100 overflow-hidden">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 px-6 lg:px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50/60 via-white to-white">
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex w-12 h-12 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6M3 9a3 3 0 106 0"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Data Kandidat</h1>
                        <p class="text-sm text-slate-500 mt-0.5">Kelola daftar calon kepala desa resmi untuk pemilihan.</p>
                    </div>
                </div>

                <a href="{{ route('candidates.create') }}"
                   class="group inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg hover:shadow-emerald-600/30 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2 -ml-1 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kandidat
                </a>
            </div>

            <div class="p-6 lg:p-8">

                <!-- Flash message (bisa ditutup) -->
                @if (session()->has('message'))
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
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition-colors" aria-label="Tutup">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Tabel -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                                <th class="py-4 px-6 w-28">No. Urut</th>
                                <th class="py-4 px-6">Nama Kandidat</th>
                                <th class="py-4 px-6">Status Verifikasi</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 text-sm bg-white">
                            @forelse($candidates as $candidate)
                                <tr class="group hover:bg-emerald-50/40 transition-colors duration-150">

                                    <!-- No. Urut -->
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 group-hover:bg-emerald-100 text-slate-700 group-hover:text-emerald-700 font-bold transition-colors">
                                            {{ $candidate->serial_number }}
                                        </span>
                                    </td>

                                    <!-- Nama + avatar inisial -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-bold shadow-sm shrink-0">
                                                {{ strtoupper(mb_substr($candidate->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-slate-900">{{ $candidate->name }}</span>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-6">
                                        @if($candidate->verification_status === 'verified')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 font-semibold text-xs rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified
                                            </span>
                                        @elseif($candidate->verification_status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 font-semibold text-xs rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20 font-semibold text-xs rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 px-6 text-center">
                                        <button
                                            wire:click="delete({{ $candidate->id }})"
                                            wire:confirm="Apakah Anda yakin ingin menghapus kandidat ini?"
                                            wire:loading.attr="disabled"
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
                                    <td colspan="4" class="py-16 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl">
                                                📋
                                            </div>
                                            <p class="text-base font-semibold text-slate-700">Belum ada data kandidat</p>
                                            <p class="text-sm text-slate-400 max-w-xs">Silakan tambahkan data calon kepala desa terlebih dahulu melalui tombol di atas.</p>
                                            <a href="{{ route('candidates.create') }}"
                                               class="mt-2 inline-flex items-center px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                                                + Tambah Kandidat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>