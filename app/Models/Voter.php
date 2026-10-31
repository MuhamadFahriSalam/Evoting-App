<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
        'election_id',
        'voter_identifier',
        'name',
        'eligibility_status',
        'polling_station_id',
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function credential()
    {
        return $this->hasOne(VoterCredential::class);
    }
}