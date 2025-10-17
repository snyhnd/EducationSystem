<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', fn () => 'home ok');

Route::prefix('admin')->name('admin.')->group(function () {
    // 新規登録
    Route::get('/register', [AdminRegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [AdminRegisterController::class, 'store'])->name('register.store');

    // ログイン/ログアウト
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // ダッシュボード（ここをコントローラに）
    Route::get('/dashboard', [AdminDashboardController::class, 'show'])->name('dashboard');

    // まだ未実装の遷移先（プレースホルダ）
    Route::get('/classes', fn () => '授業管理（準備中）')->name('classes.index');
    Route::get('/news',    fn () => 'お知らせ管理（準備中）')->name('news.index');
    Route::get('/banners', fn () => 'バナー管理（準備中）')->name('banners.index');
});
