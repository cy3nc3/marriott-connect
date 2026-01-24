<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\CurriculumManager;
use App\Livewire\Admin\SectionManager;
use App\Livewire\Dashboards\AdminDashboard;
use App\Livewire\Dashboards\FinanceDashboard;
use App\Livewire\Dashboards\ParentDashboard;
use App\Livewire\Dashboards\RegistrarDashboard;
use App\Livewire\Dashboards\StudentDashboard;
use App\Livewire\Dashboards\SuperAdminDashboard;
use App\Livewire\Dashboards\TeacherDashboard;
use App\Livewire\Finance\PointOfSale;
use App\Livewire\Finance\ProductInventory;
use App\Livewire\Registrar\EnrollmentWizard;
use App\Livewire\SuperAdmin\SchoolYearManager;
use App\Livewire\SuperAdmin\UserManager;
use App\Livewire\Teacher\GradingSheet;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard Switcher (The Hub) - Originally SchoolYearManager, now the Switcher View
    // We update this route to return the view 'dashboard' which contains the switcher
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', UserManager::class)->name('users');

    // Dashboards (Role Specific)
    Route::get('/dashboards/super-admin', SuperAdminDashboard::class)->name('dashboards.super-admin');
    Route::get('/dashboards/admin', AdminDashboard::class)->name('dashboards.admin');
    Route::get('/dashboards/registrar', RegistrarDashboard::class)->name('dashboards.registrar');
    Route::get('/dashboards/finance', FinanceDashboard::class)->name('dashboards.finance');
    Route::get('/dashboards/teacher', TeacherDashboard::class)->name('dashboards.teacher');
    Route::get('/dashboards/student', StudentDashboard::class)->name('dashboards.student');
    Route::get('/dashboards/parent', ParentDashboard::class)->name('dashboards.parent');

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

    // Legacy Routes (remapped or kept for direct access if needed, but updated imports)
    // Note: Previous steps had student.dashboard and parent.dashboard pointing to App\Livewire\Student\StudentDashboard
    // If we want to use the NEW dashboards, we should point there.
    // The instructions for Part C imply we are creating NEW components in App\Livewire\Dashboards namespace.
    // I will comment out the old ones to avoid confusion, or map them to the new ones if they are meant to replace them.
    // Given Step 1 & 2 instructions: "Create App\Livewire\Dashboards\StudentDashboard", this replaces the old one.

    // Student Routes
    // Route::get('/student/dashboard', \App\Livewire\Student\StudentDashboard::class)->name('student.dashboard');

    // Parent Routes
    // Route::get('/parent/dashboard', \App\Livewire\Parent\ParentDashboard::class)->name('parent.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
