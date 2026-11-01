<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">
        QR Pemilih
    </h1>

    <table class="w-full">

        <thead>
            <tr>
                <th>Voter</th>
                <th>QR</th>
            </tr>
        </thead>

        <tbody>

        @foreach($credentials as $credential)

            <tr>

                <td>
                    {{ $credential->voter->name }}
                </td>

                <td>

                    <a
                        target="_blank"
                        href="/storage/qrcodes/voter-{{ $credential->voter_id }}.png">

                        Lihat QR

                    </a>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>