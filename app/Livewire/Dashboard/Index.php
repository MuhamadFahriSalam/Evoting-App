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
        $totalVotes = Ballot::count();

        $candidates = Candidate::all()
            ->map(function ($candidate) use ($totalVotes) {

                $votes = Ballot::where(
                    'candidate_id',
                    $candidate->id
                )->count();

                return [
                    'candidate' => $candidate,
                    'votes' => $votes,
                    'percentage' => $totalVotes > 0
                        ? round(
                            ($votes / $totalVotes) * 100,
                            1
                        )
                        : 0,
                ];
            });

        return view(
            'livewire.dashboard.index',
            [
                'candidates' => $candidates,
                'totalVotes' => $totalVotes,
                'totalVoters' => Voter::count(),
            ]
        );
    }
}