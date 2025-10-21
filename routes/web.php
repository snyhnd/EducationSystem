<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\Admin\AdminTopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ユーザー用（生徒側）ルート
Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// 認証後にアクセスできるルート
Route::middleware(['auth'])->group(function () {

    // プロフィール設定
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // パスワード変更
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // 時間割
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
});


// 管理者用（admin/～）
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
});


Route::prefix('admin')->name('admin.')->group(function () {

    // 管理トップページ（授業管理）
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // お知らせ管理
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

    // バナー管理（仮の空ページ）
    Route::get('/banners', function () {
        return view('admin.banners.index');
    })->name('banners.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [AdminArticleController::class, 'update'])->name('articles.update');
});

Route::get('/top', [TopController::class, 'index'])->name('top');

Route::prefix('admin')->group(function () {
    Route::get('/top', [AdminTopController::class, 'index'])->name('admin.top');
});

Route::get('/progress/{grade}/{lesson}', [App\Http\Controllers\ProgressController::class, 'show'])
    ->name('progress.show');