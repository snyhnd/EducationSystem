<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\TimetableController;

/* ===========================================================
 | トップページ（仮）
 * =========================================================== */
Route::get('/', fn () => 'home ok');

/* ===========================================================
 | 管理者エリア
 | Prefix: /admin
 | Route name prefix: admin.
 * =========================================================== */
Route::prefix('admin')->name('admin.')->group(function () {

    /** 🔹 /admin → ログイン画面へリダイレクト */
    Route::get('/', fn () => redirect()->route('admin.login'))->name('root');

    /** 🔹 管理者登録 */
    Route::get('/register', [AdminRegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [AdminRegisterController::class, 'store'])->name('register.store');

    /** 🔹 ログイン／ログアウト */
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    /** 🔹 ダッシュボード */
    Route::get('/dashboard', [AdminDashboardController::class, 'show'])->name('dashboard');

    /** 🔹 各管理機能（順次実装予定） */
    Route::get('/classes', fn () => '授業管理（準備中）')->name('classes.index');
    Route::get('/news',    fn () => 'お知らせ管理（準備中）')->name('news.index');

    /** ✅ バナー管理（一覧・登録・削除） */
    Route::get('/banners',  [AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [AdminBannerController::class, 'store'])->name('banners.store');
    Route::delete('/banners/{banner}', [AdminBannerController::class, 'destroy'])->name('banners.destroy');
});

/* ===========================================================
 | ユーザーエリア：時間割（Schedule）
 | Prefix: /
 | Route name prefix: user.
 * =========================================================== */
Route::get('/schedule/{year?}/{month?}/{grade?}', [TimetableController::class, 'index'])
    ->where([
        'year'  => '[0-9]{4}',       // 西暦（4桁）
        'month' => '0?[1-9]|1[0-2]', // 月（1〜12）
    ])
    ->name('user.schedule');

/** ✅ 互換ルート（旧URL /timetable にも対応する場合） */
Route::get('/timetable/{year?}/{month?}/{grade?}', [TimetableController::class, 'index'])
    ->where([
        'year'  => '[0-9]{4}',
        'month' => '0?[1-9]|1[0-2]',
    ])
    ->name('user.timetable');
Route::post('/logout', function () {
    // 将来的にユーザー認証が実装されたらここを差し替え
    session()->flush(); // セッションをクリア
    return redirect('/'); // 今はトップページに戻す
})->name('user.logout');
Route::post('/logout', function () {
    session()->flush();            // セッション全消去
    return redirect('/');          // 仮：トップへ。実装後は ->route('user.login') 等に変更
})->name('user.logout');
