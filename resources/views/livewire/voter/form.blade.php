<div class="max-w-4xl mx-auto p-6">

    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h1 class="text-3xl font-bold mb-8">
            Tambah Pemilih
        </h1>

        <form wire:submit="save">

            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Pemilihan
                </label>

                <select
                    wire:model="election_id"
                    class="w-full border rounded-xl p-3">

                    <option value="">
                        Pilih Pemilihan
                    </option>

                    @foreach($elections as $election)

                        <option value="{{ $election->id }}">
                            {{ $election->title }}
                        </option>

                    @endforeach

                </select>

                @error('election_id')
                    <span class="text-red-500 text-sm">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Nama Pemilih
                </label>

                <input
                    type="text"
                    wire:model="name"
                    class="w-full border rounded-xl p-3">

                @error('name')
                    <span class="text-red-500 text-sm">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    ID Pemilih / NIK
                </label>

                <input
                    type="text"
                    wire:model="voter_identifier"
                    class="w-full border rounded-xl p-3">

                @error('voter_identifier')
                    <span class="text-red-500 text-sm">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <button
                type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl">

                Simpan Pemilih

            </button>

        </form>

    </div>

</div>