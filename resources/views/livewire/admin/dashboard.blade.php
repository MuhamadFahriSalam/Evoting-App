<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">
        Dashboard Admin Pilkades
    </h1>

    <div class="grid md:grid-cols-4 gap-4">

        <div class="bg-blue-100 p-4 rounded">
            <h2 class="font-semibold">
                Kandidat
            </h2>

            <div class="text-3xl font-bold">
                {{ $candidateCount }}
            </div>
        </div>

        <div class="bg-green-100 p-4 rounded">
            <h2 class="font-semibold">
                Pemilih
            </h2>

            <div class="text-3xl font-bold">
                {{ $voterCount }}
            </div>
        </div>

        <div class="bg-yellow-100 p-4 rounded">
            <h2 class="font-semibold">
                Suara Masuk
            </h2>

            <div class="text-3xl font-bold">
                {{ $ballotCount }}
            </div>
        </div>

    </div>

    <div class="mt-8 flex gap-3 flex-wrap">

        <a
            href="{{ route('candidates.index') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

            Kelola Kandidat

        </a>

        <a
            href="{{ route('voters.index') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">

            Data Pemilih

        </a>

        <a
            href="{{ route('voters.qr') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

            QR Pemilih

        </a>

        <a
            href="{{ route('results') }}"
            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">

            Hasil Voting

        </a>

    </div>

</div>