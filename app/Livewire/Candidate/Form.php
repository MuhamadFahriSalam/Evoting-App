<?php

namespace App\Livewire\Candidate;

use App\Models\Candidate;
use App\Models\Election;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $photo;
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
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;

        if ($this->photo) {
            $photoPath = $this->photo->store(
                'candidates',
                'public'
            );
        }

        Candidate::create([
            'election_id' => $this->election_id,
            'serial_number' => $this->serial_number,
            'name' => $this->name,
            'photo' => $photoPath,
            'profile' => $this->profile,
            'vision' => $this->vision,
            'mission' => $this->mission,
            'verification_status' => 'verified',
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