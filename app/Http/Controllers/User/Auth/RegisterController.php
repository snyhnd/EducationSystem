<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション（フォームのname属性に合わせて 'kana' を使用）
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kana' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'ユーザー名は必須です。',
            'kana.required' => 'カナは必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは6文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ]);

        // ユーザー作成（DBのカラム名に合わせて name_kana にマッピング）
        $user = User::create([
            'name' => $validated['name'],
            'name_kana' => $validated['kana'], // ← ここがポイント！
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'profile_image' => null,
        ]);

        // ログインしてトップへリダイレクト
        Auth::login($user);
        return redirect()->route('user_dashboard');
    }
}
