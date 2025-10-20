<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminRequestController;

// Página de bienvenida
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Dashboard de usuario normal
Route::get('dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para usuario normal
Route::middleware(['auth'])->group(function () {
    Route::get('/requests', [RequestController::class, 'index']);
    Route::post('/requests', [RequestController::class, 'store']);
    Route::put('/requests/{id}', [RequestController::class, 'update']);
    Route::delete('/requests/{id}', [RequestController::class, 'destroy']);
});

// Rutas para admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('admin/DashboardAdmin'))->name('admin.dashboard');
    Route::get('/requests', [AdminRequestController::class, 'index'])->name('admin.requests');
    Route::put('/requests/{id}', [AdminRequestController::class, 'updateStatus'])->name('admin.requests.updateStatus');
});

require __DIR__.'/settings.php';
