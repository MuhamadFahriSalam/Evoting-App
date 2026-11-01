<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
        protected $fillable = [
        'village_id',
        'title',
        'start_at',
        'end_at',
        'status',
        'results_visibility',
    ];
    
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class);
    }
}
