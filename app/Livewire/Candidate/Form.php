<?php

namespace App\Livewire\Candidate;

use App\Livewire\Concerns\ResolvesElectionByTitle;
use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use ResolvesElectionByTitle;
    use WithFileUploads;

    public string $election_title = '';
    public $photo;
    public $serial_number;
    public string $name = '';
    public string $profile = '';
    public string $vision = '';
    public string $mission = '';

    /** True jika teks yang diketik belum cocok dengan pemilihan mana pun (untuk petunjuk di form). */
    #[Computed]
    public function isNewElection(): bool
    {
        $title = $this->normalizeTitle($this->election_title);

        return mb_strlen($title) >= 5 && $this->findElectionByTitle($title) === null;
    }

    public function updatedElectionTitle(): void
    {
        $this->resetErrorBag('election_title');
    }

    public function save()
    {
        $this->election_title = $this->normalizeTitle($this->election_title);

        $this->validate([
            'election_title' => 'required|string|min:5|max:200',
            'serial_number'  => 'required|integer|min:1|max:99',
            'name'           => 'required|string|max:150',
            'profile'        => 'nullable|string|max:1000',
            'vision'         => 'nullable|string|max:2000',
            'mission'        => 'nullable|string|max:3000',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'election_title.required' => 'Nama pemilihan wajib diisi.',
            'election_title.min'      => 'Nama pemilihan minimal 5 karakter.',
            'serial_number.required'  => 'Nomor urut wajib diisi.',
            'name.required'           => 'Nama kandidat wajib diisi.',
        ]);

        $election = $this->findElectionByTitle($this->election_title); // null = pemilihan baru
        $createdElection = false;

        if ($election) {
            // Daftar kandidat dikunci begitu pemungutan suara dimulai.
            if (! in_array($election->status, ['draft', 'preparation', 'scheduled'], true)) {
                $this->addError('election_title', 'Pemilihan ini sudah dimulai atau selesai, kandidat tidak dapat ditambah.');
                return;
            }

            if (Candidate::where('election_id', $election->id)->where('serial_number', $this->serial_number)->exists()) {
                $this->addError('serial_number', 'Nomor urut ini sudah dipakai kandidat lain pada pemilihan tersebut.');
                return;
            }
        }

        $photoPath = $this->photo ? $this->photo->store('candidates', 'public') : null;

        try {
            // Pemilihan baru + kandidat dalam satu transaksi: jika kandidat gagal, pemilihan baru ikut dibatalkan.
            DB::transaction(function () use (&$election, &$createdElection, $photoPath) {
                if (! $election) {
                    $election = $this->createElectionFromTitle($this->election_title);
                    $createdElection = true;
                }

                Candidate::create([
                    'election_id'         => $election->id,
                    'serial_number'       => $this->serial_number,
                    'name'                => trim($this->name),
                    'photo'               => $photoPath,
                    'profile'             => $this->profile ?: null,
                    'vision'              => $this->vision ?: null,
                    'mission'             => $this->mission ?: null,
                    'verification_status' => 'verified',
                ]);
            });
        } catch (QueryException $e) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath); // jangan tinggalkan foto yatim
            }
            // Balapan dua penyimpanan bersamaan: unique (election_id, serial_number) di database menolaknya.
            $this->addError('serial_number', 'Nomor urut ini sudah dipakai kandidat lain pada pemilihan tersebut.');
            return;
        }

        session()->flash('success', $createdElection
            ? "Kandidat berhasil ditambahkan. Pemilihan baru \"{$election->title}\" ikut dibuat."
            : 'Kandidat berhasil ditambahkan');

        return redirect('/candidates');
    }

    public function render()
    {
        return view('livewire.candidate.form', [
            'elections' => Election::orderBy('title')->get(),
        ]);
    }
}