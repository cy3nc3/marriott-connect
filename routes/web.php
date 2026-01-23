<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\CurriculumManager;
use App\Livewire\Admin\SectionManager;
use App\Livewire\Finance\PointOfSale;
use App\Livewire\Finance\ProductInventory;
use App\Livewire\Registrar\EnrollmentWizard;
use App\Livewire\SuperAdmin\SchoolYearManager;
use App\Livewire\SuperAdmin\UserManager;
use App\Livewire\Teacher\GradingSheet;
use App\Livewire\Student\StudentDashboard;
use App\Livewire\Parent\ParentDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', SchoolYearManager::class)->name('dashboard');
    Route::get('/users', UserManager::class)->name('users');

    // Admin Routes
    Route::get('/admin/curriculum', CurriculumManager::class)->name('admin.curriculum');
    Route::get('/admin/sections', SectionManager::class)->name('admin.sections');

    // Finance Routes
    Route::get('/finance/inventory', ProductInventory::class)->name('finance.inventory');
    Route::get('/finance/pos', PointOfSale::class)->name('finance.pos');

    // Registrar Routes
    Route::get('/registrar/enrollment', EnrollmentWizard::class)->name('registrar.enrollment');

    // Teacher Routes
    Route::get('/teacher/grading', GradingSheet::class)->name('teacher.grading');

    // Student Routes
    Route::get('/student/dashboard', StudentDashboard::class)->name('student.dashboard');

    // Parent Routes
    Route::get('/parent/dashboard', ParentDashboard::class)->name('parent.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
