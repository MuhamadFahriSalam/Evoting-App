<?php

namespace App\Services;

use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\VoterCredential;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoteService
{
    public function castVote(
        string $plainToken,
        int $candidateId
    ): Ballot {

        return DB::transaction(function () use (
            $plainToken,
            $candidateId
        ) {

            $credential = VoterCredential::query()
                ->where(
                    'token_hash',
                    hash('sha256', $plainToken)
                )
                ->lockForUpdate()
                ->firstOrFail();

            if ($credential->used_at) {
                throw new \Exception(
                    'Hak pilih sudah digunakan.'
                );
            }

            if ($credential->status !== 'active') {
                throw new \Exception(
                    'Hak pilih tidak aktif.'
                );
            }

            $candidate = Candidate::query()
                ->where(
                    'election_id',
                    $credential->election_id
                )
                ->findOrFail(
                    $candidateId
                );

            $ballot = Ballot::create([
                'election_id' => $credential->election_id,
                'candidate_id' => $candidate->id,
                'ballot_reference' => Str::uuid(),
            ]);

            $credential->update([
                'status' => 'used',
                'used_at' => now(),
            ]);

            return $ballot;
        });
    }
}