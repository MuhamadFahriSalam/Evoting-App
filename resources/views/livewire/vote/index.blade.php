<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-8 text-center">
        Pilih Kandidat
    </h1>

    <div class="grid md:grid-cols-2 gap-6">

        @foreach($candidates as $candidate)

            <div
                class="border rounded-lg p-6 shadow">

                <h2 class="text-2xl font-bold">
                    {{ $candidate->serial_number }}
                </h2>

                <h3 class="text-xl my-3">
                    {{ $candidate->name }}
                </h3>

                <p>
                    {{ $candidate->vision }}
                </p>

                <button
                    wire:click="vote({{ $candidate->id }})"
                    wire:confirm="Apakah Anda yakin?"

                    class="w-full mt-4 bg-green-600 text-white py-3 rounded">

                    Pilih

                </button>

            </div>

        @endforeach

    </div>

</div>