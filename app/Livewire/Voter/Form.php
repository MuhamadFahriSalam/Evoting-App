<?php

namespace App\Livewire\Voter;

use App\Models\Election;
use App\Models\Voter;
use App\Models\VoterCredential;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    public string $election_title = '';
    public string $name = '';
    public string $voter_identifier = '';

    public function save()
    {
        $this->validate([
            'election_title'   => 'required|string|max:255',
            'name'             => 'required|string|max:255',
            'voter_identifier' => 'required|string|max:50',
        ], [
            'election_title.required'   => 'Nama pemilihan wajib diisi.',
            'name.required'             => 'Nama pemilih wajib diisi.',
            'voter_identifier.required' => 'ID pemilih / NIK wajib diisi.',
        ]);

        $election = Election::where('title', trim($this->election_title))->first();

        if (! $election) {
            $this->addError('election_title', 'Pemilihan tidak ditemukan. Pilih dari saran yang muncul.');
            return;
        }

        $identifier = trim($this->voter_identifier);

        $exists = Voter::where('election_id', $election->id)
            ->where('voter_identifier', $identifier)
            ->exists();

        if ($exists) {
            $this->addError('voter_identifier', 'ID pemilih ini sudah terdaftar pada pemilihan tersebut.');
            return;
        }

        $token = Str::random(64);

        $voter = DB::transaction(function () use ($election, $identifier, $token) {
            $voter = Voter::create([
                'election_id'        => $election->id,
                'name'               => trim($this->name),
                'voter_identifier'   => $identifier,
                'eligibility_status' => 'eligible',
            ]);

            VoterCredential::create([
                'election_id' => $election->id,
                'voter_id'    => $voter->id,
                'token_hash'  => hash('sha256', $token),
                'plain_token' => $token,
                'status'      => 'active',
                'expires_at'  => now()->addDays(30),
            ]);

            return $voter;
        });

        app(QrCodeService::class)->generate(
            url('/vote/' . $token),
            'voter-' . $voter->id
        );

        session()->flash('message', 'Pemilih berhasil ditambahkan');

        return redirect()->route('voters.index');
    }

    public function render()
    {
        return view('livewire.voter.form', [
            'elections' => Election::all(),
        ]);
    }
}