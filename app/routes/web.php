<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Inventory_manager\InventoryController;
use App\Http\Controllers\Inventory_manager\SupplierController;
use App\Http\Controllers\Inventory_manager\InvManagerDashboardController;
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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroyUser'])->name('admin.users.destroy');
    
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

// Inventory Manager routes
Route::get('/inventory-manager/dashboard', [InvManagerDashboardController::class, 'index'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.dashboard');

Route::get('/inventory-manager/inventory', [InventoryController::class, 'index'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.inventory'); 

Route::post('/inventory-manager/inventory', [InventoryController::class, 'store'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory.store'); 

Route::view('/inventory-manager/reports', 'inventory_manager.reports')
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.reports');

Route::view('/inventory-manager/suppliers', 'inventory_manager.suppliers')
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');

Route::get('/inventory-manager/inventory/{item}', [InventoryController::class, 'show'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory.show');

// Replaces the old static view with our new dynamic Controller
Route::get('/inventory-manager/suppliers', [SupplierController::class, 'index'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers');

// Handles the form submission
Route::post('/inventory-manager/suppliers', [SupplierController::class, 'store'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers.store');


// Cashier routes
Route::view('/cashier/dashboard', 'cashier.dashboard')
    ->middleware(['auth', 'role:cashier'])
    ->name('cashier.dashboard');

require __DIR__.'/settings.php';