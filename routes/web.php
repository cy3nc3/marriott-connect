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
            'finance' => redirect()->route('dashboards.finance'),
            'teacher' => redirect()->route('dashboards.teacher'),
            'student' => redirect()->route('dashboards.student'),
            'parent' => redirect()->route('dashboards.parent'),
            default => redirect()->route('login'),
        };
    })->name('dashboard');

    Route::get('/users', App\Livewire\SuperAdmin\UserManager::class)->name('users');

    // Dashboards (Role Specific)
    Route::prefix('dashboards')->name('dashboards.')->group(function () {
        Route::get('/super-admin', App\Livewire\SuperAdmin\Dashboard::class)->name('super-admin');
        Route::get('/admin', App\Livewire\Admin\Dashboard::class)->name('admin');
        Route::get('/registrar', App\Livewire\Registrar\Dashboard::class)->name('registrar');
        Route::get('/finance', App\Livewire\Finance\Dashboard::class)->name('finance');
        Route::get('/teacher', App\Livewire\Teacher\Dashboard::class)->name('teacher');
        Route::get('/student', App\Livewire\Student\Dashboard::class)->name('student');
        Route::get('/parent', App\Livewire\Parent\Dashboard::class)->name('parent');
    });

    // Super Admin & Admin Common Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Super Admin Specific
        Route::get('/school-year', App\Livewire\SuperAdmin\SchoolYearManager::class)->name('school-year');
        Route::get('/settings', App\Livewire\SuperAdmin\SystemSettings::class)->name('settings');

        // Admin
        Route::get('/curriculum', App\Livewire\Admin\Curriculum\CurriculumManager::class)->name('curriculum');
        Route::get('/sections', App\Livewire\Admin\Curriculum\SectionManager::class)->name('sections');
        Route::get('/schedule', App\Livewire\Admin\Scheduling\ScheduleBuilder::class)->name('schedule');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/classlist', App\Livewire\Admin\Scheduling\ClassListManager::class)->name('classlist');
            Route::get('/deped', App\Livewire\Admin\Reports\DepEdReports::class)->name('deped');
            Route::get('/preview', App\Livewire\Admin\Reports\ReportPreview::class)->name('preview');
            Route::get('/sf9', App\Livewire\Admin\Reports\ReportCardGenerator::class)->name('sf9');
        });
    });

    // Finance Routes
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/inventory', App\Livewire\Finance\Inventory\ProductInventory::class)->name('inventory');
        Route::get('/pos', App\Livewire\Finance\Cashier\CashierPanel::class)->name('pos');
        Route::get('/history', App\Livewire\Finance\Reporting\TransactionHistory::class)->name('history');
        Route::get('/discounts', App\Livewire\Finance\Fees\DiscountManager::class)->name('discounts');
        Route::get('/remittance', App\Livewire\Finance\Reporting\DailyRemittance::class)->name('remittance');
        Route::get('/ledger', App\Livewire\Finance\Reporting\StudentLedger::class)->name('ledger');
        Route::get('/fees', App\Livewire\Finance\Fees\FeeStructure::class)->name('fees');
    });

    // Registrar Routes
    Route::prefix('registrar')->name('registrar.')->group(function () {
        Route::get('/students', App\Livewire\Registrar\Student\StudentDirectory::class)->name('students');
        Route::get('/enrollment', App\Livewire\Registrar\Enrollment\EnrollmentWizard::class)->name('enrollment');
        Route::get('/print-cor', function () {
            $data = session('enrollment_details');
            if (!$data) {
                return redirect()->route('registrar.enrollment');
            }
            return view('livewire.registrar.print-cor', ['data' => $data]);
        })->name('print-cor');
        Route::get('/permanent-record', App\Livewire\Registrar\Records\HistoricalGrades::class)->name('permanent-record');
        Route::get('/promotion', App\Livewire\Registrar\Records\BatchPromotion::class)->name('promotion');
        Route::get('/remedial', App\Livewire\Registrar\Records\RemedialEntry::class)->name('remedial');
        Route::get('/dropping', App\Livewire\Registrar\Student\StudentDeparture::class)->name('dropping');
    });

    // Teacher Routes
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/grading', App\Livewire\Teacher\Grading\GradingSheet::class)->name('grading');
        Route::get('/advisory', App\Livewire\Teacher\Advisory\AdvisoryBoard::class)->name('advisory');
    });

    // Student Routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/schedule', App\Livewire\Student\StudentSchedule::class)->name('schedule');
        Route::get('/grades', App\Livewire\Student\StudentGrades::class)->name('grades');
    });

    // Parent Routes
    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('/billing', App\Livewire\Parent\BillingDetails::class)->name('billing');
        Route::get('/schedule', App\Livewire\Parent\StudentSchedule::class)->name('schedule');
        Route::get('/grades', App\Livewire\Parent\StudentGrades::class)->name('grades');
    });
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
