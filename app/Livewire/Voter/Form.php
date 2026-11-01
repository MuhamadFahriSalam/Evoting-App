<?php

namespace App\Livewire\Voter;

use Livewire\Component;
use App\Models\Voter;
use App\Models\Election;
use App\Models\VoterCredential;
use Illuminate\Support\Str;
use App\Services\QrCodeService;

class Form extends Component
{
    public $election_id;
    public $name;
    public $voter_identifier;

    public function save()
    {
        $this->validate([
            'election_id' => 'required',
            'name' => 'required',
            'voter_identifier' => 'required',
        ]);

        $voter = Voter::create([
            'election_id' => $this->election_id,
            'name' => $this->name,
            'voter_identifier' => $this->voter_identifier,
            'eligibility_status' => 'eligible',
        ]);

        $token = Str::random(64);

        VoterCredential::create([
            'election_id' => $this->election_id,
            'voter_id' => $voter->id,
            'token_hash' => hash('sha256', $token),
            'plain_token' => $token,
            'status' => 'active',
            'expires_at' => now()->addDays(30),
        ]);

        app(QrCodeService::class)
        ->generate(
            url('/vote/'.$token),
            'voter-'.$voter->id
        );

        session()->flash(
            'message',
            'Pemilih berhasil ditambahkan'
        );

        return redirect()
            ->route('voters.index');
    }

    public function render()
    {
        return view(
            'livewire.voter.form',
            [
                'elections' => Election::all()
            ]
        );
    }
}
