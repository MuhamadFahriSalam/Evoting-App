<?php

namespace App\Livewire\Candidate;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public ?string $notice = null;
    public string $noticeType = 'success';
    public int $noticeId = 0;

    /** Kandidat hanya boleh dihapus sebelum pemungutan suara dimulai. */
    private const DELETABLE_STATUSES = ['draft', 'preparation', 'scheduled'];

    public function delete(int $id): void
    {
        $candidate = Candidate::find($id);

        if (! $candidate) { // sudah terhapus (mis. dari tab lain)
            $this->flash('Kandidat sudah tidak ada.', 'error');
            return;
        }

        $election = Election::find($candidate->election_id);
        if ($election && ! in_array($election->status, self::DELETABLE_STATUSES, true)) {
            $this->flash('Kandidat tidak dapat dihapus setelah pemilihan dimulai.', 'error');
            return;
        }

        $photo = $candidate->photo;

        try {
            $candidate->delete();
        } catch (QueryException $e) {
            report($e);
            $this->flash('Kandidat tidak dapat dihapus karena masih terhubung dengan data lain, misalnya suara.', 'error');
            return;
        }

        if ($photo) {
            Storage::disk('public')->delete($photo); // jangan tinggalkan file foto yatim
        }

        $this->flash('Kandidat berhasil dihapus.');
    }

    private function flash(string $message, string $type = 'success'): void
    {
        $this->notice = $message;
        $this->noticeType = $type;
        $this->noticeId++; // memaksa pesan baru tampil ulang walau teksnya sama
    }

    public function render()
    {
        return view('livewire.candidate.index', [
            'candidates' => Candidate::orderBy('serial_number')->get(),
        ]);
    }
}