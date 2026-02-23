<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::redirect('/', '/dashboard')->name('home');

// Admin Guest Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Admin Protected Routes
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])->prefix('admin')->group(function () {
    // Dashboard & User Management
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users', [DashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::delete('/users/{user}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/settings.php';