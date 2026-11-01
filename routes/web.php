<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Candidate\Index as CandidateIndex;
use App\Livewire\Candidate\Form as CandidateForm;
use App\Livewire\Vote\Index as VoteIndex;
use App\Livewire\Vote\Success as VoteSuccess;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Voter\QrList;
use App\Livewire\Vote\Scanner;
use App\Livewire\Admin\Dashboard as AdminDashboard;

/*
|--------------------------------------------------------------------------
| Publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Alur voting pemilih (token divalidasi di komponen/service)
Route::get('/scan', Scanner::class)->name('vote.scan');
Route::get('/vote/{token}', VoteIndex::class)->name('vote.index');
Route::get('/vote-success', VoteSuccess::class)->name('vote.success');

/*
|--------------------------------------------------------------------------
| Redirect dashboard berdasarkan role
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isCommittee()) {
        return redirect()->route('committee.dashboard');
    } elseif ($user->isOfficer()) {
        return redirect()->route('officer.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin', AdminDashboard::class)
    ->name('admin.dashboard');
/*
|--------------------------------------------------------------------------
| Super Admin + Panitia (Committee)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin,committee'])->group(function () {
    // Kandidat
    Route::get('/candidates', CandidateIndex::class)->name('candidates.index');
    Route::get('/candidates/create', CandidateForm::class)->name('candidates.create');

    // Hasil voting
    Route::get('/results', DashboardIndex::class)->name('results');

    // QR hak pilih
    Route::get('/voters/qr', QrList::class)->name('voters.qr');
});

/*
|--------------------------------------------------------------------------
| Panitia (Committee)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:committee'])->group(function () {
    Route::get('/committee', function () {
        return view('committee.dashboard');
    })->name('committee.dashboard');
});

/*
|--------------------------------------------------------------------------
| Petugas (Officer)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/officer', function () {
        return redirect()->route('vote.scan');
    })->name('officer.dashboard');
});

/*
|--------------------------------------------------------------------------
| Profil
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';