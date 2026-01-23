<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\SuperAdmin\SchoolYearManager;
use App\Livewire\SuperAdmin\UserManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', SchoolYearManager::class)->name('dashboard');
    Route::get('/users', UserManager::class)->name('users');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
