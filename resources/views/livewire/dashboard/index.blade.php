<div class="p-6">

    <h1 class="text-3xl font-bold mb-8">
        Hasil Pemilihan
    </h1>

    <div class="grid md:grid-cols-3 gap-4 mb-8">

        <div class="bg-blue-100 p-4 rounded-xl">

            <div class="text-sm">
                Total Pemilih
            </div>

            <div class="text-3xl font-bold">
                {{ $totalVoters }}
            </div>

        </div>

        <div class="bg-green-100 p-4 rounded-xl">

            <div class="text-sm">
                Suara Masuk
            </div>

            <div class="text-3xl font-bold">
                {{ $totalVotes }}
            </div>

        </div>

        <div class="bg-yellow-100 p-4 rounded-xl">

            <div class="text-sm">
                Partisipasi
            </div>

            <div class="text-3xl font-bold">

                {{ $totalVoters > 0
                    ? round(($totalVotes / $totalVoters) * 100, 1)
                    : 0 }}%

            </div>

        </div>

    </div>

    <div class="space-y-4">

        @foreach($candidates as $item)

            <div class="bg-white p-6 rounded-2xl shadow">

                <div class="flex items-center gap-4">

                    @if($item['candidate']->photo)

                        <img
                            src="{{ asset('storage/'.$item['candidate']->photo) }}"
                            class="w-20 h-20 rounded-full object-cover">

                    @endif

                    <div class="flex-1">

                        <h2 class="font-bold text-xl">

                            {{ $item['candidate']->name }}

                        </h2>

                        <p class="text-slate-500">

                            No Urut
                            {{ $item['candidate']->serial_number }}

                        </p>

                    </div>

                    <div class="text-right">

                        <div
                            class="text-3xl font-bold text-emerald-600">

                            {{ $item['votes'] }}

                        </div>

                        <div>

                            {{ $item['percentage'] }}%

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>