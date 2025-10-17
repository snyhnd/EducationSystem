cat > routes/web.php <<'PHP'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminRegisterController;

// ✅ トップページ（確認用）
Route::get('/', function () {
    return 'home ok';
});

// ✅ 管理ユーザー用ルート
Route::prefix('admin')->name('admin.')->group(function () {
    // --- 新規登録 ---
    Route::get('/register', [AdminRegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [AdminRegisterController::class, 'store'])->name('register.store');

    // --- ログイン ---
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // --- 仮ダッシュボード（ログイン後の確認用） ---
    Route::get('/dashboard', fn () => 'admin dashboard')->name('dashboard');
});
