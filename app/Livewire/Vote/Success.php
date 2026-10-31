<?php

namespace App\Livewire\Vote;

use Livewire\Component;

class Success extends Component
{
    public function render()
    {
        return view(
            'livewire.vote.success'
        );
    }
}