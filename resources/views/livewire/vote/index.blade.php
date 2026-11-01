<div class="min-h-screen bg-gradient-to-b from-emerald-50 via-white to-white">

    {{-- Header --}}
    <header class="border-b border-slate-100 bg-white/80 backdrop-blur">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.6-2.4A9 9 0 1112 3a9 9 0 018.6 4.6z"/>
                    </svg>
                </span>
                <span class="font-extrabold text-slate-900 tracking-tight">{{ config('app.name', 'Pilkades') }}</span>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 ring-1 ring-inset ring-emerald-600/20 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Surat Suara Digital
            </span>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

        <div class="text-center max-w-xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Pilih Kandidat</h1>
            <p class="mt-3 text-sm sm:text-base text-slate-500 leading-relaxed">
                Pilihan Anda bersifat rahasia dan hanya dapat dilakukan <span class="font-semibold text-slate-700">satu kali</span>.
            </p>
        </div>

        @error('vote')
            <div class="mt-8 max-w-xl mx-auto p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-medium shadow-sm">
                {{ $message }}
            </div>
        @enderror

        {{-- Daftar kandidat --}}
        <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">
            @forelse($candidates as $candidate)
                <div wire:key="cand-{{ $candidate->id }}"
                     class="group bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 overflow-hidden flex flex-col hover:-translate-y-1 hover:shadow-xl hover:ring-emerald-200 transition-all duration-200">

                    {{-- Foto (portrait 3:4 agar pas foto tidak terpotong) --}}
                    <div class="relative aspect-[3/4] bg-slate-100 overflow-hidden">
                        @if($candidate->photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($candidate->photo) }}"
                                 alt="Foto {{ $candidate->name }}"
                                 loading="lazy"
                                 class="absolute inset-0 w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-[1.03]">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-7xl font-extrabold">
                                {{ strtoupper(mb_substr($candidate->name, 0, 1)) }}
                            </div>
                        @endif

                        {{-- Gradient bawah + nama --}}
                        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
                        <h2 class="absolute bottom-4 left-5 right-5 text-xl font-extrabold text-white drop-shadow truncate">
                            {{ $candidate->name }}
                        </h2>

                        {{-- Nomor urut --}}
                        <span class="absolute top-4 left-4 flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-white text-emerald-700 shadow-lg ring-1 ring-black/5 leading-none">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">No</span>
                            <span class="text-2xl font-extrabold">{{ $candidate->serial_number }}</span>
                        </span>
                    </div>

                    {{-- Isi --}}
                    <div class="p-5 flex flex-col flex-1">
                        @if($candidate->vision)
                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Visi</p>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $candidate->vision }}</p>
                            </div>
                        @else
                            <div class="flex-1"></div>
                        @endif

                        <button
                            type="button"
                            wire:click="vote({{ $candidate->id }})"
                            wire:confirm="Apakah Anda yakin memilih kandidat nomor {{ $candidate->serial_number }} ({{ $candidate->name }})? Pilihan tidak dapat diubah."
                            wire:loading.attr="disabled"
                            wire:target="vote"
                            class="w-full mt-5 inline-flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="vote" class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Pilih Kandidat Ini
                            </span>
                            <span wire:loading wire:target="vote">Memproses...</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 py-16 px-6 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl">🗳️</div>
                    <p class="mt-4 text-base font-semibold text-slate-700">Belum ada kandidat</p>
                    <p class="mt-1 text-sm text-slate-400">Hubungi panitia jika ini tidak seharusnya terjadi.</p>
                </div>
            @endforelse
        </div>

        <p class="mt-10 text-center text-xs text-slate-400">
            Suara Anda tidak terhubung dengan identitas Anda.
        </p>
    </div>
</div>