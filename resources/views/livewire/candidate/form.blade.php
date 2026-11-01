<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6">
        Tambah Kandidat
    </h1>

    <form wire:submit="save">

        <div class="mb-4">
            <label class="block mb-2">
                Pemilihan
            </label>

            <select
                wire:model="election_id"
                class="w-full border rounded p-3">

                <option value="">
                    Pilih Pemilihan
                </option>

                @foreach($elections as $election)
                    <option
                        value="{{ $election->id }}">

                        {{ $election->title }}

                    </option>
                @endforeach

            </select>

            @error('election_id')
                <span class="text-red-600">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Nomor Urut
            </label>

            <input
                type="number"
                wire:model="serial_number"
                class="w-full border rounded p-3">

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Nama Kandidat
            </label>

            <input
                type="text"
                wire:model="name"
                class="w-full border rounded p-3">

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Foto Kandidat
            </label>

            <input
                type="file"
                wire:model="photo"
                class="w-full border rounded p-3">

            @error('photo')
                <span class="text-red-600">
                    {{ $message }}
                </span>
            @enderror

            @if ($photo)

                <img
                    src="{{ $photo->temporaryUrl() }}"
                    class="w-32 h-32 rounded-full object-cover mt-4">

            @endif

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Profil
            </label>

            <textarea
                wire:model="profile"
                class="w-full border rounded p-3">
            </textarea>

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Visi
            </label>

            <textarea
                wire:model="vision"
                class="w-full border rounded p-3">
            </textarea>

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Misi
            </label>

            <textarea
                wire:model="mission"
                class="w-full border rounded p-3">
            </textarea>

        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-3 rounded">

            Simpan Kandidat

        </button>

    </form>

</div>