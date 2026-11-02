<?php

namespace App\Livewire\Vote;

use App\Exceptions\VoteException;
use App\Models\Candidate;
use App\Models\VoterCredential;
use App\Services\VoteReceipt;
use App\Services\VoteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.voter')]
class Index extends Component
{
    #[Locked]
    public string $token = '';

    #[Locked]
    public int $electionId = 0;

    public bool $invalidToken = false;

    public string $message = '';

    public function mount($token)
    {
        $credential = VoterCredential::where(
            'token_hash',
            hash('sha256', $token)
        )->first();

        if (! $credential) {

            $this->invalidToken = true;
            $this->message = 'QR atau token tidak valid.';

            return;
        }

        if ($credential->used_at) {

            $this->invalidToken = true;
            $this->message = 'QR sudah digunakan untuk memberikan suara.';

            return;
        }

        if ($credential->status !== 'active') {

            $this->invalidToken = true;
            $this->message = 'Hak pilih tidak aktif.';

            return;
        }

        $this->token = $token;
        $this->electionId = $credential->election_id;
    }

    public function vote(
        int $candidateId,
        VoteService $voteService
    ) {
        try {

            $voteService->castVote(
                $this->token,
                $candidateId
            );

        } catch (VoteException $e) {

            $this->addError(
                'vote',
                $e->getMessage()
            );

            return;

        } catch (ModelNotFoundException $e) {

            $this->addError(
                'vote',
                'Token atau kandidat tidak valid.'
            );

            return;
        }

        $credential = VoterCredential::where(
            'token_hash',
            hash('sha256', $this->token)
        )->first();

        if ($credential) {

            session([
                'vote_receipt' => VoteReceipt::make(
                    $credential
                )
            ]);
        }

        return redirect()
            ->route('vote.success');
    }

    public function render()
    {
        return view(
            'livewire.vote.index',
            [
                'candidates' => Candidate::where(
                        'election_id',
                        $this->electionId
                    )
                    ->where(
                        'verification_status',
                        'verified'
                    )
                    ->orderBy('serial_number')
                    ->get(),
            ]
        );
    }
}