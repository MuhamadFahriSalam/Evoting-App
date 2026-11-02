<?php

namespace App\Livewire\Candidate;

use App\Models\Candidate;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {
        Candidate::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.candidate.index', [
            'candidates' => Candidate::all()
        ]);
    }
}