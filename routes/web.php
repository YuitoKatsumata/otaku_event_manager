<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 認証が必要なルート
Route::middleware('auth')->group(function () {
    // ホーム画面（ログイン後のダッシュボード）
    Route::get('/home', function() {
        return view('home');
    })->name('home');

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// 未認証ユーザー向けのルート
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
