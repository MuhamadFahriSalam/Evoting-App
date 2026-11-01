<div class="py-10">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

        <a href="{{ route('voters.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
            Kembali ke Data Pemilih
        </a>

        <div class="mt-4 bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 overflow-hidden">

            <div class="px-6 sm:px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50/60 via-white to-white">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Pemilih</h1>
                <p class="text-sm text-slate-500 mt-1">Isi data pemilih. QR hak pilih dibuat setelah data disimpan.</p>
            </div>

            <form wire:submit="save" class="p-6 sm:p-8 space-y-6">

                {{-- Pemilihan (input teks + saran) --}}
                <div>
                    <label for="election_title" class="block text-sm font-semibold text-slate-700">Pemilihan</label>
                    <input id="election_title" type="text" wire:model="election_title" list="election-list"
                           autocomplete="off" placeholder="Ketik nama pemilihan"
                           class="mt-1.5 block w-full rounded-xl border-0 bg-slate-50 py-3 px-4 text-sm text-slate-900 ring-1 ring-inset @error('election_title') ring-rose-400 @else ring-slate-200 @enderror placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition">
                    <datalist id="election-list">
                        @foreach($elections as $election)
                            <option value="{{ $election->title }}"></option>
                        @endforeach
                    </datalist>
                    @error('election_title')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Nama Pemilih</label>
                    <input id="name" type="text" wire:model="name" placeholder="Nama lengkap"
                           class="mt-1.5 block w-full rounded-xl border-0 bg-slate-50 py-3 px-4 text-sm text-slate-900 ring-1 ring-inset @error('name') ring-rose-400 @else ring-slate-200 @enderror placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition">
                    @error('name')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ID / NIK --}}
                <div>
                    <label for="voter_identifier" class="block text-sm font-semibold text-slate-700">ID Pemilih / NIK</label>
                    <input id="voter_identifier" type="text" wire:model="voter_identifier" inputmode="numeric" placeholder="Nomor identitas"
                           class="mt-1.5 block w-full rounded-xl border-0 bg-slate-50 py-3 px-4 text-sm font-mono text-slate-900 ring-1 ring-inset @error('voter_identifier') ring-rose-400 @else ring-slate-200 @enderror placeholder:text-slate-400 placeholder:font-sans focus:bg-white focus:ring-2 focus:ring-inset focus:ring-emerald-500 transition">
                    @error('voter_identifier')
                        <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Aksi --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                    <a href="{{ route('voters.index') }}"
                       class="inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 rounded-xl ring-1 ring-slate-200 transition">
                        Batal
                    </a>
                    <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md shadow-emerald-600/25 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-500/30 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                        <span wire:loading.remove wire:target="save">Simpan Pemilih</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>