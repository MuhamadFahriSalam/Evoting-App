<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
    'election_id',
    'serial_number',
    'name',
    'photo',
    'profile',
    'vision',
    'mission',
    'verification_status',
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}
