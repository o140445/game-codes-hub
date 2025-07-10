<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Static pages - these must come before the {slug} route to avoid conflicts
Route::get('/about', function () {
    return view('common.about');
})->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/privacy-policy', function () {
    return view('common.privacyPolicy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('common.termsOfService');
})->name('terms-of-service');

// Games routes
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/{slug}', [GameController::class, 'show'])->name('games.show');

