<?php

namespace App\Livewire\Concerns;

use App\Models\Election;
use App\Models\Village;
use Illuminate\Support\Str;

trait ResolvesElectionByTitle
{
    /** "Pemilihan  X " dan "Pemilihan X" dianggap sama. */
    protected function normalizeTitle(string $title): string
    {
        return Str::of($title)->squish()->toString();
    }

    /** Pencarian tidak peka huruf besar/kecil. */
    protected function findElectionByTitle(string $title): ?Election
    {
        return Election::whereRaw('LOWER(title) = ?', [mb_strtolower($title)])->first();
    }

    /// Jika tidak ada pemilihan dengan judul itu, buat pemilihan baru dengan judul itu.
    protected function createElectionFromTitle(string $title): Election
    {
        // start_at & end_at wajib di tabel Anda: isi jadwal sementara, ubah nanti di pengaturan pemilihan.
        $start = now()->addDays(7)->setTime(8, 0);

        return Election::create([
            'village_id'         => $this->defaultVillageId(),
            'title'              => $title,
            'start_at'           => $start,
            'end_at'             => $start->copy()->setTime(13, 0),
            'status'             => 'draft',
            'results_visibility' => false, // tinyint: 0 = hasil disembunyikan
        ]);
    }

    /** village_id wajib diisi: pakai desa pemilihan terakhir, atau desa pertama, atau buat desa sementara. */
    protected function defaultVillageId(): int
    {
        return Election::latest('id')->value('village_id')
            ?? Village::value('id')
            ?? Village::create(['name' => 'Belum diatur', 'district' => '-', 'regency' => '-', 'province' => '-'])->id;
    }
}