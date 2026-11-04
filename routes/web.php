<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC WEBSITE ──────────────────────────────────
Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/services', [WebsiteController::class, 'services'])->name('services');
Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::post('/contact', [WebsiteController::class, 'submitLead'])->name('lead.submit');

// ── ADMIN PANEL ──────────────────────────────────────
// Managers: day-to-day operations (leads, attendance, read-only
// employees/payments). Admins: everything, incl. services, settings,
// money records and any delete/edit.
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('leads', LeadController::class)->except('destroy');
    Route::resource('attendance', AttendanceController::class);
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

    // Admin-only zone
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('services', ServiceController::class);
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
        Route::resource('employees', EmployeeController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::patch('payments/{payment}/void', [PaymentController::class, 'void'])->name('payments.void');
        Route::patch('payments/{payment}/restore', [PaymentController::class, 'restore'])->name('payments.restore');
    });
});

// ── ADMIN PROFILE ────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');
