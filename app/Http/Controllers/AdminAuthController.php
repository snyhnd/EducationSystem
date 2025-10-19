<?php

namespace App\Http\Controllers;

use App\Models\Admin;                 // adminsテーブルのモデル
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  // パスワード照合

class AdminAuthController extends Controller
{
    /** ログイン画面表示 */
    public function showLogin()
    {
        return view('admin.login');
    }

    /** ログイン処理（DB参照） */
    public function login(Request $request)
    {
        // ▼ バリデーション
        $cred = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required'    => 'メールアドレスを入力してください',
                'email.email'       => 'メールアドレスの形式が正しくありません',
                'password.required' => 'パスワードを入力してください',
            ]
        );

        // ▼ メールアドレスで管理ユーザー取得
        $admin = Admin::where('email', $cred['email'])->first();

        // ▼ 該当なし or パスワード不一致
        if (!$admin || !Hash::check($cred['password'], $admin->password)) {
            return back()
                ->withErrors(['login' => 'メールアドレスまたはパスワードに誤りがあります'])
                ->withInput();
        }

        // ▼ ログイン成功：必要情報をセッションへ保存
        session([
            'admin_id'    => $admin->id,
            'admin_name'  => $admin->username,
            'admin_email' => $admin->email,
        ]);

        // ▼ ダッシュボードへ
        return redirect()->route('admin.dashboard')->with('success', 'ログインしました');
    }

    /** ログアウト処理 */
    public function logout(Request $request)
    {
        // ▼ セッション破棄
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ▼ 管理ログイン画面へ戻る
        return redirect()->route('admin.login')->with('success', 'ログアウトしました');
    }
}
