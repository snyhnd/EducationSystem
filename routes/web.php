<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\TopController;
use App\Http\Controllers\User\CurriculumController;
use App\Http\Controllers\User\DeliveryController;
use App\Http\Controllers\User\ProgressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 初期トップページ（未ログイン時）
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TopController::class, 'index'])->name('welcome');


// 会員登録画面（GET）
Route::get('/register', function () {
    return view('user.auth.register');
})->name('user.register');

// 会員登録処理（POST）
Route::post('/register', [RegisterController::class, 'store'])->name('user_register');

// ログイン画面（GET）
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('user_login');

// ログイン処理（POST）
Route::post('/login', [LoginController::class, 'login'])->name('user_login_post');

Route::post('/curriculum/clear/{id}', [ProgressController::class, 'store'])->name('curriculum.clear');


// ログイン後のトップ画面（時間割・進捗・お知らせなど）
Route::get('/top', [TopController::class, 'index'])
    ->middleware('auth')
    ->name('user_dashboard');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/schedule', [CurriculumController::class, 'index'])->name('schedule');

Route::get('/schedule/partial', [CurriculumController::class, 'partial'])->name('schedule.partial');

Route::get('/lesson/delivery/{id}', [DeliveryController::class, 'show'])->name('lesson.delivery');

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/lesson/{id}', [CurriculumController::class, 'delivery'])->name('curriculum.delivery');



// PHP情報確認用（開発用）
Route::get('/phpinfo', function () {
    phpinfo();
});
