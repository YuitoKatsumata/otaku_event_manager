<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Home\HomeController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 認証が必要なルート
Route::middleware('auth')->group(function () {
    // ホーム画面（ログイン後のダッシュボード）
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/event', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::get('event/edit/{id}', [EventController::class, 'edit'])->name('event.edit');
    Route::put('event/{id}', [EventController::class, 'update'])->name('event.update');
});

// 未認証ユーザー向けのルート
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
