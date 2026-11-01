<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\Voter;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'candidateCount' => Candidate::count(),
            'voterCount' => Voter::count(),
            'ballotCount' => Ballot::count(),
        ]);
    }
}