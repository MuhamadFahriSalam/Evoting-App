<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}
