<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect / to /login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard Switcher (The Hub)
    Route::get('/dashboard', function () {
        $role = session('role');
        return match($role) {
            'super_admin' => redirect()->route('dashboards.super-admin'),
            'admin' => redirect()->route('dashboards.admin'),
            'registrar' => redirect()->route('dashboards.registrar'),
            'finance' => redirect()->route('finance.fees'),
            'teacher' => redirect()->route('teacher.grading'),
            'student' => redirect()->route('student.grades'),
            'parent' => redirect()->route('parent.billing'),
            default => redirect()->route('login'),
        };
    })->name('dashboard');

    Route::get('/users', App\Livewire\SuperAdmin\UserManager::class)->name('users');

    // Super Admin Specific Routes
    Route::get('/admin/school-year', App\Livewire\SuperAdmin\SchoolYearManager::class)->name('admin.school-year');
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
    Route::get('/admin/curriculum', App\Livewire\Admin\Curriculum\CurriculumManager::class)->name('admin.curriculum');
    Route::get('/admin/sections', App\Livewire\Admin\Curriculum\SectionManager::class)->name('admin.sections');
    Route::get('/admin/schedule', App\Livewire\Admin\Scheduling\ScheduleBuilder::class)->name('admin.schedule');
    Route::get('/admin/reports/classlist', App\Livewire\Admin\Scheduling\ClassListManager::class)->name('admin.reports.classlist');
    Route::get('/admin/reports/deped', App\Livewire\Admin\Reports\DepEdReports::class)->name('admin.reports.deped');
    Route::get('/admin/reports/preview', App\Livewire\Admin\Reports\ReportPreview::class)->name('admin.reports.preview');
    Route::get('/admin/reports/sf9', App\Livewire\Admin\Reports\ReportCardGenerator::class)->name('admin.reports.sf9');

    // Finance Routes
    Route::get('/finance/inventory', App\Livewire\Finance\Inventory\ProductInventory::class)->name('finance.inventory');
    Route::get('/finance/pos', App\Livewire\Finance\Cashier\CashierPanel::class)->name('finance.pos');
    Route::get('/finance/history', App\Livewire\Finance\Reporting\TransactionHistory::class)->name('finance.history');
    Route::get('/finance/discounts', App\Livewire\Finance\Fees\DiscountManager::class)->name('finance.discounts');
    Route::get('/finance/remittance', App\Livewire\Finance\Reporting\DailyRemittance::class)->name('finance.remittance');
    Route::get('/finance/ledger', App\Livewire\Finance\Reporting\StudentLedger::class)->name('finance.ledger');
    Route::get('/finance/fees', App\Livewire\Finance\Fees\FeeStructure::class)->name('finance.fees');

    // Registrar Routes
    Route::get('/registrar/students', App\Livewire\Registrar\Student\StudentDirectory::class)->name('registrar.students');
    Route::get('/registrar/enrollment', App\Livewire\Registrar\Enrollment\EnrollmentWizard::class)->name('registrar.enrollment');
    Route::get('/registrar/print-cor', function () {
        $data = session('enrollment_details');
        if (!$data) {
            return redirect()->route('registrar.enrollment');
        }
        return view('livewire.registrar.print-cor', ['data' => $data]);
    })->name('registrar.print-cor');
    Route::get('/registrar/permanent-record', App\Livewire\Registrar\Records\HistoricalGrades::class)->name('registrar.permanent-record');
    Route::get('/registrar/promotion', App\Livewire\Registrar\Records\BatchPromotion::class)->name('registrar.promotion');
    Route::get('/registrar/remedial', App\Livewire\Registrar\Records\RemedialEntry::class)->name('registrar.remedial');
    Route::get('/registrar/dropping', App\Livewire\Registrar\Student\StudentDeparture::class)->name('registrar.dropping');

    // Teacher Routes
    Route::get('/teacher/grading', App\Livewire\Teacher\Grading\GradingSheet::class)->name('teacher.grading');
    Route::get('/teacher/advisory', App\Livewire\Teacher\Advisory\AdvisoryBoard::class)->name('teacher.advisory');

    // Student Routes
    Route::get('/student/schedule', App\Livewire\Student\StudentSchedule::class)->name('student.schedule');
    Route::get('/student/grades', App\Livewire\Student\StudentGrades::class)->name('student.grades');

    // Parent Routes
    Route::get('/parent/billing', App\Livewire\Parent\BillingDetails::class)->name('parent.billing');
    Route::get('/parent/schedule', App\Livewire\Parent\StudentSchedule::class)->name('parent.schedule');
    Route::get('/parent/grades', App\Livewire\Parent\StudentGrades::class)->name('parent.grades');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';

// Override default login route with Livewire component
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
