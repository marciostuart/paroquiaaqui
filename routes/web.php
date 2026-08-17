<?php

use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TenantDomainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'show'])->name('site.home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('admin.dashboard');
    Route::get('/dominios', [TenantDomainController::class, 'index'])->name('admin.domains.index');
    Route::post('/dominios', [TenantDomainController::class, 'store'])->name('admin.domains.store');
    Route::post('/dominios/{domain}/verificar', [TenantDomainController::class, 'verify'])->name('admin.domains.verify');
});

// Compatibilidade com o portal PHP atual: /{slug} continua abrindo o tenant.
Route::get('/{tenant}', [PublicSiteController::class, 'show'])->where('tenant', '[a-z0-9-]+')->name('site.home.slug');
