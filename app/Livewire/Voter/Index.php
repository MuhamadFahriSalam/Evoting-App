<?php

namespace App\Livewire\Voter;

use Livewire\Component;
use App\Models\Voter;

class Index extends Component
{
    public function delete($id)
    {
        Voter::findOrFail($id)->delete();

        session()->flash(
            'message',
            'Pemilih berhasil dihapus'
        );
    }

    public function render()
    {
        return view(
            'livewire.voter.index',
            [
                'voters' => Voter::with('credential')
                    ->latest()
                    ->get()
            ]
        );
    }
}