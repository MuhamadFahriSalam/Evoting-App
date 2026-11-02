<?php

namespace App\Livewire\Vote;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.voter')]
class Success extends Component
{
    #[Locked]
    public ?string $receiptCode = null;

    #[Locked]
    public ?string $receiptUrl = null;

    public function mount()
    {
        $code = session('vote_receipt');

        if ($code) {
            $this->receiptCode = $code;
            $this->receiptUrl  = route('vote.verify', $code);
        }
    }

    public function render()
    {
        return view('livewire.vote.success');
    }
}