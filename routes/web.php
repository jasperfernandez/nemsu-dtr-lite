<?php

use App\Http\Controllers\AttendanceDayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('departments', DepartmentController::class)->except(['show']);

    Route::resource('employees', EmployeeController::class)->except(['show']);

    Route::resource('attendance_days', AttendanceDayController::class)->except(['show']);

    Route::post('time-log', TimeLogController::class)->name('time-log');
});

require __DIR__.'/settings.php';
require __DIR__.'/oauth.php';
