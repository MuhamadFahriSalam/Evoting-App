<?php

namespace App\Livewire\Vote;

use App\Services\VoteReceipt;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.voter')]
class Verify extends Component
{
    public bool $valid = false;
    public ?string $maskedName = null;
    public ?string $votedAt = null;

    public function mount(string $code)
    {
        $credential = VoteReceipt::resolve($code);

        if (! $credential || ! $credential->used_at) {
            return;
        }

        $this->valid = true;
        $this->votedAt = $credential->used_at->timezone(config('app.timezone'))->format('d M Y, H:i');
        $this->maskedName = collect(explode(' ', $credential->voter->name ?? ''))
            ->filter()
            ->map(fn ($w) => mb_substr($w, 0, 1) . str_repeat('*', max(mb_strlen($w) - 1, 2)))
            ->implode(' ');
    }

    public function render()
    {
        return view('livewire.vote.verify');
    }
}