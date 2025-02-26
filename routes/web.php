<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ShortUrlController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    // Admin task route
    Route::name('admin.')->prefix('admin/')->group(function () {

        Route::post('/shorten', [ShortUrlController::class, 'store'])->name('shorten');
       
        Route::get('/analytics', [AnalyticsController::class, 'analytics'])->name('analytics');
        Route::get('/analytics/details/{id}', [AnalyticsController::class, 'details'])->name('details');
    });

});

require __DIR__.'/auth.php';

Route::get('/{code}', [ShortUrlController::class, 'redirect']);
