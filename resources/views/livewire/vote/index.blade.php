<div class="min-h-screen bg-slate-50/50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pilih Kandidat</h1>
            <p class="text-sm text-slate-500 mt-2">Pilihan Anda bersifat rahasia dan hanya dapat dilakukan satu kali.</p>
        </div>

        {{-- Pesan error (token terpakai, tidak aktif, dll) --}}
        @error('vote')
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-medium shadow-sm">
                {{ $message }}
            </div>
        @enderror

        <div class="grid md:grid-cols-2 gap-6">
            @foreach($candidates as $candidate)
                <div class="bg-white rounded-3xl ring-1 ring-slate-100 shadow-lg shadow-slate-200/60 p-6 flex flex-col hover:-translate-y-0.5 hover:shadow-xl transition-all duration-200">

                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-600 text-white text-2xl font-extrabold shadow-md shadow-emerald-600/30">
                            {{ $candidate->serial_number }}
                        </span>
                        <h2 class="text-xl font-bold text-slate-900">{{ $candidate->name }}</h2>
                    </div>

                    @if($candidate->vision)
                        <div class="mt-4 flex-1">
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
            @endforeach
        </div>
    </div>
</div>