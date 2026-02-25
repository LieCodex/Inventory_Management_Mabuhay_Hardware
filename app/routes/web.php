<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Http\Request;

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

Route::get('/dashboard', function (Request $request) {
    return match ($request->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'inventory_manager' => redirect()->route('inventory_manager.dashboard'),
        'cashier' => redirect()->route('cashier.dashboard'),
        default => abort(403, 'Unauthorized.'),
    };
})->middleware(['auth'])->name('dashboard');

Route::view('/inventory-manager/dashboard', 'inventory_manager.dashboard')
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.dashboard');

Route::view('/cashier/dashboard', 'cashier.dashboard')
    ->middleware(['auth', 'role:cashier'])
    ->name('cashier.dashboard');

require __DIR__.'/settings.php';