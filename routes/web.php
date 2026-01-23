<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Finance\PointOfSale;
use App\Livewire\Finance\ProductInventory;
use App\Livewire\Registrar\EnrollmentWizard;
use App\Livewire\SuperAdmin\SchoolYearManager;
use App\Livewire\SuperAdmin\UserManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', SchoolYearManager::class)->name('dashboard');
    Route::get('/users', UserManager::class)->name('users');

    // Finance Routes
    Route::get('/finance/inventory', ProductInventory::class)->name('finance.inventory');
    Route::get('/finance/pos', PointOfSale::class)->name('finance.pos');

    // Registrar Routes
    Route::get('/registrar/enrollment', EnrollmentWizard::class)->name('registrar.enrollment');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
