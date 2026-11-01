<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoterCredential extends Model
{
    protected $fillable = [
        'election_id',
        'voter_id',
        'token_hash',
        'status',
        'expires_at',
        'used_at',
        'revoked_at',
    ];

    public function voter()
    {
        return $this->belongsTo(Voter::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}