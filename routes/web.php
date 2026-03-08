<?php

use App\Http\Controllers\AttendanceDayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LinkEmployeeController;
use App\Http\Controllers\TimeLogController;
use App\Http\Middleware\EnsureUserHasEmployee;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified', EnsureUserHasEmployee::class])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('departments', DepartmentController::class)->except(['show']);

    Route::resource('employees', EmployeeController::class)->except(['show']);

    Route::get('employee/link', [LinkEmployeeController::class, 'show'])->name('employee.link.show');
    Route::post('employee/link', [LinkEmployeeController::class, 'store'])->name('employee.link.store');

    Route::resource('attendance_days', AttendanceDayController::class)->except(['show']);

    Route::post('time-log', TimeLogController::class)->name('time-log');
});

require __DIR__.'/settings.php';
require __DIR__.'/oauth.php';


