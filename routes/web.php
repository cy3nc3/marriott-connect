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
use App\Livewire\Finance\ExpenseManager;
use App\Livewire\Finance\PointOfSale;
use App\Livewire\Finance\ProductInventory;
use App\Livewire\Parent\BillingDetails;
use App\Livewire\Registrar\EnrollmentWizard;
use App\Livewire\Student\StudentGrades;
use App\Livewire\Student\StudentSchedule;
use App\Livewire\SuperAdmin\SchoolYearManager;
use App\Livewire\SuperAdmin\UserManager;
use App\Livewire\Teacher\GradingSheet;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard Switcher (The Hub)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', UserManager::class)->name('users');

    // Super Admin Specific Routes
    Route::get('/admin/school-year', SchoolYearManager::class)->name('admin.school-year');
    Route::get('/admin/settings', App\Livewire\SuperAdmin\SystemSettings::class)->name('admin.settings');

    // Dashboards (Role Specific)
    Route::get('/dashboards/super-admin', App\Livewire\SuperAdmin\Dashboard::class)->name('dashboards.super-admin');
    Route::get('/dashboards/admin', App\Livewire\Admin\Dashboard::class)->name('dashboards.admin');
    Route::get('/dashboards/registrar', App\Livewire\Registrar\Dashboard::class)->name('dashboards.registrar');
    Route::get('/dashboards/finance', App\Livewire\Finance\Dashboard::class)->name('dashboards.finance');
    Route::get('/dashboards/teacher', App\Livewire\Teacher\Dashboard::class)->name('dashboards.teacher');
    Route::get('/dashboards/student', App\Livewire\Student\Dashboard::class)->name('dashboards.student');
    Route::get('/dashboards/parent', App\Livewire\Parent\Dashboard::class)->name('dashboards.parent');

    // Admin Routes
    Route::get('/admin/curriculum', CurriculumManager::class)->name('admin.curriculum');
    Route::get('/admin/sections', SectionManager::class)->name('admin.sections');
    Route::get('/admin/schedule', \App\Livewire\Admin\ScheduleBuilder::class)->name('admin.schedule');
    Route::get('/admin/reports/classlist', \App\Livewire\Admin\ClassListReport::class)->name('admin.reports.classlist');

    // Finance Routes
    Route::get('/finance/inventory', ProductInventory::class)->name('finance.inventory');
    Route::get('/finance/pos', PointOfSale::class)->name('finance.pos');
    Route::get('/finance/expenses', ExpenseManager::class)->name('finance.expenses');
    Route::get('/finance/history', \App\Livewire\Finance\TransactionHistory::class)->name('finance.history');
    Route::get('/finance/discounts', \App\Livewire\Finance\DiscountManager::class)->name('finance.discounts');
    Route::get('/finance/remittance', \App\Livewire\Finance\DailyRemittance::class)->name('finance.remittance');

    // Registrar Routes
    Route::get('/registrar/enrollment', EnrollmentWizard::class)->name('registrar.enrollment');
    Route::get('/registrar/permanent-record', \App\Livewire\Registrar\HistoricalGrades::class)->name('registrar.permanent-record');
    Route::get('/registrar/promotion', \App\Livewire\Registrar\BatchPromotion::class)->name('registrar.promotion');
    Route::get('/registrar/dropping', \App\Livewire\Registrar\StudentDeparture::class)->name('registrar.dropping');

    // Teacher Routes
    Route::get('/teacher/grading', GradingSheet::class)->name('teacher.grading');
    Route::get('/teacher/advisory', \App\Livewire\Teacher\AdvisoryBoard::class)->name('teacher.advisory');

    // Student Routes
    Route::get('/student/schedule', StudentSchedule::class)->name('student.schedule');
    Route::get('/student/grades', StudentGrades::class)->name('student.grades');

    // Parent Routes
    Route::get('/parent/billing', BillingDetails::class)->name('parent.billing');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
