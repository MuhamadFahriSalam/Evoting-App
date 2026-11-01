<?php

namespace App\Livewire\Voter;

use Livewire\Component;
use App\Models\VoterCredential;

class QrList extends Component
{
    public function render()
    {
        return view(
            'livewire.voter.qr-list',
            [
                'credentials' =>
                    VoterCredential::with('voter')
                        ->get()
            ]
        );
    }
}