<?php

namespace App\Livewire\Vote;

use App\Exceptions\VoteException;
use App\Models\Candidate;
use App\Models\VoterCredential;
use App\Services\VoteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\VoteReceipt;

#[Layout('layouts.voter')]

class Index extends Component
{
    #[Locked]
    public string $token;

    #[Locked]
    public int $electionId;

    public function mount($token)
    {
        $credential = VoterCredential::where('token_hash', hash('sha256', $token))
            ->first();

        if (! $credential || $credential->used_at || $credential->status !== 'active') {
            abort(403, 'Hak pilih tidak valid atau sudah digunakan.');
        }

        $this->token = $token;
        $this->electionId = $credential->election_id;
    }

    public function vote(int $candidateId, VoteService $voteService)
    {
        try {
            $voteService->castVote($this->token, $candidateId);
        } catch (VoteException $e) {
            $this->addError('vote', $e->getMessage());
            return;
        } catch (ModelNotFoundException $e) {
            $this->addError('vote', 'Token atau kandidat tidak valid.');
            return;
        }

        $credential = VoterCredential::where('token_hash', hash('sha256', $this->token))->first();

        if ($credential) {
            session(['vote_receipt' => VoteReceipt::make($credential)]);
        }

        return redirect()->route('vote.success');
    }
    public function render()
    {
        return view('livewire.vote.index', [
            'candidates' => Candidate::where('election_id', $this->electionId)
                ->where('verification_status', 'verified')
                ->orderBy('serial_number')
                ->get(),
        ]);
    }
}