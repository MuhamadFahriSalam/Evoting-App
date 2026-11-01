<div class="mx-auto max-w-3xl px-4 py-8 sm:px-6">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900">Tambah Kandidat</h1>
        <p class="mt-1 text-slate-600">Lengkapi data calon kepala desa. Kolom bertanda <span class="text-red-600" aria-hidden="true">*</span> wajib diisi.</p>
    </div>

    {{-- Form --}}
    <form wire:submit="save" class="space-y-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">

        {{-- Data utama --}}
        <fieldset class="space-y-5">
            <legend class="mb-1 text-lg font-semibold text-slate-900">Data utama</legend>

            {{-- Pemilihan --}}
            <div>
                <label for="election_id" class="mb-1.5 block text-sm font-medium text-slate-800">
                    Pemilihan <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <select id="election_id" wire:model="election_id"
                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-600/20 @error('election_id') border-red-500 @enderror">
                    <option value="">Pilih pemilihan</option>
                    @foreach ($elections as $election)
                        <option value="{{ $election->id }}">{{ $election->title }}</option>
                    @endforeach
                </select>
                @error('election_id')
                    <p class="mt-1.5 text-sm font-medium text-red-700" role="alert">Gagal: {{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                {{-- Nomor urut --}}
                <div class="sm:col-span-1">
                    <label for="serial_number" class="mb-1.5 block text-sm font-medium text-slate-800">
                        Nomor urut <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <input id="serial_number" type="number" min="1" inputmode="numeric" wire:model="serial_number"
                           class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-center text-2xl font-bold text-blue-900 shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-600/20 @error('serial_number') border-red-500 @enderror">
                    @error('serial_number')
                        <p class="mt-1.5 text-sm font-medium text-red-700" role="alert">Gagal: {{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-medium text-slate-800">
                        Nama kandidat <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <input id="name" type="text" wire:model="name" autocomplete="off" placeholder="Nama lengkap beserta gelar"
                           class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-600/20 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-sm font-medium text-red-700" role="alert">Gagal: {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </fieldset>

        <hr class="border-slate-200">

        {{-- Foto --}}
        <fieldset>
            <legend class="mb-3 text-lg font-semibold text-slate-900">Foto kandidat</legend>

            <div class="flex flex-col items-center gap-5 sm:flex-row sm:items-start">
                {{-- Pratinjau --}}
                <div class="shrink-0">
                    @if ($photo && $photo->isPreviewable())
                        <img src="{{ $photo->temporaryUrl() }}" alt="Pratinjau foto kandidat"
                             class="h-32 w-32 rounded-2xl object-cover shadow ring-4 ring-blue-100">
                    @else
                        <div class="flex h-32 w-32 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 ring-1 ring-slate-200" aria-hidden="true">
                            <svg class="h-14 w-14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Area unggah --}}
                <div class="w-full">
                    <input id="photo" type="file" wire:model="photo" accept="image/png,image/jpeg,image/webp" class="peer sr-only">
                    <label for="photo"
                           class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center transition hover:border-blue-500 hover:bg-blue-50 peer-focus-visible:ring-4 peer-focus-visible:ring-blue-600/30">
                        <svg class="mb-2 h-8 w-8 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V4.5m0 0L7.5 9M12 4.5L16.5 9M4.5 15.75v2.25A2.25 2.25 0 006.75 20.25h10.5a2.25 2.25 0 002.25-2.25v-2.25"/></svg>
                        <span class="font-medium text-slate-800">Klik untuk memilih foto</span>
                        <span class="mt-1 text-sm text-slate-500">JPG, PNG, atau WebP, maksimal 2 MB</span>
                    </label>

                    <p wire:loading wire:target="photo" class="mt-2 text-sm font-medium text-blue-700" role="status">Mengunggah foto…</p>
                    @error('photo')
                        <p class="mt-2 text-sm font-medium text-red-700" role="alert">Gagal: {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </fieldset>

        <hr class="border-slate-200">

        {{-- Profil, visi, misi --}}
        <fieldset class="space-y-5">
            <legend class="mb-1 text-lg font-semibold text-slate-900">Profil, visi, dan misi</legend>

            @foreach ([
                ['profile', 'Profil singkat', 3, 'Latar belakang, pekerjaan, pengalaman organisasi…'],
                ['vision',  'Visi',           3, 'Gambaran desa yang ingin diwujudkan…'],
                ['mission', 'Misi',           5, 'Tuliskan langkah-langkah utama, satu poin per baris…'],
            ] as [$field, $label, $rows, $hint])
                <div>
                    <label for="{{ $field }}" class="mb-1.5 block text-sm font-medium text-slate-800">{{ $label }}</label>
                    <textarea id="{{ $field }}" rows="{{ $rows }}" wire:model="{{ $field }}" placeholder="{{ $hint }}"
                              class="block w-full resize-y rounded-xl border border-slate-300 px-4 py-3 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-600/20 @error($field) border-red-500 @enderror"></textarea>
                    @error($field)
                        <p class="mt-1.5 text-sm font-medium text-red-700" role="alert">Gagal: {{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </fieldset>

        {{-- Aksi --}}
        <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

            {{-- Kiri --}}
            <a href="{{ url()->previous() }}"
            class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-3 font-semibold text-blue-700 transition hover:bg-blue-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-600/30">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.7 5.3a1 1 0 010 1.4L9.4 10l3.3 3.3a1 1 0 01-1.4 1.4l-4-4a1 1 0 010-1.4l4-4a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                Kembali
            </a>

            {{-- Kanan --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <a href="{{ url()->previous() }}"
                class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-600/30">
                    Batal
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:target="save,photo"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-600/40 disabled:cursor-not-allowed disabled:opacity-60">
                    <svg wire:loading wire:target="save" class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" stroke-linecap="round"/></svg>
                    <span wire:loading.remove wire:target="save">Simpan Kandidat</span>
                    <span wire:loading wire:target="save">Menyimpan…</span>
                </button>
            </div>
        </div>
    </form>
</div>