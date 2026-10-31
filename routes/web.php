<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Candidate\Index as CandidateIndex;
use App\Livewire\Candidate\Form as CandidateForm; // <--- 1. Import class Form Livewire Anda di sini

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Route Group untuk Kandidat (Gabung jadi satu agar tidak duplikat)
Route::middleware(['auth'])->group(function () {
    Route::get('/candidates', CandidateIndex::class)->name('candidates.index');
    Route::get('/candidates/create', CandidateForm::class)->name('candidates.create');
});

// Dashboard Umum (Arahkan otomatis berdasarkan role)
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isCommittee()) {
        return redirect()->route('committee.dashboard');
    } elseif ($user->isOfficer()) {
        return redirect()->route('officer.dashboard');
    }

    return view('dashboard'); // Fallback jika role lain
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Khusus Super Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Route Khusus Committee (Panitia)
Route::middleware(['auth', 'role:committee'])->group(function () {
    Route::get('/committee', function () {
        return view('committee.dashboard');
    })->name('committee.dashboard');
});

// Route Khusus Officer (Petugas)
Route::middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/officer', function () {
        return view('officer.dashboard');
    })->name('officer.dashboard');
});

// Route Profil Bawaan Laravel
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';