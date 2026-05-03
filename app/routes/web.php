<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Inventory_manager\InventoryController;
use App\Http\Controllers\Inventory_manager\SupplierController;
use App\Http\Controllers\Inventory_manager\InvManagerDashboardController;
use App\Http\Controllers\Inventory_manager\ReportController;
use App\Http\Controllers\Inventory_manager\ChartDataController;
use Illuminate\Http\Request;
use App\Http\Controllers\Inventory_manager\DeliveryController;
use App\Livewire\ReceiptViewer;
use App\Http\Controllers\Auth\PasswordResetLinkController;

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

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

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

Route::get('/inventory-manager/inventory/export', [InventoryController::class, 'export'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.inventory.export');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');


Route::get('/inventory-manager/inventory/{item}', [InventoryController::class, 'show'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory.show');

Route::get('/inventory-manager/suppliers', [SupplierController::class, 'index'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers');

Route::post('/inventory-manager/suppliers', [SupplierController::class, 'store'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers.store');

Route::get('/inventory-manager/suppliers/export', [SupplierController::class, 'export'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers.export');

Route::get('/inventory-manager/suppliers/{supplier}', [SupplierController::class, 'show'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.suppliers.show');

Route::get('/inventory-manager/reports', [ReportController::class, 'index'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.reports');

Route::get('/inventory-manager/deliveries', [DeliveryController::class, 'index'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.deliveries');

Route::get('/inventory-manager/deliveries/{logId}', [DeliveryController::class, 'show'])
    ->middleware(['auth', 'role:inventory_manager'])
    ->name('inventory_manager.deliveries.show');
//notif
Route::post('/admin/reset-approvals/{approval}/approve', [AdminDashboardController::class, 'approveReset'])->name('admin.resets.approve');
Route::post('/admin/reset-approvals/{approval}/reject', [AdminDashboardController::class, 'rejectReset'])->name('admin.resets.reject');

// Cashier routes
Route::view('/cashier/dashboard', 'cashier.dashboard')
    ->middleware(['auth', 'role:cashier'])
    ->name('cashier.dashboard');

Route::get('/transactions', function () {
    return view('cashier.transactions');
})->name('transactions.index');

//Charts Data
Route::get('/inventory/chart/weekly', [ChartDataController::class, 'getWeeklyData'])
    ->middleware('auth');

require __DIR__.'/settings.php';