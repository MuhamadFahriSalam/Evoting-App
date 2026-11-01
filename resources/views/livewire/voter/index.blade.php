<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Data Pemilih
        </h1>

        <a
            href="{{ route('voters.create') }}"
            class="bg-emerald-600 text-white px-4 py-2 rounded-lg">

            Tambah Pemilih

        </a>

    </div>

    @if(session('message'))

        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">

            {{ session('message') }}

        </div>

    @endif

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead>

                <tr class="bg-slate-50">

                    <th class="p-4 text-left">
                        Nama
                    </th>

                    <th class="p-4 text-left">
                        ID Pemilih
                    </th>

                    <th class="p-4 text-left">
                        Status
                    </th>

                    <th class="p-4 text-left">
                        QR
                    </th>

                    <th class="p-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($voters as $voter)

                    <tr class="border-t">

                        <td class="p-4">
                            {{ $voter->name }}
                        </td>

                        <td class="p-4">
                            {{ $voter->voter_identifier }}
                        </td>

                        <td class="p-4">

                            @if($voter->credential?->status == 'used')

                                <span class="text-green-600">

                                    Sudah Memilih

                                </span>

                            @else

                                <span class="text-yellow-600">

                                    Belum Memilih

                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <a
                                href="/storage/qrcodes/voter-{{ $voter->id }}.png"
                                target="_blank"
                                class="text-blue-600">

                                Lihat QR

                            </a>

                        </td>

                        <td class="p-4 text-center">

                            <button
                                wire:click="delete({{ $voter->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded">

                                Hapus

                            </button>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>