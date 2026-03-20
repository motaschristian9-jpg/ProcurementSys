<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Materials Management
    Route::get('/materials/compare', [MaterialController::class, 'compare'])->name('materials.compare');
    Route::get('/materials/template', [MaterialController::class, 'downloadTemplate'])->name('materials.template');
    Route::post('/materials/import', [MaterialController::class, 'import'])->name('materials.import');
    Route::post('/materials/bulk-delete', [MaterialController::class, 'bulkDelete'])->name('materials.bulk-delete');
    Route::resource('materials', MaterialController::class);
    
    // Categories Hub
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
});
