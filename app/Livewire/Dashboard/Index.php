<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\Voter;

class Index extends Component
{
    public function render()
    {
        $candidates = Candidate::all();

        $results = [];

        foreach ($candidates as $candidate) {

            $results[] = [
                'candidate' => $candidate,
                'votes' => Ballot::where(
                    'candidate_id',
                    $candidate->id
                )->count(),
            ];
        }

        return view(
            'livewire.dashboard.index',
            [
                'results' => $results,
                'totalVotes' => Ballot::count(),
                'totalVoters' => Voter::count(),
            ]
        );
    }
}