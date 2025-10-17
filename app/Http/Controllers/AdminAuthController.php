<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // ログイン画面の表示
    public function showLogin()
    {
        return view('admin.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 今は簡易チェック（本来は guard('admin') を使用）
        if ($credentials['email'] === 'admin@example.com' && $credentials['password'] === 'password') {
            // 仮ログイン成功時
            return redirect()->route('admin.dashboard')->with('success', 'ログイン成功！');
        }

        // ログイン失敗
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードに誤りがあります。',
        ]);
    }

    // ログアウト処理（仮）
    public function logout()
    {
        // 本来は Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'ログアウトしました');
    }
}
