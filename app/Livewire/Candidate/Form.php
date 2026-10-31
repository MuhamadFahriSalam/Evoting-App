<?php

namespace App\Livewire\Candidate;

use App\Models\Candidate;
use App\Models\Election;
use Livewire\Component;

class Form extends Component
{
    public $election_id;
    public $serial_number;
    public $name;
    public $profile;
    public $vision;
    public $mission;

    public function save()
    {
        $this->validate([
            'election_id' => 'required',
            'serial_number' => 'required',
            'name' => 'required',
        ]);

        Candidate::create([
            'election_id' => $this->election_id,
            'serial_number' => $this->serial_number,
            'name' => $this->name,
            'profile' => $this->profile,
            'vision' => $this->vision,
            'mission' => $this->mission,
            'verification_status' => 'pending',
        ]);

        session()->flash(
            'success',
            'Kandidat berhasil ditambahkan'
        );

        return redirect('/candidates');
    }

    public function render()
    {
        return view('livewire.candidate.form', [
            'elections' => Election::all()
        ]);
    }
}