<?php

namespace App\Livewire\Vote;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\VoterCredential;
use App\Services\VoteService;

class Index extends Component
{
    public string $token;

    public $candidates = [];

    public function mount($token)
    {
        $this->token = $token;

        $credential = VoterCredential::where(
            'token_hash',
            hash('sha256', $token)
        )->firstOrFail();

        $this->candidates = Candidate::where(
            'election_id',
            $credential->election_id
        )
        ->where(
            'verification_status',
            'verified'
        )
        ->get();
    }

    public function vote(
        VoteService $voteService,
        $candidateId
    )
    {
        $voteService->castVote(
            $this->token,
            $candidateId
        );

        return redirect()
            ->route('vote.success');
    }

    public function render()
    {
        return view('livewire.vote.index');
    }
}