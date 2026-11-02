@if($invalidToken)

    <div class="max-w-xl mx-auto mt-10">

        <div class="bg-red-50 border border-red-200 rounded-2xl p-8 text-center">

            <div class="text-6xl mb-4">
                ⚠️
            </div>

            <h2 class="text-2xl font-bold text-red-700 mb-3">
                Voting Tidak Dapat Dilanjutkan
            </h2>

            <p class="text-red-600">
                {{ $message }}
            </p>

            <a
                href="{{ route('vote.scan') }}"
                class="inline-block mt-6 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl">

                Kembali ke Scanner

            </a>

        </div>

    </div>

@else

    <div class="min-h-screen bg-gradient-to-b from-emerald-50 via-white to-white"
         wire:keydown.escape.window="cancel">

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
                <div class="fixed top-4 inset-x-4 z-[60] max-w-xl mx-auto p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-medium shadow-xl"
                     x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)">
                    <div class="flex items-start justify-between gap-3">
                        <span>{{ $message }}</span>
                        <button type="button" @click="show = false" class="text-rose-500 hover:text-rose-700 font-bold leading-none">&times;</button>
                    </div>
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
                                wire:click="confirm({{ $candidate->id }})"
                                wire:loading.attr="disabled"
                                wire:target="confirm,vote"
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

        {{-- Modal Konfirmasi (Livewire) --}}
        @if($confirming)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-8 bg-slate-900/60 backdrop-blur-sm"
                 wire:click.self="cancel">

                <div class="w-full max-w-5xl max-h-[92vh] overflow-y-auto bg-white rounded-3xl shadow-2xl ring-1 ring-slate-200 p-6 sm:p-10">

                    <div class="flex flex-col-reverse md:flex-row md:items-center gap-8">

                        {{-- Teks --}}
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Konfirmasi Pilihan</h3>
                            <p class="mt-2 text-sm sm:text-base text-slate-500">
                                Apakah Anda yakin ingin memilih kandidat berikut?
                            </p>

                            <p class="mt-6 text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-400">Nomor Urut</p>
                            <p class="text-6xl sm:text-7xl font-extrabold leading-none text-emerald-600">{{ $confirming->serial_number }}</p>

                            <h4 class="mt-3 text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $confirming->name }}</h4>

                            @if($confirming->vision)
                                <div class="mt-5 max-h-32 overflow-y-auto rounded-2xl bg-slate-50 ring-1 ring-slate-100 p-4 text-left">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Visi</p>
                                    <p class="mt-1 text-sm text-slate-600 leading-relaxed">{{ $confirming->vision }}</p>
                                </div>
                            @endif

                            <p class="mt-5 text-sm font-semibold text-red-600">
                                Perhatian! Pilihan yang sudah dikirim tidak dapat diubah.
                            </p>
                        </div>

                        {{-- Foto --}}
                        <div class="shrink-0 mx-auto md:mx-0 w-44 sm:w-56 aspect-[3/4] rounded-3xl overflow-hidden bg-red-600 ring-4 ring-emerald-100 shadow-xl">
                            @if($confirming->photo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($confirming->photo) }}"
                                     alt="Foto {{ $confirming->name }}"
                                     class="w-full h-full object-cover object-top">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-6xl font-extrabold">
                                    {{ strtoupper(mb_substr($confirming->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol lebar --}}
                    <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-2 gap-4">
                        <button type="button" wire:click="cancel"
                                wire:loading.attr="disabled" wire:target="vote"
                                class="py-4 sm:py-5 text-base sm:text-lg rounded-2xl bg-red-600 hover:bg-red-700 text-white font-bold shadow-md shadow-red-600/25 transition disabled:opacity-50">
                            Batal
                        </button>
                        <button type="button" wire:click="vote({{ $confirming->id }})"
                                wire:loading.attr="disabled" wire:target="vote"
                                class="py-4 sm:py-5 text-base sm:text-lg rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-md shadow-blue-600/25 transition disabled:opacity-50">
                            <span wire:loading.remove wire:target="vote">Ya, Pilih</span>
                            <span wire:loading wire:target="vote">Memproses...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endif