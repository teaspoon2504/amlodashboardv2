<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.redirect');

// Auth (Fortify)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Authenticated
Route::middleware('auth')->group(function () {
    Route::get('dashboard/officer', [DashboardController::class, 'officer'])->name('dashboard.officer')->middleware('role:officer');
    Route::get('dashboard/lead', [DashboardController::class, 'lead'])->name('dashboard.lead')->middleware('role:lead,ho');
    Route::get('dashboard/ho', [DashboardController::class, 'ho'])->name('dashboard.ho')->middleware('role:ho');

    Route::middleware('role:officer')->group(function () {
        Route::patch('tasks/{task}/officer-update', [TaskController::class, 'officerUpdate'])->name('tasks.officer-update');
    });

    Route::middleware('role:lead')->group(function () {
        Route::patch('tasks/{task}/lead-feedback', [TaskController::class, 'leadFeedback'])->name('tasks.lead-feedback');
        Route::patch('tasks/{task}/lead-set-target', [TaskController::class, 'leadSetTarget'])->name('tasks.lead-set-target');
    });

    Route::middleware('role:ho')->group(function () {
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    Route::middleware('role:ho,lead')->group(function () {
        Route::get('monitoring/regional-office', [DashboardController::class, 'regionalOffice'])->name('monitoring.regional-office');
        Route::get('monitoring/officer', [DashboardController::class, 'officerMonitoring'])->name('monitoring.officer');
    });
});