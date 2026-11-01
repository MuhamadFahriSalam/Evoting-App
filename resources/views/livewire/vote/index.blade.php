<div class="min-h-screen bg-slate-50/50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pilih Kandidat</h1>
            <p class="text-sm text-slate-500 mt-2">Pilihan Anda bersifat rahasia dan hanya dapat dilakukan satu kali.</p>
        </div>

        @error('vote')
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-medium shadow-sm">
                {{ $message }}
            </div>
        @enderror

        <div class="grid md:grid-cols-2 gap-6">
            @foreach($candidates as $candidate)
                <div class="bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 overflow-hidden flex flex-col hover:-translate-y-0.5 hover:shadow-xl transition-all duration-200">

                    {{-- Foto kandidat --}}
                    <div class="relative aspect-[4/3] bg-slate-100">
                        @if($candidate->photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($candidate->photo) }}"
                                 alt="Foto {{ $candidate->name }}"
                                 loading="lazy"
                                 class="absolute inset-0 w-full h-full object-cover object-top">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-6xl font-extrabold">
                                {{ strtoupper(mb_substr($candidate->name, 0, 1)) }}
                            </div>
                        @endif

                        {{-- Nomor urut --}}
                        <span class="absolute top-4 left-4 inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-600 text-white text-xl font-extrabold shadow-lg shadow-emerald-900/30 ring-2 ring-white">
                            {{ $candidate->serial_number }}
                        </span>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <h2 class="text-xl font-bold text-slate-900">{{ $candidate->name }}</h2>

                        @if($candidate->vision)
                            <div class="mt-3 flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Visi</p>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $candidate->vision }}</p>
                            </div>
                        @endif

                        <button
                            type="button"
                            wire:click="vote({{ $candidate->id }})"
                            wire:confirm="Apakah Anda yakin memilih kandidat nomor {{ $candidate->serial_number }}? Pilihan tidak dapat diubah."
                            wire:loading.attr="disabled"
                            wire:target="vote"
                            class="w-full mt-6 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md shadow-emerald-600/25 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="vote">Pilih</span>
                            <span wire:loading wire:target="vote">Memproses...</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>