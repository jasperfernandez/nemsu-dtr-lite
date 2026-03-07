<?php

use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('departments', DepartmentController::class);

    Route::resource('employees', EmployeeController::class);

    Route::resource('attendance_logs', AttendanceLogController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/oauth.php';
