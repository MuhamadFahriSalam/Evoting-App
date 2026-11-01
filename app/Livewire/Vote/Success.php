<?php

namespace App\Livewire\Vote;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.voter')]      
class Success extends Component
{
    public function render()
    {
        return view(
            'livewire.vote.success'
        );
    }
}