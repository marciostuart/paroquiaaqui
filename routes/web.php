<?php

use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'show'])->name('site.home');

// Compatibilidade com o portal PHP atual: /{slug} continua abrindo o tenant.
Route::get('/{tenant}', [PublicSiteController::class, 'show'])
    ->where('tenant', '[a-z0-9-]+')
    ->name('site.home.slug');
