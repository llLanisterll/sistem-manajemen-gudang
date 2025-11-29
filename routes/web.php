<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RestockOrderController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard Umum (Handle redirect dashboard untuk semua role)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ROUTE BERDASARKAN ROLE ---

// 1. Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen User (Approval Supplier)
    Route::get('/users', [DashboardController::class, 'usersIndex'])->name('users.index');
    Route::patch('/users/{id}/approve', [DashboardController::class, 'approveUser'])->name('users.approve');

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Produk & QR Code
    Route::resource('products', ProductController::class);
    Route::get('/products/{id}/print-barcode', [ProductController::class, 'printBarcode'])->name('products.printBarcode');

    // Export Laporan Transaksi
    Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
});

// 2. Manager Routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi Gudang
    // PENTING: Route Export harus ditaruh SEBELUM route show/{id} agar tidak error 404
    Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');

    // Restock Order & Rating
    Route::resource('restock', RestockOrderController::class);
    Route::patch('/restock/{restockOrder}/status', [RestockOrderController::class, 'updateStatus'])->name('restock.updateStatus');
    Route::post('/restock/{id}/rate', [RestockOrderController::class, 'rate'])->name('restock.rate');
});

// 3. Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff bisa buat & lihat transaksi
    Route::resource('transactions', TransactionController::class);
});

// 4. Supplier Routes
Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Supplier restock routes
    Route::get('/restock', [RestockOrderController::class, 'index'])->name('restock.index');
    Route::get('/restock/{restockOrder}', [RestockOrderController::class, 'show'])->name('restock.show');
    Route::patch('/restock/{restockOrder}/status', [RestockOrderController::class, 'updateStatus'])->name('restock.updateStatus');
});

require __DIR__.'/auth.php';
