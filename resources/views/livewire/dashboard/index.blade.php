<div class="p-6">

    <h1 class="text-3xl font-bold mb-8">
        Hasil Pemilihan
    </h1>

    <div class="grid md:grid-cols-3 gap-4 mb-8">

        <div class="p-6 bg-blue-100 rounded">
            <h2>Total Pemilih</h2>

            <div class="text-3xl font-bold">
                {{ $totalVoters }}
            </div>
        </div>

        <div class="p-6 bg-green-100 rounded">
            <h2>Suara Masuk</h2>

            <div class="text-3xl font-bold">
                {{ $totalVotes }}
            </div>
        </div>

        <div class="p-6 bg-yellow-100 rounded">

            <h2>Partisipasi</h2>

            <div class="text-3xl font-bold">

                {{ $totalVoters > 0
                    ? round(($totalVotes / $totalVoters) * 100, 1)
                    : 0 }}%

            </div>
        </div>

    </div>

    <div class="space-y-4">

        @foreach($results as $result)

            <div
                class="p-4 border rounded">

                <div class="flex justify-between">

                    <span>

                        {{ $result['candidate']->serial_number }}

                        -

                        {{ $result['candidate']->name }}

                    </span>

                    <span class="font-bold">

                        {{ $result['votes'] }}

                        Suara

                    </span>

                </div>

            </div>

        @endforeach

    </div>

</div>