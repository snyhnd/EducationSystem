<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;  // ←★ これを必ず追加！

class AdminRegisterController extends Controller
{
    /** 管理ユーザー登録フォーム表示 */
    public function create()
    {
        return view('admin.register');
    }

    /** 登録処理 */
    public function store(Request $request)
    {
        $v = $request->validate([
            'username' => 'required|string|max:255',
            'kana'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'ユーザー名を入力してください',
            'kana.required'     => 'カナを入力してください',
            'email.required'    => 'メールアドレスを入力してください',
            'email.email'       => 'メールアドレスの形式が正しくありません',
            'email.unique'      => 'このメールアドレスは既に登録されています',
            'password.required' => 'パスワードを入力してください',
            'password.min'      => 'パスワードは8文字以上で入力してください',
            'password.confirmed'=> 'パスワード確認が一致しません',
        ]);

        // ✅ モデル経由で保存
        Admin::create([
            'username' => $v['username'],
            'kana'     => $v['kana'],
            'email'    => $v['email'],
            'password' => Hash::make($v['password']), // ←ハッシュ化必須
        ]);

        return redirect()->route('admin.login')->with('success', '登録が完了しました！ログインしてください。');
    }
}
