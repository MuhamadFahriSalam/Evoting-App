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
        string $token,
        int $candidateId
    ): Ballot {

        return DB::transaction(function () use (
            $token,
            $candidateId
        ) {

            $credential = VoterCredential::query()
                ->lockForUpdate()
                ->where('token_hash', hash('sha256', $token))
                ->firstOrFail();

            if ($credential->used_at) {
                throw new \Exception(
                    'Hak pilih sudah digunakan.'
                );
            }

            $candidate = Candidate::query()
                ->where('id', $candidateId)
                ->where(
                    'election_id',
                    $credential->election_id
                )
                ->firstOrFail();

            $ballot = Ballot::create([
                'election_id' => $credential->election_id,
                'candidate_id' => $candidate->id,
                'ballot_reference' => Str::uuid(),
            ]);

            $credential->update([
                'used_at' => now(),
                'status' => 'used',
            ]);

            return $ballot;
        });
    }
}