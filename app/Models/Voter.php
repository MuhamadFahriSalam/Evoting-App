<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function credential()
    {
        return $this->hasOne(VoterCredential::class);
    }
}
