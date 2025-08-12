<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Financial management routes
    Route::get('/financial', [App\Http\Controllers\FinancialDashboardController::class, 'index'])
        ->name('financial.dashboard');
    Route::post('/financial', [App\Http\Controllers\FinancialDashboardController::class, 'store'])
        ->name('financial.dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
