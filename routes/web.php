<?php

use App\Http\Controllers\Shared\AuthController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\LandingController;
use Illuminate\Support\Facades\Route;

Route::get("/", [LandingController::class, 'index'])->name('landing.index');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('articles', ArticleController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});
